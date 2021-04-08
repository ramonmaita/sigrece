<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCargaNotasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carga_notas', function (Blueprint $table) {
            $table->id();
			$table->dateTime('fecha');
			$table->string('periodo');
			$table->string('seccion');
			$table->integer('cedula_docente');
			$table->string('docente');
			$table->string('cod_desasignatura');
			$table->integer('user_id');
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
        Schema::dropIfExists('carga_notas');
    }
}
