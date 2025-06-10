@extends('plantillas.admin_template')

@include('sepCertificadoLs._common')

@section('header')

<ol class="breadcrumb">
	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
    <li><a href="{{ route('sepCertificadoLs.index') }}">@yield('sepCertificadoLsAppTitle')</a></li>
    <li class="active">{{ $sepCertificadoL->name }}</li>
</ol>

<div class="page-header">
        <h1>@yield('sepCertificadoLsAppTitle') / Mostrar {{$sepCertificadoL->id}}

            {!! Form::model($sepCertificadoL, array('route' => array('sepCertificadoLs.destroy', $sepCertificadoL->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? Estas seguro?')) { return true } else {return false };")) !!}
                <div class="btn-group pull-right" role="group" aria-label="...">
                    @permission('sepCertificadoL.edit')
                    <a class="btn btn-warning btn-group" role="group" href="{{ route('sepCertificadoLs.edit', $sepCertificadoL->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                    @endpermission
                    @permission('sepCertificadoL.destroy')
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
                    <p class="form-control-static">{{$sepCertificadoL->id}}</p>
                </div>
                <div class="form-group">
                     <label for="sep_certificado_id">SEP_CERTIFICADO_ID</label>
                     <p class="form-control-static">{{$sepCertificadoL->sep_certificado_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="cliente_id">CLIENTE_ID</label>
                     <p class="form-control-static">{{$sepCertificadoL->cliente_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="hacademica_id_id">HACADEMICA_ID_ID</label>
                     <p class="form-control-static">{{$sepCertificadoL->hacademica_id_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="sep_cert_id">SEP_CERT_ID</label>
                     <p class="form-control-static">{{$sepCertificadoL->sep_cert_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="fecha_expedicion">FECHA_EXPEDICION</label>
                     <p class="form-control-static">{{$sepCertificadoL->fecha_expedicion}}</p>
                </div>
                    <div class="form-group">
                     <label for="id_carrera">ID_CARRERA</label>
                     <p class="form-control-static">{{$sepCertificadoL->id_carrera}}</p>
                </div>
                    <div class="form-group">
                     <label for="id_asignatura">ID_ASIGNATURA</label>
                     <p class="form-control-static">{{$sepCertificadoL->id_asignatura}}</p>
                </div>
                    <div class="form-group">
                     <label for="numero_asignaturas_cursadas">NUMERO_ASIGNATURAS_CURSADAS</label>
                     <p class="form-control-static">{{$sepCertificadoL->numero_asignaturas_cursadas}}</p>
                </div>
                    <div class="form-group">
                     <label for="promedio_general">PROMEDIO_GENERAL</label>
                     <p class="form-control-static">{{$sepCertificadoL->promedio_general}}</p>
                </div>
                    <div class="form-group">
                     <label for="sep_cert_observacion_id">SEP_CERT_OBSERVACION_ID</label>
                     <p class="form-control-static">{{$sepCertificadoL->sep_cert_observacion_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="bnd_descargar">BND_DESCARGAR</label>
                     <p class="form-control-static">{{$sepCertificadoL->bnd_descargar}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_mod_id">USU_MOD_ID</label>
                     <p class="form-control-static">{{$sepCertificadoL->usu_mod_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_alta_id">USU_ALTA_ID</label>
                     <p class="form-control-static">{{$sepCertificadoL->usu_alta_id}}</p>
                </div>
            </form>

            <div class="row">
                </div>

            <a class="btn btn-link" href="{{ route('sepCertificadoLs.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>

        </div>
    </div>

@endsection