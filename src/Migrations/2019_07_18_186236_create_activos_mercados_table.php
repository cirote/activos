<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActivosMercadosTable extends Migration
{
    public function up()
    {
        Schema::create('activo_mercado', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('mercado_id')->unsigned()->refers('id')->on('mercados');
            $table->integer('activo_id')->unsigned()->refers('id')->on('activos');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('activo_mercado');
    }
}
