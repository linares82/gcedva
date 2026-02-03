@extends('plantillas.admin_template')

@include('leads._common')

@section('header')

<ol class="breadcrumb">
	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
    <li><a href="{{ route('leads.index') }}">@yield('leadsAppTitle')</a></li>
    <li class="active">{{ $lead->name }}</li>
</ol>

<div class="page-header">
        <h1>@yield('leadsAppTitle') / Mostrar {{$lead->id}}

            {!! Form::model($lead, array('route' => array('leads.destroy', $lead->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? Estas seguro?')) { return true } else {return false };")) !!}
                <div class="btn-group pull-right" role="group" aria-label="...">
                    @permission('lead.edit')
                    <a class="btn btn-warning btn-group" role="group" href="{{ route('leads.edit', $lead->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                    @endpermission
                    @permission('lead.destroy')
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
                    <p class="form-control-static">{{$lead->id}}</p>
                </div>
                <div class="form-group col-sm-4">
                     <label for="nombre">NOMBRE</label>
                     <p class="form-control-static">{{$lead->nombre}}</p>
                </div>
                    <div class="form-group col-sm-4">
                     <label for="nombre2">SEGUNDO NOMBRE</label>
                     <p class="form-control-static">{{$lead->nombre2}}</p>
                </div>
                    <div class="form-group col-sm-4">
                     <label for="ape_paterno">A.PATERNO</label>
                     <p class="form-control-static">{{$lead->ape_paterno}}</p>
                </div>
                    <div class="form-group col-sm-4">
                     <label for="ape_materno">A. MATERNO</label>
                     <p class="form-control-static">{{$lead->ape_materno}}</p>
                </div>
                    <div class="form-group col-sm-4">
                     <label for="tel_fijo">TEL. FIJO</label>
                     <p class="form-control-static">{{$lead->tel_fijo}}</p>
                </div>
                    <div class="form-group col-sm-4">
                     <label for="tel_cel">TEL. CELULAR</label>
                     <p class="form-control-static">{{$lead->tel_cel}}</p>
                </div>
                    <div class="form-group col-sm-4">
                     <label for="email">EMAIL</label>
                     <p class="form-control-static">{{$lead->email}}</p>
                </div>
                    <div class="form-group col-sm-4">
                     <label for="medio_name">MEDIO</label>
                     <p class="form-control-static">{{$lead->medio->name}}</p>
                </div>
                    <div class="form-group col-sm-4">
                     <label for="ciclo_interesado">CICLO INTERESADO</label>
                     <p class="form-control-static">{{$lead->ciclo_interesado}}</p>
                </div>
                    <div class="form-group col-sm-4">
                     <label for="observaciones">OBSERVACIONES</label>
                     <p class="form-control-static">{{$lead->observaciones}}</p>
                </div>
                    <div class="form-group col-sm-4">
                     <label for="st_lead_name">ESTATUS</label>
                     <p class="form-control-static">{{$lead->stLead->name}}</p>
                </div>
                    <div class="form-group col-sm-4">
                     <label for="usu_alta_id">ALTA</label>
                     <p class="form-control-static">{{$lead->usu_alta->name}}</p>
                </div>
                    <div class="form-group col-sm-4">
                     <label for="usu_mod_id">U. MODIFICACION</label>
                     <p class="form-control-static">{{$lead->usu_mod->name}}</p>
                </div>
                <div class="form-group col-sm-4">
                     <label for="usu_mod_id">FEC. ALTA</label>
                     <p class="form-control-static">{{$lead->created_at}}</p>
                </div>
                <div class="form-group col-sm-4">
                     <label for="usu_mod_id">FEC. U. MODIFICACION</label>
                     <p class="form-control-static">{{$lead->updated_at}}</p>
                </div>
            </form>

            <div class="row">
                </div>

            <a class="btn btn-link" href="{{ route('leads.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>

        </div>
    </div>

@endsection