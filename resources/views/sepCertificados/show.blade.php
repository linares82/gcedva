@extends('plantillas.admin_template')

@include('sepCertificados._common')

@section('header')

<ol class="breadcrumb">
	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
    <li><a href="{{ route('sepCertificados.index') }}">@yield('sepCertificadosAppTitle')</a></li>
    <li class="active">{{ $sepCertificado->name }}</li>
</ol>

<div class="page-header">
        <h1>@yield('sepCertificadosAppTitle') / Mostrar {{$sepCertificado->id}}

            {!! Form::model($sepCertificado, array('route' => array('sepCertificados.destroy', $sepCertificado->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? Estas seguro?')) { return true } else {return false };")) !!}
                <div class="btn-group pull-right" role="group" aria-label="...">
                    @permission('sepCertificado.edit')
                    <a class="btn btn-warning btn-group" role="group" href="{{ route('sepCertificados.edit', $sepCertificado->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                    @endpermission
                    @permission('sepCertificado.destroy')
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
                    <p class="form-control-static">{{$sepCertificado->id}}</p>
                </div>
                <div class="form-group col-sm-4">
                     <label for="plantel_id">PLANTEL</label>
                     <p class="form-control-static"><a href="{{route('plantels.edit', $sepCertificado->plantel_id)}}" target="_blank">{{$sepCertificado->plantel->razon}}</a></p>
                </div>
                    <div class="form-group col-sm-4">
                     <label for="especialidad_id">ESPECIALIDAD</label>
                     <p class="form-control-static">{{$sepCertificado->especialidad->name}}</p>
                </div>
                    <div class="form-group col-sm-4" style="clear:left;">
                     <label for="nivel_id">NIVEL</label>
                     <p class="form-control-static">{{$sepCertificado->nivel->name}}</p>
                </div>
                    <div class="form-group col-sm-4">
                     <label for="grado_id">GRADO</label>
                     <p class="form-control-static">
                        <a href="{{ route('grados.edit', $sepCertificado->grado_id) }}" target="_blank">
                            {{$sepCertificado->grado->name}}
                        </a>
                        
                    </p>
                </div>
                    <div class="form-group col-sm-4">
                     <label for="lectivo_id">LECTIVO</label>
                     <p class="form-control-static">{{$sepCertificado->lectivo->name}}</p>
                </div>
                    <div class="form-group col-sm-4" style="clear:left;">
                     <label for="grupo_id">GRUPO</label>
                     <p class="form-control-static">{{$sepCertificado->grupo->name}}</p>
                </div>
                    <div class="form-group col-sm-4">
                     <label for="responsable_id">RESPONSABLE</label>
                     <p class="form-control-static">
                        {{ $sepCertificado->cargo->id_cargo }}
                        {{ $sepCertificado->cargo->cargo }}
                        {{ $sepCertificado->responsable->nombre }}
                        {{ $sepCertificado->responsable->ape_paterno }}
                        {{ $sepCertificado->responsable->ape_materno }}
                        {{ $sepCertificado->responsable->curp }}
                    </p>
                </div>
                    <div class="form-group col-sm-4">
                     <label for="id_carrera">ID CARRERA</label>
                     <p class="form-control-static">{{$sepCertificado->id_carrera}}</p>
                </div>
                    <div class="form-group col-sm-4" style="clear:left;">
                     <label for="id_asignatura">ID ASIGNATURA</label>
                     <p class="form-control-static">{{$sepCertificado->id_asignatura}}</p>
                </div>
                <div class="form-group col-sm-4">
                     <label for="id_asignatura">FECHA EXPEDICION</label>
                     <p class="form-control-static">{{$sepCertificado->fecha_expedicion}}</p>
                </div>
                    <div class="form-group col-sm-4">
                     <label for="usu_mod_id">U. MODODIFICACION</label>
                     <p class="form-control-static">{{$sepCertificado->usu_mod->name}}</p>
                </div>
                    <div class="form-group col-sm-4">
                     <label for="usu_alta_id">ALTA</label>
                     <p class="form-control-static">{{$sepCertificado->usu_alta->name}}</p>
                </div>
            </form>

            <div class="row">
                </div>

            <a class="btn btn-link" href="{{ route('sepCertificados.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>
            <a class="btn btn-danger" href="{{ route('sepCertificados.limpiarLineas',$sepCertificado->id) }}"><i class="glyphicon glyphicon-trash"></i>  Eliminar Lineas</a>
            <a class="btn btn-success" href="#" onclick="location.reload();"><i class="glyphicon glyphicon-check"></i>  Cargar Lineas</a>

        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-condensed table-striped">
            <thead>
                <th>ID_Institución</th><th>Clave_Campus</th><th>ID_Entidad Federativa</th>
                <th>CURP_Responsable</th><th>Nombre(Responsable de la emisión)</th><th>Primer Apellido</th>
                <th>Segundo Apellido</th><th>ID_Cargo Responsable</th><th>NÚMERO CONTROL (Matrícula del alumno)</th>
                <th>CURP_ALUMNO</th><th>NOMBRE</th><th>PRIMER APELLIDO</th>
                <th>SEGUNDO APELLIDO</th><th>ID_GÉNERO</th><th>FECHA NACIMIENTO</th>
                <th>FOTO(Opcional)</th><th>FIRMA AUTÓGRAFA(Opcional)</th><th>ID _TIPO CERTIFICACIÓN</th>
                <th>TIPO CERTIFICACIÓN</th><th>FECHA (Expedición)</th><th>ID_LUGAR EXPEDICIÓN</th>
                <th>LUGAR EXPEDICIÓN</th><th>ID_TIPO PERIODO</th><th>TOTAL de Asignaturas</th>
                <th>CLAVE PLAN ESTUDIOS</th><th>NOMBRE PLAN ESTUDIOS</th><th>RVOE</th>
                <th>Fecha_RVOE</th><th>ID_CARRERA</th><th>Número de ASIGNATURAS cursadas</th>
                <th>PROMEDIO GENERAL</th><th>ID_ ASIGNATURA</th><th>NOMBRE ASIGNATURA</th>
                <th>CICLO</th><th>CALIFICACIÓN</th><th>ID_OBSERVACIONES</th>
                <th>OBSERVACIONES</th>
            </thead>
            <tbody>
                
                @foreach ($lineas as $linea)
                    <tr>
                        <td>{{ optional($sepCertificado->plantel->sepCertInstitucion)->id_institucion }}</td>
                        <td>{{ optional($sepCertificado->plantel->sepInstitucionEducativa)->cve_institucion}}</td>
                        <td>{{ optional($sepCertificado->plantel->estadoCatalogo)->cve_inegi}}</td>
                        <td>{{ optional($sepCertificado->responsable)->curp}}</td>
                        <td>{{ optional($sepCertificado->responsable)->nombre}}</td>
                        <td>{{ optional($sepCertificado->responsable)->ape_paterno}}</td>
                        <td>{{ optional($sepCertificado->responsable)->ape_materno}}</td>
                        <td>{{ optional($sepCertificado->cargo)->id_cargo}}</td>
                        <td>
                            <a href="{{route('clientes.edit', $linea->cliente->id)}}" target="_blank">
                                {{$linea->cliente->matricula}}
                            </a>
                        </td>
                        <td>{{$linea->cliente->curp}}</td>
                        <td>{{$linea->cliente->nombre}} {{$linea->cliente->nombre2}}</td>
                        <td>{{$linea->cliente->ape_paterno}}</td>
                        <td>{{$linea->cliente->ape_materno}}</td>
                        <td>
                            @if($linea->cliente->genero_id==1)
                                251
                            @else
                                250
                            @endif
                        </td>
                        <td>{{$linea->cliente->fec_nacimiento}}</td>
                        <td><!--foto--></td><td><!--firma--></td>
                        <td>{{$linea->sepCertTipo->id_tipo_certificacion}}</td><td>{{$linea->sepCertTipo->tipo_certificacion}}</td>
                        <td>{{$linea->fecha_expedicion}}</td>
                        <td>{{ $sepCertificado->plantel->estadoCatalogo->cve_inegi}}</td>
                        <td>{{ $sepCertificado->plantel->estadoCatalogo->name}}</td>
                        <td>{{ optional($sepCertificado->grado->duracionPeriodo)->id_tipo_periodo_certificado}}</td>    
                        <td>
                            @if(isset($sepCertificado->grado->plan_estudio_id))
                            <a href="{{route('planEstudios.edit',$sepCertificado->grado->plan_estudio_id)}}" target="_blank">
                            {{optional($sepCertificado->grado->planEstudio)->total_materias_100}}
                            </a>
                            @endif
                        </td>
                        <td>{{optional($sepCertificado->grado->planEstudio)->clave_sep_cert}}</td>
                        <td>{{optional($sepCertificado->grado->planEstudio)->nombre_sep_cert}}</td>
                        <td>{{optional($sepCertificado->grado)->rvoe}}</td>
                        <td>{{optional($sepCertificado->grado)->emision_rvoe}}</td>
                        <td>{{$linea->id_carrera}}</td><td>{{ $linea->numero_asignaturas_cursadas }}</td>
                        <td>{{$linea->promedio_general}}</td>
                        <td>
                            @if(!is_null($linea->hacademica_id))
                            <a target="_blank" href="{{route('materias.edit', $linea->hacademica->materium_id)}}">
                            {{$linea->hacademica->materia->id_asignatura_certificado}}
                            </a>
                            @else
                            {{ $linea->consultaCalificacion->id_asignatura }}
                            @endif
                        </td>
                        <td>
                            @if(!is_null($linea->hacademica_id))
                                @if($linea->hacademica->materia->nombre_oficial=="")
                                    <a target="_blank" href="{{route('materias.edit', $linea->hacademica->materium_id)}}">
                                    {{$linea->hacademica->materia->name}}
                                    </a>
                                @else
                                    <a target="_blank" href="{{route('materias.edit', $linea->hacademica->materium_id)}}">
                                    {{$linea->hacademica->materia->nombre_oficial}}
                                    </a>    
                                @endif
                            @else
                                @if($linea->consultaCalificacion->nombre_oficial=="")
                                    {{ $linea->consultaCalificacion->materia }}
                                @else
                                    {{ $linea->consultaCalificacion->nombre_oficial }}
                                @endif
                            
                            @endif
                        </td>
                        <td>
                            @if(!is_null($linea->lectivo_id))   
                                <a href="{{route('lectivos.edit',$linea->lectivo_id)}}" target="_blank">{{$linea->lectivo->ciclo_escolar}}-{{$linea->lectivo->periodo_escolar}}</a>
                            @else
                            {{ $linea->consultaCalificacion->ciclo }}
                            @endif
                        </td>
                        <td>{{$linea->calificacion_materia}}</td>
                        <td>
                            @if(!is_null($linea->sep_cert_observacion_id))
                            {{optional($linea->sepCertObservacion)->id_observacion}}
                            @else
                            {{ $linea->consultaCalificacion->id_observaciones }}
                            @endif
                        </td>
                        <td>
                            @if(!is_null($linea->sep_cert_observacion_id))
                               {{optional($linea->sepCertObservacion)->descripcion}}
                            @else
                            <a target="_blank" href="{{route('consultaCalificacions.edit', 
                            array('id'=>$linea->consulta_calificacion_id, 'cliente'=>$linea->cliente_id))}}">
                            {{ $linea->consultaCalificacion->observaciones }}
                            </a>
                            @endif
                        </td>
                    </tr>    
                @endforeach
            </tbody>
        </table>
    </div>

@endsection