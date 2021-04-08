<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSolictudsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('solicituds', function (Blueprint $table) {
            $table->id();
			$table->integer('solicitante_id');
			$table->integer('admin_id')->default(0);
			$table->integer('desasignatura_id');
			$table->string('periodo');
			$table->string('seccion');
			$table->string('tipo');
			$table->enum('estatus',['EN ESPERA','EN REVISION','PROCESADO', 'PROCESADO CON OBSERVACIONES','RECHAZADO']);
			$table->mediumText('motivo')->nullable();
			$table->mediumText('observacion')->nullable();
			$table->dateTime('fecha');
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
        Schema::dropIfExists('solictuds');
    }
}
