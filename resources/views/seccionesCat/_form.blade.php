                <div class="form-group col-md-4 @if($errors->has('name')) has-error @endif">
                       <label for="name-field">Seccion</label>
                       {!! Form::text("name", null, array("class" => "form-control", "id" => "name-field")) !!}
                       @if($errors->has("name"))
                        <span class="help-block">{{ $errors->first("name") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('bnd_tramite')) has-error @endif">
                            <label for="bnd_tramite-field">Tiene Tramite</label>
                            {!! Form::checkbox("bnd_tramite", 1, null, [ "id" => "bnd_tramite-field", 'class'=>'minimal']) !!}
                            @if($errors->has("bnd_tramite"))
                            <span class="help-block">{{ $errors->first("bnd_tramite") }}</span>
                            @endif
                        </div>
                    