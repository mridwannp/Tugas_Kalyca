<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Masukan extends Model
{
    use HasFactory;

    protected $table = 'masukan';

    protected $fillable = [
        'tanggal_transaksi',
        'nomor_faktur',
        'nama_pelanggan',
        'jenis_produk',
        'jumlah',
        'harga_satuan',
        'subtotal',
        'ppn',
        'total',
        'metode_pembayaran',
        'catatan',
        'bukti'
    ];
}
