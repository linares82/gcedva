@extends('plantillas.admin_template')

@include('avisosInicios._common')

@section('header')

<ol class="breadcrumb">
	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
    <li><a href="{{ route('avisosInicios.index') }}">@yield('avisosIniciosAppTitle')</a></li>
    <li class="active">{{ $avisosInicio->name }}</li>
</ol>

<div class="page-header">
        <h1>@yield('avisosIniciosAppTitle') / Mostrar {{$avisosInicio->id}}

            {!! Form::model($avisosInicio, array('route' => array('avisosInicios.destroy', $avisosInicio->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? Estas seguro?')) { return true } else {return false };")) !!}
                <div class="btn-group pull-right" role="group" aria-label="...">
                    @permission('avisosInicio.edit')
                    <a class="btn btn-warning btn-group" role="group" href="{{ route('avisosInicios.edit', $avisosInicio->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                    @endpermission
                    @permission('avisosInicio.destroy')
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
                    <p class="form-control-static">{{$avisosInicio->id}}</p>
                </div>
                <div class="form-group col-sm-4">
                     <label for="orden">ORDEN</label>
                     <p class="form-control-static">{{$avisosInicio->orden}}</p>
                </div>
                    <div class="form-group col-sm-4">
                     <label for="asunto_name">ASUNTO</label>
                     <p class="form-control-static">{{$avisosInicio->asunto->name}}</p>
                </div>
                <div class="form-group col-sm-4">
                     <label for="dias_despues">DIAS DESPUES</label>
                     <p class="form-control-static">{{$avisosInicio->dias_despues}}</p>
                </div>    
                <div class="form-group col-sm-4">
                     <label for="detalle">DETALLE</label>
                     <p class="form-control-static">{{$avisosInicio->detalle}}</p>
                </div>
                    
                    <div class="form-group col-sm-4">
                     <label for="usu_alta_id">ALTA</label>
                     <p class="form-control-static">{{$avisosInicio->usu_alta->name}}</p>
                </div>
                    <div class="form-group col-sm-4">
                     <label for="usu_mod_id">ULTIMA MODIFICACION</label>
                     <p class="form-control-static">{{$avisosInicio->usu_mod->name}}</p>
                </div>
            </form>

            <div class="row">
                </div>

            <a class="btn btn-link" href="{{ route('avisosInicios.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>

        </div>
    </div>

@endsection