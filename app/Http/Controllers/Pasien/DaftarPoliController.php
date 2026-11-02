<?php

namespace App\Http\Controllers\Pasien;

use App\Http\Controllers\Controller;
use App\Models\DaftarPoli;
use App\Models\JadwalPeriksa;
use App\Models\Poli;
use Illuminate\Http\Request;

class DaftarPoliController extends Controller
{
    public function index()
    {
        $polis = Poli::with('dokters')->orderBy('nama_poli')->get();
        $jadwals = JadwalPeriksa::with(['dokter.poli'])
            ->whereHas('dokter', function ($query) {
                $query->where('role', 'dokter');
            })
            ->orderBy('hari')
            ->orderBy('jam_mulai')
            ->get();

        $pendaftarans = DaftarPoli::with(['jadwalPeriksa.dokter.poli', 'periksa'])
            ->where('id_pasien', auth()->id())
            ->latest()
            ->get();

        return view('pasien.daftar', compact('polis', 'jadwals', 'pendaftarans'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_jadwal' => ['required', 'exists:jadwal_periksa,id'],
            'keluhan' => ['required', 'string', 'max:1000'],
        ]);

        $jadwal = JadwalPeriksa::findOrFail($validated['id_jadwal']);

        $sudahDaftar = DaftarPoli::where('id_pasien', auth()->id())
            ->where('id_jadwal', $jadwal->id)
            ->whereDate('created_at', today())
            ->exists();

        if ($sudahDaftar) {
            return back()
                ->withInput()
                ->with('error', 'Anda sudah terdaftar pada jadwal ini hari ini.');
        }

        $noAntrian = (int) DaftarPoli::where('id_jadwal', $jadwal->id)
            ->whereDate('created_at', today())
            ->max('no_antrian') + 1;

        DaftarPoli::create([
            'id_pasien' => auth()->id(),
            'id_jadwal' => $jadwal->id,
            'keluhan' => $validated['keluhan'],
            'no_antrian' => $noAntrian,
        ]);

        return redirect()
            ->route('pasien.daftar')
            ->with('success', 'Pendaftaran berhasil. Nomor antrian Anda: ' . $noAntrian . '.');
    }
}
