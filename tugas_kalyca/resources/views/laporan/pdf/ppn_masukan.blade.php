<!DOCTYPE html>
<html>
<head>
    <title>Laporan PPN Masukan</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; margin: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: left; }
        .header { text-align: center; margin-bottom: 10px; }
        .header img { width: 60px; }
        .header h2 { margin: 4px 0 0 0; font-size: 16px; }
        .footer { margin-top: 60px; text-align: right; }
        .signature { margin-top: 60px; text-align: right; }
        .signature p { margin-bottom: 60px; }
    </style>
</head>
<body>

    <div class="header">
        <img src="https://img.icons8.com/color/96/shop.png" alt="Toko Kalyca">
        <h2>Gudang Baju Anak</h2>
    </div>

    <h3>Laporan PPN Masukan</h3>
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

    <div class="footer">
        <p>Kota, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
        <div class="signature">
            <p>.....................................................</p>
            <p>Tanda Tangan</p>
        </div>
    </div>

</body>
</html>
