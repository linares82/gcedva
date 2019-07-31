@extends('plantillas.admin_template')

@include('vinculacionHoras._common')

@section('header')

<ol class="breadcrumb">
	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
    <li><a href="{{ route('vinculacionHoras.index') }}">@yield('vinculacionHorasAppTitle')</a></li>
    <li class="active">{{ $vinculacionHora->name }}</li>
</ol>

<div class="page-header">
        <h1>@yield('vinculacionHorasAppTitle') / Mostrar {{$vinculacionHora->id}}

            {!! Form::model($vinculacionHora, array('route' => array('vinculacionHoras.destroy', $vinculacionHora->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? Estas seguro?')) { return true } else {return false };")) !!}
                <div class="btn-group pull-right" role="group" aria-label="...">
                    @permission('vinculacionHora.edit')
                    <a class="btn btn-warning btn-group" role="group" href="{{ route('vinculacionHoras.edit', $vinculacionHora->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                    @endpermission
                    @permission('vinculacionHora.destroy')
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
                    <p class="form-control-static">{{$vinculacionHora->id}}</p>
                </div>
                <div class="form-group">
                     <label for="vinculacion_lugar_practica">VINCULACION_LUGAR_PRACTICA</label>
                     <p class="form-control-static">{{$vinculacionHora->vinculacion->lugar_practica}}</p>
                </div>
                    <div class="form-group">
                     <label for="fec_inicio">FEC_INICIO</label>
                     <p class="form-control-static">{{$vinculacionHora->fec_inicio}}</p>
                </div>
                    <div class="form-group">
                     <label for="fec_fin">FEC_FIN</label>
                     <p class="form-control-static">{{$vinculacionHora->fec_fin}}</p>
                </div>
                    <div class="form-group">
                     <label for="horas">HORAS</label>
                     <p class="form-control-static">{{$vinculacionHora->horas}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_alta_id">USU_ALTA_ID</label>
                     <p class="form-control-static">{{$vinculacionHora->usu_alta_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_mod_id">USU_MOD_ID</label>
                     <p class="form-control-static">{{$vinculacionHora->usu_mod_id}}</p>
                </div>
            </form>

            <div class="row">
                </div>

            <a class="btn btn-link" href="{{ route('vinculacionHoras.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>

        </div>
    </div>

@endsection