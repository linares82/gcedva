@extends('plantillas.admin_template')

@include('autorizacionBecaComentarios._common')

@section('header')

<ol class="breadcrumb">
	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
    <li><a href="{{ route('autorizacionBecaComentarios.index') }}">@yield('autorizacionBecaComentariosAppTitle')</a></li>
    <li class="active">{{ $autorizacionBecaComentario->name }}</li>
</ol>

<div class="page-header">
        <h1>@yield('autorizacionBecaComentariosAppTitle') / Mostrar {{$autorizacionBecaComentario->id}}

            {!! Form::model($autorizacionBecaComentario, array('route' => array('autorizacionBecaComentarios.destroy', $autorizacionBecaComentario->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? Estas seguro?')) { return true } else {return false };")) !!}
                <div class="btn-group pull-right" role="group" aria-label="...">
                    @permission('autorizacionBecaComentario.edit')
                    <a class="btn btn-warning btn-group" role="group" href="{{ route('autorizacionBecaComentarios.edit', $autorizacionBecaComentario->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                    @endpermission
                    @permission('autorizacionBecaComentario.destroy')
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
                    <p class="form-control-static">{{$autorizacionBecaComentario->id}}</p>
                </div>
                <div class="form-group">
                     <label for="autorizacion_beca_solicitud">AUTORIZACION_BECA_SOLICITUD</label>
                     <p class="form-control-static">{{$autorizacionBecaComentario->autorizacionBeca->solicitud}}</p>
                </div>
                    <div class="form-group">
                     <label for="comentario">COMENTARIO</label>
                     <p class="form-control-static">{{$autorizacionBecaComentario->comentario}}</p>
                </div>
                    <div class="form-group">
                     <label for="monto_inscripcion">MONTO_INSCRIPCION</label>
                     <p class="form-control-static">{{$autorizacionBecaComentario->monto_inscripcion}}</p>
                </div>
                    <div class="form-group">
                     <label for="monto_mensualidad">MONTO_MENSUALIDAD</label>
                     <p class="form-control-static">{{$autorizacionBecaComentario->monto_mensualidad}}</p>
                </div>
                    <div class="form-group">
                     <label for="st_beca_name">ST_BECA_NAME</label>
                     <p class="form-control-static">{{$autorizacionBecaComentario->stBeca->name}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_alta_id">USU_ALTA_ID</label>
                     <p class="form-control-static">{{$autorizacionBecaComentario->usu_alta_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_mod_id">USU_MOD_ID</label>
                     <p class="form-control-static">{{$autorizacionBecaComentario->usu_mod_id}}</p>
                </div>
            </form>

            <div class="row">
                </div>

            <a class="btn btn-link" href="{{ route('autorizacionBecaComentarios.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>

        </div>
    </div>

@endsection