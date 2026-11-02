<?php

namespace Database\Seeders;

use App\Models\Poli;
use Illuminate\Database\Seeder;

class PoliSeeder extends Seeder
{
    public function run(): void
    {
        $polis = [
            [
                'nama_poli' => 'Poli Umum',
                'keterangan' => 'Pelayanan pemeriksaan dan pengobatan umum.',
            ],
            [
                'nama_poli' => 'Poli Gigi',
                'keterangan' => 'Pelayanan kesehatan gigi dan mulut.',
            ],
            [
                'nama_poli' => 'Poli Anak',
                'keterangan' => 'Pelayanan kesehatan khusus anak.',
            ],
            [
                'nama_poli' => 'Poli Penyakit Dalam',
                'keterangan' => 'Pelayanan penyakit dalam dan konsultasi lanjutan.',
            ],
        ];

        foreach ($polis as $poli) {
            Poli::updateOrCreate(['nama_poli' => $poli['nama_poli']], $poli);
        }
    }
}
