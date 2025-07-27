@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Tambah Masukan</h1>

    <form action="{{ route('masukan.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label for="tanggal_transaksi" class="form-label">Tanggal Transaksi</label>
            <input type="date" name="tanggal_transaksi" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="nomor_faktur" class="form-label">Nomor Faktur (Opsional)</label>
            <input type="text" name="nomor_faktur" class="form-control">
        </div>

        <div class="mb-3">
            <label for="nama_pelanggan" class="form-label">Nama Pelanggan (Opsional)</label>
            <input type="text" name="nama_pelanggan" class="form-control">
        </div>

        <div class="mb-3">
            <label for="jenis_produk" class="form-label">Jenis Produk</label>
            <select name="jenis_produk" class="form-control" required>
                <option value="">-- Pilih Jenis Produk --</option>
                <option value="Baju Bayi">Baju Bayi</option>
                <option value="Baju Anak Laki-laki">Baju Anak Laki-laki</option>
                <option value="Baju Anak Perempuan">Baju Anak Perempuan</option>
                <option value="Aksesoris">Aksesoris</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="jumlah" class="form-label">Jumlah Barang Terjual</label>
            <input type="number" name="jumlah" class="form-control" id="jumlah" required>
        </div>

        <div class="mb-3">
            <label for="harga_satuan" class="form-label">Harga Satuan (sebelum PPN)</label>
            <input type="number" name="harga_satuan" class="form-control" id="harga_satuan" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Subtotal</label>
            <input type="text" class="form-control" id="subtotal" disabled>
        </div>

        <div class="mb-3">
            <label class="form-label">PPN (12%)</label>
            <input type="text" class="form-control" id="ppn" disabled>
        </div>

        <div class="mb-3">
            <label class="form-label">Total</label>
            <input type="text" class="form-control" id="total" disabled>
        </div>

        <div class="mb-3">
            <label for="metode_pembayaran" class="form-label">Metode Pembayaran</label>
            <select name="metode_pembayaran" class="form-control" required>
                <option value="">-- Pilih Metode Pembayaran --</option>
                <option value="Tunai">Tunai</option>
                <option value="Transfer">Transfer</option>
                <option value="QRIS">QRIS</option>
                <option value="eWallet">eWallet</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="catatan" class="form-label">Catatan Tambahan</label>
            <textarea name="catatan" class="form-control" rows="3"></textarea>
        </div>

        <div class="mb-3">
            <label for="bukti" class="form-label">Upload Bukti Transaksi</label>
            <input type="file" name="bukti" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>

<script>
    function calculate() {
        const jumlah = parseFloat(document.getElementById('jumlah').value) || 0;
        const harga = parseFloat(document.getElementById('harga_satuan').value) || 0;
        const subtotal = jumlah * harga;
        const ppn = subtotal * 0.12; // PPN 12%
        const total = subtotal + ppn;

        document.getElementById('subtotal').value = subtotal.toLocaleString('id-ID');
        document.getElementById('ppn').value = ppn.toLocaleString('id-ID');
        document.getElementById('total').value = total.toLocaleString('id-ID');
    }

    document.getElementById('jumlah').addEventListener('input', calculate);
    document.getElementById('harga_satuan').addEventListener('input', calculate);
</script>
@endsection
