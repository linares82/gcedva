@extends('plantillas.admin_template')

@include('clientes._common')

@section('header')

	<ol class="breadcrumb">
		<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li><a href="{{ route('clientes.index') }}">@yield('clientesAppTitle')</a></li>
	    <li class="active">Reportes</li>
	</ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-plus"></i> @yield('clientesAppTitle') / Reportes </h3>
    </div>
@endsection

@section('content')
    @include('error')
    <a href="{{ route('clientes.reportes.ccxep') }}" target="_blank"> <i class="fa fa-fw fa-bar-chart"></i> Clientes - Cantidades de estatus por municipio en un periodo </a><br/>
@endsection