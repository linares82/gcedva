@extends('plantillas.admin_template')

@include('seguimientos._common')

@section('header')
    <ol class="breadcrumb">
        <li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
        <li><a href="{{ route('seguimientos.index') }}">@yield('seguimientosAppTitle')</a></li>
        <li class="active">Reporte de Incidencias</li>
    </ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-plus"></i> @yield('seguimientosAppTitle') / Incidencias </h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">

            {!! Form::open(['route' => 'incidenciasCalificacions.incidenciasR']) !!}

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
            <div class="form-group col-md-6 @if ($errors->has('tpo_examen')) has-error @endif">
                <label for="plantel_f-field">Tipo de Examen:</label>
                {!! Form::select('tpo_examen', $tpoExamens, null, [
                    'class' => 'form-control select_seguridad',
                    'id' => 'tpo_examen-field',
                ]) !!}
                @if ($errors->has('plantel_f'))
                    <span class="help-block">{{ $errors->first('tpo_examen') }}</span>
                @endif
            </div>
            <div class="form-group col-md-6 @if ($errors->has('lectivo_f')) has-error @endif">
                <label for="lectivo_f-field">Lectivo de:</label>
                {!! Form::select('lectivo_f', $list['Lectivo'], null, [
                    'class' => 'form-control select_seguridad',
                    'id' => 'lectivo_f-field',
                ]) !!}
                @if ($errors->has('lectivo_f'))
                    <span class="help-block">{{ $errors->first('lectivo_f') }}</span>
                @endif
            </div>

            <div class="form-group col-md-6 @if ($errors->has('ponderacion_id')) has-error @endif">
                <label for="ponderacion_id-field">Ponderacion</label>
                {!! Form::select('ponderacion_id', $list['Ponderacion'], null, [
                    'class' => 'form-control select_seguridad',
                    'id' => 'ponderacion_id-field',
                ]) !!}
                @if ($errors->has('ponderacion_id'))
                    <span class="help-block">{{ $errors->first('ponderacion_id') }}</span>
                @endif
            </div>
            <div class="form-group col-md-6 @if ($errors->has('carga_ponderacion_id')) has-error @endif">
                <label for="carga_ponderacion_id-field">Carga Ponderacion</label>
                {!! Form::select('carga_ponderacion_id', $list['CargaPonderacion'], null, [
                    'class' => 'form-control select_seguridad',
                    'id' => 'carga_ponderacion_id-field',
                ]) !!}
                <div id='loading10' style='display: none'><img src="{{ asset('images/ajax-loader.gif') }}"
                        title="Enviando" /></div>
                @if ($errors->has('carga_ponderacion_id'))
                    <span class="help-block">{{ $errors->first('carga_ponderacion_id') }}</span>
                @endif
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
