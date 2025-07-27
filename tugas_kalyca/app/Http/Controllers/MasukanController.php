<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Masukan;
use Illuminate\Support\Facades\Storage;

class MasukanController extends Controller
{
    public function index()
    {
        $masukan = Masukan::latest()->get();
        return view('masukan.index', compact('masukan'));
    }

    public function create()
    {
        return view('masukan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal_transaksi'   => 'required|date',
            'jenis_produk'        => 'required|string',
            'jumlah'              => 'required|numeric',
            'harga_satuan'        => 'required|numeric',
            'metode_pembayaran'   => 'required|string',
            'bukti'               => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        // Hitung subtotal, PPN, dan total
        $subtotal = ($request->jumlah ?? 0) * ($request->harga_satuan ?? 0);
        $ppn = $subtotal > 0 ? $subtotal * 0.11 : 0;
        $total = $subtotal + $ppn;

        $masukan = new Masukan();
        $masukan->tanggal_transaksi = $request->tanggal_transaksi;
        $masukan->nomor_faktur = $request->nomor_faktur;
        $masukan->nama_pelanggan = $request->nama_pelanggan;
        $masukan->jenis_produk = $request->jenis_produk;
        $masukan->jumlah = $request->jumlah;
        $masukan->harga_satuan = $request->harga_satuan;
        $masukan->subtotal = $subtotal;
        $masukan->ppn = $ppn;
        $masukan->total = $total;
        $masukan->metode_pembayaran = $request->metode_pembayaran;
        $masukan->catatan = $request->catatan;

        if ($request->hasFile('bukti')) {
            $path = $request->file('bukti')->store('bukti_transaksi', 'public');
            $masukan->bukti = $path;
        }

        $masukan->save();

        return redirect()->route('masukan.index')->with('success', 'Data berhasil disimpan.');
    }

    public function show($id)
    {
        $masukan = Masukan::findOrFail($id);
        return view('masukan.show', compact('masukan'));
    }

    public function edit($id)
    {
        $masukan = Masukan::findOrFail($id);
        return view('masukan.edit', compact('masukan'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tanggal_transaksi'   => 'required|date',
            'jenis_produk'        => 'required|string',
            'jumlah'              => 'required|numeric',
            'harga_satuan'        => 'required|numeric',
            'metode_pembayaran'   => 'required|string',
            'bukti'               => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $masukan = Masukan::findOrFail($id);

        $subtotal = ($request->jumlah ?? 0) * ($request->harga_satuan ?? 0);
        $ppn = $subtotal > 0 ? $subtotal * 0.11 : 0;
        $total = $subtotal + $ppn;

        $masukan->tanggal_transaksi = $request->tanggal_transaksi;
        $masukan->nomor_faktur = $request->nomor_faktur;
        $masukan->nama_pelanggan = $request->nama_pelanggan;
        $masukan->jenis_produk = $request->jenis_produk;
        $masukan->jumlah = $request->jumlah;
        $masukan->harga_satuan = $request->harga_satuan;
        $masukan->subtotal = $subtotal;
        $masukan->ppn = $ppn;
        $masukan->total = $total;
        $masukan->metode_pembayaran = $request->metode_pembayaran;
        $masukan->catatan = $request->catatan;

        if ($request->hasFile('bukti')) {
            if ($masukan->bukti) {
                Storage::disk('public')->delete($masukan->bukti);
            }

            $path = $request->file('bukti')->store('bukti_transaksi', 'public');
            $masukan->bukti = $path;
        }

        $masukan->save();

        return redirect()->route('masukan.index')->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $masukan = Masukan::findOrFail($id);

        if ($masukan->bukti) {
            Storage::disk('public')->delete($masukan->bukti);
        }

        $masukan->delete();

        return redirect()->route('masukan.index')->with('success', 'Data berhasil dihapus.');
    }
}