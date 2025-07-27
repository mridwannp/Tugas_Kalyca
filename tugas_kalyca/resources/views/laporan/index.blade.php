@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Laporan Bulanan</h1>

    {{-- Filter Bulan dan Tahun --}}
    <form method="GET" action="{{ route('laporan.index') }}" class="mb-4">
        <div class="row g-2 align-items-end">
            <div class="col-md-3">
                <label for="bulan">Bulan:</label>
                <select name="bulan" id="bulan" class="form-control">
                    @for ($i = 1; $i <= 12; $i++)
                        <option value="{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}" {{ $bulan == str_pad($i, 2, '0', STR_PAD_LEFT) ? 'selected' : '' }}>
                            {{ DateTime::createFromFormat('!m', $i)->format('F') }}
                        </option>
                    @endfor
                </select>
            </div>
            <div class="col-md-3">
                <label for="tahun">Tahun:</label>
                <select name="tahun" id="tahun" class="form-control">
                    @for ($y = date('Y'); $y >= 2020; $y--)
                        <option value="{{ $y }}" {{ $tahun == $y ? 'selected' : '' }}>{{ $y }}</option>
                    @endfor
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary">Tampilkan</button>
            </div>
        </div>
    </form>

    {{-- Tombol Cetak PDF --}}
    <div class="mb-4">
        <a href="{{ route('laporan.pdf.ppn_masukan', ['bulan' => $bulan, 'tahun' => $tahun]) }}" class="btn btn-outline-success me-2">Cetak PPN Masukan</a>
        <a href="{{ route('laporan.pdf.ppn_keluaran', ['bulan' => $bulan, 'tahun' => $tahun]) }}" class="btn btn-outline-warning me-2">Cetak PPN Keluaran</a>
        <a href="{{ route('laporan.pdf.selisih_ppn', ['bulan' => $bulan, 'tahun' => $tahun]) }}" class="btn btn-outline-danger me-2">Cetak Selisih PPN</a>
        <a href="{{ route('laporan.pdf.rekapitulasi', ['bulan' => $bulan, 'tahun' => $tahun]) }}" class="btn btn-outline-danger me-2">Cetak Rekapitulasi PPN</a>
        <a href="{{ route('laporan.per-barang', ['bulan' => $bulan, 'tahun' => $tahun]) }}" class="btn btn-outline-info">Laporan per Barang</a>
    </div>

    {{-- Tabel Masukan --}}
    <div class="card mb-4">
        <div class="card-header fw-bold">PPN Keluaran (Penjualan)</div>
        <div class="card-body p-0">
            <table class="table table-bordered mb-0">
                <thead class="table-secondary text-center">
                    <tr>
                        <th>Tanggal</th>
                        <th>Jenis Produk</th>
                        <th>Jumlah</th>
                        <th>Harga Satuan</th>
                        <th>Subtotal</th>
                        <th>PPN</th>
                        <th>Total</th>
                        <th>Metode Pembayaran</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($masukan as $m)
                        <tr>
                            <td>{{ $m->tanggal_transaksi }}</td>
                            <td>{{ $m->jenis_produk }}</td>
                            <td class="text-center">{{ $m->jumlah }}</td>
                            <td class="text-end">@rupiah($m->harga_satuan)</td>
                            <td class="text-end">@rupiah($m->subtotal)</td>
                            <td class="text-end">@rupiah($m->ppn)</td>
                            <td class="text-end">@rupiah($m->total)</td>
                            <td>{{ $m->metode_pembayaran }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center">Tidak ada data</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Tabel Pengeluaran --}}
    <div class="card mb-4">
        <div class="card-header fw-bold">PPN Masukan (Pengeluaran Umum)</div>
        <div class="card-body p-0">
            <table class="table table-bordered mb-0">
                <thead class="table-secondary text-center">
                    <tr>
                        <th>Tanggal</th>
                        <th>Kategori</th>
                        <th>Jumlah</th>
                        <th>Harga Satuan</th>
                        <th>Subtotal</th>
                        <th>PPN</th>
                        <th>Total</th>
                        <th>Metode Pembayaran</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pengeluaran as $p)
                        <tr>
                            <td>{{ $p->tanggal_transaksi }}</td>
                            <td>{{ $p->kategori }}</td>
                            <td class="text-center">{{ $p->jumlah_barang }}</td>
                            <td class="text-end">@rupiah($p->harga_satuan)</td>
                            <td class="text-end">@rupiah($p->subtotal)</td>
                            <td class="text-end">@rupiah($p->ppn)</td>
                            <td class="text-end">@rupiah($p->total)</td>
                            <td>{{ $p->metode_pembayaran }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center">Tidak ada data</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

   {{-- Tabel Selisih PPN --}}
    @php
        $totalPpnKeluaran = $masukan->sum('ppn');
        $totalPpnMasukan = $pengeluaran->sum('ppn') + $pengeluaran_barang->sum('ppn');
        $selisihPpn = $totalPpnKeluaran - $totalPpnMasukan;
    @endphp

    <div class="card mb-4">
        <div class="card-header fw-bold">Selisih PPN</div>
        <div class="card-body">
            <table class="table table-bordered mb-4">
                <thead class="table-secondary text-center">
                    <tr>
                        <th>Total PPN Keluaran</th>
                        <th>Total PPN Masukan</th>
                        <th>Selisih</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="text-end">
                        <td>@rupiah($totalPpnKeluaran)</td>
                        <td>@rupiah($totalPpnMasukan)</td>
                        <td class="{{ $selisihPpn < 0 ? 'text-danger' : 'text-success' }}">
                            @rupiah($selisihPpn)
                        </td>
                    </tr>
                </tbody>
            </table>

            {{-- Rekapitulasi --}}
            <h5 class="fw-bold">Rekapitulasi</h5>
            <ul class="list-group">
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    Total PPN Keluaran
                    <span class="fw-semibold">@rupiah($totalPpnKeluaran)</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    Total PPN Masukan
                    <span class="fw-semibold">@rupiah($totalPpnMasukan)</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    Selisih PPN (Keluaran - Masukan)
                    <span class="fw-semibold {{ $selisihPpn < 0 ? 'text-danger' : 'text-success' }}">
                        @rupiah($selisihPpn)
                    </span>
                </li>
            </ul>
        </div>
    </div>

</div>
@endsection
