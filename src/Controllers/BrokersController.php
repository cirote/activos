<?php

namespace Cirote\Activos\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Cirote\Movimientos\Actions\CalcularValorActualDeLasPosicionesAbiertasAction as valorActual;
use Cirote\Movimientos\Models\Movimiento;

class BrokersController extends Controller
{
	public function index(valorActual $valorActual)
    {
		 return view('activos::brokers.index')
		 	->withValorActual($valorActual->execute())
		 	->withMovimientos(Movimiento::with('broker')->deFondos()->resumir()->get());
    }
}
