<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailsubTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detailsub', function (Blueprint $table) {
            $table->char('id_pengajuan', 10);
            $table->text('deskripsi');
            $table->char('id_transaksi', 10);
            $table->string('file_lampiran');
            $table->text('komentar');
            $table->timestamps();
            
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detailsub');
    }
}
