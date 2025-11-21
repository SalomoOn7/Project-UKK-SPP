<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>KUITANSI PEMBAYARAN SPP</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        .container {
            padding: 25px;
            border: 1px solid #aaa;
            border-radius: 10px;
            width: 700px;
            margin: auto;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        th, td {
            padding: 6px;
            border-bottom: 1px solid #ddd;
        }
        th {
            text-align: left;
            font-weight: bold;
        }
        .title {
            text-align: center;
            margin-bottom: 10px;
        }
        .total-row td {
            font-weight: bold;
        }
        .right { text-align: right; }
    </style>
</head>
<body>

<div class="container">

    <h2 class="title">PEMBAYARAN SPP</h2>
    <p class="title">{{ $hariTanggal }}</p>

    <table>
        <tr>
            <th>NISN</th><td>: {{ $siswa->nisn }}</td>
            <th>Nama</th><td>: {{ $siswa->nama }}</td>
        </tr>
        <tr>
            <th>Kelas</th><td>: {{ $siswa->kelas->nama_kelas }}</td>
            <th>&nbsp;</th><td>&nbsp;</td> <!-- Kosongkan untuk rapi -->
        </tr>
    </table>

    <hr><br>

    <table>
        <thead>
            <tr>
                <th>Tahun</th>
                <th>Tanggal Bayar</th> 
                <th>Bulan</th>
                <th>Nominal</th>
            </tr>
        </thead>

        <tbody>
            @foreach($pembayaran as $pay)
            <tr>
                <td>{{ $pay->tahun_dibayar }}</td>
                 <td>{{ \Carbon\Carbon::parse($pay->tgl_bayar)->format('Y-m-d') }}</td>
                <td>{{ $pay->bulan_dibayar }}</td>
                <td>Rp {{ number_format($pay->jumlah_bayar, 0, ',', '.') }}</td>
               
            </tr>
            @endforeach

            <tr class="total-row">
                <td colspan="3">Total Bayar</td>
                <td>Rp {{ number_format($totalBayar, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    <br><br>

    <p class="right">Petugas: {{ $p->petugas->nama_petugas ?? '-' }}</p>

</div>

</body>
</html>
