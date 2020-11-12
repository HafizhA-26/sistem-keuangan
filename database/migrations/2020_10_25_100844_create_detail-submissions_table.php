<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailSubmissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_submissions', function (Blueprint $table) {
            $table->char('id_pengajuan');
            $table->text('deskripsi');
            $table->char('id_transaksi');
            $table->binary('file_lampiran');
            $table->bigInteger('komentar')->unsigned();
            $table->timestamps();
            $table->foreign('id_pengajuan')->references('id_pengajuan')->on('submissions');
            $table->foreign('id_transaksi')->references('id_transaksi')->on('transaksi');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detail_submissions');
    }
}
