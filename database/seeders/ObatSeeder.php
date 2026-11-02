<?php

namespace Database\Seeders;

use App\Models\Obat;
use Illuminate\Database\Seeder;

class ObatSeeder extends Seeder
{
    public function run(): void
    {
        $obats = [
            ['nama_obat' => 'Paracetamol', 'kemasan' => 'Strip 500 mg', 'harga' => 5000],
            ['nama_obat' => 'Amoxicillin', 'kemasan' => 'Strip 500 mg', 'harga' => 12000],
            ['nama_obat' => 'Antasida', 'kemasan' => 'Strip 500 mg', 'harga' => 7000],
            ['nama_obat' => 'Cetirizine', 'kemasan' => 'Strip 10 mg', 'harga' => 9000],
            ['nama_obat' => 'Ibuprofen', 'kemasan' => 'Strip 400 mg', 'harga' => 8000],
            ['nama_obat' => 'Vitamin C', 'kemasan' => 'Botol 30 tablet', 'harga' => 15000],
        ];

        foreach ($obats as $obat) {
            Obat::updateOrCreate(['nama_obat' => $obat['nama_obat']], $obat);
        }
    }
}
