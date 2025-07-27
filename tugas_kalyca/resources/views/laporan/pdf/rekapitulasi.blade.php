<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Rekapitulasi PPN</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: right; }
        th { background-color: #f2f2f2; text-align: center; }
    </style>
</head>
<body>
    <h2 align="center">Laporan Rekapitulasi PPN</h2>
    <table>
        <thead>
            <tr>
                <th>Total PPN Keluaran</th>
                <th>Total PPN Masukan</th>
                <th>Selisih PPN</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Rp {{ number_format($totalPpnKeluaran, 0, ',', '.') }}</td>
                <td>Rp {{ number_format($totalPpnMasukan, 0, ',', '.') }}</td>
                <td style="color: {{ $selisihPpn < 0 ? 'red' : 'green' }}">
                    Rp {{ number_format($selisihPpn, 0, ',', '.') }}
                </td>
            </tr>
        </tbody>
    </table>
</body>
</html>