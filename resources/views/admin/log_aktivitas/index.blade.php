<x-sidebar-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Log Aktivitas
        </h2>
    </x-slot>

    <div class="bg-white p-6 rounded shadow">

        <h3 class="text-lg font-semibold mb-4">Riwayat Aktivitas User</h3>

        <table class="w-full border-collapse">
            <thead>
                <tr class="bg-gray-100 text-center">
                    <th class="p-2 border">User ID</th>
                    <th class="p-2 border">Tipe User</th>
                    <th class="p-2 border">Aktivitas</th>
                    <th class="p-2 border">Waktu</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($logs as $log)
                    <tr>
                        <td class="p-2 border text-center">{{ $log->user_id }}</td>
                        <td class="p-2 border capitalize text-center">{{ $log->user_type }}</td>
                        <td class="p-2 border text-center">{{ $log->aktivitas }}</td>
                        <td class="p-2 border text-center">{{ \Carbon\Carbon::parse($log->waktu)->format('d-m-Y H:i:s') }} </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-4">
            {{ $logs->links() }}
        </div>

    </div>
</x-sidebar-layout>
