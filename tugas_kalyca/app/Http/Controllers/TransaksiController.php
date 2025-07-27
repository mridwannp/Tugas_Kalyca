<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    public function index()
    {
        $transaksis = Transaksi::latest()->get();
        return view('transaksi.index', compact('transaksis'));
    }

    public function create()
    {
        return view('transaksi.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'tipe' => 'required',
            'nama_barang' => 'required',
            'jumlah' => 'required|integer',
            'harga_satuan' => 'required|numeric',
            'bukti' => 'nullable|image|max:2048',
        ]);

        $dasar = $request->harga_satuan * $request->jumlah;
        if ($request->has('ppn_termasuk')) {
            $dasar = 100 / 112 * $dasar;
        }

        $ppn = $request->has('ppn_termasuk') ? 0.12 * $dasar : 0;

        $total = $dasar + $ppn;

        $path = null;
        if ($request->hasFile('bukti')) {
            $path = $request->file('bukti')->store('bukti', 'public');
        }

        Transaksi::create([
            'tanggal' => $request->tanggal,
            'tipe' => $request->tipe,
            'nama_barang' => $request->nama_barang,
            'jumlah' => $request->jumlah,
            'harga_satuan' => $request->harga_satuan,
            'ppn_termasuk' => $request->has('ppn_termasuk'),
            'ppn' => $ppn,
            'total' => $total,
            'bukti' => $path,
        ]);

        return redirect()->route('transaksi.index')->with('success', 'Data berhasil disimpan!');
    }
}
