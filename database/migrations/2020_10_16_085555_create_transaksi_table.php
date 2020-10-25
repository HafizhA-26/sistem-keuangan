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
            $table->char('id_transaksi',10)->unique();
            $table->char('id_dana',10);
            $table->integer('jumlah');
            $table->enum('jenis',['keluar', 'masuk', 'pending']);
            $table->string('id_pengaju');
            $table->date('tgl_transaksi');
            $table->timestamps();
            $table->foreign('id_dana')->references('id_dana')->on('dana');
            $table->foreign('id_pengaju')->references('nip')->on('users');
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
