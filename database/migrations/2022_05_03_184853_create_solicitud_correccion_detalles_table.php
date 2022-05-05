<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSolicitudCorreccionDetallesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('solicitud_correccion_detalles', function (Blueprint $table) {
            $table->id();
			$table->integer('solicitud_correccion_id');
			$table->integer('alumno_id');
			$table->integer('actividad_id');
			$table->decimal('nota_anterior',8,2);
			$table->decimal('nota_nueva',8,2);
			$table->enum('estatus_jefe',['EN ESPERA','EN REVISION','PROCESADO', 'PROCESADO CON OBSERVACIONES','RECHAZADO']);
			$table->enum('estatus_admin',['EN ESPERA','EN REVISION','PROCESADO', 'PROCESADO CON OBSERVACIONES','RECHAZADO']);
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
        Schema::dropIfExists('solicitud_correccion_detalles');
    }
}
