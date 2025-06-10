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
                    <p class="form-control-static">{{ $sepTitulo->plantel->razon }}</p>
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
                    <p class="form-control-static">{{ $sepTitulo->grado->name }}</p>
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

        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-condensed table-striped">
            <thead>
                <th>CLAVE_INSTITUCIÓN</th><th>NOMBRE_INSTITUCIÓN</th><th>CLAVE_CARRERA</th>
                <th>NOMBRE_CARRERA</th><th>FECHA_INICIO</th><th>FECHA_TERMINACIÓN</th>
                <th>ID_AUTORIZACION_RECONOCIMIENTO</th><th>AUTORIZACION_RECONOCIMIENTO</th><th>NÚMERO_Acuerdo o RVOE</th>
                <th>CURP</th><th>NOMBRE</th><th>PRIMER_APELLIDO</th>
                <th>SEGUNDO_APELLIDO</th><th>CORREO_ELECTRÓNICO</th><th>FECHA_EXPEDICIÓN</th>
                <th>ID_MODALIDAD_TITULACION</th><th>MODALIDAD_TITULACIÓN</th><th>FECHA_EXAMEN_PROFESIONAL</th>
                <th>FECHA_EXENCIÓN_EXAMEN_PROFESIONAL</th><th>SERVICIO_SOCIAL</th><th>ID_FUNDAMENTO_LEGAL_SERVICIO_SOCIAL</th>
                <th>ID_ENTIDAD_FEDERATIVA</th><th>ENTIDAD_FEDERATIVA</th><th>INSTITUCIÓN_PROCEDENCIA</th>
                <th>ID_TIPO_ESTUDIO_ANTECEDENTE</th><th>TIPO_ESTUDIO_ANTECEDENTE</th><th>ID_ENTIDAD_FEDERATIVA</th>
                <th>ENTIDAD_FEDERATIVA</th><th>FECHA_INICIO</th><th>FECHA_TERMINACIÓN</th>
                <th>NÚMERO_CÉDULA</th>
            </thead>
            <tbody>
                @foreach ($sepTitulo->lineas as $linea)
                    <tr>
                        <td></td><td></td><td></td>
                        <td></td><td></td><td></td>
                        <td></td><td></td><td></td>
                        <td></td><td></td><td></td>
                        <td></td><td></td><td></td>
                        <td></td><td></td><td></td>
                        <td></td><td></td><td></td>
                        <td></td><td></td><td></td>    
                        <td></td><td></td><td></td>
                        <td></td><td></td><td></td>
                    </tr>    
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
