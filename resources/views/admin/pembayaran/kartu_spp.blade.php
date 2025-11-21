<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>KARTU SPP</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 13px;
        }
        .container {
            width: 90%;
            margin: auto;
            padding: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        th {
            background: #6c87ff;
            color: white;
            padding: 8px;
            text-align: center;
        }
        td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        .belum { color: red; font-weight: bold; }
        h2, h3, p { text-align: center; margin: 4px 0; }
    </style>
</head>
<body>

<div class="container">

    <h2>KARTU SPP</h2>
    <h3>SMK TI PEMBANGUNAN CIMAHI</h3>
    <p>JL. H. Bakar No. 18 B / JL. Ciseupan Kota Cimahi<br>085293393191</p>
    <hr>

    <table style="margin-top: 10px">
        <tr>
            <td width="20%">NIS</td>
            <td>: {{ $siswa->nis }}</td>
        </tr>
        <tr>
            <td>Nama</td>
            <td>: {{ $siswa->nama }}</td>
        </tr>
        <tr>
            <td>Kelas</td>
            <td>: {{ $siswa->kelas->nama_kelas }}</td>
        </tr>
    </table>

    <table>
        <thead>
            <tr>
                <th>Bulan</th>
                <th>Jumlah</th>
                <th>Tanggal Bayar</th>
                <th>Petugas</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($urutanBulan as $bulan)
                @php
                    $data = $pembayaran->get($bulan);
                @endphp

                <tr>
                    <td>{{ $bulan }}</td>

                    <td>
                          @if ($data)
                              Rp{{ number_format($data->jumlah_bayar, 0, ',', '.') }}
                          @else
                              -
                          @endif
                  </td>

                    <td>
                        @if ($data)
                            {{ \Carbon\Carbon::parse($data->tgl_bayar)->format('d/m/Y') }}
                        @else
                            <span class="belum">Belum Bayar</span>
                        @endif
                    </td>

                    <td>
                        @if ($data)
                            {{ $data->petugas->nama_petugas }}
                        @else
                            -
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

</div>

</body>
</html>
