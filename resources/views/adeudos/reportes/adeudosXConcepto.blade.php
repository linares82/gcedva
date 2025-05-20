@extends('plantillas.admin_template')

@include('seguimientos._common')

@section('header')
    <ol class="breadcrumb">
        <li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
        <li><a href="{{ route('seguimientos.index') }}">@yield('seguimientosAppTitle')</a></li>
        <li class="active">Adeudos por Concepto</li>
    </ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-plus"></i> Adeudos por concepto </h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">

            {!! Form::open(['route' => 'adeudos.adeudosXConceptoR', 'id' => 'frm']) !!}

            <div class="form-group col-md-6 @if ($errors->has('fecha_f')) has-error @endif">
                <label for="fecha_f-field">Año(formato 'aaaa'):</label>
                {!! Form::text('fecha_f', null, ['class' => 'form-control input-sm', 'id' => 'fecha_f-field']) !!}
                @if ($errors->has('fecha_f'))
                    <span class="help-block">{{ $errors->first('fecha_f') }}</span>
                @endif
            </div>
            <div class="form-group col-md-6 @if ($errors->has('agrupamiento_plantel_id')) has-error @endif">
                <label for="agrupamiento_plantel_id-field">Agrupamiento Planteles<i id="lbl_trabajando"></i></label>
                {!! Form::select('agrupamiento_plantel_id', $agrupamientoPlantels, null, [
                    'class' => 'form-control select_seguridad',
                    'id' => 'agrupamiento_plantel_id-field',
                ]) !!}
                @if ($errors->has('agrupamiento_plantel_id'))
                    <span class="help-block">{{ $errors->first('agrupamiento_plantel_id') }}</span>
                @endif
            </div>
            <!--
                    <div class="form-group col-md-6 @if ($errors->has('fecha_t')) has-error @endif">
                        <label for="fecha_t-field">Fecha a:</label>
                        {!! Form::text('fecha_t', null, ['class' => 'form-control input-sm', 'id' => 'fecha_t-field']) !!}
                        @if ($errors->has('fecha_t'))
    <span class="help-block">{{ $errors->first('fecha_t') }}</span>
    @endif
                    </div>
                -->
            <div class="form-group col-md-6 @if ($errors->has('plantel_f')) has-error @endif">
                <label for="plantel_f-field">Plantel de:*<input type="checkbox" id="seleccionar_planteles">Seleccionar
                    Todo</label>
                {!! Form::select('plantel_f[]', $planteles, null, [
                    'class' => 'form-control select_seguridad',
                    'id' => 'plantel_f-field',
                    'multiple' => true,
                ]) !!}
                @if ($errors->has('plantel_f'))
                    <span class="help-block">{{ $errors->first('plantel_f') }}</span>
                @endif
            </div>
            <!--
                    <div class="form-group col-md-6 @if ($errors->has('detalle_f')) has-error @endif">
                        <label for="detalle_f-field">Con detalle:</label>
                        @{!! Form::select('detalle_f', ['3' => 'Adeudos'], null, [
                            'class' => 'form-control select_seguridad',
                            'id' => 'detalle_f-field',
                        ]) !!}
                        @if ($errors->has('detalle_f'))
    <span class="help-block">{{ $errors->first('detalle_f') }}</span>
    @endif
                    </div>
                -->
            <div class="form-group col-md-6 @if ($errors->has('concepto_f')) has-error @endif">
                <label for="concepto_f-field">Concepto
                    de:<!--*<input type="checkbox" id="seleccionar_conceptos">Seleccionar Todo--></label>
                {!! Form::select('concepto_f', $conceptos, null, [
                    'class' => 'form-control select_seguridad',
                    'id' => 'concepto_f-field',
                ]) !!}
                @if ($errors->has('concepto_f'))
                    <span class="help-block">{{ $errors->first('concepto_f') }}</span>
                @endif
            </div>

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
            $("#agrupamiento_plantel_id-field").change(function(event) {
                cambioAgrupamiento();
            });

            function cambioAgrupamiento() {
                $.ajax({
                    url: '{{ route('plantels.PlantelXAgrupamiento') }}',
                    type: 'GET',
                    data: {
                        'plantel_agrupamiento_id': $("#agrupamiento_plantel_id-field option:selected")
                        .val(),
                    },
                    dataType: 'json',
                    beforeSend: function() {
                        $('#lbl_trabajando').html('...');
                        $("#fact_usuario").text('Procesando');

                    },
                    complete: function(datos) {
                        $('#lbl_trabajando').html('');
                        $("#plantel_f-field").val(datos.responseJSON).change();

                    },
                    success: function(data) {

                    }
                });
            }

            $('#seleccionar_conceptos').change(function() {
                if ($(this).is(':checked')) {
                    $("#concepto_f-field > option").prop("selected", "selected");
                    $("#concepto_f-field").trigger("change");
                } else {
                    $("#concepto_f-field > option").prop("selected", "selected");
                    $('#concepto_f-field').val(null).trigger('change');
                }
            });

            $('#seleccionar_planteles').change(function() {
                if ($(this).is(':checked')) {
                    $("#plantel_f-field > option").prop("selected", "selected");
                    $("#plantel_f-field").trigger("change");
                } else {
                    $("#plantel_f-field > option").prop("selected", "selected");
                    $('#plantel_f-field').val(null).trigger('change');
                }
            });

            $('#concepto_f-field').select2();



            $('#fecha_-field').Zebra_DatePicker({
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
    </script>
@endpush
