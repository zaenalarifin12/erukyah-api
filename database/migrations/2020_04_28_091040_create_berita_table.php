<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBeritaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('berita', function (Blueprint $table) {
            $table->bigIncrements("idBerita");
            $table->string("judulBerita");
            $table->text("slugBerita");
            $table->text("uraianBerita");
            $table->text("fileBerita");
            $table->unsignedBigInteger("idUser");
            $table->timestamps();
            $table->softDeletes();

            $table->foreign("idUser")->references("idUser")->on("users")->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('berita');
    }
}
