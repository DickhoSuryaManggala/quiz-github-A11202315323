<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use App\Models\JadwalPeriksa;

class JadwalPeriksaController extends Controller
{
    public function index()
    {
        $urutanHari = [
            'Senin' => 1,
            'Selasa' => 2,
            'Rabu' => 3,
            'Kamis' => 4,
            'Jumat' => 5,
            'Sabtu' => 6,
            'Minggu' => 7,
        ];

        $jadwals = JadwalPeriksa::with('dokter')
            ->where('id_dokter', auth()->id())
            ->get()
            ->sortBy(fn ($jadwal) => $urutanHari[$jadwal->hari] ?? 99)
            ->values();

        return view('dokter.jadwal.index', compact('jadwals'));
    }
}
