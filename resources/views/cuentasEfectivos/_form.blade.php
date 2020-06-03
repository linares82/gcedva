                <div class="form-group col-md-4 @if($errors->has('name')) has-error @endif">
                       <label for="name-field">Nombre</label>
                       {!! Form::text("name", null, array("class" => "form-control", "id" => "name-field")) !!}
                       @if($errors->has("name"))
                        <span class="help-block">{{ $errors->first("name") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-12 {{ $errors->has('plantel_id') ? 'has-error' : '' }}">
                        <label for="plantel_id" class="control-label">Plantel</label>
                        <!--<div class="col-md-10">-->
                            <select class="form-control select_seguridad" id="tpo_deteccion_id" name="plantel_id[]" required="true" multiple="multiple">
                                    @foreach ($plantels as $key => $plantel)
                                        <option value="{{ $key }}" {{ old('plantel_id', optional($plantels_selected))->search($key)>-1 ? 'selected' : '' }}>
                                            {{ $plantel }}
                                        </option>
                                    @endforeach
                            </select>

                            {!! $errors->first('tpo_deteccion_id', '<p class="help-block">:message</p>') !!}
                        <!--</div>-->
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('clabe')) has-error @endif">
                       <label for="clabe-field">CLABE</label>
                       {!! Form::text("clabe", null, array("class" => "form-control", "id" => "clabe-field")) !!}
                       @if($errors->has("clabe"))
                        <span class="help-block">{{ $errors->first("clabe") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('no_cuenta')) has-error @endif">
                       <label for="no_cuenta-field">No. Cuenta</label>
                       {!! Form::text("no_cuenta", null, array("class" => "form-control", "id" => "no_cuenta-field")) !!}
                       @if($errors->has("no_cuenta"))
                        <span class="help-block">{{ $errors->first("no_cuenta") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('fecha_saldo_inicial')) has-error @endif">
                       <label for="fecha_saldo_inicial-field">Fecha Saldo Inicial</label>
                       {!! Form::text("fecha_saldo_inicial", null, array("class" => "form-control", "id" => "fecha_saldo_inicial-field")) !!}
                       @if($errors->has("fecha_saldo_inicial"))
                        <span class="help-block">{{ $errors->first("fecha_saldo_inicial") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('saldo_inicial')) has-error @endif">
                       <label for="saldo_inicial-field">Saldo Inicial</label>
                       {!! Form::number("saldo_inicial", null, array("class" => "form-control", "id" => "saldo_inicial-field")) !!}
                       @if($errors->has("saldo_inicial"))
                        <span class="help-block">{{ $errors->first("saldo_inicial") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('saldo_actualizado')) has-error @endif">
                       <label for="saldo_actualizado-field">Saldo Actualizado</label>
                       {!! Form::number("saldo_actualizado", null, array("class" => "form-control", "id" => "saldo_actualizado-field",'disabled'=>'disabled')) !!}
                       @if($errors->has("saldo_actualizado"))
                        <span class="help-block">{{ $errors->first("saldo_inicial") }}</span>
                       @endif
                    </div>

                    <div class="form-group col-md-4 @if($errors->has('bnd_banco')) has-error @endif">
                        <label for="bnd_banco-field">Cuenta Bancaria?</label>
                        {!! Form::checkbox("bnd_banco", 1, null, [ "id" => "bnd_banco-field", 'class'=>'minimal']) !!}
                        @if($errors->has("bnd_banco"))
                        <span class="help-block">{{ $errors->first("bnd_banco") }}</span>
                        @endif
                    </div>

                    <div class="form-group col-md-4 @if($errors->has('csc_efectivo')) has-error @endif">
                       <label for="csc_efectivo-field">Consecutivo para Cuenta de Efectivo</label>
                       {!! Form::number("csc_efectivo", null, array("class" => "form-control", "id" => "csc_efectivo-field")) !!}
                       @if($errors->has("csc_efectivo"))
                        <span class="help-block">{{ $errors->first("csc_efectivo") }}</span>
                       @endif
                    </div>

                    
                    <div class='row'></div>
                    <div id="comprobar_div" class="form-group col-md-4 @if($errors->has('comprobacion')) has-error @endif">
                     <label for="comprobacion-field">Saldo Comprobado</label>
                     {!! Form::text("comprobacion", null, array("class" => "form-control", "id" => "comprobacion-field")) !!}
                     <button type="button" id="btn_comprobar" class="btn btn-success btn-sm">Comprobar</button>
                     
                     </div>
@push('scripts')
  <script type="text/javascript">
    $(document).ready(function() {
    $('#fecha_saldo_inicial-field').Zebra_DatePicker({
        days:['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'],
        months:['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
        readonly_element: false,
        lang_clear_date: 'Limpiar',
        show_select_today: 'Hoy',
      });
    
    @if(isset($cuentasEfectivo))  
    $('#comprobar_div').on('click', '#btn_comprobar', function() {
        $.ajax({
            type: 'POST',
            url: '{{ route("cuentasEfectivos.comprobarSaldo")}}',
            data: {
                '_token': $('input[name=_token]').val(),
                'cuenta': {{ $cuentasEfectivo->id }},
            },
            beforeSend : function(){$("#loading3").show(); },
            complete : function(){$("#loading3").hide(); },
            success: function(data) {
                $('#comprobacion-field').val(data);
            },
        });
    });
    @endif

    $('#plantel_id-field')
    });
    


    </script>
@endpush                    