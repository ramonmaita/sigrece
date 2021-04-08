<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDesasignaturaDocenteSeccion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('desasignatura_docente_seccion', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('des_asignatura_id')->unsigned();
            $table->bigInteger('docente_id')->unsigned();
            $table->bigInteger('seccion_id')->unsigned();
            $table->enum('estatus',['ACTIVO','INACTIVO']);
            $table->timestamps();


            $table->foreign('des_asignatura_id')->references('id')->on('des_asignaturas')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('docente_id')->references('id')->on('docentes')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('seccion_id')->references('id')->on('seccions')
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
        Schema::dropIfExists('desasignatura_docente_seccion');
    }
}
