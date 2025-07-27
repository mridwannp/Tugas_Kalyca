<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan PPN Keluaran</title>
    <style>
        body { font-family: sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: left; }
    </style>
</head>
<body>
    <h2>Laporan PPN Keluaran</h2>
    <p>Bulan: {{ $bulan }}, Tahun: {{ $tahun }}</p>

    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Jenis Produk</th>
                <th>PPN</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($masukan as $item)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($item->tanggal_transaksi)->format('d M Y') }}</td>
                    <td>{{ $item->jenis_produk ?? '-' }}</td>
                    <td>Rp{{ number_format($item->ppn, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h4 style="text-align:right; margin-top: 20px;">
        Total PPN Keluaran: Rp{{ number_format($masukan->sum('ppn'), 0, ',', '.') }}
    </h4>
</body>
</html>