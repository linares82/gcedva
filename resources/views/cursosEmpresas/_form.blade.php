                <div class="form-group col-md-4 @if($errors->has('name')) has-error @endif">
                       <label for="name-field">Curso</label>
                       {!! Form::text("name", null, array("class" => "form-control", "id" => "name-field")) !!}
                       @if($errors->has("name"))
                        <span class="help-block">{{ $errors->first("name") }}</span>
                       @endif
                    </div>
                    
                    <div class="form-group col-md-4 @if($errors->has('descuento_max')) has-error @endif">
                       <label for="descuento_max-field">Descuento Máximo</label>
                       {!! Form::text("descuento_max", null, array("class" => "form-control", "id" => "descuento_max-field")) !!}
                       @if($errors->has("descuento_max"))
                        <span class="help-block">{{ $errors->first("descuento_max") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('p_asesor')) has-error @endif">
                       <label for="p_asesor-field">% Asesor (0.00)</label>
                       {!! Form::text("p_asesor", null, array("class" => "form-control", "id" => "p_asesor-field")) !!}
                       @if($errors->has("p_asesor"))
                        <span class="help-block">{{ $errors->first("p_asesor") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('p_ventas')) has-error @endif">
                       <label for="p_ventas-field">% Ventas (0.00)</label>
                       {!! Form::text("p_ventas", null, array("class" => "form-control", "id" => "p_ventas-field")) !!}
                       @if($errors->has("p_ventas"))
                        <span class="help-block">{{ $errors->first("p_ventas") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('p_instructor')) has-error @endif">
                       <label for="p_instructor-field">% Instructor (0.00)</label>
                       {!! Form::text("p_instructor", null, array("class" => "form-control", "id" => "p_instructor-field")) !!}
                       @if($errors->has("p_instructor"))
                        <span class="help-block">{{ $errors->first("p_instructor") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('p_ganancia')) has-error @endif">
                       <label for="p_ganancia-field">% Ganancia(0.00)</label>
                       {!! Form::text("p_ganancia", null, array("class" => "form-control", "id" => "p_ganancia-field", 'readonly'=>'readonly')) !!}
                       @if($errors->has("p_ganancia"))
                        <span class="help-block">{{ $errors->first("p_ganancia") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('precio_persona')) has-error @endif">
                       <label for="precio_persona-field">Precio Persona (0.00)</label>
                       {!! Form::text("precio_persona", null, array("class" => "form-control", "id" => "precio_persona-field")) !!}
                       @if($errors->has("precio_persona"))
                        <span class="help-block">{{ $errors->first("precio_persona") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('precio_en_linea')) has-error @endif">
                       <label for="precio_en_linea-field">Precio Persona en Linea (0.00)</label>
                       {!! Form::text("precio_en_linea", null, array("class" => "form-control", "id" => "precio_en_linea-field")) !!}
                       @if($errors->has("precio_en_linea"))
                        <span class="help-block">{{ $errors->first("precio_en_linea") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('precio_demo')) has-error @endif">
                       <label for="precio_demo-field">Precio Demo (0.00)</label>
                       {!! Form::text("precio_demo", null, array("class" => "form-control", "id" => "precio_demo-field")) !!}
                       @if($errors->has("precio_demo"))
                        <span class="help-block">{{ $errors->first("precio_demo") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('duracion')) has-error @endif">
                       <label for="duracion-field">Duración(hrs.)</label>
                       {!! Form::text("duracion", null, array("class" => "form-control", "id" => "duracion-field")) !!}
                       @if($errors->has("duracion"))
                        <span class="help-block">{{ $errors->first("duracion") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-12 @if($errors->has('detalle')) has-error @endif">
                       <label for="detalle-field">Detalle</label>
                       {!! Form::textArea("detalle", null, array("class" => "form-control", "id" => "detalle-field")) !!}
                       @if($errors->has("detalle"))
                        <span class="help-block">{{ $errors->first("detalle") }}</span>
                       @endif
                    </div>
@push('scripts')
<!-- CK Editor -->
    <script src="https://cdn.ckeditor.com/4.4.3/standard/ckeditor.js"></script>
<script type="text/javascript">
    $(function () {
        // Replace the <textarea id="detalle-field"> with a CKEditor
        // instance, using default configuration.
        CKEDITOR.replace('detalle-field');
        //bootstrap WYSIHTML5 - text editor
        $(".textarea").wysihtml5();
      });
    $(document).ready(function() {
        $('#p_asesor-field').change(function(){
            calcularGanancia();
        });
        $('#p_ventas-field').change(function(){
            calcularGanancia();
        });
        $('#p_instructor-field').change(function(){
            calcularGanancia();
        });
    });
    function calcularGanancia(){
        
        $('#p_ganancia-field').val(1-(
                                  parseFloat($('#p_asesor-field').val())+
                                  parseFloat($('#p_ventas-field').val())+
                                  parseFloat($('#p_instructor-field').val())));
    }
    </script>
@endpush
