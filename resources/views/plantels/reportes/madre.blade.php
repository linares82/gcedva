@extends('plantillas.admin_template')

@include('seguimientos._common')

@section('header')

	<ol class="breadcrumb">
		<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li><a href="{{ route('clientes.index') }}">@yield('clientesAppTitle')</a></li>
	    <li class="active">Altas por Usuario</li>
	</ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-plus"></i> @yield('seguimientosAppTitle') / Reporte Madre </h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">

            {!! Form::open(array('route' => 'plantels.madreR', 'id'=>'frm_reporte')) !!}

<!--                <div class="form-group col-md-6 @if($errors->has('estatus_f')) has-error @endif">
                    <label for="estatus_f-field">Estatus de:</label>
                    {!! Form::select("estatus_f", $list["StCliente"], null, array("class" => "form-control select_seguridad", "id" => "estatus_f-field", 'readonly'=>'readonly')) !!}
                    @if($errors->has("estatus_f"))
                    <span class="help-block">{{ $errors->first("estatus_f") }}</span>
                    @endif
                </div>
            
                <div class="form-group col-md-6 @if($errors->has('estatus_t')) has-error @endif">
                    <label for="estatus_t-field">Estatus a:</label>
                    {!! Form::select("estatus_t", $list["StCliente"], null, array("class" => "form-control select_seguridad", "id" => "estatus_t-field", 'readonly'=>'readonly')) !!}
                    @if($errors->has("estatus_t"))
                    <span class="help-block">{{ $errors->first("estatus_t") }}</span>
                    @endif
                </div>-->
            
                <div class="form-group col-md-6 @if($errors->has('plantel_f')) has-error @endif">
                    <label for="plantel_f-field">Plantel de:</label>
                    {!! Form::select("plantel_f", $planteles, null, array("class" => "form-control select_seguridad", "id" => "plantel_f-field")) !!}
                    <div id='loading10' style='display: none'><img src="{{ asset('images/ajax-loader.gif') }}" title="Enviando" /></div> 
                    @if($errors->has("plantel_f"))
                    <span class="help-block">{{ $errors->first("plantel_f") }}</span>
                    @endif
                </div>
                {!! Form::hidden("valor_reporte", null, array("id" => "valor_reporte-field")) !!}
                
                
                <div class="row">
                </div>
                <div class="well well-sm">
                    
                    <button class="btn btn-primary combinaciones">Combinaciones</button>
                    <button class="btn btn-primary asignaciones">Asignaciones</button>
                    <button class="btn btn-primary alumnos">Alumnos</button>
                    <button class="btn btn-primary alumnosCalificaciones">Alumnos Calificaciones</button>
                    
                    

                </div>
            {!! Form::close() !!}
        </div>
    </div>
    <div>
        @if(isset($plantels))
        <h4> Lista de Planteles</h4>
        <div class="box">
            <div class="box-body">
                <div class="table-responsive">    
                <table class="table table-condensed table-striped">
                    <thead>
                        <th>Csc</th>
                        <th>Logo</th><th>Razon Social</th><th>Razon Social(Contabilidad)</th><th>RFC</th>
                        <th>Direccion</th><th>Cve Multipagos</th><th>Cuenta Contable</th>
                        <th>Director</th><th>Tel.</th><th>Tel. Fijo</th><th>Tel. Cel.</th>
                        <th>Mail</th><th>Mail Empresa</th>
                    </thead>
                    <tbody>
                        @foreach($plantels as $plantel)
                        <tr>
                            <td>{{++$i}}</td>
                            <td>{{$plantel->logo}}</td><td>{{$plantel->razon}}</td><td>{{$plantel->nombre_corto}}</td>
                            <td>{{$plantel->rfc}}</td>
                            <td>{{$plantel->calle}} {{$plantel->no_int}}, {{$plantel->colonia}}, {{$plantel->municipio}}, {{$plantel->Estado}}, C.P. {{$plantel->cp}}</td>
                            <td>{{$plantel->cve_multipagos}}</td><td>{{$plantel->cuenta_contable}}</td>
                            <td>{{$plantel->nombre}} {{$plantel->ape_paterno}} {{$plantel->ape_materno}}</td>
                            <td>{{$plantel->tel}}</td><td>{{$plantel->tel_fijo}}</td><td>{{$plantel->tel_cel}}</td>
                            <td>{{$plantel->mail}}</td><td>{{$plantel->mail_empresa}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div>
            <div>
        <div>
        @endif
        @if(isset($combinaciones))
        <h4> Lista de Combinaciones</h4>
        <div class="box">
            <div class="box-body">
                <div class="table-responsive">    
                <table id="example1" class="table table-condensed table-striped">
                    <thead>
                        <tr>
                            <th>Csc</th>
                            <th>Logo</th><th>Razon Social</th><th>Razon Social(Contabilidad)</th><th>RFC</th>
                            <th>Direccion</th><th>Cve Multipagos</th><th>Cuenta Contable</th><th>CLABE</th><th>C. Bancaria</th>
                            <th>Director</th><th>Tel.</th><th>Tel. Fijo</th><th>Tel. Cel.</th>
                            <th>Mail</th><th>Mail Empresa</th>
                            <th>Especialidad</th><th>Nivel</th><th>Grado</th><th>Nombre RVOE</th><th>RVOE</th><th>Fec. RVOE</th>
                            <th>CCT</th><th>Denominacion</th><th>Seccion</th>
                        </tr>
                        
                    </thead>
                    <tbody>
                        @foreach($combinaciones as $combinacion)
                        <tr>
                            <td>{{++$i}}</td>
                            <td>{{$combinacion->logo}}</td><td>{{$combinacion->razon}}</td><td>{{$combinacion->nombre_corto}}</td>
                            <td>{{$combinacion->rfc}}</td>
                            <td>{{$combinacion->calle}} {{$combinacion->no_int}}, {{$combinacion->colonia}}, {{$combinacion->municipio}}, {{$combinacion->Estado}}, C.P. {{$combinacion->cp}}</td>
                            <td>{{$combinacion->cve_multipagos}}</td><td>{{$combinacion->cuenta_contable}}</td><td>{{$combinacion->clabe}}</td><td>{{$combinacion->cuenta_banco}}</td>
                            <td>{{$combinacion->nombre}} {{$combinacion->ape_paterno}} {{$combinacion->ape_materno}}</td>
                            <td>{{$combinacion->tel}}</td><td>{{$combinacion->tel_fijo}}</td><td>{{$combinacion->tel_cel}}</td>
                            <td>{{$combinacion->mail}}</td><td>{{$combinacion->mail_empresa}}</td>
                            <td>{{$combinacion->especialidad}}</td><td>{{$combinacion->nivel}}</td><td>{{$combinacion->grado}}</td>
                            <td>{{$combinacion->nombre2}}</td><td>{{$combinacion->rvoe}}</td><td>{{$combinacion->fec_rvoe}}</td><td>{{$combinacion->cct}}</td>
                            <td>{{$combinacion->denominacion}}</td><td>{{$combinacion->seccion}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div>
            <div>
        <div>
        @endif
        @if(isset($asignaciones))
        <h4> Lista de Asignaciones</h4>
        <div class="box">
            <div class="box-body">
                <div class="table-responsive">    
                <table class="table table-condensed table-striped">
                    <thead>
                        <tr>
                        <th>Csc</th><th>Plantel</th><th>Lectivo</th><th>Lectivo Oficial</th><th>Grupo</th><th>Materia</th><th>Docente</th>
                        <th>CURP</th><th>Domicilio</th><th>Fec. Nacimiento</th><th>Genero</th><th>Estado Nacimiento</th><th>Pais</th>
                        <th>N. Academico</th><th>Profesion</th><th>Cédula</th><th>Años Servicio Escuela</th><th>Docente O.</th>
                        <th>CURP</th><th>Domicilio</th><th>Fec. Nacimiento</th><th>Genero</th><th>Estado Nacimiento</th><th>Pais</th>
                        <th>N. Academico</th><th>Profesion</th><th>Cédula</th><th>Años Servicio Escuela</th><th>Total Alumnos</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($asignaciones as $asignacion)
                        <tr>
                            <td>{{++$i}}</td>
                            <td>{{$asignacion->razon}}</td><td>{{$asignacion->lectivo}}</td><td>{{$asignacion->lectivo_oficial}}</td>
                            <td>{{$asignacion->grupo}}</td><td>{{$asignacion->materia}}</td>
                            <td>{{$asignacion->nombre}} {{$asignacion->ape_paterno}} {{$asignacion->ape_materno}}</td><td>{{$asignacion->curp}}</td>
                            <td>{{$asignacion->domicilio}}</td><td>{{$asignacion->fec_nacimiento}}</td>
                            <td>@if($asignacion->genero==1)
                                Masculino
                                @else
                                Femenino
                                @endif
                            </td>
                            <td>{{$asignacion->estado}}</td><td>{{$asignacion->pais_nacimiento}}</td><td>{{$asignacion->nivel_academico}}</td>
                            <td>{{$asignacion->profesion}}</td><td>{{$asignacion->cedula}}</td><td>{{$asignacion->anios_servicio_escuela}}</td>
                            <td>{{$asignacion->do_nombre}} {{$asignacion->do_ape_paterno}} {{$asignacion->do_ape_materno}}</td><td>{{$asignacion->do_curp}}</td>
                            <td>{{$asignacion->do_domicilio}}</td><td>{{$asignacion->fec_nacimiento}}</td>
                            <td>@if($asignacion->genero==1)
                                Masculino
                                @else
                                Femenino
                                @endif
                            </td>
                            <td>{{$asignacion->do_estado}}</td><td>{{$asignacion->do_pais_nacimiento}}</td><td>{{$asignacion->do_nivel_academico}}</td>
                            <td>{{$asignacion->do_profesion}}</td><td>{{$asignacion->do_cedula}}</td><td>{{$asignacion->do_anios_servicio_escuela}}</td>
                            <td>{{$asignacion->total_alumnos}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div>
            <div>
        <div>
        @endif
        @if(isset($alumnos))
        <h4> Lista de Alumnos</h4>
        <div class="box">
            <div class="box-body">
                <div class="table-responsive">    
                <table class="table table-condensed table-striped">
                    <thead>
                        <th>Csc</th><th>Plantel</th>
                        <th>Id</th><th>Alumno</th><th>Matricula</th><th>Fec. Nacimiento</th><th>Genero</th><th>CURP</th><th>Estatus</th>
                        <th>Fec. Alta / Fec. Baja</th><th>Domicilio</th><th>Nacionalidad</th><th>Correo Electronico</th><th>Telefono</th><th>Estado Civil</th>
                        <th>Edad</th><th>Estado Nacimiento</th><th>Fec. Ingreso</th><th>Documentos</th><th>T. Beca</th><th>% Beca</th><th>Mensualidad SEP</th>
                        <th>Monto Beca SEP</th>
                        <th>Nombre Padre</th><th>Direccion</th><th>CURP</th><th>Mail</th><th>Tel.</th>
                        <th>Nombre Madre</th><th>Direccion</th><th>CURP</th><th>Mail</th><th>Tel.</th>
                    </thead>
                    <tbody>
                        @foreach($alumnos as $alumno)
                        <tr>
                            <td>{{++$i}}</td><td>{{$alumno->razon}}</td><td>{{$alumno->cliente_id}}</td>
                            <td>{{$alumno->nombre}} {{$alumno->nombre2}} {{$alumno->ape_paterno}} {{$alumno->ape_materno}}</td><td>{{$alumno->matricula}}</td>
                            <td>{{$alumno->fec_nacimiento}}</td>
                            <td>@if($alumno->genero==1)
                                Masculino
                                @else
                                Femenino
                                @endif
                            </td>
                            <td>{{$alumno->curp}}</td>
                            <td>{{$alumno->st_cliente}}</td><td>{{$alumno->created_at->format('d-m-Y')}} / {{$alumno->fecha_baja}}</td>
                            <td>{{$alumno->calle}} {{$alumno->no_ext}}, {{$alumno->colonia}}, {{$alumno->municipio}}, {{$alumno->estado}}, CP {{$alumno->cp}}</td>
                            <td>{{$alumno->nacionalidad}}</td><td>{{$alumno->mail}}</td><td>{{$alumno->tel_fijo}}</td><td>{{$alumno->estado_civil}}</td>
                            <td>{{$alumno->edad}}</td><td>{{$alumno->estado_nacimiento}}</td><td>{{$alumno->fecha_inscripcion}}</td>
                            <td>
                                <ul>
                                    @php
                                    $documentos=\App\PivotDocCliente::where('cliente_id',$alumno->cliente_id)->get(); 
                                    @endphp
                                    @foreach($documentos as $documento)
                                    <li>{{$documento->docAlumno->name}}</li>
                                @endforeach
                                </ul>
                            </td>
                            <td> {{$alumno->tipo_beca}}</td><td> {{$alumno->porcentaje_beca}}</td><td> {{$alumno->mensualidad_sep}}</td><td> {{$alumno->mensualidad_sep*$alumno->porcentaje_beca}}</td>
                            <td>{{ $alumno->nombre_padre }}</td><td>{{ $alumno->dir_padre }}</td><td>{{ $alumno->curp_padre }}</td><td>{{ $alumno->mail_padre }}</td><td>{{ $alumno->tel_padre }}</td>
                            <td>{{ $alumno->nombre_madre }}</td><td>{{ $alumno->dir_madre }}</td><td>{{ $alumno->curp_madre }}</td><td>{{ $alumno->mail_madre }}</td><td>{{ $alumno->tel_madre }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div>
            <div>
        <div>
        @endif
        @if(isset($alumnosCalificaciones))
        <h4> Lista de Alumnos y Calificaciones</h4>
        <div class="box">
            <div class="box-body">
                <div class="table-responsive">    
                <table class="table table-condensed table-striped">
                    <thead>
                        <th>Csc</th><th>Plantel</th>
                        <th>Especialidad</th><th>Nivel</th><th>Grado</th><th>Id</th><th>Alumno</th><th>Matricula</th><th>Grupo</th>
                        <th>Materia</th><th>Codigo</th><th>Creditos</th>
                        <th>Turno</th><th>Lectivo</th><th>Periodo Estudio</th>
                        <th>Tipo Examen</th><th>Calificacion</th><th>Faltas</th> 
                    </thead>
                    <tbody>
                        @foreach($alumnosCalificaciones as $alumnoC)
                        <tr>
                            <td>{{++$i}}</td><td>{{$alumnoC->razon}}</td>
                            <td>{{$alumnoC->especialidad}}</td><td>{{$alumnoC->nivel}}</td><td>{{$alumnoC->grado}}</td><td>{{$alumnoC->cliente_id}}</td>
                            <td>{{$alumnoC->nombre}} {{$alumnoC->nombre2}} {{$alumnoC->ape_paterno}} {{$alumnoC->ape_materno}}</td><td>{{$alumnoC->matricula}}</td>
                            <td>{{$alumnoC->grupo}}</td><td>{{$alumnoC->materia}}</td><td>{{$alumnoC->codigo}}</td><td>{{$alumnoC->creditos}}</td>
                            <td>{{$alumnoC->turno}}</td><td>{{$alumnoC->lectivo}}</td><td>{{$alumnoC->periodo_Estudio}}</td>
                            <td>{{$alumnoC->tipo_examen}}</td><td>{{$alumnoC->calificacion}}</td><td>{{ $alumnoC->faltas }}</td>
                            
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div>
            <div>
        <div>
        @endif
    </div>
@endsection
@push('scripts')
  <script type="text/javascript">
    $(document).ready(function() {
        
        $('#example1 thead tr').clone(true).appendTo( '#example1 thead' );
        $('#example1 thead tr:eq(1) th').each( function (i) {
            var title = $(this).text();
            $(this).html( '<input type="text" placeholder="Buscar '+title+'" />' );
    
            $( 'input', this ).on( 'keyup change', function (e) {
                
                if (e.keyCode == 13){
                    if ( table.column(i).search() !== this.value ) {
                    table
                        .column(i)
                        .search( this.value )
                        .draw();
                }
                }
                
            } );
        } );
        

        let table = $('#example1').DataTable({
          "paging": false,
          "lengthChange": true,
          "searching": true,
          "ordering": false,
          "info": true,
          "autoWidth": true
        });

        /*
        var oTable = $('#example1').dataTable( {
        "bPaginate": false,
        "bLengthChange": true,
        "bFilter": true,
        "bSort": true,
        "bInfo": true,
        "bAutoWidth": true } );
        
        $('#example1_filter input').unbind();
        $('#example1_filter input').bind('keyup', function(e) {
        if(e.keyCode == 13) {
        oTable.fnFilter(this.value);
        }
        });*/
        

        $(".plantel").click(function(e){
            e.preventDefault();
            $('#valor_reporte-field').val('planteles');
            $('#frm_reporte').attr('action', '{{route("plantels.madreR")}}');
            $('#frm_reporte').submit();
        });

        $(".combinaciones").click(function(e){
            e.preventDefault();
            $('#valor_reporte-field').val('combinaciones');
            $('#frm_reporte').attr('action', '{{route("plantels.madreR")}}');
            $('#frm_reporte').submit();
        });

        $(".asignaciones").click(function(e){
            e.preventDefault();
            $('#valor_reporte-field').val('asignaciones');
            $('#frm_reporte').attr('action', '{{route("plantels.madreR")}}');
            $('#frm_reporte').submit();
        });

        $(".alumnos").click(function(e){
            e.preventDefault();
            $('#valor_reporte-field').val('alumnos');
            $('#frm_reporte').attr('action', '{{route("plantels.madreR")}}');
            $('#frm_reporte').submit();
        });

        
        $(".alumnosCalificaciones").click(function(e){
            e.preventDefault();
            $('#valor_reporte-field').val('alumnosCalificaciones');
            $('#frm_reporte').attr('action', '{{route("plantels.madreR")}}');
            $('#frm_reporte').submit();
        });
    });
    
    </script>
@endpush