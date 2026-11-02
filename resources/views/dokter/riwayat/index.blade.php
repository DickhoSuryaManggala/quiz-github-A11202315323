<x-layouts.app title="Riwayat Pasien">
    <div class="flex flex-col gap-6">

        <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-2xl font-bold text-slate-800">Riwayat Pasien</h2>
                <p class="mt-1 text-sm text-slate-500">
                    Daftar pemeriksaan pasien yang pernah Anda tangani.
                </p>
            </div>

            <div class="rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm shadow-sm">
                <i class="fas fa-file-medical mr-2 text-[#2d4499]"></i>
                {{ $riwayats->count() }} riwayat pemeriksaan
            </div>
        </div>

        <div class="card border border-slate-200 bg-base-100 shadow-md">
            <div class="card-body p-0">
                <div class="overflow-x-auto">
                    <table class="table table-zebra w-full">
                        <thead class="bg-slate-100 text-xs uppercase tracking-wider text-slate-500">
                            <tr>
                                <th class="px-6 py-4">Tanggal Periksa</th>
                                <th class="px-6 py-4">Pasien</th>
                                <th class="px-6 py-4">Poli</th>
                                <th class="px-6 py-4">Catatan</th>
                                <th class="px-6 py-4 text-center">Obat</th>
                                <th class="px-6 py-4">Biaya</th>
                                <th class="px-6 py-4 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($riwayats as $riwayat)
                            <tr class="hover:bg-slate-50 transition">
                                <td class="px-6 py-4 text-slate-600">
                                    {{ $riwayat->tgl_periksa->format('d/m/Y H:i') }}
                                </td>
                                <td class="px-6 py-4">
                                    <div class="font-semibold text-slate-800">
                                        {{ $riwayat->daftarPoli->pasien->nama ?? '-' }}
                                    </div>
                                    <div class="text-xs text-slate-500">
                                        No. RM: {{ $riwayat->daftarPoli->pasien->no_rm ?? '-' }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-slate-600">
                                    {{ $riwayat->daftarPoli->jadwalPeriksa->dokter->poli->nama_poli ?? '-' }}
                                </td>
                                <td class="max-w-xs px-6 py-4 text-slate-600">
                                    <span class="line-clamp-2">{{ $riwayat->catatan ?? '-' }}</span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="badge border-none bg-slate-200 text-slate-700">
                                        {{ $riwayat->detailPeriksas->count() }} obat
                                    </span>
                                </td>
                                <td class="px-6 py-4 font-semibold text-slate-800">
                                    Rp {{ number_format($riwayat->biaya_periksa, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <a href="{{ route('riwayat-pasien.show', $riwayat->id) }}"
                                        class="btn btn-sm border-none bg-[#2d4499] text-white hover:bg-[#1e2d6b]">
                                        <i class="fas fa-eye"></i>
                                        Detail
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="py-14 text-center text-slate-400">
                                    <i class="fas fa-clock-rotate-left mb-3 block text-3xl"></i>
                                    Belum ada riwayat pemeriksaan
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
