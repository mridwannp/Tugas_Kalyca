<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengeluaran extends Model
{
    use HasFactory;

    protected $fillable = [
        'tanggal_transaksi',
        'kategori',
        'jenis_produk',
        'keterangan',
        'jumlah_barang',
        'harga_satuan',
        'subtotal',
        'ppn',
        'total',
        'metode_pembayaran',
        'bukti',
        'catatan'
    ];

}
