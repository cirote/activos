<?php

namespace Cirote\Activos\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Carbon\Carbon;

class Bid extends Model
{
	private $subyacente;

	use Bs;

    public function setSubyacenteAttribute(Activo $subyacente)
    {
    	$this->subyacente = $subyacente;

    	return $this;
    }

    public function getSubyacenteAttribute()
    {
    	return $this->subyacente;
    }

  	public function getPrecioAttribute() 
  	{
		return $this->subyacente->precio->bid_precio;
	}

  	public function getCantidadAttribute() 
  	{
		return $this->subyacente->precio->bid_cantidad;
	}

  	public function getValorImplicitoAttribute() 
  	{
		return $this->subyacente->valorImplicito;
	}

	public function getValorExplicitoAttribute() 
	{
		return max($this->precio - $this->valorImplicito, 0);
	}

  	public function getDiasAttribute() 
  	{
		return Carbon::now()->diffInDays($this->vencimiento);
	}

	public function getPrecioBS($s0, $x, $r, $d, $t) 
	{
		return $this->subyacente->getPrecioBS($s0, $x, $r, $d, $t);
	}

	public function getTasaAttribute() 
	{
		return $this->valorExplicito / $this->subyacente->strike;
	}

	public function getTnaAttribute() 
	{
		return $this->TNANetaDeComisiones($this->getTasaUltimo(), $this->getUltimoPrecio());
	}

	public function getTasaNetaAttribute() 
	{
		if (!$this->tasa)
			return 0;

		// Monto estimado de las comisiones de compra y venta
		$comisiones = $this->subyacente->precioActualPesos * $this->tasaComision() * 2;

		// Calculo de la tasa neta de comisiones
		$tasa = $this->tasa - ($comisiones / $this->subyacente->subyacente->precioActualPesos);
		
		// Calcula la tasa continua diaria
		$td = $this->tasaDiariaContinua($tasa, $this->subyacente->dias);
		
		// Expresa la tasa continua diaria como una TNA
		$te = $this->TNAEquivalente($td);	
		
		return $te;
	}

	private function tasaComision() 
	{
		return 0.02;
	}

	private function tasaAnualContinua($TNA = null, $dias = 365) 
	{
		return $this->tasaDiariaContinua($TNA, $dias) * 365;
	}

	private function tasaDiariaContinua($TNA = null, $dias = 365) 
	{
		$_tasa = $TNA ? $TNA : $this->subyacente->subyacente->tasaLibreDeRiesgo;

		$_tasa += 1;

		return pow($_tasa, (1 / $dias)) - 1;
	}

	private function TNAEquivalente($tasaDiariaContinua) 
	{
		return pow(1 + $tasaDiariaContinua, 365) - 1;
	}

	public function getEquivalenteCompraAttribute()
	{
		return $this->precio
			? min($this->subyacente->subyacente->precioActualPesos, $this->subyacente->strike - $this->precio + $this->valorImplicito)
			: 0;
	}

	public function getEquivalenteVentaAttribute()
	{
		return $this->precio
			? $this->subyacente->strike + $this->precio
			: 0;
	}

	public function getVolatilidadImplicitaAttribute()
	{
		return $this->volatilidad(
			$this->subyacente->subyacente->precioActualPesos, 
			$this->subyacente->strike,
			$this->subyacente->tasaLibreDeRiesgo, 
			$this->precio, 
			$this->subyacente->dias / 365
		) * 100;
	}
}
