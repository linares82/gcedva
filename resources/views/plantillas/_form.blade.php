
                    <div class="form-group col-md-6 @if($errors->has('nombre')) has-error @endif">
                       <label for="nombre-field">Nombre</label>
                       {!! Form::text("nombre", null, array("class" => "form-control", "id" => "nombre-field")) !!}
                       @if($errors->has("nombre"))
                        <span class="help-block">{{ $errors->first("nombre") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-6 @if($errors->has('asunto')) has-error @endif">
                       <label for="asunto-field">Asunto</label>
                       {!! Form::text("asunto", null, array("class" => "form-control", "id" => "asunto-field")) !!}
                       @if($errors->has("asunto"))
                        <span class="help-block">{{ $errors->first("asunto") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-6 @if($errors->has('para_nombre')) has-error @endif">
                       <label for="para_nombre-field">Para(Leyenda en lugar del nombre)</label>
                       {!! Form::text("para_nombre", null, array("class" => "form-control", "id" => "para_nombre-field")) !!}
                       @if($errors->has("para_nombre"))
                        <span class="help-block">{{ $errors->first("para_nombre") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-6 @if($errors->has('tpo_correo_id')) has-error @endif">
                       <label for="tpo_correo_id-field">Tipo Correo</label>
                       {!! Form::select("tpo_correo_id", $list["TpoCorreo"], null, array("class" => "form-control", "id" => "tpo_correo_id-field")) !!}
                       @if($errors->has("tpo_correo_id"))
                        <span class="help-block">{{ $errors->first("tpo_correo_id") }}</span>
                       @endif
                    </div>
                    
                      <div id="estatus_div">
                          <div class="form-group col-md-4 @if($errors->has('st_cliente_id')) has-error @endif" style="clear:left;">
                             <label for="st_cliente_id-field">Estatus</label>
                             {!! Form::select("st_cliente", $list["StCliente"], null, array("class" => "form-control", "id" => "st_cliente-field")) !!}
                             @if($errors->has("st_cliente_id"))
                              <span class="help-block">{{ $errors->first("st_cliente_id") }}</span>
                             @endif
                          </div>
                        @if(isset($plantilla))  
                          <div class="row">
                            <div class="col-md-12">
                              <table class="table table-condensed table-striped">
                                <thead>
                                  <th>Estatus</th><th>Borrar</th>
                                </thead>
                                <tbody>
                                    @foreach($plantilla->estatus as $st)
                                      <tr>
                                        <td>{!! $st->name !!}</td>
                                        <td> <a href="{!! route('plantillas.eliminarEstatus', array('plantilla'=>$plantilla->id,'st'=>$st->id)) !!}" class="btn btn-xs btn-danger">Eliminar</a>
                                        </td>
                                      </tr>
                                    @endforeach
                                  
                                </tbody>

                              </table>
                            </div>  

                          </div>
                        @endif
                      </div>
                    
                    <!--
                    <div class="form-group col-md-4 @if($errors->has('periodo_id')) has-error @endif">
                       <label for="periodo_id-field">Periodo:Mensual</label>
                       {!! Form::select("periodo_id", $list["Periodo"], null, array("class" => "form-control", "id" => "periodo_id-field")) !!}
                       @if($errors->has("periodo_id"))
                        <span class="help-block">{{ $errors->first("periodo_id") }}</span>
                       @endif
                    </div>
                    -->
                    <div id="dia_div">
                      <div class="form-group col-md-4 @if($errors->has('dia')) has-error @endif" style="clear:left;">
                         <label for="dia-field">Dia (número entre 1 y 28)</label>
                         {!! Form::text("dia", null, array("class" => "form-control", "id" => "dia-field")) !!}
                         @if($errors->has("dia"))
                          <span class="help-block">{{ $errors->first("dia") }}</span>
                         @endif
                      </div>
                    </div>

                    <div id="nivel_div">
                      <div class="form-group col-md-4 @if($errors->has('nivel_id')) has-error @endif" style="">
                         <label for="nivel_id-field">Nivel</label>
                         {!! Form::select("nivel_id", $list["Nivel"], null, array("class" => "form-control", "id" => "nivel_id-field")) !!}
                         @if($errors->has("nivel_id"))
                          <span class="help-block">{{ $errors->first("nivel_id") }}</span>
                         @endif
                      </div>
                    </div>

                    <div id="inicio_div">
                      <div class="form-group col-md-4 @if($errors->has('inicio')) has-error @endif" style="clear:left;">
                         <label for="inicio-field">Inicio</label>
                         {!! Form::text("inicio", null, array("class" => "form-control", "id" => "inicio-field")) !!}
                         @if($errors->has("inicio"))
                          <span class="help-block">{{ $errors->first("inicio") }}</span>
                         @endif
                      </div>
                    </div>

                    <div id="fin_div">
                      <div class="form-group col-md-4 @if($errors->has('fin')) has-error @endif">
                         <label for="fin-field">Fin</label>
                         {!! Form::text("fin", null, array("class" => "form-control", "id" => "fin-field")) !!}
                         @if($errors->has("fin"))
                          <span class="help-block">{{ $errors->first("fin") }}</span>
                         @endif
                      </div>
                    </div>

                    <div class="form-group col-md-12 @if($errors->has('dia')) has-error @endif">
                       <button type="button" onclick="BrowseServer('id_of_the_target_input');">Elegir imagen</button>
                        <input type="text" id="id_of_the_target_input"/>
                        <label for="id_of_the_target_input">
                        {!! e('
                              <img src="{ { $message-&gt;embed(\'http://localhost/crmscool/public/filemanager/userfiles/DSCN1838.JPG\') } }" />
                        ') !!}
                        </label>
                        
                    </div>
                    
                    <div class="form-group col-md-12 @if($errors->has('plantilla')) has-error @endif">
                       <label for="plantilla-field">Plantilla</label>
                       {!! Form::textArea("plantilla", null, array("class" => "form-control mceEditor", "id" => "plantilla-field", 'rows'=>'8')) !!}
                       @if($errors->has("plantilla"))
                        <span class="help-block">{{ $errors->first("plantilla") }}</span>
                       @endif
                    </div>
                    


                    
@push('scripts')
  
  <script src="{{ asset ('/bower_components/AdminLTE/plugins/tinymce/js/tinymce/tinymce.min.js') }}"></script>
  <script src="{{ asset ('/bower_components/AdminLTE/plugins/tinymce/js/tinymce/tinymce_editor.js') }}"></script>
  
  <script>
  
  tinymce.init({ 
    //mode : "specific_textareas",
    language : "es",
    //location : "{{ asset ('/filemanager/userfiles') }}",
    //  file_browser_callback_types: 'file image media',
    //editor_selector : "mceEditor",
    selector: 'textarea#plantilla-field',
    theme: 'modern',
    plugins: [
      //'autolink lists  charmap print hr anchor',
      //'code',
      'insertdatetime table contextmenu link image imagetools code',
      //'emoticons paste textcolor colorpicker textpattern'
    ],
    toolbar1: 'undo redo | insert | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
    toolbar2: 'print preview media | forecolor backcolor emoticons | codesample',
    image_advtab: false,
    templates: [
      { title: 'Test template 1', content: 'Test 1' },
      { title: 'Test template 2', content: 'Test 2' }
    ],
    content_css: [
      '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
      '//www.tinymce.com/css/codepen.min.css'
    ]
  });
  
  </script>
  


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

      //ocultar campos
      $('#estatus_div').hide();
      $('#dia_div').hide();
      $('#nivel_div').hide();
      $('#inicio_div').hide();
      $('#fin_div').hide();

      ocultaMuestra();

      $('#tpo_correo_id-field').change(function(){
        ocultaMuestra();
      });

      function ocultaMuestra(){
      if($('#tpo_correo_id-field option:selected').val()==1){
          $('#estatus_div').hide();
          $('#dia_div').hide();
          $('#nivel_div').hide();
          $('#inicio_div').hide();
          $('#fin_div').hide();
       }else if($('#tpo_correo_id-field option:selected').val()==2){
          $('#estatus_div').hide();
          $('#dia_div').show();
          $('#nivel_div').show();
          $('#inicio_div').hide();
          $('#fin_div').hide();
       }else if($('#tpo_correo_id-field option:selected').val()==3){
          $('#estatus_div').show();
          $('#dia_div').hide();
          $('#nivel_div').hide();
          $('#inicio_div').show();
          $('#fin_div').show();
       }else if($('#tpo_correo_id-field option:selected').val()==4){
          $('#estatus_div').show();
          $('#dia_div').show();
          $('#nivel_div').hide();
          $('#inicio_div').hide();
          $('#fin_div').hide();
       }
     }

    });
      // File Picker modification for FCK Editor v2.0 - www.fckeditor.net
     // by: Pete Forde <pete@unspace.ca> @ Unspace Interactive
     var urlobj;

     function BrowseServer(obj)
     {
          urlobj = obj;
          OpenServerBrowser(
          "{{ url('filemanager/show') }}",
          screen.width * 0.7,
          screen.height * 0.7 ) ;
     }

     function OpenServerBrowser( url, width, height )
     {
          var iLeft = (screen.width - width) / 2 ;
          var iTop = (screen.height - height) / 2 ;
          var sOptions = "toolbar=no,status=no,resizable=yes,dependent=yes" ;
          sOptions += ",width=" + width ;
          sOptions += ",height=" + height ;
          sOptions += ",left=" + iLeft ;
          sOptions += ",top=" + iTop ;
          var oWindow = window.open( url, "BrowseWindow", sOptions ) ;
     }

     function SetUrl( url, width, height, alt )
     {
          document.getElementById(urlobj).value = url ;
          oWindow = null;
     }

     
     </script>


  
@endpush