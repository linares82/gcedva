                <div class="form-group col-md-4 @if($errors->has('name')) has-error @endif">
                       <label for="name-field">Medio</label>
                       {!! Form::text("name", null, array("class" => "form-control input-sm", "id" => "name-field")) !!}
                       @if($errors->has("name"))
                        <span class="help-block">{{ $errors->first("name") }}</span>
                       @endif
                    </div>

                    <div class="form-group col-md-3 @if($errors->has('bnd_prospectos')) has-error @endif">
                            <label for="bnd_prospectos-field">Prospectos</label>
                            {!! Form::checkbox("bnd_prospectos", 1, null, [ "id" => "bnd_prospectos-field", 'class'=>'minimal']) !!}
                            @if($errors->has("bnd_prospectos"))
                            <span class="help-block">{{ $errors->first("bnd_prospectos") }}</span>
                            @endif
                        </div>
                    