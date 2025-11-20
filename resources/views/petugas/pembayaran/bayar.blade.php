<x-sidebar-layout>
    <div class="p-6">
        <h1 class="text-xl font-bold mb-4">Pembayaran SPP</h1>

        <div class="bg-white p-6 rounded shadow">
            <form action="{{ route('petugas.pembayaran.store') }}" method="POST">
                @csrf

                <input type="hidden" name="nisn" value="{{ $siswa->nisn }}">
                <input type="hidden" name="id_spp" value="{{ $siswa->id_spp }}">

                <div class="mb-4">
                    <label class="font-semibold">NISN</label>
                    <p>{{ $siswa->nisn }}</p>
                </div>

                <div class="mb-4">
                    <label class="font-semibold">Nama Siswa</label>
                    <p>{{ $siswa->nama }}</p>
                </div>

                <div class="mb-4">
                    <label class="font-semibold">Tanggal Pembayaran</label>
                    <p>{{ now()->format('d F Y') }}</p>
                </div>
                
            <div class="mb-4">
                <label class="font-semibold">Nominal</label>
                <p>Rp {{ number_format($siswa->spp->nominal, 0, ',', '.') }}</p>
            </div>

                <div class="mb-4">
                    <label class="font-semibold">Pilih Bulan Pembayaran</label>
                        <x-multi-select 
                        id="bulanSelect"
                        name="bulan[]"
                        :options="$bulanBelum"
                        placeholder="Pilih bulan yang ingin dibayar..."
                        />
                </div>
            <x-primary-button>Simpan Pembayaran</x-primary-button>

            </form>
        </div>
    </div>
</x-sidebar-layout>
