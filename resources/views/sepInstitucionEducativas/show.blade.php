@extends('plantillas.admin_template')

@include('sepInstitucionEducativas._common')

@section('header')

<ol class="breadcrumb">
	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
    <li><a href="{{ route('sepInstitucionEducativas.index') }}">@yield('sepInstitucionEducativasAppTitle')</a></li>
    <li class="active">{{ $sepInstitucionEducativa->name }}</li>
</ol>

<div class="page-header">
        <h1>@yield('sepInstitucionEducativasAppTitle') / Mostrar {{$sepInstitucionEducativa->id}}

            {!! Form::model($sepInstitucionEducativa, array('route' => array('sepInstitucionEducativas.destroy', $sepInstitucionEducativa->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? Estas seguro?')) { return true } else {return false };")) !!}
                <div class="btn-group pull-right" role="group" aria-label="...">
                    @permission('sepInstitucionEducativa.edit')
                    <a class="btn btn-warning btn-group" role="group" href="{{ route('sepInstitucionEducativas.edit', $sepInstitucionEducativa->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                    @endpermission
                    @permission('sepInstitucionEducativa.destroy')
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
                    <p class="form-control-static">{{$sepInstitucionEducativa->id}}</p>
                </div>
                <div class="form-group">
                     <label for="cve_institucion">CVE_INSTITUCION</label>
                     <p class="form-control-static">{{$sepInstitucionEducativa->cve_institucion}}</p>
                </div>
                    <div class="form-group">
                     <label for="descripcion">DESCRIPCION</label>
                     <p class="form-control-static">{{$sepInstitucionEducativa->descripcion}}</p>
                </div>
            </form>

            <div class="row">
                </div>

            <a class="btn btn-link" href="{{ route('sepInstitucionEducativas.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>

        </div>
    </div>

@endsection