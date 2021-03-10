@extends('plantillas.admin_template')

@include('hStProspectos._common')

@section('header')

<ol class="breadcrumb">
	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
    <li><a href="{{ route('hStProspectos.index') }}">@yield('hStProspectosAppTitle')</a></li>
    <li class="active">{{ $hStProspecto->name }}</li>
</ol>

<div class="page-header">
        <h1>@yield('hStProspectosAppTitle') / Mostrar {{$hStProspecto->id}}

            {!! Form::model($hStProspecto, array('route' => array('hStProspectos.destroy', $hStProspecto->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? Estas seguro?')) { return true } else {return false };")) !!}
                <div class="btn-group pull-right" role="group" aria-label="...">
                    @permission('hStProspecto.edit')
                    <a class="btn btn-warning btn-group" role="group" href="{{ route('hStProspectos.edit', $hStProspecto->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                    @endpermission
                    @permission('hStProspecto.destroy')
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
                    <p class="form-control-static">{{$hStProspecto->id}}</p>
                </div>
                <div class="form-group">
                     <label for="prospecto_id">PROSPECTO_ID</label>
                     <p class="form-control-static">{{$hStProspecto->prospecto_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="st_prospecto_id">ST_PROSPECTO_ID</label>
                     <p class="form-control-static">{{$hStProspecto->st_prospecto_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="alta_id">ALTA_ID</label>
                     <p class="form-control-static">{{$hStProspecto->alta_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_mod_id">USU_MOD_ID</label>
                     <p class="form-control-static">{{$hStProspecto->usu_mod_id}}</p>
                </div>
            </form>

            <div class="row">
                </div>

            <a class="btn btn-link" href="{{ route('hStProspectos.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>

        </div>
    </div>

@endsection