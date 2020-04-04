                <div class="form-group @if($errors->has('uid')) has-error @endif">
                       <label for="uid-field">Uid</label>
                       {!! Form::text("uid", null, array("class" => "form-control", "id" => "uid-field")) !!}
                       @if($errors->has("uid"))
                        <span class="help-block">{{ $errors->first("uid") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('from')) has-error @endif">
                       <label for="from-field">From</label>
                       {!! Form::text("from", null, array("class" => "form-control", "id" => "from-field")) !!}
                       @if($errors->has("from"))
                        <span class="help-block">{{ $errors->first("from") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('to')) has-error @endif">
                       <label for="to-field">To</label>
                       {!! Form::text("to", null, array("class" => "form-control", "id" => "to-field")) !!}
                       @if($errors->has("to"))
                        <span class="help-block">{{ $errors->first("to") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('asunto')) has-error @endif">
                       <label for="asunto-field">Asunto</label>
                       {!! Form::text("asunto", null, array("class" => "form-control", "id" => "asunto-field")) !!}
                       @if($errors->has("asunto"))
                        <span class="help-block">{{ $errors->first("asunto") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('adjuntos')) has-error @endif">
                       <label for="adjuntos-field">Adjuntos</label>
                       {!! Form::text("adjuntos", null, array("class" => "form-control", "id" => "adjuntos-field")) !!}
                       @if($errors->has("adjuntos"))
                        <span class="help-block">{{ $errors->first("adjuntos") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('fecha')) has-error @endif">
                       <label for="fecha-field">Fecha</label>
                       {!! Form::text("fecha", null, array("class" => "form-control", "id" => "fecha-field")) !!}
                       @if($errors->has("fecha"))
                        <span class="help-block">{{ $errors->first("fecha") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('mesaje')) has-error @endif">
                       <label for="mesaje-field">Mesaje</label>
                       {!! Form::text("mesaje", null, array("class" => "form-control", "id" => "mesaje-field")) !!}
                       @if($errors->has("mesaje"))
                        <span class="help-block">{{ $errors->first("mesaje") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('bnd_leido')) has-error @endif">
                       <label for="bnd_leido-field">Bnd_leido</label>
                       {!! Form::text("bnd_leido", null, array("class" => "form-control", "id" => "bnd_leido-field")) !!}
                       @if($errors->has("bnd_leido"))
                        <span class="help-block">{{ $errors->first("bnd_leido") }}</span>
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