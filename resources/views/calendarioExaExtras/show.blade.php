@extends('plantillas.admin_template')

@include('calendarioExaExtras._common')

@section('header')

<ol class="breadcrumb">
	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
    <li><a href="{{ route('calendarioExaExtras.index') }}">@yield('calendarioExaExtrasAppTitle')</a></li>
    <li class="active">{{ $calendarioExaExtra->name }}</li>
</ol>

<div class="page-header">
        <h1>@yield('calendarioExaExtrasAppTitle') / Mostrar {{$calendarioExaExtra->id}}

            {!! Form::model($calendarioExaExtra, array('route' => array('calendarioExaExtras.destroy', $calendarioExaExtra->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? Estas seguro?')) { return true } else {return false };")) !!}
                <div class="btn-group pull-right" role="group" aria-label="...">
                    @permission('calendarioExaExtra.edit')
                    <a class="btn btn-warning btn-group" role="group" href="{{ route('calendarioExaExtras.edit', $calendarioExaExtra->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                    @endpermission
                    @permission('calendarioExaExtra.destroy')
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
                    <p class="form-control-static">{{$calendarioExaExtra->id}}</p>
                </div>
                <div class="form-group col-sm-4">
                     <label for="plantel_razon">PLANTEL</label>
                     <p class="form-control-static">{{$calendarioExaExtra->plantel->razon}}</p>
                </div>
                    <div class="form-group col-sm-4">
                     <label for="duracion_periodo_name">DURACION</label>
                     <p class="form-control-static">{{$calendarioExaExtra->duracionPeriodo->name}}</p>
                </div>
                    <div class="form-group col-sm-4">
                     <label for="fec_inicio">FEC. INICIO</label>
                     <p class="form-control-static">{{$calendarioExaExtra->fec_inicio}}</p>
                </div>
                    <div class="form-group col-sm-4">
                     <label for="fec_fin">FEC. FIN</label>
                     <p class="form-control-static">{{$calendarioExaExtra->fec_fin}}</p>
                </div>
                    <div class="form-group col-sm-4">
                     <label for="usu_alta_id">U. ALTA</label>
                     <p class="form-control-static">{{$calendarioExaExtra->usu_alta->name}}</p>
                </div>
                    <div class="form-group col-sm-4">
                     <label for="usu_mod_id">U. MODIFICACION</label>
                     <p class="form-control-static">{{$calendarioExaExtra->usu_mod->name}}</p>
                </div>
            </form>

            <div class="row">
                </div>

            <a class="btn btn-link" href="{{ route('calendarioExaExtras.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>

        </div>
    </div>

@endsection