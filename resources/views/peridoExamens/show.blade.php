@extends('plantillas.admin_template')

@include('peridoExamens._common')

@section('header')

<ol class="breadcrumb">
	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
    <li><a href="{{ route('peridoExamens.index') }}">@yield('peridoExamensAppTitle')</a></li>
    <li class="active">{{ $peridoExaman->name }}</li>
</ol>

<div class="page-header">
        <h1>@yield('peridoExamensAppTitle') / Mostrar {{$peridoExaman->id}}

            {!! Form::model($peridoExaman, array('route' => array('peridoExamens.destroy', $peridoExaman->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? Estas seguro?')) { return true } else {return false };")) !!}
                <div class="btn-group pull-right" role="group" aria-label="...">
                    @permission('peridoExaman.edit')
                    <a class="btn btn-warning btn-group" role="group" href="{{ route('peridoExamens.edit', $peridoExaman->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                    @endpermission
                    @permission('peridoExaman.destroy')
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
                    <p class="form-control-static">{{$peridoExaman->id}}</p>
                </div>
                <div class="form-group">
                     <label for="lectivo_id">LECTIVO_ID</label>
                     <p class="form-control-static">{{$peridoExaman->lectivo_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="inicio">INICIO</label>
                     <p class="form-control-static">{{$peridoExaman->inicio}}</p>
                </div>
                    <div class="form-group">
                     <label for="fin">FIN</label>
                     <p class="form-control-static">{{$peridoExaman->fin}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_alta_id">USU_ALTA_ID</label>
                     <p class="form-control-static">{{$peridoExaman->usu_alta_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_mod_id">USU_MOD_ID</label>
                     <p class="form-control-static">{{$peridoExaman->usu_mod_id}}</p>
                </div>
            </form>

            <div class="row">
                </div>

            <a class="btn btn-link" href="{{ route('peridoExamens.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>

        </div>
    </div>

@endsection