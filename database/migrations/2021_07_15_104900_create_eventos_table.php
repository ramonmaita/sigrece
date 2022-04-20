<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('eventos', function (Blueprint $table) {
            $table->id();
			$table->integer('periodo_id');
			$table->integer('evento_padre')->default(0);
			$table->string('nombre');
			$table->text('descripcion');
			$table->datetime('inicio');
			$table->datetime('fin');
			$table->enum('tipo',['GRADUACION','INSCRIPCION','CARGA DE CALIFICACIONES']);
			$table->enum('aplicar',['MISION SUCRE','UPT Bolivar','REGULARES','NUEVO INGRESO','CIU','PER']);
			$table->string('pnf')->nullable();
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
        Schema::dropIfExists('eventos');
    }
}
