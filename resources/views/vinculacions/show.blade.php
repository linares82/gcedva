@extends('plantillas.admin_template')

@include('vinculacions._common')

@section('header')

<ol class="breadcrumb">
	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
    <li><a href="{{ route('vinculacions.index') }}">@yield('vinculacionsAppTitle')</a></li>
    <li class="active">{{ $vinculacion->name }}</li>
</ol>

<div class="page-header">
        <h1>@yield('vinculacionsAppTitle') / Mostrar {{$vinculacion->id}}

            {!! Form::model($vinculacion, array('route' => array('vinculacions.destroy', $vinculacion->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? Estas seguro?')) { return true } else {return false };")) !!}
                <div class="btn-group pull-right" role="group" aria-label="...">
                    @permission('vinculacion.edit')
                    <a class="btn btn-warning btn-group" role="group" href="{{ route('vinculacions.edit', $vinculacion->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                    @endpermission
                    @permission('vinculacion.destroy')
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
                    <p class="form-control-static">{{$vinculacion->id}}</p>
                </div>
                <div class="form-group">
                     <label for="cliente_nombre">CLIENTE_NOMBRE</label>
                     <p class="form-control-static">{{$vinculacion->cliente->nombre}}</p>
                </div>
                    <div class="form-group">
                     <label for="lugar_practica">EMPRESA</label>
                     <p class="form-control-static">{{$vinculacion->lugar_practica}}</p>
                </div>
                    <div class="form-group">
                     <label for="tel_fijo">TEL. FIJO</label>
                     <p class="form-control-static">{{$vinculacion->tel_fijo}}</p>
                </div>
                    <div class="form-group">
                     <label for="nombre_contacto">NOMBRE CONTACTO</label>
                     <p class="form-control-static">{{$vinculacion->nombre_contacto}}</p>
                </div>
                    <div class="form-group">
                     <label for="mail_contacto">MAIL CONTACTO</label>
                     <p class="form-control-static">{{$vinculacion->mail_contacto}}</p>
                </div>
                    <div class="form-group">
                     <label for="fec_inicio">FEC. INICIO</label>
                     <p class="form-control-static">{{$vinculacion->fec_inicio}}</p>
                </div>
                    <div class="form-group">
                     <label for="fec_fin">FEC. FIN</label>
                     <p class="form-control-static">{{$vinculacion->fec_fin}}</p>
                </div>
                    <div class="form-group">
                     <label for="bnd_constancia_entregada">DV4 ENTREGADA</label>
                     <p class="form-control-static">{{$vinculacion->bnd_constancia_entregada}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_alta_id">ALTA</label>
                     <p class="form-control-static">{{$vinculacion->usu_alta->name}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_mod_id">ULTIMA MODIFICACION</label>
                     <p class="form-control-static">{{$vinculacion->usu_mod->name}}</p>
                </div>
            </form>

            <div class="row">
                </div>

            <a class="btn btn-link" href="{{ route('vinculacions.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>

        </div>
    </div>

@endsection