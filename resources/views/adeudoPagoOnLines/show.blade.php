@extends('plantillas.admin_template')

@include('adeudoPagoOnLines._common')

@section('header')

<ol class="breadcrumb">
	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
    <li><a href="{{ route('adeudoPagoOnLines.index') }}">@yield('adeudoPagoOnLinesAppTitle')</a></li>
    <li class="active">{{ $adeudoPagoOnLine->name }}</li>
</ol>

<div class="page-header">
        <h1>@yield('adeudoPagoOnLinesAppTitle') / Mostrar {{$adeudoPagoOnLine->id}}

            {!! Form::model($adeudoPagoOnLine, array('route' => array('adeudoPagoOnLines.destroy', $adeudoPagoOnLine->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? Estas seguro?')) { return true } else {return false };")) !!}
                <div class="btn-group pull-right" role="group" aria-label="...">
                    @permission('adeudoPagoOnLine.edit')
                    <a class="btn btn-warning btn-group" role="group" href="{{ route('adeudoPagoOnLines.edit', $adeudoPagoOnLine->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                    @endpermission
                    @permission('adeudoPagoOnLine.destroy')
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
                    <p class="form-control-static">{{$adeudoPagoOnLine->id}}</p>
                </div>
                <div class="form-group">
                     <label for="adeudo_id">ADEUDO_ID</label>
                     <p class="form-control-static">{{$adeudoPagoOnLine->adeudo_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="subtotal">SUBTOTAL</label>
                     <p class="form-control-static">{{$adeudoPagoOnLine->subtotal}}</p>
                </div>
                    <div class="form-group">
                     <label for="descuento">DESCUENTO</label>
                     <p class="form-control-static">{{$adeudoPagoOnLine->descuento}}</p>
                </div>
                    <div class="form-group">
                     <label for="recargo">RECARGO</label>
                     <p class="form-control-static">{{$adeudoPagoOnLine->recargo}}</p>
                </div>
                    <div class="form-group">
                     <label for="cliente_id">CLIENTE_ID</label>
                     <p class="form-control-static">{{$adeudoPagoOnLine->cliente_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_alta_id">USU_ALTA_ID</label>
                     <p class="form-control-static">{{$adeudoPagoOnLine->usu_alta_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_mod_id">USU_MOD_ID</label>
                     <p class="form-control-static">{{$adeudoPagoOnLine->usu_mod_id}}</p>
                </div>
            </form>

            <div class="row">
                </div>

            <a class="btn btn-link" href="{{ route('adeudoPagoOnLines.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>

        </div>
    </div>

@endsection