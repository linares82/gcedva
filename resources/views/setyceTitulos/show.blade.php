@extends('plantillas.admin_template')

@include('setyceTitulos._common')

@section('header')

<ol class="breadcrumb">
	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
    <li><a href="{{ route('setyceTitulos.index') }}">@yield('setyceTitulosAppTitle')</a></li>
    <li class="active">{{ $setyceTitulo->name }}</li>
</ol>

<div class="page-header">
        <h1>@yield('setyceTitulosAppTitle') / Mostrar {{$setyceTitulo->id}}

            {!! Form::model($setyceTitulo, array('route' => array('setyceTitulos.destroy', $setyceTitulo->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? Estas seguro?')) { return true } else {return false };")) !!}
                <div class="btn-group pull-right" role="group" aria-label="...">
                    @permission('setyceTitulo.edit')
                    <a class="btn btn-warning btn-group" role="group" href="{{ route('setyceTitulos.edit', $setyceTitulo->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                    @endpermission
                    @permission('setyceTitulo.destroy')
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
                    <p class="form-control-static">{{$setyceTitulo->id}}</p>
                </div>
                <div class="form-group">
                     <label for="setyce_lote_id">SETYCE_LOTE_ID</label>
                     <p class="form-control-static">{{$setyceTitulo->setyce_lote_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="cliente_id">CLIENTE_ID</label>
                     <p class="form-control-static">{{$setyceTitulo->cliente_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="carrera">CARRERA</label>
                     <p class="form-control-static">{{$setyceTitulo->carrera}}</p>
                </div>
                    <div class="form-group">
                     <label for="fecha_inicio">FECHA_INICIO</label>
                     <p class="form-control-static">{{$setyceTitulo->fecha_inicio}}</p>
                </div>
                    <div class="form-group">
                     <label for="fechat_terminacion">FECHAT_TERMINACION</label>
                     <p class="form-control-static">{{$setyceTitulo->fechat_terminacion}}</p>
                </div>
                    <div class="form-group">
                     <label for="folio">FOLIO</label>
                     <p class="form-control-static">{{$setyceTitulo->folio}}</p>
                </div>
                    <div class="form-group">
                     <label for="curp">CURP</label>
                     <p class="form-control-static">{{$setyceTitulo->curp}}</p>
                </div>
                    <div class="form-group">
                     <label for="nombre">NOMBRE</label>
                     <p class="form-control-static">{{$setyceTitulo->nombre}}</p>
                </div>
                    <div class="form-group">
                     <label for="primer_apellido">PRIMER_APELLIDO</label>
                     <p class="form-control-static">{{$setyceTitulo->primer_apellido}}</p>
                </div>
                    <div class="form-group">
                     <label for="segundo_apellido">SEGUNDO_APELLIDO</label>
                     <p class="form-control-static">{{$setyceTitulo->segundo_apellido}}</p>
                </div>
                    <div class="form-group">
                     <label for="correo_electronico">CORREO_ELECTRONICO</label>
                     <p class="form-control-static">{{$setyceTitulo->correo_electronico}}</p>
                </div>
                    <div class="form-group">
                     <label for="fecha_expedicion">FECHA_EXPEDICION</label>
                     <p class="form-control-static">{{$setyceTitulo->fecha_expedicion}}</p>
                </div>
                    <div class="form-group">
                     <label for="sep_modalidad_titulacion_id">SEP_MODALIDAD_TITULACION_ID</label>
                     <p class="form-control-static">{{$setyceTitulo->sep_modalidad_titulacion_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="fecha_examen_profesional">FECHA_EXAMEN_PROFESIONAL</label>
                     <p class="form-control-static">{{$setyceTitulo->fecha_examen_profesional}}</p>
                </div>
                    <div class="form-group">
                     <label for="cumplio_servicio_social">CUMPLIO_SERVICIO_SOCIAL</label>
                     <p class="form-control-static">{{$setyceTitulo->cumplio_servicio_social}}</p>
                </div>
                    <div class="form-group">
                     <label for="sep_fundamento_legal_servicio_social_id">SEP_FUNDAMENTO_LEGAL_SERVICIO_SOCIAL_ID</label>
                     <p class="form-control-static">{{$setyceTitulo->sep_fundamento_legal_servicio_social_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="sep_t_estudio_antecedente_id">SEP_T_ESTUDIO_ANTECEDENTE_ID</label>
                     <p class="form-control-static">{{$setyceTitulo->sep_t_estudio_antecedente_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="entidad_expedicion">ENTIDAD_EXPEDICION</label>
                     <p class="form-control-static">{{$setyceTitulo->entidad_expedicion}}</p>
                </div>
                    <div class="form-group">
                     <label for="institucion_procedencia">INSTITUCION_PROCEDENCIA</label>
                     <p class="form-control-static">{{$setyceTitulo->institucion_procedencia}}</p>
                </div>
                    <div class="form-group">
                     <label for="entidad_antecedente">ENTIDAD_ANTECEDENTE</label>
                     <p class="form-control-static">{{$setyceTitulo->entidad_antecedente}}</p>
                </div>
                    <div class="form-group">
                     <label for="fecha_inicio_antecedente">FECHA_INICIO_ANTECEDENTE</label>
                     <p class="form-control-static">{{$setyceTitulo->fecha_inicio_antecedente}}</p>
                </div>
                    <div class="form-group">
                     <label for="fecha_terminoa_antecedente">FECHA_TERMINOA_ANTECEDENTE</label>
                     <p class="form-control-static">{{$setyceTitulo->fecha_terminoa_antecedente}}</p>
                </div>
                    <div class="form-group">
                     <label for="no_cedula">NO_CEDULA</label>
                     <p class="form-control-static">{{$setyceTitulo->no_cedula}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_mod_id">USU_MOD_ID</label>
                     <p class="form-control-static">{{$setyceTitulo->usu_mod_id}}</p>
                </div>
            </form>

            <div class="row">
                </div>

            <a class="btn btn-link" href="{{ route('setyceTitulos.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>

        </div>
    </div>

@endsection