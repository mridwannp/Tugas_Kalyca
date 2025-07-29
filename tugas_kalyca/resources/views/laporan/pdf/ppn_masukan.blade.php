<!DOCTYPE html>
<html>
<head>
    <title>Laporan PPN Masukan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header img {
            width: 60px;
            display: block;
            margin: 0 auto 5px;
        }
        .header h2 {
            margin: 0;
            font-size: 18px;
        }
        h3 {
            text-align: center;
            margin-top: 0;
            margin-bottom: 10px;
        }
        p {
            margin: 4px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        th, td {
            border: 1px solid #000;
            padding: 6px;
            text-align: left;
        }
        .total {
            margin-top: 10px;
            font-weight: bold;
        }
        .footer {
            margin-top: 50px;
            text-align: right;
        }
        .signature {
            margin-top: 60px;
            text-align: right;
        }
        .signature p {
            margin: 0;
        }
    </style>
</head>
<body>

    <div class="header">
        <img src="{{ public_path('shop.png') }}" alt="Logo">
        <h2>Gudang Baju Anak</h2>
    </div>

    <h3>Laporan PPN Masukan</h3>
    <p><strong>Bulan:</strong> {{ $bulan }} / <strong>Tahun:</strong> {{ $tahun }}</p>

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

    <p class="total">Total PPN Masukan: Rp{{ number_format($pengeluaran_barang->sum('ppn'), 0, ',', '.') }}</p>

    <div class="footer">
        <p>Bandung, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
    </div>

    <div class="signature">
        <p>.....................................................</p>
        <p><strong>Tanda Tangan</strong></p>
    </div>

</body>
</html>
