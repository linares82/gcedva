@extends('plantillas.admin_template')

@include('cotizacionLns._common')

@section('header')

<ol class="breadcrumb">
	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
    <li><a href="{{ route('cotizacionLns.index') }}">@yield('cotizacionLnsAppTitle')</a></li>
    <li class="active">{{ $cotizacionLn->name }}</li>
</ol>

<div class="page-header">
        <h1>@yield('cotizacionLnsAppTitle') / Mostrar {{$cotizacionLn->id}}

            {!! Form::model($cotizacionLn, array('route' => array('cotizacionLns.destroy', $cotizacionLn->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? Estas seguro?')) { return true } else {return false };")) !!}
                <div class="btn-group pull-right" role="group" aria-label="...">
                    @permission('cotizacionLn.edit')
                    <a class="btn btn-warning btn-group" role="group" href="{{ route('cotizacionLns.edit', $cotizacionLn->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                    @endpermission
                    @permission('cotizacionLn.destroy')
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
                    <p class="form-control-static">{{$cotizacionLn->id}}</p>
                </div>
                <div class="form-group">
                     <label for="cotizacion_curso_no_coti">COTIZACION_CURSO_NO_COTI</label>
                     <p class="form-control-static">{{$cotizacionLn->cotizacionCurso->no_coti}}</p>
                </div>
                    <div class="form-group">
                     <label for="consecutivo">CONSECUTIVO</label>
                     <p class="form-control-static">{{$cotizacionLn->consecutivo}}</p>
                </div>
                    <div class="form-group">
                     <label for="cursos_empresa_name">CURSOS_EMPRESA_NAME</label>
                     <p class="form-control-static">{{$cotizacionLn->cursosEmpresa->name}}</p>
                </div>
                    <div class="form-group">
                     <label for="tipo_precio_coti_name">TIPO_PRECIO_COTI_NAME</label>
                     <p class="form-control-static">{{$cotizacionLn->tipoPrecioCoti->name}}</p>
                </div>
                    <div class="form-group">
                     <label for="cantidad">CANTIDAD</label>
                     <p class="form-control-static">{{$cotizacionLn->cantidad}}</p>
                </div>
                    <div class="form-group">
                     <label for="precio">PRECIO</label>
                     <p class="form-control-static">{{$cotizacionLn->precio}}</p>
                </div>
                    <div class="form-group">
                     <label for="total">TOTAL</label>
                     <p class="form-control-static">{{$cotizacionLn->total}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_alta_id">USU_ALTA_ID</label>
                     <p class="form-control-static">{{$cotizacionLn->usu_alta_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_mod_id">USU_MOD_ID</label>
                     <p class="form-control-static">{{$cotizacionLn->usu_mod_id}}</p>
                </div>
            </form>

            <div class="row">
                </div>

            <a class="btn btn-link" href="{{ route('cotizacionLns.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>

        </div>
    </div>

@endsection