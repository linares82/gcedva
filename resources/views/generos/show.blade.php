@extends('plantillas.admin_template')

@include('generos._common')

@section('header')

<ol class="breadcrumb">
	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
    <li><a href="{{ route('generos.index') }}">@yield('generosAppTitle')</a></li>
    <li class="active">{{ $genero->name }}</li>
</ol>

<div class="page-header">
        <h1>@yield('generosAppTitle') / Mostrar {{$genero->id}}

            {!! Form::model($genero, array('route' => array('generos.destroy', $genero->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? Estas seguro?')) { return true } else {return false };")) !!}
                <div class="btn-group pull-right" role="group" aria-label="...">
                    @permission('genero.edit')
                    <a class="btn btn-warning btn-group" role="group" href="{{ route('generos.edit', $genero->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                    @endpermission
                    @permission('genero.destroy')
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
                    <p class="form-control-static">{{$genero->id}}</p>
                </div>
                <div class="form-group">
                     <label for="name">NAME</label>
                     <p class="form-control-static">{{$genero->name}}</p>
                </div>
                    <div class="form-group">
                     <label for="cve_sep_cert">CVE_SEP_CERT</label>
                     <p class="form-control-static">{{$genero->cve_sep_cert}}</p>
                </div>
            </form>

            <div class="row">
                </div>

            <a class="btn btn-link" href="{{ route('generos.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>

        </div>
    </div>

@endsection