@extends('plantillas.admin_template')

@include('hEstatuses._common')

@section('header')

<ol class="breadcrumb">
	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
    <li><a href="{{ route('hEstatuses.index') }}">@yield('hEstatusesAppTitle')</a></li>
    <li class="active">{{ $hEstatus->name }}</li>
</ol>

<div class="page-header">
        <h1>@yield('hEstatusesAppTitle') / Mostrar {{$hEstatus->id}}

            {!! Form::model($hEstatus, array('route' => array('hEstatuses.destroy', $hEstatus->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? Estas seguro?')) { return true } else {return false };")) !!}
                <div class="btn-group pull-right" role="group" aria-label="...">
                    @permission('hEstatus.edit')
                    <a class="btn btn-warning btn-group" role="group" href="{{ route('hEstatuses.edit', $hEstatus->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                    @endpermission
                    @permission('hEstatus.destroy')
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
                    <p class="form-control-static">{{$hEstatus->id}}</p>
                </div>
                <div class="form-group">
                     <label for="tabla">TABLA</label>
                     <p class="form-control-static">{{$hEstatus->tabla}}</p>
                </div>
                    <div class="form-group">
                     <label for="estatus">ESTATUS</label>
                     <p class="form-control-static">{{$hEstatus->estatus}}</p>
                </div>
                    <div class="form-group">
                     <label for="estatus_id">ESTATUS_ID</label>
                     <p class="form-control-static">{{$hEstatus->estatus_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="fecha">FECHA</label>
                     <p class="form-control-static">{{$hEstatus->fecha}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_alta_id">USU_ALTA_ID</label>
                     <p class="form-control-static">{{$hEstatus->usu_alta_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_mod_id">USU_MOD_ID</label>
                     <p class="form-control-static">{{$hEstatus->usu_mod_id}}</p>
                </div>
            </form>

            <div class="row">
                </div>

            <a class="btn btn-link" href="{{ route('hEstatuses.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>

        </div>
    </div>

@endsection