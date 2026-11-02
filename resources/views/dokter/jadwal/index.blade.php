<x-layouts.app title="Jadwal Periksa">
    <div class="flex flex-col gap-6">

        <div>
            <h2 class="text-2xl font-bold text-slate-800">Jadwal Periksa</h2>
            <p class="mt-1 text-sm text-slate-500">Jadwal praktik yang terdaftar atas nama Anda.</p>
        </div>

        <div class="card border border-slate-200 bg-base-100 shadow-md">
            <div class="card-body p-0">
                <div class="overflow-x-auto">
                    <table class="table table-zebra w-full">
                        <thead class="bg-slate-100 text-xs uppercase tracking-wider text-slate-500">
                            <tr>
                                <th class="px-6 py-4">Hari</th>
                                <th class="px-6 py-4">Jam Mulai</th>
                                <th class="px-6 py-4">Jam Selesai</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($jadwals as $jadwal)
                            <tr class="hover:bg-slate-50 transition">
                                <td class="px-6 py-4 font-semibold text-slate-800">{{ $jadwal->hari }}</td>
                                <td class="px-6 py-4 text-slate-600">{{ substr($jadwal->jam_mulai, 0, 5) }}</td>
                                <td class="px-6 py-4 text-slate-600">{{ substr($jadwal->jam_selesai, 0, 5) }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="py-14 text-center text-slate-400">
                                    <i class="fas fa-calendar-xmark mb-3 block text-3xl"></i>
                                    Belum ada jadwal periksa
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
