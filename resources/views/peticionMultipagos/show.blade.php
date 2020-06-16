@extends('plantillas.admin_template')

@include('peticionMultipagos._common')

@section('header')

<ol class="breadcrumb">
	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
    <li><a href="{{ route('peticionMultipagos.index') }}">@yield('peticionMultipagosAppTitle')</a></li>
    <li class="active">{{ $peticionMultipago->name }}</li>
</ol>

<div class="page-header">
        <h1>@yield('peticionMultipagosAppTitle') / Mostrar {{$peticionMultipago->id}}

            {!! Form::model($peticionMultipago, array('route' => array('peticionMultipagos.destroy', $peticionMultipago->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? Estas seguro?')) { return true } else {return false };")) !!}
                <div class="btn-group pull-right" role="group" aria-label="...">
                    @permission('peticionMultipago.edit')
                    <a class="btn btn-warning btn-group" role="group" href="{{ route('peticionMultipagos.edit', $peticionMultipago->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                    @endpermission
                    @permission('peticionMultipago.destroy')
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
                    <p class="form-control-static">{{$peticionMultipago->id}}</p>
                </div>
                <div class="form-group">
                     <label for="mp_account">MP_ACCOUNT</label>
                     <p class="form-control-static">{{$peticionMultipago->mp_account}}</p>
                </div>
                    <div class="form-group">
                     <label for="mp_product">MP_PRODUCT</label>
                     <p class="form-control-static">{{$peticionMultipago->mp_product}}</p>
                </div>
                    <div class="form-group">
                     <label for="mp_order">MP_ORDER</label>
                     <p class="form-control-static">{{$peticionMultipago->mp_order}}</p>
                </div>
                    <div class="form-group">
                     <label for="mp_reference">MP_REFERENCE</label>
                     <p class="form-control-static">{{$peticionMultipago->mp_reference}}</p>
                </div>
                    <div class="form-group">
                     <label for="mp_node">MP_NODE</label>
                     <p class="form-control-static">{{$peticionMultipago->mp_node}}</p>
                </div>
                    <div class="form-group">
                     <label for="mp_concept">MP_CONCEPT</label>
                     <p class="form-control-static">{{$peticionMultipago->mp_concept}}</p>
                </div>
                    <div class="form-group">
                     <label for="mp_amount">MP_AMOUNT</label>
                     <p class="form-control-static">{{$peticionMultipago->mp_amount}}</p>
                </div>
                    <div class="form-group">
                     <label for="mp_customername">MP_CUSTOMERNAME</label>
                     <p class="form-control-static">{{$peticionMultipago->mp_customername}}</p>
                </div>
                    <div class="form-group">
                     <label for="mp_currency">MP_CURRENCY</label>
                     <p class="form-control-static">{{$peticionMultipago->mp_currency}}</p>
                </div>
                    <div class="form-group">
                     <label for="mp_signature">MP_SIGNATURE</label>
                     <p class="form-control-static">{{$peticionMultipago->mp_signature}}</p>
                </div>
                    <div class="form-group">
                     <label for="mp_urlsuccess">MP_URLSUCCESS</label>
                     <p class="form-control-static">{{$peticionMultipago->mp_urlsuccess}}</p>
                </div>
                    <div class="form-group">
                     <label for="mp_urlfailure">MP_URLFAILURE</label>
                     <p class="form-control-static">{{$peticionMultipago->mp_urlfailure}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_alta_id">USU_ALTA_ID</label>
                     <p class="form-control-static">{{$peticionMultipago->usu_alta_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_mod_id">USU_MOD_ID</label>
                     <p class="form-control-static">{{$peticionMultipago->usu_mod_id}}</p>
                </div>
            </form>

            <div class="row">
                </div>

            <a class="btn btn-link" href="{{ route('peticionMultipagos.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>

        </div>
    </div>

@endsection