<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDolarTable extends Migration
{
    public function up()
    {
        Schema::create('dolar', function (Blueprint $table) 
        {
            $table->bigIncrements('id');

            $table->double('AC17_en_pesos');
            $table->double('AC17_en_dolares');
            $table->double('AC17_mep');

            $table->double('DICA_en_pesos');
            $table->double('DICA_en_dolares');
            $table->double('DICA_mep');

            $table->double('mep_promedio');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('dolar');
    }
}
