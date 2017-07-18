@extends('plantillas.admin_template')

@include('seguimientos._common')

@section('header')

<ol class="breadcrumb">
	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
    <li><a href="{{ route('seguimientos.index') }}">@yield('seguimientosAppTitle')</a></li>
    <li class="active">{{ $seguimiento->id }}</li>
</ol>

<div class="page-header">
        <h1>@yield('seguimientosAppTitle') / Estatus {{$seguimiento->estatus->name}}

            {!! Form::model($seguimiento, array('route' => array('seguimientos.destroy', $seguimiento->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? Estas seguro?')) { return true } else {return false };")) !!}
                <div class="btn-group pull-right" role="group" aria-label="...">
                    @permission('seguimiento.edit')
                    <a class="btn btn-warning btn-group" role="group" href="{{ route('seguimientos.edit', $seguimiento->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                    @endpermission
                    @permission('seguimiento.destroy')
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
                <div class="form-group col-sm-2 ">
                     <label for="cliente_id">CLIENTE</label>
                     <p class="form-control-static"><label for="cliente_id">Nombre Completo:</label> {{$seguimiento->cliente->nombre." ".$seguimiento->cliente->nombre2." ".$seguimiento->cliente->ape_paterno." ".$seguimiento->cliente->ape_materno}}</p>
                     <p class="form-control-static"><label for="cliente_id">Tel. Fijo:</label> {{$seguimiento->cliente->tel_fijo}}</p>
                     <p class="form-control-static"><label for="cliente_id">Tel. Celular:</label> {{$seguimiento->cliente->tel_cel}}</p>
                     <p class="form-control-static"><label for="cliente_id">E-mail:</label> {{$seguimiento->cliente->mail}}</p>
                     <p class="form-control-static"><label for="cliente_id">Dirección:</label> {{
                         $seguimiento->cliente->calle." ".$seguimiento->cliente->no_ext." ".$seguimiento->cliente->colonia." ".$seguimiento->cliente->municipio->name}}
                     </p>
                </div>
            </form>

            <div class="row">
            </div>

            <a class="btn btn-link" href="{{ route('clientes.index', $seguimiento->cliente_id) }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>

        </div>
    </div>

@endsection