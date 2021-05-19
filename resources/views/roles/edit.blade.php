@extends('plantillas.admin_template')

@include('roles._common')

@section('header')

	<ol class="breadcrumb">
	    <li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li><a href="{{ route('rolesF.index') }}">@yield('salonsAppTitle')  </a></li>
	    <li><a href="{{ route('rolesF.show', $model->id) }}">{{ $model->id }}</a></li>
	    <li class="active">Editar</li>
	</ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-edit"></i> @yield('salonsAppTitle') / Editar {{$model->id}}</h3>
    </div>
@endsection

@section('content')
<form action="{{ route('rolesF.update', $model->id) }}" method="post" role="form">

  @include('roles._form')
  <button type="submit" class="btn btn-labeled btn-primary"><span class="btn-label"><i class="fa fa-check"></i></span>Guardar</button>
  <a class="btn btn-labeled btn-default" href="{{ route('rolesF.index') }}"><span class="btn-label"><i class="fa fa-chevron-left"></i></span>Cancelar</a>
</form>
@endsection
