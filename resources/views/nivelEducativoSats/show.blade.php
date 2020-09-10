@extends('plantillas.admin_template')

@include('nivelEducativoSats._common')

@section('header')

<ol class="breadcrumb">
	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
    <li><a href="{{ route('nivelEducativoSats.index') }}">@yield('nivelEducativoSatsAppTitle')</a></li>
    <li class="active">{{ $nivelEducativoSat->name }}</li>
</ol>

<div class="page-header">
        <h1>@yield('nivelEducativoSatsAppTitle') / Mostrar {{$nivelEducativoSat->id}}

            {!! Form::model($nivelEducativoSat, array('route' => array('nivelEducativoSats.destroy', $nivelEducativoSat->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? Estas seguro?')) { return true } else {return false };")) !!}
                <div class="btn-group pull-right" role="group" aria-label="...">
                    @permission('nivelEducativoSat.edit')
                    <a class="btn btn-warning btn-group" role="group" href="{{ route('nivelEducativoSats.edit', $nivelEducativoSat->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                    @endpermission
                    @permission('nivelEducativoSat.destroy')
                    <button type="submit" class="btn btn-danger">Borrar <i class="glyphicon glyphicon-trash"></i><
                    /button>
                    @endpermission
                </div>
            {!! Form::close() !!}

        </h1>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">

            <form action="#">
                <div class="form-group col-sm-4">
                    <label for="nome">ID</label>
                    <p class="form-control-static">{{$nivelEducativoSat->id}}</p>
                </div>
                <div class="form-group">
                     <label for="name">NAME</label>
                     <p class="form-control-static">{{$nivelEducativoSat->name}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_alta_id">USU_ALTA_ID</label>
                     <p class="form-control-static">{{$nivelEducativoSat->usu_alta_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_mod_id">USU_MOD_ID</label>
                     <p class="form-control-static">{{$nivelEducativoSat->usu_mod_id}}</p>
                </div>
            </form>

            <div class="row">
                </div>

            <a class="btn btn-link" href="{{ route('nivelEducativoSats.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>

        </div>
    </div>

@endsection