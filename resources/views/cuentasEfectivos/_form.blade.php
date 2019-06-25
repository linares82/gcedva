                <div class="form-group col-md-4 @if($errors->has('name')) has-error @endif">
                       <label for="name-field">Nombre</label>
                       {!! Form::text("name", null, array("class" => "form-control", "id" => "name-field")) !!}
                       @if($errors->has("name"))
                        <span class="help-block">{{ $errors->first("name") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('clabe')) has-error @endif">
                       <label for="clabe-field">CLABE</label>
                       {!! Form::text("clabe", null, array("class" => "form-control", "id" => "clabe-field")) !!}
                       @if($errors->has("clabe"))
                        <span class="help-block">{{ $errors->first("clabe") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('no_cuenta')) has-error @endif">
                       <label for="no_cuenta-field">No. Cuenta</label>
                       {!! Form::text("no_cuenta", null, array("class" => "form-control", "id" => "no_cuenta-field")) !!}
                       @if($errors->has("no_cuenta"))
                        <span class="help-block">{{ $errors->first("no_cuenta") }}</span>
                       @endif
                    </div>
                    