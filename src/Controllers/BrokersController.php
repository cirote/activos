<?php

namespace Cirote\Activos\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Cirote\Movimientos\Models\Movimiento;

class BrokersController extends Controller
{
	public function index()
    {
		 return view('activos::brokers.index')
		 	->withMovimientos(Movimiento::with('broker')->deFondos()->resumir()->get());
    }
}
