@extends('plantillas.admin_template')

@include('ubicacionArts._common')

@section('header')

<ol class="breadcrumb">
	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
    <li><a href="{{ route('ubicacionArts.index') }}">@yield('ubicacionArtsAppTitle')</a></li>
    <li class="active">{{ $ubicacionArt->name }}</li>
</ol>

<div class="page-header">
        <h1>@yield('ubicacionArtsAppTitle') / Mostrar {{$ubicacionArt->id}}

            {!! Form::model($ubicacionArt, array('route' => array('ubicacionArts.destroy', $ubicacionArt->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? Estas seguro?')) { return true } else {return false };")) !!}
                <div class="btn-group pull-right" role="group" aria-label="...">
                    @permission('ubicacionArt.edit')
                    <a class="btn btn-warning btn-group" role="group" href="{{ route('ubicacionArts.edit', $ubicacionArt->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                    @endpermission
                    @permission('ubicacionArt.destroy')
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
                    <p class="form-control-static">{{$ubicacionArt->id}}</p>
                </div>
                <div class="form-group col-sm-4">
                     <label for="plantel_">PLANTEL</label>
                     <p class="form-control-static">{{$ubicacionArt->plantel->razon}}</p>
                </div>
                    <div class="form-group col-sm-4">
                     <label for="ubicacion">UBICACION</label>
                     <p class="form-control-static">{{$ubicacionArt->ubicacion}}</p>
                </div>
                    <div class="form-group col-sm-4">
                     <label for="usu_alta_id">ALTA</label>
                     <p class="form-control-static">{{$ubicacionArt->usu_alta->name}}</p>
                </div>
                    <div class="form-group col-sm-4">
                     <label for="usu_mod_id">ULTIMA MODIFICACION</label>
                     <p class="form-control-static">{{$ubicacionArt->usu_mod->name}}</p>
                </div>
            </form>

            <div class="row">
                </div>

            <a class="btn btn-link" href="{{ route('ubicacionArts.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>

        </div>
    </div>

@endsection