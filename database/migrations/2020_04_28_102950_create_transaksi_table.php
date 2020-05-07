<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransaksiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaksi', function (Blueprint $table) {
            $table->bigIncrements("idTransaksi");
            $table->string("nokk");
            $table->string("nik", 16);

            $table->string("latitude");
            $table->string("longtitude");
            $table->string("fotoDepan");
            $table->string("fotoLantai");
            $table->string("fotoDinding");
            $table->string("fotoAtap");

            $table->unsignedBigInteger("idLantai");
            $table->unsignedBigInteger("idDinding");
            $table->unsignedBigInteger("idKondisiDinding");
            $table->unsignedBigInteger("idAtap");
            $table->unsignedBigInteger("idKondisiAtap");
            $table->unsignedBigInteger("idUser");

            $table->foreign("idLantai")
                ->references("idLantai")->on("lantai")->onDelete("cascade");
            $table->foreign("idDinding")
                ->references("idDinding")->on("dinding")->onDelete("cascade");
            $table->foreign("idKondisiDinding")
                ->references("idKondisiDinding")->on("kondisiDinding")->onDelete("cascade");
            $table->foreign("idAtap")
                ->references("idAtap")->on("atap")->onDelete("cascade");
            $table->foreign("idKondisiAtap")
                ->references("idKondisiAtap")->on("kondisiAtap")->onDelete("cascade");
            $table->foreign("idUser")
                ->references("idUser")->on("users")->onDelete("cascade");

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transaksi');
    }
}
