@extends('plantillas.admin_template')

@include('usoFacturas._common')

@section('header')

<ol class="breadcrumb">
	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
    <li><a href="{{ route('usoFacturas.index') }}">@yield('usoFacturasAppTitle')</a></li>
    <li class="active">{{ $usoFactura->name }}</li>
</ol>

<div class="page-header">
        <h1>@yield('usoFacturasAppTitle') / Mostrar {{$usoFactura->id}}

            {!! Form::model($usoFactura, array('route' => array('usoFacturas.destroy', $usoFactura->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? Estas seguro?')) { return true } else {return false };")) !!}
                <div class="btn-group pull-right" role="group" aria-label="...">
                    @permission('usoFactura.edit')
                    <a class="btn btn-warning btn-group" role="group" href="{{ route('usoFacturas.edit', $usoFactura->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                    @endpermission
                    @permission('usoFactura.destroy')
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
                    <p class="form-control-static">{{$usoFactura->id}}</p>
                </div>
                <div class="form-group">
                     <label for="clave">CLAVE</label>
                     <p class="form-control-static">{{$usoFactura->clave}}</p>
                </div>
                    <div class="form-group">
                     <label for="descripcion">DESCRIPCION</label>
                     <p class="form-control-static">{{$usoFactura->descripcion}}</p>
                </div>
                    <div class="form-group">
                     <label for="bnd_fisica">BND_FISICA</label>
                     <p class="form-control-static">{{$usoFactura->bnd_fisica}}</p>
                </div>
                    <div class="form-group">
                     <label for="bnd_moral">BND_MORAL</label>
                     <p class="form-control-static">{{$usoFactura->bnd_moral}}</p>
                </div>
                    <div class="form-group">
                     <label for=" usu_alta_id"> USU_ALTA_ID</label>
                     <p class="form-control-static">{{$usoFactura-> usu_alta_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_mod_id">USU_MOD_ID</label>
                     <p class="form-control-static">{{$usoFactura->usu_mod_id}}</p>
                </div>
            </form>

            <div class="row">
                </div>

            <a class="btn btn-link" href="{{ route('usoFacturas.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>

        </div>
    </div>

@endsection