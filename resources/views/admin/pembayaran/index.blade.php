<x-sidebar-layout>
    <div class="p-6">
        <h1 class="text-xl font-bold mb-4">Data Pembayaran Siswa</h1>

        <div class="bg-white shadow rounded p-4">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b">
                        <th class="p-2">NISN</th>
                        <th class="p-2">Nama</th>
                        <th class="p-2">Status Pembayaran</th>
                        <th class="p-2">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $d)
                        <tr class="border-b">
                            <td class="p-2">{{ $d['nisn'] }}</td>
                            <td class="p-2">{{ $d['nama'] }}</td>
                            <td class="p-2">
                                @php
                                    $belum = array_values(array_filter($d['status'], fn($v)=>$v=='belum'));
                                @endphp

                                <span class="text-red-500">
                                    {{ count($belum) }} Bulan Belum Lunas
                                </span>
                            </td>
                            <td class="p-2">
                                <form action="{{ route('admin.pembayaran.bayar', $d['nisn']) }}" method="GET">
                                    <x-primary-button type="submit">
                                        Bayar
                                    </x-primary-button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-sidebar-layout>
