@extends('layouts::master')

@section('body_class')
    skin-blue sidebar-mini
@endsection

@section('main_header')
    @include('activos::layouts.mainheader')
@endsection

@section('sidebar')
    @include('activos::menues.menu')
@endsection


