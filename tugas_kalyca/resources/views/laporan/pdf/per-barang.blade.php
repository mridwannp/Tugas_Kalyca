<!DOCTYPE html>
<html>
<head>
    <title>Laporan Per Barang</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #000; padding: 4px; text-align: left; }
        h4 { margin-bottom: 5px; }
        .logo { width: 100px; margin-bottom: 10px; }
        .text-center { text-align: center; }
        .signature {
            width: 200px;
            float: right;
            text-align: center;
            margin-top: 40px;
        }
    </style>
</head>
<body>
    <!-- Logo -->
    <div class="text-center">
        <img src="{{ public_path('logo.png') }}" class="logo">
    </div>

    <h4 class="text-center">Laporan Per Barang - {{ DateTime::createFromFormat('!m', $bulan)->format('F') }} {{ $tahun }}</h4>

    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Jenis Produk</th>
                <th>Jumlah</th>
                <th>Harga Satuan</th>
                <th>Subtotal</th>
                <th>PPN</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @forelse($data as $jenis => $items)
                @foreach($items as $item)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($item->tanggal_transaksi)->format('d M Y') }}</td>
                        <td>{{ $jenis }}</td>
                        <td>{{ $item->jumlah }}</td>
                        <td>Rp{{ number_format($item->harga_satuan, 0, ',', '.') }}</td>
                        <td>Rp{{ number_format($item->subtotal, 0, ',', '.') }}</td>
                        <td>Rp{{ number_format($item->ppn, 0, ',', '.') }}</td>
                        <td>Rp{{ number_format($item->total, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            @empty
                <tr>
                    <td colspan="7" class="text-center">Tidak ada data transaksi untuk bulan ini.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Tanda Tangan -->
    <div class="footer">
        <p>Bandung, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
    </div>

    <div class="signature">
        <p>.....................................................</p>
        <p><strong>Tanda Tangan</strong></p>
    </div>
</body>
</html>
