@extends('plantillas.admin_template')

@include('cotizacionCursos._common')

@section('header')

<ol class="breadcrumb">
	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
    <li><a href="{{ route('cotizacionCursos.index') }}">@yield('cotizacionCursosAppTitle')</a></li>
    <li class="active">{{ $cotizacionCurso->name }}</li>
</ol>

<div class="page-header">
        <h1>@yield('cotizacionCursosAppTitle') / Mostrar {{$cotizacionCurso->id}}

            {!! Form::model($cotizacionCurso, array('route' => array('cotizacionCursos.destroy', $cotizacionCurso->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? Estas seguro?')) { return true } else {return false };")) !!}
                <div class="btn-group pull-right" role="group" aria-label="...">
                    @permission('cotizacionCurso.edit')
                    <a class="btn btn-warning btn-group" role="group" href="{{ route('cotizacionCursos.edit', $cotizacionCurso->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                    @endpermission
                    @permission('cotizacionCurso.destroy')
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
                    <p class="form-control-static">{{$cotizacionCurso->id}}</p>
                </div>
                <div class="form-group">
                     <label for="no_coti">NO_COTI</label>
                     <p class="form-control-static">{{$cotizacionCurso->no_coti}}</p>
                </div>
                    <div class="form-group">
                     <label for="empresa_">EMPRESA_</label>
                     <p class="form-control-static">{{$cotizacionCurso->empresa->}}</p>
                </div>
                    <div class="form-group">
                     <label for="fecha">FECHA</label>
                     <p class="form-control-static">{{$cotizacionCurso->fecha}}</p>
                </div>
                    <div class="form-group">
                     <label for="descuento">DESCUENTO</label>
                     <p class="form-control-static">{{$cotizacionCurso->descuento}}</p>
                </div>
                    <div class="form-group">
                     <label for="forma_pago">FORMA_PAGO</label>
                     <p class="form-control-static">{{$cotizacionCurso->forma_pago}}</p>
                </div>
                    <div class="form-group">
                     <label for="subtotal">SUBTOTAL</label>
                     <p class="form-control-static">{{$cotizacionCurso->subtotal}}</p>
                </div>
                    <div class="form-group">
                     <label for="descuento">DESCUENTO</label>
                     <p class="form-control-static">{{$cotizacionCurso->descuento}}</p>
                </div>
                    <div class="form-group">
                     <label for="iva">IVA</label>
                     <p class="form-control-static">{{$cotizacionCurso->iva}}</p>
                </div>
                    <div class="form-group">
                     <label for="total">TOTAL</label>
                     <p class="form-control-static">{{$cotizacionCurso->total}}</p>
                </div>
                    <div class="form-group">
                     <label for="observaciones">OBSERVACIONES</label>
                     <p class="form-control-static">{{$cotizacionCurso->observaciones}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_alta_id">USU_ALTA_ID</label>
                     <p class="form-control-static">{{$cotizacionCurso->usu_alta_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_mod_id">USU_MOD_ID</label>
                     <p class="form-control-static">{{$cotizacionCurso->usu_mod_id}}</p>
                </div>
            </form>

            <div class="row">
                </div>

            <a class="btn btn-link" href="{{ route('cotizacionCursos.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>

        </div>
    </div>

@endsection