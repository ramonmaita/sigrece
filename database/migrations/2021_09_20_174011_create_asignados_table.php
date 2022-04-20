<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAsignadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asignados', function (Blueprint $table) {
            $table->id();
            $table->integer('periodo_id');
			$table->integer('pnf_id');
			$table->integer('cedula');
			$table->string('apellidos');
			$table->string('nombres');
			$table->enum('sexo',['M','F']);
			$table->date('fecha_nacimiento');
			$table->string('telefono')->nullable();
			$table->string('celular')->nullable();
			$table->string('correo')->nullable();
			$table->year('graduacion');
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
        Schema::dropIfExists('asignados');
    }
}
