@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Edit Pengeluaran</h2>

    <form action="{{ route('pengeluaran.update', $pengeluaran->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Tanggal Transaksi</label>
            <input type="date" name="tanggal_transaksi" class="form-control" value="{{ old('tanggal_transaksi', $pengeluaran->tanggal_transaksi) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Kategori</label>
            <select name="kategori" class="form-control" required>
                <option value="Operasional" {{ old('kategori', $pengeluaran->kategori) == 'Operasional' ? 'selected' : '' }}>Operasional</option>
                <option value="Stok Barang" {{ old('kategori', $pengeluaran->kategori) == 'Stok Barang' ? 'selected' : '' }}>Stok Barang</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Jenis Produk</label>
            <select name="jenis_produk" class="form-control" required>
                <option value="Baju Bayi" {{ old('jenis_produk', $pengeluaran->jenis_produk) == 'Baju Bayi' ? 'selected' : '' }}>Baju Bayi</option>
                <option value="Baju Anak Laki-laki" {{ old('jenis_produk', $pengeluaran->jenis_produk) == 'Baju Anak Laki-laki' ? 'selected' : '' }}>Baju Anak Laki-laki</option>
                <option value="Baju Anak Perempuan" {{ old('jenis_produk', $pengeluaran->jenis_produk) == 'Baju Anak Perempuan' ? 'selected' : '' }}>Baju Anak Perempuan</option>
                <option value="Aksesoris" {{ old('jenis_produk', $pengeluaran->jenis_produk) == 'Aksesoris' ? 'selected' : '' }}>Aksesoris</option>
                <option value="Lainnya" {{ old('jenis_produk', $pengeluaran->jenis_produk) == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Keterangan</label>
            <input type="text" name="keterangan" class="form-control" value="{{ old('keterangan', $pengeluaran->keterangan) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Jumlah Barang</label>
            <input type="number" id="jumlah_barang" name="jumlah_barang" class="form-control" value="{{ old('jumlah_barang', $pengeluaran->jumlah_barang) }}" oninput="hitungTotal()" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Harga Satuan (sebelum PPN)</label>
            <input type="number" id="harga_satuan" name="harga_satuan" class="form-control" value="{{ old('harga_satuan', $pengeluaran->harga_satuan) }}" oninput="hitungTotal()" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Subtotal</label>
            <input type="text" id="subtotal_display" class="form-control" readonly>
            <input type="hidden" id="subtotal" name="subtotal" value="{{ old('subtotal', $pengeluaran->subtotal) }}">
        </div>

        <div class="mb-3">
            <label class="form-label">PPN 12%</label>
            <input type="text" id="ppn_display" class="form-control" readonly>
            <input type="hidden" id="ppn" name="ppn" value="{{ old('ppn', $pengeluaran->ppn) }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Total</label>
            <input type="text" id="total_display" class="form-control" readonly>
            <input type="hidden" id="total" name="total" value="{{ old('total', $pengeluaran->total) }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Metode Pembayaran</label>
            <select name="metode_pembayaran" class="form-control" required>
                <option value="Tunai" {{ old('metode_pembayaran', $pengeluaran->metode_pembayaran) == 'Tunai' ? 'selected' : '' }}>Tunai</option>
                <option value="Transfer" {{ old('metode_pembayaran', $pengeluaran->metode_pembayaran) == 'Transfer' ? 'selected' : '' }}>Transfer</option>
                <option value="QRIS" {{ old('metode_pembayaran', $pengeluaran->metode_pembayaran) == 'QRIS' ? 'selected' : '' }}>QRIS</option>
                <option value="eWallet" {{ old('metode_pembayaran', $pengeluaran->metode_pembayaran) == 'eWallet' ? 'selected' : '' }}>eWallet</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Upload Bukti</label>
            <input type="file" name="bukti" class="form-control">
            @if ($pengeluaran->bukti)
                <small class="text-muted">Bukti saat ini: <a href="{{ asset('storage/' . $pengeluaran->bukti) }}" target="_blank">Lihat</a></small>
            @endif
        </div>

        <div class="mb-3">
            <label class="form-label">Catatan Tambahan</label>
            <textarea name="catatan" class="form-control">{{ old('catatan', $pengeluaran->catatan) }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Update Data</button>
        <a href="{{ route('pengeluaran.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>

<script>
    function hitungTotal() {
        let jumlah = parseFloat(document.getElementById('jumlah_barang').value) || 0;
        let harga = parseFloat(document.getElementById('harga_satuan').value) || 0;

        let subtotal = jumlah * harga;
        let ppn = subtotal * 0.12; // PPN 12%
        let total = subtotal + ppn;

        document.getElementById('subtotal_display').value = subtotal.toLocaleString('id-ID');
        document.getElementById('ppn_display').value = ppn.toLocaleString('id-ID');
        document.getElementById('total_display').value = total.toLocaleString('id-ID');

        document.getElementById('subtotal').value = subtotal;
        document.getElementById('ppn').value = ppn;
        document.getElementById('total').value = total;
    }

    // Jalankan saat halaman dibuka
    window.onload = hitungTotal;
</script>
@endsection
