<?php

namespace Cirote\Activos\Controllers;

use Scheb\YahooFinanceApi\ApiClientFactory;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Cirote\Activos\Models\Inexistente;
use App\Models\Activos\Activo;

class HomeController extends Controller
{
	public function index()
    {
        return view('activos::inexistentes.index')
        	->withActivos(Inexistente::select('subyacente_id')->distinct()->get()->load('subyacente')->paginate(5));
    }

	public function prueba()
    {
    	$client = ApiClientFactory::createApiClient();

        //	$searchResult = $client->search("Galicia");

        //	$searchResult = $client->getQuote("AAPL");

        $searchResult = $client->getQuotes(['GGAL', 'GFG.BA']);

        dd($searchResult);
    }
}
