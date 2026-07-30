                <div class="form-group col-md-4 @if($errors->has('seccion_id')) has-error @endif">
                       <label for="seccion_id-field">Seccion</label>
                       {!! Form::select("seccion_id", $list["Seccion"], null, array("class" => "form-control select_seguridad", "id" => "seccion_id-field")) !!}
                       @if($errors->has("seccion_id"))
                        <span class="help-block">{{ $errors->first("seccion_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('descripcion')) has-error @endif">
                       <label for="descripcion-field">Descripcion</label>
                       {!! Form::text("descripcion", null, array("class" => "form-control", "id" => "descripcion-field")) !!}
                       @if($errors->has("descripcion"))
                        <span class="help-block">{{ $errors->first("descripcion") }}</span>
                       @endif
                    </div>
                    <!--<div class="form-group col-md-4 @if($errors->has('archivo')) has-error @endif">
                       <label for="archivo-field">Archivo</label>
                       {!! Form::text("archivo", null, array("class" => "form-control", "id" => "archivo-field")) !!}
                       @if($errors->has("archivo"))
                        <span class="help-block">{{ $errors->first("archivo") }}</span>
                       @endif
                    </div>
                  -->
                    <div class="form-group col-md-4 @if($errors->has('fecha_disponibilidad')) has-error @endif">
                       <label for="fecha_disponibilidad-field">Fecha Disponibilidad</label>
                       {!! Form::text("fecha_disponibilidad", null, array("class" => "form-control fecha", "id" => "fecha_disponibilidad-field")) !!}
                       @if($errors->has("fecha_disponibilidad"))
                        <span class="help-block">{{ $errors->first("fecha_disponibilidad") }}</span>
                       @endif
                    </div>
                    @if(isset($material))
                    <div class="well well-sm">
                    <div class="btn btn-xs btn-file">
                           <i class="fa fa-paperclip"></i> Seleccionar Archivo
                           <input type="file"  id="archivo_space"
                           accept=".pdf"
                           name="archivo_space">
                           <input type="hidden" name="_token" id="_token"  value="<?= csrf_token(); ?>">
                           <input type="hidden"  id="archivo_hidden" name="archivo_hidden" >
                     </div>
                     <button class="btn btn-success btn-xs btn_archivo_space" id="btn_archivo"
                        data-material='{{ $material->id }}'> 
                        <span class="glyphicon glyphicon-ok">Gardar</span> 
                     </button>
                     <br/>
                     <div id="texto_notificacion">
                     </div>
                     @if(!is_null($material->archivo))
                     <a href="{{ $material->archivoUrl }}" target="_blank">Ver</a>
                     @endif
                     </div>
                     
                     @endif
                     <div class="row"></div>


@push('scripts')
<script type="text/javascript">
$(document).on("click", ".btn_archivo_space", function (e) {
    e.preventDefault();
    
    var miurl = "{{route('materials.cargarImgSpace')}}";
    // var fileup=$("#file").val();
    var divresul = "texto_notificacion";

    var data = new FormData();
    data.append('file', $('#archivo_space')[0].files[0]);
    data.append('material_id', $(this).data('material'));
    
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('#_token').val()
        }
    });
    $.ajax({
        url: miurl,
        type: 'POST',
        // Form data
        //datos del formulario
        data: data,
        //dataType: "json",
        //necesario para subir archivos via ajax
        cache: false,
        contentType: false,
        processData: false,
        //mientras enviamos el archivo
        beforeSend: function () {
            $("#" + divresul + "").html('guardando...');
        },
        complete: function () {
            $("#" + divresul + "").html('ok');
        },
        //una vez finalizado correctamente
        success: function (data) {
            
                location.reload();
            
        },
        //si ha ocurrido un error
        error: function (data) {

        }
    });
})
</script>

@endpush