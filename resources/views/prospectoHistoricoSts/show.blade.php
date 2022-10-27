@extends('plantillas.admin_template')

@include('prospectoHistoricoSts._common')

@section('header')

<ol class="breadcrumb">
	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
    <li><a href="{{ route('prospectoHistoricoSts.index') }}">@yield('prospectoHistoricoStsAppTitle')</a></li>
    <li class="active">{{ $prospectoHistoricoSt->name }}</li>
</ol>

<div class="page-header">
        <h1>@yield('prospectoHistoricoStsAppTitle') / Mostrar {{$prospectoHistoricoSt->id}}

            {!! Form::model($prospectoHistoricoSt, array('route' => array('prospectoHistoricoSts.destroy', $prospectoHistoricoSt->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? Estas seguro?')) { return true } else {return false };")) !!}
                <div class="btn-group pull-right" role="group" aria-label="...">
                    @permission('prospectoHistoricoSt.edit')
                    <a class="btn btn-warning btn-group" role="group" href="{{ route('prospectoHistoricoSts.edit', $prospectoHistoricoSt->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                    @endpermission
                    @permission('prospectoHistoricoSt.destroy')
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
                    <p class="form-control-static">{{$prospectoHistoricoSt->id}}</p>
                </div>
                <div class="form-group">
                     <label for="prospecto_id">PROSPECTO_ID</label>
                     <p class="form-control-static">{{$prospectoHistoricoSt->prospecto_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="st_prospecto_id">ST_PROSPECTO_ID</label>
                     <p class="form-control-static">{{$prospectoHistoricoSt->st_prospecto_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_alta_id">USU_ALTA_ID</label>
                     <p class="form-control-static">{{$prospectoHistoricoSt->usu_alta_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_mod_id">USU_MOD_ID</label>
                     <p class="form-control-static">{{$prospectoHistoricoSt->usu_mod_id}}</p>
                </div>
            </form>

            <div class="row">
                </div>

            <a class="btn btn-link" href="{{ route('prospectoHistoricoSts.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>

        </div>
    </div>

@endsection