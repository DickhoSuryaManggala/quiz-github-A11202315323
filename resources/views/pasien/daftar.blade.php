<x-layouts.app title="Daftar Poli">
    <div class="flex flex-col gap-6">

        <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-2xl font-bold text-slate-800">Daftar Poli</h2>
                <p class="mt-1 text-sm text-slate-500">
                    Pilih poli dan jadwal dokter, lalu sampaikan keluhan Anda.
                </p>
            </div>

            <div class="flex items-center gap-3 rounded-xl border border-slate-200 bg-white px-4 py-3 shadow-sm">
                <div class="flex h-10 w-10 items-center justify-center rounded-full bg-[#2d4499]/10 text-[#2d4499]">
                    <i class="fas fa-user"></i>
                </div>
                <div>
                    <div class="text-sm font-semibold text-slate-800">{{ auth()->user()->nama }}</div>
                    <div class="text-xs text-slate-500">No. RM: {{ auth()->user()->no_rm ?? '-' }}</div>
                </div>
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

        <div class="grid grid-cols-1 gap-6 xl:grid-cols-3">

            <div class="card border border-slate-200 bg-base-100 shadow-md xl:col-span-2">
                <div class="card-body">
                    <h3 class="card-title text-slate-800">
                        <i class="fas fa-notes-medical text-[#2d4499]"></i>
                        Formulir Pendaftaran
                    </h3>

                    @if($errors->any())
                    <div class="alert alert-error mt-2 rounded-xl">
                        <i class="fas fa-circle-exclamation"></i>
                        <div>
                            @foreach($errors->all() as $error)
                            <div>{{ $error }}</div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <form action="{{ route('pasien.daftar.store') }}" method="POST" class="mt-3 space-y-5">
                        @csrf

                        <div class="form-control">
                            <label class="label" for="poliSelect">
                                <span class="label-text font-semibold text-slate-700">Pilih Poli</span>
                            </label>
                            <select id="poliSelect" class="select select-bordered w-full" required>
                                <option value="">Semua Poli</option>
                                @foreach($polis as $poli)
                                <option value="{{ $poli->id }}">{{ $poli->nama_poli }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-control">
                            <label class="label" for="jadwalSelect">
                                <span class="label-text font-semibold text-slate-700">Jadwal Dokter</span>
                            </label>
                            <select id="jadwalSelect" name="id_jadwal" class="select select-bordered w-full" required>
                                <option value="">Pilih jadwal dokter</option>
                                @foreach($jadwals as $jadwal)
                                <option value="{{ $jadwal->id }}" data-poli="{{ $jadwal->dokter->id_poli }}">
                                    {{ $jadwal->dokter->poli->nama_poli ?? '-' }} &middot;
                                    {{ $jadwal->dokter->nama }} &middot;
                                    {{ $jadwal->hari }}, {{ substr($jadwal->jam_mulai, 0, 5) }}-{{ substr($jadwal->jam_selesai, 0, 5) }}
                                </option>
                                @endforeach
                            </select>
                            <label class="label">
                                <span class="label-text-alt text-slate-400">
                                    Jadwal otomatis menyesuaikan poli yang dipilih.
                                </span>
                            </label>
                        </div>

                        <div class="form-control">
                            <label class="label" for="keluhan">
                                <span class="label-text font-semibold text-slate-700">Keluhan</span>
                            </label>
                            <textarea id="keluhan" name="keluhan" rows="4" required
                                class="textarea textarea-bordered w-full"
                                placeholder="Tuliskan keluhan yang Anda rasakan...">{{ old('keluhan') }}</textarea>
                        </div>

                        <button type="submit"
                            class="btn w-full border-none bg-[#2d4499] text-white hover:bg-[#1e2d6b]">
                            <i class="fas fa-paper-plane"></i>
                            Daftar Sekarang
                        </button>
                    </form>
                </div>
            </div>

            <div class="card border border-slate-200 bg-gradient-to-br from-[#1e2d6b] to-[#2d4499] text-white shadow-md">
                <div class="card-body">
                    <h3 class="card-title text-white">
                        <i class="fas fa-circle-info"></i>
                        Alur Pendaftaran
                    </h3>
                    <p class="text-sm text-white/70">
                        Ikuti langkah berikut agar pendaftaran Anda diproses dengan cepat.
                    </p>

                    <ol class="mt-2 space-y-4 text-sm">
                        <li class="flex gap-3">
                            <span class="flex h-7 w-7 shrink-0 items-center justify-center rounded-full bg-white/15 font-bold">1</span>
                            <span>Pilih poli yang sesuai dengan keluhan.</span>
                        </li>
                        <li class="flex gap-3">
                            <span class="flex h-7 w-7 shrink-0 items-center justify-center rounded-full bg-white/15 font-bold">2</span>
                            <span>Pilih jadwal dokter yang tersedia.</span>
                        </li>
                        <li class="flex gap-3">
                            <span class="flex h-7 w-7 shrink-0 items-center justify-center rounded-full bg-white/15 font-bold">3</span>
                            <span>Isi keluhan, lalu tekan tombol Daftar Sekarang.</span>
                        </li>
                        <li class="flex gap-3">
                            <span class="flex h-7 w-7 shrink-0 items-center justify-center rounded-full bg-white/15 font-bold">4</span>
                            <span>Nomor antrian akan muncul setelah pendaftaran berhasil.</span>
                        </li>
                    </ol>
                </div>
            </div>
        </div>

        <div class="card border border-slate-200 bg-base-100 shadow-md">
            <div class="card-body p-0">
                <div class="border-b border-slate-100 px-6 py-4">
                    <h3 class="font-bold text-slate-800">Riwayat Pendaftaran</h3>
                    <p class="text-sm text-slate-500">Pendaftaran yang pernah Anda lakukan.</p>
                </div>

                <div class="overflow-x-auto">
                    <table class="table table-zebra w-full">
                        <thead class="bg-slate-100 text-xs uppercase tracking-wider text-slate-500">
                            <tr>
                                <th class="px-6 py-4">Tanggal</th>
                                <th class="px-6 py-4">Poli</th>
                                <th class="px-6 py-4">Dokter</th>
                                <th class="px-6 py-4">Jadwal</th>
                                <th class="px-6 py-4 text-center">No. Antrian</th>
                                <th class="px-6 py-4 text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pendaftarans as $pendaftaran)
                            <tr class="hover:bg-slate-50 transition">
                                <td class="px-6 py-4 text-slate-600">
                                    {{ $pendaftaran->created_at->format('d/m/Y H:i') }}
                                </td>
                                <td class="px-6 py-4 font-semibold text-slate-800">
                                    {{ $pendaftaran->jadwalPeriksa->dokter->poli->nama_poli ?? '-' }}
                                </td>
                                <td class="px-6 py-4 text-slate-600">
                                    {{ $pendaftaran->jadwalPeriksa->dokter->nama ?? '-' }}
                                </td>
                                <td class="px-6 py-4 text-slate-600">
                                    {{ $pendaftaran->jadwalPeriksa->hari ?? '-' }},
                                    {{ substr($pendaftaran->jadwalPeriksa->jam_mulai ?? '', 0, 5) }}-{{ substr($pendaftaran->jadwalPeriksa->jam_selesai ?? '', 0, 5) }}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="badge border-none bg-[#2d4499] text-white">
                                        {{ $pendaftaran->no_antrian }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @if($pendaftaran->periksa)
                                    <span class="badge border-none bg-emerald-500 text-white">Selesai</span>
                                    @else
                                    <span class="badge border-none bg-amber-400 text-slate-900">Menunggu</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="py-14 text-center text-slate-400">
                                    <i class="fas fa-inbox mb-3 block text-3xl"></i>
                                    Belum ada pendaftaran
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        const poliSelect = document.getElementById('poliSelect');
        const jadwalSelect = document.getElementById('jadwalSelect');
        const semuaJadwal = Array.from(jadwalSelect.querySelectorAll('option[data-poli]'))
            .map((option) => option.cloneNode(true));

        function filterJadwal() {
            const poli = poliSelect.value;
            jadwalSelect.innerHTML = '<option value="">Pilih jadwal dokter</option>';

            semuaJadwal
                .filter((option) => !poli || option.dataset.poli === poli)
                .forEach((option) => jadwalSelect.appendChild(option.cloneNode(true)));
        }

        poliSelect.addEventListener('change', filterJadwal);
        filterJadwal();
    </script>
    @endpush
</x-layouts.app>
