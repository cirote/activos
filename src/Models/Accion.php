<?php

namespace Cirote\Activos\Models;

use Illuminate\Support\Collection;
use Tightenco\Parental\HasParent;

class Accion extends Activo
{
    use HasParent;

    public function historico()
    {
        return $this->hasMany(Historico::class)
            ->where('mercado_id', 4)
            ->orderBy('fecha');
    }

    public function sma()
    {
        Collection::macro('toGraph', function () {
            return $this->map(function ($value) {
                return $value->toGraph();
            });
        });

        return $this->historico->toGraph()->toJson();
    }
}
