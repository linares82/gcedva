@extends('plantillas.admin_template')

@include('incidenciasCalificacions._common')

@section('header')

<ol class="breadcrumb">
	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
    <li><a href="{{ route('incidenciasCalificacions.index') }}">@yield('incidenciasCalificacionsAppTitle')</a></li>
    <li class="active">{{ $incidenciasCalificacion->name }}</li>
</ol>

<div class="page-header">
        <h1>@yield('incidenciasCalificacionsAppTitle') / Mostrar {{$incidenciasCalificacion->id}}

            {!! Form::model($incidenciasCalificacion, array('route' => array('incidenciasCalificacions.destroy', $incidenciasCalificacion->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? Estas seguro?')) { return true } else {return false };")) !!}
                <div class="btn-group pull-right" role="group" aria-label="...">
                    @permission('incidenciasCalificacion.edit')
                    <a class="btn btn-warning btn-group" role="group" href="{{ route('incidenciasCalificacions.edit', $incidenciasCalificacion->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                    @endpermission
                    @permission('incidenciasCalificacion.destroy')
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
                    <p class="form-control-static">{{$incidenciasCalificacion->id}}</p>
                </div>
                
                    <div class="form-group col-sm-4">
                     <label for="cliente_id">CLIENTE</label>
                     <p class="form-control-static">
                        {{$incidenciasCalificacion->cliente_id}} 
                        {{$incidenciasCalificacion->cliente->nombre}}
                        {{$incidenciasCalificacion->cliente->nombre2}}
                        {{$incidenciasCalificacion->cliente->ape_paterno}}
                        {{$incidenciasCalificacion->cliente->ape_materno}}
                    </p>
                </div>
                <div class="form-group col-sm-4">
                     <label for="calificacion_nueva">MATERIA</label>
                     <p class="form-control-static">{{$incidenciasCalificacion->materium->name}}</p>
                </div>
                <div class="form-group col-sm-4">
                     <label for="calificacion_nueva">Calificacion Ponderacion</label>
                     <p class="form-control-static">{{$incidenciasCalificacion->calificacionPonderacion->cargaPonderacion->name}}</p>
                </div>
                <div class="form-group col-sm-4">
                     <label for="calificacion_nueva">CALIFICACION ANTERIOR</label>
                     <p class="form-control-static">{{$incidenciasCalificacion->calificacionPonderacion->calificacion_parcial}}</p>
                </div>
                <div class="form-group col-sm-4">
                     <label for="calificacion_nueva">CALIFICACION NUEVA</label>
                     <p class="form-control-static">{{$incidenciasCalificacion->calificacion_nueva}}</p>
                </div>
                    <div class="form-group col-sm-4">
                     <label for="justificacion">JUSTIFICACION</label>
                     <p class="form-control-static">{{$incidenciasCalificacion->justificacion}}</p>
                </div>
                <div class="form-group col-sm-4">
                     <label for="justificacion">OBS.</label>
                     <p class="form-control-static">{{$incidenciasCalificacion->observacion}}</p>
                </div>
                <div class="form-group col-sm-4">
                     <label for="justificacion">Autorizado</label>
                     <p class="form-control-static">
                        @if($incidenciasCalificacion->bnd_autorizada==1)
                            SI
                        @else
                            NO
                        @endif
                    </p>
                </div>
                <div class="form-group col-sm-4">
                     <label for="justificacion">Rechazado</label>
                     <p class="form-control-static">
                        @if($incidenciasCalificacion->bnd_rechazada==1)
                            SI
                        @else
                            NO
                        @endif</p>
                </div>
                <div class="form-group col-sm-4">
                     <label for="fecha_ar">FECHA AUTORIZAR/RECHAZAR</label>
                     <p class="form-control-static">{{$incidenciasCalificacion->fecha_ar}}</p>
                </div>
                    <div class="form-group col-sm-4">
                     <label for="usu_alta_id">ALTA</label>
                     <p class="form-control-static"> {{$incidenciasCalificacion->created_at->format('d-m-Y')}} {{$incidenciasCalificacion->usu_alta->name}}</p>
                </div>
                    <div class="form-group col-sm-4">
                     <label for="usu_mod_id">U. MODIFICACION</label>
                     <p class="form-control-static">{{$incidenciasCalificacion->usu_mod->name}}</p>
                </div>
            </form>

            <div class="row">
                </div>

            <a class="btn btn-link" href="{{ route('incidenciasCalificacions.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>
            @permission('incidenciasCalificacions.edit')
            <a class="btn btn-warning" href="{{ route('incidenciasCalificacions.edit', $incidenciasCalificacion->id) }}"> Editar</a>
            @endpermission
            @permission('incidenciasCalificacions.autorizar')
            <a class="btn btn-success" href="{{ route('incidenciasCalificacions.autorizar', array('id'=>$incidenciasCalificacion->id)) }}">  Autorizar</a>
            @endpermission
            @permission('incidenciasCalificacions.rechazar')
            <a class="btn btn-danger" href="{{ route('incidenciasCalificacions.rechazar', array('id'=>$incidenciasCalificacion->id)) }}">  Rechazar</a>
            @endpermission    
        </div>
    </div>

@endsection