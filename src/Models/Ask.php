<?php

namespace Cirote\Activos\Models;


use Illuminate\Support\Collection;
use Carbon\Carbon;

class Ask extends Bid
{
    public function getPrecioAttribute() 
    {
        return $this->subyacente->precio->ask_precio;
    }

    public function getCantidadAttribute() 
    {
        return $this->subyacente->precio->ask_cantidad;
    }
}
