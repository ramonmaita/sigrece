<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInformacionMedicasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('informacion_medicas', function (Blueprint $table) {
            $table->id();
            $table->integer('alumno_id')->unique();
            $table->string('posee_discapacidad');
            $table->string('discapacidad')->nullable();
            $table->string('posee_enfermedad');
            $table->string('enfermedad')->nullable();
            $table->string('llamar_emergencia');
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
        Schema::dropIfExists('informacion_medicas');
    }
}
