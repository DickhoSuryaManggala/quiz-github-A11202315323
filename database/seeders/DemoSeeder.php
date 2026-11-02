<?php

namespace Database\Seeders;

use App\Models\DaftarPoli;
use App\Models\DetailPeriksa;
use App\Models\JadwalPeriksa;
use App\Models\Obat;
use App\Models\Periksa;
use App\Models\User;
use Illuminate\Database\Seeder;

class DemoSeeder extends Seeder
{
    public function run(): void
    {
        $dokter = User::where('role', 'dokter')->where('nama', 'dr. Andi Pratama')->first();
        $jadwal = null;

        if ($dokter) {
            $namaHariIni = now()->locale('id')->dayName;

            $jadwal = JadwalPeriksa::where('id_dokter', $dokter->id)
                ->where('hari', $namaHariIni)
                ->first()
                ?? JadwalPeriksa::where('id_dokter', $dokter->id)
                    ->orderBy('hari')
                    ->first();
        }

        if (! $dokter || ! $jadwal) {
            return;
        }

        $pasien = User::where('role', 'pasien')
            ->whereIn('nama', ['Budi Santoso', 'Siti Aminah', 'Rina Marlina', 'Agus Setiawan'])
            ->get()
            ->keyBy('nama');

        $buatPendaftaran = function (string $namaPasien, int $noAntrian, string $keluhan, $tanggal) use ($pasien, $jadwal) {
            $dataPasien = $pasien->get($namaPasien);

            if (! $dataPasien) {
                return null;
            }

            $daftar = DaftarPoli::where('id_pasien', $dataPasien->id)
                ->where('id_jadwal', $jadwal->id)
                ->whereDate('created_at', $tanggal)
                ->first();

            if ($daftar) {
                return $daftar;
            }

            $daftar = new DaftarPoli([
                'id_pasien' => $dataPasien->id,
                'id_jadwal' => $jadwal->id,
                'keluhan' => $keluhan,
                'no_antrian' => $noAntrian,
            ]);
            $daftar->created_at = $tanggal;
            $daftar->updated_at = $tanggal;
            $daftar->save();

            return $daftar;
        };

        $buatPeriksa = function (DaftarPoli $daftar, string $catatan, array $namaObat, $tanggal) {
            if ($daftar->periksa) {
                return;
            }

            $obats = Obat::whereIn('nama_obat', $namaObat)->get();
            $periksa = Periksa::create([
                'id_daftar_poli' => $daftar->id,
                'tgl_periksa' => $tanggal,
                'catatan' => $catatan,
                'biaya_periksa' => 150000 + $obats->sum('harga'),
            ]);

            foreach ($obats as $obat) {
                DetailPeriksa::create([
                    'id_periksa' => $periksa->id,
                    'id_obat' => $obat->id,
                ]);
            }
        };

        $hariIni = now();
        $kemarin = now()->subDay();
        $tigaHariLalu = now()->subDays(3);

        $budiHariIni = $buatPendaftaran('Budi Santoso', 1, 'Demam dan batuk sejak dua hari terakhir.', $hariIni);
        $sitiHariIni = $buatPendaftaran('Siti Aminah', 2, 'Nyeri ulu hati dan mual setelah makan.', $hariIni);
        $rinaHariIni = $buatPendaftaran('Rina Marlina', 3, 'Sakit kepala dan badan terasa lemas.', $hariIni);

        if ($sitiHariIni) {
            $buatPeriksa(
                $sitiHariIni,
                'Gastritis akut. Diberikan antasida dan anjuran makan dalam porsi kecil tetapi sering.',
                ['Antasida', 'Paracetamol'],
                $hariIni
            );
        }

        $budiKemarin = $buatPendaftaran('Budi Santoso', 1, 'Batuk berdahak dan tenggorokan gatal.', $kemarin);

        if ($budiKemarin) {
            $buatPeriksa(
                $budiKemarin,
                'Infeksi saluran pernapasan atas. Istirahat cukup dan minum air hangat.',
                ['Paracetamol', 'Amoxicillin'],
                $kemarin
            );
        }

        $agusTigaHariLalu = $buatPendaftaran('Agus Setiawan', 1, 'Pusing dan mudah lelah saat beraktivitas.', $tigaHariLalu);

        if ($agusTigaHariLalu) {
            $buatPeriksa(
                $agusTigaHariLalu,
                'Kelelahan dan kurang istirahat. Disarankan memperbaiki pola tidur.',
                ['Vitamin C'],
                $tigaHariLalu
            );
        }
    }
}
