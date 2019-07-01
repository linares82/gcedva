@extends('plantillas.admin_template')

@include('cuentasEfectivos._common')

@section('header')

<ol class="breadcrumb">
	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
    <li><a href="{{ route('cuentasEfectivos.index') }}">@yield('cuentasEfectivosAppTitle')</a></li>
    <li class="active">{{ $cuentasEfectivo->name }}</li>
</ol>

<div class="page-header">
        <h1>@yield('cuentasEfectivosAppTitle') / Mostrar {{$cuentasEfectivo->id}}

            {!! Form::model($cuentasEfectivo, array('route' => array('cuentasEfectivos.destroy', $cuentasEfectivo->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? Estas seguro?')) { return true } else {return false };")) !!}
                <div class="btn-group pull-right" role="group" aria-label="...">
                    @permission('cuentasEfectivo.edit')
                    <a class="btn btn-warning btn-group" role="group" href="{{ route('cuentasEfectivos.edit', $cuentasEfectivo->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                    @endpermission
                    @permission('cuentasEfectivo.destroy')
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
                    <p class="form-control-static">{{$cuentasEfectivo->id}}</p>
                </div>
                <div class="form-group col-sm-4">
                     <label for="name">NOMBRE</label>
                     <p class="form-control-static">{{$cuentasEfectivo->name}}</p>
                </div>
                    <div class="form-group col-sm-4">
                     <label for="clabe">CLABE</label>
                     <p class="form-control-static">{{$cuentasEfectivo->clabe}}</p>
                </div>
                    <div class="form-group col-sm-4">
                     <label for="no_cuenta">NO. CUENTA</label>
                     <p class="form-control-static">{{$cuentasEfectivo->no_cuenta}}</p>
                </div>
                    <div class="form-group col-sm-4">
                     <label for="usu_alta_id">ALTA</label>
                     <p class="form-control-static">{{$cuentasEfectivo->usu_alta->name}}</p>
                </div>
                    <div class="form-group col-sm-4">
                     <label for="usu_mod_id">ULTIMA MODIFICACION</label>
                     <p class="form-control-static">{{$cuentasEfectivo->usu_mod->name}}</p>
                </div>
            </form>

            <div class="row">
                </div>

            <a class="btn btn-link" href="{{ route('cuentasEfectivos.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>

            @if($cuentasEfectivo->hCuentasEfectivos->count())
                <table class="table table-condensed table-striped">
                    <thead>
                        <tr>
                        <th>SALDO INICIAL</th>
                        <th>SALDO ACTUALIZADO</th>
                        <th>FECHA SALDO INICIAL</th>
                        <th>ALTA</th>
                            
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($cuentasEfectivo->hCuentasEfectivos as $hCuentasEfectivo)
                            <tr>
                    <td>{{$hCuentasEfectivo->saldo_inicial}}</td>
                    <td>{{$hCuentasEfectivo->saldo_actualizado}}</td>
                    <td>{{$hCuentasEfectivo->fecha_saldo_inicial}}</td>
                    <td>{{$hCuentasEfectivo->usu_alta_id}}</td>
                    
                        
                           </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>

@endsection