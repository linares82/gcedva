                <div class="form-group col-md-4 @if($errors->has('no_coti')) has-error @endif">
                       <label for="no_coti-field">No</label>
                       
                    </div>
                    
                    <div class="form-group col-md-4 @if($errors->has('fecha')) has-error @endif">
                       <label for="fecha-field">Fecha</label>
                       {!! Form::text("fecha", null, array("class" => "form-control", "id" => "fecha-field")) !!}
                       @if($errors->has("fecha"))
                        <span class="help-block">{{ $errors->first("fecha") }}</span>
                       @endif
                    </div>

                    <div class="form-group col-md-4 @if($errors->has('empresa_id')) has-error @endif">
                       <label for="empresa_id-field">Empresa:{{$empresa->razon_social}}</label><br/>
                       <label for="empresa_id-field">Contacto:{{$empresa->nombre_contacto}}</label><br/>
                       <label for="empresa_id-field">Tel. Fijo:{{$empresa->tel_fijo}}</label><br/>
                       <label for="empresa_id-field">Tel. Celular:{{$empresa->tel_cel}}</label><br/>
                       <label for="empresa_id-field">Email:{{$empresa->correo1}}</label><br/>
                       <label for="empresa_id-field">Dirección:Calle {{$empresa->calle." ".$empresa->no_ex}}, No. Int. {{$empresa->no_int}}, 
                                                     Colonia {{$empresa->colonia}}, Municipio {{$empresa->municipio->name}}, Estado {{$empresa->estado->name}},
                                                     CP {{$empresa->cp}}</label>
                       {!! Form::hidden("empresa_id", $empresa->id, array("class" => "form-control", "id" => "empresa_id-field")) !!}
                    </div>

                    <div class="form-group col-md-12 @if($errors->has('observaciones')) has-error @endif">
                       <label for="observaciones-field">Observaciones</label>
                       {!! Form::textArea("observaciones", null, array("class" => "form-control", "id" => "observaciones-field")) !!}
                       @if($errors->has("observaciones"))
                        <span class="help-block">{{ $errors->first("observaciones") }}</span>
                       @endif
                    </div>
@push('scripts')
<script src="https://cdn.ckeditor.com/4.4.3/standard/ckeditor.js"></script>                    
  <script type="text/javascript">
    $(function () {
        // Replace the <textarea id="observaciones-field"> with a CKEditor
        // instance, using default configuration.
        CKEDITOR.replace('observaciones-field');
        //bootstrap WYSIHTML5 - text editor
        $(".textarea").wysihtml5();
      });
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

