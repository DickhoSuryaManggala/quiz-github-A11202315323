<x-layouts.app title="Detail Riwayat Pasien">
    <div class="mx-auto flex max-w-5xl flex-col gap-6">

        <div class="flex items-center gap-3">
            <a href="{{ route('riwayat-pasien.index') }}"
                class="btn btn-square border border-slate-200 bg-white text-slate-600 hover:bg-slate-100">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div>
                <h2 class="text-2xl font-bold text-slate-800">Detail Riwayat Pasien</h2>
                <p class="text-sm text-slate-500">
                    Pemeriksaan pada {{ $periksa->tgl_periksa->format('d/m/Y H:i') }}
                </p>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">

            <div class="flex flex-col gap-6">
                <div class="card border border-slate-200 bg-base-100 shadow-md">
                    <div class="card-body">
                        <h3 class="card-title text-slate-800">
                            <i class="fas fa-user text-[#2d4499]"></i>
                            Data Pasien
                        </h3>

                        <div class="mt-2 space-y-3 text-sm">
                            <div class="flex justify-between gap-4">
                                <span class="text-slate-500">Nama</span>
                                <span class="font-semibold text-slate-800">{{ $periksa->daftarPoli->pasien->nama ?? '-' }}</span>
                            </div>
                            <div class="flex justify-between gap-4">
                                <span class="text-slate-500">No. RM</span>
                                <span class="font-semibold text-slate-800">{{ $periksa->daftarPoli->pasien->no_rm ?? '-' }}</span>
                            </div>
                            <div class="flex justify-between gap-4">
                                <span class="text-slate-500">No. KTP</span>
                                <span class="font-semibold text-slate-800">{{ $periksa->daftarPoli->pasien->no_ktp ?? '-' }}</span>
                            </div>
                            <div class="flex justify-between gap-4">
                                <span class="text-slate-500">No. HP</span>
                                <span class="font-semibold text-slate-800">{{ $periksa->daftarPoli->pasien->no_hp ?? '-' }}</span>
                            </div>
                            <div class="flex justify-between gap-4">
                                <span class="text-slate-500">Alamat</span>
                                <span class="max-w-[60%] text-right font-semibold text-slate-800">{{ $periksa->daftarPoli->pasien->alamat ?? '-' }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card border border-slate-200 bg-base-100 shadow-md">
                    <div class="card-body">
                        <h3 class="card-title text-slate-800">
                            <i class="fas fa-calendar-check text-[#2d4499]"></i>
                            Informasi Kunjungan
                        </h3>

                        <div class="mt-2 space-y-3 text-sm">
                            <div class="flex justify-between gap-4">
                                <span class="text-slate-500">Poli</span>
                                <span class="font-semibold text-slate-800">{{ $periksa->daftarPoli->jadwalPeriksa->dokter->poli->nama_poli ?? '-' }}</span>
                            </div>
                            <div class="flex justify-between gap-4">
                                <span class="text-slate-500">Dokter</span>
                                <span class="font-semibold text-slate-800">{{ $periksa->daftarPoli->jadwalPeriksa->dokter->nama ?? '-' }}</span>
                            </div>
                            <div class="flex justify-between gap-4">
                                <span class="text-slate-500">No. Antrian</span>
                                <span class="badge border-none bg-[#2d4499] text-white">{{ $periksa->daftarPoli->no_antrian }}</span>
                            </div>
                            <div class="flex justify-between gap-4">
                                <span class="text-slate-500">Tanggal Periksa</span>
                                <span class="font-semibold text-slate-800">{{ $periksa->tgl_periksa->format('d/m/Y H:i') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex flex-col gap-6 lg:col-span-2">
                <div class="card border border-slate-200 bg-base-100 shadow-md">
                    <div class="card-body">
                        <h3 class="card-title text-slate-800">
                            <i class="fas fa-notes-medical text-[#2d4499]"></i>
                            Catatan Pemeriksaan
                        </h3>
                        <p class="mt-2 text-sm leading-relaxed text-slate-600">
                            {{ $periksa->catatan ?: 'Tidak ada catatan.' }}
                        </p>

                        <div class="mt-4 rounded-xl bg-amber-50 p-4 text-sm text-amber-800">
                            <div class="mb-1 font-semibold">
                                <i class="fas fa-comment-medical mr-1"></i>
                                Keluhan Saat Mendaftar
                            </div>
                            <p>{{ $periksa->daftarPoli->keluhan }}</p>
                        </div>
                    </div>
                </div>

                <div class="card border border-slate-200 bg-base-100 shadow-md">
                    <div class="card-body p-0">
                        <div class="border-b border-slate-100 px-6 py-4">
                            <h3 class="font-bold text-slate-800">Resep Obat</h3>
                            <p class="text-sm text-slate-500">Obat yang diberikan pada pemeriksaan ini.</p>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="table w-full">
                                <thead class="bg-slate-100 text-xs uppercase tracking-wider text-slate-500">
                                    <tr>
                                        <th class="px-6 py-4">Nama Obat</th>
                                        <th class="px-6 py-4">Kemasan</th>
                                        <th class="px-6 py-4 text-right">Harga</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($periksa->detailPeriksas as $detail)
                                    <tr>
                                        <td class="px-6 py-4 font-semibold text-slate-800">
                                            {{ $detail->obat->nama_obat ?? '-' }}
                                        </td>
                                        <td class="px-6 py-4 text-slate-600">
                                            {{ $detail->obat->kemasan ?? '-' }}
                                        </td>
                                        <td class="px-6 py-4 text-right text-slate-700">
                                            Rp {{ number_format($detail->obat->harga ?? 0, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="3" class="py-10 text-center text-slate-400">
                                            Tidak ada obat yang diresepkan
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="flex items-center justify-between border-t border-slate-100 px-6 py-4">
                            <span class="font-semibold text-slate-800">Total Biaya Periksa</span>
                            <span class="text-lg font-bold text-[#2d4499]">
                                Rp {{ number_format($periksa->biaya_periksa, 0, ',', '.') }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
