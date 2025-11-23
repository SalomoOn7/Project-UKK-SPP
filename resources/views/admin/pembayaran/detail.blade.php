<x-sidebar-layout>
    <div class="p-6">
    <h1 class="text-xl font-bold mb-4">Detail Pembayaran Siswa</h1>

    {{-- Informasi Siswa --}}
    <div class="bg-white rounded shadow p-4 mb-4">
        <h2 class="font-semibold text-lg mb-3">Informasi Siswa</h2>

        <div class="grid grid-cols-2 gap-3 text-sm">
            <p><strong>NISN:</strong> {{ $siswa->nisn }}</p>
            <p><strong>Nama:</strong> {{ $siswa->nama }}</p>
            <p><strong>Kelas:</strong> {{ $siswa->kelas->nama_kelas }}</p>
            <p><strong>Tahun SPP:</strong> {{ $siswa->spp->tahun }}</p>
            <p><strong>Nominal SPP:</strong> Rp {{ number_format($siswa->spp->nominal, 0, ',', '.') }}</p>
            <p><strong>Total Bulan Dibayar:</strong> {{ count($bulanSudah) }} Bulan</p>
            <p><strong>Total Bayar:</strong> 
                <span class="bg-green-100 text-green-700 px-2 py-1 rounded text-xs ml-1">
                    Rp {{ number_format($totalBayar, 0, ',', '.') }}
                </span>
            </p>
            <p><strong>Tunggakan:</strong> 
                <span class="px-2 py-1 bg-red-100 text-red-700 rounded text-xs ml-1">
                    Rp {{ number_format($tunggakan, 0, ',', '.') }}
                </span>
            </p>
        </div>
    </div>

    {{-- Tabel Pembayaran --}}
    <div class="bg-white rounded shadow p-4">
        <h2 class="font-semibold text-lg mb-3">Riwayat Pembayaran</h2>

        <table class="w-full text-sm">
            <thead>
                <tr class="border-b bg-gray-100">
                    <th class="p-2 text-left">Bulan</th>
                    <th class="p-2 text-left">Tanggal Bayar</th>
                    <th class="p-2 text-left">Petugas</th>
                    <th class="p-2 text-left">Jumlah Bayar</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pembayaran as $p)
                    <tr class="border-b">
                        <td class="p-2">{{ $p->bulan_dibayar }}</td>
                        <td class="p-2">{{ \Carbon\Carbon::parse($p->tgl_bayar)->format('d-m-Y') }}</td>
                        <td class="p-2">{{ $p->petugas->nama_petugas ?? '-' }}</td>
                        <td class="p-2">Rp {{ number_format($p->jumlah_bayar, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Tombol PDF, Kartu SPP & Kembali --}}
    <div class="mt-4 flex gap-4">
        <form action="{{ route('admin.pembayaran.cetak', $siswa->nisn) }}" method="GET" target="_blank">
            <x-primary-button>
                Cetak Kuitansi PDF
            </x-primary-button>
        </form>

        <form action="{{ route('admin.pembayaran.kartu_spp', $siswa->nisn) }}" method="GET" target="_blank">
            <x-primary-button>
                Cetak Kartu SPP
            </x-primary-button>
        </form>

        <a href="{{ route('admin.pembayaran.index') }}">
            <x-primary-button>
                Kembali
            </x-primary-button>
        </a>
    </div>

</div>

</x-sidebar-layout>
