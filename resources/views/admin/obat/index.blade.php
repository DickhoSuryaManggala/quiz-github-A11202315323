<x-layouts.app title="Data Obat">
    <div class="space-y-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-slate-800">Data Obat</h1>
                <p class="text-sm text-slate-500 mt-1">Kelola data obat poliklinik</p>
            </div>
            <a href="{{ route('admin.obat.create') }}"
                class="inline-flex items-center gap-2 px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-lg shadow-sm transition-all">
                <i class="fas fa-plus"></i>
                Tambah Obat
            </a>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-slate-50 text-slate-600">
                        <tr>
                            <th class="px-6 py-3 text-left font-semibold">No</th>
                            <th class="px-6 py-3 text-left font-semibold">Nama Obat</th>
                            <th class="px-6 py-3 text-left font-semibold">Kemasan</th>
                            <th class="px-6 py-3 text-left font-semibold">Harga</th>
                            <th class="px-6 py-3 text-center font-semibold">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($obats as $obat)
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="px-6 py-4 text-slate-500">{{ $loop->iteration }}</td>
                                <td class="px-6 py-4 font-medium text-slate-800">{{ $obat->nama_obat }}</td>
                                <td class="px-6 py-4 text-slate-600">{{ $obat->kemasan ?? '-' }}</td>
                                <td class="px-6 py-4 text-slate-600">Rp {{ number_format($obat->harga, 0, ',', '.') }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('admin.obat.edit', $obat) }}"
                                            class="inline-flex items-center gap-1 px-3 py-1.5 bg-amber-100 hover:bg-amber-200 text-amber-700 text-xs font-semibold rounded-lg transition-colors">
                                            <i class="fas fa-pen-to-square"></i>
                                            Edit
                                        </a>
                                        <form action="{{ route('admin.obat.destroy', $obat) }}" method="POST"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus obat ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="inline-flex items-center gap-1 px-3 py-1.5 bg-red-100 hover:bg-red-200 text-red-700 text-xs font-semibold rounded-lg transition-colors">
                                                <i class="fas fa-trash"></i>
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-slate-400">
                                    <i class="fas fa-box-open text-4xl mb-3 block text-slate-300"></i>
                                    Belum ada data obat.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layouts.app>
