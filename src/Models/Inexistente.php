<?php

namespace Cirote\Activos\Models;

use Illuminate\Database\Eloquent\Model;
use Cirote\Activos\Config\Config;
use App\Models\Activos\Activo;
use App\Models\Activos\Call;
use App\Models\Activos\Put;

class Inexistente extends Model
{
    protected $table = Config::PREFIJO . Config::INEXISTENTES;

    protected $guarded = [];

    public function subyacente()
    {
    	return $this->belongsTo(Activo::class, 'subyacente_id');
    }

    public function getAñoAttribute()
    {
    	return date("Y");
    }

    public function getMesAttribute()
    {
    	$mes = substr($this->ticker, 8, 2);

    	switch ($mes) 
    	{
    		case 'MY':
    			$m = 5;
    			break;

    		case 'JU':
    			$m = 6;
    			break;

    		case 'AG':
    			$m = 8;
    			break;

    		default:
    			$m = 0;
    	}

    	return $m;
    }

    public function getStrikeAttribute()
    {
    	return (double) substr($this->ticker, 4, 4);
    }

    public function getTipoAttribute()
    {
    	return substr($this->ticker, 3, 1) == 'C'
    		? Call::class 
    		: Put::class;
    }

    public function getSortStringAttribute()
    {
    	return (100 + $this->mes) . (1000000 + $this->strike) . substr($this->ticker, 3, 1);
    }
}
