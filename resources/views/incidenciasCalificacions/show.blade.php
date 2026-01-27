@extends('plantillas.admin_template')

@include('incidenciasCalificacions._common')

@section('header')

<ol class="breadcrumb">
	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
    <li><a href="{{ route('incidenciasCalificacions.index') }}">@yield('incidenciasCalificacionsAppTitle')</a></li>
    <li class="active">{{ $incidenciasCalificacion->name }}</li>
</ol>

<div class="page-header">
        <h1>@yield('incidenciasCalificacionsAppTitle') / Mostrar {{$incidenciasCalificacion->id}}

        </h1>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">

            <form action="#">
                <div class="form-group col-sm-4">
                    <label for="nome">ID</label>
                    <p class="form-control-static">{{$incidenciasCalificacion->id}}</p>
                </div>
                
                    <div class="form-group col-sm-4">
                     <label for="cliente_id">CLIENTE</label>
                     <p class="form-control-static">
                        {{$incidenciasCalificacion->cliente_id}} 
                        {{$incidenciasCalificacion->cliente->nombre}}
                        {{$incidenciasCalificacion->cliente->nombre2}}
                        {{$incidenciasCalificacion->cliente->ape_paterno}}
                        {{$incidenciasCalificacion->cliente->ape_materno}}
                    </p>
                </div>
                <div class="form-group col-sm-4">
                     <label for="calificacion_nueva">MATERIA</label>
                     <p class="form-control-static">{{$incidenciasCalificacion->materium->name}}</p>
                </div>
                <div class="form-group col-sm-4">
                     <label for="calificacion_nueva">Calificacion Ponderacion</label>
                     <p class="form-control-static">{{$incidenciasCalificacion->calificacionPonderacion->cargaPonderacion->name}}</p>
                </div>
                <div class="form-group col-sm-4">
                     <label for="calificacion_nueva">CALIFICACION ANTERIOR</label>
                     <p class="form-control-static">{{$incidenciasCalificacion->calificacionPonderacion->calificacion_parcial}}</p>
                </div>
                <div class="form-group col-sm-4">
                     <label for="calificacion_nueva">CALIFICACION NUEVA</label>
                     <p class="form-control-static">{{$incidenciasCalificacion->calificacion_nueva}}</p>
                </div>
                    <div class="form-group col-sm-4">
                     <label for="justificacion">JUSTIFICACION</label>
                     <p class="form-control-static">{{$incidenciasCalificacion->justificacion}}</p>
                </div>
                <div class="form-group col-sm-4">
                     <label for="justificacion">OBS.</label>
                     <p class="form-control-static">{{$incidenciasCalificacion->observacion}}</p>
                </div>
                <div class="form-group col-sm-4">
                     <label for="justificacion">Autorizado</label>
                     <p class="form-control-static">
                        @if($incidenciasCalificacion->bnd_autorizada==1)
                            SI
                        @else
                            NO
                        @endif
                    </p>
                </div>
                <div class="form-group col-sm-4">
                     <label for="justificacion">Rechazado</label>
                     <p class="form-control-static">
                        @if($incidenciasCalificacion->bnd_rechazada==1)
                            SI
                        @else
                            NO
                        @endif</p>
                </div>
                <div class="form-group col-sm-4">
                     <label for="fecha_ar">FECHA AUTORIZAR/RECHAZAR</label>
                     <p class="form-control-static">{{$incidenciasCalificacion->fecha_ar}}</p>
                </div>
                </div>
                    <div class="form-group col-sm-4">
                     <label for="usu_mod_id">RESPUESTA</label>
                     <p class="form-control-static">{{$incidenciasCalificacion->respuesta}}</p>
                </div>
                    <div class="form-group col-sm-4">
                     <label for="usu_alta_id">ALTA</label>
                     <p class="form-control-static"> {{$incidenciasCalificacion->created_at->format('d-m-Y')}} {{$incidenciasCalificacion->usu_alta->name}}</p>
                </div>
                    <div class="form-group col-sm-4">
                     <label for="usu_mod_id">U. MODIFICACION</label>
                     <p class="form-control-static">{{$incidenciasCalificacion->usu_mod->name}}</p>
                </div>
                <div class="form-group col-sm-4">
                     <label for="usu_mod_id">Evidencia</label>
                     <p class="form-control-static">
                        <a target="_blank" href="{{ asset('storage/incidencias_calificacions/' . $incidenciasCalificacion->imagen) }}">
                            Ver
                        </a>
                     </p>
                </div>
            </form>

            <div class="row">
                </div>

            <a class="btn btn-link" href="{{ route('incidenciasCalificacions.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>
            @permission('incidenciasCalificacions.edit')
            <!--<a class="btn btn-warning" href="{{ route('incidenciasCalificacions.edit', $incidenciasCalificacion->id) }}"> Editar</a>-->
            @endpermission
            @permission('incidenciasCalificacions.autorizar')
            <!--<a class="btn btn-success" href="{{ route('incidenciasCalificacions.autorizar', array('id'=>$incidenciasCalificacion->id)) }}">  Autorizar</a>-->
            @endpermission
            @permission('incidenciasCalificacions.rechazar')
             <!--<a class="btn btn-danger" href="{{ route('incidenciasCalificacions.rechazar', array('id'=>$incidenciasCalificacion->id)) }}">  Rechazar</a>-->
            @endpermission    
            
            <div class="row"></div>
            @if($incidenciasCalificacion->bnd_autorizada==0 && $incidenciasCalificacion->bnd_rechazada==0)
            {!! Form::model($incidenciasCalificacion, array('route' => array('incidenciasCalificacions.edit', $incidenciasCalificacion->id),'id' => 'frm_ar', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('Estas seguro de tu evaluación?')) { return true } else {return false };")) !!}
                <div class="form-group col-md-12 @if ($errors->has('justificacion')) has-error @endif">
                <label for="justificacion-field">Justificacion</label>
                {!! Form::hidden('id', $incidenciasCalificacion->id, [
                        'class' => 'form-control',
                        'id' => 'incidencias_calificacion_id-field',
                ]) !!}
                {!! Form::textArea('respuesta', null, [
                        'class' => 'form-control',
                        'id' => 'respuesta-field',
                        'rows' => 3,
                ]) !!}
                @if ($errors->has('justificacion'))
                        <span class="help-block">{{ $errors->first('justificacion') }}</span>
                @endif
                </div>
                <div class="row"></div>
                @permission('incidenciasCalificacions.autorizar')
                <div class="btn-group pull-right" role="group" aria-label="...">
                    <a class="btn btn-success btn-group" id="btn_autorizar" role="group" href="{{ route('incidenciasCalificacions.edit', $incidenciasCalificacion->id) }}"><i class="glyphicon glyphicon-edit"></i> Autorizar</a>
                </div>
                @endpermission
                @permission('incidenciasCalificacions.rechazar')
                <div class="btn-group pull-right" role="group" aria-label="...">
                    <a class="btn btn-danger btn-group" id="btn_rechazar" role="group" href="{{ route('incidenciasCalificacions.edit', $incidenciasCalificacion->id) }}"><i class="glyphicon glyphicon-edit"></i> Rechazar</a>
                </div>
                @endpermission
                
            {!! Form::close() !!}
                @endif
        </div>
    </div>

@endsection

@push('scripts')
   <script>
         $(document).ready(function() {
            $('#btn_autorizar').click(function(event){
                event.preventDefault();
                var url = "{{ route('incidenciasCalificacions.autorizar') }}";
                var $miFormulario = $('#frm_ar');
                $miFormulario.attr('action', url);
                $miFormulario.submit();

            });

            $('#btn_rechazar').click(function(event){
                event.preventDefault();
                var url = "{{ route('incidenciasCalificacions.rechazar') }}";
                var $miFormulario = $('#frm_ar');
                $miFormulario.attr('action', url);
                $miFormulario.submit();
            });
         });
   </script>
@endpush
