@extends('plantillas.admin_template')

@include('cajaCortes._common')

@section('header')

<ol class="breadcrumb">
	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
    <li><a href="{{ route('cajaCortes.index') }}">@yield('cajaCortesAppTitle')</a></li>
    <li class="active">{{ $cajaCorte->name }}</li>
</ol>

<div class="page-header">
        <h1>@yield('cajaCortesAppTitle') / Mostrar {{$cajaCorte->id}}

            {!! Form::model($cajaCorte, array('route' => array('cajaCortes.destroy', $cajaCorte->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? Estas seguro?')) { return true } else {return false };")) !!}
                <div class="btn-group pull-right" role="group" aria-label="...">
                    @permission('cajaCorte.edit')
                    <a class="btn btn-warning btn-group" role="group" href="{{ route('cajaCortes.edit', $cajaCorte->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                    @endpermission
                    @permission('cajaCorte.destroy')
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
                    <p class="form-control-static">{{$cajaCorte->id}}</p>
                </div>
                <div class="form-group">
                     <label for="fecha">FECHA</label>
                     <p class="form-control-static">{{$cajaCorte->fecha}}</p>
                </div>
                    <div class="form-group">
                     <label for="monto_calculado">MONTO_CALCULADO</label>
                     <p class="form-control-static">{{$cajaCorte->monto_calculado}}</p>
                </div>
                    <div class="form-group">
                     <label for="monto_real">MONTO_REAL</label>
                     <p class="form-control-static">{{$cajaCorte->monto_real}}</p>
                </div>
                    <div class="form-group">
                     <label for="faltante">FALTANTE</label>
                     <p class="form-control-static">{{$cajaCorte->faltante}}</p>
                </div>
                    <div class="form-group">
                     <label for="sobrante">SOBRANTE</label>
                     <p class="form-control-static">{{$cajaCorte->sobrante}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_alta_id">USU_ALTA_ID</label>
                     <p class="form-control-static">{{$cajaCorte->usu_alta_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_mod_id">USU_MOD_ID</label>
                     <p class="form-control-static">{{$cajaCorte->usu_mod_id}}</p>
                </div>
            </form>

            <div class="row">
                </div>

            <a class="btn btn-link" href="{{ route('cajaCortes.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>

        </div>
    </div>

@endsection