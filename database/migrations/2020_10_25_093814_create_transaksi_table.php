<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransaksiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaksi', function (Blueprint $table) {
            $table->char('id_transaksi',10)->primary();
            $table->char('id_dana');
            $table->integer('jumlah');
            $table->enum('jenis',['keluar', 'masuk', 'pending']);
            $table->integer('id_pengaju');
            $table->date('tgl_transaksi');
            $table->foreign('id_dana')->references('id_dana')->on('dana');
            $table->foreign('id_pengaju')->references('nip')->on('accounts');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transaksi');
    }
}
