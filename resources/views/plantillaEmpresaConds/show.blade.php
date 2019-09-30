@extends('plantillas.admin_template')

@include('plantillaEmpresaConds._common')

@section('header')

<ol class="breadcrumb">
	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
    <li><a href="{{ route('plantillaEmpresaConds.index') }}">@yield('plantillaEmpresaCondsAppTitle')</a></li>
    <li class="active">{{ $plantillaEmpresaCond->name }}</li>
</ol>

<div class="page-header">
        <h1>@yield('plantillaEmpresaCondsAppTitle') / Mostrar {{$plantillaEmpresaCond->id}}

            {!! Form::model($plantillaEmpresaCond, array('route' => array('plantillaEmpresaConds.destroy', $plantillaEmpresaCond->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? Estas seguro?')) { return true } else {return false };")) !!}
                <div class="btn-group pull-right" role="group" aria-label="...">
                    @permission('plantillaEmpresaCond.edit')
                    <a class="btn btn-warning btn-group" role="group" href="{{ route('plantillaEmpresaConds.edit', $plantillaEmpresaCond->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                    @endpermission
                    @permission('plantillaEmpresaCond.destroy')
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
                    <p class="form-control-static">{{$plantillaEmpresaCond->id}}</p>
                </div>
                <div class="form-group">
                     <label for="plantilla_empresa_nombre">PLANTILLA_EMPRESA_NOMBRE</label>
                     <p class="form-control-static">{{$plantillaEmpresaCond->plantillaEmpresa->nombre}}</p>
                </div>
                    <div class="form-group">
                     <label for="operador_condicion">OPERADOR_CONDICION</label>
                     <p class="form-control-static">{{$plantillaEmpresaCond->operador_condicion}}</p>
                </div>
                    <div class="form-group">
                     <label for="plantilla_empresa_campo_campo">PLANTILLA_EMPRESA_CAMPO_CAMPO</label>
                     <p class="form-control-static">{{$plantillaEmpresaCond->plantillaEmpresaCampo->campo}}</p>
                </div>
                    <div class="form-group">
                     <label for="signo_comparacion">SIGNO_COMPARACION</label>
                     <p class="form-control-static">{{$plantillaEmpresaCond->signo_comparacion}}</p>
                </div>
                    <div class="form-group">
                     <label for="valor_condicion">VALOR_CONDICION</label>
                     <p class="form-control-static">{{$plantillaEmpresaCond->valor_condicion}}</p>
                </div>
                    <div class="form-group">
                     <label for="interpretacion">INTERPRETACION</label>
                     <p class="form-control-static">{{$plantillaEmpresaCond->interpretacion}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_alta_id">USU_ALTA_ID</label>
                     <p class="form-control-static">{{$plantillaEmpresaCond->usu_alta_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_mod_id">USU_MOD_ID</label>
                     <p class="form-control-static">{{$plantillaEmpresaCond->usu_mod_id}}</p>
                </div>
            </form>

            <div class="row">
                </div>

            <a class="btn btn-link" href="{{ route('plantillaEmpresaConds.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>

        </div>
    </div>

@endsection