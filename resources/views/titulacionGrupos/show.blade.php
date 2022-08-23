@extends('plantillas.admin_template')

@include('titulacionGrupos._common')

@section('header')

<ol class="breadcrumb">
	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
    <li><a href="{{ route('titulacionGrupos.index') }}">@yield('titulacionGruposAppTitle')</a></li>
    <li class="active">{{ $titulacionGrupo->name }}</li>
</ol>

<div class="page-header">
        <h1>@yield('titulacionGruposAppTitle') / Mostrar {{$titulacionGrupo->id}}

            {!! Form::model($titulacionGrupo, array('route' => array('titulacionGrupos.destroy', $titulacionGrupo->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? Estas seguro?')) { return true } else {return false };")) !!}
                <div class="btn-group pull-right" role="group" aria-label="...">
                    @permission('titulacionGrupo.edit')
                    <a class="btn btn-warning btn-group" role="group" href="{{ route('titulacionGrupos.edit', $titulacionGrupo->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                    @endpermission
                    @permission('titulacionGrupo.destroy')
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
                    <p class="form-control-static">{{$titulacionGrupo->id}}</p>
                </div>
                <div class="form-group col-sm-4">
                     <label for="name">GRUPO</label>
                     <p class="form-control-static">{{$titulacionGrupo->name}}</p>
                </div>
                    <div class="form-group col-sm-4">
                     <label for="fecha">FECHA</label>
                     <p class="form-control-static">{{$titulacionGrupo->fecha}}</p>
                </div>
                    <div class="form-group col-sm-4">
                     <label for="usu_alta_id">ALTA</label>
                     <p class="form-control-static">{{$titulacionGrupo->usu_alta->name}}</p>
                </div>
                    <div class="form-group col-sm-4">
                     <label for="usu_mod_id">U. MODIFICACION</label>
                     <p class="form-control-static">{{$titulacionGrupo->usu_mod->name}}</p>
                </div>
            </form>

            <div class="row">
                </div>

            <a class="btn btn-link" href="{{ route('titulacionGrupos.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>

        </div>
    </div>

@endsection