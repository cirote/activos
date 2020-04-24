<?php

namespace Cirote\Activos\Controllers;

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
}
