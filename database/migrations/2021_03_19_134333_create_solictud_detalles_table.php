<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSolictudDetallesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('solicitud_detalles', function (Blueprint $table) {
            $table->id();
			$table->integer('solicitud_id');
			$table->integer('alumno_id');
			$table->integer('admin_id')->default(0);
			$table->integer('nota_e');
			$table->integer('nota');
			$table->enum('estatus',['EN ESPERA','EN REVISION','PROCESADO', 'PROCESADO CON OBSERVACIONES','RECHAZADO']);
			$table->mediumText('observacion')->nullable();
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
        Schema::dropIfExists('solictud_detalles');
    }
}
