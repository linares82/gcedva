                <div class="form-group @if($errors->has('name')) has-error @endif">
                       <label for="name-field">Name</label>
                       {!! Form::text("name", null, array("class" => "form-control", "id" => "name-field")) !!}
                       @if($errors->has("name"))
                        <span class="help-block">{{ $errors->first("name") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('costo')) has-error @endif">
                     <label for="name-field">Costo</label>
                     {!! Form::text("costo", null, array("class" => "form-control", "id" => "costo-field")) !!}
                     @if($errors->has("costo"))
                      <span class="help-block">{{ $errors->first("costo") }}</span>
                     @endif
                  </div>
     