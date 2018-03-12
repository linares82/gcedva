@extends('plantillas.admin_template')

@include('pagosLectivosLns._common')

@section('header')

<ol class="breadcrumb">
	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
    <li><a href="{{ route('pagosLectivosLns.index') }}">@yield('pagosLectivosLnsAppTitle')</a></li>
    <li class="active">{{ $pagosLectivosLn->name }}</li>
</ol>

<div class="page-header">
        <h1>@yield('pagosLectivosLnsAppTitle') / Mostrar {{$pagosLectivosLn->id}}

            {!! Form::model($pagosLectivosLn, array('route' => array('pagosLectivosLns.destroy', $pagosLectivosLn->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? Estas seguro?')) { return true } else {return false };")) !!}
                <div class="btn-group pull-right" role="group" aria-label="...">
                    @permission('pagosLectivosLn.edit')
                    <a class="btn btn-warning btn-group" role="group" href="{{ route('pagosLectivosLns.edit', $pagosLectivosLn->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                    @endpermission
                    @permission('pagosLectivosLn.destroy')
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
                    <p class="form-control-static">{{$pagosLectivosLn->id}}</p>
                </div>
                <div class="form-group">
                     <label for="pagos_lectivo_id">PAGOS_LECTIVO_ID</label>
                     <p class="form-control-static">{{$pagosLectivosLn->pagos_lectivo_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="clave">CLAVE</label>
                     <p class="form-control-static">{{$pagosLectivosLn->clave}}</p>
                </div>
                    <div class="form-group">
                     <label for="concepto">CONCEPTO</label>
                     <p class="form-control-static">{{$pagosLectivosLn->concepto}}</p>
                </div>
                    <div class="form-group">
                     <label for="nombre_corto">NOMBRE_CORTO</label>
                     <p class="form-control-static">{{$pagosLectivosLn->nombre_corto}}</p>
                </div>
                    <div class="form-group">
                     <label for="monto_mase">MONTO_MASE</label>
                     <p class="form-control-static">{{$pagosLectivosLn->monto_mase}}</p>
                </div>
                    <div class="form-group">
                     <label for="seriacion_id">SERIACION_ID</label>
                     <p class="form-control-static">{{$pagosLectivosLn->seriacion_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="cuenta_contable_id">CUENTA_CONTABLE_ID</label>
                     <p class="form-control-static">{{$pagosLectivosLn->cuenta_contable_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="fec_inicio">FEC_INICIO</label>
                     <p class="form-control-static">{{$pagosLectivosLn->fec_inicio}}</p>
                </div>
                    <div class="form-group">
                     <label for="cuenta_contable_recargo_id">CUENTA_CONTABLE_RECARGO_ID</label>
                     <p class="form-control-static">{{$pagosLectivosLn->cuenta_contable_recargo_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_alta_id">USU_ALTA_ID</label>
                     <p class="form-control-static">{{$pagosLectivosLn->usu_alta_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_mod_id">USU_MOD_ID</label>
                     <p class="form-control-static">{{$pagosLectivosLn->usu_mod_id}}</p>
                </div>
            </form>

            <div class="row">
                </div>

            <a class="btn btn-link" href="{{ route('pagosLectivosLns.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>

        </div>
    </div>

@endsection