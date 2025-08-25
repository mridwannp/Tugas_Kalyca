<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengeluaran;

class PengeluaranController extends Controller
{
    public function index()
    {
        $keluarans = Pengeluaran::latest()->paginate(10);
        return view('pengeluaran.index', compact('keluarans'));
    }

    public function create()
    {
        return view('pengeluaran.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'tanggal_transaksi' => 'required|date',
            'kategori' => 'required|string',
            'jenis_produk' => 'required|string',
            'keterangan' => 'nullable|string',
            'jumlah_barang' => 'nullable|integer',
            'harga_satuan' => 'nullable|numeric',
            'metode_pembayaran' => 'required|string',
            'catatan' => 'nullable|string',
            'bukti' => 'nullable|image|max:2048'
        ]);

        // Hitung subtotal dan PPN
        $subtotal = ($data['jumlah_barang'] ?? 0) * ($data['harga_satuan'] ?? 0);
        $ppn = $subtotal > 0 ? $subtotal * 0.11 : 0;
        $total = $subtotal + $ppn;

        $data['subtotal'] = $subtotal;
        $data['ppn'] = $ppn;
        $data['total'] = $total;

        if ($request->hasFile('bukti')) {
            $data['bukti'] = $request->file('bukti')->store('bukti_pengeluaran', 'public');
        }

        Pengeluaran::create($data);

        return redirect()->route('pengeluaran.index')->with('success', 'Data pengeluaran berhasil disimpan.');
    }

    public function edit($id)
    {
        $pengeluaran = Pengeluaran::findOrFail($id);
        return view('pengeluaran.edit', compact('pengeluaran'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'tanggal_transaksi' => 'required|date',
            'kategori' => 'required|string',
            'jenis_produk' => 'required|string',
            'keterangan' => 'nullable|string',
            'jumlah_barang' => 'nullable|integer',
            'harga_satuan' => 'nullable|numeric',
            'metode_pembayaran' => 'required|string',
            'catatan' => 'nullable|string',
            'bukti' => 'nullable|image|max:2048'
        ]);

        $pengeluaran = Pengeluaran::findOrFail($id);

        $subtotal = ($data['jumlah_barang'] ?? 0) * ($data['harga_satuan'] ?? 0);
        $ppn = $subtotal * 0.11;
        $total = $subtotal + $ppn;

        $data['subtotal'] = $subtotal;
        $data['ppn'] = $ppn;
        $data['total'] = $total;

        if ($request->hasFile('bukti')) {
            $data['bukti'] = $request->file('bukti')->store('bukti_pengeluaran', 'public');
        }

        $pengeluaran->update($data);

        return redirect()->route('pengeluaran.index')->with('success', 'Data pengeluaran berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $pengeluaran = Pengeluaran::findOrFail($id);

        if ($pengeluaran->bukti && \Storage::disk('public')->exists($pengeluaran->bukti)) {
            \Storage::disk('public')->delete($pengeluaran->bukti);
        }

        $pengeluaran->delete();

        return redirect()->route('pengeluaran.index')->with('success', 'Data pengeluaran berhasil dihapus.');
    }
}
