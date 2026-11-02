<x-layouts.app title="Formulir Pemeriksaan">
    <div class="mx-auto flex max-w-5xl flex-col gap-6">

        <div class="flex items-center gap-3">
            <a href="{{ route('periksa-pasien.index') }}"
                class="btn btn-square border border-slate-200 bg-white text-slate-600 hover:bg-slate-100">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div>
                <h2 class="text-2xl font-bold text-slate-800">Formulir Pemeriksaan</h2>
                <p class="text-sm text-slate-500">Lengkapi hasil pemeriksaan dan resep obat pasien.</p>
            </div>
        </div>

        @if($errors->any())
        <div class="alert alert-error rounded-xl shadow-sm">
            <i class="fas fa-circle-exclamation"></i>
            <div>
                @foreach($errors->all() as $error)
                <div>{{ $error }}</div>
                @endforeach
            </div>
        </div>
        @endif

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
                                <span class="font-semibold text-slate-800">{{ $daftarPoli->pasien->nama ?? '-' }}</span>
                            </div>
                            <div class="flex justify-between gap-4">
                                <span class="text-slate-500">No. RM</span>
                                <span class="font-semibold text-slate-800">{{ $daftarPoli->pasien->no_rm ?? '-' }}</span>
                            </div>
                            <div class="flex justify-between gap-4">
                                <span class="text-slate-500">No. KTP</span>
                                <span class="font-semibold text-slate-800">{{ $daftarPoli->pasien->no_ktp ?? '-' }}</span>
                            </div>
                            <div class="flex justify-between gap-4">
                                <span class="text-slate-500">No. HP</span>
                                <span class="font-semibold text-slate-800">{{ $daftarPoli->pasien->no_hp ?? '-' }}</span>
                            </div>
                            <div class="flex justify-between gap-4">
                                <span class="text-slate-500">Alamat</span>
                                <span class="max-w-[60%] text-right font-semibold text-slate-800">{{ $daftarPoli->pasien->alamat ?? '-' }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card border border-slate-200 bg-base-100 shadow-md">
                    <div class="card-body">
                        <h3 class="card-title text-slate-800">
                            <i class="fas fa-calendar-check text-[#2d4499]"></i>
                            Jadwal Pendaftaran
                        </h3>

                        <div class="mt-2 space-y-3 text-sm">
                            <div class="flex justify-between gap-4">
                                <span class="text-slate-500">Poli</span>
                                <span class="font-semibold text-slate-800">{{ $daftarPoli->jadwalPeriksa->dokter->poli->nama_poli ?? '-' }}</span>
                            </div>
                            <div class="flex justify-between gap-4">
                                <span class="text-slate-500">Dokter</span>
                                <span class="font-semibold text-slate-800">{{ $daftarPoli->jadwalPeriksa->dokter->nama ?? '-' }}</span>
                            </div>
                            <div class="flex justify-between gap-4">
                                <span class="text-slate-500">Hari</span>
                                <span class="font-semibold text-slate-800">{{ $daftarPoli->jadwalPeriksa->hari ?? '-' }}</span>
                            </div>
                            <div class="flex justify-between gap-4">
                                <span class="text-slate-500">Jam</span>
                                <span class="font-semibold text-slate-800">
                                    {{ substr($daftarPoli->jadwalPeriksa->jam_mulai ?? '', 0, 5) }}-{{ substr($daftarPoli->jadwalPeriksa->jam_selesai ?? '', 0, 5) }}
                                </span>
                            </div>
                            <div class="flex justify-between gap-4">
                                <span class="text-slate-500">No. Antrian</span>
                                <span class="badge border-none bg-[#2d4499] text-white">{{ $daftarPoli->no_antrian }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="rounded-2xl border border-amber-200 bg-amber-50 p-4 text-sm text-amber-800">
                    <div class="mb-1 flex items-center gap-2 font-semibold">
                        <i class="fas fa-comment-medical"></i>
                        Keluhan Pasien
                    </div>
                    <p>{{ $daftarPoli->keluhan }}</p>
                </div>
            </div>

            <div class="lg:col-span-2">
                <form action="{{ route('periksa-pasien.store', $daftarPoli->id) }}" method="POST"
                    class="card border border-slate-200 bg-base-100 shadow-md">
                    @csrf

                    <div class="card-body gap-5">
                        <h3 class="card-title text-slate-800">
                            <i class="fas fa-notes-medical text-[#2d4499]"></i>
                            Hasil Pemeriksaan
                        </h3>

                        <div class="form-control">
                            <label class="label" for="catatan">
                                <span class="label-text font-semibold text-slate-700">Catatan Dokter</span>
                            </label>
                            <textarea id="catatan" name="catatan" rows="4"
                                class="textarea textarea-bordered w-full"
                                placeholder="Diagnosis, tindakan, dan anjuran untuk pasien...">{{ old('catatan') }}</textarea>
                        </div>

                        <div>
                            <div class="mb-3 flex items-center justify-between">
                                <span class="font-semibold text-slate-700">Resep Obat</span>
                                <span class="text-xs text-slate-400">Pilih satu atau lebih obat</span>
                            </div>

                            <div class="max-h-72 space-y-2 overflow-y-auto pr-1">
                                @forelse($obats as $obat)
                                <label
                                    class="flex cursor-pointer items-center justify-between gap-4 rounded-xl border border-slate-200 px-4 py-3 transition hover:border-[#2d4499] hover:bg-slate-50">
                                    <div class="flex items-center gap-3">
                                        <input type="checkbox" name="obat[]" value="{{ $obat->id }}"
                                            data-harga="{{ $obat->harga }}"
                                            class="checkbox checkbox-primary obat-checkbox"
                                            @checked(in_array($obat->id, old('obat', [])))>
                                        <div>
                                            <div class="font-semibold text-slate-800">{{ $obat->nama_obat }}</div>
                                            <div class="text-xs text-slate-500">{{ $obat->kemasan ?? '-' }}</div>
                                        </div>
                                    </div>
                                    <div class="text-sm font-semibold text-slate-700">
                                        Rp {{ number_format($obat->harga, 0, ',', '.') }}
                                    </div>
                                </label>
                                @empty
                                <div class="rounded-xl border border-dashed border-slate-300 py-8 text-center text-sm text-slate-400">
                                    Belum ada data obat
                                </div>
                                @endforelse
                            </div>
                        </div>

                        <div class="rounded-2xl bg-slate-50 p-5">
                            <div class="flex items-center justify-between text-sm text-slate-600">
                                <span>Biaya jasa dokter</span>
                                <span>Rp {{ number_format($biayaJasaDokter, 0, ',', '.') }}</span>
                            </div>
                            <div class="mt-2 flex items-center justify-between text-sm text-slate-600">
                                <span>Biaya obat</span>
                                <span id="biayaObat">Rp 0</span>
                            </div>
                            <div class="mt-3 flex items-center justify-between border-t border-slate-200 pt-3">
                                <span class="font-semibold text-slate-800">Total Biaya Periksa</span>
                                <span id="totalBiaya" class="text-lg font-bold text-[#2d4499]">
                                    Rp {{ number_format($biayaJasaDokter, 0, ',', '.') }}
                                </span>
                            </div>
                        </div>

                        <div class="flex flex-col gap-3 sm:flex-row sm:justify-end">
                            <a href="{{ route('periksa-pasien.index') }}"
                                class="btn border border-slate-200 bg-white text-slate-600 hover:bg-slate-100">
                                Batal
                            </a>
                            <button type="submit"
                                class="btn border-none bg-[#2d4499] text-white hover:bg-[#1e2d6b]">
                                <i class="fas fa-floppy-disk"></i>
                                Simpan Pemeriksaan
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        const biayaJasaDokter = {{ $biayaJasaDokter }};
        const checkboxObat = document.querySelectorAll('.obat-checkbox');
        const biayaObatEl = document.getElementById('biayaObat');
        const totalBiayaEl = document.getElementById('totalBiaya');

        function formatRupiah(value) {
            return 'Rp ' + new Intl.NumberFormat('id-ID').format(value);
        }

        function hitungBiaya() {
            let totalObat = 0;

            checkboxObat.forEach((checkbox) => {
                if (checkbox.checked) {
                    totalObat += Number(checkbox.dataset.harga);
                }
            });

            biayaObatEl.textContent = formatRupiah(totalObat);
            totalBiayaEl.textContent = formatRupiah(biayaJasaDokter + totalObat);
        }

        checkboxObat.forEach((checkbox) => checkbox.addEventListener('change', hitungBiaya));
        hitungBiaya();
    </script>
    @endpush
</x-layouts.app>
