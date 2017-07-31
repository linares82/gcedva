                    <div class="form-group col-md-4 @if($errors->has('desc_corta')) has-error @endif">
                       <label for="desc_corta-field">Desc. Corta</label>
                       {!! Form::text("desc_corta", null, array("class" => "form-control", "id" => "desc_corta-field", 'rows'=>'3', 'maxlength'=>'255')) !!}
                       @if($errors->has("desc_corta"))
                        <span class="help-block">{{ $errors->first("desc_corta") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('aviso')) has-error @endif">
                       <label for="aviso-field">Aviso</label>
                       {!! Form::textArea("aviso", null, array("class" => "form-control", "id" => "aviso-field", 'rows'=>'3', 'maxlength'=>'255')) !!}
                       @if($errors->has("aviso"))
                        <span class="help-block">{{ $errors->first("aviso") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('inicio')) has-error @endif">
                       <label for="inicio-field">Inicio Vigencia</label>
                       {!! Form::text("inicio", null, array("class" => "form-control", "id" => "inicio-field")) !!}
                       @if($errors->has("inicio"))
                        <span class="help-block">{{ $errors->first("inicio") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('fin')) has-error @endif">
                       <label for="fin-field">Fin Vigencia</label>
                       {!! Form::text("fin", null, array("class" => "form-control", "id" => "fin-field")) !!}
                       @if($errors->has("fin"))
                        <span class="help-block">{{ $errors->first("fin") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('puesto_id')) has-error @endif">
                       <label for="puesto_id-field">Puesto</label>
                       {!! Form::select("puesto_id", $list["Puesto"], null, array("class" => "form-control", "id" => "puesto_id-field")) !!}
                       @if($errors->has("puesto_id"))
                        <span class="help-block">{{ $errors->first("puesto_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('plantel_id')) has-error @endif">
                       <label for="plantel_id-field">Plantel</label>
                       {!! Form::select("plantel_id", $list["Plantel"], null, array("class" => "form-control", "id" => "plantel_id-field")) !!}
                       @if($errors->has("plantel_id"))
                        <span class="help-block">{{ $errors->first("st_cliente_id") }}</span>
                       @endif
                    </div>
                    
@push('scripts')
  <script type="text/javascript">
    $(document).ready(function() {
    $('#inicio-field').Zebra_DatePicker({
        days:['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'],
        months:['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
        readonly_element: false,
        lang_clear_date: 'Limpiar',
        show_select_today: 'Hoy',
      });
      $('#fin-field').Zebra_DatePicker({
        days:['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'],
        months:['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
        readonly_element: false,
        lang_clear_date: 'Limpiar',
        show_select_today: 'Hoy',
      });
    });
    </script>
@endpush