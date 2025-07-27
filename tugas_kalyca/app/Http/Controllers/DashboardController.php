<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Masukan;
use App\Models\Pengeluaran;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $bulanSekarang = Carbon::now()->month;
        $tahunSekarang = Carbon::now()->year;

        // Ringkasan bulan ini
        $totalMasukan = Masukan::whereMonth('tanggal_transaksi', $bulanSekarang)
            ->whereYear('tanggal_transaksi', $tahunSekarang)
            ->sum('total');

        $totalPengeluaran = Pengeluaran::whereMonth('tanggal_transaksi', $bulanSekarang)
            ->whereYear('tanggal_transaksi', $tahunSekarang)
            ->sum('total');

        $saldo = $totalMasukan - $totalPengeluaran;

        // Data untuk grafik 6 bulan terakhir
        $bulanLabels = [];
        $masukanData = [];
        $pengeluaranData = [];

        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->startOfMonth()->subMonths($i);
            $label = $date->translatedFormat('M Y');
            $bulanLabels[] = $label;

            $masukan = DB::table('masukan')
                ->whereMonth('tanggal_transaksi', $date->month)
                ->whereYear('tanggal_transaksi', $date->year)
                ->sum('total');

            $pengeluaran = DB::table('pengeluarans')
                ->whereMonth('tanggal_transaksi', $date->month)
                ->whereYear('tanggal_transaksi', $date->year)
                ->sum('total');

            $masukanData[] = $masukan;
            $pengeluaranData[] = $pengeluaran;
        }

        return view('dashboard', compact(
            'totalMasukan',
            'totalPengeluaran',
            'saldo',
            'bulanLabels',
            'masukanData',
            'pengeluaranData'
        ));
    }

    public function filter(Request $request)
    {
        $filter = $request->input('filter');
        $start = $request->input('start');
        $end = $request->input('end');

        // Ambil data sesuai filter: harian, mingguan, bulanan, custom
        [$labels, $masukanData, $pengeluaranData] = $this->getChartData($filter, $start, $end);

        return response()->json([
            'labels' => $labels,
            'masukanData' => $masukanData,
            'pengeluaranData' => $pengeluaranData
        ]);
    }

    private function getChartData($filter, $start = null, $end = null)
    {
        $labels = [];
        $masukanData = [];
        $pengeluaranData = [];

        if ($filter === 'harian') {
            $tanggal = Carbon::today();
            $labels[] = $tanggal->translatedFormat('d M');
            $masukan = Masukan::whereDate('tanggal_transaksi', $tanggal)->sum('total');
            $pengeluaran = Pengeluaran::whereDate('tanggal_transaksi', $tanggal)->sum('total');
            $masukanData[] = $masukan;
            $pengeluaranData[] = $pengeluaran;

        } elseif ($filter === 'mingguan') {
            $startDate = Carbon::now()->startOfWeek();
            for ($i = 0; $i < 7; $i++) {
                $date = $startDate->copy()->addDays($i);
                $labels[] = $date->translatedFormat('D'); // Misal: Sen, Sel, Rab
                $masukanData[] = Masukan::whereDate('tanggal_transaksi', $date)->sum('total');
                $pengeluaranData[] = Pengeluaran::whereDate('tanggal_transaksi', $date)->sum('total');
            }

        } elseif ($filter === 'bulanan') {
            $startDate = Carbon::now()->startOfMonth();
            $endDate = Carbon::now()->endOfMonth();
            $period = \Carbon\CarbonPeriod::create($startDate, $endDate);
            $labels[] = Carbon::now()->translatedFormat('M'); // Contoh: "Jul"
            $masukanData[] = Masukan::whereMonth('tanggal_transaksi', Carbon::now()->month)
                ->whereYear('tanggal_transaksi', Carbon::now()->year)
                ->sum('total');

            $pengeluaranData[] = Pengeluaran::whereMonth('tanggal_transaksi', Carbon::now()->month)
                ->whereYear('tanggal_transaksi', Carbon::now()->year)
                ->sum('total');

        } elseif ($filter === 'custom' && $start && $end) {
            $startDate = Carbon::parse($start);
            $endDate = Carbon::parse($end);
            $period = \Carbon\CarbonPeriod::create($startDate, $endDate);
            foreach ($period as $date) {
                $labels[] = $date->format('d M');
                $masukanData[] = Masukan::whereDate('tanggal_transaksi', $date)->sum('total');
                $pengeluaranData[] = Pengeluaran::whereDate('tanggal_transaksi', $date)->sum('total');
            }
        }
        return [$labels, $masukanData, $pengeluaranData];
    }
}