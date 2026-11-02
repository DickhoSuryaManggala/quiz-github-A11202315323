<x-layouts.app title="Periksa Pasien">
    <div class="flex flex-col gap-6">

        <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-2xl font-bold text-slate-800">Periksa Pasien</h2>
                <p class="mt-1 text-sm text-slate-500">
                    Daftar pasien yang mendaftar pada jadwal praktik Anda hari ini.
                </p>
            </div>

            <div class="rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm shadow-sm">
                <i class="fas fa-calendar-day mr-2 text-[#2d4499]"></i>
                {{ now()->locale('id')->isoFormat('dddd, D MMMM Y') }}
            </div>
        </div>

        @if(session('success'))
        <div class="alert alert-success rounded-xl shadow-sm">
            <i class="fas fa-check-circle"></i>
            <span>{{ session('success') }}</span>
        </div>
        @endif

        @if(session('error'))
        <div class="alert alert-error rounded-xl shadow-sm">
            <i class="fas fa-circle-xmark"></i>
            <span>{{ session('error') }}</span>
        </div>
        @endif

        <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
            <div class="stat rounded-2xl border border-slate-200 bg-base-100 shadow-sm">
                <div class="stat-figure text-[#2d4499]">
                    <i class="fas fa-users text-2xl"></i>
                </div>
                <div class="stat-title">Total Antrian</div>
                <div class="stat-value text-[#2d4499]">{{ $daftarPolis->count() }}</div>
                <div class="stat-desc">Pasien terdaftar hari ini</div>
            </div>

            <div class="stat rounded-2xl border border-slate-200 bg-base-100 shadow-sm">
                <div class="stat-figure text-amber-500">
                    <i class="fas fa-hourglass-half text-2xl"></i>
                </div>
                <div class="stat-title">Menunggu</div>
                <div class="stat-value text-amber-500">{{ $jumlahMenunggu }}</div>
                <div class="stat-desc">Belum diperiksa</div>
            </div>

            <div class="stat rounded-2xl border border-slate-200 bg-base-100 shadow-sm">
                <div class="stat-figure text-emerald-500">
                    <i class="fas fa-circle-check text-2xl"></i>
                </div>
                <div class="stat-title">Selesai</div>
                <div class="stat-value text-emerald-500">{{ $jumlahSelesai }}</div>
                <div class="stat-desc">Sudah diperiksa</div>
            </div>
        </div>

        <div class="card border border-slate-200 bg-base-100 shadow-md">
            <div class="card-body p-0">
                <div class="border-b border-slate-100 px-6 py-4">
                    <h3 class="font-bold text-slate-800">Antrian Pasien</h3>
                    <p class="text-sm text-slate-500">Klik tombol periksa untuk membuka formulir pemeriksaan.</p>
                </div>

                <div class="overflow-x-auto">
                    <table class="table table-zebra w-full">
                        <thead class="bg-slate-100 text-xs uppercase tracking-wider text-slate-500">
                            <tr>
                                <th class="px-6 py-4 text-center">Antrian</th>
                                <th class="px-6 py-4">Pasien</th>
                                <th class="px-6 py-4">Poli</th>
                                <th class="px-6 py-4">Keluhan</th>
                                <th class="px-6 py-4">Status</th>
                                <th class="px-6 py-4 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($daftarPolis as $daftarPoli)
                            <tr class="hover:bg-slate-50 transition">
                                <td class="px-6 py-4 text-center">
                                    <span class="badge border-none bg-[#2d4499] text-white">
                                        {{ $daftarPoli->no_antrian }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="font-semibold text-slate-800">
                                        {{ $daftarPoli->pasien->nama ?? '-' }}
                                    </div>
                                    <div class="text-xs text-slate-500">
                                        No. RM: {{ $daftarPoli->pasien->no_rm ?? '-' }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-slate-600">
                                    {{ $daftarPoli->jadwalPeriksa->dokter->poli->nama_poli ?? '-' }}
                                </td>
                                <td class="max-w-xs px-6 py-4 text-slate-600">
                                    <span class="line-clamp-2">{{ $daftarPoli->keluhan }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    @if($daftarPoli->periksa)
                                    <span class="badge border-none bg-emerald-500 text-white">Selesai</span>
                                    @else
                                    <span class="badge border-none bg-amber-400 text-slate-900">Menunggu</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right">
                                    @if($daftarPoli->periksa)
                                    <a href="{{ route('riwayat-pasien.show', $daftarPoli->periksa->id) }}"
                                        class="btn btn-sm border-none bg-slate-200 text-slate-700 hover:bg-slate-300">
                                        <i class="fas fa-eye"></i>
                                        Lihat Hasil
                                    </a>
                                    @else
                                    <a href="{{ route('periksa-pasien.create', $daftarPoli->id) }}"
                                        class="btn btn-sm border-none bg-[#2d4499] text-white hover:bg-[#1e2d6b]">
                                        <i class="fas fa-stethoscope"></i>
                                        Periksa
                                    </a>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="py-14 text-center text-slate-400">
                                    <i class="fas fa-user-clock mb-3 block text-3xl"></i>
                                    Belum ada pasien pada jadwal hari ini
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
