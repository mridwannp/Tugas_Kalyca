<!DOCTYPE html>
<html>
<head>
    <title>Laporan Per Barang</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #000; padding: 4px; text-align: left; }
        h4, h5 { margin-bottom: 5px; }
    </style>
</head>
<body>
    <h4>Laporan Per Barang - {{ DateTime::createFromFormat('!m', $bulan)->format('F') }} {{ $tahun }}</h4>

    @forelse($data as $jenis => $items)
        <h5>{{ $jenis }}</h5>
        <table>
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Jumlah</th>
                    <th>Harga Satuan</th>
                    <th>Subtotal</th>
                    <th>PPN</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($items as $item)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($item->tanggal_transaksi)->format('d M Y') }}</td>
                        <td>{{ $item->jumlah }}</td>
                        <td>Rp{{ number_format($item->harga_satuan, 0, ',', '.') }}</td>
                        <td>Rp{{ number_format($item->subtotal, 0, ',', '.') }}</td>
                        <td>Rp{{ number_format($item->ppn, 0, ',', '.') }}</td>
                        <td>Rp{{ number_format($item->total, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @empty
        <p>Tidak ada data transaksi untuk bulan ini.</p>
    @endforelse
</body>
</html>
