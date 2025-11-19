<h2 style="text-align:center;">KUITANSI SPP</h2>
<p>Tanggal: {{ now()->translatedFormat('l, d F Y') }}</p>

<p><strong>NISN:</strong> {{ $siswa->nisn }}</p>
<p><strong>Nama:</strong> {{ $siswa->nama }}</p>
<p><strong>Kelas:</strong> {{ $siswa->kelas->nama_kelas }}</p>

<hr>

<h4>Bulan Dibayar:</h4>
<ul>
@foreach($bulanDibayar as $b)
    <li>{{ $b }}</li>
@endforeach
</ul>

<h4>Tunggakan:</h4>
<ul>
@foreach($tunggakan as $t)
    <li>{{ $t }}</li>
@endforeach
</ul>

<hr>

<p><strong>Total Bayar:</strong> Rp {{ number_format($pembayaran->sum('jumlah_bayar'),0,',','.') }}</p>
