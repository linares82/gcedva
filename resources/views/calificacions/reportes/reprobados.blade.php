@extends('plantillas.admin_template')

@include('seguimientos._common')

@section('header')
    <ol class="breadcrumb">
        <li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
        <li><a href="{{ route('seguimientos.index') }}">@yield('seguimientosAppTitle')</a></li>
        <li class="active">Reporte de Evaluaciones Reprobadas</li>
    </ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-plus"></i> @yield('seguimientosAppTitle') / Reprobadas </h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">

            {!! Form::open(['route' => 'calificacions.reprobadosR']) !!}

            <div class="form-group col-md-6 @if ($errors->has('plantel_f')) has-error @endif">
                <label for="plantel_f-field">Plantel de:</label>
                {!! Form::select('plantel_f', $planteles, null, [
                    'class' => 'form-control select_seguridad',
                    'id' => 'plantel_f-field',
                ]) !!}
                @if ($errors->has('plantel_f'))
                    <span class="help-block">{{ $errors->first('plantel_f') }}</span>
                @endif
            </div>

            <div class="form-group col-md-6 @if ($errors->has('inicio_matricula')) has-error @endif">
                <label for="inicio_matricula-field">Inicio Matricula(4 digitos):</label>
                {!! Form::text('inicio_matricula', null, ['class' => 'form-control input-sm', 'id' => 'inicio_matricula-field']) !!}
                @if ($errors->has('inicio_matricula'))
                    <span class="help-block">{{ $errors->first('inicio_matricula') }}</span>
                @endif
            </div>

            <div class="form-group col-md-6 @if ($errors->has('lectivo_f')) has-error @endif">
                <label for="lectivo-field">Lectivo:</label>
                {!! Form::select('lectivo', $lectivos, null, [
                    'class' => 'form-control select_seguridad',
                    'id' => 'lectivo-field',
                ]) !!}
            </div>

            <!--
                        <div class="form-group col-md-6 @if ($errors->has('fecha_f')) has-error @endif">
                            <label for="fecha_f-field">Fecha de:</label>
                            {!! Form::text('fecha_f', null, ['class' => 'form-control input-sm', 'id' => 'fecha_f-field']) !!}
                            @if ($errors->has('fecha_f'))
    <span class="help-block">{{ $errors->first('fecha_f') }}</span>
    @endif
                        </div>
                        /*
                        <div class="form-group col-md-6 @if ($errors->has('fecha_t')) has-error @endif">
                            <label for="fecha_t-field">Fecha a:</label>
                            {!! Form::text('fecha_t', null, ['class' => 'form-control input-sm', 'id' => 'fecha_t-field']) !!}
                            @if ($errors->has('fecha_t'))
    <span class="help-block">{{ $errors->first('fecha_t') }}</span>
    @endif
                        </div>
                    -->

            <!--    <div class="form-group col-md-6 @if ($errors->has('plantel_t')) has-error @endif">
                                        <label for="plantel_t-field">Plantel a:</label>
                                        {!! Form::select('plantel_t', $planteles, null, [
                                            'class' => 'form-control select_seguridad',
                                            'id' => 'plantel_t-field',
                                        ]) !!}
                                        @if ($errors->has('plantel_t'))
    <span class="help-block">{{ $errors->first('plantel_t') }}</span>
    @endif
                                    </div>
                                
                                
                                    
                                    -->
            <div class="row">
            </div>
            <div class="well well-sm">
                <button type="submit" class="btn btn-primary">Tabla</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection
@push('scripts')
    <script type="text/javascript">
        $(document).ready(function() {

            $('#tpo_examen-field').on('change', function() {
                if ($('#tpo_examen-field option:selected').val() == 2) {
                    $('#ponderacion_id-field').prop('disabled', true);
                    $('#carga_ponderacion_id-field').prop('disabled', true);
                } else {
                    $('#ponderacion_id-field').prop('disabled', false);
                    $('#carga_ponderacion_id-field').prop('disabled', false);
                }
            });

            $('#ponderacion_id-field').change(function() {
                getCmbCargaPonde();
            });

            $('#fecha_f-field').Zebra_DatePicker({
                days: ['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'],
                months: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto',
                    'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
                ],
                readonly_element: false,
                lang_clear_date: 'Limpiar',
                show_select_today: 'Hoy',
            });
            $('#fecha_t-field').Zebra_DatePicker({
                days: ['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'],
                months: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto',
                    'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
                ],
                readonly_element: false,
                lang_clear_date: 'Limpiar',
                show_select_today: 'Hoy',
            });

        });

        function getCmbCargaPonde() {
            //var $example = $("#especialidad_id-field").select2();
            var a = $('#frm_cliente').serialize();
            $.ajax({
                url: '{{ route('cargaPonderacions.getCmbCarga') }}',
                type: 'GET',
                data: "ponderacion_id=" + $('#ponderacion_id-field option:selected').val() +
                    "&carga_ponderacion_id=" + $('#carga_ponderacion_id-field option:selected').val() + "",
                dataType: 'json',
                beforeSend: function() {
                    $("#loading10").show();
                },
                complete: function() {
                    $("#loading10").hide();
                },
                success: function(data) {
                    //$example.select2("destroy");
                    $('#carga_ponderacion_id-field').empty();
                    $('#carga_ponderacion_id-field').append($('<option></option>').text('Seleccionar').val(
                        '0'));
                    $.each(data, function(i) {
                        //alert(data[i].name);
                        $('#carga_ponderacion_id-field').append("<option " + data[i].selectec +
                            " value=\"" + data[i].id + "\">" + data[i].name + "<\/option>");
                    });
                    //$example.select2();
                }
            });
        }
    </script>
@endpush
