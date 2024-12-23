@extends('plantillas.admin_template')

@include('formaPagos._common')

@section('header')

<ol class="breadcrumb">
	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
    <li><a href="{{ route('formaPagos.index') }}">@yield('formaPagosAppTitle')</a></li>
    <li class="active">{{ $formaPago->name }}</li>
</ol>

<div class="page-header">
        <h1>@yield('formaPagosAppTitle') / Mostrar {{$formaPago->id}}

            {!! Form::model($formaPago, array('route' => array('formaPagos.destroy', $formaPago->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? Estas seguro?')) { return true } else {return false };")) !!}
                <div class="btn-group pull-right" role="group" aria-label="...">
                    @permission('formaPago.edit')
                    <a class="btn btn-warning btn-group" role="group" href="{{ route('formaPagos.edit', $formaPago->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                    @endpermission
                    @permission('formaPago.destroy')
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
                    <p class="form-control-static">{{$formaPago->id}}</p>
                </div>
                <div class="form-group col-sm-4">
                     <label for="name">FORMA PAGO</label>
                     <p class="form-control-static">{{$formaPago->name}}</p>
                </div>
                    <div class="form-group col-sm-4">
                     <label for="usu_alta_id">ALTA</label>
                     <p class="form-control-static">{{$formaPago->usu_alta->name}}</p>
                </div>
                    <div class="form-group col-sm-4">
                     <label for="usu_mod_id">ULTIMA MODIFICACION</label>
                     <p class="form-control-static">{{$formaPago->usu_mod->name}}</p>
                </div>
            </form>

            <div class="row">
                </div>

            <a class="btn btn-link" href="{{ route('formaPagos.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>

        </div>
    </div>

@endsection