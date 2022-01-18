@extends('plantillas.admin_template')

@include('titulacionIntentos._common')

@section('header')

<ol class="breadcrumb">
	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
    <li><a href="{{ route('titulacionIntentos.index') }}">@yield('titulacionIntentosAppTitle')</a></li>
    <li class="active">{{ $titulacionIntento->name }}</li>
</ol>

<div class="page-header">
        <h1>@yield('titulacionIntentosAppTitle') / Mostrar {{$titulacionIntento->id}}

            {!! Form::model($titulacionIntento, array('route' => array('titulacionIntentos.destroy', $titulacionIntento->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? Estas seguro?')) { return true } else {return false };")) !!}
                <div class="btn-group pull-right" role="group" aria-label="...">
                    @permission('titulacionIntento.edit')
                    <a class="btn btn-warning btn-group" role="group" href="{{ route('titulacionIntentos.edit', $titulacionIntento->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                    @endpermission
                    @permission('titulacionIntento.destroy')
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
                    <p class="form-control-static">{{$titulacionIntento->id}}</p>
                </div>
                <div class="form-group">
                     <label for="titulacion_id">TITULACION_ID</label>
                     <p class="form-control-static">{{$titulacionIntento->titulacion->id}}</p>
                </div>
                    <div class="form-group">
                     <label for="intento">INTENTO</label>
                     <p class="form-control-static">{{$titulacionIntento->intento}}</p>
                </div>
                    <div class="form-group">
                     <label for="fec_examen">FEC_EXAMEN</label>
                     <p class="form-control-static">{{$titulacionIntento->fec_examen}}</p>
                </div>
                    <div class="form-group">
                     <label for="opcion_titulacion_id">OPCION_TITULACION_ID</label>
                     <p class="form-control-static">{{$titulacionIntento->opcion_titulacion_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_alta_id">USU_ALTA_ID</label>
                     <p class="form-control-static">{{$titulacionIntento->usu_alta_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_mod_id">USU_MOD_ID</label>
                     <p class="form-control-static">{{$titulacionIntento->usu_mod_id}}</p>
                </div>
            </form>

            <div class="row">
                </div>

            <a class="btn btn-link" href="{{ route('titulacionIntentos.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>

        </div>
    </div>

@endsection