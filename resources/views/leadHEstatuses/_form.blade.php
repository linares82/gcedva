                <div class="form-group @if($errors->has('lead_id')) has-error @endif">
                       <label for="lead_id-field">Lead_id</label>
                       {!! Form::text("lead_id", null, array("class" => "form-control", "id" => "lead_id-field")) !!}
                       @if($errors->has("lead_id"))
                        <span class="help-block">{{ $errors->first("lead_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('st_lead_id')) has-error @endif">
                       <label for="st_lead_id-field">St_lead_id</label>
                       {!! Form::text("st_lead_id", null, array("class" => "form-control", "id" => "st_lead_id-field")) !!}
                       @if($errors->has("st_lead_id"))
                        <span class="help-block">{{ $errors->first("st_lead_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('fecha')) has-error @endif">
                       <label for="fecha-field">Fecha</label>
                       {!! Form::text("fecha", null, array("class" => "form-control", "id" => "fecha-field")) !!}
                       @if($errors->has("fecha"))
                        <span class="help-block">{{ $errors->first("fecha") }}</span>
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