@extends("layouts::sidebar.solo_menu")

@section('sidebar_menu')
<li class="{{ Request::routeIs('home') ? "active" : "" }}">
    <a href="{{ route('home', [], false) }}">
        <i class="fa fa-home"></i> <span>Home</span>
    </a>
</li>

@includeIf('opciones::menues.inexistentes')

@includeIf('estrategias::menues.menu')

@endsection