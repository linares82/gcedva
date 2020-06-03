@extends('plantillas.admin_template')

@include('descuentos._common')

@section('header')

<ol class="breadcrumb">
	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
    <li><a href="{{ route('descuentos.index') }}">@yield('descuentosAppTitle')</a></li>
    <li class="active">{{ $descuento->name }}</li>
</ol>

<div class="page-header">
        <h1>@yield('descuentosAppTitle') / Mostrar {{$descuento->id}}

            {!! Form::model($descuento, array('route' => array('descuentos.destroy', $descuento->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? Estas seguro?')) { return true } else {return false };")) !!}
                <div class="btn-group pull-right" role="group" aria-label="...">
                    @permission('descuento.edit')
                    <a class="btn btn-warning btn-group" role="group" href="{{ route('descuentos.edit', $descuento->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                    @endpermission
                    @permission('descuento.destroy')
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
                    <p class="form-control-static">{{$descuento->id}}</p>
                </div>
                <div class="form-group">
                     <label for="name">NAME</label>
                     <p class="form-control-static">{{$descuento->name}}</p>
                </div>
                    <div class="form-group">
                     <label for="porcentaje">PORCENTAJE</label>
                     <p class="form-control-static">{{$descuento->porcentaje}}</p>
                </div>
                    <div class="form-group">
                     <label for="justificacion">JUSTIFICACION</label>
                     <p class="form-control-static">{{$descuento->justificacion}}</p>
                </div>
                    <div class="form-group">
                     <label for="autorizado_por">AUTORIZADO_POR</label>
                     <p class="form-control-static">{{$descuento->autorizado_por}}</p>
                </div>
                    <div class="form-group">
                     <label for="autorizado_el">AUTORIZADO_EL</label>
                     <p class="form-control-static">{{$descuento->autorizado_el}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_alta_id">USU_ALTA_ID</label>
                     <p class="form-control-static">{{$descuento->usu_alta_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_mod_id">USU_MOD_ID</label>
                     <p class="form-control-static">{{$descuento->usu_mod_id}}</p>
                </div>
            </form>

            <div class="row">
                </div>

            <a class="btn btn-link" href="{{ route('descuentos.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>

        </div>
    </div>

@endsection