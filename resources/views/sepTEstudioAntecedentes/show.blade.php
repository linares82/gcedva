@extends('plantillas.admin_template')

@include('sepTEstudioAntecedentes._common')

@section('header')

<ol class="breadcrumb">
	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
    <li><a href="{{ route('sepTEstudioAntecedentes.index') }}">@yield('sepTEstudioAntecedentesAppTitle')</a></li>
    <li class="active">{{ $sepTEstudioAntecedente->name }}</li>
</ol>

<div class="page-header">
        <h1>@yield('sepTEstudioAntecedentesAppTitle') / Mostrar {{$sepTEstudioAntecedente->id}}

            {!! Form::model($sepTEstudioAntecedente, array('route' => array('sepTEstudioAntecedentes.destroy', $sepTEstudioAntecedente->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? Estas seguro?')) { return true } else {return false };")) !!}
                <div class="btn-group pull-right" role="group" aria-label="...">
                    @permission('sepTEstudioAntecedente.edit')
                    <a class="btn btn-warning btn-group" role="group" href="{{ route('sepTEstudioAntecedentes.edit', $sepTEstudioAntecedente->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                    @endpermission
                    @permission('sepTEstudioAntecedente.destroy')
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
                    <p class="form-control-static">{{$sepTEstudioAntecedente->id}}</p>
                </div>
                <div class="form-group">
                     <label for="id_t_estudio_antecedente">ID_T_ESTUDIO_ANTECEDENTE</label>
                     <p class="form-control-static">{{$sepTEstudioAntecedente->id_t_estudio_antecedente}}</p>
                </div>
                    <div class="form-group">
                     <label for="t_estudio_antecedente">T_ESTUDIO_ANTECEDENTE</label>
                     <p class="form-control-static">{{$sepTEstudioAntecedente->t_estudio_antecedente}}</p>
                </div>
            </form>

            <div class="row">
                </div>

            <a class="btn btn-link" href="{{ route('sepTEstudioAntecedentes.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>

        </div>
    </div>

@endsection