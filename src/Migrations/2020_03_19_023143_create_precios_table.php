<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePreciosTable extends Migration
{
    public function up()
    {
        Schema::create('precios', function (Blueprint $table) 
        {
            $table->bigIncrements('id');

            $table->integer('activo_id')->index()->unsigned()->refers('id')->on('activos');
            $table->integer('ticker_id')->index()->unsigned()->refers('id')->on('tickers');
            $table->integer('mercado_id')->index()->unsigned()->refers('id')->on('mercados');
            $table->integer('moneda_id')->index()->unsigned()->refers('id')->on('activos');

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
        Schema::dropIfExists('precios');
    }
}
