<?php

namespace Cirote\Activos\Models;

use Illuminate\Database\Eloquent\Model;
use Tightenco\Parental\HasChildren;
use Cirote\Activos\Actions\Precios\ObtenerPreciosAction;
use Cirote\Activos\Actions\Precios\ObtenerPrecioDolarAction;
use Cirote\Activos\Config\Config;
use Cirote\Opciones\Models\Call;
use Cirote\Opciones\Models\Put;

class Activo extends Model
{
    use HasChildren;

    protected $table = Config::PREFIJO . Config::ACTIVOS;

    protected $guarded = [];

    protected $dates = ['vencimiento', 'created_at', 'updated_at'];

    private $obtenerPrecios;

    private $obtenerPrecioDolar;

    public function __construct($attributes = array())  
    {
        parent::__construct($attributes);

        $this->obtenerPrecios = resolve(ObtenerPreciosAction::class);

        $this->obtenerPrecioDolar = resolve(ObtenerPrecioDolarAction::class);
    }

    static public function byName($name)
    {
        return static::where('denominacion', $name)->first();
    }

    static public function byTicker($ticker)
    {
        $tickerGuardado = Ticker::byName($ticker);

        if ($tickerGuardado)
            return $tickerGuardado->activo;

        return null;
    }

    public function getTickerAttribute()
    {
        $ticker = $this->tickers->firstWhere('principal', true);

        if ($ticker)
        {
            return $ticker;
        }

        return $this->tickers->first();
    }

    public function tickers()
    {
        return $this->hasMany(Ticker::class, 'activo_id');
    }

    public function agregarTicker($ticker, $tipo = '', $ratio = 1, $principal = false, $pesos = false, $dolares = false)
    {
        $this->tickers()->firstOrCreate([
            'ticker' => $ticker,
            'tipo' => $tipo,
            'ratio' => $ratio,
            'principal' => $principal,
            'precio_referencia_pesos' => $pesos,
            'precio_referencia_dolares' => $dolares,
        ]);

        return $this;
    }

    public function broker()
    {
        if ($this->broker_id)
            return $this->belongsTo(Broker::class);
    }

    public function operaciones()
    {
        if ($this->broker_id)
        {
            return $this->hasMany(Operacion::class, 'activo_id')
                ->where('broker_id', $this->broker_id)
                ->orderBy('fecha');
        }

        return $this->hasMany(Operacion::class, 'activo_id')->orderBy('fecha');
    }

    public function precio()
    {
        return $this->hasOne(Precio::class, 'activo_id');
    }

    public function getPrecioActualPesosAttribute()
    {
        if ($precio = $this->getPrecio('precio_referencia_pesos'))
        {
            return $precio;
        }

        return $this->precio->precio_pesos ?? 0;
    }

    public function getPrecioActualDolaresAttribute()
    {
        if ($precio = $this->getPrecio('precio_referencia_dolares'))
        {
            return $precio;
        }

        if ($precio = $this->getPrecio('precio_referencia_pesos'))
        {
            return $precio / $this->obtenerPrecioDolar->execute();
        }

        return $this->precio->precio_dolares ?? 0;
    }

    private function getPrecio($campoReferencia)
    {
        $ticker = $this->tickers->firstWhere($campoReferencia, true);

        if ($ticker)
        {
            if ($datos = $this->obtenerPrecios->execute($ticker->ticker))
            {
                return $datos->getRegularMarketPrice() / $ticker->ratio;
            }

            dd($ticker);
        }

        return null;
    }

    public function getValorActualDolaresAttribute()
    {
        return $this->precioActualDolares * $this->cantidad;
    }

    public function getRelacionCostoValorDolaresAttribute()
    {
        return $this->costoDolares ? $this->valorActualDolares / $this->costoDolares * 100 : 0;
    }

    private $bid;

    public function getBidAttribute()
    {
        if (!$this->bid)
        {
            $this->bid = new Bid();

            $this->bid->subyacente = $this;
        }

        return $this->bid;
    }

    private $ask;

    public function getAskAttribute()
    {
        if (!$this->ask)
        {
            $this->ask = new Ask();

            $this->ask->subyacente = $this;
        }

        return $this->ask;
    }

    public function calls()
    {
        return $this->hasMany(Call::class, 'principal_id');
    }

}
