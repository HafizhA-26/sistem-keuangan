<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubmissionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('submissions', function (Blueprint $table) {
            $table->char('id_pengajuan', 10)->primary();
            $table->string('judul', 100);
            $table->string('status', 10);
            $table->char('id_transaksi',10)->nullable();
            $table->bigInteger('id_pengaju')->unsigned();
            $table->timestamps();
            $table->foreign('id_transaksi')->references('id_transaksi')->on('transaksi');
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
        Schema::dropIfExists('submission');
    }
}
