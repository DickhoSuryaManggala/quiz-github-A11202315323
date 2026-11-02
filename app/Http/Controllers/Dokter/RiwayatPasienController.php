<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use App\Models\Periksa;

class RiwayatPasienController extends Controller
{
    public function index()
    {
        $riwayats = Periksa::with([
            'daftarPoli.pasien',
            'daftarPoli.jadwalPeriksa.dokter.poli',
            'detailPeriksas.obat',
        ])
            ->whereHas('daftarPoli.jadwalPeriksa', function ($query) {
                $query->where('id_dokter', auth()->id());
            })
            ->latest('tgl_periksa')
            ->get();

        return view('dokter.riwayat.index', compact('riwayats'));
    }

    public function show(Periksa $periksa)
    {
        $periksa->load([
            'daftarPoli.pasien',
            'daftarPoli.jadwalPeriksa.dokter.poli',
            'detailPeriksas.obat',
        ]);

        abort_unless(
            $periksa->daftarPoli &&
            $periksa->daftarPoli->jadwalPeriksa &&
            (int) $periksa->daftarPoli->jadwalPeriksa->id_dokter === (int) auth()->id(),
            403,
            'Anda tidak berhak melihat riwayat pasien ini.'
        );

        return view('dokter.riwayat.show', compact('periksa'));
    }
}
