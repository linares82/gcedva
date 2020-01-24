@extends('plantillas.admin_template')

@include('comenMuebles._common')

@section('header')

<ol class="breadcrumb">
	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
    <li><a href="{{ route('comenMuebles.index') }}">@yield('comenMueblesAppTitle')</a></li>
    <li class="active">{{ $comenMueble->name }}</li>
</ol>

<div class="page-header">
        <h1>@yield('comenMueblesAppTitle') / Mostrar {{$comenMueble->id}}

            {!! Form::model($comenMueble, array('route' => array('comenMuebles.destroy', $comenMueble->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? Estas seguro?')) { return true } else {return false };")) !!}
                <div class="btn-group pull-right" role="group" aria-label="...">
                    @permission('comenMueble.edit')
                    <a class="btn btn-warning btn-group" role="group" href="{{ route('comenMuebles.edit', $comenMueble->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                    @endpermission
                    @permission('comenMueble.destroy')
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
                    <p class="form-control-static">{{$comenMueble->id}}</p>
                </div>
                <div class="form-group">
                     <label for="mueble_id">MUEBLE_ID</label>
                     <p class="form-control-static">{{$comenMueble->mueble->id}}</p>
                </div>
                    <div class="form-group">
                     <label for="st_mueble_name">ST_MUEBLE_NAME</label>
                     <p class="form-control-static">{{$comenMueble->stMueble->name}}</p>
                </div>
                    <div class="form-group">
                     <label for="obs">OBS</label>
                     <p class="form-control-static">{{$comenMueble->obs}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_alta_id">USU_ALTA_ID</label>
                     <p class="form-control-static">{{$comenMueble->usu_alta_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_mod_id">USU_MOD_ID</label>
                     <p class="form-control-static">{{$comenMueble->usu_mod_id}}</p>
                </div>
            </form>

            <div class="row">
                </div>

            <a class="btn btn-link" href="{{ route('comenMuebles.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>

        </div>
    </div>

@endsection