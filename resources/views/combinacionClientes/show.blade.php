@extends('plantillas.admin_template')

@include('combinacionClientes._common')

@section('header')

<ol class="breadcrumb">
	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
    <li><a href="{{ route('combinacionClientes.index') }}">@yield('combinacionClientesAppTitle')</a></li>
    <li class="active">{{ $combinacionCliente->name }}</li>
</ol>

<div class="page-header">
        <h1>@yield('combinacionClientesAppTitle') / Mostrar {{$combinacionCliente->id}}

            {!! Form::model($combinacionCliente, array('route' => array('combinacionClientes.destroy', $combinacionCliente->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? Estas seguro?')) { return true } else {return false };")) !!}
                <div class="btn-group pull-right" role="group" aria-label="...">
                    @permission('combinacionCliente.edit')
                    <a class="btn btn-warning btn-group" role="group" href="{{ route('combinacionClientes.edit', $combinacionCliente->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                    @endpermission
                    @permission('combinacionCliente.destroy')
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
                    <p class="form-control-static">{{$combinacionCliente->id}}</p>
                </div>
                <div class="form-group">
                     <label for="cliente_nombre">CLIENTE_NOMBRE</label>
                     <p class="form-control-static">{{$combinacionCliente->cliente->nombre}}</p>
                </div>
                    <div class="form-group">
                     <label for="plantel_razon">PLANTEL_RAZON</label>
                     <p class="form-control-static">{{$combinacionCliente->plantel->razon}}</p>
                </div>
                    <div class="form-group">
                     <label for="especialidad_id">ESPECIALIDAD_ID</label>
                     <p class="form-control-static">{{$combinacionCliente->especialidad_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="nivel_id">NIVEL_ID</label>
                     <p class="form-control-static">{{$combinacionCliente->nivel_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="grado_id">GRADO_ID</label>
                     <p class="form-control-static">{{$combinacionCliente->grado_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="turno_id">TURNO_ID</label>
                     <p class="form-control-static">{{$combinacionCliente->turno_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="bnd_inscrito">BND_INSCRITO</label>
                     <p class="form-control-static">{{$combinacionCliente->bnd_inscrito}}</p>
                </div>
                    <div class="form-group">
                     <label for="fec_inscrito">FEC_INSCRITO</label>
                     <p class="form-control-static">{{$combinacionCliente->fec_inscrito}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_alta_id">USU_ALTA_ID</label>
                     <p class="form-control-static">{{$combinacionCliente->usu_alta_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_mod_id">USU_MOD_ID</label>
                     <p class="form-control-static">{{$combinacionCliente->usu_mod_id}}</p>
                </div>
            </form>

            <div class="row">
                </div>

            <a class="btn btn-link" href="{{ route('combinacionClientes.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>

        </div>
    </div>

@endsection