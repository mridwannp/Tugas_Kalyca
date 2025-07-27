<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Selisih PPN</title>
    <style>
        body { font-family: sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: left; }
    </style>
</head>
<body>
    <h2>Laporan Selisih PPN</h2>
    <p>Bulan: {{ $bulan }}, Tahun: {{ $tahun }}</p>

    <table>
        <tr>
            <th>PPN Keluaran (Penjualan)</th>
            <td>Rp{{ number_format($ppnKeluaran, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <th>PPN Masukan (Pembelian)</th>
            <td>Rp{{ number_format($ppnMasukan, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <th>Selisih PPN</th>
            <td>
                Rp{{ number_format($selisih, 0, ',', '.') }}
                @if($selisih > 0)
                    (Harus disetor ke negara)
                @elseif($selisih < 0)
                    (Lebih bayar)
                @else
                    (Nihil)
                @endif
            </td>
        </tr>
    </table>
</body>
</html>
