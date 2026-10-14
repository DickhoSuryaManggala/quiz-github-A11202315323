<x-layouts.app title="Edit Obat">
    <div class="space-y-6">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.obat.index') }}"
                class="inline-flex items-center justify-center w-10 h-10 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-600 transition-colors">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-slate-800">Edit Obat</h1>
                <p class="text-sm text-slate-500 mt-1">Ubah data obat di bawah ini</p>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
            <form action="{{ route('admin.obat.update', $obat) }}" method="POST" class="space-y-5">
                @csrf
                @method('PUT')

                <div>
                    <label for="nama_obat" class="block text-sm font-semibold text-slate-700 mb-1.5">
                        Nama Obat <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="nama_obat" id="nama_obat"
                        value="{{ old('nama_obat', $obat->nama_obat) }}"
                        class="w-full px-4 py-2.5 rounded-lg border @error('nama_obat') border-red-400 @else border-slate-300 @enderror focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 outline-none transition-all"
                        placeholder="Contoh: Paracetamol">
                    @error('nama_obat')
                        <p class="mt-1.5 text-xs text-red-500"><i class="fas fa-circle-exclamation"></i> {{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="kemasan" class="block text-sm font-semibold text-slate-700 mb-1.5">
                        Kemasan
                    </label>
                    <input type="text" name="kemasan" id="kemasan"
                        value="{{ old('kemasan', $obat->kemasan) }}"
                        class="w-full px-4 py-2.5 rounded-lg border @error('kemasan') border-red-400 @else border-slate-300 @enderror focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 outline-none transition-all"
                        placeholder="Contoh: Strip 10 tablet">
                    @error('kemasan')
                        <p class="mt-1.5 text-xs text-red-500"><i class="fas fa-circle-exclamation"></i> {{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="harga" class="block text-sm font-semibold text-slate-700 mb-1.5">
                        Harga (Rp) <span class="text-red-500">*</span>
                    </label>
                    <input type="number" name="harga" id="harga" min="0"
                        value="{{ old('harga', $obat->harga) }}"
                        class="w-full px-4 py-2.5 rounded-lg border @error('harga') border-red-400 @else border-slate-300 @enderror focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 outline-none transition-all"
                        placeholder="Contoh: 5000">
                    @error('harga')
                        <p class="mt-1.5 text-xs text-red-500"><i class="fas fa-circle-exclamation"></i> {{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center gap-3 pt-2">
                    <button type="submit"
                        class="inline-flex items-center gap-2 px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-lg shadow-sm transition-all">
                        <i class="fas fa-save"></i>
                        Perbarui
                    </button>
                    <a href="{{ route('admin.obat.index') }}"
                        class="inline-flex items-center gap-2 px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-semibold rounded-lg transition-all">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>
