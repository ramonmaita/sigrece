<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNucleoPnfTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nucleo_pnf', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('nucleo_id')->unsigned();
            $table->bigInteger('pnf_id')->unsigned();
            $table->timestamps();


            $table->foreign('nucleo_id')->references('id')->on('nucleos')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('pnf_id')->references('id')->on('pnfs')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('nucleo_pnf');
    }
}
