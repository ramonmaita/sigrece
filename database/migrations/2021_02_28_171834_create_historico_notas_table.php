<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHistoricoNotasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('historico_notas', function (Blueprint $table) {
            $table->id();
            $table->string('periodo');
            $table->integer('nro_periodo');
            $table->integer('cedula_estudiante');
            $table->string('cod_desasignatura');
            $table->string('cod_asignatura');
            $table->string('nombre_asignatura')->nullable();
            $table->integer('nota');
            $table->string('observacion')->nullable();
            $table->string('seccion')->nullable();
            $table->integer('especialidad');
            $table->integer('cedula_docente')->nullable();
            $table->string('docente')->nullable();
            $table->string('tipo')->nullable();
            $table->integer('estatus');

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
        Schema::dropIfExists('historico_notas');
    }
}
