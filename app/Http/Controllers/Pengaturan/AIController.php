<?php

namespace App\Http\Controllers\Pengaturan;

use App\Helpers\RouteLink;
use App\Services\AIService;
use Illuminate\Http\Request;
use Illuminate\Cache\RateLimiter;
use App\Models\Pengaturan\AIModel;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Crypt;
use App\Http\Requests\Pengaturan\AIModelRequest;

class AIController extends Controller
{
    public function index()
    {
        // Redirect home page for role
        $route = RouteLink::homePage(Auth::user()->roles);

        $breadcumb = [
            ['title' => 'Home', 'link' => $route, 'page' => ''],
            ['title' => 'Manajemen Pengaturan', 'link' => 'javascript:void(0);', 'page' => ''],
            ['title' => 'Set Rapat Dinas ', 'link' => route('rapat.set-rapat'), 'page' => 'aria-current="page"']
        ];
        $data = [
            'title' => 'Manajemen Pengaturan | Set Rapat Dinas',
            'routeHome' => $route,
            'breadcumbs' => $breadcumb,
            'aiConfig' => AIModel::first()
        ];

        return view('pengaturan.form-ai-config', $data);
    }

    public function saveAIModel(AIModelRequest $request): RedirectResponse
    {
        // Run validated
        $request->validated();
        $aiConfig = AIModel::first();

        $save = null;

        $formData = [
            'ai_model' => $request->input('aiModel'),
            'prompt_catatan_rapat' => $request->input('promptCatatanRapat'),
            'prompt_kesimpulan_rapat' => $request->input('promptKesimpulanRapat'),
        ];

        if ($aiConfig) {
            $save = $aiConfig->update($formData);
        } else {
            $save = AIModel::create($formData);
        }
        if (!$save) {
            return redirect()->back()->with('error', 'Pengaturan AI Model gagal disimpan !')->withInput();
        }
        // Redirect to AI Model page with success message
        return redirect()->route('aplikasi.ai-model')->with('success', 'Pengaturan AI Model berhasil disimpan !');
    }

    public function generateResponse(Request $request, AIService $aiService)
    {
        try {
            // Rate limiter for users
            $ipAddress = $request->ip();
            $rateLimiter = app(RateLimiter::class);
            $key = 'ai-response-attempts:' . $ipAddress;

            if ($rateLimiter->tooManyAttempts($key, 15)) {
                return response()->json(['response' => 'Terlalu banyak percobaan, silakan tunggu 1 menit !'], 429);
            }

            $type = $request->type;

            if (!$type) {
                return response()->json(['response' => 'Parameter tidak valid !']);
            }

            $configAI = AIModel::firstOrFail();

            $prompts = [
                'catatanRapat' => $configAI->prompt_catatan_rapat,
                'kesimpulanRapat' => $configAI->prompt_kesimpulan_rapat,
            ];

            if (!isset($prompts[$type])) {
                return response()->json(['response' => 'Permintaan tipe tidak valid !']);
            }

            $prompt = $prompts[$type] . $request->content;

            if (trim($prompt) === '') {
                return response()->json(['response' => 'Prompt tidak boleh kosong !']);
            }

            $response = $aiService->getResponseAI($configAI->ai_model, $prompt);

            return response()->json(['response' => $response]);
        } catch (\Exception $e) {
            return response()->json(['response' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }
}
