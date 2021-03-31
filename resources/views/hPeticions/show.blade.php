@extends('plantillas.admin_template')

@include('hPeticions._common')

@section('header')

<ol class="breadcrumb">
	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
    <li><a href="{{ route('hPeticions.index') }}">@yield('hPeticionsAppTitle')</a></li>
    <li class="active">{{ $hPeticion->name }}</li>
</ol>

<div class="page-header">
        <h1>@yield('hPeticionsAppTitle') / Mostrar {{$hPeticion->id}}

            {!! Form::model($hPeticion, array('route' => array('hPeticions.destroy', $hPeticion->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? Estas seguro?')) { return true } else {return false };")) !!}
                <div class="btn-group pull-right" role="group" aria-label="...">
                    @permission('hPeticion.edit')
                    <a class="btn btn-warning btn-group" role="group" href="{{ route('hPeticions.edit', $hPeticion->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                    @endpermission
                    @permission('hPeticion.destroy')
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
                    <p class="form-control-static">{{$hPeticion->id}}</p>
                </div>
                <div class="form-group">
                     <label for="peticion_multipagos_id">PETICION_MULTIPAGOS_ID</label>
                     <p class="form-control-static">{{$hPeticion->peticion_multipagos_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="campo">CAMPO</label>
                     <p class="form-control-static">{{$hPeticion->campo}}</p>
                </div>
                    <div class="form-group">
                     <label for="valor_anterior">VALOR_ANTERIOR</label>
                     <p class="form-control-static">{{$hPeticion->valor_anterior}}</p>
                </div>
                    <div class="form-group">
                     <label for="valor">VALOR</label>
                     <p class="form-control-static">{{$hPeticion->valor}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_alta_id">USU_ALTA_ID</label>
                     <p class="form-control-static">{{$hPeticion->usu_alta_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_mod_id">USU_MOD_ID</label>
                     <p class="form-control-static">{{$hPeticion->usu_mod_id}}</p>
                </div>
            </form>

            <div class="row">
                </div>

            <a class="btn btn-link" href="{{ route('hPeticions.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>

        </div>
    </div>

@endsection