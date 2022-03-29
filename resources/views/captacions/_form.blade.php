                <div class="form-group col-md-4 @if($errors->has('plantel')) has-error @endif">
                       <label for="plantel-field">Plantel</label>
                       {!! Form::text("plantel", null, array("class" => "form-control", "id" => "plantel-field")) !!}
                       @if($errors->has("plantel"))
                        <span class="help-block">{{ $errors->first("plantel") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('nombre')) has-error @endif">
                       <label for="nombre-field">Nombre</label>
                       {!! Form::text("nombre", null, array("class" => "form-control", "id" => "nombre-field")) !!}
                       @if($errors->has("nombre"))
                        <span class="help-block">{{ $errors->first("nombre") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('nombre2')) has-error @endif">
                       <label for="nombre2-field">Segundo Nombre </label>
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
                    <div class="form-group col-md-4 @if($errors->has('mail')) has-error @endif">
                       <label for="mail-field">Mail</label>
                       {!! Form::text("mail", null, array("class" => "form-control", "id" => "mail-field")) !!}
                       @if($errors->has("mail"))
                        <span class="help-block">{{ $errors->first("mail") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('tel_cel')) has-error @endif">
                       <label for="tel_cel-field">Tel. Cel.</label>
                       {!! Form::text("tel_cel", null, array("class" => "form-control", "id" => "tel_cel-field")) !!}
                       @if($errors->has("tel_cel"))
                        <span class="help-block">{{ $errors->first("tel_cel") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('tel_fijo')) has-error @endif">
                       <label for="tel_fijo-field">Tel. Fijo</label>
                       {!! Form::text("tel_fijo", null, array("class" => "form-control", "id" => "tel_fijo-field")) !!}
                       @if($errors->has("tel_fijo"))
                        <span class="help-block">{{ $errors->first("tel_fijo") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('pais')) has-error @endif">
                       <label for="pais-field">Pais</label>
                       {!! Form::text("pais", null, array("class" => "form-control", "id" => "pais-field")) !!}
                       @if($errors->has("pais"))
                        <span class="help-block">{{ $errors->first("pais") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('medio_id')) has-error @endif">
                       <label for="medio_id-field">Medio</label>
                       {!! Form::select("medio_id", $medios, null, array("class" => "form-control", "id" => "medio_id-field")) !!}
                       @if($errors->has("medio_id"))
                        <span class="help-block">{{ $errors->first("medio_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-12 @if($errors->has('comen_obs')) has-error @endif">
                       <label for="comen_obs-field">Comentarios y Obs.</label></label>
                       {!! Form::textArea("comen_obs", null, array("class" => "form-control", "id" => "comen_obs-field")) !!}
                       @if($errors->has("comen_obs"))
                        <span class="help-block">{{ $errors->first("comen_obs") }}</span>
                       @endif
                    </div>
                    