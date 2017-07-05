                <div class="form-group col-md-4 @if($errors->has('otro_id')) has-error @endif">
                       <label for="otro_id-field">Otro</label>
                       {!! Form::select("otro_id", $list["Otro"], null, array("class" => "form-control", "id" => "subotro_id-field")) !!}
                       @if($errors->has("otro_id"))
                        <span class="help-block">{{ $errors->first("otro_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('name')) has-error @endif">
                       <label for="name-field">Subotro</label>
                       {!! Form::text("name", null, array("class" => "form-control", "id" => "name-field")) !!}
                       @if($errors->has("name"))
                        <span class="help-block">{{ $errors->first("name") }}</span>
                       @endif
                    </div>
                    