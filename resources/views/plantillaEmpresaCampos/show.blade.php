@extends('plantillas.admin_template')

@include('plantillaEmpresaCampos._common')

@section('header')

<ol class="breadcrumb">
	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
    <li><a href="{{ route('plantillaEmpresaCampos.index') }}">@yield('plantillaEmpresaCamposAppTitle')</a></li>
    <li class="active">{{ $plantillaEmpresaCampo->name }}</li>
</ol>

<div class="page-header">
        <h1>@yield('plantillaEmpresaCamposAppTitle') / Mostrar {{$plantillaEmpresaCampo->id}}

            {!! Form::model($plantillaEmpresaCampo, array('route' => array('plantillaEmpresaCampos.destroy', $plantillaEmpresaCampo->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? Estas seguro?')) { return true } else {return false };")) !!}
                <div class="btn-group pull-right" role="group" aria-label="...">
                    @permission('plantillaEmpresaCampo.edit')
                    <a class="btn btn-warning btn-group" role="group" href="{{ route('plantillaEmpresaCampos.edit', $plantillaEmpresaCampo->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                    @endpermission
                    @permission('plantillaEmpresaCampo.destroy')
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
                    <p class="form-control-static">{{$plantillaEmpresaCampo->id}}</p>
                </div>
                <div class="form-group">
                     <label for="campo">CAMPO</label>
                     <p class="form-control-static">{{$plantillaEmpresaCampo->campo}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_alta_id">USU_ALTA_ID</label>
                     <p class="form-control-static">{{$plantillaEmpresaCampo->usu_alta_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_mod_id">USU_MOD_ID</label>
                     <p class="form-control-static">{{$plantillaEmpresaCampo->usu_mod_id}}</p>
                </div>
            </form>

            <div class="row">
                </div>

            <a class="btn btn-link" href="{{ route('plantillaEmpresaCampos.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>

        </div>
    </div>

@endsection