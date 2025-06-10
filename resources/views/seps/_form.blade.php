                <div class="form-group @if($errors->has('cve_institucion')) has-error @endif">
                       <label for="cve_institucion-field">Cve_institucion</label>
                       {!! Form::text("cve_institucion", null, array("class" => "form-control", "id" => "cve_institucion-field")) !!}
                       @if($errors->has("cve_institucion"))
                        <span class="help-block">{{ $errors->first("cve_institucion") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('descripcion')) has-error @endif">
                       <label for="descripcion-field">Descripcion</label>
                       {!! Form::text("descripcion", null, array("class" => "form-control", "id" => "descripcion-field")) !!}
                       @if($errors->has("descripcion"))
                        <span class="help-block">{{ $errors->first("descripcion") }}</span>
                       @endif
                    </div>