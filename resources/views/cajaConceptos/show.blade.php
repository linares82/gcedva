@extends('plantillas.admin_template')

@include('cajaConceptos._common')

@section('header')

<ol class="breadcrumb">
	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
    <li><a href="{{ route('cajaConceptos.index') }}">@yield('cajaConceptosAppTitle')</a></li>
    <li class="active">{{ $cajaConcepto->name }}</li>
</ol>

<div class="page-header">
        <h1>@yield('cajaConceptosAppTitle') / Mostrar {{$cajaConcepto->id}}

            {!! Form::model($cajaConcepto, array('route' => array('cajaConceptos.destroy', $cajaConcepto->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? Estas seguro?')) { return true } else {return false };")) !!}
                <div class="btn-group pull-right" role="group" aria-label="...">
                    @permission('cajaConcepto.edit')
                    <a class="btn btn-warning btn-group" role="group" href="{{ route('cajaConceptos.edit', $cajaConcepto->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                    @endpermission
                    @permission('cajaConcepto.destroy')
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
                    <p class="form-control-static">{{$cajaConcepto->id}}</p>
                </div>
                <div class="form-group col-sm-4">
                     <label for="name">CONCEPTO</label>
                     <p class="form-control-static">{{$cajaConcepto->name}}</p>
                </div>
                    <div class="form-group col-sm-4">
                     <label for="monto">MONTO</label>
                     <p class="form-control-static">{{$cajaConcepto->monto}}</p>
                </div>
                    <div class="form-group col-sm-4">
                     <label for="activo">ACTIVO</label>
                     <p class="form-control-static">{{$cajaConcepto->activo}}</p>
                </div>
                    <div class="form-group col-sm-4">
                     <label for="usu_alta_id">ALTA</label>
                     <p class="form-control-static">{{$cajaConcepto->usu_alta->name}}</p>
                </div>
                    <div class="form-group col-sm-4">
                     <label for="usu_mod_id">ULTIMA MODIFICACION</label>
                     <p class="form-control-static">{{$cajaConcepto->usu_mod->name}}</p>
                </div>
            </form>

            <div class="row">
                </div>

            <a class="btn btn-link" href="{{ route('cajaConceptos.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>

        </div>
    </div>

@endsection