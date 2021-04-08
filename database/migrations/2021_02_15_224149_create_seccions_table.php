<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSeccionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seccions', function (Blueprint $table) {
            $table->id();
            $table->integer('periodo_id');
            $table->integer('nucleo_id');
            $table->integer('pnf_id');
            $table->integer('trayecto_id');
            $table->integer('plan_id')->default(0);
            $table->integer('cupos');
            $table->string('nombre');
            $table->string('turno');
            $table->string('observacion');
            $table->enum('estatus',['ACTIVA','INACTIVA']);
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
        Schema::dropIfExists('seccions');
    }
}
