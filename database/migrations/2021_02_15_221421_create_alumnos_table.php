<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAlumnosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alumnos', function (Blueprint $table) {
            $table->id();
            $table->integer('cedula')->unique();
            $table->string('p_nombre');
            $table->string('s_nombre')->nullable();
            $table->string('p_apellido');
            $table->string('s_apellido')->nullable();
            $table->string('sexo')->nullable();
            $table->string('escivil')->nullable();
            $table->string('nacionalidad')->default('V');
            $table->date('fechan')->nullable();
            $table->string('lugarn')->nullable();
            $table->integer('pnf_id');
            $table->integer('plan_id');
            $table->integer('nucleo_id');
            $table->string('tipo');
            $table->mediumText('imagen')->nullable();
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
        Schema::dropIfExists('alumnos');
    }
}
