@extends('plantillas.admin_template')

@include('roles._common')

@section('header')

	<ol class="breadcrumb">
		<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li><a href="{{ route('rolesF.index') }}">@yield('salonsAppTitle')</a></li>
	    <li class="active">Crear</li>
	</ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-plus"></i> @yield('salonsAppTitle') / Crear </h3>
    </div>
@endsection

@section('content')
<form action="{{ route('rolesF.store') }}" method="post" role="form">
    @include('roles._form')
    <button type="submit" class="btn btn-labeled btn-primary"><span class="btn-label"><i class="fa fa-plus"></i></span>Crear</button>
    <a class="btn btn-labeled btn-default" href="{{ route('rolesF.index')}}"><span class="btn-label"><i class="fa fa-chevron-left"></i></span>Cancelar</a>
</form>
@endsection
