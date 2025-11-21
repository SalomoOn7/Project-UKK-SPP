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

                <p><strong>Nominal SPP:</strong> 
                    Rp {{ number_format($siswa->spp->nominal, 0, ',', '.') }}
                </p>

                <p><strong>Total Bulan Dibayar:</strong> 
                    {{ count($bulanSudah ?? []) }} Bulan
                </p>

                <p ><strong>Total Bayar:</strong> 
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
            <a href="{{ route('siswa.pembayaran.history') }}">
              <x-primary-button>
              Kembali
            </x-primary-button>
          </a>
        </div>

    </div>
</x-sidebar-layout>
