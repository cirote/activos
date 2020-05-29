<?php

namespace Cirote\Activos\Controllers;

use Scheb\YahooFinanceApi\ApiClientFactory;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Cirote\Activos\Models\Inexistente;
use Cirote\Activos\Actions\Precios\ObtenerPreciosAction;

class HomeController extends Controller
{
	public function index()
    {
        return view('activos::inexistentes.index')
        	->withActivos(Inexistente::select('subyacente_id')->distinct()->get()->load('subyacente')->paginate(5));
    }

	public function prueba()
    {
        $api = resolve(ObtenerPreciosAction::class);

        dd($api->execute('GGAL'));

        die('Terminé');

    	$client = ApiClientFactory::createApiClient();

        //	$searchResult = $client->search("Galicia");

        //	$searchResult = $client->getQuote("AAPL");

        $searchResult = $client->getQuotes(['GGAL', 'GFG.BA']);

        dd($searchResult);
    }
}
