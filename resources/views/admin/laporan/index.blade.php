    <x-sidebar-layout>
        <h1 class="text-2xl font-bold mb-4">Laporan Pembayaran SPP</h1>

        <form action="{{ route('admin.laporan.cari') }}" method="GET">
            <select name="id_kelas" class="border p-2 rounded">
                <option value="">-- Pilih Kelas --</option>
                @foreach($kelas as $k)
                    <option value="{{ $k->id_kelas }}" {{ (isset($id_kelas) && $id_kelas == $k->id_kelas) ? 'selected' : '' }}>
                        {{ $k->nama_kelas }}
                    </option>
                @endforeach
            </select>

            <button class="bg-green-500 text-white px-4 py-2 rounded">Cari</button>

            @isset($id_kelas)
            <a href="{{ route('admin.laporan.cetak', ['id_kelas' => $id_kelas]) }}" target="_blank" class="bg-blue-500 text-white px-4 py-2 rounded">
                Cetak PDF
            </a>
            @endisset
        </form>

        <br>

        @isset($siswa)
        <table class="w-full text-xs border">
    <thead>
        <tr class="bg-gray-200 text-center">
            <th class="border p-2">NISN</th>
            <th class="border p-2">Nama</th>

            {{-- Header Bulan --}}
            @php
                $bulanList = ['Juli','Agustus','September','Oktober','November','Desember',
                    'Januari','Februari','Maret','April','Mei','Juni'];
            @endphp

            @foreach($bulanList as $b)
                <th class="border p-2 w-20">{{ $b }}</th>
            @endforeach

            <th class="border p-2">Total Bayar</th>
            <th class="border p-2">Tunggakan</th>
        </tr>
    </thead>

    <tbody>
        @foreach($siswa as $s)
            @php
                $bulanSudah = App\Models\Pembayaran::where('nisn', $s->nisn)
                    ->pluck('bulan_dibayar')
                    ->toArray();

                $totalBayar = App\Models\Pembayaran::where('nisn', $s->nisn)->sum('jumlah_bayar');
                $tunggakan = $s->spp->nominal * 12 - $totalBayar;
            @endphp

            <tr class="text-center">
                <td class="border p-2">{{ $s->nisn }}</td>
                <td class="border p-2 text-left">{{ $s->nama }}</td>

                {{-- Status per Bulan --}}
                @foreach($bulanList as $b)
                    <td class="border p-2">
                        @if(in_array($b, $bulanSudah))
                            <span class="text-green-600 font-bold">✔</span>
                        @else
                            <span class="text-red-600 font-bold">✘</span>
                        @endif
                    </td>
                @endforeach

                <td class="border p-2">
                    Rp {{ number_format($totalBayar,0,',','.') }}
                </td>

                <td class="border p-2 text-red-600 font-semibold">
                    Rp {{ number_format($tunggakan,0,',','.') }}
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
        @endisset

    </x-sidebar-layout>
