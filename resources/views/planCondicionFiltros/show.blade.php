@extends('plantillas.admin_template')

@include('planCondicionFiltros._common')

@section('header')

<ol class="breadcrumb">
	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
    <li><a href="{{ route('planCondicionFiltros.index') }}">@yield('planCondicionFiltrosAppTitle')</a></li>
    <li class="active">{{ $planCondicionFiltro->name }}</li>
</ol>

<div class="page-header">
        <h1>@yield('planCondicionFiltrosAppTitle') / Mostrar {{$planCondicionFiltro->id}}

            {!! Form::model($planCondicionFiltro, array('route' => array('planCondicionFiltros.destroy', $planCondicionFiltro->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? Estas seguro?')) { return true } else {return false };")) !!}
                <div class="btn-group pull-right" role="group" aria-label="...">
                    @permission('planCondicionFiltro.edit')
                    <a class="btn btn-warning btn-group" role="group" href="{{ route('planCondicionFiltros.edit', $planCondicionFiltro->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                    @endpermission
                    @permission('planCondicionFiltro.destroy')
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
                    <p class="form-control-static">{{$planCondicionFiltro->id}}</p>
                </div>
                <div class="form-group">
                     <label for="plantilla_id">PLANTILLA_ID</label>
                     <p class="form-control-static">{{$planCondicionFiltro->plantilla_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="campo_id">CAMPO_ID</label>
                     <p class="form-control-static">{{$planCondicionFiltro->campo_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="signo_comparacion">SIGNO_COMPARACION</label>
                     <p class="form-control-static">{{$planCondicionFiltro->signo_comparacion}}</p>
                </div>
                    <div class="form-group">
                     <label for="valor_condicion">VALOR_CONDICION</label>
                     <p class="form-control-static">{{$planCondicionFiltro->valor_condicion}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_alta_id">USU_ALTA_ID</label>
                     <p class="form-control-static">{{$planCondicionFiltro->usu_alta_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_mod_id">USU_MOD_ID</label>
                     <p class="form-control-static">{{$planCondicionFiltro->usu_mod_id}}</p>
                </div>
            </form>

            <div class="row">
                </div>

            <a class="btn btn-link" href="{{ route('planCondicionFiltros.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>

        </div>
    </div>

@endsection