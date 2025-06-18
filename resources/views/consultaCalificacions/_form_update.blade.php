                
                    <div class="form-group col-md-4 @if($errors->has('matricula')) has-error @endif">
                       <label for="matricula-field">Matricula</label>
                       {!! Form::text("matricula", $consultaCalificacion->matricula, array("class" => "form-control", "id" => "matricula-field", 'readonly'=>true)) !!}
                       @if($errors->has("matricula"))
                        <span class="help-block">{{ $errors->first("matricula") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('materia')) has-error @endif">
                     <label for="materia-field">Materia</label>
                     {!! Form::text("materia", null, array("class" => "form-control", "id" => "materia-field")) !!}
                     @if($errors->has("materia"))
                      <span class="help-block">{{ $errors->first("materia") }}</span>
                     @endif
                  </div>
                    <div class="form-group col-md-4 @if($errors->has('periodo_escolar')) has-error @endif">
                     <label for="periodo_escolar-field">Periodo Escolar</label>
                     {!! Form::text("periodo_escolar", null, array("class" => "form-control", "id" => "periodo_escolar-field")) !!}
                     @if($errors->has("periodo_escolar"))
                      <span class="help-block">{{ $errors->first("periodo_escolar") }}</span>
                     @endif
                  </div>
                    <div class="form-group col-md-4 @if($errors->has('codigo')) has-error @endif">
                       <label for="codigo-field">Codigo</label>
                       {!! Form::text("codigo", null, array("class" => "form-control", "id" => "codigo-field")) !!}
                       @if($errors->has("codigo"))
                        <span class="help-block">{{ $errors->first("codigo") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('creditos')) has-error @endif">
                       <label for="creditos-field">Creditos</label>
                       {!! Form::text("creditos", null, array("class" => "form-control", "id" => "creditos-field")) !!}
                       @if($errors->has("creditos"))
                        <span class="help-block">{{ $errors->first("creditos") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('lectivo')) has-error @endif">
                       <label for="lectivo-field">Lectivo</label>
                       {!! Form::text("lectivo", null, array("class" => "form-control", "id" => "lectivo-field")) !!}
                       @if($errors->has("lectivo"))
                        <span class="help-block">{{ $errors->first("lectivo") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('calificacion')) has-error @endif">
                       <label for="calificacion-field">Calificacion</label>
                       {!! Form::text("calificacion", null, array("class" => "form-control", "id" => "calificacion-field")) !!}
                       @if($errors->has("calificacion"))
                        <span class="help-block">{{ $errors->first("calificacion") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('tipo_examen')) has-error @endif">
                       <label for="tipo_examen-field">Tipo Examen</label>
                       {!! Form::text("tipo_examen", null, array("class" => "form-control", "id" => "tipo_examen-field")) !!}
                       @if($errors->has("tipo_examen"))
                        <span class="help-block">{{ $errors->first("tipo_examen") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('grupo')) has-error @endif">
                       <label for="grupo-field">Grupo</label>
                       {!! Form::text("grupo", null, array("class" => "form-control", "id" => "grupo-field")) !!}
                       @if($errors->has("grupo"))
                        <span class="help-block">{{ $errors->first("grupo") }}</span>
                       @endif
                    </div>

                    <div class="form-group col-md-3 @if($errors->has('bnd_oficial')) has-error @endif">
                            <label for="bnd_oficial-field">¿Materia Oficial?</label>
                            {!! Form::checkbox("bnd_oficial", 1, null, [ "id" => "bnd_oficial-field", 'class'=>'minimal']) !!}
                            @if($errors->has("bnd_oficial"))
                            <span class="help-block">{{ $errors->first("bnd_oficial") }}</span>
                            @endif
                        </div>
                    <div class="form-group col-md-4 @if($errors->has('nombre_oficial')) has-error @endif">
                       <label for="nombre_oficial-field">Nombre Oficial</label>
                       {!! Form::text("nombre_oficial", null, array("class" => "form-control", "id" => "nombre_oficial-field")) !!}
                       @if($errors->has("nombre_oficial"))
                        <span class="help-block">{{ $errors->first("nombre_oficial") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('id_asignatura')) has-error @endif">
                       <label for="id_asignatura-field">Id Asignatura</label>
                       {!! Form::text("id_asignatura", null, array("class" => "form-control", "id" => "id_asignatura-field")) !!}
                       @if($errors->has("id_asignatura"))
                        <span class="help-block">{{ $errors->first("id_asignatura") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('nombre_asignatura')) has-error @endif">
                       <label for="nombre_asignatura-field">Nombre Asignatura</label>
                       {!! Form::text("nombre_asignatura", null, array("class" => "form-control", "id" => "nombre_asignatura-field")) !!}
                       @if($errors->has("nombre_asignatura"))
                        <span class="help-block">{{ $errors->first("nombre_asignatura") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('ciclo')) has-error @endif">
                       <label for="ciclo-field">Ciclo</label>
                       {!! Form::text("ciclo", null, array("class" => "form-control", "id" => "ciclo-field")) !!}
                       @if($errors->has("ciclo"))
                        <span class="help-block">{{ $errors->first("ciclo") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('id_observaciones')) has-error @endif">
                       <label for="id_observaciones-field">Id Observaciones</label>
                       {!! Form::text("id_observaciones", null, array("class" => "form-control", "id" => "id_observaciones-field")) !!}
                       @if($errors->has("id_observaciones"))
                        <span class="help-block">{{ $errors->first("id_observaciones") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('observaciones')) has-error @endif">
                       <label for="observaciones-field">Observaciones</label>
                       {!! Form::text("observaciones", null, array("class" => "form-control", "id" => "observaciones-field")) !!}
                       @if($errors->has("observaciones"))
                        <span class="help-block">{{ $errors->first("observaciones") }}</span>
                       @endif
                    </div>
                    