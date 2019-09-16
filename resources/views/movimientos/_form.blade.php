                <div class="form-group col-md-4 @if($errors->has('plantel_id')) has-error @endif">
                       <label for="plantel_id-field">Plantel</label>
                       {!! Form::select("plantel_id", $list["Plantel"], null, array("class" => "form-control select_seguridad", "id" => "plantel_id-field")) !!}
                       @if($errors->has("plantel_id"))
                        <span class="help-block">{{ $errors->first("plantel_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('articulo_id')) has-error @endif">
                       <label for="articulo_id-field">Articulo</label>
                       {!! Form::select("articulo_id", $list["Articulo"], null, array("class" => "form-control select_seguridad", "id" => "articulo_id-field")) !!}
                       @if($errors->has("articulo_id"))
                        <span class="help-block">{{ $errors->first("articulo_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('cantidad')) has-error @endif">
                       <label for="cantidad-field">Cantidad</label>
                       {!! Form::text("cantidad", null, array("class" => "form-control", "id" => "cantidad-field")) !!}
                       @if($errors->has("cantidad"))
                        <span class="help-block">{{ $errors->first("cantidad") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('fecha')) has-error @endif">
                       <label for="fecha-field">Fecha</label>
                       {!! Form::text("fecha", null, array("class" => "form-control", "id" => "fecha-field")) !!}
                       @if($errors->has("fecha"))
                        <span class="help-block">{{ $errors->first("fecha") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('entrada_salida_id')) has-error @endif">
                       <label for="entrada_salida_id-field">Tipo</label>
                       {!! Form::select("entrada_salida_id", $list["EntradaSalida"], null, array("class" => "form-control select_seguridad", "id" => "entrada_salida_id-field")) !!}
                       @if($errors->has("entrada_salida_id"))
                        <span class="help-block">{{ $errors->first("entrada_salida_id") }}</span>
                       @endif
                    </div>
@push('scripts')
<script>
        $('#fecha-field').Zebra_DatePicker({
                        days:['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'],
                                months:['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
                                readonly_element: false,
                                lang_clear_date: 'Limpiar',
                                show_select_today: 'Hoy',
                        });
    </script>
@endpush
