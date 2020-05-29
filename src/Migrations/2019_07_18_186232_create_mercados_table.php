<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Cirote\Activos\Config\Config;

class CreateMercadosTable extends Migration
{
    public function up()
    {
        Schema::create(Config::PREFIJO . Config::MERCADOS, function (Blueprint $table) 
        {
            $table->increments('id');
            $table->string('nombre');

            $table->integer('bolsa_id')->unsigned();
            $table->foreign('bolsa_id')->references('id')->on(Config::PREFIJO . Config::BOLSAS);

            $table->integer('moneda_id')->unsigned();
            $table->foreign('moneda_id')->references('id')->on(Config::PREFIJO . Config::ACTIVOS);

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists(Config::PREFIJO . Config::MERCADOS);
    }
}
