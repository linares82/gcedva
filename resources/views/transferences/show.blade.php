@extends('plantillas.admin_template')

@include('transferences._common')

@section('header')

<ol class="breadcrumb">
	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
    <li><a href="{{ route('transferences.index') }}">@yield('transferencesAppTitle')</a></li>
    <li class="active">{{ $transference->name }}</li>
</ol>

<div class="page-header">
        <h1>@yield('transferencesAppTitle') / Mostrar {{$transference->id}}

            {!! Form::model($transference, array('route' => array('transferences.destroy', $transference->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? Estas seguro?')) { return true } else {return false };")) !!}
                <div class="btn-group pull-right" role="group" aria-label="...">
                    @permission('transference.edit')
                    <a class="btn btn-warning btn-group" role="group" href="{{ route('transferences.edit', $transference->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                    @endpermission
                    @permission('transference.destroy')
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
                    <p class="form-control-static">{{$transference->id}}</p>
                </div>
                <div class="form-group col-sm-4">
                     <label for="origen_id">ORIGEN</label>
                     <p class="form-control-static">{{$transference->origen->name}}</p>
                </div>
                    <div class="form-group col-sm-4">
                     <label for="destino_id">DESTINO</label>
                     <p class="form-control-static">{{$transference->destino->name}}</p>
                </div>
                    <div class="form-group col-sm-4">
                     <label for="monto">MONTO</label>
                     <p class="form-control-static">{{$transference->monto}}</p>
                </div>
                    <div class="form-group col-sm-4">
                     <label for="fecha">FECHA</label>
                     <p class="form-control-static">{{$transference->fecha}}</p>
                </div>
                    <div class="form-group col-sm-4">
                     <label for="responsable_id">RESPONSABLE</label>
                     <p class="form-control-static">{{$transference->responsable->nombre}} {{$transference->responsable->ape_paterno}} {{$transference->responsable->ape_materno}}</p>
                </div>
                    <div class="form-group col-sm-4">
                     <label for="plantel_razon">PLANTEL</label>
                     <p class="form-control-static">{{$transference->plantel->razon}}</p>
                </div>
                    <div class="form-group col-sm-4">
                     <label for="motivo">MOTIVO</label>
                     <p class="form-control-static">{{$transference->motivo}}</p>
                </div>
                    <div class="form-group col-sm-4">
                     <label for="usu_alta_id">USU_ALTA_ID</label>
                     <p class="form-control-static">{{$transference->usu_alta->name}}</p>
                </div>
                    <div class="form-group col-sm-4">
                     <label for="usu_mod_id">ULTIMA MODIFICACION</label>
                     <p class="form-control-static">{{$transference->usu_mod->name}}</p>
                </div>
            </form>

            <div class="row">
                </div>

            <a class="btn btn-link" href="{{ route('transferences.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>

        </div>
    </div>

@endsection