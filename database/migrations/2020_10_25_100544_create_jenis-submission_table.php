<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJenisSubmissionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jenis_submissions', function (Blueprint $table) {
            $table->char('id_jenis',10)->primary();
            $table->string('nama_jenis');
            $table->enum('tipe',['keluar', 'masuk']);
            $table->char('id_dana',10);
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
        Schema::dropIfExists('jenis_submissions');
    }
}
