<x-sidebar-layout>
    <div class="p-6">
        <h1 class="text-xl font-bold mb-4">History Pembayaran SPP</h1>

        {{-- Identitas Siswa --}}
        <div class="bg-white shadow rounded p-6 mb-6">
            <h2 class="text-lg font-semibold mb-4">Data Siswa</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                <div>
                    <p class="font-semibold">NISN:</p>
                    <p>{{ $siswa->nisn }}</p>
                </div>

                <div>
                    <p class="font-semibold">Nama:</p>
                    <p>{{ $siswa->nama }}</p>
                </div>

                <div>
                    <p class="font-semibold">Kelas:</p>
                    <p>{{ $siswa->kelas->nama_kelas }}</p>
                </div>

                <div>
                    <p class="font-semibold">Tahun SPP:</p>
                    <p>{{ $siswa->spp->tahun }}</p>
                </div>

                <div>
                    <p class="font-semibold">Nominal SPP per Bulan:</p>
                    <p>Rp {{ number_format($siswa->spp->nominal, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>

        {{-- Ringkasan Pembayaran --}}
        <div class="bg-white shadow rounded p-6 mb-6">
            <h2 class="text-lg font-semibold mb-4">Ringkasan Pembayaran</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                <div>
                    <p class="font-semibold">Total Bulan Lunas:</p>
                    <p>{{ $totalBulan }} Bulan</p>
                </div>

                <div>
                    <p class="font-semibold">Total Pembayaran:</p>
                    <p>Rp {{ number_format($totalBayar, 0, ',', '.') }}</p>
                </div>
            </div>

            <div class="mt-4">
                <a href="{{ route('admin.pembayaran.detail', $siswa->nisn) }}">
                    <x-primary-button>
                        Lihat Detail Pembayaran
                    </x-primary-button>
                </a>
            </div>
        </div>

        {{-- Tabel Riwayat Pembayaran --}}
        <div class="bg-white shadow rounded p-6 mb-6">
            <h2 class="text-lg font-semibold mb-4">Riwayat Pembayaran</h2>

            <table class="w-full text-sm border">
                <thead>
                    <tr class="bg-gray-100 border-b text-left">
                        <th class="p-2">Tanggal Bayar</th>
                        <th class="p-2">Bulan Dibayar</th>
                        <th class="p-2">Total Bayar</th>
                        <th class="p-2">Petugas</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($siswa->pembayaran as $p)
                        <tr class="border-b">
                            <td class="p-2">{{ \Carbon\Carbon::parse($p->tgl_bayar)->format('d-m-Y') }}</td>

                            {{-- 🔥 Solusi A: langsung tampilkan STRING bukan array --}}
                            <td class="p-2">
                                <span class="inline-block bg-green-100 text-green-700 px-2 py-1 rounded text-xs">
                                    {{ $p->bulan_dibayar }}
                                </span>
                            </td>

                            <td class="p-2">
                                Rp {{ number_format($p->jumlah_bayar, 0, ',', '.') }}
                            </td>

                            <td class="p-2">
                                {{ $p->petugas->nama_petugas ?? '-' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="p-4 text-center text-gray-500">
                                Belum ada pembayaran.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
            <form action="{{ route('admin.pembayaran.index', $siswa->nisn) }}" method="GET">
        <x-primary-button>
            Kembali
        </x-primary-button>
    </form>
    </div>

</x-sidebar-layout>
