<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_accounts', function (Blueprint $table) {
            $table->bigInteger('nip')->unsigned();
            $table->bigInteger('nuptk');
            $table->string('nama', 20);
            $table->enum('jk',['Pria','Wanita']);
            $table->string('noHP',20);
            $table->char('id_jabatan');
            $table->text('alamat');
            $table->string('picture');
            $table->timestamps();
            $table->foreign('nip')->references('nip')->on('accounts');
            $table->foreign('id_jabatan')->references('id_jabatan')->on('jabatan');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detail_accounts');
    }
}
