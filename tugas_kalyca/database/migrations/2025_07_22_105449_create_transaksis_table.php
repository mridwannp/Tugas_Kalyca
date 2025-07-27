<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->string('tipe'); // pemasukan / pengeluaran
            $table->string('nama_barang');
            $table->integer('jumlah');
            $table->decimal('harga_satuan', 15, 2);
            $table->boolean('ppn_termasuk')->default(false); // centang jika harga sudah termasuk PPN
            $table->decimal('ppn', 15, 2)->nullable(); // nilai PPN
            $table->decimal('total', 15, 2); // harga total + ppn
            $table->string('bukti')->nullable(); // path file bukti transaksi
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksis');
    }
};
