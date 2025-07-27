@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Daftar Masukan</h2>

    {{-- Tombol Tambah --}}
    <a href="{{ route('masukan.create') }}" class="btn btn-success mb-3">+ Tambah Masukan</a>

    {{-- Flash Message --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Tabel Data --}}
    <div class="table-responsive">
        <table class="table table-bordered table-striped align-middle">
            <thead class="table-dark text-center">
                <tr>
                    <th>Tanggal</th>
                    <th>Nomor Faktur</th>
                    <th>Nama Pelanggan</th>
                    <th>Jenis Produk</th>
                    <th>Jumlah</th>
                    <th>Harga Satuan</th>
                    <th>Subtotal</th>
                    <th>PPN (12%)</th>
                    <th>Total</th>
                    <th>Metode Pembayaran</th>
                    <th>Bukti</th>
                    <th style="white-space: nowrap;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($masukan as $item)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($item->tanggal_transaksi)->format('d M Y') }}</td>
                        <td>{{ $item->nomor_faktur ?? '-' }}</td>
                        <td>{{ $item->nama_pelanggan ?? '-' }}</td>
                        <td>{{ $item->jenis_produk }}</td>
                        <td class="text-end">{{ $item->jumlah }}</td>
                        <td class="text-end">Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}</td>
                        <td class="text-end">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                        <td class="text-end">Rp {{ number_format($item->ppn, 0, ',', '.') }}</td>
                        <td class="text-end">Rp {{ number_format($item->total, 0, ',', '.') }}</td>
                        <td>{{ $item->metode_pembayaran }}</td>
                        <td class="text-center">
                            @if ($item->bukti)
                                <a href="{{ asset('storage/' . $item->bukti) }}" target="_blank" class="btn btn-sm btn-outline-secondary">Lihat</a>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td class="text-center" style="white-space: nowrap;">
                            <a href="{{ route('masukan.edit', $item->id) }}" class="btn btn-sm btn-primary">Edit</a>
                            <form action="{{ route('masukan.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger" type="submit">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="12" class="text-center text-muted">Belum ada data masukan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
