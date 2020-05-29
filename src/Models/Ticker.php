<?php

namespace Cirote\Activos\Models;

use Illuminate\Database\Eloquent\Model;

class Ticker extends Model
{
    protected $fillable = ['ticker'];

    static public function byName($name)
    {
        return static::where('ticker', $name)->first();
    }

    protected function activo()
    {
        return $this->belongsTo(Activo::class);
    }
}
