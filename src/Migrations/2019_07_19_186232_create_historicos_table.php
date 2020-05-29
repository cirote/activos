<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Cirote\Activos\Config\Config;

class CreateHistoricosTable extends Migration
{
    public function up()
    {
        Schema::create('historicos', function (Blueprint $table) 
        {
            $table->increments('id');

            $table->integer('activo_id')->unsigned();
            $table->foreign('activo_id')->references('id')->on(Config::PREFIJO . Config::ACTIVOS);
            
            $table->integer('mercado_id')->index()->unsigned();
            $table->foreign('mercado_id')->references('id')->on(Config::PREFIJO . Config::MERCADOS);

            $table->integer('moneda_id')->index()->unsigned();
            $table->foreign('moneda_id')->references('id')->on(Config::PREFIJO . Config::ACTIVOS);

            $table->date('fecha')->index();
            $table->double('apertura');
            $table->double('maximo');
            $table->double('minimo');
            $table->double('cierre');
            $table->double('volumen')->default(0);
            $table->double('interes_abierto');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('historicos');
    }
}
