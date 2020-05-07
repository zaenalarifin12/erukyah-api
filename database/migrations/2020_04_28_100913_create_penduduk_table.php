<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePendudukTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('penduduk', function (Blueprint $table) {
            $table->bigIncrements("idPenduduk");
            $table->string("nokk");
            $table->string("nik", 16);
            $table->string("nama");
            $table->text("alamat");

            $table->string("latitude");
            $table->string("longtitude");
            $table->double("totalSkor")->nullable();
            $table->date("tglPerbaikan")->nullable();
            $table->string("noKontrak")->nullable();
            $table->string("fotoRumahPerbaikan")->nullable();
            $table->string("fotoLantai")->nullable();
            $table->string("fotoDinding")->nullable();
            $table->string("fotoAtap")->nullable();

            // status persetujuan
            // 0 belum disetujui
            // 1 sudah disetujui
            // 2 sudah direnovasi
            $table->enum("status", [0,1,2])->default(0);

            #relasi
            $table->unsignedBigInteger("idDesa");
            $table->unsignedBigInteger("idKecamatan");
            $table->unsignedBigInteger("idKabupaten");
            $table->unsignedBigInteger("idProvinsi");
            $table->unsignedBigInteger("idUser");

            $table->foreign("idDesa")
                ->references("idDesa")->on("desa")->onDelete("cascade");
            $table->foreign("idKecamatan")
                ->references("idKecamatan")->on("kecamatan")->onDelete("cascade");
            $table->foreign("idKabupaten")
                ->references("idKabupaten")->on("kabupaten")->onDelete("cascade");
            $table->foreign("idProvinsi")
                ->references("idProvinsi")->on("provinsi")->onDelete("cascade");
            $table->foreign("idUser")
                ->references("idUser")->on("users")->onDelete("idUser");

            $table->softDeletes();
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
        Schema::dropIfExists('penduduk');
    }
}
