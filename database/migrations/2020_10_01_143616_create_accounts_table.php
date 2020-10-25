<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->string('nip');
            $table->string('nuptk');
            $table->string('nama');
            $table->string('jk');
            $table->string('nama_jabatan');
            $table->string('noHP');
            $table->text('alamat');
            $table->string('image');
            $table->timestamps();
            $table->foreign('nip')->references('nip')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accounts');
    }
}
