@extends('plantillas.admin_template')

@include('prospectos._common')

@section('header')

<ol class="breadcrumb">
	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
    <li><a href="{{ route('prospectos.index') }}">@yield('prospectosAppTitle')</a></li>
    <li class="active">{{ $prospecto->name }}</li>
</ol>

<div class="page-header">
        <h1>@yield('prospectosAppTitle') / Mostrar {{$prospecto->id}}

            {!! Form::model($prospecto, array('route' => array('prospectos.destroy', $prospecto->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? Estas seguro?')) { return true } else {return false };")) !!}
                <div class="btn-group pull-right" role="group" aria-label="...">
                    @permission('prospecto.edit')
                    <a class="btn btn-warning btn-group" role="group" href="{{ route('prospectos.edit', $prospecto->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                    @endpermission
                    @permission('prospecto.destroy')
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
                    <p class="form-control-static">{{$prospecto->id}}</p>
                </div>
                <div class="form-group col-sm-4">
                     <label for="nombre">NOMBRE</label>
                     <p class="form-control-static">{{$prospecto->nombre}}</p>
                </div>
                    <div class="form-group col-sm-4">
                     <label for="nombre2">NOMBRE2</label>
                     <p class="form-control-static">{{$prospecto->nombre2}}</p>
                </div>
                    <div class="form-group col-sm-4">
                     <label for="ape_paterno">A. PATERNO</label>
                     <p class="form-control-static">{{$prospecto->ape_paterno}}</p>
                </div>
                    <div class="form-group col-sm-4">
                     <label for="ape_materno">A. MATERNO</label>
                     <p class="form-control-static">{{$prospecto->ape_materno}}</p>
                </div>
                    <div class="form-group col-sm-4">
                     <label for="tel_fijo">TEL. FIJO</label>
                     <p class="form-control-static">{{$prospecto->tel_fijo}}</p>
                </div>
                    <div class="form-group col-sm-4">
                     <label for="tel_cel">TEL. CELUAR</label>
                     <p class="form-control-static">{{$prospecto->tel_cel}}</p>
                </div>
                    <div class="form-group col-sm-4">
                     <label for="mail">MAIL</label>
                     <p class="form-control-static">{{$prospecto->mail}}</p>
                </div>
                    <div class="form-group col-sm-4">
                     <label for="plantel_id">PLANTEL</label>
                     <p class="form-control-static">{{$prospecto->plantel->razon}}</p>
                </div>
                    <div class="form-group col-sm-4">
                     <label for="especialidad_id">ESPECIALIDAD</label>
                     <p class="form-control-static">{{$prospecto->especialidad->name}}</p>
                </div>
                    <div class="form-group col-sm-4">
                     <label for="nivel_id">NIVEL</label>
                     <p class="form-control-static">{{$prospecto->nivel->name}}</p>
                </div>
                    <div class="form-group col-sm-4">
                     <label for="medio_id">MEDIO</label>
                     <p class="form-control-static">{{$prospecto->medio->name}}</p>
                </div>
                    <div class="form-group col-sm-4">
                     <label for="st_prospecto_id">ESTATUS PROSPECTO</label>
                     <p class="form-control-static">{{$prospecto->stProspecto->name}}</p>
                </div>
                    <div class="form-group col-sm-4">
                     <label for="usu_alta_id">ALTA</label>
                     <p class="form-control-static">{{$prospecto->usu_alta->name}}</p>
                </div>
                    <div class="form-group col-sm-4">
                     <label for="usu_mod_id">U. Modificacion</label>
                     <p class="form-control-static">{{$prospecto->usu_mod->name}}</p>
                </div>
            </form>

            <div class="row">
                </div>

            <a class="btn btn-link" href="{{ route('prospectos.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>

        </div>
    </div>

@endsection