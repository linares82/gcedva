@extends('plantillas.admin_template')

@include('articulos._common')

@section('header')

<ol class="breadcrumb">
	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
    <li><a href="{{ route('articulos.index') }}">@yield('articulosAppTitle')</a></li>
    <li class="active">{{ $articulo->name }}</li>
</ol>

<div class="page-header">
        <h1>@yield('articulosAppTitle') / Mostrar {{$articulo->id}}

            {!! Form::model($articulo, array('route' => array('articulos.destroy', $articulo->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? Estas seguro?')) { return true } else {return false };")) !!}
                <div class="btn-group pull-right" role="group" aria-label="...">
                    @permission('articulo.edit')
                    <a class="btn btn-warning btn-group" role="group" href="{{ route('articulos.edit', $articulo->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                    @endpermission
                    @permission('articulo.destroy')
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
                    <p class="form-control-static">{{$articulo->id}}</p>
                </div>
                <div class="form-group col-sm-4">
                     <label for="name">ARTICULO</label>
                     <p class="form-control-static">{{$articulo->name}}</p>
                </div>
                    <div class="form-group col-sm-4">
                     <label for="unidad_uso">UNIDAD USO</label>
                     <p class="form-control-static">{{$articulo->unidad_uso}}</p>
                </div>
                    
                    <div class="form-group col-sm-4">
                     <label for="categoria_id">CATEGORIA</label>
                     <p class="form-control-static">{{$articulo->categoriaArticulo->name}}</p>
                </div>
                    <div class="form-group col-sm-4">
                     <label for="usu_alta_id">ALTA</label>
                     <p class="form-control-static">{{$articulo->usu_alta->name}}</p>
                </div>
                    <div class="form-group col-sm-4">
                     <label for="usu_mod_id">ULTIMA MODIFICACION</label>
                     <p class="form-control-static">{{$articulo->usu_mod->name}}</p>
                </div>
                <div class="form-group col-sm-6">
                     <label for="existencias">Existencias</label>
                     <table class="table table-condensed table-striped table-bordered table-hover">
                         <thead>
                         <th>Plantel</th><th>Existencia</th>
                         </thead>
                         <tbody>
                         @foreach($articulo->existencia as $existencia)
                         <tr>
                             <td>{{$existencia->plantel->razon}}</td><td>{{$existencia->existencia}}</td>
                         </tr>
                          
                        @endforeach
                         </tbody>
                     </table>
                     
                </div>
            </form>

            <div class="row">
                </div>

            <a class="btn btn-link" href="{{ route('articulos.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>

        </div>
    </div>

@endsection