                <div class="form-group col-md-4 @if($errors->has('name')) has-error @endif">
                       <label for="name-field">Evento</label>
                       {!! Form::text("name", null, array("class" => "form-control", "id" => "name-field")) !!}
                       @if($errors->has("name"))
                        <span class="help-block">{{ $errors->first("name") }}</span>
                       @endif
                    </div>
               <div class="form-group col-md-3 @if($errors->has('bnd_duplicar_cliente')) has-error @endif">
                            <label for="bnd_duplicar_cliente-field">Duplica Cliente Por Cambio De Carrera</label>
                            {!! Form::checkbox("bnd_duplicar_cliente", 1, null, [ "id" => "bnd_duplicar_cliente-field", 'class'=>'minimal']) !!}
                            @if($errors->has("bnd_duplicar_cliente"))
                            <span class="help-block">{{ $errors->first("bnd_duplicar_cliente") }}</span>
                            @endif
                        </div>
                    