@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Masukan</h1>

    <form action="{{ route('masukan.update', $masukan->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="tanggal_transaksi" class="form-label">Tanggal Transaksi</label>
            <input type="date" name="tanggal_transaksi" class="form-control" value="{{ $masukan->tanggal_transaksi }}" required>
        </div>

        <div class="mb-3">
            <label for="nomor_faktur" class="form-label">Nomor Faktur (Opsional)</label>
            <input type="text" name="nomor_faktur" class="form-control" value="{{ $masukan->nomor_faktur }}">
        </div>

        <div class="mb-3">
            <label for="nama_pelanggan" class="form-label">Nama Pelanggan (Opsional)</label>
            <input type="text" name="nama_pelanggan" class="form-control" value="{{ $masukan->nama_pelanggan }}">
        </div>

        <div class="mb-3">
            <label for="jenis_produk" class="form-label">Jenis Produk</label>
            <select name="jenis_produk" class="form-control" required>
                <option value="">-- Pilih Jenis Produk --</option>
                <option value="Baju Bayi" {{ $masukan->jenis_produk == 'Baju Bayi' ? 'selected' : '' }}>Baju Bayi</option>
                <option value="Baju Anak Laki-laki" {{ $masukan->jenis_produk == 'Baju Anak Laki-laki' ? 'selected' : '' }}>Baju Anak Laki-laki</option>
                <option value="Baju Anak Perempuan" {{ $masukan->jenis_produk == 'Baju Anak Perempuan' ? 'selected' : '' }}>Baju Anak Perempuan</option>
                <option value="Aksesoris" {{ $masukan->jenis_produk == 'Aksesoris' ? 'selected' : '' }}>Aksesoris</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="jumlah" class="form-label">Jumlah Barang Terjual</label>
            <input type="number" name="jumlah" class="form-control" id="jumlah" value="{{ $masukan->jumlah }}" required>
        </div>

        <div class="mb-3">
            <label for="harga_satuan" class="form-label">Harga Satuan (sebelum PPN)</label>
            <input type="number" name="harga_satuan" class="form-control" id="harga_satuan" value="{{ $masukan->harga_satuan }}" required>
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
                <option value="Tunai" {{ $masukan->metode_pembayaran == 'Tunai' ? 'selected' : '' }}>Tunai</option>
                <option value="Transfer" {{ $masukan->metode_pembayaran == 'Transfer' ? 'selected' : '' }}>Transfer</option>
                <option value="QRIS" {{ $masukan->metode_pembayaran == 'QRIS' ? 'selected' : '' }}>QRIS</option>
                <option value="eWallet" {{ $masukan->metode_pembayaran == 'eWallet' ? 'selected' : '' }}>eWallet</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="catatan" class="form-label">Catatan Tambahan</label>
            <textarea name="catatan" class="form-control" rows="3">{{ $masukan->catatan }}</textarea>
        </div>

        <div class="mb-3">
            <label for="bukti" class="form-label">Upload Bukti Transaksi</label>
            @if ($masukan->bukti)
                <p><a href="{{ asset('storage/'.$masukan->bukti) }}" target="_blank">Lihat Bukti</a></p>
            @endif
            <input type="file" name="bukti" class="form-control">
        </div>

        <button type="submit" class="btn btn-success">Update</button>
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
    window.addEventListener('load', calculate); // Hitung otomatis saat form dibuka
</script>
@endsection
