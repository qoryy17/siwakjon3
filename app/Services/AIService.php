<?php

namespace App\Services;

use Gemini\Laravel\Facades\Gemini;

class AIService
{
    public function getResponseAI($model, $prompt)
    {
        $response = Gemini::generativeModel($model)->generateContent($prompt);
        $response = $response->text();
        return $response;
    }
}
