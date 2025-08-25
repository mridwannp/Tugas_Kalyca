<?php

namespace App\Http\Controllers;

use App\Models\Pengeluaran;
use Illuminate\Http\Request;

class PengeluaranController extends Controller
{
    /**
     * Menampilkan semua data pengeluaran
     */
    public function index()
    {
        $pengeluarans = Pengeluaran::latest()->get();
        return view('pengeluaran.index', compact('pengeluarans'));
    }

    /**
     * Form tambah pengeluaran
     */
    public function create()
    {
        return view('pengeluaran.create');
    }

    /**
     * Simpan data pengeluaran baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'tanggal_transaksi' => 'required|date',
            'nomor_faktur'      => 'nullable|string|max:50',
            'nama_supplier'     => 'nullable|string|max:100',
            'jenis_pengeluaran' => 'required|string|max:100',
            'jumlah'            => 'required|numeric|min:1',
            'harga_satuan'      => 'required|numeric|min:0',
            'harga_sudah_ppn'   => 'nullable|boolean',
            'metode_pembayaran' => 'required|string',
            'catatan'           => 'nullable|string',
            'bukti_transaksi'   => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        // Hitung subtotal
        $subtotal = $request->jumlah * $request->harga_satuan;

        // Hitung PPN
        if ($request->harga_sudah_ppn) {
            $dasar = (100 / 112) * $subtotal;
            $ppn   = 0.12 * $dasar;
            $total = $subtotal;
        } else {
            $ppn   = 0.11 * $subtotal;
            $total = $subtotal + $ppn;
        }

        // Upload bukti transaksi
        $buktiPath = null;
        if ($request->hasFile('bukti_transaksi')) {
            $buktiPath = $request->file('bukti_transaksi')->store('bukti_pengeluaran', 'public');
        }

        Pengeluaran::create([
            'tanggal_transaksi' => $request->tanggal_transaksi,
            'nomor_faktur'      => $request->nomor_faktur,
            'nama_supplier'     => $request->nama_supplier,
            'jenis_pengeluaran' => $request->jenis_pengeluaran,
            'jumlah'            => $request->jumlah,
            'harga_satuan'      => $request->harga_satuan,
            'subtotal'          => $subtotal,
            'ppn'               => $ppn,
            'total'             => $total,
            'harga_sudah_ppn'   => $request->harga_sudah_ppn ?? 0,
            'metode_pembayaran' => $request->metode_pembayaran,
            'catatan'           => $request->catatan,
            'bukti_transaksi'   => $buktiPath,
        ]);

        return redirect()->route('pengeluaran.index')->with('success', 'Data pengeluaran berhasil ditambahkan.');
    }

    /**
     * Form edit pengeluaran
     */
    public function edit(Pengeluaran $pengeluaran)
    {
        return view('pengeluaran.edit', compact('pengeluaran'));
    }

    /**
     * Update pengeluaran
     */
    public function update(Request $request, Pengeluaran $pengeluaran)
    {
        $request->validate([
            'tanggal_transaksi' => 'required|date',
            'nomor_faktur'      => 'nullable|string|max:50',
            'nama_supplier'     => 'nullable|string|max:100',
            'jenis_pengeluaran' => 'required|string|max:100',
            'jumlah'            => 'required|numeric|min:1',
            'harga_satuan'      => 'required|numeric|min:0',
            'harga_sudah_ppn'   => 'nullable|boolean',
            'metode_pembayaran' => 'required|string',
            'catatan'           => 'nullable|string',
            'bukti_transaksi'   => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $subtotal = $request->jumlah * $request->harga_satuan;

        if ($request->harga_sudah_ppn) {
            $dasar = (100 / 112) * $subtotal;
            $ppn   = 0.12 * $dasar;
            $total = $subtotal;
        } else {
            $ppn   = 0.11 * $subtotal;
            $total = $subtotal + $ppn;
        }

        $buktiPath = $pengeluaran->bukti_transaksi;
        if ($request->hasFile('bukti_transaksi')) {
            $buktiPath = $request->file('bukti_transaksi')->store('bukti_pengeluaran', 'public');
        }

        $pengeluaran->update([
            'tanggal_transaksi' => $request->tanggal_transaksi,
            'nomor_faktur'      => $request->nomor_faktur,
            'nama_supplier'     => $request->nama_supplier,
            'jenis_pengeluaran' => $request->jenis_pengeluaran,
            'jumlah'            => $request->jumlah,
            'harga_satuan'      => $request->harga_satuan,
            'subtotal'          => $subtotal,
            'ppn'               => $ppn,
            'total'             => $total,
            'harga_sudah_ppn'   => $request->harga_sudah_ppn ?? 0,
            'metode_pembayaran' => $request->metode_pembayaran,
            'catatan'           => $request->catatan,
            'bukti_transaksi'   => $buktiPath,
        ]);

        return redirect()->route('pengeluaran.index')->with('success', 'Data pengeluaran berhasil diperbarui.');
    }

    /**
     * Hapus data pengeluaran
     */
    public function destroy(Pengeluaran $pengeluaran)
    {
        if ($pengeluaran->bukti_transaksi && \Storage::disk('public')->exists($pengeluaran->bukti_transaksi)) {
            \Storage::disk('public')->delete($pengeluaran->bukti_transaksi);
        }

        $pengeluaran->delete();

        return redirect()->route('pengeluaran.index')->with('success', 'Data pengeluaran berhasil dihapus.');
    }
}
