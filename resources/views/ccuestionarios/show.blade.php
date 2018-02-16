@extends('plantillas.admin_template')

@include('ccuestionarios._common')

@section('header')

<ol class="breadcrumb">
	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
    <li><a href="{{ route('ccuestionarios.index') }}">@yield('ccuestionariosAppTitle')</a></li>
    <li class="active">{{ $ccuestionario->name }}</li>
</ol>

<div class="page-header">
        <h1>@yield('ccuestionariosAppTitle') / Mostrar {{$ccuestionario->id}}

            {!! Form::model($ccuestionario, array('route' => array('ccuestionarios.destroy', $ccuestionario->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? Estas seguro?')) { return true } else {return false };")) !!}
                <div class="btn-group pull-right" role="group" aria-label="...">
                    @permission('ccuestionario.edit')
                    <a class="btn btn-warning btn-group" role="group" href="{{ route('ccuestionarios.edit', $ccuestionario->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                    @endpermission
                    @permission('ccuestionario.destroy')
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
                    <p class="form-control-static">{{$ccuestionario->id}}</p>
                </div>
                <div class="form-group col-sm-4">
                     <label for="st_cuestionario_name">ESTATUS</label>
                     <p class="form-control-static">{{$ccuestionario->stCuestionario->name}}</p>
                </div>
                    <div class="form-group col-sm-4">
                     <label for="name">CUESTIONARIO</label>
                     <p class="form-control-static">{{$ccuestionario->name}}</p>
                </div>
                    <div class="form-group col-sm-4">
                     <label for="usu_mod_id">ULTIMA MODIFICACION</label>
                     <p class="form-control-static">{{$ccuestionario->usu_mod->name}}</p>
                </div>
                    <div class="form-group col-sm-4">
                     <label for="usu_alta_id">ALTA</label>
                     <p class="form-control-static">{{$ccuestionario->usu_alta->name}}</p>
                </div>
            </form>

            <div class="row">
                </div>

            @permission('ccuestionarioPreguntas.create')
            <a class="btn btn-success btn-xs pull-left" href="{{ route('ccuestionarioPreguntas.create',array('cuestionario'=>$ccuestionario->id)) }}"><i class="glyphicon glyphicon-plus"></i> Crear Pregunta</a>
            @endpermission
            
            @if(isset($ccuestionario->ccuestionarioPreguntas))
            <table class="table table-condensed table-striped">
                <thead>
                    <th>NUMERO</th>
                    <th>PREGUNTA</th>
                    <th></th>
                    <th></th>
                </thead>
                <tbody>
                    @foreach($ccuestionario->ccuestionarioPreguntas as $p)
                    <tr>
                        <td>{{$p->numero}}</td>
                        <td>{{$p->name}}</td>
                        <td>
                            @if(isset($p->ccuestionarioRespuesta))
                            <table class="table table-condensed table-striped">
                                <thead>
                                    <th>Clave</th>
                                    <th>Respuesta</th>
                                    <th></th>
                                </thead>
                                <tbody>
                                    @foreach($p->ccuestionarioRespuesta as $r)
                                    <tr>
                                        <td>{{$r->clave}}</td>
                                        <td>{{$r->name}}</td>
                                        <td>
                                            @permission('ccuestionarioRespuestas.edit')
                                            <a class="btn btn-xs btn-warning" href="{{ route('ccuestionarioRespuestas.edit', $r->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar Respuesta</a>
                                            @endpermission
                                            <br/>
                                            @permission('ccuestionarioRespuestas.destroy')
                                                <a href="{!! route('ccuestionarioRespuestas.destroy', $r->id) !!}" class="btn btn-xs btn-danger">Eliminar Respuesta</a>
                                            @endpermission
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @endif
                        </td>
                        <td>
                            @permission('ccuestionarioRespuestas.create')
                            <a class="btn btn-success btn-xs" href="{{ route('ccuestionarioRespuestas.create', array('cuestionario'=>$ccuestionario->id, 'pregunta'=>$p->id)) }}"><i class="glyphicon glyphicon-plus"></i> Crear Respuesta</a>
                            @endpermission
                            <br/>
                            @permission('ccuestionarioPreguntas.edit')
                            <a class="btn btn-xs btn-warning" href="{{ route('ccuestionarioPreguntas.edit', $p->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar Pregunta</a>
                            @endpermission
                            <br/>
                            @permission('ccuestionarioPreguntas.destroy')
                                <a href="{!! route('ccuestionarioPreguntas.destroy', $p->id) !!}" class="btn btn-xs btn-danger">Eliminar Pregunta</a>
                            @endpermission
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @endif
            
            <a class="btn btn-link" href="{{ route('ccuestionarios.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>

        </div>
    </div>

@endsection