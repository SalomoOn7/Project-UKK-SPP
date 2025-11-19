<h2 style="text-align:center;">KUITANSI SPP</h2>

<p>Tanggal: {{ now()->translatedFormat('l, d F Y') }}</p>

<p><strong>NIS :</strong> {{ $siswa->nis }}</p>
<p><strong>Nama :</strong> {{ $siswa->nama }}</p>
<p><strong>Kelas :</strong> {{ $siswa->kelas->nama_kelas }} ({{ $siswa->kelas->kompetensi_keahlian }})</p>

<hr>

<h4>Bulan Dibayar:</h4>
<ul>
@foreach($bulanDibayar as $bulan)
    <li>{{ $bulan }}</li>
@endforeach
</ul>

<ul>
    <p><strong>Tunggakan:</strong> 
    Rp {{ number_format($tunggakan, 0, ',', '.') }}
</p>

</ul>

<hr>

<p><strong>Total Bayar:</strong> Rp {{ number_format($totalBayar, 0, ',', '.') }}</p>
<p><strong>Petugas:</strong> {{ $p->petugas->nama_petugas ?? '-' }}</p>

