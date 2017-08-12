                <div class="box box-default">
                  <div class="box-body">
                    <div class="form-group col-md-4 @if($errors->has('cve_cliente')) has-error @endif">
                       {!! Form::hidden("id", null, array("class" => "form-control", "id" => "id-field")) !!}
                       <label for="cve_cliente-field">codigo SMS(Max. 160 catacteres)</label><div id="contador"></div>
                       {!! Form::textArea("cve_cliente", null, array("class" => "form-control", "id" => "cve_cliente-field", 'rows'=>'3', 'maxlength'=>'160')) !!}
                       @if($errors->has("cve_cliente"))
                        <span class="help-block">{{ $errors->first("cve_cliente") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('matricula')) has-error @endif">
                       <label for="matricula-field">Matricula</label><div id="contador"></div>
                       {!! Form::text("matricula", null, array("class" => "form-control", "id" => "matricula-field")) !!}
                       @if($errors->has("matricula"))
                        <span class="help-block">{{ $errors->first("matricula") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('nombre')) has-error @endif">
                       <label for="nombre-field">Primer nombre</label>
                       {!! Form::text("nombre", null, array("class" => "form-control", "id" => "nombre-field")) !!}
                       @if($errors->has("nombre"))
                        <span class="help-block">{{ $errors->first("nombre") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('nombre2')) has-error @endif">
                       <label for="nombre2-field">Segundo nombre</label>
                       {!! Form::text("nombre2", null, array("class" => "form-control", "id" => "nombre2-field")) !!}
                       @if($errors->has("nombre2"))
                        <span class="help-block">{{ $errors->first("nombre2") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('ape_paterno')) has-error @endif">
                         <label for="ape_paterno-field">A. Paterno</label>
                         {!! Form::text("ape_paterno", null, array("class" => "form-control", "id" => "ape_paterno-field")) !!}
                         @if($errors->has("ape_paterno"))
                          <span class="help-block">{{ $errors->first("ape_paterno") }}</span>
                         @endif
                      </div>
                      <div class="form-group col-md-4 @if($errors->has('ape_materno')) has-error @endif">
                         <label for="ape_materno-field">A. Materno</label>
                         {!! Form::text("ape_materno", null, array("class" => "form-control", "id" => "ape_materno-field")) !!}
                         @if($errors->has("ape_materno"))
                          <span class="help-block">{{ $errors->first("ape_materno") }}</span>
                         @endif
                      </div>
                    
                    <div class="form-group col-md-4 @if($errors->has('tel_fijo')) has-error @endif">
                       <label for="tel_fijo-field">Teléfono Fijo</label>
                       {!! Form::text("tel_fijo", null, array("class" => "form-control", "id" => "tel_fijo-field")) !!}
                       @if($errors->has("tel_fijo"))
                        <span class="help-block">{{ $errors->first("tel_fijo") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('st_cliente_id')) has-error @endif">
                       <label for="st_cliente_id-field">Estatus</label>
                       {!! Form::select("st_cliente_id", $list["StCliente"], null, array("class" => "form-control select_seguridad", "id" => "st_cliente_id-field")) !!}
                       @if($errors->has("st_cliente_id"))
                        <span class="help-block">{{ $errors->first("st_cliente_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('empleado_id')) has-error @endif" style="clear:left;">
                       <label for="empleado_id-field">Empleado</label>
                       {!! Form::select("empleado_id", $list["Empleado"], null, array("class" => "form-control select_seguridad", "id" => "empleado_id-field")) !!}
                       <div id='loading3' style='display: none'><img src="{{ asset('images/ajax-loader.gif') }}" title="Enviando" /></div> 
                       @if($errors->has("empleado_id"))
                        <span class="help-block">{{ $errors->first("empleado_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('plantel_id')) has-error @endif">
                       <label for="plantel_id-field">Plantel</label>
                       {!! Form::select("plantel_id", $list["Plantel"], null, array("class" => "form-control select_seguridad", "id" => "plantel_id-field", 'readonly'=>'readonly')) !!}
                       @if($errors->has("plantel_id"))
                        <span class="help-block">{{ $errors->first("plantel_id") }}</span>
                       @endif
                    </div>
                  </div>
                </div>
                <div class="box box-default">
                  <div class="box-body">
                    <div class="form-group col-md-4 @if($errors->has('tel_cel')) has-error @endif">
                       <label for="tel_cel-field">Teléfono Celular(10 dígitos)</label>
                       {!! Form::text("tel_cel", null, array("class" => "form-control", "id" => "tel_cel-field")) !!}
                       @if($errors->has("tel_cel"))
                        <span class="help-block">{{ $errors->first("tel_cel") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('celular_confirmado')) has-error @endif">
                       <label for="celular_confirmado-field">Celular Confirmado</label>
                       {!! Form::checkbox("celular_confirmado", 1, null, [ "id" => "celular_confirmado-field"]) !!}
                       @if($errors->has("celular_confirmado"))
                        <span class="help-block">{{ $errors->first("celular_confirmado") }}</span>
                       @endif
                    </div>
                    @if(isset($cliente))
                      @permission('clientes.enviaSms')
                      <div class="form-group col-md-4">
                        <button type="button" class="btn btn-primary" id="btn_sms">Enviar SMS Bienvenida</button>   
                        <div id='loading1' style='display: none'><img src="{{ asset('images/ajax-loader.gif') }}" title="Enviando" /></div> 
                        <div id='msj'></div>
                      </div>
                      @endpermission
                    @endif
                  </div>
                </div>
                <div class="box box-default">
                  <div class="box-body">
                    <div class="form-group col-md-4 @if($errors->has('mail')) has-error @endif">
                       <label for="mail-field">Correo Electrónico</label>
                       {!! Form::text("mail", null, array("class" => "form-control", "id" => "mail-field")) !!}
                       @if($errors->has("mail"))
                        <span class="help-block">{{ $errors->first("mail") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('correo_confirmado')) has-error @endif">
                       <label for="correo_confirmado-field">Correo Confirmado</label>
                       {!! Form::checkbox("correo_confirmado", 1, null, [ "id" => "correo_confirmado-field", 'disabled'=>"disabled"]) !!}
                       <div id='loading2' style='display: none'><img src="{{ asset('images/ajax-loader.gif') }}" title="Enviando" /></div> 
                       @if($errors->has("correo_confirmado"))
                        <span class="help-block">{{ $errors->first("correo_confirmado") }}</span>
                       @endif
                    </div>
                    @if(isset($cliente))
                      @permission('clientes.enviaMail')
                        <div class="form-group col-md-4">
                          <button type="button" class="btn btn-primary" id="btn_mail">Enviar Mail Bienvenida</button>   
                          <div class="row_1"><div id='loading1' style='display: none'><img src="{{ asset('images/ajax-loader.gif') }}" title="Loading" /></div> </div>
                          <div id='msj'></div>
                        </div>
                      @endpermission
                    @endif
                  </div>
                </div>
                <div class="box box-default">
                  <div class="box-body">
                    <div class="form-group col-md-4 @if($errors->has('fec_registro')) has-error @endif">
                       <label for="fec_registro-field">Fecha Registro</label>
                       {!! Form::text("fec_registro", null, array("class" => "form-control", "id" => "fec_registro-field")) !!}
                       @if($errors->has("fec_registro"))
                        <span class="help-block">{{ $errors->first("fec_registro") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('ofertum_id')) has-error @endif">
                       <label for="ofertum_id-field">Oferta</label>
                       {!! Form::select("ofertum_id", $list['Ofertum'],null, array("class" => "form-control select_seguridad", "id" => "ofertum_id-field")) !!}
                       @if($errors->has("ofertum_id"))
                        <span class="help-block">{{ $errors->first("oferta_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('medio_id')) has-error @endif">
                       <label for="medio_id-field">Medio por el que se enteró</label>
                       {!! Form::select("medio_id", $list["Medio"], null, array("class" => "form-control select_seguridad", "id" => "medio_id-field")) !!}
                       @if($errors->has("medio_id"))
                        <span class="help-block">{{ $errors->first("medio_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('expo')) has-error @endif" id="expo-group" style="clear:left">
                       <label for="expo-field">Expo</label>
                       {!! Form::text("expo",null, array("class" => "form-control", "id" => "expo-field")) !!}
                       @if($errors->has("expo"))
                        <span class="help-block">{{ $errors->first("expo") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('otro_medio')) has-error @endif" id="otro_medio-group">
                       <label for="otro_medio-field">Otro Medio</label>
                       {!! Form::text("otro_medio", null, array("class" => "form-control", "id" => "otro_medio-field")) !!}
                       @if($errors->has("otro_medio"))
                        <span class="help-block">{{ $errors->first("otro_medio") }}</span>
                       @endif
                    </div>
                    
                    
                    <div class="form-group col-md-4 @if($errors->has('promociones')) has-error @endif">
                       <label for="promociones-field">Promociones</label>
                       {!! Form::checkbox("promociones", 1, null, [ "id" => "promociones-field"]) !!}
                       @if($errors->has("promociones"))
                        <span class="help-block">{{ $errors->first("promociones") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('promo_cel')) has-error @endif">
                       <label for="promo_cel-field">Promociones por Celular</label>
                       {!! Form::checkbox("promo_cel", 1, null, [ "id" => "promo_cel-field"]) !!}
                       @if($errors->has("promo_cel"))
                        <span class="help-block">{{ $errors->first("promo_cel") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('promo_correo')) has-error @endif">
                       <label for="promo_correo-field">Promociones por Correo</label>
                       {!! Form::checkbox("promo_correo", 1, null, [ "id" => "promo_correo-field"]) !!}
                       @if($errors->has("promo_correo"))
                        <span class="help-block">{{ $errors->first("promo_correo") }}</span>
                       @endif
                    </div>
                  </div>
                </div>
                <div class="box box-default">
                  <div class="box-body">
                    <div class="form-group col-md-4 @if($errors->has('especialidad')) has-error @endif">
                       <label for="especialidad-field">Especialidad</label>
                       {!! Form::select("especialidad_id", $list["Especialidad"], null, array("class" => "form-control select_seguridad", "id" => "especialidad_id-field")) !!}
                       <div id='loading10' style='display: none'><img src="{{ asset('images/ajax-loader.gif') }}" title="Enviando" /></div> 
                       @if($errors->has("especialidad"))
                        <span class="help-block">{{ $errors->first("especialidad") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('nivel_id')) has-error @endif">
                       <label for="nivel_id-field">Nivel</label>
                       {!! Form::select("nivel_id", $list["Nivel"], null, array("class" => "form-control select_seguridad", "id" => "nivel_id-field")) !!}
                       <div id='loading11' style='display: none'><img src="{{ asset('images/ajax-loader.gif') }}" title="Enviando" /></div> 
                       @if($errors->has("nivel_id"))
                        <span class="help-block">{{ $errors->first("nivel_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('grado_id')) has-error @endif">
                       <label for="grado_id-field">Grado</label>
                       {!! Form::select("grado_id", $list["Grado"], null, array("class" => "form-control select_seguridad", "id" => "grado_id-field")) !!}
                       <div id='loading12' style='display: none'><img src="{{ asset('images/ajax-loader.gif') }}" title="Enviando" /></div> 
                       @if($errors->has("grado_id"))
                        <span class="help-block">{{ $errors->first("grado_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('especialidad2')) has-error @endif">
                       <label for="especialidad2-field">Especialidad 2</label>
                       {!! Form::select("especialidad2_id", $list["Especialidad"], null, array("class" => "form-control select_seguridad", "id" => "especialidad2_id-field")) !!}
                       <div id='loading10' style='display: none'><img src="{{ asset('images/ajax-loader.gif') }}" title="Enviando" /></div> 
                       @if($errors->has("especialidad2"))
                        <span class="help-block">{{ $errors->first("especialidad") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('curso_id')) has-error @endif">
                       <label for="curso_id-field">Nivel 2</label>
                       {!! Form::select("curso_id", $list["Nivel"], null, array("class" => "form-control select_seguridad", "id" => "curso_id-field")) !!}
                       <div id='loading20' style='display: none'><img src="{{ asset('images/ajax-loader.gif') }}" title="Enviando" /></div> 
                       @if($errors->has("curso_id"))
                        <span class="help-block">{{ $errors->first("curso_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('subcurso_id')) has-error @endif" >
                       <label for="municipio_id-field">Grado 2 </label>
                       {!! Form::select("subcurso_id", $list["Grado"], null, array("class" => "form-control select_seguridad", "id" => "subcurso_id-field")) !!}
                       <div id='loading21' style='display: none'><img src="{{ asset('images/ajax-loader.gif') }}" title="Enviando" /></div> 
                       @if($errors->has("subcurso_id"))
                        <span class="help-block">{{ $errors->first("municipio_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('especialidad3')) has-error @endif">
                       <label for="especialidad3-field">Especialidad 3</label>
                       {!! Form::select("especialidad3_id", $list["Especialidad"], null, array("class" => "form-control select_seguridad", "id" => "especialidad3_id-field")) !!}
                       <div id='loading10' style='display: none'><img src="{{ asset('images/ajax-loader.gif') }}" title="Enviando" /></div> 
                       @if($errors->has("especialidad3"))
                        <span class="help-block">{{ $errors->first("especialidad3") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('diplomado_id')) has-error @endif">
                       <label for="estado_id-field">Nivel 3</label>
                       {!! Form::select("diplomado_id", $list["Nivel"], null, array("class" => "form-control select_seguridad", "id" => "diplomado_id-field")) !!}
                       <div id='loading22' style='display: none'><img src="{{ asset('images/ajax-loader.gif') }}" title="Enviando" /></div> 
                       @if($errors->has("diplomado_id"))
                        <span class="help-block">{{ $errors->first("estado_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('subdiplomado_id')) has-error @endif" >
                       <label for="subdiplomado_id-field">Grado 3</label>
                       {!! Form::select("subdiplomado_id", $list["Grado"], null, array("class" => "form-control select_seguridad", "id" => "subdiplomado_id-field")) !!}
                       <div id='loading23' style='display: none'><img src="{{ asset('images/ajax-loader.gif') }}" title="Enviando" /></div> 
                       @if($errors->has("subdiplomado_id"))
                        <span class="help-block">{{ $errors->first("subdiplomado_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('especialidad4')) has-error @endif">
                       <label for="especialidad4-field">Especialidad 4</label>
                       {!! Form::select("especialidad4_id", $list["Especialidad"], null, array("class" => "form-control select_seguridad", "id" => "especialidad4_id-field")) !!}
                       <div id='loading10' style='display: none'><img src="{{ asset('images/ajax-loader.gif') }}" title="Enviando" /></div> 
                       @if($errors->has("especialidad4"))
                        <span class="help-block">{{ $errors->first("especialidad4") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('otro_id')) has-error @endif">
                       <label for="otro_id-field">Nivel 4</label>
                       {!! Form::select("otro_id", $list["Nivel"], null, array("class" => "form-control select_seguridad", "id" => "otro_id-field")) !!}
                       <div id='loading24' style='display: none'><img src="{{ asset('images/ajax-loader.gif') }}" title="Enviando" /></div> 
                       @if($errors->has("otro_id"))
                        <span class="help-block">{{ $errors->first("otro_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('subotro_id')) has-error @endif" >
                       <label for="subotro_id-field">Grado</label>
                       {!! Form::select("subotro_id", $list["Grado"], null, array("class" => "form-control select_seguridad", "id" => "subotro_id-field")) !!}
                       <div id='loading25' style='display: none'><img src="{{ asset('images/ajax-loader.gif') }}" title="Enviando" /></div> 
                       @if($errors->has("subotro_id"))
                        <span class="help-block">{{ $errors->first("subotro_id") }}</span>
                       @endif
                    </div>

                  </div>
                </div>
                <div class="box box-default">
                  <div class="box-body">
                    
                    <div class="form-group col-md-4 @if($errors->has('calle')) has-error @endif">
                       <label for="calle-field">Calle</label>
                       {!! Form::text("calle", null, array("class" => "form-control", "id" => "calle-field")) !!}
                       @if($errors->has("calle"))
                        <span class="help-block">{{ $errors->first("calle") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('no_exterior')) has-error @endif">
                       <label for="no_exterior-field">No. Exterior</label>
                       {!! Form::text("no_exterior", null, array("class" => "form-control", "id" => "no_exterior-field")) !!}
                       @if($errors->has("no_exterior"))
                        <span class="help-block">{{ $errors->first("no_exterior") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('no_interior')) has-error @endif">
                       <label for="no_interior-field">No. Interior</label>
                       {!! Form::text("no_interior", null, array("class" => "form-control", "id" => "no_interior-field")) !!}
                       @if($errors->has("no_interior"))
                        <span class="help-block">{{ $errors->first("no_interior") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('colonia')) has-error @endif">
                       <label for="colonia-field">Colonia</label>
                       {!! Form::text("colonia", null, array("class" => "form-control", "id" => "colonia-field")) !!}
                       @if($errors->has("colonia"))
                        <span class="help-block">{{ $errors->first("colonia") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('cp')) has-error @endif">
                       <label for="cp-field">C.P.</label>
                       {!! Form::text("cp", null, array("class" => "form-control", "id" => "cp-field")) !!}
                       @if($errors->has("cp"))
                        <span class="help-block">{{ $errors->first("cp") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('estado_id')) has-error @endif">
                       <label for="estado_id-field">Estado</label>
                       {!! Form::select("estado_id", $list["Estado"], null, array("class" => "form-control select_seguridad", "id" => "estado_id-field")) !!}
                       @if($errors->has("estado_id"))
                        <span class="help-block">{{ $errors->first("estado_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('municipio_id')) has-error @endif" style="clear:left;">
                       <label for="municipio_id-field">Municipio</label>
                       {!! Form::select("municipio_id", $list["Municipio"], null, array("class" => "form-control select_seguridad", "id" => "municipio_id-field")) !!}
                       @if($errors->has("municipio_id"))
                        <span class="help-block">{{ $errors->first("municipio_id") }}</span>
                       @endif
                    </div>
                  </div>
                </div>
                @if(isset($cliente->id))
                <div class="box box-default">
                  <div class="box-body">
                    <div class="form-group col-md-12 @if($errors->has('pregunta_id')) has-error @endif">
                       <label for="empleado_id-field">Pregunta</label>
                       {!! Form::select("pregunta_id", $preguntas, null, array("class" => "form-control select_seguridad", "id" => "pregunta_id-field")) !!}
                       @if($errors->has("pregunta_id"))
                        <span class="help-block">{{ $errors->first("pregunta_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-12 @if($errors->has('respuesta')) has-error @endif">
                       <label for="cp-field">Respuesta</label>
                       {!! Form::textarea("respuesta", null, array("class" => "form-control", "id" => "respuesta-field", 'rows'=>2)) !!}
                       @if($errors->has("respuesta"))
                        <span class="help-block">{{ $errors->first("respuesta") }}</span>
                       @endif
                    </div>
                  </div>
                </div>
                @endif
                @if(isset($cp))
                <div class="row">
                <div class="col-md-12">
                  <table class="table table-condensed table-striped">
                    <thead>
                      <th>Pregunta</th><th>Respuesta</th><th>Borrar</th>
                    </thead>
                    <tbody>
                        @foreach($cp as $r)
                          <tr>
                            <td>{!! $r->pregunta->name !!}</td><td>{!! $r->respuesta !!}</td>
                            <td> <a href="{!! route('preguntasClientes.destroy', $r->id) !!}" class="btn btn-xs btn-danger">Eliminar</a>
                              
                            </td>
                          </tr>
                        @endforeach
                      
                    </tbody>

                  </table>
                </div>  
                </div>
                @endif
@push('scripts')
  <script src="{{ asset ('/bower_components/AdminLTE/plugins/input-mask/jquery.inputmask.js') }}"></script>
<script src="{{ asset ('/bower_components/AdminLTE/plugins/input-mask/jquery.inputmask.extensions.js') }}"></script>
<script src="{{ asset ('/bower_components/AdminLTE/plugins/input-mask/jquery.inputmask.phone.extensions.js') }}"></script>
  <script type="text/javascript">
    $(document).ready(function() {
      $('#tel_cel-field').inputmask({"mask": "(999) 999-9999"}); //specifying options
      $('#tel_fijo-field').inputmask({"mask": "(999) 999-9999"}); //specifying options
      $('#expo-group').hide();
      $('#otro_medio-group').hide(); 
      ocultaExpo();
      $("#btn_sms").click(function(event) {
            enviaSms();
        });
      $("#btn_mail").click(function(event) {
            enviaMail();
        });
      //coloca la fecha del dia si esta vacio el campo
      if($.trim($("#fec_registro-field").val())==''){
        var fullDate = new Date()
        //Thu May 19 2011 17:25:38 GMT+1000 {}
        //convert month to 2 digits
        var twoDigitMonth = ((fullDate.getMonth().length+1) === 1)? (fullDate.getMonth()+1) : '0' + (fullDate.getMonth()+1);
         
        var currentDate = fullDate.getFullYear() + "-" + twoDigitMonth + "-" + fullDate.getDate();
        //alert(currentDate);
        
        $("#fec_registro-field").val(currentDate);
      }
      // assuming the controls you want to attach the plugin to
      // have the "datepicker" class set
      //Campo de fecha
      $('#fec_registro-field').Zebra_DatePicker({
        days:['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'],
        months:['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
        readonly_element: false,
        lang_clear_date: 'Limpiar',
        show_select_today: 'Hoy',
      });
     
     //Ocultar expo y otro
     $('#medio_id-field').change(function(){
        ocultaExpo();
      });

     //Cuenta caracteres del sms
     var max_chars = 10;

    $('#cve_cliente-fiel').keyup(function() {
        var chars = $(this).val().length;
        var diff = max_chars - chars;
        $('#contador').html(diff);   
        alert('hi');
    });

     function ocultaExpo(){
      if($('#medio_id-field option:selected').val()==1){
          $('#expo-group').show();
          $('#otro_medio-group').hide();
       }else if($('#medio_id-field option:selected').val()==6){
          $('#otro_medio-group').show(); 
          $('#expo-group').hide()
       }else{
          $('#otro_medio-group').hide();
          $('#expo-group').hide()
       }
     }

     function enviaSms(){
        var a= $('#frm_cliente').serialize();
            $.ajax({
                url: '{{ route("clientes.enviaSms") }}',
                type: 'POST',
                data: a,
                dataType: 'json',
                beforeSend : function(){$("#loading1").show();},
                complete : function(){$("#loading1").hide();},
                success: function(parametros){
                    if(parametros==true){
                      $('#msj').html('Sms enviado');
                    }else{
                      $('#msj').html('Envio de sms fallo');
                    }
                }
            });       
    }
    function enviaMail(){
        var a= $('#frm_cliente').serialize();
            $.ajax({
                url: '{{ route("clientes.enviaMail") }}',
                type: 'POST',
                data: a,
                dataType: 'json',
                beforeSend : function(){$("#loading2").show();},
                complete : function(){$("#loading2").hide();},
                success: function(parametros){
                    if(parametros==true){
                      $('#msj').html('Sms enviado');
                    }else{
                      $('#msj').html('Envio de sms fallo');
                    }
                }
            });       
    }

    //Asigna el plantel segun el empleado
      $('#empleado_id-field').change(function(){
        $("#loading3").show();
        $.get("{{ url('getPlantel')}}",
          { empleado: $(this).val() },
          function(data) {
            $('#plantel_id-field').val(data).change();
            $("#loading3").hide();
          });
        
      });
      /*
      $.ajax({
          url: '{{ url('getPlantel')}}',
          type: 'GET',
          data: (empleado=$('#empleado_id-field').val),
          beforeSend : function(){$("#loading3").show();},
          complete : function(){$("#loading3").hide();},
          success: function(data){
              $('#plantel_id-field').val(data).change();
          }
      });*/

      //trabaja el campo plantel 
      @permission('Icliente.modificarPlantel')
      $('#plantel_id-field').prop('disabled', true);
      @endpermission
      $( "#frm_cliente" ).submit(function() {
          $('#plantel_id-field').prop('disabled', false);
          return true;
      });

      //Campo combos dependientes
      $('#estado_id-field').change(function(){
        $.get("{{ url('getCmbMunicipios')}}",
          { estado: $(this).val() },
          function(data) {
            $('#municipio_id-field').empty();
            $.each(data, function(key, element) {
              $('#municipio_id-field').append("<option value='" + key + "'>" + element + "</option>");
            });
          });
      }); 

      /*
      //Campo combos dependientes
      $('#nivel_id-field').change(function(){
        $("#loading4").show();
        $.get("{{ url('getCmbGrados')}}",
          { nivel: $(this).val() },
          function(data) {
            $('#grado_id-field').empty();
            $.each(data, function(key, element) {
              $('#grado_id-field').append("<option value='" + key + "'>" + element + "</option>");
            });
            $("#loading4").hide();
          });
      }); 

      //Campo combos dependientes
      $('#curso_id-field').change(function(){
        $("#loading5").show();
        $.get("{{ url('getCmbSubcursos')}}",
          { curso: $(this).val() },
          function(data) {
            $('#subcurso_id-field').empty();
            $.each(data, function(key, element) {
              $('#subcurso_id-field').append("<option value='" + key + "'>" + element + "</option>");
            });
            $("#loading5").hide();
          });
      }); 

      //Campo combos dependientes
      $('#diplomado_id-field').change(function(){
        $("#loading6").show();
        $.get("{{ url('getCmbSubdiplomados')}}",
          { diplomado: $(this).val() },
          function(data) {
            $('#subdiplomado_id-field').empty();
            $.each(data, function(key, element) {
              $('#subdiplomado_id-field').append("<option value='" + key + "'>" + element + "</option>");
            });
            $("#loading6").hide();
          });
      }); 

      //Campo combos dependientes
      $('#otro_id-field').change(function(){
        $("#loading7").show();
        $.get("{{ url('getCmbSubotros')}}",
          { otro: $(this).val() },
          function(data) {
            $('#subotro_id-field').empty();
            $.each(data, function(key, element) {
              $('#subotro_id-field').append("<option value='" + key + "'>" + element + "</option>");
            });
            $("#loading7").hide();
          });
      });    
*/
      //combos dependientes
      getCmbEspecialidad();
      getCmbNivel();
      getCmbNivel2();
      getCmbNivel3();
      getCmbNivel4();
      getCmbGrado();
      $('#plantel_id-field').change(function(){
          getCmbEspecialidad();
      });
      function getCmbEspecialidad(){
          //var $example = $("#especialidad_id-field").select2();
          var a= $('#frm_cliente').serialize();
              $.ajax({
                  url: '{{ route("especialidads.getCmbEspecialidad") }}',
                  type: 'GET',
                  data: a,
                  dataType: 'json',
                  beforeSend : function(){$("#loading10").show();},
                  complete : function(){$("#loading10").hide();},
                  success: function(data){
                      //$example.select2("destroy");
                      $('#especialidad_id-field').html('');
                      $('#especialidad2_id-field').html('');
                      $('#especialidad3_id-field').html('');
                      $('#especialidad4_id-field').html('');
                      //$('#especialidad_id-field').empty();
                      $('#especialidad_id-field').append($('<option></option>').text('Seleccionar').val('0'));
                      $('#especialidad2_id-field').append($('<option></option>').text('Seleccionar').val('0'));
                      $('#especialidad3_id-field').append($('<option></option>').text('Seleccionar').val('0'));
                      $('#especialidad4_id-field').append($('<option></option>').text('Seleccionar').val('0'));
                      $.each(data, function(i) {
                          //alert(data[i].name);
                          $('#especialidad_id-field').append("<option "+data[i].selectec+" value=\""+data[i].id+"\">"+data[i].name+"<\/option>");
                          $('#especialidad2_id-field').append("<option "+data[i].selectec+" value=\""+data[i].id+"\">"+data[i].name+"<\/option>");
                          $('#especialidad3_id-field').append("<option "+data[i].selectec+" value=\""+data[i].id+"\">"+data[i].name+"<\/option>");
                          $('#especialidad4_id-field').append("<option "+data[i].selectec+" value=\""+data[i].id+"\">"+data[i].name+"<\/option>");
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
      $('#especialidad2_id-field').change(function(){
          getCmbNivel2();
      });
      function getCmbNivel2(){
          //var $example = $("#especialidad_id-field").select2();
          var a= $('#frm_cliente').serialize();
              $.ajax({
                  url: '{{ route("nivels.getCmbNivels") }}',
                  type: 'GET',
                  data: "plantel_id=" + $('#plantel_id-field option:selected').val() + "&especialidad_id=" + $('#especialidad2_id-field option:selected').val() + "&nivel_id=" + $('#curso_id-field option:selected').val() +"",
                  dataType: 'json',
                  beforeSend : function(){$("#loading11").show();},
                  complete : function(){$("#loading11").hide();},
                  success: function(data){
                      //alert(data);
                      //$example.select2("destroy");
                      $('#curso_id-field').html('');
                      //$('#especialidad_id-field').empty();
                      $('#curso_id-field').append($('<option></option>').text('Seleccionar').val('0'));
                      
                      $.each(data, function(i) {
                          //alert(data[i].name);
                          $('#curso_id-field').append("<option "+data[i].selectec+" value=\""+data[i].id+"\">"+data[i].name+"<\/option>");
                      });
                      //$example.select2();
                  }
              });       
      }
      $('#especialidad3_id-field').change(function(){
          getCmbNivel3();
      });
      function getCmbNivel3(){
          //var $example = $("#especialidad_id-field").select2();
          var a= $('#frm_cliente').serialize();
              $.ajax({
                  url: '{{ route("nivels.getCmbNivels") }}',
                  type: 'GET',
                  data: "plantel_id=" + $('#plantel_id-field option:selected').val() + "&especialidad_id=" + $('#especialidad3_id-field option:selected').val() +  "&nivel_id=" + $('#diplomado_id-field option:selected').val() +"",
                  dataType: 'json',
                  beforeSend : function(){$("#loading11").show();},
                  complete : function(){$("#loading11").hide();},
                  success: function(data){
                      //alert(data);
                      //$example.select2("destroy");
                      $('#diplomado_id-field').html('');
                      //$('#especialidad_id-field').empty();
                      $('#diplomado_id-field').append($('<option></option>').text('Seleccionar').val('0'));
                      
                      $.each(data, function(i) {
                          //alert(data[i].name);
                          $('#diplomado_id-field').append("<option "+data[i].selectec+" value=\""+data[i].id+"\">"+data[i].name+"<\/option>");
                      });
                      //$example.select2();
                  }
              });       
      }
      $('#especialidad4_id-field').change(function(){
          getCmbNivel4();
      });
      function getCmbNivel4(){
          //var $example = $("#especialidad_id-field").select2();
          var a= $('#frm_cliente').serialize();
              $.ajax({
                  url: '{{ route("nivels.getCmbNivels") }}',
                  type: 'GET',
                  data: "plantel_id=" + $('#plantel_id-field option:selected').val() + "&especialidad_id=" + $('#especialidad4_id-field option:selected').val() + "&nivel_id=" + $('#otro_id-field option:selected').val() + "",
                  dataType: 'json',
                  beforeSend : function(){$("#loading11").show();},
                  complete : function(){$("#loading11").hide();},
                  success: function(data){
                      //alert(data);
                      //$example.select2("destroy");
                      $('#otro_id-field').html('');
                      //$('#especialidad_id-field').empty();
                      $('#otro_id-field').append($('<option></option>').text('Seleccionar').val('0'));
                      
                      $.each(data, function(i) {
                          //alert(data[i].name);
                          $('#otro_id-field').append("<option "+data[i].selectec+" value=\""+data[i].id+"\">"+data[i].name+"<\/option>");
                      });
                      //$example.select2();
                  }
              });       
      }
      
      $('#nivel_id-field').change(function(){
          getCmbGrado();
      });
      function getCmbGrado(){
          //var $example = $("#especialidad_id-field").select2();
          var a= $('#frm_cliente').serialize();
              $.ajax({
                  url: '{{ route("grados.getCmbGrados") }}',
                  type: 'GET',
                  data: "plantel_id=" + $('#plantel_id-field option:selected').val() + "&especialidad_id=" + $('#especialidad_id-field option:selected').val() + "&nivel_id=" + $('#nivel_id-field option:selected').val() + "&grado_id=" + $('#grado_id-field option:selected').val() +"",
                  dataType: 'json',
                  beforeSend : function(){$("#loading12").show();},
                  complete : function(){$("#loading12").hide();},
                  success: function(data){
                      //alert(data);
                      //$example.select2("destroy");
                      $('#grado_id-field').html('');
                      //$('#especialidad_id-field').empty();
                      $('#grado_id-field').append($('<option></option>').text('Seleccionar').val('0'));
                      
                      $.each(data, function(i) {
                          //alert(data[i].name);
                          $('#grado_id-field').append("<option "+data[i].selectec+" value=\""+data[i].id+"\">"+data[i].name+"<\/option>");
                      });
                      //$example.select2();
                  }
              });       
      }
      $('#curso_id-field').change(function(){
          getCmbGrado2();
      });
      function getCmbGrado2(){
          //var $example = $("#especialidad_id-field").select2();
          var a= $('#frm_cliente').serialize();
              $.ajax({
                  url: '{{ route("grados.getCmbGrados") }}',
                  type: 'GET',
                  data: "plantel_id=" + $('#plantel_id-field option:selected').val() + "&especialidad_id=" + $('#especialidad2_id-field option:selected').val() + "&nivel_id=" + $('#curso_id-field option:selected').val() + "&grado_id=" + $('#subcurso_id-field option:selected').val() + "",
                  dataType: 'json',
                  beforeSend : function(){$("#loading12").show();},
                  complete : function(){$("#loading12").hide();},
                  success: function(data){
                      //alert(data);
                      //$example.select2("destroy");
                      $('#subcurso_id-field').html('');
                      //$('#especialidad_id-field').empty();
                      $('#subcurso_id-field').append($('<option></option>').text('Seleccionar').val('0'));
                      
                      $.each(data, function(i) {
                          //alert(data[i].name);
                          $('#subcurso_id-field').append("<option "+data[i].selectec+" value=\""+data[i].id+"\">"+data[i].name+"<\/option>");
                      });
                      //$example.select2();
                  }
              });       
      }
      $('#diplomado_id-field').change(function(){
          getCmbGrado3();
      });
      function getCmbGrado3(){
          //var $example = $("#especialidad_id-field").select2();
          var a= $('#frm_cliente').serialize();
              $.ajax({
                  url: '{{ route("grados.getCmbGrados") }}',
                  type: 'GET',
                  data: "plantel_id=" + $('#plantel_id-field option:selected').val() + "&especialidad_id=" + $('#especialidad3_id-field option:selected').val() + "&nivel_id=" + $('#diplomado_id-field option:selected').val() + "&grado_id=" + $('#subdiplomado_id-field option:selected').val()+ "",
                  dataType: 'json',
                  beforeSend : function(){$("#loading12").show();},
                  complete : function(){$("#loading12").hide();},
                  success: function(data){
                      //alert(data);
                      //$example.select2("destroy");
                      $('#subdiplomado_id-field').html('');
                      //$('#especialidad_id-field').empty();
                      $('#subdiplomado_id-field').append($('<option></option>').text('Seleccionar').val('0'));
                      
                      $.each(data, function(i) {
                          //alert(data[i].name);
                          $('#subdiplomado_id-field').append("<option "+data[i].selectec+" value=\""+data[i].id+"\">"+data[i].name+"<\/option>");
                      });
                      //$example.select2();
                  }
              });       
      }
      $('#otro_id-field').change(function(){
          getCmbGrado4();
      });
      function getCmbGrado4(){
          //var $example = $("#especialidad_id-field").select2();
          var a= $('#frm_cliente').serialize();
              $.ajax({
                  url: '{{ route("grados.getCmbGrados") }}',
                  type: 'GET',
                  data: "plantel_id=" + $('#plantel_id-field option:selected').val() + "&especialidad_id=" + $('#especialidad4_id-field option:selected').val() + "&nivel_id=" + $('#otro_id-field option:selected').val() + "&grado_id=" + $('#subotro_id-field option:selected').val()+ "",
                  dataType: 'json',
                  beforeSend : function(){$("#loading12").show();},
                  complete : function(){$("#loading12").hide();},
                  success: function(data){
                      //alert(data);
                      //$example.select2("destroy");
                      $('#subotro_id-field').html('');
                      //$('#especialidad_id-field').empty();
                      $('#subotro_id-field').append($('<option></option>').text('Seleccionar').val('0'));
                      
                      $.each(data, function(i) {
                          //alert(data[i].name);
                          $('#subotro_id-field').append("<option "+data[i].selectec+" value=\""+data[i].id+"\">"+data[i].name+"<\/option>");
                      });
                      //$example.select2();
                  }
              });       
      }
      //fin combos dependientes

      //
      $(function() {
          $("#expo-field").autocomplete({
              source: "{!! route('clientes.autocomplete') !!}",
              minLength: 2,
              autofocus:true,
              select: function( event, ui ) {
                  $('#expo-field').val(ui.item.label);
              }
          });
      });

      
    });
   

  </script>
@endpush
                    