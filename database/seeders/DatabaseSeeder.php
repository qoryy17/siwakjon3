<?php

namespace Database\Seeders;

use App\Enum\RolesEnum;
use App\Models\Manajemen\KlasifikasiRapatModel;
use App\Models\Pengaturan\AplikasiModel;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        User::insert([
            'name' => 'Qori Chairawan, S.Kom., CITM',
            'email' => 'test@siwakjon.local',
            'email_verified_at' => now(),
            'password' => Hash::make('siwakjon'),
            'remember_token' => Str::random(10),
            'active' => '1',
            'roles' => RolesEnum::SUPERADMIN->value,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        KlasifikasiRapatModel::insert([
            [
                'rapat' => 'Bulanan',
                'kode_klasifikasi' => 'BLN',
                'aktif' => 'Y',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'rapat' => 'Berjenjang',
                'kode_klasifikasi' => 'BNJ',
                'aktif' => 'Y',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'rapat' => 'Lainnya',
                'kode_klasifikasi' => 'LN',
                'aktif' => 'Y',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'rapat' => 'Pengawasan',
                'kode_klasifikasi' => 'PW',
                'aktif' => 'Y',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);

        AplikasiModel::insert([
            'lembaga' => 'Mahkamah Agung Republik Indonesia',
            'badan_peradilan' => 'Direktorat Jenderal Badan Peradilan Umum',
            'wilayah_hukum' => 'Pengadilan Tinggi Medan',
            'kode_satker' => '400395',
            'satuan_kerja' => 'Pengadilan Negeri Lubuk Pakam',
            'alamat' => 'Jalan Jenderal Sudirman No. 58 Lubuk Pakam',
            'provinsi' => 'Sumatera Utara',
            'kota' => 'Kabupaten Deli Serdang',
            'kode_pos' => '20512',
            'telepon' => '000',
            'email' => 'pnlubukpakam@yahoo.co.id',
            'website' => 'www.pn-lubukpakam.go.id',
            'license' => '-',
            'logo' => '-',
        ]);
    }
}
