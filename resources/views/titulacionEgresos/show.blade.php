@extends('plantillas.admin_template')

@include('titulacionEgresos._common')

@section('header')

<ol class="breadcrumb">
	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
    <li><a href="{{ route('titulacionEgresos.index') }}">@yield('titulacionEgresosAppTitle')</a></li>
    <li class="active">{{ $titulacionEgreso->name }}</li>
</ol>

<div class="page-header">
        <h1>@yield('titulacionEgresosAppTitle') / Mostrar {{$titulacionEgreso->id}}

            {!! Form::model($titulacionEgreso, array('route' => array('titulacionEgresos.destroy', $titulacionEgreso->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? Estas seguro?')) { return true } else {return false };")) !!}
                <div class="btn-group pull-right" role="group" aria-label="...">
                    @permission('titulacionEgreso.edit')
                    <a class="btn btn-warning btn-group" role="group" href="{{ route('titulacionEgresos.edit', $titulacionEgreso->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                    @endpermission
                    @permission('titulacionEgreso.destroy')
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
                    <p class="form-control-static">{{$titulacionEgreso->id}}</p>
                </div>
                <div class="form-group col-sm-4">
                     <label for="titulacion_grupo_name">GRUPO</label>
                     <p class="form-control-static">{{$titulacionEgreso->titulacionGrupo->name}}</p>
                </div>
                    <div class="form-group col-sm-4">
                     <label for="titulacion_concepto_name">CONCEPTO</label>
                     <p class="form-control-static">{{$titulacionEgreso->titulacionConcepto->name}}</p>
                </div>
                    <div class="form-group col-sm-4">
                     <label for="monto">MONTO</label>
                     <p class="form-control-static">{{$titulacionEgreso->monto}}</p>
                </div>
                    <div class="form-group col-sm-4">
                     <label for="fecha">FECHA</label>
                     <p class="form-control-static">{{$titulacionEgreso->fecha}}</p>
                </div>
                    <div class="form-group col-sm-4">
                     <label for="observacion">OBSERVACION</label>
                     <p class="form-control-static">{{$titulacionEgreso->observacion}}</p>
                </div>
                    <div class="form-group col-sm-4">
                     <label for="usu_alta_id">ALTA</label>
                     <p class="form-control-static">{{$titulacionEgreso->usu_alta->name}}</p>
                </div>
                    <div class="form-group col-sm-4">
                     <label for="usu_mod_id">U. MODIFICACION</label>
                     <p class="form-control-static">{{$titulacionEgreso->usu_mod->name}}</p>
                </div>
            </form>

            <div class="row">
                </div>

            <a class="btn btn-link" href="{{ route('titulacionEgresos.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>

        </div>
    </div>

@endsection