<x-sidebar-layout>
    <div class="p-6">
        <h1 class="text-xl font-bold mb-4">Pembayaran SPP</h1>
    <div class="bg-white p-6 rounded shadow">
        <form action="{{ route('admin.pembayaran.store') }}" method="POST" id="form-bayar">
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

            <x-primary-button type="button" id="btn-simpan">Simpan Pembayaran</x-primary-button>
        </form>
    </div>
</div>

<script>
    const btnSimpan = document.getElementById('btn-simpan');
    const formBayar = document.getElementById('form-bayar');

    btnSimpan.addEventListener('click', function(e) {
        e.preventDefault();

        // Ambil select asli dari x-multi-select
        const selectEl = document.getElementById('bulanSelect');
        const selectedValues = Array.from(selectEl.selectedOptions).map(o => o.value);

        if (selectedValues.length === 0) {
            alert('Pilih bulan terlebih dahulu! Minimal 1 bulan harus dipilih.');
            return;
        }

        const bulanList = selectedValues.join(', ');

        if (confirm(`Apakah Anda yakin ingin menyimpan pembayaran untuk bulan: ${bulanList}?`)) {
            formBayar.submit();
        }
    });
</script>
</x-sidebar-layout>
