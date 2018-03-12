            <input type="hidden" name="_token" id="_token"  value="<?= csrf_token(); ?>"> 
            <div class="box box-default box-solid">
                    <div class="box-header">
                        <h3 class="box-title">IDENTIFICACIÓN</h3>
                        <div class="box-tools">
                            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="form-group col-md-4 @if($errors->has('activo_bnd')) has-error @endif">
                           <label for="activo_bnd-field">Activo</label>
                           {!! Form::checkbox("activo_bnd", 1, null, [ "id" => "activo_bnd-field"]) !!}
                           @if($errors->has("activo_bnd"))
                            <span class="help-block">{{ $errors->first("activo_bnd") }}</span>
                           @endif
                        </div>
                        <div class="form-group col-md-8 @if($errors->has('nombre')) has-error @endif">
                           <label for="nombre-field">Nombre</label>
                           {!! Form::text("nombre", null, array("class" => "form-control input-sm", "id" => "nombre-field")) !!}
                           @if($errors->has("nombre"))
                            <span class="help-block">{{ $errors->first("nombre") }}</span>
                           @endif
                        </div>
                        <div class="form-group col-md-6 @if($errors->has('tpo_correo_id')) has-error @endif">
                            <label for="tpo_correo_id-field">Tipo Correo</label>
                            {!! Form::select("tpo_correo_id", $list["TpoCorreo"], null, array("class" => "form-control select_seguridad", "id" => "tpo_correo_id-field")) !!}
                            @if($errors->has("tpo_correo_id"))
                             <span class="help-block">{{ $errors->first("tpo_correo_id") }}</span>
                            @endif
                         </div>
                        </div>
                    </div>
                    <div class="box box-default box-solid">
                    <div class="box-header">
                        <h3 class="box-title">DESTINATARIOS</h3>
                        <div class="box-tools">
                            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="form-group col-md-3 @if($errors->has('plan_campo_filtro_id')) has-error @endif">
                            <label for="plan_campo_filtro_id-field">Campo</label>
                            {!! Form::select("plan_campo_filtro_id", $list1["PlanCampoFiltro"], null, array("class" => "form-control select_seguridad", "id" => "plan_campo_filtro_id-field")) !!}
                            @if($errors->has("plan_campo_filtro_id"))
                             <span class="help-block">{{ $errors->first("plan_campo_filtro_id") }}</span>
                            @endif
                         </div>
                        <div class="form-group col-md-3 @if($errors->has('signo_comparacion_filtro')) has-error @endif">
                            <label for="signo_comparacion_filtro-field">Signo de comparacion</label>
                            {!! Form::select("signo_comparacion_filtro", array('Seleccionar Opción','>=','>', '=', 'like', '<>', '<', '<='), null, array("class" => "form-control select_seguridad", "id" => "signo_comparacion_filtro-field")) !!}
                            @if($errors->has("signo_comparacion_filtro"))
                             <span class="help-block">{{ $errors->first("signo_comparacion_filtro") }}</span>
                            @endif
                         </div>
                        <div class="form-group col-md-3 @if($errors->has('valor_condicion')) has-error @endif" id="div_valor">
                            <label for="valor_condicion-field">Valor condicion</label>
                            {!! Form::text("valor_condicion", null, array("class" => "form-control input-sm", "id" => "valor_condicion-field")) !!}
                            @if($errors->has("valor_condicion"))
                             <span class="help-block">{{ $errors->first("valor_condicion") }}</span>
                            @endif
                         </div>
                        <div class="form-group col-md-3 @if($errors->has('valor_condicion')) has-error @endif" id="div_especialidad"></div>
                        <div class="form-group col-md-3 @if($errors->has('valor_condicion')) has-error @endif" style="clear:left;" id="div_nivel"></div>
                        <div class="form-group col-md-3 @if($errors->has('valor_condicion')) has-error @endif" id="div_grado"></div>
                        <div class="form-group col-md-3 @if($errors->has('valor_condicion')) has-error @endif" id="div_comprobar">
                            <div id='loading10' style='display: none'><img src="{{ asset('images/ajax-loader.gif') }}" title="Enviando" /></div> 
                        </div>
                        <div class="form-group col-md-3 @if($errors->has('valor_condicion')) has-error @endif" >
                            <input type="button" class="btn btn-xs btn-block btn-success" value="Agregar" onclick="AgregarCondicion()" />
                            <input type="button" class="btn btn-xs btn-block btn-info" value="Comprobar" onclick="ComprobarCantidad()" />
                        </div>
                        <div class="form-group col-md-12">
                            <table class="table table-condensed table-striped">
                                <thead>
                                <th>Campo</th><th>Signo</th><th>Valor</th><th></th><th></th>
                                </thead>
                                <tbody>
                                    @foreach($plantilla->condiciones as $c)
                                    <tr>
                                        <td>{{$c->campo->campo}}</td>
                                        <td>{{$c->signo_comparacion}}</td>
                                        <td>{{$c->interpretacion}}</td>
                                        <td>
                                            <a class="btn btn-xs btn-danger" href="{{ route('planCondicionFiltros.destroy', $c->id) }}"><i class="glyphicon glyphicon-trash"></i>Borrar</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!--
                        <div id="estatus_div">
                            <div class="form-group col-md-4 @if($errors->has('st_cliente_id')) has-error @endif" style="clear:left;">
                               <label for="st_cliente_id-field">Estatus</label>
                               {!! Form::select("st_cliente", $list["StCliente"], null, array("class" => "form-control select_seguridad", "id" => "st_cliente-field")) !!}
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
                        <div id="nivel_div">
                        <div class="form-group col-md-4 @if($errors->has('plantel_id')) has-error @endif" style="clear:left;">
                               <label for="plantel_id-field">Plantel</label>
                               {!! Form::select("plantel_id", $list["Plantel"], null, array("class" => "form-control select_seguridad", "id" => "plantel_id-field")) !!}
                               @if($errors->has("plantel_id"))
                                <span class="help-block">{{ $errors->first("plantel_id") }}</span>
                               @endif
                            </div>
                        <div class="form-group col-md-4 @if($errors->has('especialidad_id')) has-error @endif">
                               <label for="especialidad_id-field">Especialidad</label>
                               {!! Form::select("especialidad_id", $list["Especialidad"], null, array("class" => "form-control select_seguridad", "id" => "especialidad_id-field")) !!}
                               <div id='loading10' style='display: none'><img src="{{ asset('images/ajax-loader.gif') }}" title="Enviando" /></div> 
                               @if($errors->has("especialidad_id"))
                                <span class="help-block">{{ $errors->first("especialidad_id") }}</span>
                               @endif
                            </div>
                        <div class="form-group col-md-4 @if($errors->has('nivel_id')) has-error @endif" style="">
                           <label for="nivel_id-field">Nivel</label>
                           {!! Form::select("nivel_id", $list["Nivel"], null, array("class" => "form-control select_seguridad", "id" => "nivel_id-field")) !!}
                           <div id='loading11' style='display: none'><img src="{{ asset('images/ajax-loader.gif') }}" title="Enviando" /></div> 
                           @if($errors->has("nivel_id"))
                            <span class="help-block">{{ $errors->first("nivel_id") }}</span>
                           @endif
                        </div>
                      </div>
                        -->
                        </div>
                    </div>
                    <div class="box box-default box-solid">
                    <div class="box-header">
                        <h3 class="box-title">TEMPORALIDAD</h3>
                        <div class="box-tools">
                            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        <!--<div id="dia_div">-->
                            <div class="form-group col-md-4 @if($errors->has('dia')) has-error @endif" style="clear:left;">
                               <label for="dia-field">Dia (número entre 1 y 28)</label>
                               {!! Form::text("dia", null, array("class" => "form-control input-sm", "id" => "dia-field")) !!}
                               @if($errors->has("dia"))
                                <span class="help-block">{{ $errors->first("dia") }}</span>
                               @endif
                            </div>
                          <!--</div>-->
                        <!--<div id="inicio_div">-->
                            <div class="form-group col-md-4 @if($errors->has('inicio')) has-error @endif">
                               <label for="inicio-field">Inicio</label>
                               {!! Form::text("inicio", null, array("class" => "form-control input-sm", "id" => "inicio-field")) !!}
                               @if($errors->has("inicio"))
                                <span class="help-block">{{ $errors->first("inicio") }}</span>
                               @endif
                            </div>
                          <!--</div>-->

                          <!--<div id="fin_div">-->
                            <div class="form-group col-md-4 @if($errors->has('fin')) has-error @endif">
                               <label for="fin-field">Fin</label>
                               {!! Form::text("fin", null, array("class" => "form-control input-sm", "id" => "fin-field")) !!}
                               @if($errors->has("fin"))
                                <span class="help-block">{{ $errors->first("fin") }}</span>
                               @endif
                            </div>
                          </div>

                        <!--</div>-->
                    </div>
                    <div class="box box-default box-solid">
                    <div class="box-header">
                        <h3 class="box-title">CORREO</h3>
                        <div class="box-tools">
                            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="form-group col-md-2 @if($errors->has('mail_bnd')) has-error @endif">
                            <label for="mail_bnd-field">Mail</label>
                            {!! Form::checkbox("mail_bnd", 1, null, [ "id" => "mail_bnd-field"]) !!}
                            @if($errors->has("mail_bnd"))
                             <span class="help-block">{{ $errors->first("mail_bnd") }}</span>
                            @endif
                         </div>
                        <div class="form-group col-md-10 @if($errors->has('asunto')) has-error @endif">
                            <label for="asunto-field">Asunto</label>
                            {!! Form::text("asunto", null, array("class" => "form-control input-sm", "id" => "asunto-field")) !!}
                            @if($errors->has("asunto"))
                             <span class="help-block">{{ $errors->first("asunto") }}</span>
                            @endif
                         </div>
                        
                        <div class="form-group col-md-12 @if($errors->has('plantilla')) has-error @endif">
                            <label for="plantilla-field">Plantilla</label>
                            {!! Form::textArea("plantilla", null, array("class" => "form-control mceEditor", "id" => "plantilla-field", 'rows'=>'8')) !!}
                            @if($errors->has("plantilla"))
                             <span class="help-block">{{ $errors->first("plantilla") }}</span>
                            @endif
                         </div>
                        <!--<div class="form-group col-md-12 @if($errors->has('dia')) has-error @endif">
                            <button type="button" onclick="BrowseServer('id_of_the_target_input');">Elegir imagen</button>
                             <input type="text" id="id_of_the_target_input"/>
                         </div>
                        -->
                         <div class="form-group">
                             <div class="btn btn-default btn-file">
                                 <i class="fa fa-paperclip"></i> Adjuntar Archivo
                                 <input type="file"  id="file" name="file" class="email_archivo" >
                                 {!! Form::text("img1", null, array("class" => "form-control input-sm", "id" => "img1-field")) !!}
                             </div>
                             <p class="help-block"  >Max. 20MB</p>
                             <div id="texto_notificacion">

                             </div>
                         </div>
                        <!-- cargador empresa -->
                        <div style="display: none;" id="cargador_empresa" align="center">
                           <br>
                           <label style="color:#FFF; background-color:#ABB6BA; text-align:center">&nbsp;&nbsp;&nbsp;Espere... &nbsp;&nbsp;&nbsp;</label>

                           <img src="{{asset('images/ajax-loader.gif')}}" align="middle" alt="cargador"> &nbsp;<label style="color:#ABB6BA">Realizando envio de correo ...</label>

                           <br>
                           <hr style="color:#003" width="50%">
                           <br>
                        </div>
                        
                        </div>
                    </div>
                    <div class="box box-default box-solid">
                    <div class="box-header">
                        <h3 class="box-title">SMS</h3>
                        <div class="box-tools">
                            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="form-group col-md-4 @if($errors->has('sms_bnd')) has-error @endif">
                            <label for="sms_bnd-field">Sms</label>
                            {!! Form::checkbox("sms_bnd", 1, null, [ "id" => "sms_bnd-field"]) !!}
                            @if($errors->has("sms_bnd"))
                             <span class="help-block">{{ $errors->first("sms_bnd") }}</span>
                            @endif
                         </div>
                         <div class="form-group col-md-12 @if($errors->has('sms')) has-error @endif">
                            <label for="sms-field">Texto del SMS(maximo 160 caracteres)</label>
                            {!! Form::textArea("sms", null, array("class" => "form-control input-sm", "id" => "sms-field", 'rows'=>'2', 'maxlength'=>'160')) !!}
                            @if($errors->has("sms"))
                             <span class="help-block">{{ $errors->first("sms") }}</span>
                            @endif
                         </div>                    
                        </div>
                    </div>
                    
                    
                    
                    
                      <!--<div id="especialidad_div">
                          
                        @if(isset($plantilla))  
                          <div class="row">
                            <div class="col-md-12">
                              <table class="table table-condensed table-striped">
                                <thead>
                                  <th>Especialidad</th><th>Borrar</th>
                                </thead>
                                <tbody>
                                    @foreach($plantilla->especialidad as $esp)
                                      <tr>
                                        <td>{!! $esp->name !!}</td>
                                        <td> <a href="{!! route('plantillas.eliminarEspecialidad', array('plantilla'=>$plantilla->id,'esp'=>$esp->id)) !!}" class="btn btn-xs btn-danger">Eliminar</a>
                                        </td>
                                      </tr>
                                    @endforeach
                                  
                                </tbody>

                              </table>
                            </div>  

                          </div>
                        @endif
                      </div>
                    -->
                    <!--
                    <div class="form-group col-md-4 @if($errors->has('periodo_id')) has-error @endif">
                       <label for="periodo_id-field">Periodo:Mensual</label>
                       {!! Form::select("periodo_id", $list["Periodo"], null, array("class" => "form-control input-sm", "id" => "periodo_id-field")) !!}
                       @if($errors->has("periodo_id"))
                        <span class="help-block">{{ $errors->first("periodo_id") }}</span>
                       @endif
                    </div>
                    -->
                    
                    
                    
                    
                    


                    
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
      'insertdatetime table contextmenu link imagetools',
      //'emoticons paste textcolor colorpicker textpattern'
    ],
    toolbar1: 'undo redo | insert | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link',
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
    function ComprobarCantidad(){
        var sms=0;
        var mail=0;
        if ($('#sms_bnd-field').is(":checked"))
        {
          sms=1;
        }
        if ($('#mail_bnd-field').is(":checked"))
        {
          mail=1;
        }
        $.ajax({
                  url: '{{ route("plantillas.comprobarCantidad") }}',
                  type: 'GET',
                  data: "plantilla={{ $plantilla->id }}" +
                        "&mail_bnd=" + mail + 
                        "&sms_bnd=" + sms + "",
                  dataType: 'json',
                  beforeSend : function(){$("#loading10").show();},
                  complete : function(){$("#loading10").hide();},
                  success: function(data){
                      //$example.select2("destroy");
                      $('#div_comprobar').html('');
                      
                      //$('#especialidad_id-field').empty();
                      $('#div_comprobar').append('<label>Registros afectados: '+data+'</label>');
                      
                      
                      //$example.select2();
                  }
              });
    }
    
    function AgregarCondicion(){
        var opcion=$('#plan_campo_filtro_id-field option:selected').val();
        var todas;
        if ($('#todas_condiciones').is(":checked"))
        {
          todas=1;
        }else{
          todas=0;
        }
        //alert(opcion);
        switch(opcion){
            case "1":
                $.ajax({
                    url: '{{ route("plantillas.crearCondicion") }}',
                    type: 'GET',
                    data: "plantilla={{ $plantilla->id }}" + 
                          "&campo=" + $('#plan_campo_filtro_id-field option:selected').val() + 
                          "&signo=" + $('#signo_comparacion_filtro-field option:selected').val() + 
                          "&valor=" + $('#valor_condicion-field option:selected').val() +
                          "&interpretacion=" + $('#valor_condicion-field option:selected').text() + "",
                    dataType: 'json',
                    beforeSend : function(){$("#loading10").show();},
                    complete : function(){location.reload(true);},
                    success: function(data){
                    }
                });
                break;
            case "2":
                $.ajax({
                    url: '{{ route("plantillas.crearCondicion") }}',
                    type: 'GET',
                    data: "plantilla={{ $plantilla->id }}" + 
                          "&campo=" + $('#plan_campo_filtro_id-field option:selected').val() + 
                          "&signo=" + $('#signo_comparacion_filtro-field option:selected').val() + 
                          "&valor=" + $('#valor_condicion-field option:selected').val() +
                          "&interpretacion=" + $('#valor_condicion-field option:selected').text() + "",
                    dataType: 'json',
                    beforeSend : function(){$("#loading10").show();},
                    complete : function(){location.reload(true);},
                    success: function(data){
                     }
                });
                break;
            case "3":
                $.ajax({
                    url: '{{ route("plantillas.crearCondicion") }}',
                    type: 'GET',
                    data: "plantilla={{ $plantilla->id }}" + 
                          "&campo=" + $('#plan_campo_filtro_id-field option:selected').val() + 
                          "&signo=" + $('#signo_comparacion_filtro-field option:selected').val() + 
                          "&valor=" + $('#valor_especialidad-field option:selected').val() +
                          "&interpretacion=" + $('#valor_especialidad-field option:selected').text() + 
                          "&valor_plantel=" + $('#valor_plantel-field option:selected').val() +
                          "&interpretacion_plantel=" + $('#valor_plantel-field option:selected').text() + 
                          "&todas_condiciones=" + todas + "",
                    dataType: 'json',
                    beforeSend : function(){$("#loading10").show();},
                    //complete: function(){$("#loading10").hide();},
                    complete : function(){location.reload(true);},
                    success: function(data){
                     }
                });
                break;
            case "4":
                $.ajax({
                    url: '{{ route("plantillas.crearCondicion") }}',
                    type: 'GET',
                    data: "plantilla={{ $plantilla->id }}" + 
                          "&campo=" + $('#plan_campo_filtro_id-field option:selected').val() + 
                          "&signo=" + $('#signo_comparacion_filtro-field option:selected').val() + 
                          "&valor=" + $('#valor_nivel-field option:selected').val() +
                          "&interpretacion=" + $('#valor_nivel-field option:selected').text() + 
                          "&valor_especialidad=" + $('#valor_especialidad-field option:selected').val() +
                          "&interpretacion_especialidad=" + $('#valor_especialidad-field option:selected').text() + 
                          "&valor_plantel=" + $('#valor_plantel-field option:selected').val() +
                          "&interpretacion_plantel=" + $('#valor_plantel-field option:selected').text() + 
                          "&todas_condiciones=" + todas + "",
                    dataType: 'json',
                    beforeSend : function(){$("#loading10").show();},
                    //complete: function(){$("#loading10").hide();},
                    complete : function(){location.reload(true);},
                    success: function(data){
                     }
                });
                break;
            case "5":
                $.ajax({
                    url: '{{ route("plantillas.crearCondicion") }}',
                    type: 'GET',
                    data: "plantilla={{ $plantilla->id }}" + 
                          "&campo=" + $('#plan_campo_filtro_id-field option:selected').val() + 
                          "&signo=" + $('#signo_comparacion_filtro-field option:selected').val() + 
                          "&valor=" + $('#valor_grado-field option:selected').val() +
                          "&interpretacion=" + $('#valor_grado-field option:selected').text() + 
                          "&valor_nivel=" + $('#valor_nivel-field option:selected').val() +
                          "&interpretacion_nivel=" + $('#valor_nivel-field option:selected').text() + 
                          "&valor_especialidad=" + $('#valor_especialidad-field option:selected').val() +
                          "&interpretacion_especialidad=" + $('#valor_especialidad-field option:selected').text() + 
                          "&valor_plantel=" + $('#valor_plantel-field option:selected').val() +
                          "&interpretacion_plantel=" + $('#valor_plantel-field option:selected').text() + 
                          "&todas_condiciones=" + todas + "",
                    dataType: 'json',
                    beforeSend : function(){$("#loading10").show();},
                    //complete: function(){$("#loading10").hide();},
                    complete : function(){location.reload(true);},
                    success: function(data){
                     }
                });
                break;
        }
        
        
    }
    $(document).ready(function() {
      getCmbEspecialidad();
      getCmbNivel();
      $('#plantel_id-field').change(function(){
          getCmbEspecialidad();
      });
      
      $('#plan_campo_filtro_id-field').change(function(){
        var campo=$('#plan_campo_filtro_id-field option:selected').val();
        //alert(campo);
        switch(campo){
            case "1":
                $.ajax({
                    url: '{{ route("stSeguimientos.getCmbEstatus") }}',
                    type: 'GET',
                    data: campo,
                    dataType: 'json',
                    beforeSend : function(){$("#loading10").show();},
                    complete : function(){$("#loading10").hide();},
                    success: function(data){     
                        //$example.select2("destroy");
                        $('#div_valor').html('');
                        //$('#especialidad_id-field').empty();
                        //$('#div_valor').append('<select id="valor_condicion-field" class="form-control select_seguridad"></select>').append($('<option></option>').text('Seleccionar').val('0'));
                        $('#div_valor').append('<label for="valor_condicion-field">Valor condicion</label>');
                        $('#div_valor').append('<select id="valor_condicion-field" class="form-control select_seguridad"></select>');
                        $.each(data, function(i) {
                            $('#valor_condicion-field').append("<option "+data[i].selectec+" value=\""+data[i].id+"\">"+data[i].name+"<\/option>");
                        });
                        $('#valor_condicion-field').select2();     
                    }
                });                
                break;
            case "2":
                $.ajax({
                    url: '{{ route("plantels.getCmbPlantels") }}',
                    type: 'GET',
                    data: campo,
                    dataType: 'json',
                    beforeSend : function(){$("#loading10").show();},
                    complete : function(){$("#loading10").hide();},
                    success: function(data){     
                        //$example.select2("destroy");
                        $('#div_valor').html('');
                        //$('#especialidad_id-field').empty();
                        //$('#div_valor').append('<select id="valor_condicion-field" class="form-control select_seguridad"></select>').append($('<option></option>').text('Seleccionar').val('0'));
                        $('#div_valor').append('<label for="valor_condicion-field">Valor condicion</label>');
                        $('#div_valor').append('<select id="valor_condicion-field" class="form-control select_seguridad"></select>');
                        $.each(data, function(i) {
                            $('#valor_condicion-field').append("<option "+data[i].selectec+" value=\""+data[i].id+"\">"+data[i].name+"<\/option>");
                        });
                        $('#valor_condicion-field').select2();     
                    }
                });                
                break;
            case "3":
                $.ajax({
                    url: '{{ route("plantels.getCmbPlantels") }}',
                    type: 'GET',
                    data: campo,
                    dataType: 'json',
                    beforeSend : function(){$("#loading10").show();},
                    complete : function(){$("#loading10").hide();},
                    success: function(data){     
                        //$example.select2("destroy");
                        $('#div_valor').html('');
                        //$('#especialidad_id-field').empty();
                        //$('#div_valor').append('<select id="valor_condicion-field" class="form-control select_seguridad"></select>').append($('<option></option>').text('Seleccionar').val('0'));
                        $('#div_valor').append('<label for="valor_condicion-field">Plantel condicion</label>');
                        $('#div_valor').append('<select id="valor_plantel-field" class="form-control select_seguridad"></select>');
                        $.each(data, function(i) {
                            $('#valor_plantel-field').append("<option "+data[i].selectec+" value=\""+data[i].id+"\">"+data[i].name+"<\/option>");
                        });
                        $('#valor_plantel-field').select2();     
                        $('#div_valor').append('<input type="checkbox" name="todas_condiciones" id="todas_condiciones" value="1"> Todas las condiciones<br>');
                        
                        $('#valor_plantel-field').change(function(){
                            getCmbEspecialidadAjax(false, false);
                        });
                        
                    }
                });                
                break;
            case "4":
                $.ajax({
                    url: '{{ route("plantels.getCmbPlantels") }}',
                    type: 'GET',
                    data: campo,
                    dataType: 'json',
                    beforeSend : function(){$("#loading10").show();},
                    complete : function(){$("#loading10").hide();},
                    success: function(data){     
                        //$example.select2("destroy");
                        $('#div_valor').html('');
                        //$('#especialidad_id-field').empty();
                        //$('#div_valor').append('<select id="valor_condicion-field" class="form-control select_seguridad"></select>').append($('<option></option>').text('Seleccionar').val('0'));
                        $('#div_valor').append('<label for="valor_condicion-field">Plantel condicion</label>');
                        $('#div_valor').append('<select id="valor_plantel-field" class="form-control select_seguridad"></select>');
                        $.each(data, function(i) {
                            $('#valor_plantel-field').append("<option "+data[i].selectec+" value=\""+data[i].id+"\">"+data[i].name+"<\/option>");
                        });
                        $('#valor_plantel-field').select2();     
                        $('#div_valor').append('<input type="checkbox" name="todas_condiciones" id="todas_condiciones" value="1"> Todas las condiciones<br>');
                        
                        $('#valor_plantel-field').change(function(){
                            getCmbEspecialidadAjax(true, false);
                        });
                    }
                });                
                break;
            case "5":
                $.ajax({
                    url: '{{ route("plantels.getCmbPlantels") }}',
                    type: 'GET',
                    data: campo,
                    dataType: 'json',
                    beforeSend : function(){$("#loading10").show();},
                    complete : function(){$("#loading10").hide();},
                    success: function(data){     
                        $('#div_valor').html('');
                        $('#div_valor').append('<label for="valor_condicion-field">Plantel condicion</label>');
                        $('#div_valor').append('<select id="valor_plantel-field" class="form-control select_seguridad"></select>');
                        $.each(data, function(i) {
                            $('#valor_plantel-field').append("<option "+data[i].selectec+" value=\""+data[i].id+"\">"+data[i].name+"<\/option>");
                        });
                        $('#valor_plantel-field').select2(); 
                        $('#div_valor').append('<input type="checkbox" name="todas_condiciones" id="todas_condiciones" value="1"> Todas las condiciones<br>');
                        
                        $('#valor_plantel-field').change(function(){
                            getCmbEspecialidadAjax(true, true);
                        });
                    }
                });                
                break;
        } 
      });
    
    function getCmbEspecialidadAjax(nivel, grado){
        $.ajax({
            url: '{{ route("especialidads.getCmbEspecialidad") }}',
            type: 'GET',
            data: "plantel_id=" + $('#valor_plantel-field option:selected').val() + 
                  "&especialidad_id=0" + "",
            dataType: 'json',
            beforeSend : function(){$("#loading10").show();},
            complete : function(){$("#loading10").hide();},
            success: function(data){     
                $('#div_especialidad').html('');
                $('#div_especialidad').append('<label for="valor_especialidad-field">Especialidad condicion</label>');
                $('#div_especialidad').append('<select id="valor_especialidad-field" class="form-control select_seguridad"></select>');
                $.each(data, function(i) {
                    $('#valor_especialidad-field').append("<option "+data[i].selectec+" value=\""+data[i].id+"\">"+data[i].name+"<\/option>");
                });
                $('#valor_especialidad-field').select2();     

                $('#valor_especialidad-field').change(function(){
                    if(nivel){
                        getCmbNivelAjax(grado);
                    }
                });
                
                
            }
        });
    }
    
    function getCmbNivelAjax(grado){
        $.ajax({
            url: '{{ route("nivels.getCmbNivels") }}',
            type: 'GET',
            data: "plantel_id=" + $('#valor_plantel-field option:selected').val() + 
                  "&especialidad_id=" + $('#valor_especialidad-field option:selected').val() + 
                  "&nivel_id=0" + "",
            dataType: 'json',
            beforeSend : function(){$("#loading10").show();},
            complete : function(){$("#loading10").hide();},
            success: function(data){     
                $('#div_nivel').html('');
                $('#div_nivel').append('<label for="valor_nivel-field">Nivel condicion</label>');
                $('#div_nivel').append('<select id="valor_nivel-field" class="form-control select_seguridad"></select>');
                $.each(data, function(i) {
                    $('#valor_nivel-field').append("<option "+data[i].selectec+" value=\""+data[i].id+"\">"+data[i].name+"<\/option>");
                });
                $('#valor_nivel-field').select2();     

                $('#valor_nivel-field').change(function(){
                    if(grado){
                        getCmbGradoAjax();
                    }
                });
            }
        });
    }
    
    function getCmbGradoAjax(){
        $.ajax({
            url: '{{ route("grados.getCmbGrados") }}',
            type: 'GET',
            data: "plantel_id=" + $('#valor_plantel-field option:selected').val() + 
                  "&especialidad_id=" + $('#valor_especialidad-field option:selected').val() + 
                  "&nivel_id=" + $('#valor_nivel-field option:selected').val() + 
                  "&grado_id=0" + "",
            dataType: 'json',
            beforeSend : function(){$("#loading10").show();},
            complete : function(){$("#loading10").hide();},
            success: function(data){     
                $('#div_grado').html('');
                $('#div_grado').append('<label for="valor_grado-field">Grado condicion</label>');
                $('#div_grado').append('<select id="valor_grado-field" class="form-control select_seguridad"></select>');
                $.each(data, function(i) {
                    $('#valor_grado-field').append("<option "+data[i].selectec+" value=\""+data[i].id+"\">"+data[i].name+"<\/option>");
                });
                $('#valor_grado-field').select2();     
            }
        });
    }
      
      function getCmbEspecialidad(){
          //var $example = $("#especialidad_id-field").select2();
          var a= $('#frm_cliente').serialize();
              $.ajax({
                  url: '{{ route("especialidads.getCmbEspecialidad") }}',
                  type: 'GET',
                  data: "plantel_id=" + $('#plantel_id-field option:selected').val() + "&especialidad_id=" + $('#especialidad_id-field option:selected').val() + "",
                  dataType: 'json',
                  beforeSend : function(){$("#loading10").show();},
                  complete : function(){$("#loading10").hide();},
                  success: function(data){
                      //$example.select2("destroy");
                      $('#especialidad_id-field').html('');
                      
                      //$('#especialidad_id-field').empty();
                      $('#especialidad_id-field').append($('<option></option>').text('Seleccionar').val('0'));
                      
                      $.each(data, function(i) {
                          //alert(data[i].name);
                          $('#especialidad_id-field').append("<option "+data[i].selectec+" value=\""+data[i].id+"\">"+data[i].name+"<\/option>");
                      });
                      //$example.select2();
                  }
              });       
      }
      $('#especialidad_id-field').change(function(){
          getCmbNivel();
      });
      function getCmbNivel(){
          //var $example = $("#especialidad_id-field").select2();
          var a= $('#frm_cliente').serialize();
              $.ajax({
                  url: '{{ route("nivels.getCmbNivels") }}',
                  type: 'GET',
                  data: "plantel_id=" + $('#plantel_id-field option:selected').val() + "&especialidad_id=" + $('#especialidad_id-field option:selected').val() + "&nivel_id=" + $('#nivel_id-field option:selected').val() + "",
                  dataType: 'json',
                  beforeSend : function(){$("#loading11").show();},
                  complete : function(){$("#loading11").hide();},
                  success: function(data){
                      //alert(data);
                      //$example.select2("destroy");
                      $('#nivel_id-field').html('');
                      //$('#especialidad_id-field').empty();
                      $('#nivel_id-field').append($('<option></option>').text('Seleccionar').val('0'));
                      
                      $.each(data, function(i) {
                          //alert(data[i].name);
                          $('#nivel_id-field').append("<option "+data[i].selectec+" value=\""+data[i].id+"\">"+data[i].name+"<\/option>");
                      });
                      //$example.select2();
                  }
              });       
      }
      
      



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
          $('#especialidad_div').hide();
       }else if($('#tpo_correo_id-field option:selected').val()==2){
          $('#estatus_div').hide();
          $('#dia_div').show();
          $('#nivel_div').show();
          $('#inicio_div').hide();
          $('#fin_div').hide();
          $('#especialidad_div').hide();
       }else if($('#tpo_correo_id-field option:selected').val()==3){
          $('#estatus_div').show();
          $('#dia_div').hide();
          $('#nivel_div').hide();
          $('#inicio_div').show();
          $('#fin_div').show();
          $('#especialidad_div').hide();
       }else if($('#tpo_correo_id-field option:selected').val()==4){
          $('#estatus_div').show();
          $('#dia_div').show();
          $('#nivel_div').hide();
          $('#inicio_div').hide();
          $('#fin_div').hide();
          $('#especialidad_div').hide();
       }else if($('#tpo_correo_id-field option:selected').val()==5){
          $('#estatus_div').show();
          $('#dia_div').show();
          $('#nivel_div').show();
          $('#inicio_div').hide();
          $('#fin_div').hide();
          $('#especialidad_div').show();
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

     $(document).on("change", ".email_archivo", function (e) {
        var miurl = "{{url('plantillas/carga_archivo_correo')}}";
        // var fileup=$("#file").val();
        var divresul = "texto_notificacion";

        var data = new FormData();
        data.append('file', $('#file')[0].files[0]);

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
            //necesario para subir archivos via ajax
            cache: false,
            contentType: false,
            processData: false,
            //mientras enviamos el archivo
            beforeSend: function () {
                $("#" + divresul + "").html($("#cargador_empresa").html());
            },
            //una vez finalizado correctamente
            success: function (data) {
                var codigo = '<div class="mailbox-attachment-info"><a href="#" class="mailbox-attachment-name"><i class="fa fa-paperclip"></i>' + data + '</a><span class="mailbox-attachment-size"> </span></div>';
                $("#" + divresul + "").html(codigo);
                $('#img1-field').val(data);
            },
            //si ha ocurrido un error
            error: function (data) {
                $("#" + divresul + "").html(data);

            }
        });
     })
     </script>


  
@endpush