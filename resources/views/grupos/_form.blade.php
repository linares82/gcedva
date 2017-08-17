                <div class="form-group @if($errors->has('name')) has-error @endif">
                       <label for="name-field">Name</label>
                       {!! Form::text("name", null, array("class" => "form-control", "id" => "name-field")) !!}
                       @if($errors->has("name"))
                        <span class="help-block">{{ $errors->first("name") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('desc_corta')) has-error @endif">
                       <label for="desc_corta-field">Desc_corta</label>
                       {!! Form::text("desc_corta", null, array("class" => "form-control", "id" => "desc_corta-field")) !!}
                       @if($errors->has("desc_corta"))
                        <span class="help-block">{{ $errors->first("desc_corta") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('limite_alumnos')) has-error @endif">
                       <label for="limite_alumnos-field">Limite_alumnos</label>
                       {!! Form::text("limite_alumnos", null, array("class" => "form-control", "id" => "limite_alumnos-field")) !!}
                       @if($errors->has("limite_alumnos"))
                        <span class="help-block">{{ $errors->first("limite_alumnos") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('jornada_id')) has-error @endif">
                       <label for="jornada_id-field">Jornada_id</label>
                       {!! Form::text("jornada_id", null, array("class" => "form-control", "id" => "jornada_id-field")) !!}
                       @if($errors->has("jornada_id"))
                        <span class="help-block">{{ $errors->first("jornada_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('salon_id')) has-error @endif">
                       <label for="salon_id-field">Salon_id</label>
                       {!! Form::text("salon_id", null, array("class" => "form-control", "id" => "salon_id-field")) !!}
                       @if($errors->has("salon_id"))
                        <span class="help-block">{{ $errors->first("salon_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('periodo_id')) has-error @endif">
                       <label for="periodo_id-field">Periodo_id</label>
                       {!! Form::text("periodo_id", null, array("class" => "form-control", "id" => "periodo_id-field")) !!}
                       @if($errors->has("periodo_id"))
                        <span class="help-block">{{ $errors->first("periodo_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('usu_alta_id')) has-error @endif">
                       <label for="usu_alta_id-field">Usu_alta_id</label>
                       {!! Form::text("usu_alta_id", null, array("class" => "form-control", "id" => "usu_alta_id-field")) !!}
                       @if($errors->has("usu_alta_id"))
                        <span class="help-block">{{ $errors->first("usu_alta_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('usu_mod_id')) has-error @endif">
                       <label for="usu_mod_id-field">Usu_mod_id</label>
                       {!! Form::text("usu_mod_id", null, array("class" => "form-control", "id" => "usu_mod_id-field")) !!}
                       @if($errors->has("usu_mod_id"))
                        <span class="help-block">{{ $errors->first("usu_mod_id") }}</span>
                       @endif
                    </div>