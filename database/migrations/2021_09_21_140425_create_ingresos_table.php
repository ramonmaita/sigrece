<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIngresosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ingresos', function (Blueprint $table) {
            $table->id();
			$table->integer('periodo_id');
			$table->integer('alumno_id');
			$table->enum('tipo',['ASIGNADO', 'OTRAS OPRTUNIDADES', 'REINGRESO']);
			$table->enum('estatus',['REGISTRADO','ACTUALIZADO','INSCRITO']);
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
        Schema::dropIfExists('ingresos');
    }
}
