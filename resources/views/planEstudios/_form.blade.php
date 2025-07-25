<div class="form-group @if ($errors->has('name')) has-error @endif">
    <label for="name-field">Plan Estudios</label>
    {!! Form::text('name', null, ['class' => 'form-control', 'id' => 'name-field']) !!}
    @if ($errors->has('name'))
        <span class="help-block">{{ $errors->first('name') }}</span>
    @endif
</div>
<div class="form-group col-md-4 @if ($errors->has('numero')) has-error @endif">
    <label for="numero-field">Numero Certificado</label>
    {!! Form::text('numero', null, ['class' => 'form-control', 'id' => 'numero-field']) !!}
    @if ($errors->has('numero'))
        <span class="help-block">{{ $errors->first('numero') }}</span>
    @endif
</div>
<div class="form-group col-md-4 @if ($errors->has('plantel_id')) has-error @endif">
    <label for="plantel_id-field">Plantel</label>
    {!! Form::select('plantel_id', $list['Plantel'], null, [
        'class' => 'form-control select_seguridad',
        'id' => 'plantel_id-field',
    ]) !!}

    @if ($errors->has('plantel_id'))
        <span class="help-block">{{ $errors->first('plantel_id') }}</span>
    @endif
</div>
<div class="form-group col-md-4 @if ($errors->has('total_materias_100')) has-error @endif">
    <label for="total_materias_100-field">Total Materias para el 100 %(Certificado)</label>
    {!! Form::text('total_materias_100', null, ['class' => 'form-control', 'id' => 'total_materias_100-field']) !!}
    @if ($errors->has('total_materias_100'))
        <span class="help-block">{{ $errors->first('total_materias_100') }}</span>
    @endif
</div>
<div class="form-group col-md-4 @if ($errors->has('clave_sep_cert')) has-error @endif">
    <label for="clave_sep_cert-field">Clave Plan Estudios (Certificado)</label>
    {!! Form::text('clave_sep_cert', null, ['class' => 'form-control', 'id' => 'clave_sep_cert-field']) !!}
    @if ($errors->has('clave_sep_cert'))
        <span class="help-block">{{ $errors->first('clave_sep_cert') }}</span>
    @endif
</div>
<div class="form-group col-md-4 @if ($errors->has('nombre_sep_cert')) has-error @endif">
    <label for="nombre_sep_cert-field">Nombre Plan Estudios(Certificado)</label>
    {!! Form::text('nombre_sep_cert', null, ['class' => 'form-control', 'id' => 'nombre_sep_cert-field']) !!}
    @if ($errors->has('nombre_sep_cert'))
        <span class="help-block">{{ $errors->first('nombre_sep_cert') }}</span>
    @endif
</div>
@if (isset($planEstudio))
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Definir Periodos de estudio</h3>
            </div>

            <div class="form-group col-md-6 @if ($errors->has('periodo_estudio_id')) has-error @endif" style="clear:left;">
                <label for="periodo_estudio_id-field">Periodos Estudio</label>
                {!! Form::select('periodo_estudio_id', [], null, [
                    'class' => 'form-control select_seguridad',
                    'id' => 'periodo_estudio_id-field',
                ]) !!}
                <div id="loading" style="visible:none;">Cargando...</div>
                @if ($errors->has('periodo_estudio_id'))
                    <span class="help-block">{{ $errors->first('periodo_estudio_id') }}</span>
                @endif
            </div>
        </div>
    </div>
@endif
@push('scripts')
    <script type="text/javascript">
        $(document).ready(function() {

            if ($('#plantel_id-field').val() != 0) {
                getPeriodosEstudio();
            }


            $('#plantel_id-field').change(function() {
                getPeriodosEstudio();
            });

        });


        function getPeriodosEstudio() {
            //var $example = $("#especialidad_id-field").select2();



            //console.log($id_seleccionados);
            $.ajax({
                url: '{{ route('periodoEstudios.periodosEstudioXPlantel') }}',
                type: 'GET',
                data: {
                    'plantel_id': $('#plantel_id-field option:selected').val(),
                },
                dataType: 'json',
                beforeSend: function() {
                    $("#loading").show();
                },
                complete: function() {
                    $("#loading").hide();
                },
                success: function(data) {
                    $('#periodo_estudio_id-field').empty();
                    $('#periodo_estudio-field').append($('<option></option>').text('Seleccionar').val('0'));
                    $.each(data, function(i) {
                        //alert(data[i].selectec);
                        $('#periodo_estudio_id-field').append("<option " + data[i].selectec +
                            " value=\"" + data[i].id + "\">" + data[i].name + "<\/option>");
                    });
                    $('#periodo_estudio_id-field').change();
                }
            });
        }
    </script>
@endpush
