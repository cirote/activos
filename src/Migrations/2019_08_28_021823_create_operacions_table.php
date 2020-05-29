<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Cirote\Activos\Config\Config;

class CreateOperacionsTable extends Migration
{
    public function up()
    {
        Schema::create('operaciones', function (Blueprint $table) 
        {
            $table->increments('id');
            $table->string('clase')->nullable();
            $table->string('type')->nullable();
            $table->date('fecha');

            $table->integer('activo_id')->unsigned();
            $table->foreign('activo_id')->references('id')->on(Config::PREFIJO . Config::ACTIVOS);

            $table->integer('broker_id')->unsigned();
            $table->foreign('broker_id')->references('id')->on(Config::PREFIJO . Config::BROKERS);
            
            $table->string('descripcion')->nullable();
            $table->bigInteger('cantidad')->nullable();
            $table->double('precio')->nullable();
            $table->double('pesos');
            $table->double('dolares');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('operaciones');
    }
}
