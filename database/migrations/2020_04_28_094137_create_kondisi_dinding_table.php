<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKondisiDindingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kondisiDinding', function (Blueprint $table) {
            $table->bigIncrements("idKondisiDinding");
            $table->string("namaKondisiDinding");
            $table->integer("skorKondisiDinding");
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
        Schema::dropIfExists('kondisiDinding');
    }
}
