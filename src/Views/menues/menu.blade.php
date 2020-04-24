@extends("layouts::sidebar.solo_menu")

@section('sidebar_menu')
<li class="{{ Request::routeIs('home') ? "active" : "" }}">
    <a href="{{ route('home', [], false) }}">
        <i class="fa fa-home"></i> <span>Home</span>
    </a>
</li>

<li class="header">Opciones Inexistentes</li>
<li class="{{ Request::routeIs('inexistentes.index') ? "active" : "" }}">
    <a href="{{ route('inexistentes.index', [], false) }}">
        <i class="fa fa-table"></i> <span>Lista 2</span>
    </a>
</li>

@include('opciones::menues.inexistentes')

@endsection