@extends('plantillas.admin_template')

@include('webhookOpenpays._common')

@section('header')

<ol class="breadcrumb">
	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
    <li><a href="{{ route('webhookOpenpays.index') }}">@yield('webhookOpenpaysAppTitle')</a></li>
    <li class="active">{{ $webhookOpenpay->name }}</li>
</ol>

<div class="page-header">
        <h1>@yield('webhookOpenpaysAppTitle') / Mostrar {{$webhookOpenpay->id}}

            {!! Form::model($webhookOpenpay, array('route' => array('webhookOpenpays.destroy', $webhookOpenpay->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? Estas seguro?')) { return true } else {return false };")) !!}
                <div class="btn-group pull-right" role="group" aria-label="...">
                    @permission('webhookOpenpay.edit')
                    <a class="btn btn-warning btn-group" role="group" href="{{ route('webhookOpenpays.edit', $webhookOpenpay->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                    @endpermission
                    @permission('webhookOpenpay.destroy')
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
                    <p class="form-control-static">{{$webhookOpenpay->id}}</p>
                </div>
                <div class="form-group">
                     <label for="openpay_id">OPENPAY_ID</label>
                     <p class="form-control-static">{{$webhookOpenpay->openpay_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="type">TYPE</label>
                     <p class="form-control-static">{{$webhookOpenpay->type}}</p>
                </div>
                    <div class="form-group">
                     <label for="verification_code">VERIFICATION_CODE</label>
                     <p class="form-control-static">{{$webhookOpenpay->verification_code}}</p>
                </div>
                    <div class="form-group">
                     <label for="event_date">EVENT_DATE</label>
                     <p class="form-control-static">{{$webhookOpenpay->event_date}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_alta_id">USU_ALTA_ID</label>
                     <p class="form-control-static">{{$webhookOpenpay->usu_alta_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_mod_id">USU_MOD_ID</label>
                     <p class="form-control-static">{{$webhookOpenpay->usu_mod_id}}</p>
                </div>
            </form>

            <div class="row">
                </div>

            <a class="btn btn-link" href="{{ route('webhookOpenpays.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>

        </div>
    </div>

@endsection