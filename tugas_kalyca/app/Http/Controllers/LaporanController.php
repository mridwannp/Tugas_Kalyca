<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Masukan;
use App\Models\Pengeluaran;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        // Ambil bulan dan tahun dari request atau default ke saat ini
        $bulan = $request->input('bulan', date('m'));
        $tahun = $request->input('tahun', date('Y'));

        // Buat tanggal awal dan akhir dari bulan + tahun tersebut
        $tanggal_awal = Carbon::createFromDate($tahun, $bulan, 1)->startOfMonth()->format('Y-m-d');
        $tanggal_akhir = Carbon::createFromDate($tahun, $bulan, 1)->endOfMonth()->format('Y-m-d');

        // Ambil masukan (penjualan) pada bulan dan tahun tersebut
        $masukan = Masukan::whereDate('tanggal_transaksi', '>=', $tanggal_awal)
            ->whereDate('tanggal_transaksi', '<=', $tanggal_akhir)
            ->get();

        // Ambil semua pengeluaran
        $pengeluaran = Pengeluaran::whereDate('tanggal_transaksi', '>=', $tanggal_awal)
            ->whereDate('tanggal_transaksi', '<=', $tanggal_akhir)
            ->get();

        // Pengeluaran khusus kategori "barang"
       $pengeluaran_barang = Pengeluaran::whereDate('tanggal_transaksi', '>=', $tanggal_awal)
            ->whereDate('tanggal_transaksi', '<=', $tanggal_akhir)
            ->where('kategori', 'Stok Barang') // BENAR
            ->get();

        return view('laporan.index', compact(
            'masukan',
            'pengeluaran',
            'pengeluaran_barang',
            'bulan',
            'tahun'
        ));
    }

    public function cetakPpnMasukan(Request $request)
    {
        $bulan = str_pad($request->input('bulan', date('m')), 2, '0', STR_PAD_LEFT);
        $tahun = $request->input('tahun', date('Y'));
    
        $pengeluaran_barang = Pengeluaran::whereMonth('tanggal_transaksi', $bulan)
            ->whereYear('tanggal_transaksi', $tahun)
            ->get();
    
        if ($pengeluaran_barang->isEmpty()) {
            return back()->with('error', 'Tidak ada data pengeluaran stok barang untuk bulan dan tahun ini.');
        }
    
        $pdf = PDF::loadView('laporan.pdf.ppn_masukan', compact('pengeluaran_barang', 'bulan', 'tahun'));
        return $pdf->download("laporan-ppn-masukan-{$bulan}-{$tahun}.pdf");
    }

    public function cetakPpnKeluaran(Request $request)
    {
        $bulan = $request->input('bulan', date('m'));
        $tahun = $request->input('tahun', date('Y'));

        $masukan = Masukan::whereMonth('tanggal_transaksi', $bulan)
            ->whereYear('tanggal_transaksi', $tahun)
            ->get();

        $pdf = PDF::loadView('laporan.pdf.ppn_keluaran', compact('masukan', 'bulan', 'tahun'));
        return $pdf->download("laporan-ppn-keluaran-{$bulan}-{$tahun}.pdf");
    }

    public function cetakSelisihPpn(Request $request)
    {
        $bulan = $request->input('bulan', date('m'));
        $tahun = $request->input('tahun', date('Y'));

        $ppnKeluaran = Masukan::whereMonth('tanggal_transaksi', $bulan)
            ->whereYear('tanggal_transaksi', $tahun)
            ->sum('ppn');

        $ppnMasukan = Pengeluaran::whereMonth('tanggal_transaksi', $bulan)
            ->whereYear('tanggal_transaksi', $tahun)
            ->sum('ppn');

        $selisih = $ppnKeluaran - $ppnMasukan;

        $pdf = PDF::loadView('laporan.pdf.selisih_ppn', compact('ppnKeluaran', 'ppnMasukan', 'selisih', 'bulan', 'tahun'));
        return $pdf->download("laporan-selisih-ppn-{$bulan}-{$tahun}.pdf");
    }

    public function viewPerBarang(Request $request)
    {
        $bulan = $request->bulan ?? date('m');
        $tahun = $request->tahun ?? date('Y');

        $data = Masukan::whereMonth('tanggal_transaksi', $bulan)
            ->whereYear('tanggal_transaksi', $tahun)
            ->get()
            ->groupBy('jenis_produk');

        return view('laporan.per-barang', compact('data', 'bulan', 'tahun'));
    }


    public function cetakPerBarang(Request $request)
    {
        $bulan = $request->get('bulan', date('m'));
        $tahun = $request->get('tahun', date('Y'));

        // Ambil data sama seperti view biasa
        $masukan = \App\Models\Masukan::whereMonth('tanggal_transaksi', $bulan)
            ->whereYear('tanggal_transaksi', $tahun)
            ->get();

        $data = $masukan->groupBy('jenis_produk');

        $pdf = Pdf::loadView('laporan.pdf.per-barang', compact('data', 'bulan', 'tahun'));
        return $pdf->stream('laporan-per-barang.pdf');
    }

    public function cetakRekapitulasi(Request $request)
    {
        $masukan = Masukan::all();
        $pengeluaran = Pengeluaran::all();
        $pengeluaran_barang = Pengeluaran::where('kategori', 'Stok Barang')->get();

        $totalPpnKeluaran = $masukan->sum('ppn');
        $totalPpnMasukan = $pengeluaran->sum('ppn') + $pengeluaran_barang->sum('ppn');
        $selisihPpn = $totalPpnKeluaran - $totalPpnMasukan;

        $pdf = Pdf::loadView('laporan.pdf.rekapitulasi', compact(
            'totalPpnKeluaran',
            'totalPpnMasukan',
            'selisihPpn'
        ));

        return $pdf->download('laporan-rekapitulasi-ppn.pdf');
    }
}
