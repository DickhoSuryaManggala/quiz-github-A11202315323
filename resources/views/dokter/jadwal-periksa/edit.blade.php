<x-layouts.app title="Edit Jadwal Periksa">
    <div class="space-y-6">
        <div class="flex items-center gap-3">
            <a href="{{ route('dokter.jadwal-periksa.index') }}"
                class="inline-flex items-center justify-center w-10 h-10 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-600 transition-colors">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-slate-800">Edit Jadwal Periksa</h1>
                <p class="text-sm text-slate-500 mt-1">Ubah jadwal praktik di bawah ini</p>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
            <form action="{{ route('dokter.jadwal-periksa.update', $jadwalPeriksa) }}" method="POST" class="space-y-5">
                @csrf
                @method('PUT')

                <div>
                    <label for="hari" class="block text-sm font-semibold text-slate-700 mb-1.5">
                        Hari <span class="text-red-500">*</span>
                    </label>
                    <select name="hari" id="hari"
                        class="w-full px-4 py-2.5 rounded-lg border @error('hari') border-red-400 @else border-slate-300 @enderror focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 outline-none transition-all bg-white">
                        <option value="">-- Pilih Hari --</option>
                        @foreach ($hari as $h)
                            <option value="{{ $h }}" {{ old('hari', $jadwalPeriksa->hari) === $h ? 'selected' : '' }}>{{ $h }}</option>
                        @endforeach
                    </select>
                    @error('hari')
                        <p class="mt-1.5 text-xs text-red-500"><i class="fas fa-circle-exclamation"></i> {{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label for="jam_mulai" class="block text-sm font-semibold text-slate-700 mb-1.5">
                            Jam Mulai <span class="text-red-500">*</span>
                        </label>
                        <input type="time" name="jam_mulai" id="jam_mulai"
                            value="{{ old('jam_mulai', substr($jadwalPeriksa->jam_mulai, 0, 5)) }}"
                            class="w-full px-4 py-2.5 rounded-lg border @error('jam_mulai') border-red-400 @else border-slate-300 @enderror focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 outline-none transition-all">
                        @error('jam_mulai')
                            <p class="mt-1.5 text-xs text-red-500"><i class="fas fa-circle-exclamation"></i> {{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="jam_selesai" class="block text-sm font-semibold text-slate-700 mb-1.5">
                            Jam Selesai <span class="text-red-500">*</span>
                        </label>
                        <input type="time" name="jam_selesai" id="jam_selesai"
                            value="{{ old('jam_selesai', substr($jadwalPeriksa->jam_selesai, 0, 5)) }}"
                            class="w-full px-4 py-2.5 rounded-lg border @error('jam_selesai') border-red-400 @else border-slate-300 @enderror focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 outline-none transition-all">
                        @error('jam_selesai')
                            <p class="mt-1.5 text-xs text-red-500"><i class="fas fa-circle-exclamation"></i> {{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex items-center gap-3 pt-2">
                    <button type="submit"
                        class="inline-flex items-center gap-2 px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-lg shadow-sm transition-all">
                        <i class="fas fa-save"></i>
                        Perbarui
                    </button>
                    <a href="{{ route('dokter.jadwal-periksa.index') }}"
                        class="inline-flex items-center gap-2 px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-semibold rounded-lg transition-all">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>
