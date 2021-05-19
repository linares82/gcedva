@extends('plantillas.admin_template')

@include('apples._common')

@section('header')

	<ol class="breadcrumb">
	    <li><a href="/"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li><a href="{{ route('apples.index') }}">@yield('applesAppTitle')</a></li>
	    <li><a href="{{ route('apples.show', $model->id) }}">{{ $model->id }}</a></li>
	    <li class="active">Editar</li>
	</ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-edit"></i> @yield('applesAppTitle') / Editar {{$model->id}}</h3>
    </div>
@endsection

@section('content')
<form action="{{ route('usuariosF.update', $model->id) }}" method="post" role="form">
    
    @include('users._form')
    <button type="submit" id="save" class="btn btn-labeled btn-primary"><span class="btn-label"><i class="fa fa-check"></i></span>Guardar</button>
    <a class="btn btn-labeled btn-default" href="{{ route('usuariosF.index') }}"><span class="btn-label"><i class="fa fa-chevron-left"></i></span>Cancelar</a>
</form>
@endsection