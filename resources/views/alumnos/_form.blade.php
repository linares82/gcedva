                
                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs">
                            <li class="active">
                                <a data-toggle="tab" href="#tab1">Alumno</a>
                            </li>
                            <li class="">
                                <a data-toggle="tab" href="#tab2">Datos Escolares</a>
                            </li>
                            <li class="">
                                <a data-toggle="tab" href="#tab3">Padre</a>
                            </li>
                            <li class="">
                                <a data-toggle="tab" href="#tab4">Madre</a>
                            </li>
                            <li class="">
                                <a data-toggle="tab" href="#tab5">Acudiente</a>
                            </li>
                            <li class="">
                                <a data-toggle="tab" href="#tab7">Documentos</a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div id="tab1" class="tab-pane active">
                                <fieldset>
                                <div class="form-group col-md-4 @if($errors->has('matricula')) has-error @endif">
                                <label for="matricula-field">Matricula</label>
                                {!! Form::text("matricula", null, array("class" => "form-control", "id" => "matricula-field")) !!}
                                @if($errors->has("matricula"))
                                    <span class="help-block">{{ $errors->first("matricula") }}</span>
                                @endif
                                </div>
                                <div class="form-group col-md-4 @if($errors->has('cve_alumno')) has-error @endif">
                                <label for="cve_alumno-field">Clave Alumno</label>
                                {!! Form::text("cve_alumno", null, array("class" => "form-control", "id" => "cve_alumno-field")) !!}
                                @if($errors->has("cve_alumno"))
                                    <span class="help-block">{{ $errors->first("cve_alumno") }}</span>
                                @endif
                                </div>
                                <div class="form-group col-md-4 @if($errors->has('nombre')) has-error @endif">
                                <label for="nombre-field">Primer Nombre</label>
                                {!! Form::text("nombre", null, array("class" => "form-control", "id" => "nombre-field")) !!}
                                @if($errors->has("nombre"))
                                    <span class="help-block">{{ $errors->first("nombre") }}</span>
                                @endif
                                </div>
                                <div class="form-group col-md-4 @if($errors->has('nombre2')) has-error @endif">
                                <label for="nombre2-field">Segundo Nombre</label>
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
                                <div class="form-group col-md-4 @if($errors->has('genero')) has-error @endif">
                                <label for="genero-field">Genero</label>
                                {!! Form::text("genero", null, array("class" => "form-control", "id" => "genero-field")) !!}
                                @if($errors->has("genero"))
                                    <span class="help-block">{{ $errors->first("genero") }}</span>
                                @endif
                                </div>
                                <div class="form-group col-md-4 @if($errors->has('curp')) has-error @endif">
                                <label for="curp-field">CURP</label>
                                {!! Form::text("curp", null, array("class" => "form-control", "id" => "curp-field")) !!}
                                @if($errors->has("curp"))
                                    <span class="help-block">{{ $errors->first("curp") }}</span>
                                @endif
                                </div>
                                <div class="form-group col-md-4 @if($errors->has('fec_nacimiento')) has-error @endif">
                                <label for="fec_nacimiento-field">F. Nacimiento</label>
                                {!! Form::text("fec_nacimiento", null, array("class" => "form-control", "id" => "fec_nacimiento-field")) !!}
                                @if($errors->has("fec_nacimiento"))
                                    <span class="help-block">{{ $errors->first("fec_nacimiento") }}</span>
                                @endif
                                </div>
                                <div class="form-group col-md-4 @if($errors->has('lugar_nacimiento')) has-error @endif">
                                <label for="lugar_nacimiento-field">Lugar Nacimiento</label>
                                {!! Form::text("lugar_nacimiento", null, array("class" => "form-control", "id" => "lugar_nacimiento-field")) !!}
                                @if($errors->has("lugar_nacimiento"))
                                    <span class="help-block">{{ $errors->first("lugar_nacimiento") }}</span>
                                @endif
                                </div>
                                <div class="form-group col-md-4 @if($errors->has('extranjero')) has-error @endif">
                                <label for="extranjero-field">Extranjero</label>
                                {!! Form::text("extranjero", null, array("class" => "form-control", "id" => "extranjero-field")) !!}
                                @if($errors->has("extranjero"))
                                    <span class="help-block">{{ $errors->first("extranjero") }}</span>
                                @endif
                                </div>
                                
                                <div class="form-group col-md-4 @if($errors->has('tel_fijo')) has-error @endif">
                                <label for="tel_fijo-field">Teléfono Fijo</label>
                                {!! Form::text("tel_fijo", null, array("class" => "form-control", "id" => "tel_fijo-field")) !!}
                                @if($errors->has("tel_fijo"))
                                    <span class="help-block">{{ $errors->first("tel_fijo") }}</span>
                                @endif
                                </div>
                                <div class="form-group col-md-4 @if($errors->has('tel_cel')) has-error @endif">
                                <label for="tel_cel-field">Teléfono Celular</label>
                                {!! Form::text("tel_cel", null, array("class" => "form-control", "id" => "tel_cel-field")) !!}
                                @if($errors->has("tel_cel"))
                                    <span class="help-block">{{ $errors->first("tel_cel") }}</span>
                                @endif
                                </div>
                                <div class="form-group col-md-4 @if($errors->has('cel_empresa')) has-error @endif">
                                <label for="cel_empresa-field">Celular Empresa</label>
                                {!! Form::text("cel_empresa", null, array("class" => "form-control", "id" => "cel_empresa-field")) !!}
                                @if($errors->has("cel_empresa"))
                                    <span class="help-block">{{ $errors->first("cel_empresa") }}</span>
                                @endif
                                </div>
                                <div class="form-group col-md-4 @if($errors->has('mail')) has-error @endif">
                                <label for="mail-field">Correo Electrónico</label>
                                {!! Form::text("mail", null, array("class" => "form-control", "id" => "mail-field")) !!}
                                @if($errors->has("mail"))
                                    <span class="help-block">{{ $errors->first("mail") }}</span>
                                @endif
                                </div>
                                <div class="form-group col-md-4 @if($errors->has('mail_empresa')) has-error @endif">
                                <label for="mail_empresa-field">Correo Electrónico Trabajo</label>
                                {!! Form::text("mail_empresa", null, array("class" => "form-control", "id" => "mail_empresa-field")) !!}
                                @if($errors->has("mail_empresa"))
                                    <span class="help-block">{{ $errors->first("mail_empresa") }}</span>
                                @endif
                                </div>
                                <div class="form-group col-md-4 @if($errors->has('calle')) has-error @endif">
                                <label for="calle-field">Calle</label>
                                {!! Form::text("calle", null, array("class" => "form-control", "id" => "calle-field")) !!}
                                @if($errors->has("calle"))
                                    <span class="help-block">{{ $errors->first("calle") }}</span>
                                @endif
                                </div>
                                <div class="form-group col-md-4 @if($errors->has('no_interior')) has-error @endif">
                                <label for="no_interior-field">No. Interior</label>
                                {!! Form::text("no_interior", null, array("class" => "form-control", "id" => "no_interior-field")) !!}
                                @if($errors->has("no_interior"))
                                    <span class="help-block">{{ $errors->first("no_interior") }}</span>
                                @endif
                                </div>
                                <div class="form-group col-md-4 @if($errors->has('no_exterior')) has-error @endif">
                                <label for="no_exterior-field">No. Exterior</label>
                                {!! Form::text("no_exterior", null, array("class" => "form-control", "id" => "no_exterior-field")) !!}
                                @if($errors->has("no_exterior"))
                                    <span class="help-block">{{ $errors->first("no_exterior") }}</span>
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
                                <div class="form-group col-md-4 @if($errors->has('municipio_id')) has-error @endif">
                                <label for="municipio_id-field">Municipio</label>
                                {!! Form::select("municipio_id", $list["Municipio"], null, array("class" => "form-control select_seguridad", "id" => "municipio_id-field", 'style'=>'width:100%')) !!}
                                @if($errors->has("municipio_id"))
                                    <span class="help-block">{{ $errors->first("municipio_id") }}</span>
                                @endif
                                </div>
                                <div class="form-group col-md-4 @if($errors->has('estado_id')) has-error @endif">
                                <label for="estado_id-field">Estado</label>
                                {!! Form::select("estado_id", $list["Estado"], null, array("class" => "form-control select_seguridad", "id" => "estado_id-field", 'style'=>'width:100%')) !!}
                                @if($errors->has("estado_id"))
                                    <span class="help-block">{{ $errors->first("estado_id") }}</span>
                                @endif
                                </div>
                                <div class="form-group col-md-4 @if($errors->has('st_cliente_id')) has-error @endif">
                                <label for="st_cliente_id-field">Estatus</label>
                                {!! Form::select("st_cliente_id", $list["StCliente"], null, array("class" => "form-control select_seguridad", "id" => "st_cliente_id-field", 'style'=>'width:100%')) !!}
                                @if($errors->has("st_cliente_id"))
                                    <span class="help-block">{{ $errors->first("st_cliente_id") }}</span>
                                @endif
                                </div>
                                <div class="form-group col-md-4 @if($errors->has('distancia_escuela')) has-error @endif">
                                <label for="distancia_escuela-field">Distancia Escuela</label>
                                {!! Form::text("distancia_escuela", null, array("class" => "form-control", "id" => "distancia_escuela-field")) !!}
                                @if($errors->has("distancia_escuela"))
                                    <span class="help-block">{{ $errors->first("distancia_escuela") }}</span>
                                @endif
                                </div>
                                <div class="form-group col-md-4 @if($errors->has('peso')) has-error @endif">
                                <label for="peso-field">Peso</label>
                                {!! Form::text("peso", null, array("class" => "form-control", "id" => "peso-field")) !!}
                                @if($errors->has("peso"))
                                    <span class="help-block">{{ $errors->first("peso") }}</span>
                                @endif
                                </div>
                                <div class="form-group col-md-4 @if($errors->has('estatura')) has-error @endif">
                                <label for="estatura-field">Estatura</label>
                                {!! Form::text("estatura", null, array("class" => "form-control", "id" => "estatura-field")) !!}
                                @if($errors->has("estatura"))
                                    <span class="help-block">{{ $errors->first("estatura") }}</span>
                                @endif
                                </div>
                                <div class="form-group col-md-4 @if($errors->has('tipo_sangre')) has-error @endif">
                                <label for="tipo_sangre-field">Tipo Sangre</label>
                                {!! Form::text("tipo_sangre", null, array("class" => "form-control", "id" => "tipo_sangre-field")) !!}
                                @if($errors->has("tipo_sangre"))
                                    <span class="help-block">{{ $errors->first("tipo_sangre") }}</span>
                                @endif
                                </div>
                                <div class="form-group col-md-4 @if($errors->has('alergias')) has-error @endif">
                                <label for="alergias-field">Alergias</label>
                                {!! Form::text("alergias", null, array("class" => "form-control", "id" => "alergias-field")) !!}
                                @if($errors->has("alergias"))
                                    <span class="help-block">{{ $errors->first("alergias") }}</span>
                                @endif
                                </div>
                                <div class="form-group col-md-4 @if($errors->has('medicinas_contraindicadas')) has-error @endif">
                                <label for="medicinas_contraindicadas-field">Medicinas Contraindicadas</label>
                                {!! Form::text("medicinas_contraindicadas", null, array("class" => "form-control", "id" => "medicinas_contraindicadas-field")) !!}
                                @if($errors->has("medicinas_contraindicadas"))
                                    <span class="help-block">{{ $errors->first("medicinas_contraindicadas") }}</span>
                                @endif
                                </div>
                                <div class="form-group col-md-4 @if($errors->has('color_piel')) has-error @endif">
                                <label for="color_piel-field">Color Piel</label>
                                {!! Form::text("color_piel", null, array("class" => "form-control", "id" => "color_piel-field")) !!}
                                @if($errors->has("color_piel"))
                                    <span class="help-block">{{ $errors->first("color_piel") }}</span>
                                @endif
                                </div>
                                <div class="form-group col-md-4 @if($errors->has('color_cabello')) has-error @endif">
                                <label for="color_cabello-field">Color Cabello</label>
                                {!! Form::text("color_cabello", null, array("class" => "form-control", "id" => "color_cabello-field")) !!}
                                @if($errors->has("color_cabello"))
                                    <span class="help-block">{{ $errors->first("color_cabello") }}</span>
                                @endif
                                </div>
                                <div class="form-group col-md-4 @if($errors->has('senas_particulares')) has-error @endif">
                                <label for="senas_particulares-field">Señas Particulares</label>
                                {!! Form::text("senas_particulares", null, array("class" => "form-control", "id" => "senas_particulares-field")) !!}
                                @if($errors->has("senas_particulares"))
                                    <span class="help-block">{{ $errors->first("senas_particulares") }}</span>
                                @endif
                                </div>
                                </fieldset>
                            </div>
                            <div id="tab2" class="tab-pane">
                                <fieldset>
                                <div class="form-group col-md-4 @if($errors->has('fec_inscripcion')) has-error @endif">
                                <label for="fec_inscripcion-field">F. Inscripcion</label>
                                {!! Form::text("fec_inscripcion", null, array("class" => "form-control", "id" => "fec_inscripcion-field")) !!}
                                @if($errors->has("fec_inscripcion"))
                                    <span class="help-block">{{ $errors->first("fec_inscripcion") }}</span>
                                @endif
                                </div>
                                <div class="form-group col-md-4 @if($errors->has('plantel_id')) has-error @endif">
                                <label for="plantel_id-field">Plantel</label>
                                {!! Form::select("plantel_id", $list["Plantel"], null, array("class" => "form-control select_seguridad", "id" => "plantel_id-field", 'style'=>'width:100%')) !!}
                                @if($errors->has("plantel_id"))
                                    <span class="help-block">{{ $errors->first("plantel_id") }}</span>
                                @endif
                                </div>
                                <div class="form-group col-md-4 @if($errors->has('especialidad_id')) has-error @endif">
                                <label for="especialidad_id-field">Especialidad</label>
                                {!! Form::select("especialidad_id", $list["Especialidad"], null, array("class" => "form-control select_seguridad", "id" => "especialidad_id-field", 'style'=>'width:100%')) !!}
                                @if($errors->has("especialidad_id"))
                                    <span class="help-block">{{ $errors->first("especialidad_id") }}</span>
                                @endif
                                </div>
                                <div class="form-group col-md-4 @if($errors->has('nivel_id')) has-error @endif">
                                <label for="nivel_id-field">Nivel</label>
                                {!! Form::select("nivel_id", $list["Nivel"], null, array("class" => "form-control select_seguridad", "id" => "nivel_id-field", 'style'=>'width:100%')) !!}
                                @if($errors->has("nivel_id"))
                                    <span class="help-block">{{ $errors->first("nivel_id") }}</span>
                                @endif
                                </div>
                                <div class="form-group col-md-4 @if($errors->has('grado_id')) has-error @endif">
                                <label for="grado_id-field">Grado</label>
                                {!! Form::select("grado_id", $list["Grado"], null, array("class" => "form-control select_seguridad", "id" => "grado_id-field", 'style'=>'width:100%')) !!}
                                @if($errors->has("grado_id"))
                                    <span class="help-block">{{ $errors->first("grado_id") }}</span>
                                @endif
                                </div>
            
                                </fieldset>
                            </div>
                            <div id="tab3" class="tab-pane">
                                <fieldset>
                                <div class="form-group col-md-4 @if($errors->has('nombre_padre')) has-error @endif">
                                <label for="nombre_padre-field">Nombre Completo</label>
                                {!! Form::text("nombre_padre", null, array("class" => "form-control", "id" => "nombre_padre-field")) !!}
                                @if($errors->has("nombre_padre"))
                                    <span class="help-block">{{ $errors->first("nombre_padre") }}</span>
                                @endif
                                </div>
                                <div class="form-group col-md-4 @if($errors->has('curp_padre')) has-error @endif">
                                <label for="curp_padre-field">CURP</label>
                                {!! Form::text("curp_padre", null, array("class" => "form-control", "id" => "curp_padre-field")) !!}
                                @if($errors->has("curp_padre"))
                                    <span class="help-block">{{ $errors->first("curp_padre") }}</span>
                                @endif
                                </div>
                                <div class="form-group col-md-4 @if($errors->has('dir_padre')) has-error @endif">
                                <label for="dir_padre-field">Dirección</label>
                                {!! Form::text("dir_padre", null, array("class" => "form-control", "id" => "dir_padre-field")) !!}
                                @if($errors->has("dir_padre"))
                                    <span class="help-block">{{ $errors->first("dir_padre") }}</span>
                                @endif
                                </div>
                                <div class="form-group col-md-4 @if($errors->has('tel_padre')) has-error @endif">
                                <label for="tel_padre-field">Teléfono Fijo</label>
                                {!! Form::text("tel_padre", null, array("class" => "form-control", "id" => "tel_padre-field")) !!}
                                @if($errors->has("tel_padre"))
                                    <span class="help-block">{{ $errors->first("tel_padre") }}</span>
                                @endif
                                </div>
                                <div class="form-group col-md-4 @if($errors->has('cel_padre')) has-error @endif">
                                <label for="cel_padre-field">Teléfono Celular</label>
                                {!! Form::text("cel_padre", null, array("class" => "form-control", "id" => "cel_padre-field")) !!}
                                @if($errors->has("cel_padre"))
                                    <span class="help-block">{{ $errors->first("cel_padre") }}</span>
                                @endif
                                </div>
                                <div class="form-group col-md-4 @if($errors->has('tel_ofi_padre')) has-error @endif">
                                <label for="tel_ofi_padre-field">Teléfono Trabajo</label>
                                {!! Form::text("tel_ofi_padre", null, array("class" => "form-control", "id" => "tel_ofi_padre-field")) !!}
                                @if($errors->has("tel_ofi_padre"))
                                    <span class="help-block">{{ $errors->first("tel_ofi_padre") }}</span>
                                @endif
                                </div>
                                <div class="form-group col-md-4 @if($errors->has('mail_padre')) has-error @endif">
                                <label for="mail_padre-field">Correo Electrónico</label>
                                {!! Form::text("mail_padre", null, array("class" => "form-control", "id" => "mail_padre-field")) !!}
                                @if($errors->has("mail_padre"))
                                    <span class="help-block">{{ $errors->first("mail_padre") }}</span>
                                @endif
                                </div>
                            </div>
                            <div id="tab4" class="tab-pane">
                                <fieldset>
                                <div class="form-group col-md-4 @if($errors->has('nombre_madre')) has-error @endif">
                                <label for="nombre_madre-field">Nombre Completo </label>
                                {!! Form::text("nombre_madre", null, array("class" => "form-control", "id" => "nombre_madre-field")) !!}
                                @if($errors->has("nombre_madre"))
                                    <span class="help-block">{{ $errors->first("nombre_madre") }}</span>
                                @endif
                                </div>
                                <div class="form-group col-md-4 @if($errors->has('curp_madre')) has-error @endif">
                                <label for="curp_madre-field">CURP</label>
                                {!! Form::text("curp_madre", null, array("class" => "form-control", "id" => "curp_madre-field")) !!}
                                @if($errors->has("curp_madre"))
                                    <span class="help-block">{{ $errors->first("curp_madre") }}</span>
                                @endif
                                </div>
                                <div class="form-group col-md-4 @if($errors->has('dir_madre')) has-error @endif">
                                <label for="dir_madre-field">Dirección</label>
                                {!! Form::text("dir_madre", null, array("class" => "form-control", "id" => "dir_madre-field")) !!}
                                @if($errors->has("dir_madre"))
                                    <span class="help-block">{{ $errors->first("dir_madre") }}</span>
                                @endif
                                </div>
                                <div class="form-group col-md-4 @if($errors->has('tel_madre')) has-error @endif">
                                <label for="tel_madre-field">Teléfono Fijo</label>
                                {!! Form::text("tel_madre", null, array("class" => "form-control", "id" => "tel_madre-field")) !!}
                                @if($errors->has("tel_madre"))
                                    <span class="help-block">{{ $errors->first("tel_madre") }}</span>
                                @endif
                                </div>
                                <div class="form-group col-md-4 @if($errors->has('cel_madre')) has-error @endif">
                                <label for="cel_madre-field">Teléfono Celular</label>
                                {!! Form::text("cel_madre", null, array("class" => "form-control", "id" => "cel_madre-field")) !!}
                                @if($errors->has("cel_madre"))
                                    <span class="help-block">{{ $errors->first("cel_madre") }}</span>
                                @endif
                                </div>
                                <div class="form-group col-md-4 @if($errors->has('tel_ofi_madre')) has-error @endif">
                                <label for="tel_ofi_madre-field">Teléfono Trabajo</label>
                                {!! Form::text("tel_ofi_madre", null, array("class" => "form-control", "id" => "tel_ofi_madre-field")) !!}
                                @if($errors->has("tel_ofi_madre"))
                                    <span class="help-block">{{ $errors->first("tel_ofi_madre") }}</span>
                                @endif
                                </div>
                                <div class="form-group col-md-4 @if($errors->has('mail_madre')) has-error @endif">
                                <label for="mail_madre-field">Correo Electrónico</label>
                                {!! Form::text("mail_madre", null, array("class" => "form-control", "id" => "mail_madre-field")) !!}
                                @if($errors->has("mail_madre"))
                                    <span class="help-block">{{ $errors->first("mail_madre") }}</span>
                                @endif
                                </div>
                                </fieldset>
                            </div>
                            <div id="tab5" class="tab-pane">
                                <fieldset>
                                <div class="form-group col-md-4 @if($errors->has('nombre_acudiente')) has-error @endif">
                                <label for="nombre_acudiente-field">Nombre Completo</label>
                                {!! Form::text("nombre_acudiente", null, array("class" => "form-control", "id" => "nombre_acudiente-field")) !!}
                                @if($errors->has("nombre_acudiente"))
                                    <span class="help-block">{{ $errors->first("nombre_acudiente") }}</span>
                                @endif
                                </div>
                                <div class="form-group col-md-4 @if($errors->has('curp_acudiente')) has-error @endif">
                                <label for="curp_acudiente-field">CURP</label>
                                {!! Form::text("curp_acudiente", null, array("class" => "form-control", "id" => "curp_acudiente-field")) !!}
                                @if($errors->has("curp_acudiente"))
                                    <span class="help-block">{{ $errors->first("curp_acudiente") }}</span>
                                @endif
                                </div>
                                <div class="form-group col-md-4 @if($errors->has('dir_acudiente')) has-error @endif">
                                <label for="dir_acudiente-field">Dirrección</label>
                                {!! Form::text("dir_acudiente", null, array("class" => "form-control", "id" => "dir_acudiente-field")) !!}
                                @if($errors->has("dir_acudiente"))
                                    <span class="help-block">{{ $errors->first("dir_acudiente") }}</span>
                                @endif
                                </div>
                                <div class="form-group col-md-4 @if($errors->has('tel_acudiente')) has-error @endif">
                                <label for="tel_acudiente-field">Teléfono Fijo</label>
                                {!! Form::text("tel_acudiente", null, array("class" => "form-control", "id" => "tel_acudiente-field")) !!}
                                @if($errors->has("tel_acudiente"))
                                    <span class="help-block">{{ $errors->first("tel_acudiente") }}</span>
                                @endif
                                </div>
                                <div class="form-group col-md-4 @if($errors->has('cel_acudiente')) has-error @endif">
                                <label for="cel_acudiente-field">Teléfono Celular</label>
                                {!! Form::text("cel_acudiente", null, array("class" => "form-control", "id" => "cel_acudiente-field")) !!}
                                @if($errors->has("cel_acudiente"))
                                    <span class="help-block">{{ $errors->first("cel_acudiente") }}</span>
                                @endif
                                </div>
                                <div class="form-group col-md-4 @if($errors->has('tel_ofi_acudiente')) has-error @endif">
                                <label for="tel_ofi_acudiente-field">Teléfono Trabajo</label>
                                {!! Form::text("tel_ofi_acudiente", null, array("class" => "form-control", "id" => "tel_ofi_acudiente-field")) !!}
                                @if($errors->has("tel_ofi_acudiente"))
                                    <span class="help-block">{{ $errors->first("tel_ofi_acudiente") }}</span>
                                @endif
                                </div>
                                <div class="form-group col-md-4 @if($errors->has('mail_acudiente')) has-error @endif">
                                <label for="mail_acudiente-field">Correo Electrónico</label>
                                {!! Form::text("mail_acudiente", null, array("class" => "form-control", "id" => "mail_acudiente-field")) !!}
                                @if($errors->has("mail_acudiente"))
                                    <span class="help-block">{{ $errors->first("mail_acudiente") }}</span>
                                @endif
                                </div>
                                </fieldset>
                            </div>
                        </div>
                    </div>
                                       
                    