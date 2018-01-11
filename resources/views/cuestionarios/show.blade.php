@extends('plantillas.admin_template')

@include('cuestionarios._common')

@section('header')

<ol class="breadcrumb">
	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
    <li><a href="{{ route('cuestionarios.index') }}">@yield('cuestionariosAppTitle')</a></li>
    <li class="active">{{ $cuestionario->name }}</li>
</ol>

<div class="page-header">
        <h1>@yield('cuestionariosAppTitle') / Mostrar {{$cuestionario->id}}

            {!! Form::model($cuestionario, array('route' => array('cuestionarios.destroy', $cuestionario->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? Estas seguro?')) { return true } else {return false };")) !!}
                <div class="btn-group pull-right" role="group" aria-label="...">
                    @permission('cuestionario.edit')
                    <a class="btn btn-warning btn-group" role="group" href="{{ route('cuestionarios.edit', $cuestionario->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                    @endpermission
                    @permission('cuestionario.destroy')
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
                    <p class="form-control-static">{{$cuestionario->id}}</p>
                </div>
                <div class="form-group col-sm-4">
                     <label for="st_cuestionario_id">ESTATUS</label>
                     <p class="form-control-static">{{$cuestionario->stCuestionario->name}}</p>
                </div>
                    <div class="form-group col-sm-4">
                     <label for="name">CUESTIONARIO</label>
                     <p class="form-control-static">{{$cuestionario->name}}</p>
                </div>
                    <div class="form-group col-sm-4">
                     <label for="usu_alta_id">ALTA</label>
                     <p class="form-control-static">{{$cuestionario->usu_alta->name}}</p>
                </div>
                    <div class="form-group col-sm-4">
                     <label for="usu_mod_id">ULTIMA MODIFICACION</label>
                     <p class="form-control-static">{{$cuestionario->usu_mod->name}}</p>
                </div>
            </form>

            <div class="row">
            </div>
            
            @permission('cuestionarioPreguntas.create')
            <a class="btn btn-success btn-xs pull-left" href="{{ route('cuestionarioPreguntas.create',array('cuestionario'=>$cuestionario->id)) }}"><i class="glyphicon glyphicon-plus"></i> Crear Pregunta</a>
            @endpermission
            
            @if(isset($cuestionario->preguntas))
            <table class="table table-condensed table-striped">
                <thead>
                    <th>NUMERO</th>
                    <th>PREGUNTA</th>
                    <th></th>
                    <th></th>
                </thead>
                <tbody>
                    @foreach($cuestionario->preguntas as $p)
                    <tr>
                        <td>{{$p->numero}}</td>
                        <td>{{$p->name}}</td>
                        <td>
                            @if(isset($p->respuestas))
                            <table class="table table-condensed table-striped">
                                <thead>
                                    <th>Clave</th>
                                    <th>Respuesta</th>
                                    <th></th>
                                </thead>
                                <tbody>
                                    @foreach($p->respuestas as $r)
                                    <tr>
                                        <td>{{$r->clave}}</td>
                                        <td>{{$r->name}}</td>
                                        <td>
                                            @permission('cuestionarioRespuestas.destroy')
                                                <a href="{!! route('cuestionarioRespuestas.destroy', $r->id) !!}" class="btn btn-xs btn-danger">Eliminar Respuesta</a>
                                            @endpermission
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @endif
                        </td>
                        <td>
                            @permission('cuestionarioRespuestas.create')
                            <a class="btn btn-success btn-xs" href="{{ route('cuestionarioRespuestas.create', array('cuestionario'=>$cuestionario->id, 'pregunta'=>$p->id)) }}"><i class="glyphicon glyphicon-plus"></i> Crear Respuesta</a>
                            @endpermission
                            <br/>
                            @permission('cuestionarioPreguntas.destroy')
                                <a href="{!! route('cuestionarioPreguntas.destroy', $p->id) !!}" class="btn btn-xs btn-danger">Eliminar Pregunta</a>
                            @endpermission
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @endif
            <a class="btn btn-link" href="{{ route('cuestionarios.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>

        </div>
    </div>

@endsection