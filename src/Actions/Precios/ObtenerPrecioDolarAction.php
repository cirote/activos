<?php

namespace Cirote\Activos\Actions\Precios;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Carbon;
use Cirote\Activos\Actions\Precios\ObtenerPreciosAction;

class ObtenerPrecioDolarAction 
{
	private $dolar_promedio;

    private $ObtenerPrecios;

	public function execute()
    {
    	if (! $this->dolar_promedio)
    	{
    		$this->calcularDolar();
    	}

    	return $this->dolar_promedio;
    }

    private function calcularDolar()
    {
        $this->obtenerPrecios = resolve(ObtenerPreciosAction::class);

        $CCLGalicia = $this->calcularDolarDeUnActivo('GFG.BA', 'GGAL') * 10;

        $CCLYPF = $this->calcularDolarDeUnActivo('YPFD.BA', 'YPF');

        $total = $CCLGalicia + $CCLYPF;

        $this->dolar_promedio = $total / 2;
    }

    private function calcularDolarDeUnActivo($tickerPrecioPesos, $tickerPrecioDolares)
    {
        return $this->obtenerPrecios->execute($tickerPrecioPesos)->getRegularMarketPrice() / $this->obtenerPrecios->execute($tickerPrecioDolares)->getRegularMarketPrice();
    }
}