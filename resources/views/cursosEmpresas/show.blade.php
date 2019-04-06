@extends('plantillas.admin_template')

@include('cursosEmpresas._common')

@section('header')

<ol class="breadcrumb">
	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
    <li><a href="{{ route('cursosEmpresas.index') }}">@yield('cursosEmpresasAppTitle')</a></li>
    <li class="active">{{ $cursosEmpresa->name }}</li>
</ol>

<div class="page-header">
        <h1>@yield('cursosEmpresasAppTitle') / Mostrar {{$cursosEmpresa->id}}

            {!! Form::model($cursosEmpresa, array('route' => array('cursosEmpresas.destroy', $cursosEmpresa->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? Estas seguro?')) { return true } else {return false };")) !!}
                <div class="btn-group pull-right" role="group" aria-label="...">
                    @permission('cursosEmpresa.edit')
                    <a class="btn btn-warning btn-group" role="group" href="{{ route('cursosEmpresas.edit', $cursosEmpresa->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                    @endpermission
                    @permission('cursosEmpresa.destroy')
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
                    <p class="form-control-static">{{$cursosEmpresa->id}}</p>
                </div>
                <div class="form-group col-sm-4">
                     <label for="name">CURSO</label>
                     <p class="form-control-static">{{$cursosEmpresa->name}}</p>
                </div>
                    
                    <div class="form-group col-sm-4">
                     <label for="descuento_max">DESCUENTO MAXIMO</label>
                     <p class="form-control-static">{{$cursosEmpresa->descuento_max}}</p>
                </div>
                    <div class="form-group col-sm-4">
                     <label for="p_asesor">% ASESOR</label>
                     <p class="form-control-static">{{$cursosEmpresa->p_asesor}}</p>
                </div>
                    <div class="form-group col-sm-4">
                     <label for="p_ventas">% VENTAS</label>
                     <p class="form-control-static">{{$cursosEmpresa->p_ventas}}</p>
                </div>
                    <div class="form-group col-sm-4">
                     <label for="p_instructor">% INSTRUCTOR</label>
                     <p class="form-control-static">{{$cursosEmpresa->p_instructor}}</p>
                </div>
                    <div class="form-group col-sm-4">
                     <label for="p_ganancia">% GANANCIA</label>
                     <p class="form-control-static">{{$cursosEmpresa->p_ganancia}}</p>
                </div>
                    <div class="form-group col-sm-4">
                     <label for="precio_persona">PRECIO PERSONA</label>
                     <p class="form-control-static">{{$cursosEmpresa->precio_persona}}</p>
                </div>
                <div class="form-group col-sm-4">
                     <label for="precio_persona">PRECIO PERSONA EN LINEA</label>
                     <p class="form-control-static">{{$cursosEmpresa->precio_en_linea}}</p>
                </div>
                    <div class="form-group col-sm-4">
                     <label for="precio_demo">PRECIO DEMO</label>
                     <p class="form-control-static">{{$cursosEmpresa->precio_demo}}</p>
                </div>
                    <div class="form-group col-sm-4">
                     <label for="duracion">DURACION</label>
                     <p class="form-control-static">{{$cursosEmpresa->duracion}}</p>
                </div>
                <div class="form-group col-sm-12">
                     <label for="detalle">DETALLE</label>
                     <p class="form-control-static">{{$cursosEmpresa->detalle}}</p>
                </div>
                    <div class="form-group col-sm-4">
                     <label for="usu_alta_id">ALTA</label>
                     <p class="form-control-static">{{$cursosEmpresa->usu_alta->name}}</p>
                </div>
                    <div class="form-group col-sm-4">
                     <label for="usu_mod_id">ULTIMA MODIFICACION</label>
                     <p class="form-control-static">{{$cursosEmpresa->usu_mod->name}}</p>
                </div>
                
            </form>

            <div class="row">
                </div>

            <a class="btn btn-link" href="{{ route('cursosEmpresas.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>

        </div>
    </div>

@endsection