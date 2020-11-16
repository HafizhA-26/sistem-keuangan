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
            $table->bigInteger("id_komentar");
            $table->text("komentar");
            $table->date("comment_date");
            $table->bigInteger('nip');
            $table->timestamps();

            $table->foreign('nip')->references('nip')->on('accounts');
            $table->foreign("id_komentar")->references('id_komentar')->on('detail_submissions');
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
