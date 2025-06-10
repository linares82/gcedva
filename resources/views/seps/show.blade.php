@extends('plantillas.admin_template')

@include('seps._common')

@section('header')

<ol class="breadcrumb">
	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
    <li><a href="{{ route('seps.index') }}">@yield('sepsAppTitle')</a></li>
    <li class="active">{{ $sep->name }}</li>
</ol>

<div class="page-header">
        <h1>@yield('sepsAppTitle') / Mostrar {{$sep->id}}

            {!! Form::model($sep, array('route' => array('seps.destroy', $sep->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? Estas seguro?')) { return true } else {return false };")) !!}
                <div class="btn-group pull-right" role="group" aria-label="...">
                    @permission('sep.edit')
                    <a class="btn btn-warning btn-group" role="group" href="{{ route('seps.edit', $sep->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                    @endpermission
                    @permission('sep.destroy')
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
                    <p class="form-control-static">{{$sep->id}}</p>
                </div>
                <div class="form-group">
                     <label for="cve_institucion">CVE_INSTITUCION</label>
                     <p class="form-control-static">{{$sep->cve_institucion}}</p>
                </div>
                    <div class="form-group">
                     <label for="descripcion">DESCRIPCION</label>
                     <p class="form-control-static">{{$sep->descripcion}}</p>
                </div>
            </form>

            <div class="row">
                </div>

            <a class="btn btn-link" href="{{ route('seps.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>

        </div>
    </div>

@endsection