@extends('plantillas.admin_template')

@include('sepCertificadoCs._common')

@section('header')

<ol class="breadcrumb">
	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
    <li><a href="{{ route('sepCertificadoCs.index') }}">@yield('sepCertificadoCsAppTitle')</a></li>
    <li class="active">{{ $sepCertificadoC->name }}</li>
</ol>

<div class="page-header">
        <h1>@yield('sepCertificadoCsAppTitle') / Mostrar {{$sepCertificadoC->id}}

            {!! Form::model($sepCertificadoC, array('route' => array('sepCertificadoCs.destroy', $sepCertificadoC->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? Estas seguro?')) { return true } else {return false };")) !!}
                <div class="btn-group pull-right" role="group" aria-label="...">
                    @permission('sepCertificadoC.edit')
                    <a class="btn btn-warning btn-group" role="group" href="{{ route('sepCertificadoCs.edit', $sepCertificadoC->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                    @endpermission
                    @permission('sepCertificadoC.destroy')
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
                    <p class="form-control-static">{{$sepCertificadoC->id}}</p>
                </div>
                <div class="form-group">
                     <label for="plantel_id">PLANTEL_ID</label>
                     <p class="form-control-static">{{$sepCertificadoC->plantel_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="empleado_id">EMPLEADO_ID</label>
                     <p class="form-control-static">{{$sepCertificadoC->empleado_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="sep_cargo_id">SEP_CARGO_ID</label>
                     <p class="form-control-static">{{$sepCertificadoC->sep_cargo_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="especialidad_id">ESPECIALIDAD_ID</label>
                     <p class="form-control-static">{{$sepCertificadoC->especialidad_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="nivel_id">NIVEL_ID</label>
                     <p class="form-control-static">{{$sepCertificadoC->nivel_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="grado_id">GRADO_ID</label>
                     <p class="form-control-static">{{$sepCertificadoC->grado_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_alta_id">USU_ALTA_ID</label>
                     <p class="form-control-static">{{$sepCertificadoC->usu_alta_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_mod_id">USU_MOD_ID</label>
                     <p class="form-control-static">{{$sepCertificadoC->usu_mod_id}}</p>
                </div>
            </form>

            <div class="row">
                </div>

            <a class="btn btn-link" href="{{ route('sepCertificadoCs.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>

        </div>
    </div>

@endsection