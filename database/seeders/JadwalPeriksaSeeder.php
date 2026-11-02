<?php

namespace Database\Seeders;

use App\Models\JadwalPeriksa;
use App\Models\User;
use Illuminate\Database\Seeder;

class JadwalPeriksaSeeder extends Seeder
{
    public function run(): void
    {
        $jadwals = [
            'Poli Umum' => [
                ['hari' => 'Senin', 'jam_mulai' => '08:00', 'jam_selesai' => '12:00'],
                ['hari' => 'Rabu', 'jam_mulai' => '08:00', 'jam_selesai' => '12:00'],
                ['hari' => 'Jumat', 'jam_mulai' => '13:00', 'jam_selesai' => '16:00'],
            ],
            'Poli Gigi' => [
                ['hari' => 'Selasa', 'jam_mulai' => '09:00', 'jam_selesai' => '13:00'],
                ['hari' => 'Kamis', 'jam_mulai' => '09:00', 'jam_selesai' => '13:00'],
            ],
            'Poli Anak' => [
                ['hari' => 'Senin', 'jam_mulai' => '13:00', 'jam_selesai' => '16:00'],
                ['hari' => 'Kamis', 'jam_mulai' => '08:00', 'jam_selesai' => '11:00'],
            ],
        ];

        foreach ($jadwals as $namaPoli => $items) {
            $dokter = User::where('role', 'dokter')
                ->whereHas('poli', function ($query) use ($namaPoli) {
                    $query->where('nama_poli', $namaPoli);
                })
                ->first();

            if (! $dokter) {
                continue;
            }

            foreach ($items as $item) {
                JadwalPeriksa::updateOrCreate(
                    [
                        'id_dokter' => $dokter->id,
                        'hari' => $item['hari'],
                    ],
                    [
                        'jam_mulai' => $item['jam_mulai'],
                        'jam_selesai' => $item['jam_selesai'],
                    ]
                );
            }
        }
    }
}
