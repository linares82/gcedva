@extends('plantillas.admin_template')

@include('hadeudos._common')

@section('header')

<ol class="breadcrumb">
	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
    <li><a href="{{ route('hadeudos.index') }}">@yield('hadeudosAppTitle')</a></li>
    <li class="active">{{ $hadeudo->name }}</li>
</ol>

<div class="page-header">
        <h1>@yield('hadeudosAppTitle') / Mostrar {{$hadeudo->id}}

            {!! Form::model($hadeudo, array('route' => array('hadeudos.destroy', $hadeudo->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? Estas seguro?')) { return true } else {return false };")) !!}
                <div class="btn-group pull-right" role="group" aria-label="...">
                    @permission('hadeudo.edit')
                    <a class="btn btn-warning btn-group" role="group" href="{{ route('hadeudos.edit', $hadeudo->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                    @endpermission
                    @permission('hadeudo.destroy')
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
                    <p class="form-control-static">{{$hadeudo->id}}</p>
                </div>
                <div class="form-group">
                     <label for="adeudo_id">ADEUDO_ID</label>
                     <p class="form-control-static">{{$hadeudo->adeudo_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="campo">CAMPO</label>
                     <p class="form-control-static">{{$hadeudo->campo}}</p>
                </div>
                    <div class="form-group">
                     <label for="valor_anterior">VALOR_ANTERIOR</label>
                     <p class="form-control-static">{{$hadeudo->valor_anterior}}</p>
                </div>
                    <div class="form-group">
                     <label for="valor_nuevo">VALOR_NUEVO</label>
                     <p class="form-control-static">{{$hadeudo->valor_nuevo}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_alta_id">USU_ALTA_ID</label>
                     <p class="form-control-static">{{$hadeudo->usu_alta_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_mod_id">USU_MOD_ID</label>
                     <p class="form-control-static">{{$hadeudo->usu_mod_id}}</p>
                </div>
            </form>

            <div class="row">
                </div>

            <a class="btn btn-link" href="{{ route('hadeudos.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>

        </div>
    </div>

@endsection