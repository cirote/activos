<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Cirote\Activos\Config\Config;

class CreateOpcionesInexistentesTable extends Migration
{
    public function up()
    {
        Schema::create(Config::PREFIJO . Config::INEXISTENTES, function (Blueprint $table) 
        {
            $table->increments('id');
            $table->string('ticker')->unique();
            $table->integer('subyacente_id')->nullable();
	        $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists(Config::PREFIJO . Config::INEXISTENTES);
    }
}
