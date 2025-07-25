                    <div class="box box-default">
                      <div class="box-body">
                      <div class="form-group col-md-4 @if($errors->has('cve_empleado')) has-error @endif">
                         <label for="cve_empleado-field">Clave Empleado</label>
                         {!! Form::text("cve_empleado", null, array("class" => "form-control input-sm", "id" => "cve_empleado-field")) !!}
                         @if($errors->has("cve_empleado"))
                          <span class="help-block">{{ $errors->first("cve_empleado") }}</span>
                         @endif
                      </div>
                      <div class="form-group col-md-4 @if($errors->has('nombre')) has-error @endif">
                         <label for="nombre-field">Nombre</label>
                         {!! Form::text("nombre", null, array("class" => "form-control input-sm", "id" => "nombre-field")) !!}
                         @if($errors->has("nombre"))
                          <span class="help-block">{{ $errors->first("nombre") }}</span>
                         @endif
                      </div>
                      <div class="form-group col-md-4 @if($errors->has('ape_paterno')) has-error @endif">
                         <label for="ape_paterno-field">A. Paterno</label>
                         {!! Form::text("ape_paterno", null, array("class" => "form-control input-sm", "id" => "ape_paterno-field")) !!}
                         @if($errors->has("ape_paterno"))
                          <span class="help-block">{{ $errors->first("ape_paterno") }}</span>
                         @endif
                      </div>
                      <div class="form-group col-md-4 @if($errors->has('ape_materno')) has-error @endif">
                         <label for="ape_materno-field">A. Materno</label>
                         {!! Form::text("ape_materno", null, array("class" => "form-control input-sm", "id" => "ape_materno-field")) !!}
                         @if($errors->has("ape_materno"))
                          <span class="help-block">{{ $errors->first("ape_materno") }}</span>
                         @endif
                      </div>
                      <div class="form-group col-md-4 @if($errors->has('mail')) has-error @endif">
                        <label for="mail-field">Correo Electrónico</label>
                        {!! Form::text("mail", null, array("class" => "form-control input-sm", "id" => "mail-field")) !!}
                        @if($errors->has("mail"))
                         <span class="help-block">{{ $errors->first("mail") }}</span>
                        @endif
                     </div>
                      @permission('empleados.verDatosPersonales')
                      <div class="form-group col-md-4 @if($errors->has('rfc')) has-error @endif">
                         <label for="rfc-field">RFC</label>
                         {!! Form::text("rfc", null, array("class" => "form-control input-sm", "id" => "rfc-field")) !!}
                         @if($errors->has("rfc"))
                          <span class="help-block">{{ $errors->first("rfc") }}</span>
                         @endif
                      </div>
                      <div class="form-group col-md-4 @if($errors->has('curp')) has-error @endif">
                         <label for="curp-field">CURP</label>
                         {!! Form::text("curp", null, array("class" => "form-control input-sm", "id" => "curp-field")) !!}
                         @if($errors->has("curp"))
                          <span class="help-block">{{ $errors->first("curp") }}</span>
                         @endif
                      </div>
                      <div class="form-group col-md-4 @if($errors->has('direccion')) has-error @endif">
                         <label for="direccion-field">Dirección</label>
                         {!! Form::text("direccion", null, array("class" => "form-control input-sm", "id" => "direccion-field")) !!}
                         @if($errors->has("direccion"))
                          <span class="help-block">{{ $errors->first("direccion") }}</span>
                         @endif
                      </div>
                      <div class="form-group col-md-4 @if($errors->has('tel_fijo')) has-error @endif">
                         <label for="tel_fijo-field">Teléfono</label>
                         {!! Form::text("tel_fijo", null, array("class" => "form-control input-sm", "id" => "tel_fijo-field")) !!}
                         @if($errors->has("tel_fijo"))
                          <span class="help-block">{{ $errors->first("tel_fijo") }}</span>
                         @endif
                      </div>
                      <div class="form-group col-md-4 @if($errors->has('tel_cel')) has-error @endif">
                         <label for="tel_cel-field">Celular</label>
                         {!! Form::text("tel_cel", null, array("class" => "form-control input-sm", "id" => "tel_cel-field")) !!}
                         @if($errors->has("tel_cel"))
                          <span class="help-block">{{ $errors->first("tel_cel") }}</span>
                         @endif
                      </div>
                      <div class="form-group col-md-4 @if($errors->has('cel_empresa')) has-error @endif">
                         <label for="cel_empresa-field">Celular Empresa</label>
                         {!! Form::text("cel_empresa", null, array("class" => "form-control input-sm", "id" => "cel_empresa-field")) !!}
                         @if($errors->has("cel_empresa"))
                          <span class="help-block">{{ $errors->first("cel_empresa") }}</span>
                         @endif
                      </div>
                      
                      <div class="form-group col-md-4 @if($errors->has('mail_empresa')) has-error @endif">
                         <label for="mail_empresa-field">Correo Electrónico Empresa</label>
                         {!! Form::text("mail_empresa", null, array("class" => "form-control input-sm", "id" => "mail_empresa-field")) !!}
                         @if($errors->has("mail_empresa"))
                          <span class="help-block">{{ $errors->first("mail_empresa") }}</span>
                         @endif
                      </div>
                      <div class="form-group col-md-4 @if($errors->has('fec_nacimiento')) has-error @endif">
                        <label for="fec_nacimiento-field">Fecha Nacimiento</label>
                        {!! Form::text("fec_nacimiento", null, array("class" => "form-control input-sm fecha", "id" => "fec_nacimiento-field")) !!}
                        @if($errors->has("fec_nacimiento"))
                        <span class="help-block">{{ $errors->first("fec_nacimiento") }}</span>
                        @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('pais_nacimiento')) has-error @endif">
                      <label for="pais_nacimiento-field">Pais Nacimiento</label>
                      {!! Form::text("pais_nacimiento", null, array("class" => "form-control input-sm", "id" => "pais_nacimiento-field")) !!}
                      @if($errors->has("pais_nacimiento"))
                       <span class="help-block">{{ $errors->first("pais_nacimiento") }}</span>
                      @endif
                   </div>
                    <div class="form-group col-md-4 @if($errors->has('estado_nacimiento_id')) has-error @endif">
                      <label for="estado_nacimiento_id-field">Estado Nacimiento</label>
                      {!! Form::select("estado_nacimiento_id", $estados, null, array("class" => "form-control select_seguridad", "id" => "estado_nacimiento_id-field")) !!}
                      @if($errors->has("estado_nacimiento_id"))
                      <span class="help-block">{{ $errors->first("estado_nacimiento_id") }}</span>
                      @endif
                  </div>
                    <div class="form-group col-md-4 @if($errors->has('nivel_estudio_id')) has-error @endif" style="clear:left;">
                      <label for="nivel_estudio_id-field">Nivel Estudio</label>
                      {!! Form::select("nivel_estudio_id", $nivel_estudios, null, array("class" => "form-control select_seguridad", "id" => "nivel_estudio_id-field")) !!}
                      @if($errors->has("nivel_estudio_id"))
                      <span class="help-block">{{ $errors->first("nivel_estudio_id") }}</span>
                      @endif
                  </div>
                    <div class="form-group col-md-4 @if($errors->has('profesion')) has-error @endif">
                      <label for="profesion-field">Profesion</label>
                      {!! Form::text("profesion", null, array("class" => "form-control input-sm", "id" => "profesion-field")) !!}
                      @if($errors->has("profesion"))
                        <span class="help-block">{{ $errors->first("profesion") }}</span>
                      @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('cedula')) has-error @endif">
                      <label for="cedula-field">Cedula</label>
                      {!! Form::text("cedula", null, array("class" => "form-control input-sm", "id" => "cedula-field")) !!}
                      @if($errors->has("cedula"))
                        <span class="help-block">{{ $errors->first("cedula") }}</span>
                      @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('anios_servicio_escuela')) has-error @endif">
                      <label for="anios_servicio_escuela-field">Años Servicio Escuela</label>
                      {!! Form::text("anios_servicio_escuela", null, array("class" => "form-control input-sm", "id" => "anios_servicio_escuela-field")) !!}
                      @if($errors->has("anios_servicio_escuela"))
                        <span class="help-block">{{ $errors->first("cedula") }}</span>
                      @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('profordems')) has-error @endif">
                      <label for="profordems-field">PROFORDEMS</label>
                      {!! Form::text("profordems", null, array("class" => "form-control input-sm", "id" => "profordems-field")) !!}
                      @if($errors->has("profordems"))
                        <span class="help-block">{{ $errors->first("profordems") }}</span>
                      @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('fec_inicio_experiencia_academicas')) has-error @endif">
                      <label for="fec_inicio_experiencia_academicas-field">F. Inicio Experiencia Academica</label>
                      {!! Form::text("fec_inicio_experiencia_academicas", null, array("class" => "form-control input-sm fecha", "id" => "fec_inicio_experiencia_academicas-field")) !!}
                      @if($errors->has("fec_inicio_experiencia_academicas"))
                        <span class="help-block">{{ $errors->first("fec_inicio_experiencia_academicas") }}</span>
                      @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('contacto_emergencia')) has-error @endif">
                      <label for="contacto_emergencia-field">Contacto de Emergencia</label>
                      {!! Form::text("contacto_emergencia", null, array("class" => "form-control input-sm", "id" => "contacto_emergencia-field")) !!}
                      @if($errors->has("contacto_emergencia"))
                        <span class="help-block">{{ $errors->first("contacto_emergencia") }}</span>
                      @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('parentesco')) has-error @endif">
                      <label for="parentesco-field">Parentesco</label>
                      {!! Form::text("parentesco", null, array("class" => "form-control input-sm", "id" => "parentesco-field")) !!}
                      @if($errors->has("parentesco"))
                        <span class="help-block">{{ $errors->first("parentesco") }}</span>
                      @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('tel_emergencia')) has-error @endif">
                      <label for="tel_emergencia-field">Tel. Emergencia</label>
                      {!! Form::text("tel_emergencia", null, array("class" => "form-control input-sm", "id" => "tel_emergencia-field")) !!}
                      @if($errors->has("tel_emergencia"))
                        <span class="help-block">{{ $errors->first("tel_emergencia") }}</span>
                      @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('contacto_emergencia2')) has-error @endif">
                      <label for="contacto_emergencia2-field">Contacto de Emergencia 2</label>
                      {!! Form::text("contacto_emergencia2", null, array("class" => "form-control input-sm", "id" => "contacto_emergencia2-field")) !!}
                      @if($errors->has("contacto_emergencia2"))
                        <span class="help-block">{{ $errors->first("contacto_emergencia2") }}</span>
                      @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('parentesco2')) has-error @endif">
                      <label for="parentesco2-field">Parentesco 2</label>
                      {!! Form::text("parentesco2", null, array("class" => "form-control input-sm", "id" => "parentesco2-field")) !!}
                      @if($errors->has("parentesco2"))
                        <span class="help-block">{{ $errors->first("parentesco2") }}</span>
                      @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('tel_emergencia2')) has-error @endif">
                      <label for="tel_emergencia2-field">Tel. Emergencia 2</label>
                      {!! Form::text("tel_emergencia2", null, array("class" => "form-control input-sm", "id" => "tel_emergencia2-field")) !!}
                      @if($errors->has("tel_emergencia2"))
                        <span class="help-block">{{ $errors->first("tel_emergencia2") }}</span>
                      @endif
                    </div>
                    @endpermission
                      </div>
                    </div>
                    @permission('empleados.verDatosPlantel')
                    <div class="box box-default">
                      <div class="box-body">
                        <div class="form-group col-md-4 @if($errors->has('puesto_id')) has-error @endif">
                          <label for="puesto_id-field">Puesto</label>
                          {!! Form::select("puesto_id", $list["Puesto"], null, array("class" => "form-control select_seguridad", "id" => "puesto_id-field")) !!}
                          @if($errors->has("puesto_id"))
                            <span class="help-block">{{ $errors->first("puesto_id") }}</span>
                          @endif
                        </div>
                        <div class="form-group col-md-3 @if($errors->has('area_id')) has-error @endif">
                          <label for="area_id-field">Area</label>
                          {!! Form::select("area_id", $list["Area"], null, array("class" => "form-control select_seguridad", "id" => "area_id-field")) !!}
                          @if($errors->has("area_id"))
                            <span class="help-block">{{ $errors->first("area_id") }}</span>
                          @endif
                        </div>
                        <div class="form-group col-md-1 @if($errors->has('jefe_bnd')) has-error @endif">
                          <label for="jefe_bnd-field">Tiene subordinados?</label>
                          {!! Form::checkbox("jefe_bnd", 1, null, [ "id" => "jefe_bnd-field"]) !!}
                          @if($errors->has("jefe_bnd"))
                            <span class="help-block">{{ $errors->first("jefe_bnd") }}</span>
                          @endif
                        </div>
                        <div class="form-group col-md-2 @if($errors->has('st_prospecto_id')) has-error @endif">
                          <label for="st_prospecto_id-field">Etapa Prospectos</label>
                          {!! Form::select("st_prospecto_id", $list["StProspecto"], null, array("class" => "form-control select_seguridad", "id" => "st_prospecto_id-field")) !!}
                          @if($errors->has("st_prospecto_id"))
                            <span class="help-block">{{ $errors->first("st_prospecto_id") }}</span>
                          @endif
                        </div>
                        <div class="form-group col-md-4 @if($errors->has('jefe_id')) has-error @endif">
                          <label for="jefe_id-field">Jefe</label>
                          {!! Form::select("jefe_id", $jefes, null, array("class" => "form-control select_seguridad", "id" => "jefe_id-field")) !!}
                          @if($errors->has("jefe_id"))
                            <span class="help-block">{{ $errors->first("resp_alerta_id") }}</span>
                          @endif
                        </div>
                        <div class="form-group col-md-4 @if($errors->has('pertenece_a')) has-error @endif">
                          <label for="pertenece_a-field">Pertenece A</label>
                          {!! Form::select("pertenece_a", $list["Plantel"], isset($empleado->plantel_id) ? $empleado->plantel_id : null, array("class" => "form-control select_seguridad", "id" => "pertenece_a-field")) !!}
                          @if($errors->has("pertenece_a"))
                            <span class="help-block">{{ $errors->first("pertenece_a") }}</span>
                          @endif
                        </div>
                        <div class="form-group col-md-4 @if($errors->has('fec_ingreso')) has-error @endif">
                          <label for="fec_ingreso-field">F. Ingreso</label>
                          {!! Form::text("fec_ingreso", null, array("class" => "form-control input-sm fecha", "id" => "fec_ingreso-field")) !!}
                          @if($errors->has("fec_ingreso"))
                            <span class="help-block">{{ $errors->first("fec_ingreso") }}</span>
                          @endif
                        </div>
                        <div class="row"></div>
                        <div class="form-group col-md-12 @if($errors->has('plantel_id')) has-error @endif">
                          <label for="plantel_id-field">Planteles *<input type="checkbox" id="seleccionar_planteles">Seleccionar Todo</label>
                          {!! Form::select("plantel_id[]", $list["Plantel"], isset($empleado->plantels) ? $empleado->plantels : null, array("class" => "form-control select_seguridad", "id" => "plantel_id-field", 'multiple'=>true)) !!}
                          @if($errors->has("plantel_id"))
                            <span class="help-block">{{ $errors->first("plantel_id") }}</span>
                          @endif
                        </div>
                      
                        <div class="form-group col-md-4 @if($errors->has('st_puesto_id')) has-error @endif">
                          <label for="stpuesto_id-field">Estatus</label>
                          {!! Form::select("st_empleado_id", $list["StEmpleado"], null, array("class" => "form-control input-sm", "id" => "st_empleado_id-field")) !!}
                          @if($errors->has("st_empleado_id"))
                            <span class="help-block">{{ $errors->first("stpuesto_id") }}</span>
                          @endif
                        </div>
                        <div class="form-group col-md-4 @if($errors->has('user_id')) has-error @endif">
                            <label for="plantel_id-field">Usuario 
                                @permission('entrust')
                                <a href="{!! route('entrust-gui::users.create') !!}" target="_blank">Crear usuario</a>
                                @endpermission
                              </label>
                            {!! Form::select("user_id", $list["User"], null, array("class" => "form-control select_seguridad", "id" => "user_id-field")) !!}
                            @if($errors->has("user_id"))
                              <span class="help-block">{{ $errors->first("user_id") }}</span>
                            @endif
                        </div>
                        <div class="form-group col-md-2 @if($errors->has('genero')) has-error @endif">
                          <label for="genero-field">Género</label><br/>
                          <div class="form-group col-md-6 @if($errors->has('genero')) has-error @endif">
                            {!! Form::radio("genero", 1, null, [ "id" => "genero-field"]) !!}
                            <label for="Genero-field">Masculino</label>
                          </div>
                          <div class="form-group col-md-6 @if($errors->has('genero')) has-error @endif">
                            {!! Form::radio("genero", 2, null, [ "id" => "genero-field2"]) !!}
                            <label for="Genero-field">Femenino</label>
                          </div>
                          
                          @if($errors->has("genero_bnd"))
                            <span class="help-block">{{ $errors->first("genero") }}</span>
                          @endif
                        </div>  
                        <div class="form-group col-md-2 @if($errors->has('extranjero_bnd')) has-error @endif">
                          <label for="extranjero_bnd-field">Extranjero</label>
                          {!! Form::checkbox("extranjero_bnd", 1, null, [ "id" => "extranjero_bnd-field"]) !!}
                          @if($errors->has("extranjero_bnd"))
                            <span class="help-block">{{ $errors->first("extranjero_bnd") }}</span>
                          @endif
                        </div>  
                        <div class="form-group col-md-3 @if($errors->has('alimenticia_bnd')) has-error @endif">
                          <label for="alimenticia_bnd-field">Proporciona pensión alimenticia</label>
                          {!! Form::checkbox("alimenticia_bnd", 1, null, [ "id" => "alimenticia_bnd-field"]) !!}
                          @if($errors->has("alimenticia_bnd"))
                            <span class="help-block">{{ $errors->first("alimenticia_bnd") }}</span>
                          @endif
                        </div>  
                      </div>
                    </div>
                    @endpermission
                    
                    @permission('empleados.verDatosContrato')
                    <div class="box box-default">
                      <div class="box-body">
                        
                        <div class="form-group col-md-1 @if($errors->has('alerta_bnd')) has-error @endif">
                          <label for="alerta_bnd-field">Alerta</label>
                          {!! Form::checkbox("alerta_bnd", 1, null, [ "id" => "alerta_bnd-field"]) !!}
                          @if($errors->has("alerta_bnd"))
                            <span class="help-block">{{ $errors->first("alerta_bnd") }}</span>
                          @endif
                        </div>
                        
                        
                        <div class="form-group col-md-1 @if($errors->has('dias_alerta')) has-error @endif">
                          <label for="dias_alerta-field">Dias Alerta</label>
                          {!! Form::text("dias_alerta", (isset($empleado->dias_alerta) and is_null($empleado->dias_alerta)) ? 0 : null, array("class" => "form-control input-sm", "id" => "dias_alerta-field")) !!}
                          @if($errors->has("dias_alerta"))
                            <span class="help-block">{{ $errors->first("dias_alerta") }}</span>
                          @endif
                        </div>
                        <div class="form-group col-md-1 @if($errors->has('bnd_recontratable')) has-error @endif">
                          <label for="bnd_recontratable-field">Es Recontratable?</label>
                          {!! Form::checkbox("bnd_recontratable", 1, null, [ "id" => "bnd_recontratable-field"]) !!}
                          @if($errors->has("bnd_recontratable"))
                            <span class="help-block">{{ $errors->first("bnd_recontratable") }}</span>
                          @endif
                        </div>
                        <div class="form-group col-md-9 @if($errors->has('just_recontratable')) has-error @endif">
                          <label for="just_recontratable-field">Justificacion</label>
                          {!! Form::text("just_recontratable", null, array("class" => "form-control input-sm", "id" => "just_recontratable-field")) !!}
                          @if($errors->has("just_recontratable"))
                            <span class="help-block">{{ $errors->first("just_recontratable") }}</span>
                          @endif
                        </div>
                        <div class="form-group col-md-3 @if($errors->has('plantel_contrato1_id')) has-error @endif" style="clear:left;">
                          <label for="plantel_contrato1_id-field">Plantel contrato 1</label>
                          {!! Form::select("plantel_contrato1_id", $list["Plantel"], isset($empleado->plantel_contrato1_id) ? $empleado->plantel_contrato1_id : null, array("class" => "form-control select_seguridad", "id" => "plantel_contrato1_id-field")) !!}
                          @if($errors->has("plantel_contrato1_id"))
                            <span class="help-block">{{ $errors->first("plantel_contrato1_id") }}</span>
                          @endif
                        </div>
                        <div class="form-group col-md-2 @if($errors->has('tipo_contrato_id')) has-error @endif" >
                          <label for="tipo_contrato_id-field">Tipo Contrato</label>
                          {!! Form::select("tipo_contrato_id", $tipoContratos, isset($empleado->tipo_contrato_id) ? $empleado->tipo_contrato_id : null, array("class" => "form-control select_seguridad", "id" => "tipo_contrato_id-field")) !!}
                          @if($errors->has("tipo_contrato_id"))
                            <span class="help-block">{{ $errors->first("tipo_contrato_id") }}</span>
                          @endif
                        </div>
                        <div class="form-group col-md-2 @if($errors->has('fec_inicio_contrato1')) has-error @endif">
                          <label for="fec_inicio_contrato1-field">Inicio Contrato</label>
                          {!! Form::text("fec_inicio_contrato1", null, array("class" => "form-control input-sm fecha", "id" => "fec_inicio_contrato1-field")) !!}
                          @if($errors->has("fec_inicio_contrato1"))
                            <span class="help-block">{{ $errors->first("fec_inicio_contrato1") }}</span>
                          @endif
                        </div>
                        <div class="form-group col-md-2 @if($errors->has('fin_contrato')) has-error @endif">
                          <label for="fin_contrato-field">Fin Contrato</label>
                          {!! Form::text("fin_contrato", null, array("class" => "form-control input-sm", "id" => "fin_contrato-field")) !!}
                          @if($errors->has("fin_contrato"))
                            <span class="help-block">{{ $errors->first("fin_contrato") }}</span>
                          @endif
                        </div>

                        <div class="form-group col-md-3 @if($errors->has('resp_alerta_id')) has-error @endif">
                          <label for="resp_alerta_id-field">Reponsable</label>
                          {!! Form::select("resp_alerta_id", $responsables, null, array("class" => "form-control select_seguridad", "id" => "resp_alerta_id-field")) !!}
                          @if($errors->has("resp_alerta_id"))
                            <span class="help-block">{{ $errors->first("resp_alerta_id") }}</span>
                          @endif
                        </div>

                        <div class="form-group col-md-3 @if($errors->has('plantel_contrato2_id')) has-error @endif" style="clear:left;">
                          <label for="plantel_contrato2_id-field">Plantel contrato 2</label>
                          {!! Form::select("plantel_contrato2_id", $list["Plantel"], isset($empleado->plantel_contrato2_id) ? $empleado->plantel_contrato2_id : null, array("class" => "form-control select_seguridad", "id" => "plantel_contrato2_id-field")) !!}
                          @if($errors->has("plantel_contrato2_id"))
                            <span class="help-block">{{ $errors->first("plantel_contrato2_id") }}</span>
                          @endif
                        </div>
                        <div class="form-group col-md-2 @if($errors->has('tipo_contrato2_id')) has-error @endif" >
                          <label for="tipo_contrato2_id-field">Tipo Contrato</label>
                          {!! Form::select("tipo_contrato2_id", $tipoContratos, isset($empleado->tipo_contrato2_id) ? $empleado->tipo_contrato2_id : null, array("class" => "form-control select_seguridad", "id" => "tipo_contrato2_id-field")) !!}
                          @if($errors->has("tipo_contrato2_id"))
                            <span class="help-block">{{ $errors->first("tipo_contrato2_id") }}</span>
                          @endif
                        </div>
                        <div class="form-group col-md-2 @if($errors->has('fec_inicio_contrato2')) has-error @endif">
                          <label for="fec_inicio_contrato2-field">Inicio Contrato</label>
                          {!! Form::text("fec_inicio_contrato2", null, array("class" => "form-control input-sm fecha", "id" => "fec_inicio_contrato2-field")) !!}
                          @if($errors->has("fec_inicio_contrato2"))
                            <span class="help-block">{{ $errors->first("fec_inicio_contrato2") }}</span>
                          @endif
                        </div>
                        <div class="form-group col-md-2 @if($errors->has('fec_fin_contrato2')) has-error @endif">
                          <label for="fec_fin_contrato2-field">Fin Contrato</label>
                          {!! Form::text("fec_fin_contrato2", null, array("class" => "form-control input-sm fecha", "id" => "fec_fin_contrato2-field")) !!}
                          @if($errors->has("fec_fin_contrato2"))
                            <span class="help-block">{{ $errors->first("fec_fin_contrato2") }}</span>
                          @endif
                        </div>

                        <div class="form-group col-md-3 @if($errors->has('resp_alerta2_id')) has-error @endif">
                          <label for="resp_alerta_id2-field">Reponsable</label>
                          {!! Form::select("resp_alerta2_id", $responsables, null, array("class" => "form-control select_seguridad", "id" => "resp_alerta2_id-field")) !!}
                          @if($errors->has("resp_alerta2_id"))
                            <span class="help-block">{{ $errors->first("resp_alerta2_id") }}</span>
                          @endif
                        </div>

                        <div class="form-group col-md-3 @if($errors->has('plantel_contrato3_id')) has-error @endif" style="clear:left;">
                          <label for="plantel_contrato3_id-field">Plantel contrato 3</label>
                          {!! Form::select("plantel_contrato3_id", $list["Plantel"], isset($empleado->plantel_contrato3_id) ? $empleado->plantel_contrato3_id : null, array("class" => "form-control select_seguridad", "id" => "plantel_contrato3_id-field")) !!}
                          @if($errors->has("plantel_contrato3_id"))
                            <span class="help-block">{{ $errors->first("plantel_contrato3_id") }}</span>
                          @endif
                        </div>
                        <div class="form-group col-md-2 @if($errors->has('tipo_contrato3_id')) has-error @endif" >
                          <label for="tipo_contrato3_id-field">Tipo Contrato</label>
                          {!! Form::select("tipo_contrato3_id", $tipoContratos, isset($empleado->tipo_contrato3_id) ? $empleado->tipo_contrato3_id : null, array("class" => "form-control select_seguridad", "id" => "tipo_contrato3_id-field")) !!}
                          @if($errors->has("tipo_contrato3_id"))
                            <span class="help-block">{{ $errors->first("tipo_contrato3_id") }}</span>
                          @endif
                        </div>
                        <div class="form-group col-md-2 @if($errors->has('fec_inicio_contrato3')) has-error @endif">
                          <label for="fec_inicio_contrato3-field">Inicio Contrato</label>
                          {!! Form::text("fec_inicio_contrato3", null, array("class" => "form-control input-sm fecha", "id" => "fec_inicio_contrato3-field")) !!}
                          @if($errors->has("fec_inicio_contrato3"))
                            <span class="help-block">{{ $errors->first("fec_inicio_contrato3") }}</span>
                          @endif
                        </div>
                        <div class="form-group col-md-2 @if($errors->has('fec_fin_contrato3')) has-error @endif">
                          <label for="fec_fin_contrato3-field">Fin Contrato</label>
                          {!! Form::text("fec_fin_contrato3", null, array("class" => "form-control input-sm fecha", "id" => "fec_fin_contrato3-field")) !!}
                          @if($errors->has("fec_fin_contrato3"))
                            <span class="help-block">{{ $errors->first("fec_fin_contrato3") }}</span>
                          @endif
                        </div>

                        <div class="form-group col-md-3 @if($errors->has('resp_alerta3_id')) has-error @endif">
                          <label for="resp_alerta_id3-field">Reponsable</label>
                          {!! Form::select("resp_alerta3_id", $responsables, null, array("class" => "form-control select_seguridad", "id" => "resp_alerta3_id-field")) !!}
                          @if($errors->has("resp_alerta3_id"))
                            <span class="help-block">{{ $errors->first("resp_alerta3_id") }}</span>
                          @endif
                        </div>
                      </div>
                    </div>
                    @endpermission

                    @permission('empleados.verDocumentos')
                    @if(isset($empleado))
                    <div class="box box-default">
                      <div class="box-body">
                        <div class="form-group col-md-6 @if($errors->has('doc_empleado_id')) has-error @endif">
                          <label for="doc_empleado_id-field">Documento</label>
                          {!! Form::select("doc_empleado_id", $list1["DocEmpleado"], null, array("class" => "form-control select_seguridad", "id" => "doc_empleado_id-field")) !!}
                          @if($errors->has("doc_empleado_id"))
                            <span class="help-block">{{ $errors->first("doc_empleado_id") }}</span>
                          @endif
                        </div>
