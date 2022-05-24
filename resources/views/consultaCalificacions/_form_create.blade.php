                
                    <div class="form-group col-md-4 @if($errors->has('matricula')) has-error @endif">
                       <label for="matricula-field">Matricula</label>
                       {!! Form::text("matricula", optional($cliente)->matricula, array("class" => "form-control", "id" => "matricula-field", 'readonly'=>true)) !!}
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
                    