@extends('plantillas.admin_template')

@include('apples._common')

@section('header')

	<ol class="breadcrumb">
		<li><a href="/"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li><a href="{{ route('usuariosF.index') }}">Usuarios</a></li>
	    <li class="active">Crear</li>
	</ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-plus"></i> Usuarios / Crear </h3>
    </div>
@endsection

@section('content')
@include('error')
<form action="{{ route('usuariosF.store') }}" method="post" role="form">
    @include('users._form')
    <button type="submit" id="create" class="btn btn-labeled btn-primary"><span class="btn-label"><i class="fa fa-plus"></i></span>Guardar</button>
    <a class="btn btn-labeled btn-default" href="{{ route('usuariosF.index') }}"><span class="btn-label"><i class="fa fa-chevron-left"></i></span>Cancelar</a>
</form>
@endsection
