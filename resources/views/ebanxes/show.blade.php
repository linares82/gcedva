@extends('plantillas.admin_template')

@include('ebanxes._common')

@section('header')

<ol class="breadcrumb">
	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
    <li><a href="{{ route('ebanxes.index') }}">@yield('ebanxesAppTitle')</a></li>
    <li class="active">{{ $ebanx->name }}</li>
</ol>

<div class="page-header">
        <h1>@yield('ebanxesAppTitle') / Mostrar {{$ebanx->id}}

            {!! Form::model($ebanx, array('route' => array('ebanxes.destroy', $ebanx->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? Estas seguro?')) { return true } else {return false };")) !!}
                <div class="btn-group pull-right" role="group" aria-label="...">
                    @permission('ebanx.edit')
                    <a class="btn btn-warning btn-group" role="group" href="{{ route('ebanxes.edit', $ebanx->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                    @endpermission
                    @permission('ebanx.destroy')
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
                    <p class="form-control-static">{{$ebanx->id}}</p>
                </div>
                <div class="form-group">
                     <label for="nombre">NOMBRE</label>
                     <p class="form-control-static">{{$ebanx->nombre}}</p>
                </div>
                    <div class="form-group">
                     <label for="nombre2">NOMBRE2</label>
                     <p class="form-control-static">{{$ebanx->nombre2}}</p>
                </div>
                    <div class="form-group">
                     <label for="ape_paterno">APE_PATERNO</label>
                     <p class="form-control-static">{{$ebanx->ape_paterno}}</p>
                </div>
                    <div class="form-group">
                     <label for="ape_materno">APE_MATERNO</label>
                     <p class="form-control-static">{{$ebanx->ape_materno}}</p>
                </div>
                    <div class="form-group">
                     <label for="fel_fijo">FEL_FIJO</label>
                     <p class="form-control-static">{{$ebanx->fel_fijo}}</p>
                </div>
                    <div class="form-group">
                     <label for="mail">MAIL</label>
                     <p class="form-control-static">{{$ebanx->mail}}</p>
                </div>
                    <div class="form-group">
                     <label for="plantel_id">PLANTEL_ID</label>
                     <p class="form-control-static">{{$ebanx->plantel_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="medio_id">MEDIO_ID</label>
                     <p class="form-control-static">{{$ebanx->medio_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="empleado_id">EMPLEADO_ID</label>
                     <p class="form-control-static">{{$ebanx->empleado_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="observaciones">OBSERVACIONES</label>
                     <p class="form-control-static">{{$ebanx->observaciones}}</p>
                </div>
                    <div class="form-group">
                     <label for="estado_id">ESTADO_ID</label>
                     <p class="form-control-static">{{$ebanx->estado_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="municipio_id">MUNICIPIO_ID</label>
                     <p class="form-control-static">{{$ebanx->municipio_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="st_cliente_id">ST_CLIENTE_ID</label>
                     <p class="form-control-static">{{$ebanx->st_cliente_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="especialidad_id">ESPECIALIDAD_ID</label>
                     <p class="form-control-static">{{$ebanx->especialidad_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="especialidad_id">ESPECIALIDAD_ID</label>
                     <p class="form-control-static">{{$ebanx->especialidad_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="especialidad2_id">ESPECIALIDAD2_ID</label>
                     <p class="form-control-static">{{$ebanx->especialidad2_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="especialidad3_id">ESPECIALIDAD3_ID</label>
                     <p class="form-control-static">{{$ebanx->especialidad3_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="especialidad4_id">ESPECIALIDAD4_ID</label>
                     <p class="form-control-static">{{$ebanx->especialidad4_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="nivel_id">NIVEL_ID</label>
                     <p class="form-control-static">{{$ebanx->nivel_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="diplomado_id">DIPLOMADO_ID</label>
                     <p class="form-control-static">{{$ebanx->diplomado_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="curso_id">CURSO_ID</label>
                     <p class="form-control-static">{{$ebanx->curso_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="otro_id">OTRO_ID</label>
                     <p class="form-control-static">{{$ebanx->otro_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="grado_id">GRADO_ID</label>
                     <p class="form-control-static">{{$ebanx->grado_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="subdiplomado_id">SUBDIPLOMADO_ID</label>
                     <p class="form-control-static">{{$ebanx->subdiplomado_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="subotro_id">SUBOTRO_ID</label>
                     <p class="form-control-static">{{$ebanx->subotro_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="turno_id">TURNO_ID</label>
                     <p class="form-control-static">{{$ebanx->turno_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="turno2_id">TURNO2_ID</label>
                     <p class="form-control-static">{{$ebanx->turno2_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="turno3_id">TURNO3_ID</label>
                     <p class="form-control-static">{{$ebanx->turno3_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="turno4_id">TURNO4_ID</label>
                     <p class="form-control-static">{{$ebanx->turno4_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="ofertum_id">OFERTUM_ID</label>
                     <p class="form-control-static">{{$ebanx->ofertum_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="matricula">MATRICULA</label>
                     <p class="form-control-static">{{$ebanx->matricula}}</p>
                </div>
                    <div class="form-group">
                     <label for="ciclo_id">CICLO_ID</label>
                     <p class="form-control-static">{{$ebanx->ciclo_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="empresa_id">EMPRESA_ID</label>
                     <p class="form-control-static">{{$ebanx->empresa_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="cve_cliente">CVE_CLIENTE</label>
                     <p class="form-control-static">{{$ebanx->cve_cliente}}</p>
                </div>
                    <div class="form-group">
                     <label for="tel_cel">TEL_CEL</label>
                     <p class="form-control-static">{{$ebanx->tel_cel}}</p>
                </div>
                    <div class="form-group">
                     <label for="paise_id">PAISE_ID</label>
                     <p class="form-control-static">{{$ebanx->paise_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_alta_id">USU_ALTA_ID</label>
                     <p class="form-control-static">{{$ebanx->usu_alta_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_mod_id">USU_MOD_ID</label>
                     <p class="form-control-static">{{$ebanx->usu_mod_id}}</p>
                </div>
            </form>

            <div class="row">
                </div>

            <a class="btn btn-link" href="{{ route('ebanxes.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>

        </div>
    </div>

@endsection