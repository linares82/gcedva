@extends('plantillas.admin_template')

@include('calendarioAsignacionPonderacions._common')

@section('header')

<ol class="breadcrumb">
	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
    <li><a href="{{ route('calendarioAsignacionPonderacions.index') }}">@yield('calendarioAsignacionPonderacionsAppTitle')</a></li>
    <li class="active">{{ $calendarioAsignacionPonderacion->name }}</li>
</ol>

<div class="page-header">
        <h1>@yield('calendarioAsignacionPonderacionsAppTitle') / Mostrar {{$calendarioAsignacionPonderacion->id}}

            {!! Form::model($calendarioAsignacionPonderacion, array('route' => array('calendarioAsignacionPonderacions.destroy', $calendarioAsignacionPonderacion->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? Estas seguro?')) { return true } else {return false };")) !!}
                <div class="btn-group pull-right" role="group" aria-label="...">
                    @permission('calendarioAsignacionPonderacion.edit')
                    <a class="btn btn-warning btn-group" role="group" href="{{ route('calendarioAsignacionPonderacions.edit', $calendarioAsignacionPonderacion->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                    @endpermission
                    @permission('calendarioAsignacionPonderacion.destroy')
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
                    <p class="form-control-static">{{$calendarioAsignacionPonderacion->id}}</p>
                </div>
                <div class="form-group">
                     <label for="asignacion_academica_id">ASIGNACION_ACADEMICA_ID</label>
                     <p class="form-control-static">{{$calendarioAsignacionPonderacion->asignacion_academica_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="carga_ponderacion_id">CARGA_PONDERACION_ID</label>
                     <p class="form-control-static">{{$calendarioAsignacionPonderacion->carga_ponderacion_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="fec_inicio">FEC_INICIO</label>
                     <p class="form-control-static">{{$calendarioAsignacionPonderacion->fec_inicio}}</p>
                </div>
                    <div class="form-group">
                     <label for="fec_fin">FEC_FIN</label>
                     <p class="form-control-static">{{$calendarioAsignacionPonderacion->fec_fin}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_alta_id">USU_ALTA_ID</label>
                     <p class="form-control-static">{{$calendarioAsignacionPonderacion->usu_alta_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_mod_id">USU_MOD_ID</label>
                     <p class="form-control-static">{{$calendarioAsignacionPonderacion->usu_mod_id}}</p>
                </div>
            </form>

            <div class="row">
                </div>

            <a class="btn btn-link" href="{{ route('calendarioAsignacionPonderacions.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>

        </div>
    </div>

@endsection