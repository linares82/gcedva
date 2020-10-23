                <div class="form-group col-md-4 @if($errors->has('evento_cliente_id')) has-error @endif">
                       <label for="evento_cliente_id-field">Evento</label>
                       {!! Form::select("evento_cliente_id", $list["EventoCliente"], null, array("class" => "form-control select_seguridad", "id" => "evento_cliente_id-field")) !!}
                       @if($errors->has("evento_cliente_id"))
                        <span class="help-block">{{ $errors->first("evento_cliente_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('descripcion')) has-error @endif">
                       <label for="descripcion-field">Descripcion</label>
                       {!! Form::text("descripcion", null, array("class" => "form-control", "id" => "descripcion-field")) !!}
                       @if($errors->has("descripcion"))
                        <span class="help-block">{{ $errors->first("descripcion") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('fecha')) has-error @endif">
                       <label for="fecha-field">Fecha</label>
                       {!! Form::text("fecha", null, array("class" => "form-control", "id" => "fecha-field")) !!}
                       {!! Form::hidden("cliente_id", $cliente, array("class" => "form-control", "id" => "cliente_id-field")) !!}
                       @if($errors->has("fecha"))
                        <span class="help-block">{{ $errors->first("fecha") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('fec_vigencia')) has-error @endif">
                       <label for="fec_vigencia-field">Fecha Vigencia</label>
                       {!! Form::text("fec_vigencia", null, array("class" => "form-control", "id" => "fec_vigencia-field")) !!}
                       @if($errors->has("fec_vigencia"))
                        <span class="help-block">{{ $errors->first("fec_vigencia") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('archivo')) has-error @endif">
                       <label for="archivo-field">Archivo</label>
                       {!! Form::text("archivo", null, array("class" => "form-control input-sm", "id" => "archivo-field", 'readonly'=>'readonly')) !!}
                       {!! Form::file('archivo_file') !!}
                       @if($errors->has("archivo"))
                        <span class="help-block">{{ $errors->first("archivo") }}</span>
                       @endif
                    </div>
                    <div class='row'></div>
                     <div class="form-group col-md-12 @if($errors->has('inscripcion_id')) has-error @endif">
                       <label for="inscripcion_id-field">Inscripcion</label>
                       {!! Form::select("inscripcion_id", $inscripcions, null, array("class" => "form-control select_seguridad", "id" => "inscripcion_id-field")) !!}
                       @if($errors->has("inscripcion_id"))
                        <span class="help-block">{{ $errors->first("inscripcion_id") }}</span>
                       @endif
                    </div>
                    
@push('scripts')
<script type="text/javascript">
    $(document).ready(function() {
    $('#fecha-field').Zebra_DatePicker({
                        days:['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'],
                                months:['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
                                readonly_element: false,
                                lang_clear_date: 'Limpiar',
                                show_select_today: 'Hoy',
    });
    $('#fec_vigencia-field').Zebra_DatePicker({
                        days:['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'],
                                months:['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
                                readonly_element: false,
                                lang_clear_date: 'Limpiar',
                                show_select_today: 'Hoy',
    });
    
    });
    @if (count($bajas_existentes) > 0)
    $('#evento_cliente_id-field option[value="2"]').prop('disabled',true);
    $('#evento_cliente_id-field').select2();
   @endif

    

</script>
@endpush

