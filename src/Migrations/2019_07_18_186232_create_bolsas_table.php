<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Cirote\Activos\Config\Config;

class CreateBolsasTable extends Migration
{
    public function up()
    {
        Schema::create(Config::PREFIJO . Config::BOLSAS, function (Blueprint $table) 
        {
            $table->increments('id');
            $table->string('nombre');
            $table->string('sigla');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists(Config::PREFIJO . Config::BOLSAS);
    }
}
