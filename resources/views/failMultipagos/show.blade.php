@extends('plantillas.admin_template')

@include('failMultipagos._common')

@section('header')

<ol class="breadcrumb">
	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
    <li><a href="{{ route('failMultipagos.index') }}">@yield('failMultipagosAppTitle')</a></li>
    <li class="active">{{ $failMultipago->name }}</li>
</ol>

<div class="page-header">
        <h1>@yield('failMultipagosAppTitle') / Mostrar {{$failMultipago->id}}

            {!! Form::model($failMultipago, array('route' => array('failMultipagos.destroy', $failMultipago->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? Estas seguro?')) { return true } else {return false };")) !!}
                <div class="btn-group pull-right" role="group" aria-label="...">
                    @permission('failMultipago.edit')
                    <a class="btn btn-warning btn-group" role="group" href="{{ route('failMultipagos.edit', $failMultipago->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                    @endpermission
                    @permission('failMultipago.destroy')
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
                    <p class="form-control-static">{{$failMultipago->id}}</p>
                </div>
                <div class="form-group">
                     <label for="mp_order">MP_ORDER</label>
                     <p class="form-control-static">{{$failMultipago->mp_order}}</p>
                </div>
                    <div class="form-group">
                     <label for="mp_reference">MP_REFERENCE</label>
                     <p class="form-control-static">{{$failMultipago->mp_reference}}</p>
                </div>
                    <div class="form-group">
                     <label for="mp_amount">MP_AMOUNT</label>
                     <p class="form-control-static">{{$failMultipago->mp_amount}}</p>
                </div>
                    <div class="form-group">
                     <label for="mp_response">MP_RESPONSE</label>
                     <p class="form-control-static">{{$failMultipago->mp_response}}</p>
                </div>
                    <div class="form-group">
                     <label for="mp_responsemsg">MP_RESPONSEMSG</label>
                     <p class="form-control-static">{{$failMultipago->mp_responsemsg}}</p>
                </div>
                    <div class="form-group">
                     <label for="mp_authorization">MP_AUTHORIZATION</label>
                     <p class="form-control-static">{{$failMultipago->mp_authorization}}</p>
                </div>
                    <div class="form-group">
                     <label for="mp_signature">MP_SIGNATURE</label>
                     <p class="form-control-static">{{$failMultipago->mp_signature}}</p>
                </div>
                    <div class="form-group">
                     <label for=" usu_alta_id"> USU_ALTA_ID</label>
                     <p class="form-control-static">{{$failMultipago-> usu_alta_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_mod_id">USU_MOD_ID</label>
                     <p class="form-control-static">{{$failMultipago->usu_mod_id}}</p>
                </div>
            </form>

            <div class="row">
                </div>

            <a class="btn btn-link" href="{{ route('failMultipagos.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>

        </div>
    </div>

@endsection