<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMercadosTable extends Migration
{
    public function up()
    {
        Schema::create('mercados', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nombre');
            $table->integer('bolsa_id')->unsigned()->refers('id')->on('bolsas');
            $table->integer('moneda_id')->unsigned()->refers('id')->on('activos');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('mercados');
    }
}
