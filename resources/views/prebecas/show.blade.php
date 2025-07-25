@extends('plantillas.admin_template')

@include('prebecas._common')

@section('header')

<ol class="breadcrumb">
	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
    <li><a href="{{ route('prebecas.index') }}">@yield('prebecasAppTitle')</a></li>
    <li class="active">{{ $prebeca->name }}</li>
</ol>

<div class="page-header">
        <h1>@yield('prebecasAppTitle') / Mostrar {{$prebeca->id}}

            {!! Form::model($prebeca, array('route' => array('prebecas.destroy', $prebeca->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? Estas seguro?')) { return true } else {return false };")) !!}
                <div class="btn-group pull-right" role="group" aria-label="...">
                    @permission('prebeca.edit')
                    <a class="btn btn-warning btn-group" role="group" href="{{ route('prebecas.edit', $prebeca->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                    @endpermission
                    @permission('prebeca.destroy')
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
                    <p class="form-control-static">{{$prebeca->id}}</p>
                </div>
                <div class="form-group">
                     <label for="cliente_id">CLIENTE_ID</label>
                     <p class="form-control-static">{{$prebeca->cliente_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="motivo_beca_id">MOTIVO_BECA_ID</label>
                     <p class="form-control-static">{{$prebeca->motivo_beca_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="observaciones">OBSERVACIONES</label>
                     <p class="form-control-static">{{$prebeca->observaciones}}</p>
                </div>
                    <div class="form-group">
                     <label for="procentaje_beca_id">PROCENTAJE_BECA_ID</label>
                     <p class="form-control-static">{{$prebeca->procentaje_beca_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_alta_id">USU_ALTA_ID</label>
                     <p class="form-control-static">{{$prebeca->usu_alta_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_mod_id">USU_MOD_ID</label>
                     <p class="form-control-static">{{$prebeca->usu_mod_id}}</p>
                </div>
            </form>

            <div class="row">
                </div>

            <a class="btn btn-link" href="{{ route('prebecas.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>

        </div>
    </div>

@endsection