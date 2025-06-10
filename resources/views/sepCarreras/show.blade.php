@extends('plantillas.admin_template')

@include('sepCarreras._common')

@section('header')

<ol class="breadcrumb">
	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
    <li><a href="{{ route('sepCarreras.index') }}">@yield('sepCarrerasAppTitle')</a></li>
    <li class="active">{{ $sepCarrera->name }}</li>
</ol>

<div class="page-header">
        <h1>@yield('sepCarrerasAppTitle') / Mostrar {{$sepCarrera->id}}

            {!! Form::model($sepCarrera, array('route' => array('sepCarreras.destroy', $sepCarrera->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? Estas seguro?')) { return true } else {return false };")) !!}
                <div class="btn-group pull-right" role="group" aria-label="...">
                    @permission('sepCarrera.edit')
                    <a class="btn btn-warning btn-group" role="group" href="{{ route('sepCarreras.edit', $sepCarrera->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                    @endpermission
                    @permission('sepCarrera.destroy')
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
                    <p class="form-control-static">{{$sepCarrera->id}}</p>
                </div>
                <div class="form-group">
                     <label for="cve_carrera">CVE_CARRERA</label>
                     <p class="form-control-static">{{$sepCarrera->cve_carrera}}</p>
                </div>
                    <div class="form-group">
                     <label for="descripcion">DESCRIPCION</label>
                     <p class="form-control-static">{{$sepCarrera->descripcion}}</p>
                </div>
                    <div class="form-group">
                     <label for="id_area">ID_AREA</label>
                     <p class="form-control-static">{{$sepCarrera->id_area}}</p>
                </div>
                    <div class="form-group">
                     <label for="area">AREA</label>
                     <p class="form-control-static">{{$sepCarrera->area}}</p>
                </div>
                    <div class="form-group">
                     <label for="cve_subarea">CVE_SUBAREA</label>
                     <p class="form-control-static">{{$sepCarrera->cve_subarea}}</p>
                </div>
                    <div class="form-group">
                     <label for="area">AREA</label>
                     <p class="form-control-static">{{$sepCarrera->area}}</p>
                </div>
                    <div class="form-group">
                     <label for="id_nivel_sirep">ID_NIVEL_SIREP</label>
                     <p class="form-control-static">{{$sepCarrera->id_nivel_sirep}}</p>
                </div>
                    <div class="form-group">
                     <label for="nivel_educativo">NIVEL_EDUCATIVO</label>
                     <p class="form-control-static">{{$sepCarrera->nivel_educativo}}</p>
                </div>
                    <div class="form-group">
                     <label for="num_rvoe">NUM_RVOE</label>
                     <p class="form-control-static">{{$sepCarrera->num_rvoe}}</p>
                </div>
            </form>

            <div class="row">
                </div>

            <a class="btn btn-link" href="{{ route('sepCarreras.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>

        </div>
    </div>

@endsection