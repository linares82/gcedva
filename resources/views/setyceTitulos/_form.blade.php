                <div class="form-group @if($errors->has('setyce_lote_id')) has-error @endif">
                       <label for="setyce_lote_id-field">Setyce_lote_id</label>
                       {!! Form::text("setyce_lote_id", null, array("class" => "form-control", "id" => "setyce_lote_id-field")) !!}
                       @if($errors->has("setyce_lote_id"))
                        <span class="help-block">{{ $errors->first("setyce_lote_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('cliente_id')) has-error @endif">
                       <label for="cliente_id-field">Cliente_id</label>
                       {!! Form::text("cliente_id", null, array("class" => "form-control", "id" => "cliente_id-field")) !!}
                       @if($errors->has("cliente_id"))
                        <span class="help-block">{{ $errors->first("cliente_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('carrera')) has-error @endif">
                       <label for="carrera-field">Carrera</label>
                       {!! Form::text("carrera", null, array("class" => "form-control", "id" => "carrera-field")) !!}
                       @if($errors->has("carrera"))
                        <span class="help-block">{{ $errors->first("carrera") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('fecha_inicio')) has-error @endif">
                       <label for="fecha_inicio-field">Fecha_inicio</label>
                       {!! Form::text("fecha_inicio", null, array("class" => "form-control", "id" => "fecha_inicio-field")) !!}
                       @if($errors->has("fecha_inicio"))
                        <span class="help-block">{{ $errors->first("fecha_inicio") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('fechat_terminacion')) has-error @endif">
                       <label for="fechat_terminacion-field">Fechat_terminacion</label>
                       {!! Form::text("fechat_terminacion", null, array("class" => "form-control", "id" => "fechat_terminacion-field")) !!}
                       @if($errors->has("fechat_terminacion"))
                        <span class="help-block">{{ $errors->first("fechat_terminacion") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('folio')) has-error @endif">
                       <label for="folio-field">Folio</label>
                       {!! Form::text("folio", null, array("class" => "form-control", "id" => "folio-field")) !!}
                       @if($errors->has("folio"))
                        <span class="help-block">{{ $errors->first("folio") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('curp')) has-error @endif">
                       <label for="curp-field">Curp</label>
                       {!! Form::text("curp", null, array("class" => "form-control", "id" => "curp-field")) !!}
                       @if($errors->has("curp"))
                        <span class="help-block">{{ $errors->first("curp") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('nombre')) has-error @endif">
                       <label for="nombre-field">Nombre</label>
                       {!! Form::text("nombre", null, array("class" => "form-control", "id" => "nombre-field")) !!}
                       @if($errors->has("nombre"))
                        <span class="help-block">{{ $errors->first("nombre") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('primer_apellido')) has-error @endif">
                       <label for="primer_apellido-field">Primer_apellido</label>
                       {!! Form::text("primer_apellido", null, array("class" => "form-control", "id" => "primer_apellido-field")) !!}
                       @if($errors->has("primer_apellido"))
                        <span class="help-block">{{ $errors->first("primer_apellido") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('segundo_apellido')) has-error @endif">
                       <label for="segundo_apellido-field">Segundo_apellido</label>
                       {!! Form::text("segundo_apellido", null, array("class" => "form-control", "id" => "segundo_apellido-field")) !!}
                       @if($errors->has("segundo_apellido"))
                        <span class="help-block">{{ $errors->first("segundo_apellido") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('correo_electronico')) has-error @endif">
                       <label for="correo_electronico-field">Correo_electronico</label>
                       {!! Form::text("correo_electronico", null, array("class" => "form-control", "id" => "correo_electronico-field")) !!}
                       @if($errors->has("correo_electronico"))
                        <span class="help-block">{{ $errors->first("correo_electronico") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('fecha_expedicion')) has-error @endif">
                       <label for="fecha_expedicion-field">Fecha_expedicion</label>
                       {!! Form::text("fecha_expedicion", null, array("class" => "form-control", "id" => "fecha_expedicion-field")) !!}
                       @if($errors->has("fecha_expedicion"))
                        <span class="help-block">{{ $errors->first("fecha_expedicion") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('sep_modalidad_titulacion_id')) has-error @endif">
                       <label for="sep_modalidad_titulacion_id-field">Sep_modalidad_titulacion_id</label>
                       {!! Form::text("sep_modalidad_titulacion_id", null, array("class" => "form-control", "id" => "sep_modalidad_titulacion_id-field")) !!}
                       @if($errors->has("sep_modalidad_titulacion_id"))
                        <span class="help-block">{{ $errors->first("sep_modalidad_titulacion_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('fecha_examen_profesional')) has-error @endif">
                       <label for="fecha_examen_profesional-field">Fecha_examen_profesional</label>
                       {!! Form::text("fecha_examen_profesional", null, array("class" => "form-control", "id" => "fecha_examen_profesional-field")) !!}
                       @if($errors->has("fecha_examen_profesional"))
                        <span class="help-block">{{ $errors->first("fecha_examen_profesional") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('cumplio_servicio_social')) has-error @endif">
                       <label for="cumplio_servicio_social-field">Cumplio_servicio_social</label>
                       {!! Form::text("cumplio_servicio_social", null, array("class" => "form-control", "id" => "cumplio_servicio_social-field")) !!}
                       @if($errors->has("cumplio_servicio_social"))
                        <span class="help-block">{{ $errors->first("cumplio_servicio_social") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('sep_fundamento_legal_servicio_social_id')) has-error @endif">
                       <label for="sep_fundamento_legal_servicio_social_id-field">Sep_fundamento_legal_servicio_social_id</label>
                       {!! Form::text("sep_fundamento_legal_servicio_social_id", null, array("class" => "form-control", "id" => "sep_fundamento_legal_servicio_social_id-field")) !!}
                       @if($errors->has("sep_fundamento_legal_servicio_social_id"))
                        <span class="help-block">{{ $errors->first("sep_fundamento_legal_servicio_social_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('sep_t_estudio_antecedente_id')) has-error @endif">
                       <label for="sep_t_estudio_antecedente_id-field">Sep_t_estudio_antecedente_id</label>
                       {!! Form::text("sep_t_estudio_antecedente_id", null, array("class" => "form-control", "id" => "sep_t_estudio_antecedente_id-field")) !!}
                       @if($errors->has("sep_t_estudio_antecedente_id"))
                        <span class="help-block">{{ $errors->first("sep_t_estudio_antecedente_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('entidad_expedicion')) has-error @endif">
                       <label for="entidad_expedicion-field">Entidad_expedicion</label>
                       {!! Form::text("entidad_expedicion", null, array("class" => "form-control", "id" => "entidad_expedicion-field")) !!}
                       @if($errors->has("entidad_expedicion"))
                        <span class="help-block">{{ $errors->first("entidad_expedicion") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('institucion_procedencia')) has-error @endif">
                       <label for="institucion_procedencia-field">Institucion_procedencia</label>
                       {!! Form::text("institucion_procedencia", null, array("class" => "form-control", "id" => "institucion_procedencia-field")) !!}
                       @if($errors->has("institucion_procedencia"))
                        <span class="help-block">{{ $errors->first("institucion_procedencia") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('entidad_antecedente')) has-error @endif">
                       <label for="entidad_antecedente-field">Entidad_antecedente</label>
                       {!! Form::text("entidad_antecedente", null, array("class" => "form-control", "id" => "entidad_antecedente-field")) !!}
                       @if($errors->has("entidad_antecedente"))
                        <span class="help-block">{{ $errors->first("entidad_antecedente") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('fecha_inicio_antecedente')) has-error @endif">
                       <label for="fecha_inicio_antecedente-field">Fecha_inicio_antecedente</label>
                       {!! Form::text("fecha_inicio_antecedente", null, array("class" => "form-control", "id" => "fecha_inicio_antecedente-field")) !!}
                       @if($errors->has("fecha_inicio_antecedente"))
                        <span class="help-block">{{ $errors->first("fecha_inicio_antecedente") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('fecha_terminoa_antecedente')) has-error @endif">
                       <label for="fecha_terminoa_antecedente-field">Fecha_terminoa_antecedente</label>
                       {!! Form::text("fecha_terminoa_antecedente", null, array("class" => "form-control", "id" => "fecha_terminoa_antecedente-field")) !!}
                       @if($errors->has("fecha_terminoa_antecedente"))
                        <span class="help-block">{{ $errors->first("fecha_terminoa_antecedente") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('no_cedula')) has-error @endif">
                       <label for="no_cedula-field">No_cedula</label>
                       {!! Form::text("no_cedula", null, array("class" => "form-control", "id" => "no_cedula-field")) !!}
                       @if($errors->has("no_cedula"))
                        <span class="help-block">{{ $errors->first("no_cedula") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('usu_mod_id')) has-error @endif">
                       <label for="usu_mod_id-field">Usu_mod_id</label>
                       {!! Form::text("usu_mod_id", null, array("class" => "form-control", "id" => "usu_mod_id-field")) !!}
                       @if($errors->has("usu_mod_id"))
                        <span class="help-block">{{ $errors->first("usu_mod_id") }}</span>
                       @endif
                    </div>