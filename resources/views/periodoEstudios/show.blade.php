@extends('plantillas.admin_template')

@include('periodoEstudios._common')

@section('header')

<ol class="breadcrumb">
	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
    <li><a href="{{ route('periodoEstudios.index') }}">@yield('periodoEstudiosAppTitle')</a></li>
    <li class="active">{{ $periodoEstudio->name }}</li>
</ol>

<div class="page-header">
        <h1>@yield('periodoEstudiosAppTitle') / Mostrar {{$periodoEstudio->id}}

            {!! Form::model($periodoEstudio, array('route' => array('periodoEstudios.destroy', $periodoEstudio->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? Estas seguro?')) { return true } else {return false };")) !!}
                <div class="btn-group pull-right" role="group" aria-label="...">
                    @permission('periodoEstudio.edit')
                    <a class="btn btn-warning btn-group" role="group" href="{{ route('periodoEstudios.edit', $periodoEstudio->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                    @endpermission
                    @permission('periodoEstudio.destroy')
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
                    <p class="form-control-static">{{$periodoEstudio->id}}</p>
                </div>
                <div class="form-group">
                     <label for="name">NAME</label>
                     <p class="form-control-static">{{$periodoEstudio->name}}</p>
                </div>
                    <div class="form-group">
                     <label for="grado_id">GRADO_ID</label>
                     <p class="form-control-static">{{$periodoEstudio->grado_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_alta_id">USU_ALTA_ID</label>
                     <p class="form-control-static">{{$periodoEstudio->usu_alta_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_mod_id">USU_MOD_ID</label>
                     <p class="form-control-static">{{$periodoEstudio->usu_mod_id}}</p>
                </div>
            </form>

            <div class="row">
                </div>

            <a class="btn btn-link" href="{{ route('periodoEstudios.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>

        </div>
    </div>

@endsection