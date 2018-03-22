                <div class="form-group col-md-4 @if($errors->has('name')) has-error @endif">
                       <label for="name-field">Nombre</label>
                       {!! Form::text("name", null, array("class" => "form-control", "id" => "name-field")) !!}
                       @if($errors->has("name"))
                        <span class="help-block">{{ $errors->first("name") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('detalle')) has-error @endif">
                       <label for="detalle-field">Detalle</label>
                       {!! Form::text("detalle", null, array("class" => "form-control", "id" => "detalle-field")) !!}
                       @if($errors->has("detalle"))
                        <span class="help-block">{{ $errors->first("detalle") }}</span>
                       @endif
                    </div>
                    