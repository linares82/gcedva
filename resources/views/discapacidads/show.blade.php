@extends('plantillas.admin_template')

@include('discapacidads._common')

@section('header')

<ol class="breadcrumb">
	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
    <li><a href="{{ route('discapacidads.index') }}">@yield('discapacidadsAppTitle')</a></li>
    <li class="active">{{ $discapacidad->name }}</li>
</ol>

<div class="page-header">
        <h1>@yield('discapacidadsAppTitle') / Mostrar {{$discapacidad->id}}

            {!! Form::model($discapacidad, array('route' => array('discapacidads.destroy', $discapacidad->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? Estas seguro?')) { return true } else {return false };")) !!}
                <div class="btn-group pull-right" role="group" aria-label="...">
                    @permission('discapacidad.edit')
                    <a class="btn btn-warning btn-group" role="group" href="{{ route('discapacidads.edit', $discapacidad->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                    @endpermission
                    @permission('discapacidad.destroy')
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
                    <p class="form-control-static">{{$discapacidad->id}}</p>
                </div>
                <div class="form-group">
                     <label for="name">NAME</label>
                     <p class="form-control-static">{{$discapacidad->name}}</p>
                </div>
                    <div class="form-group">
                     <label for="clave">CLAVE</label>
                     <p class="form-control-static">{{$discapacidad->clave}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_alta_id">USU_ALTA_ID</label>
                     <p class="form-control-static">{{$discapacidad->usu_alta_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_mod_id">USU_MOD_ID</label>
                     <p class="form-control-static">{{$discapacidad->usu_mod_id}}</p>
                </div>
            </form>

            <div class="row">
                </div>

            <a class="btn btn-link" href="{{ route('discapacidads.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>

        </div>
    </div>

@endsection