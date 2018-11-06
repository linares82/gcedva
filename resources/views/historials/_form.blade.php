                <div class="form-group col-md-4 @if($errors->has('historia_evento_id')) has-error @endif">
                       <label for="historia_evento_id-field">Evento</label>
                       {!! Form::select("historia_evento_id", $list["HistoriaEvento"], null, array("class" => "form-control select_seguridad", "id" => "historia_evento_id-field")) !!}
                       @if($errors->has("historia_evento_id"))
                        <span class="help-block">{{ $errors->first("historia_evento_id") }}</span>
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
                       {!! Form::hidden("empleado_id", $empleado, array("class" => "form-control", "id" => "empleado_id-field")) !!}
                       @if($errors->has("fecha"))
                        <span class="help-block">{{ $errors->first("fecha") }}</span>
                       @endif
                    </div>
                    
                    <div class="form-group col-md-4 @if($errors->has('archivo')) has-error @endif">
                       <label for="archivo-field">Archivo</label>
                       {!! Form::text("archivo", null, array("class" => "form-control input-sm", "id" => "archivo-field", 'readonly'=>'readonly')) !!}
                       {!! Form::file('archivo_file') !!}
                       @if (isset($historial1))
                       <img src="{!! asset('imagenes/planteles/'.$plantel->id.'/'.$plantel->logo) !!}" alt="Logo" height="100"> </img>
                       @endif
                       @if($errors->has("descripcion"))
                        <span class="help-block">{{ $errors->first("descripcion") }}</span>
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
    });
</script>
@endpush
