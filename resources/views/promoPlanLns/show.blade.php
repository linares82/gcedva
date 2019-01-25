@extends('plantillas.admin_template')

@include('promoPlanLns._common')

@section('header')

<ol class="breadcrumb">
	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
    <li><a href="{{ route('promoPlanLns.index') }}">@yield('promoPlanLnsAppTitle')</a></li>
    <li class="active">{{ $promoPlanLn->name }}</li>
</ol>

<div class="page-header">
        <h1>@yield('promoPlanLnsAppTitle') / Mostrar {{$promoPlanLn->id}}

            {!! Form::model($promoPlanLn, array('route' => array('promoPlanLns.destroy', $promoPlanLn->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? Estas seguro?')) { return true } else {return false };")) !!}
                <div class="btn-group pull-right" role="group" aria-label="...">
                    @permission('promoPlanLn.edit')
                    <a class="btn btn-warning btn-group" role="group" href="{{ route('promoPlanLns.edit', $promoPlanLn->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                    @endpermission
                    @permission('promoPlanLn.destroy')
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
                    <p class="form-control-static">{{$promoPlanLn->id}}</p>
                </div>
                <div class="form-group">
                     <label for="plan_pago_ln_monto">PLAN_PAGO_LN_MONTO</label>
                     <p class="form-control-static">{{$promoPlanLn->planPagoLn->monto}}</p>
                </div>
                    <div class="form-group">
                     <label for="fec_inicio">FEC_INICIO</label>
                     <p class="form-control-static">{{$promoPlanLn->fec_inicio}}</p>
                </div>
                    <div class="form-group">
                     <label for="fec_fin">FEC_FIN</label>
                     <p class="form-control-static">{{$promoPlanLn->fec_fin}}</p>
                </div>
                    <div class="form-group">
                     <label for="descuento">DESCUENTO</label>
                     <p class="form-control-static">{{$promoPlanLn->descuento}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_alta_id">USU_ALTA_ID</label>
                     <p class="form-control-static">{{$promoPlanLn->usu_alta_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_mod_id">USU_MOD_ID</label>
                     <p class="form-control-static">{{$promoPlanLn->usu_mod_id}}</p>
                </div>
            </form>

            <div class="row">
                </div>

            <a class="btn btn-link" href="{{ route('promoPlanLns.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>

        </div>
    </div>

@endsection