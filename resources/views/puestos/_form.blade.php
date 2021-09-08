                <div class="form-group col-md-4 @if($errors->has('name')) has-error @endif">
                       <label for="name-field">Puesto</label>
                       {!! Form::text("name", null, array("class" => "form-control input-sm", "id" => "name-field")) !!}
                       @if($errors->has("name"))
                        <span class="help-block">{{ $errors->first("name") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('bnd_permitido_clientes')) has-error @endif">
                     <label for="bnd_permitido_clientes-field">Permitido en Clientes</label>
                     {!! Form::checkbox("bnd_permitido_clientes", 1, null, [ "id" => "bnd_permitido_clientes-field"]) !!}
                     @if($errors->has("bnd_permitido_clientes"))
                      <span class="help-block">{{ $errors->first("bnd_permitido_clientes") }}</span>
                     @endif
                  </div>
                    
                    