<!DOCTYPE html>
<html>
<head>
    <title>Laporan PPN Masukan</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: left; }
    </style>
</head>
<body>
    <h3>Laporan PPN Masukan dari Pembelian Barang</h3>
    <p>Bulan: {{ $bulan }} / Tahun: {{ $tahun }}</p>

    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Jenis Produk</th>
                <th>PPN</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pengeluaran_barang as $item)
            <tr>
                <td>{{ \Carbon\Carbon::parse($item->tanggal_transaksi)->format('d M Y') }}</td>
                <td>{{ $item->jenis_produk ?? '-' }}</td>
                <td>Rp{{ number_format($item->ppn, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <h4>Total PPN Masukan: Rp{{ number_format($pengeluaran_barang->sum('ppn'), 0, ',', '.') }}</h4>
</body>
</html>