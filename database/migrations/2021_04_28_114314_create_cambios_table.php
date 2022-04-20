<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCambiosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cambios', function (Blueprint $table) {
            $table->id();
			$table->integer('periodo_id');
			$table->integer('alumno_id');
			$table->integer('usuario_id');
			$table->integer('estudiante_id');
			$table->integer('orgien');
			$table->integer('destino');
			$table->string('observacion');
			$table->enum('tipo',['CAMBIO DE SECCION','CAMBIO DE SECCION MUTUO','CAMBIO DE PNF']);
            $table->timestamps();
			$table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cambios');
    }
}
