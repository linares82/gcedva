@extends('plantillas.admin_template')

@include('reglaRecargos._common')

@section('header')

<ol class="breadcrumb">
	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
    <li><a href="{{ route('reglaRecargos.index') }}">@yield('reglaRecargosAppTitle')</a></li>
    <li class="active">{{ $reglaRecargo->name }}</li>
</ol>

<div class="page-header">
        <h1>@yield('reglaRecargosAppTitle') / Mostrar {{$reglaRecargo->id}}

            {!! Form::model($reglaRecargo, array('route' => array('reglaRecargos.destroy', $reglaRecargo->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? Estas seguro?')) { return true } else {return false };")) !!}
                <div class="btn-group pull-right" role="group" aria-label="...">
                    @permission('reglaRecargo.edit')
                    <a class="btn btn-warning btn-group" role="group" href="{{ route('reglaRecargos.edit', $reglaRecargo->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                    @endpermission
                    @permission('reglaRecargo.destroy')
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
                    <p class="form-control-static">{{$reglaRecargo->id}}</p>
                </div>
                <div class="form-group col-sm-4">
                     <label for="name">REGLA RECARGO</label>
                     <p class="form-control-static">{{$reglaRecargo->name}}</p>
                </div>
                    <div class="form-group col-sm-4">
                     <label for="dia_inicio">DIA INICIO</label>
                     <p class="form-control-static">{{$reglaRecargo->dia_inicio}}</p>
                </div>
                    <div class="form-group col-sm-4">
                     <label for="dia_fin">DIA FIN</label>
                     <p class="form-control-static">{{$reglaRecargo->dia_fin}}</p>
                </div>
                    <div class="form-group col-sm-4">
                     <label for="porcentaje">PORCENTAJE</label>
                     <p class="form-control-static">{{$reglaRecargo->porcentaje}}</p>
                </div>
                    <div class="form-group col-sm-4">
                     <label for="usu_alta_id">ALTA</label>
                     <p class="form-control-static">{{$reglaRecargo->usu_alta->name}}</p>
                </div>
                    <div class="form-group col-sm-4">
                     <label for="usu_mod_id">ULTIMA MODIFICACION</label>
                     <p class="form-control-static">{{$reglaRecargo->usu_mod->name}}</p>
                </div>
            </form>

            <div class="row">
                </div>

            <a class="btn btn-link" href="{{ route('reglaRecargos.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>

        </div>
    </div>

@endsection