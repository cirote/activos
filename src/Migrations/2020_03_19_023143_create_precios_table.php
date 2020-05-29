<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Cirote\Activos\Config\Config;

class CreatePreciosTable extends Migration
{
    public function up()
    {
        Schema::create(Config::PREFIJO . Config::PRECIOS, function (Blueprint $table) 
        {
            $table->bigIncrements('id');

            $table->integer('activo_id')->unsigned();
            $table->foreign('activo_id')->references('id')->on(Config::PREFIJO . Config::ACTIVOS);

            $table->integer('ticker_id')->unsigned();
            $table->foreign('ticker_id')->references('id')->on(Config::PREFIJO . Config::TICKERS);

            $table->integer('mercado_id')->index()->unsigned();
            $table->foreign('mercado_id')->references('id')->on(Config::PREFIJO . Config::MERCADOS);

            $table->integer('moneda_id')->unsigned();
            $table->foreign('moneda_id')->references('id')->on(Config::PREFIJO . Config::ACTIVOS);

            $table->double('bid_precio')->nullable()->default(null);
            $table->integer('bid_cantidad')->nullable()->default(null);
            $table->double('ask_precio')->nullable()->default(null);
            $table->integer('ask_cantidad')->nullable()->default(null);

            $table->double('precio_pesos')->nullable()->default(null);
            $table->double('precio_dolares')->nullable()->default(null);

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists(Config::PREFIJO . Config::PRECIOS);
    }
}
