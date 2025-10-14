@extends('plantillas.admin_template')

@include('setyceLotes._common')

@section('header')

<ol class="breadcrumb">
	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
    <li><a href="{{ route('setyceLotes.index') }}">@yield('setyceLotesAppTitle')</a></li>
    <li class="active">{{ $setyceLote->name }}</li>
</ol>

<div class="page-header">
        <h1>@yield('setyceLotesAppTitle') / Mostrar {{$setyceLote->id}}

            {!! Form::model($setyceLote, array('route' => array('setyceLotes.destroy', $setyceLote->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? Estas seguro?')) { return true } else {return false };")) !!}
                <div class="btn-group pull-right" role="group" aria-label="...">
                    @permission('setyceLote.edit')
                    <a class="btn btn-warning btn-group" role="group" href="{{ route('setyceLotes.edit', $setyceLote->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                    @endpermission
                    @permission('setyceLote.destroy')
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
                    <p class="form-control-static">{{$setyceLote->id}}</p>
                </div>
                <div class="form-group col-sm-4">
                     <label for="setyce_id">SETYCE ID</label>
                     <p class="form-control-static">{{$setyceLote->setyce_id}}</p>
                </div>
                    <div class="form-group col-sm-4">
                     <label for="name">NOMBRE</label>
                     <p class="form-control-static">{{$setyceLote->name}}</p>
                </div>
                <div class="form-group col-sm-4">
                     <label for="name">Clientes</label>
                     <p class="form-control-static">{{$setyceLote->clientes}}</p>
                </div>
                <div class="form-group col-sm-4">
                     <label for="name">Titulacion Grupo</label>
                     <p class="form-control-static">{{$setyceLote->titulacionGrupo->name}}</p>
                </div>
                    <div class="form-group col-sm-4">
                     <label for="usu_alta_id">U. ALTA</label>
                     <p class="form-control-static">{{$setyceLote->usu_alta->name}}</p>
                </div>
                    <div class="form-group col-sm-4">
                     <label for="usu_mod_id">U. MODIFICACION</label>
                     <p class="form-control-static">{{$setyceLote->usu_mod->name}}</p>
                </div>
            </form>

            <div class="row">
            </div>
            <a class="btn btn-info" href="{{ route('setyceLotes.addAlumnos', $setyceLote->id) }}"></i>Crear Lineas</a>
            <a class="btn btn-link" href="{{ route('setyceLotes.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>

        </div>
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-condensed table-striped">
                    <thead>
                        <th>CLIENTE ID</th>
                        <th>SETyCE ID</th>
                        <th>CARRERA</th>
                        <th>FECHA_INICIO</th><th>FECHA_TERMINACIÓN</th>
                        <th>FOLIO</th>
                        <th>CURP</th><th>NOMBRE</th><th>PRIMER APELLIDO</th>
                        <th>SEGUNDO APELLIDO</th><th>CORREO_ELECTRÓNICO</th>
                        <th>FECHA EXPEDICIÓN</th>
                        <th>MODALIDAD TITULACION</th>
                        <th>FECHA EXAMEN PROFESIONAL</th>
                        <th>CUMPLIO SERVICIO SOCIAL</th>
                        <th>FUNDAMENTO LEGAL SERVICIO SOCIAL</th>
                        <th>ENTIDAD EXPEDICION</th>
                        <th>INSTITUCIÓN PROCEDENCIA</th>
                        <th>TIPO ESTUDIO ANTECEDENTE</th>
                        <th>ENTIDAD ANTECEDENTE</th>
                        <th>FECHA INICIO ANTECEDENTE</th><th>FECHA TERMINACIÓN ANTECEDENTE</th>
                        <th>NÚMERO_CÉDULA</th>
                    </thead>
                    <tbody>
                        
                        @foreach ($lineas as $linea)
                            @php
                            //dd($linea->cliente_id);
                            @endphp
                            <tr>
                                <td>{{$linea->cliente_id}}</td>
                                <td>{{$linea->setyce_id}}</td>
                                <td>{{optional($linea->cliente->combinacionCliente->grado->carrera)->cve_carrera}}</td>
                                @php
                                    $primeraMateria=App\Hacademica::where('cliente_id', $linea->cliente_id)
                                    ->with('lectivo')
                                    ->orderBy('id', 'asc')
                                    ->first();
                                    $ultimaMateria=App\Hacademica::where('cliente_id', $linea->cliente_id)
                                    ->with('lectivo')
                                    ->orderBy('id', 'desc')
                                    ->first();
                                @endphp
                                <td>
                                    {{ $primeraMateria->lectivo->inicio }}    
                                </td>
                                <td>
                                    {{ $ultimaMateria->lectivo->fin }}    
                                </td>
                                <td></td>
                                <td>
                                    <a href="{{ route('clientes.edit', $linea->cliente_id) }}" target="_blank">
                                    {{$linea->cliente->curp}}
                                    </a>
                                </td>
                                <td>{{$linea->cliente->nombre}} {{$linea->cliente->nombre2}}</td>
                                <td>{{$linea->cliente->ape_paterno}}</td><td>{{$linea->cliente->ape_materno}}</td>
                                <td>{{$linea->cliente->mail}}</td>
                                <td>
                                    @if($linea->cliente->titulacions->where('bnd_titulado',1)->first()!==null)
                                    @php
                                        $fecha_excepcion_examen_profesional=optional($linea->cliente->titulacions->where('bnd_titulado',1))->first();
                                        echo '<a href="'.route('titulacions.edit', $fecha_excepcion_examen_profesional->id).'" target="_blank">';    
                                        echo $fecha_excepcion_examen_profesional->fecha_expedicion;
                                        echo "</a>";
                                    @endphp
                                    @endif  
                                </td>
                                <td>
                                    @if(optional($linea->cliente->titulacions->where('bnd_titulado',1))->load('opcionTitulacion','opcionTitulacion.sepModalidadTitulacion')->first()!==null)
                                    @php
                                        $fecha_excepcion_examen_profesional=optional($linea->cliente->titulacions->where('bnd_titulado',1))->load('opcionTitulacion','opcionTitulacion.sepModalidadTitulacion')->first();
                                        echo optional($fecha_excepcion_examen_profesional->opcionTitulacion->sepModalidadTitulacion)->id_modalidad;
                                        echo "-";
                                        echo optional($fecha_excepcion_examen_profesional->opcionTitulacion->sepModalidadTitulacion)->descripcion;
                                    @endphp
                                    @endif        
                                </td>
                                <td>
                                    @if($linea->cliente->titulacions->where('bnd_titulado',1)->first()!==null)
                                    @php
                                        $fecha_excepcion_examen_profesional=optional($linea->cliente->titulacions->where('bnd_titulado',1))->first();
                                        //dd($fecha_excepcion_examen_profesional);
                                        echo $fecha_excepcion_examen_profesional->fecha_examen_profesional;
                                    @endphp
                                    @endif  
                                </td>
                                <td>
                                    @if($linea->cliente->combinacionCliente->grado->bnd_servicio_social==1)
                                        SI
                                    @else
                                        No
                                    @endif
                                </td>    
                                <td>
                                    {{optional($linea->cliente->combinacionCliente->grado->sepFundamentoLegalServicioSocial)->id_fundamento_legal_servicio_social}} - 
                                    {{optional($linea->cliente->combinacionCliente->grado->sepFundamentoLegalServicioSocial)->fundamento_legal_servicio_social}}
                                </td>
                                <td>
                                    {{$linea->cliente->plantel->estadoCatalogo->cve_inegi}} -
                                    {{$linea->cliente->plantel->estadoCatalogo->name}}
                                </td>
                                <td>{{optional($linea->cliente->procedenciaAlumno)->institucion_procedencia}}</td>
                                @php
                                    $antecedente=App\ProcedenciaAlumno::where('cliente_id', $linea->cliente->id)
                                    ->with('sepTEstudioAntecedente','estado')
                                    ->first();
                                    //dd($antecedente);
                                @endphp
                                <td>
                                    @if($antecedente!==null)
                                    {{optional($antecedente->sepTEstudioAntecedente)->id_t_estudio_antecedente}} -
                                    {{optional($antecedente->sepTEstudioAntecedente)->t_estudio_antecedente}}
                                    @endif
                                </td>
                                <td>
                                    @if($antecedente!==null)
                                    {{optional($antecedente->estado)->cve_inegi}} -
                                    {{optional($antecedente->estado)->name}}
                                    @endif
                                </td>
                                <td>
                                    @if($antecedente!==null)
                                    {{optional($antecedente)->fecha_inicio}}
                                    @endif    
                                </td>
                                <td>
                                    @if($antecedente!==null)
                                    {{optional($antecedente)->fecha_terminacion}}
                                    @endif    

                                </td>
                                <td>
                                    @if($antecedente!==null)
                                    {{optional($antecedente)->numero_cedula}}
                                    @endif    

                                </td>
                            </tr>    
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection