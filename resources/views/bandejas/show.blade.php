@extends('plantillas.admin_template')

@include('bandejas._common')

@section('header')

<ol class="breadcrumb">
	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
    <li><a href="{{ route('bandejas.index') }}">@yield('bandejasAppTitle')</a></li>
    <li class="active">{{ $bandeja->name }}</li>
</ol>

<div class="page-header">
        <h1>@yield('bandejasAppTitle') / Mostrar {{$bandeja->id}}

            {!! Form::model($bandeja, array('route' => array('bandejas.destroy', $bandeja->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? Estas seguro?')) { return true } else {return false };")) !!}
                <div class="btn-group pull-right" role="group" aria-label="...">
                    @permission('bandeja.edit')
                    <a class="btn btn-warning btn-group" role="group" href="{{ route('bandejas.edit', $bandeja->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                    @endpermission
                    @permission('bandeja.destroy')
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
                    <p class="form-control-static">{{$bandeja->id}}</p>
                </div>
                <div class="form-group">
                     <label for="uid">UID</label>
                     <p class="form-control-static">{{$bandeja->uid}}</p>
                </div>
                    <div class="form-group">
                     <label for="from">FROM</label>
                     <p class="form-control-static">{{$bandeja->from}}</p>
                </div>
                    <div class="form-group">
                     <label for="to">TO</label>
                     <p class="form-control-static">{{$bandeja->to}}</p>
                </div>
                    <div class="form-group">
                     <label for="asunto">ASUNTO</label>
                     <p class="form-control-static">{{$bandeja->asunto}}</p>
                </div>
                    <div class="form-group">
                     <label for="adjuntos">ADJUNTOS</label>
                     <p class="form-control-static">{{$bandeja->adjuntos}}</p>
                </div>
                    <div class="form-group">
                     <label for="fecha">FECHA</label>
                     <p class="form-control-static">{{$bandeja->fecha}}</p>
                </div>
                    <div class="form-group">
                     <label for="mesaje">MESAJE</label>
                     <p class="form-control-static">{{$bandeja->mesaje}}</p>
                </div>
                    <div class="form-group">
                     <label for="bnd_leido">BND_LEIDO</label>
                     <p class="form-control-static">{{$bandeja->bnd_leido}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_alta_id">USU_ALTA_ID</label>
                     <p class="form-control-static">{{$bandeja->usu_alta_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_mod_id">USU_MOD_ID</label>
                     <p class="form-control-static">{{$bandeja->usu_mod_id}}</p>
                </div>
            </form>

            <div class="row">
                </div>

            <a class="btn btn-link" href="{{ route('bandejas.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>

        </div>
    </div>

@endsection