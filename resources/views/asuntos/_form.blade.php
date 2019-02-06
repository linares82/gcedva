                <div class="form-group col-md-4 @if($errors->has('name')) has-error @endif">
                       <label for="name-field">Asunto</label>
                       {!! Form::text("name", null, array("class" => "form-control input-sm", "id" => "name-field")) !!}
                       @if($errors->has("name"))
                        <span class="help-block">{{ $errors->first("name") }}</span>
                       @endif
                    </div>
                <div class="form-group col-md-3 @if($errors->has('bnd_empresa')) has-error @endif">
                        <label for="bnd_empresa-field">Empresa</label>
                        {!! Form::checkbox("bnd_empresa", 1, null, [ "id" => "bnd_empresa-field", 'class'=>'minimal']) !!}
                        @if($errors->has("bnd_empresa"))
                        <span class="help-block">{{ $errors->first("bnd_empresa") }}</span>
                        @endif
                    </div>
