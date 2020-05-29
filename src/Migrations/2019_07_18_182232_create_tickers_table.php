<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Cirote\Activos\Config\Config;

class CreateTickersTable extends Migration
{

    public function up()
    {
        Schema::create(Config::PREFIJO . Config::TICKERS, function (Blueprint $table) 
        {
            $table->increments('id');
            $table->string('ticker', 20)->unique();

            $table->integer('activo_id')->unsigned();
            $table->foreign('activo_id')->references('id')->on(Config::PREFIJO . Config::ACTIVOS);
            
            $table->string('tipo')->nullable()->default(null);
            $table->double('ratio')->default(1);
            $table->boolean('principal')->default(false);
            $table->boolean('precio_referencia_pesos')->default(false);
            $table->boolean('precio_referencia_dolares')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists(Config::PREFIJO . Config::TICKERS);
    }
}
