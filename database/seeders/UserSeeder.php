<?php

namespace Database\Seeders;

use App\Models\Poli;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $poliUmum = Poli::where('nama_poli', 'Poli Umum')->first();
        $poliGigi = Poli::where('nama_poli', 'Poli Gigi')->first();
        $poliAnak = Poli::where('nama_poli', 'Poli Anak')->first();

        $prefixNoRm = now()->format('Ym');
        $domainEmail = 'poliklinik.test';

        $users = [
            [
                'nama' => 'Administrator',
                'email' => 'admin@gmail.com',
                'password' => 'admin',
                'role' => 'admin',
            ],
            [
                'nama' => 'dr. Andi Pratama',
                'email' => 'dokter@gmail.com',
                'password' => 'dokter',
                'role' => 'dokter',
                'poli' => $poliUmum,
            ],
            [
                'nama' => 'Budi Santoso',
                'email' => 'pasien@gmail.com',
                'password' => 'pasien',
                'role' => 'pasien',
            ],
            [
                'nama' => 'drg. Sari Wulandari',
                'email' => 'sari' . '@' . $domainEmail,
                'password' => 'dokter',
                'role' => 'dokter',
                'poli' => $poliGigi,
            ],
            [
                'nama' => 'dr. Maya Lestari',
                'email' => 'maya' . '@' . $domainEmail,
                'password' => 'dokter',
                'role' => 'dokter',
                'poli' => $poliAnak,
            ],
            [
                'nama' => 'Siti Aminah',
                'email' => 'siti' . '@' . $domainEmail,
                'password' => 'pasien',
                'role' => 'pasien',
            ],
            [
                'nama' => 'Rina Marlina',
                'email' => 'rina' . '@' . $domainEmail,
                'password' => 'pasien',
                'role' => 'pasien',
            ],
            [
                'nama' => 'Agus Setiawan',
                'email' => 'agus' . '@' . $domainEmail,
                'password' => 'pasien',
                'role' => 'pasien',
            ],
        ];

        foreach ($users as $index => $user) {
            $nomor = $index + 1;

            User::updateOrCreate(
                ['email' => $user['email']],
                [
                    'nama' => $user['nama'],
                    'email' => $user['email'],
                    'password' => Hash::make($user['password']),
                    'role' => $user['role'],
                    'id_poli' => ($user['poli'] ?? null)?->id,
                    'no_rm' => $user['role'] === 'pasien'
                        ? $prefixNoRm . '-' . str_pad((string) $nomor, 3, '0', STR_PAD_LEFT)
                        : null,
                    'alamat' => 'Jl. Kesehatan No. ' . $nomor . ', Semarang',
                    'no_ktp' => str_pad((string) $nomor, 16, '0', STR_PAD_LEFT),
                    'no_hp' => '0812' . str_pad((string) (10000000 + $nomor), 8, '0', STR_PAD_LEFT),
                ]
            );
        }
    }
}
