<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Pembayaran SPP</title>

    <style>
        body {
            font-family: sans-serif;
            margin: 20px;
            font-size: 13px;
        }

        h2 {
            text-align: center;
            margin-bottom: 10px;
            font-weight: bold;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th {
            background: #f3f4f6;
            font-weight: bold;
            padding: 6px;
            border-bottom: 2px solid #d1d5db;
            text-align: center;
        }

        td {
            padding: 6px;
            text-align: center;
            border-bottom: 1px solid #e5e7eb;
        }

        /* Style mirip Tailwind */
        .text-left { text-align: left; }
        .text-right { text-align: right; }
    </style>
</head>
<body>

    <h2>Laporan Pembayaran SPP Kelas {{ $kelas->nama_kelas }}</h2>

    <table class="w-full border-collapse text-xs">
    <thead>
        <tr class="border-b">
            <th class="py-2">NIS</th>
            <th class="py-2 text-left">Nama</th>

            @foreach($bulanList as $bl)
                <th class="py-2">{{ $bl }}</th>
            @endforeach

            <th class="py-2">Total</th>
            <th class="py-2">Tunggakan</th>
        </tr>
    </thead>

    <tbody>
        @foreach($siswa as $s)
        <tr class="border-b">
            <td class="py-1 text-center">{{ $s->nis }}</td>
            <td class="py-1 text-left">{{ $s->nama }}</td>

            @foreach($bulanList as $bl)
            <td class="py-1 text-right">
                @if($s->detail_bulan[$bl] > 0)
                    Rp {{ number_format($s->detail_bulan[$bl], 0, ',', '.') }}
                @else
                    -
                @endif
            </td>
            @endforeach

            <td class="py-1 text-right">Rp {{ number_format($s->totalBayar,0,',','.') }}</td>
            <td class="py-1 text-right">Rp {{ number_format($s->tunggakan,0,',','.') }}</td>
        </tr>
        @endforeach
    </tbody>
</table>


</body>
</html>
