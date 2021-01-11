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
            $table->enum('jenis',['keluar', 'masuk', 'pending','rejected']);
            $table->timestamps();
            $table->foreign('id_dana')->references('id_dana')->on('dana');
            
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
