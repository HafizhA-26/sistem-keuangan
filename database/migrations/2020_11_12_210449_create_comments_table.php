<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->char('id_pengajuan',10);
            $table->text("komentar")->nullable();
            $table->bigInteger('nip')->unsigned();
            $table->timestamps();

            $table->foreign('nip')->references('nip')->on('accounts');
            $table->foreign('id_pengajuan')->references('id_pengajuan')->on('submissions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comments');
    }
}
