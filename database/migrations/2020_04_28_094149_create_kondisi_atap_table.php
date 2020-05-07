<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKondisiAtapTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kondisiAtap', function (Blueprint $table) {
            $table->bigIncrements("idKondisiAtap");
            $table->string("namaKondisiAtap");
            $table->integer("skorKondisiAtap");
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
        Schema::dropIfExists('kondisiAtap');
    }
}
