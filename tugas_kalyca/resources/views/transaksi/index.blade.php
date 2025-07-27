@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4>Daftar Transaksi</h4>
    <a href="{{ route('transaksi.create') }}" class="btn btn-success">+ Tambah Transaksi</a>
</div>

@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<div class="table-responsive shadow-sm">
    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>Tanggal</th>
                <th>Jenis</th>
                <th>Nama Barang</th>
                <th>Jumlah</th>
                <th>Harga Satuan</th>
                <th>PPN</th>
                <th>Total</th>
                <th>Bukti</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($transaksis as $t)
                <tr>
                    <td>{{ $t->tanggal }}</td>
                    <td>{{ ucfirst($t->tipe) }}</td>
                    <td>{{ $t->nama_barang }}</td>
                    <td>{{ $t->jumlah }}</td>
                    <td>Rp{{ number_format($t->harga_satuan, 0, ',', '.') }}</td>
                    <td>Rp{{ number_format($t->ppn, 0, ',', '.') }}</td>
                    <td>Rp{{ number_format($t->total, 0, ',', '.') }}</td>
                    <td>
                        @if ($t->bukti)
                            <a href="{{ asset('storage/' . $t->bukti) }}" class="btn btn-sm btn-outline-primary" target="_blank">Lihat</a>
                        @else
                            <span class="text-muted">-</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center">Belum ada transaksi</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
