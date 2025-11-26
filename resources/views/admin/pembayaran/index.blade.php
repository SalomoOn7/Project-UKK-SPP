<x-sidebar-layout>
    <div class="p-6">
        <h1 class="text-xl font-bold mb-4">Data Pembayaran Siswa</h1>
         {{-- FILTER FORM --}}
        {{-- FILTER & SEARCH FORM --}}
        <form method="GET" class="mb-4 flex gap-3">
    <select name="kelas" class="border px-3 py-2 rounded">
        <option value=""> Semua Kelas </option>
        @foreach($kelas as $k)
            <option value="{{ $k->id_kelas  }}" 
                {{ $filterKelas == $k->id_kelas  ? 'selected' : '' }}>
                {{ $k->nama_kelas }}
            </option>
        @endforeach
    </select>

    <input type="text" name="nama" class="border px-3 py-2 rounded"
           placeholder="Cari nama..." value="{{ $filterNama }}">

    <button class="bg-blue-600 text-white px-4 py-2 rounded">
        Cari / Filter
    </button>
</form>

        <div class="bg-white shadow rounded p-4 overflow-x-auto">
            <table class="w-full text-sm border">
                <thead class="bg-gray-200">
                    <tr class="border-b text-center">
                        <th class="p-2">NISN</th>
                        <th class="p-2">Nama</th>
                        <th class="p-2">Kelas</th>
                        {{-- Header nama bulan --}}
                        @foreach(["Jul","Aug","Sep","Oct","Nov","Dec","Jan","Feb","Mar","Apr","May","Jun"] as $b)
                            <th class="p-1">{{ $b }}</th>
                        @endforeach

                        <th class="p-2">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($data as $d)
                        <tr class="border-b text-center">
                            <td class="p-2">{{ $d['nisn'] }}</td>
                            <td class="p-2">{{ $d['nama'] }}</td>
                            <td class="p-2">{{ $d['kelas'] }}</td>
                            {{-- Status tiap bulan --}}
                            @foreach($d['status'] as $bulan => $status)
                                <td class="p-1">
                                    @if($status == 'lunas')
                                        <span class="text-green-600 font-bold">✔</span>
                                    @else
                                        <span class="text-red-600 font-bold">✘</span>
                                    @endif
                                </td>
                            @endforeach

                            <td class="p-2">
                                <div class="flex justify-center gap-2">
                                    <form action="{{ route('admin.pembayaran.bayar', $d['nisn']) }}" method="GET">
                                            <x-primary-button>Bayar</x-primary-button>
                                        </form>

                                        <form action="{{ route('admin.pembayaran.history', $d['nisn']) }}" method="GET">
                                            <x-primary-button class="bg-gray-700 hover:bg-gray-800">History</x-primary-button>
                                        </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>

            </table>
        </div>
    </div>
</x-sidebar-layout>
