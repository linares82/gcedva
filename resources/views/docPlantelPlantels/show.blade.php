@extends('plantillas.admin_template')

@include('docPlantelPlantels._common')

@section('header')

<ol class="breadcrumb">
	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
    <li><a href="{{ route('docPlantelPlantels.index') }}">@yield('docPlantelPlantelsAppTitle')</a></li>
    <li class="active">{{ $docPlantelPlantel->name }}</li>
</ol>

<div class="page-header">
        <h1>@yield('docPlantelPlantelsAppTitle') / Mostrar {{$docPlantelPlantel->id}}

            {!! Form::model($docPlantelPlantel, array('route' => array('docPlantelPlantels.destroy', $docPlantelPlantel->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? Estas seguro?')) { return true } else {return false };")) !!}
                <div class="btn-group pull-right" role="group" aria-label="...">
                    @permission('docPlantelPlantel.edit')
                    <a class="btn btn-warning btn-group" role="group" href="{{ route('docPlantelPlantels.edit', $docPlantelPlantel->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                    @endpermission
                    @permission('docPlantelPlantel.destroy')
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
                    <p class="form-control-static">{{$docPlantelPlantel->id}}</p>
                </div>
                <div class="form-group">
                     <label for="doc_plantel_name">DOC_PLANTEL_NAME</label>
                     <p class="form-control-static">{{$docPlantelPlantel->docPlantel->name}}</p>
                </div>
                    <div class="form-group">
                     <label for="plantel_razon">PLANTEL_RAZON</label>
                     <p class="form-control-static">{{$docPlantelPlantel->plantel->razon}}</p>
                </div>
                    <div class="form-group">
                     <label for="fec_vigencia">FEC_VIGENCIA</label>
                     <p class="form-control-static">{{$docPlantelPlantel->fec_vigencia}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_alta_id">USU_ALTA_ID</label>
                     <p class="form-control-static">{{$docPlantelPlantel->usu_alta_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_mod_id">USU_MOD_ID</label>
                     <p class="form-control-static">{{$docPlantelPlantel->usu_mod_id}}</p>
                </div>
            </form>

            <div class="row">
                </div>

            <a class="btn btn-link" href="{{ route('docPlantelPlantels.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>

        </div>
    </div>

@endsection