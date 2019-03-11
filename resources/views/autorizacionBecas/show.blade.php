@extends('plantillas.admin_template')

@include('autorizacionBecas._common')

@section('header')

<ol class="breadcrumb">
	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
    <li><a href="{{ route('autorizacionBecas.index') }}">@yield('autorizacionBecasAppTitle')</a></li>
    <li class="active">{{ $autorizacionBeca->name }}</li>
</ol>

<div class="page-header">
        <h1>@yield('autorizacionBecasAppTitle') / Mostrar {{$autorizacionBeca->id}}

            {!! Form::model($autorizacionBeca, array('route' => array('autorizacionBecas.destroy', $autorizacionBeca->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? Estas seguro?')) { return true } else {return false };")) !!}
                <div class="btn-group pull-right" role="group" aria-label="...">
                    @permission('autorizacionBeca.edit')
                    <a class="btn btn-warning btn-group" role="group" href="{{ route('autorizacionBecas.edit', $autorizacionBeca->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                    @endpermission
                    @permission('autorizacionBeca.destroy')
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
                    <p class="form-control-static">{{$autorizacionBeca->id}}</p>
                </div>
                <div class="form-group col-sm-4">
                     <label for="solicitud">SOLICITUD</label>
                     <p class="form-control-static">{{$autorizacionBeca->solicitud}}</p>
                </div>
                    <div class="form-group col-sm-4">
                     <label for="cliente_nombre">CLIENTE</label>
                     <p class="form-control-static">{{$autorizacionBeca->cliente->nombre." ".$autorizacionBeca->cliente->nombre2." ".$autorizacionBeca->cliente->ape_paterno." ".$autorizacionBeca->cliente->ape_materno}}</p>
                </div>
                    <div class="form-group col-sm-4">
                     <label for="monto_inscripcion">MONTO INSCRIPCION</label>
                     <p class="form-control-static">{{$autorizacionBeca->monto_inscripcion}}</p>
                </div>
                    <div class="form-group col-sm-4">
                     <label for="monto_mensualidad">MONTO MENSUALIDAD</label>
                     <p class="form-control-static">{{$autorizacionBeca->monto_mensualidad}}</p>
                </div>
                    <div class="form-group col-sm-4">
                     <label for="st_beca_name">ESTATUS</label>
                     <p class="form-control-static">{{$autorizacionBeca->stBeca->name}}</p>
                </div>
                    <div class="form-group col-sm-4">
                     <label for="usu_alta_id">ALTA</label>
                     <p class="form-control-static">{{$autorizacionBeca->usu_alta->name}}</p>
                </div>
                    <div class="form-group col-sm-4">
                     <label for="usu_mod_id">ULTIMA MODIFICACION</label>
                     <p class="form-control-static">{{$autorizacionBeca->usu_mod->name}}</p>
                </div>
            </form>

            <div class="row">
                </div>

            <a class="btn btn-link" href="{{ route('autorizacionBecas.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>

        </div>
    </div>

<table class='table table-bordered table-condensed table-hover table-striped'>
    <thead >
        <th>Comentario</th>
        <th>Monto Inscripcion</th>
        <th>Monto Mensualidad</th>
        <th>Estatus</th>
        <th>Alta</th>
        <th>Creado</th>
    </thead>
    <tbody>
        @foreach($autorizacionBeca->autorizacionBecaComentarios as $comentario)
        <tr>
            <td>{{$comentario->comentario}}</td>
            <td>{{$comentario->monto_inscripcion}}</td>
            <td>{{$comentario->monto_mensualidad}}</td>
            <td>{{$comentario->stBeca->name}}</td>
            <td>{{$comentario->usu_alta->name}}</td>
            <td>{{$comentario->created_at}}</td>
        </tr>
        @endforeach
    </tbody>
</table>

@endsection