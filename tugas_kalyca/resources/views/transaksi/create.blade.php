@extends('layouts.app')

@section('content')
<div class="card shadow-sm">
    <div class="card-header">
        <h4>Tambah Transaksi</h4>
    </div>
    <div class="card-body">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('transaksi.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label class="form-label">Tanggal</label>
                <input type="date" name="tanggal" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Jenis Transaksi</label>
                <select name="tipe" class="form-select" required>
                    <option value="">-- Pilih --</option>
                    <option value="pemasukan">Pemasukan</option>
                    <option value="pengeluaran">Pengeluaran</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Nama Barang</label>
                <input type="text" name="nama_barang" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Jumlah</label>
                <input type="number" name="jumlah" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Harga Satuan</label>
                <input type="number" name="harga_satuan" class="form-control" step="0.01" required>
            </div>

            <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" name="ppn_termasuk" id="ppnCheck">
                <label class="form-check-label" for="ppnCheck">
                    Harga sudah termasuk PPN 12%
                </label>
            </div>

            <div class="mb-3">
                <label class="form-label">Upload Bukti (opsional)</label>
                <input type="file" name="bukti" class="form-control" accept="image/*">
            </div>

            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('transaksi.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
@endsection
