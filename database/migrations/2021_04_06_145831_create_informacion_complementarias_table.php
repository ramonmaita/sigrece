<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInformacionComplementariasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('informacion_complementarias', function (Blueprint $table) {
            $table->id();
			$table->integer('alumno_id')->unique();
            $table->string('carnet_patria')->nullable();
            $table->string('pertenece_etnia');
            $table->string('etnia')->nullable();
            $table->string('madre');
            $table->string('tlf_madre')->nullable();
            $table->string('padre');
            $table->string('tlf_padre')->nullable();
            $table->string('equipos')->nullable();
            $table->string('internet')->nullable();
            $table->string('ingreso');
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
        Schema::dropIfExists('informacion_complementarias');
    }
}
