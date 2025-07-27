<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('masukan', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal_transaksi');
            $table->string('nomor_faktur')->nullable();
            $table->string('nama_pelanggan')->nullable();
            $table->string('jenis_produk');
            $table->integer('jumlah');
            $table->decimal('harga_satuan', 12, 2);
            $table->decimal('subtotal', 12, 2);
            $table->decimal('ppn', 12, 2);
            $table->decimal('total', 12, 2);
            $table->string('metode_pembayaran');
            $table->text('catatan')->nullable();
            $table->string('bukti')->nullable(); // path ke file bukti
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('masukans');
    }
};
