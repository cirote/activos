<?php

namespace Cirote\Activos\Models;

use Illuminate\Database\Eloquent\Model;
use Cirote\Activos\Config\Config;

class Precio extends Model
{
	protected $table = Config::PREFIJO . Config::PRECIOS;

	public $guarded = [];
}