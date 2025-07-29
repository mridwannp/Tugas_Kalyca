@extends('layouts.app')

@section('content')
<div class="container">
    <h4 class="fw-bold mb-4">Laporan Per Barang</h4>

    <form method="GET" class="row g-3 mb-4">
        <div class="col-md-2">
            <label>Bulan</label>
            <select name="bulan" class="form-select">
                @for ($i = 1; $i <= 12; $i++)
                    <option value="{{ $i }}" {{ $i == $bulan ? 'selected' : '' }}>
                        {{ DateTime::createFromFormat('!m', $i)->format('F') }}
                    </option>
                @endfor
            </select>
        </div>
        <div class="col-md-2">
            <label>Tahun</label>
            <input type="number" name="tahun" class="form-control" value="{{ $tahun }}">
        </div>
        <div class="col-md-2 d-flex align-items-end">
            <button type="submit" class="btn btn-primary">Tampilkan</button>
        </div>
    </form>

    <div class="mb-3">
        <a href="{{ route('laporan.pdf.per-barang', ['bulan' => $bulan, 'tahun' => $tahun]) }}" class="btn btn-danger" target="_blank">
            <i class="bi bi-file-earmark-pdf-fill"></i> Cetak PDF
        </a>
    </div>

    @php
        $flattenedData = [];
        foreach($data as $jenis => $items) {
            foreach($items as $item) {
                $item->jenis = $jenis;
                $flattenedData[] = $item;
            }
        }
    @endphp

    @if(count($flattenedData) > 0)
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Jenis</th>
                    <th>Jumlah</th>
                    <th>Harga Satuan</th>
                    <th>Subtotal</th>
                    <th>PPN</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($flattenedData as $item)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($item->tanggal_transaksi)->format('d M Y') }}</td>
                        <td>{{ $item->jenis }}</td>
                        <td>{{ $item->jumlah }}</td>
                        <td>Rp{{ number_format($item->harga_satuan, 0, ',', '.') }}</td>
                        <td>Rp{{ number_format($item->subtotal, 0, ',', '.') }}</td>
                        <td>Rp{{ number_format($item->ppn, 0, ',', '.') }}</td>
                        <td>Rp{{ number_format($item->total, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="alert alert-info">Tidak ada data transaksi untuk bulan ini.</div>
    @endif
</div>
@endsection
