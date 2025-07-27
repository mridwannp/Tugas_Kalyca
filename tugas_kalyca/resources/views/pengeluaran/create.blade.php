@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Tambah Data Pengeluaran</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('pengeluaran.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label class="form-label">Tanggal Transaksi</label>
            <input type="date" name="tanggal_transaksi" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Kategori</label>
            <select name="kategori" class="form-control" required>
                <option value="Operasional">Operasional</option>
                <option value="Stok Barang">Stok Barang</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Jenis Produk</label>
            <select name="jenis_produk" class="form-control" required>
                <option value="Baju Bayi">Baju Bayi</option>
                <option value="Baju Anak Laki-laki">Baju Anak Laki-laki</option>
                <option value="Baju Anak Perempuan">Baju Anak Perempuan</option>
                <option value="Aksesoris">Aksesoris</option>
                <option value="Lainnya">Lainnya</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Keterangan</label>
            <input type="text" name="keterangan" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Jumlah Barang</label>
            <input type="number" id="jumlah_barang" name="jumlah_barang" class="form-control" oninput="hitungTotal()" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Harga Satuan (sebelum PPN)</label>
            <input type="number" id="harga_satuan" name="harga_satuan" class="form-control" oninput="hitungTotal()" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Subtotal</label>
            <input type="text" id="subtotal_display" class="form-control" readonly>
            <input type="hidden" id="subtotal" name="subtotal">
        </div>

        <div class="mb-3">
            <label class="form-label">PPN 12%</label>
            <input type="text" id="ppn_display" class="form-control" readonly>
            <input type="hidden" id="ppn" name="ppn">
        </div>

        <div class="mb-3">
            <label class="form-label">Total</label>
            <input type="text" id="total_display" class="form-control" readonly>
            <input type="hidden" id="total" name="total">
        </div>

        <div class="mb-3">
            <label class="form-label">Metode Pembayaran</label>
            <select name="metode_pembayaran" class="form-control" required>
                <option value="Tunai">Tunai</option>
                <option value="Transfer">Transfer</option>
                <option value="QRIS">QRIS</option>
                <option value="eWallet">eWallet</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Upload Bukti</label>
            <input type="file" name="bukti" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">Catatan Tambahan (Opsional)</label>
            <textarea name="catatan" class="form-control"></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
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
</script>
@endsection
