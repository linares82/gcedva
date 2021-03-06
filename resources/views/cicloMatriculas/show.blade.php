@extends('plantillas.admin_template')

@include('cicloMatriculas._common')

@section('header')

<ol class="breadcrumb">
	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
    <li><a href="{{ route('cicloMatriculas.index') }}">@yield('cicloMatriculasAppTitle')</a></li>
    <li class="active">{{ $cicloMatricula->name }}</li>
</ol>

<div class="page-header">
        <h1>@yield('cicloMatriculasAppTitle') / Mostrar {{$cicloMatricula->id}}

            {!! Form::model($cicloMatricula, array('route' => array('cicloMatriculas.destroy', $cicloMatricula->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? Estas seguro?')) { return true } else {return false };")) !!}
                <div class="btn-group pull-right" role="group" aria-label="...">
                    @permission('cicloMatricula.edit')
                    <a class="btn btn-warning btn-group" role="group" href="{{ route('cicloMatriculas.edit', $cicloMatricula->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                    @endpermission
                    @permission('cicloMatricula.destroy')
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
                    <p class="form-control-static">{{$cicloMatricula->id}}</p>
                </div>
                <div class="form-group col-sm-4">
                     <label for="name ">CICLO</label>
                     <p class="form-control-static">{{$cicloMatricula->name}}</p>
                </div>
                    <div class="form-group col-sm-4">
                     <label for="bnd_activo">ACTIVO</label>
                     <p class="form-control-static">@if($cicloMatricula->bnd_activo) SI @else NO @endif</p>
                </div>
                    <div class="form-group col-sm-4">
                     <label for="usu_alta_id">ALTA</label>
                     <p class="form-control-static">{{$cicloMatricula->usu_alta->name}}</p>
                </div>
                    <div class="form-group col-sm-4">
                     <label for="usu_mod_id">U. MODIFICACION</label>
                     <p class="form-control-static">{{$cicloMatricula->usu_mod->name}}</p>
                </div>
            </form>

            <div class="row">
                </div>

            <a class="btn btn-link" href="{{ route('cicloMatriculas.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>

        </div>
    </div>

@endsection