<!--                        <div class="form-group col-md-6 @if($errors->has('archivo')) has-error @endif">
                          <button type="button" onclick="BrowseServer('archivo-field');">Elegir Archivo</button>
                          {!! Form::text("archivo", null, array("class" => "form-control input-sm", "id" => "archivo-field")) !!}
                          @if($errors->has("archivo"))
                            <span class="help-block">{{ $errors->first("archivo") }}</span>
                          @endif
                        </div>-->
                        <div class="form-group col-md-6">
                                <div class="btn btn-default btn-file">
                                    <i class="fa fa-paperclip"></i> Adjuntar Archivo
                                    <input type="file"  id="file" name="file" class="empleado_archivo" >
                                    <input type="hidden" name="_token" id="_token"  value="<?= csrf_token(); ?>"> 
                                    <input type="hidden"  id="file_hidden" name="file_hidden" >
                                </div>
                                @permission('empleados.cargarImg')
                                <button class="btn btn-success btn-xs" id="btn_archivo"> <span class="glyphicon glyphicon-ok">Cargar</span> </btn>
                                @endpermission
                                <br/>
                                <p class="help-block"  >Max. 20MB</p>
                                <div id="texto_notificacion">
                                    
                                </div>
                            </div>
                        
                        <div class="form-group col-md-6">
                          <table class="table table-condensed table-striped">
                            <thead>
                              <tr>
                                <th>Documento Agregados</th><th>Link</th><th></th>
                              </tr>
                            </thead>
                            <tbody>
                              @foreach($empleado->pivotDocEmpleado as $doc)
                              <tr>
                                <td>
                                  {{$doc->docEmpleado->name}}
                                </td>
                                <td>
                                  @php
                                  $cadena_img = "";
                  
                                        $cadena_img = explode('/', $doc->archivo);
                                        
                                  @endphp
                                  <a href="{{asset("imagenes/empleados/".$empleado->id."/".end($cadena_img))}}" target="_blank">Ver</a>
                                </td>
                                <td>
                                  @permission('pivotDocEmpleados.destroy')
                                  <a class="btn btn-xs btn-danger" href="{{route('pivotDocEmpleados.destroy', $doc->id)}}">Eliminar</a>
                                  @endpermission
                                </td>
                              </tr>
                              @endforeach
                            </tbody>
                          </table>
                        </div>
                        <div class="form-group col-md-6">
                          <table class="table table-condensed table-striped">
                            <thead>
                              <tr>
                                <th>Documentos Faltantes</th><th>Obligatorio</th>
                              </tr>
                            </thead>
                            <tbody>
                              @foreach($documentos_faltantes as $df)
                              <tr>
                                <td>
                                  {{ $df->name }}
                                </td>
                                <td>
                                  @if($df->doc_obligatorio == 1)
                                    <button class="btn btn-success btn-xs"><span class="glyphicon glyphicon-ok"></span></button>
                                  @else
                                    @if($empleado->extranjero_bnd==1 and $df->id==18)
                                      <button class="btn btn-success btn-xs"><span class="glyphicon glyphicon-ok"></span></button>
                                    @elseif($empleado->alimenticia_bnd==1 and $df->id==17)
                                      <button class="btn btn-success btn-xs"><span class="glyphicon glyphicon-ok"></span></button>
                                    @elseif($empleado->genero==1 and $df->id==14)
                                      <button class="btn btn-success btn-xs"><span class="glyphicon glyphicon-ok"></span></button>
                                    @else
                                      <button class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-remove"></span></button>
                                    @endif
                                    
                                  @endif
                                </td>
                                
                              </tr>
                              @endforeach
                            </tbody>
                          </table>
                        </div>
                      </div>
                    </div>
                    @endif
                    @endpermission
