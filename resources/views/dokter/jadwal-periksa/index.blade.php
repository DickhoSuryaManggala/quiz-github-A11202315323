<x-layouts.app title="Jadwal Periksa">
    <div class="space-y-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-slate-800">Jadwal Periksa</h1>
                <p class="text-sm text-slate-500 mt-1">Kelola jadwal praktik Anda</p>
            </div>
            <a href="{{ route('dokter.jadwal-periksa.create') }}"
                class="inline-flex items-center gap-2 px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-lg shadow-sm transition-all">
                <i class="fas fa-plus"></i>
                Tambah Jadwal
            </a>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-slate-50 text-slate-600">
                        <tr>
                            <th class="px-6 py-3 text-left font-semibold">No</th>
                            <th class="px-6 py-3 text-left font-semibold">Hari</th>
                            <th class="px-6 py-3 text-left font-semibold">Jam Mulai</th>
                            <th class="px-6 py-3 text-left font-semibold">Jam Selesai</th>
                            <th class="px-6 py-3 text-center font-semibold">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($jadwals as $jadwal)
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="px-6 py-4 text-slate-500">{{ $loop->iteration }}</td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-indigo-100 text-indigo-700">
                                        {{ $jadwal->hari }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-slate-700 font-mono">{{ substr($jadwal->jam_mulai, 0, 5) }}</td>
                                <td class="px-6 py-4 text-slate-700 font-mono">{{ substr($jadwal->jam_selesai, 0, 5) }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('dokter.jadwal-periksa.edit', $jadwal) }}"
                                            class="inline-flex items-center gap-1 px-3 py-1.5 bg-amber-100 hover:bg-amber-200 text-amber-700 text-xs font-semibold rounded-lg transition-colors">
                                            <i class="fas fa-pen-to-square"></i>
                                            Edit
                                        </a>
                                        <form action="{{ route('dokter.jadwal-periksa.destroy', $jadwal) }}" method="POST"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus jadwal ini?');">
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
                                    <i class="fas fa-calendar-xmark text-4xl mb-3 block text-slate-300"></i>
                                    Belum ada jadwal periksa.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layouts.app>
