<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Cirote\Activos\Config\Config;

class CreateActivosTable extends Migration
{
    public function up()
    {
        Schema::create(Config::PREFIJO . Config::ACTIVOS, function (Blueprint $table) 
        {
            $table->increments('id');

            $table->string('denominacion')->index();
            $table->string('clase')->nullable();
            $table->string('type')->nullable();

            $table->integer('principal_id')->nullable()->default(null)->refers('id')->on('activos');
            $table->double('strike')->nullable()->default(null);
            $table->date('vencimiento')->nullable()->default(null);

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists(Config::PREFIJO . Config::ACTIVOS);
    }
}
