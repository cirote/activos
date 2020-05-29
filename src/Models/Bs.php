<?php

namespace Cirote\Activos\Models;

trait Bs
{
	/*
		Bloque de funciones vinculadas al modelo de valoración
	*/

	/*
		Calculo de la curva de distribución normal
	*/
	private function distribucionNormal($x) 
	{
		// Si el parametro $x es negativo
		if ($x < 0)
			return (1 - $this->distribucionNormal(-$x));

		// Coeficientes
		$y = 0.2316419;
		$a1 = 0.31938153;
		$a2 = -0.356563782;
		$a3 = 1.781477937;
		$a4 = -1.821255978;
		$a5 = 1.330274429;
		$k = 1 / (1 + ($y * $x));
		
		// Calcula el polinomio
		$p = ($a1 * $k) + ($a2 * pow($k, 2)) + ($a3 * pow($k, 3)) + ($a4 * pow($k, 4)) + ($a5 * pow($k, 5));

		// Calcula N prima
		$nPrima	= exp((-pow($x, 2)) / 2) / sqrt(2 * pi());

		// Devuelve el resultado
		return 1 - ($nPrima * $p);
	}

	/*
		Calcula el coeficiente d1 de las formulas de precios de opciones
	*/
	private function d1($s0, $x, $r, $d, $t) 
	{
		$a1 = log($s0/$x);
		$a2 = ($r + 0.5 * pow($d, 2)) * $t;
		$b = $d * sqrt($t);
		return ($a1 + $a2) / $b;
	}

	/*
		Calcula el coeficiente d2 de las formulas de precios de opciones
	*/
	private function d2($s0, $x, $r, $d, $t) 
	{
		$a1 = log($s0/$x);
		$a2 = ($r - pow($d, 2) / 2) * $t;
		$b = $d * sqrt($t);
		return ($a1 + $a2) / $b;
	}

	public function getPrecioBS($s0, $x, $r, $d, $t) 
	{
		return -10;
	}

	private function volatilidad($s0, $x, $r, $c, $t) 
	{
		$h = 5;
		$l = 0;
		$dif = 0.0001;
		
		while (($h - $l) > $dif) {

			$v = ($h + $l) / 2;

			if ($this->getPrecioBS($s0, $x, $r, $v, $t) > $c) {
				$h = $v;
			} else {
				$l = $v;
			}
		}

		return ($v > 0.1) ? $v : 0;
	}
}
