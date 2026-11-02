<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use App\Models\DaftarPoli;
use App\Models\DetailPeriksa;
use App\Models\Obat;
use App\Models\Periksa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PeriksaPasienController extends Controller
{
    private const BIAYA_JASA_DOKTER = 150000;

    public function index()
    {
        $daftarPolis = DaftarPoli::with(['pasien', 'jadwalPeriksa.dokter.poli', 'periksa'])
            ->whereHas('jadwalPeriksa', function ($query) {
                $query->where('id_dokter', auth()->id());
            })
            ->whereDate('created_at', today())
            ->orderBy('no_antrian')
            ->get();

        $jumlahMenunggu = $daftarPolis->filter(fn ($item) => $item->periksa === null)->count();
        $jumlahSelesai = $daftarPolis->filter(fn ($item) => $item->periksa !== null)->count();

        return view('dokter.periksa.index', compact('daftarPolis', 'jumlahMenunggu', 'jumlahSelesai'));
    }

    public function create(DaftarPoli $daftarPoli)
    {
        $this->pastikanMilikDokter($daftarPoli);

        if ($daftarPoli->periksa) {
            return redirect()
                ->route('periksa-pasien.index')
                ->with('error', 'Pasien ini sudah diperiksa.');
        }

        $obats = Obat::orderBy('nama_obat')->get();

        return view('dokter.periksa.create', [
            'daftarPoli' => $daftarPoli->load(['pasien', 'jadwalPeriksa.dokter.poli']),
            'obats' => $obats,
            'biayaJasaDokter' => self::BIAYA_JASA_DOKTER,
        ]);
    }

    public function store(Request $request, DaftarPoli $daftarPoli)
    {
        $this->pastikanMilikDokter($daftarPoli);

        if ($daftarPoli->periksa) {
            return redirect()
                ->route('periksa-pasien.index')
                ->with('error', 'Pasien ini sudah diperiksa.');
        }

        $validated = $request->validate([
            'catatan' => ['nullable', 'string', 'max:1000'],
            'obat' => ['nullable', 'array'],
            'obat.*' => ['integer', 'exists:obat,id'],
        ]);

        $obats = Obat::whereIn('id', $validated['obat'] ?? [])->get();
        $biayaPeriksa = self::BIAYA_JASA_DOKTER + $obats->sum('harga');

        DB::transaction(function () use ($daftarPoli, $validated, $obats, $biayaPeriksa) {
            $periksa = Periksa::create([
                'id_daftar_poli' => $daftarPoli->id,
                'tgl_periksa' => now(),
                'catatan' => $validated['catatan'] ?? null,
                'biaya_periksa' => $biayaPeriksa,
            ]);

            foreach ($obats as $obat) {
                DetailPeriksa::create([
                    'id_periksa' => $periksa->id,
                    'id_obat' => $obat->id,
                ]);
            }
        });

        return redirect()
            ->route('periksa-pasien.index')
            ->with('success', 'Pemeriksaan pasien berhasil disimpan.');
    }

    private function pastikanMilikDokter(DaftarPoli $daftarPoli): void
    {
        abort_unless(
            $daftarPoli->jadwalPeriksa &&
            (int) $daftarPoli->jadwalPeriksa->id_dokter === (int) auth()->id(),
            403,
            'Anda tidak berhak memeriksa pasien ini.'
        );
    }
}
