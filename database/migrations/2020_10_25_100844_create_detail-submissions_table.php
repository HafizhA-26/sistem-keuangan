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
            $table->char('id_pengajuan',10);
            $table->text('deskripsi')->nullable();
            $table->string('file_lampiran')->nullable();
            $table->timestamps();
            $table->foreign('id_pengajuan')->references('id_pengajuan')->on('submissions');
            
        });
        // DB::statement("ALTER TABLE detail_submissions MODIFY file_lampiran MEDIUMBLOB");
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
