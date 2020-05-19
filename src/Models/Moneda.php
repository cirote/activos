<?php

namespace Cirote\Activos\Models;


use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Tightenco\Parental\HasParent;

class Moneda extends Activo
{
    use HasParent;

    static public function makePesosPorDolarYPF()
    {
        $ypf = Activo::byTicker('YPFD');

        $peso = Activo::byTicker('$');
        $dolar = Activo::byTicker('USD');

        $enPesos = DB::table('historicos')
            ->select('fecha as fechaPesos', 'cierre as pesos')
            ->where('activo_id', $ypf->id)
            ->where('moneda_id', $peso->id);

        return DB::table('historicos')
            ->select('fecha', 'cierre as dolares', 'pesos', DB::raw('(pesos / cierre) as cotizacion'))
            ->where('activo_id', $ypf->id)
            ->where('moneda_id', $dolar->id)
            ->joinSub($enPesos, 'enPesos', function ($join) {
                $join->on('historicos.fecha', 'enPesos.fechaPesos');
            });
    }

    static public function makePesosPorDolarTenaris()
    {
        $tenaris = Activo::byTicker('TS');

        $peso = Activo::byTicker('$');
        $dolar = Activo::byTicker('USD');

        $enPesos = DB::table('historicos')
            ->select('fecha as fechaPesos', 'cierre as pesos')
            ->where('activo_id', $tenaris->id)
            ->where('moneda_id', $peso->id);

        return DB::table('historicos')
            ->select('fecha', 'cierre as dolares', 'pesos', DB::raw('(2 * pesos / cierre) as cotizacion'))
            ->where('activo_id', $tenaris->id)
            ->where('moneda_id', $dolar->id)
            ->joinSub($enPesos, 'enPesos', function ($join) {
                $join->on('historicos.fecha', 'enPesos.fechaPesos');
            });
    }

    static public function cotizacion($fecha)
    {
        if (is_string($fecha))
            $fecha = Carbon::create($fecha);

        $corte = Carbon::create(2019, 8, 30, 0, 0, 0);

        if ($fecha->greaterThan($corte))
        {
            return static::makePesosPorDolarYPF()->where('fecha', '<=', $fecha)->orderByDesc('fecha')->first()->cotizacion;
        }

        return static::makePesosPorDolarTenaris()->where('fecha', '<=', $fecha)->orderByDesc('fecha')->first()->cotizacion;
    }
}
