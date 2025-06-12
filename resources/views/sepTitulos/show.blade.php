@extends('plantillas.admin_template')

@include('sepTitulos._common')

@section('header')
    <ol class="breadcrumb">
        <li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
        <li><a href="{{ route('sepTitulos.index') }}">@yield('sepTitulosAppTitle')</a></li>
        <li class="active">{{ $sepTitulo->name }}</li>
    </ol>

    <div class="page-header">
        <h1>@yield('sepTitulosAppTitle') / Mostrar {{ $sepTitulo->id }}

            {!! Form::model($sepTitulo, [
                'route' => ['sepTitulos.destroy', $sepTitulo->id],
                'method' => 'delete',
                'style' => 'display: inline;',
                'onsubmit' => "if(confirm('¿Borrar? Estas seguro?')) { return true } else {return false };",
            ]) !!}
            <div class="btn-group pull-right" role="group" aria-label="...">
                @permission('sepTitulo.edit')
                    <a class="btn btn-warning btn-group" role="group" href="{{ route('sepTitulos.edit', $sepTitulo->id) }}"><i
                            class="glyphicon glyphicon-edit"></i> Editar</a>
                @endpermission
                @permission('sepTitulo.destroy')
                    <button type="submit" class="btn btn-danger">Borrar <i class="glyphicon glyphicon-trash"></i>
                        < /button>
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
                    <p class="form-control-static">{{ $sepTitulo->id }}</p>
                </div>
                <div class="form-group col-sm-4">
                    <label for="plantel_id">PLANTEL</label>
                    <p class="form-control-static">
                        <a href="{{ route('plantels.edit', $sepTitulo->plantel_id) }}" target="_blank">
                            {{ $sepTitulo->plantel->razon }}
                        </a>
                    </p>
                </div>
                <div class="form-group col-sm-4">
                    <label for="especialidad_id">ESPECIALIDAD</label>
                    <p class="form-control-static">{{ $sepTitulo->especialidad->name }}</p>
                </div>
                <div class="form-group col-sm-4" style="clear:left;">
                    <label for="nivel_id">NIVEL</label>
                    <p class="form-control-static">{{ $sepTitulo->nivel->name }}</p>
                </div>
                <div class="form-group col-sm-4">
                    <label for="grado_id">GRADO</label>
                    <p class="form-control-static">
                        <a href="{{ route('grados.edit', $sepTitulo->grado_id) }}" target="_blank">
                            {{ $sepTitulo->grado->name }}
                        </a>
                    </p>
                </div>
                <div class="form-group col-sm-4">
                    <label for="lectivo">LECTIVO</label>
                    <p class="form-control-static">{{ $sepTitulo->lectivo->name }}</p>
                </div>
                <div class="form-group col-sm-4" style="clear:left;">
                    <label for="grupo_id">GRUPO</label>
                    <p class="form-control-static">{{ $sepTitulo->grupo->name }}</p>
                </div>
                <div class="form-group col-sm-4">
                    <label for="r1_sep_cargo_id">Responsable 1</label>
                    <p class="form-control-static">
                        {{ $sepTitulo->r1Cargo->id_cargo }}
                        {{ $sepTitulo->r1Cargo->cargo }}
                        {{ $sepTitulo->r1_titulo }}
                        {{ $sepTitulo->r1->nombre }}
                        {{ $sepTitulo->r1->ape_paterno }}
                        {{ $sepTitulo->r1->ape_materno }}
                        {{ $sepTitulo->r1->curp }}
                    </p>
                </div>
                <div class="form-group col-sm-4">
                    <label for="r2_sep_cargo_id">Responsable 2</label>
                    <p class="form-control-static">
                        {{ $sepTitulo->r2Cargo->id_cargo }}
                        {{ $sepTitulo->r2Cargo->cargo }}
                        {{ $sepTitulo->r2_titulo }}
                        {{ $sepTitulo->r2->nombre }}
                        {{ $sepTitulo->r2->ape_paterno }}
                        {{ $sepTitulo->r2->ape_materno }}
                        {{ $sepTitulo->r2->curp }}
                    </p>
                </div>
                <div class="form-group col-sm-4">
                    <label for="usu_alta_id">ALTA</label>
                    <p class="form-control-static">{{ $sepTitulo->usu_alta->name }}</p>
                </div>
                <div class="form-group col-sm-4">
                    <label for="usu_mod_id">ULTIMA MODIFICACION</label>
                    <p class="form-control-static">{{ $sepTitulo->usu_mod->name }}</p>
                </div>
            </form>

            <div class="row">
            </div>

            <a class="btn btn-link" href="{{ route('sepTitulos.index') }}"><i class="glyphicon glyphicon-backward"></i>
                Regresar</a>
            <a class="btn btn-danger" href="{{ route('sepTitulos.limpiarLineas',$sepTitulo->id) }}"><i class="glyphicon glyphicon-trash"></i>  Eliminar Lineas</a>
            <a class="btn btn-success" href="#" onclick="location.reload();"><i class="glyphicon glyphicon-check"></i>  Cargar Lineas</a>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-condensed table-striped">
            <thead>
                <th>FOLIO_CONTROL</th>
                <th>ID_CARGO</th><th>CARGO</th><th>ABR_TÍTULO_RESPONSABLE</th>
                <th>NOMBRE_RESPONSABLE</th><th>PRIMER_APELLIDO_RESPONSABLE</th>
                <th>SEGUNDO_APELLIDO_RESPONSABLE</th><th>CURP_RESPONSABLE</th>
                <th>ID_CARGO</th><th>CARGO</th><th>ABR_TÍTULO_RESPONSABLE</th>
                <th>NOMBRE_RESPONSABLE</th><th>PRIMER_APELLIDO_RESPONSABLE</th>
                <th>SEGUNDO_APELLIDO_RESPONSABLE</th>
                <th>CURP_RESPONSABLE</th><th>CLAVE_INSTITUCIÓN</th>
                <th>NOMBRE_INSTITUCIÓN</th><th>CLAVE_CARRERA</th>
                <th>NOMBRE_CARRERA</th><th>FECHA_INICIO</th><th>FECHA_TERMINACIÓN</th>
                <th>ID_AUTORIZACION_RECONOCIMIENTO</th><th>AUTORIZACION_RECONOCIMIENTO</th><th>NÚMERO_Acuerdo o RVOE</th>
                <th>CURP</th><th>NOMBRE</th><th>PRIMER_APELLIDO</th>
                <th>SEGUNDO_APELLIDO</th><th>CORREO_ELECTRÓNICO</th><th>FECHA_EXPEDICIÓN</th>
                <th>ID_MODALIDAD_TITULACION</th><th>MODALIDAD_TITULACIÓN</th><th>FECHA_EXAMEN_PROFESIONAL</th>
                <th>FECHA_EXENCIÓN_EXAMEN_PROFESIONAL</th><th>SERVICIO_SOCIAL</th>
                <th>ID_FUNDAMENTO_LEGAL_SERVICIO_SOCIAL</th><th>FUNDAMENTO_LEGAL_SERVICIO_SOCIAL</th>
                <th>ID_ENTIDAD_FEDERATIVA</th><th>ENTIDAD_FEDERATIVA</th><th>INSTITUCIÓN_PROCEDENCIA</th>
                <th>ID_TIPO_ESTUDIO_ANTECEDENTE</th><th>TIPO_ESTUDIO_ANTECEDENTE</th><th>ID_ENTIDAD_FEDERATIVA</th>
                <th>ENTIDAD_FEDERATIVA</th><th>FECHA_INICIO</th><th>FECHA_TERMINACIÓN</th>
                <th>NÚMERO_CÉDULA</th>
            </thead>
            <tbody>
                @foreach ($lineas as $linea)
                    <tr>
                        <td>{{$linea->cliente->matricula}}</td><td>{{$sepTitulo->r1Cargo->id_cargo}}</td>
                        <td>{{$sepTitulo->r1Cargo->cargo}}</td><td>{{$sepTitulo->r1_titulo}}</td>
                        <td>{{$sepTitulo->r1->nombre}}</td><td>{{$sepTitulo->r1->ape_paterno}}</td>
                        <td>{{$sepTitulo->r1->ape_materno}}</td><td>{{$sepTitulo->r1->curp}}</td>
                        <td>{{$sepTitulo->r2Cargo->id_cargo}}</td>
                        <td>{{$sepTitulo->r2Cargo->cargo}}</td><td>{{$sepTitulo->r2_titulo}}</td>
                        <td>{{$sepTitulo->r2->nombre}}</td><td>{{$sepTitulo->r2->ape_paterno}}</td>
                        <td>{{$sepTitulo->r2->ape_materno}}</td><td>{{$sepTitulo->r2->curp}}</td>
                        <td>{{$sepTitulo->plantel->sepInstitucionEducativa->cve_institucion}}</td>
                        <td>{{$sepTitulo->plantel->sepInstitucionEducativa->descripcion}}</td>
                        <td>{{$sepTitulo->grado->carrera->cve_carrera}}</td>
                        <td>{{$sepTitulo->grado->carrera->descripcion}}</td>
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
                        <td>{{$sepTitulo->grado->autorizacionReconocimiento->id_autorizacion_reconocimiento}}</td>
                        <td>{{$sepTitulo->grado->autorizacionReconocimiento->autorizacion_reconocimiento}}</td>
                        <td>{{ $sepTitulo->grado->rvoe }}</td>
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
                            @endphp
                            @endif        
                        </td>
                        <td>
                            @if(optional($linea->cliente->titulacions->where('bnd_titulado',1))->load('opcionTitulacion','opcionTitulacion.sepModalidadTitulacion')->first()!==null)
                            @php
                                $fecha_excepcion_examen_profesional=optional($linea->cliente->titulacions->where('bnd_titulado',1))->load('opcionTitulacion','opcionTitulacion.sepModalidadTitulacion')->first();
                                echo optional($fecha_excepcion_examen_profesional->opcionTitulacion->sepModalidadTitulacion)->descripcion;
                            @endphp
                            @endif        
                        </td>
                        <td>
                            @if($linea->cliente->titulacions->where('bnd_titulado',1)->first()!==null)
                            @php
                                $fecha_excepcion_examen_profesional=optional($linea->cliente->titulacions->where('bnd_titulado',1))->first();
                                echo $fecha_excepcion_examen_profesional->fecha_examen_profesional;
                            @endphp
                            @endif  
                        </td>
                        <td>
                            @if($linea->cliente->titulacions->where('bnd_titulado',1)->first()!==null)
                            @php
                                $fecha_excepcion_examen_profesional=optional($linea->cliente->titulacions->where('bnd_titulado',1))->first();
                                echo $fecha_excepcion_examen_profesional->fecha_excencion_examen_profesional;
                            @endphp
                            @endif        
                        </td>
                        <td>
                            @if($sepTitulo->grado->bnd_servicio_social==1)
                                SI
                            @else
                                No
                            @endif
                        </td>    
                        <td>{{optional($sepTitulo->grado->sepFundamentoLegalServicioSocial)->id_fundamento_legal_servicio_social}}</td>
                        <td>{{optional($sepTitulo->grado->sepFundamentoLegalServicioSocial)->fundamento_legal_servicio_social}}</td>
                        <td>{{$sepTitulo->plantel->estadoCatalogo->cve_inegi}}</td>
                        <td>{{$sepTitulo->plantel->estadoCatalogo->name}}</td>
                        <td>{{optional($linea->cliente->procedenciaAlumno)->institucion_procedencia}}</td>
                        @php
                            $antecedente=App\ProcedenciaAlumno::where('cliente_id', $linea->cliente->id)
                            ->with('sepTEstudioAntecedente','estado')
                            ->first();
                            //dd($antecedente);
                        @endphp
                        <td>
                            @if($antecedente!==null)
                            {{optional($antecedente->sepTEstudioAntecedente)->id_t_estudio_antecedente}}
                            @endif
                        </td>
                        <td>
                            @if($antecedente!==null)
                            {{optional($antecedente->sepTEstudioAntecedente)->t_estudio_antecedente}}
                            @endif
                        </td>
                        <td>
                            @if($antecedente!==null)
                            {{optional($antecedente->estado)->cve_inegi}}
                            @endif
                        </td>
                        <td>
                            @if($antecedente!==null)
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
@endsection
