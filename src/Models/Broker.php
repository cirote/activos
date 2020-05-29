<?php

namespace Cirote\Activos\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Operaciones\Operacion;
use App\Models\Operaciones\Deposito;
use App\Models\Operaciones\Retiro;
use Cirote\Activos\Config\Config;

class Broker extends Model
{
    protected $table = Config::PREFIJO . Config::BROKERS;

    static public function byName($name)
    {
        return static::where('nombre', $name)->first();
    }

    static public function bySigla($sigla)
    {
        return static::where('sigla', $sigla)->first();
    }

    public function operaciones()
    {
        return $this->hasMany(Operacion::class);
    }

    public function operacionesPorFecha()
    {
        return $this->operaciones()->orderByDesc('fecha');
    }


    public function activos()
    {   
        return Activo::select(['activos.*', 'operaciones.broker_id as broker_id'])
            ->join('operaciones', 'operaciones.activo_id', '=', 'activos.id')
            ->where('broker_id', $this->id)
            ->distinct();
    }

    public function getAActivosAttribute()
    {
        return $this->activos()->conStock();
    }

    public function conStock()
    {
        return $this->activos()->orderBy('denominacion')->get()
            ->filter(function ($activo, $key) 
                {
                    return $activo->cantidad;
                });
    }

    private $aportes_netos;

    public function getAportesNetosAttribute()
    {
        if (! $this->aportes_netos)
        {
            $this->aportes_netos = 0;

            foreach ($this->operaciones as $operacion)
            {
                if ($operacion instanceof Deposito)
                {
                    $this->aportes_netos += $operacion->dolares;
                }

                if ($operacion instanceof Retiro)
                {
                    $this->aportes_netos -= $operacion->dolares;
                }
            }
        }

        return $this->aportes_netos;
    }
}
