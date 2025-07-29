<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Selisih PPN</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; margin: 40px; }
        h2, h4, p { text-align: center; margin: 4px 0; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: left; }
        .logo { text-align: center; margin-bottom: 10px; }
        .logo img { width: 60px; }
        .footer { margin-top: 60px; width: 100%; }
        .footer-right { text-align: right; }
        .signature { margin-top: 60px; text-align: right; }
    </style>
</head>
<body>

    <div class="logo">
        <img src="{{ public_path('logo.png') }}" alt="Logo">
        <h4>Gudang Baju Anak</h4>
    </div>

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

    <div class="footer">
        <div class="footer-right">
            <p>Bandung, {{ \Carbon\Carbon::parse($tanggal)->translatedFormat('d F Y') }}</p>
            <div class="signature">Tanda Tangan: ____________________</div>
        </div>
    </div>

</body>
</html>