@push('scripts')
<script src="{{ asset ('/bower_components/AdminLTE/plugins/tinymce/js/tinymce/tinymce.min.js') }}"></script>
<script src="{{ asset ('/bower_components/AdminLTE/plugins/tinymce/js/tinymce/tinymce_editor.js') }}"></script>
<script type="text/javascript">

$(document).ready(function() {
  $('#seleccionar_planteles').change(function(){
    if( $(this).is(':checked') ) {
      $("#plantel_id-field > option").prop("selected","selected");
            $("#plantel_id-field").trigger("change");
    }else{
      $("#plantel_id-field > option").prop("selected","selected");
            $('#plantel_id-field').val(null).trigger('change');
    }
  });

  @permission('empleados.editarPlanteles')
  $("#frm_empleado").find(':input').each(function() {   
         $(this).prop('readonly',true);
         $('#plantel_id-field').prop('readonly',false);
         $('#seleccionar_planteles').prop('readonly',false);
         $('.btn').prop('readonly',false);
         $("#plantel_id-field").trigger("change");
         //$('#_token').prop('readonly',false);
         //$('#file_hidden').prop('readonly',false);
         
      });
  @endpermission
});
  



  $('#fin_contrato-field').Zebra_DatePicker({
        days:['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'],
        months:['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
        readonly_element: false,
        lang_clear_date: 'Limpiar',
        show_select_today: 'Hoy',
      });
  $('#user_id-field').select2({
    placeholder: 'Enter a tag',
    ajax: {
        dataType: 'json',
        url: '{{ route("empleados.usuarios") }}',
        delay: 400,
        data: function(params) {
            return {
                term: params.term
            }
        },
        processResults: function (data, page) {
          return {
            results: data
          };
        },
    }
  });

    //codigo de trabajo del cargador de imagenes
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
     
     
     $(document).on("click", "#btn_archivo", function (e) {
        e.preventDefault();
        if($('#doc_empleado_id-field option:selected').val()==0){
            alert("Elegir Documento para Cargar");
        }
        var miurl = "{{route('empleados.cargarImg')}}";
        // var fileup=$("#file").val();
        var divresul = "texto_notificacion";

        var data = new FormData();
        data.append('file', $('#file')[0].files[0]);
        data.append('doc_empleado_id', $('#doc_empleado_id-field option:selected').val());
        @if(isset($empleado))
        data.append('empleado', {{$empleado->id}});
        @endif

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
                $("#" + divresul + "").html($("#cargador_empresa").html());
            },
            //una vez finalizado correctamente
            success: function (data) {
                if (confirm('¿Deseas Actualizar la Página?')){
                    location.reload();
                }
                
            },
            //si ha ocurrido un error
            error: function (data) {
                

            }
        });
    }) 
    
</script>

@endpush