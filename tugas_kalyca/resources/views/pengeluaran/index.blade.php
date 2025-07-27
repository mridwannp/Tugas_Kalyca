@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Daftar Keluaran</h2>

    {{-- Tombol Tambah --}}
    <a href="{{ route('pengeluaran.create') }}" class="btn btn-success mb-3">+ Tambah Pengeluaran</a>

    {{-- Tabel --}}
    <div class="table-responsive">
        <table class="table table-bordered table-striped align-middle">
            <thead class="table-dark">
                <tr>
                    <th>Tanggal</th>
                    <th>Kategori</th>
                    <th>Keterangan</th>
                    <th>Jumlah</th>
                    <th>Harga Satuan</th>
                    <th>Subtotal</th>
                    <th>PPN (12%)</th>
                    <th>Total</th>
                    <th>Metode Pembayaran</th>
                    <th>Bukti</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($keluarans as $item)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}</td>
                    <td>{{ $item->kategori }}</td>
                    <td>{{ $item->keterangan }}</td>
                    <td>{{ $item->jumlah_barang }}</td>
                    <td>Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($item->ppn, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($item->total, 0, ',', '.') }}</td>
                    <td>{{ $item->metode_pembayaran }}</td>
                    <td>
                        @if ($item->bukti)
                            <a href="{{ asset('storage/' . $item->bukti) }}" target="_blank">Lihat</a>
                        @else
                            -
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('pengeluaran.edit', $item->id) }}" class="btn btn-sm btn-primary">Edit</a>
                        <form action="{{ route('pengeluaran.destroy', $item->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger" type="submit">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="11" class="text-center">Belum ada data pengeluaran</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
