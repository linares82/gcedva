@extends('plantillas.admin_template')

@include('captacions._common')

@section('header')

<ol class="breadcrumb">
	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
    <li><a href="{{ route('captacions.index') }}">@yield('captacionsAppTitle')</a></li>
    <li class="active">{{ $captacion->name }}</li>
</ol>

<div class="page-header">
        <h1>@yield('captacionsAppTitle') / Mostrar {{$captacion->id}}

            {!! Form::model($captacion, array('route' => array('captacions.destroy', $captacion->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? Estas seguro?')) { return true } else {return false };")) !!}
                <div class="btn-group pull-right" role="group" aria-label="...">
                    @permission('captacion.edit')
                    <a class="btn btn-warning btn-group" role="group" href="{{ route('captacions.edit', $captacion->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                    @endpermission
                    @permission('captacion.destroy')
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
                    <p class="form-control-static">{{$captacion->id}}</p>
                </div>
                <div class="form-group col-sm-4">
                     <label for="plantel">PLANTEL</label>
                     <p class="form-control-static">{{$captacion->plantel}}</p>
                </div>
                    <div class="form-group col-sm-4">
                     <label for="nombre">NOMBRE</label>
                     <p class="form-control-static">{{$captacion->nombre}}</p>
                </div>
                    <div class="form-group col-sm-4">
                     <label for="nombre2">NOMBRE2</label>
                     <p class="form-control-static">{{$captacion->nombre2}}</p>
                </div>
                    <div class="form-group col-sm-4">
                     <label for="ape_paterno">A. PATERNO</label>
                     <p class="form-control-static">{{$captacion->ape_paterno}}</p>
                </div>
                    <div class="form-group col-sm-4">
                     <label for="ape_materno">A. MATERNO</label>
                     <p class="form-control-static">{{$captacion->ape_materno}}</p>
                </div>
                    <div class="form-group col-sm-4">
                     <label for="mail">MAIL</label>
                     <p class="form-control-static">{{$captacion->mail}}</p>
                </div>
                    <div class="form-group col-sm-4">
                     <label for="tel_cel">TEL. CEL.</label>
                     <p class="form-control-static">{{$captacion->tel_cel}}</p>
                </div>
                    <div class="form-group col-sm-4">
                     <label for="tel_fijo">TEL. FIJO</label>
                     <p class="form-control-static">{{$captacion->tel_fijo}}</p>
                </div>
                    <div class="form-group col-sm-4">
                     <label for="pais">PAIS</label>
                     <p class="form-control-static">{{$captacion->pais}}</p>
                </div>
                    <div class="form-group col-sm-4">
                     <label for="medio_name">MEDIO</label>
                     <p class="form-control-static">{{$captacion->medio->name}}</p>
                </div>
                    <div class="form-group col-sm-4">
                     <label for="usu_alta_id">U. ALTA</label>
                     <p class="form-control-static">{{$captacion->usu_alta->name}}</p>
                </div>
                    <div class="form-group col-sm-4">
                     <label for="usu_mod_id">U. MODIFICACION</label>
                     <p class="form-control-static">{{$captacion->usu_mod->name}}</p>
                </div>
            </form>

            <div class="row">
                </div>

            <a class="btn btn-link" href="{{ route('captacions.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>

        </div>
    </div>

@endsection