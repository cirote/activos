@extends("layouts::sidebar.solo_menu")

@section('sidebar_menu')
<li class="{{ Request::routeIs('home') ? "active" : "" }}">
    <a href="{{ route('home', [], false) }}">
        <i class="fa fa-home"></i> <span>Home</span>
    </a>
</li>

<li class="header">BROKER's</li>
<li class="{{ Request::routeIs('brokers.index') ? "active" : "" }}">
    <a href="{{ route('brokers.index', [], false) }}">
        <i class="fa fa-table"></i> <span>Cuadro resumen</span>
    </a>
</li>

@includeIf('movimientos::menues.menu')

@includeIf('opciones::menues.inexistentes')

@includeIf('estrategias::menues.menu')

@endsection