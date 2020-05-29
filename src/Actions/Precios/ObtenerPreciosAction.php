<?php

namespace Cirote\Activos\Actions\Precios;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Carbon;
use Scheb\YahooFinanceApi\ApiClientFactory;
use Cirote\Activos\Models\Ticker;

class ObtenerPreciosAction 
{
	private $tickers;

	private $consulta;

	private function leerDatos()
    {
    	$this->tickers = Ticker::select('ticker')
            ->where('precio_referencia_pesos', true)
            ->orWhere('precio_referencia_dolares', true)
            ->get()
            ->pluck('ticker')
            ->toArray();

    	$client = ApiClientFactory::createApiClient();

        $searchResult = collect($client->getQuotes($this->tickers));

		$this->consulta = $searchResult->mapWithKeys(function ($item) {
		    return [$item->getSymbol() => $item];
		});
    }

	public function execute($ticker)
    {
    	if (! $this->consulta)
    	{
    		$this->leerDatos();
    	}

    	return $this->consulta[$ticker] ?? null;
    }
}