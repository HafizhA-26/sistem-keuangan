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
            $table->string('nama',50);
            $table->enum('jk',['Pria','Wanita']);
            $table->string('noHP',20)->nullable();
            $table->char('id_jabatan',10)->nullable();
            $table->text('alamat')->nullable();
            $table->string('picture')->nullable();
            $table->string('id_jurusan',10)->nullable()->default(NULL);
            $table->timestamps();
            $table->foreign('nip')->references('nip')->on('accounts');
            $table->foreign('id_jabatan')->references('id_jabatan')->on('jabatan');
            $table->foreign('id_jurusan')->references('id_jurusan')->on('jurusan');
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
