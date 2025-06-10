                <div class="form-group @if($errors->has('id_tipo_certificacion')) has-error @endif">
                       <label for="id_tipo_certificacion-field">Id_tipo_certificacion</label>
                       {!! Form::text("id_tipo_certificacion", null, array("class" => "form-control", "id" => "id_tipo_certificacion-field")) !!}
                       @if($errors->has("id_tipo_certificacion"))
                        <span class="help-block">{{ $errors->first("id_tipo_certificacion") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('tipo_certificacion')) has-error @endif">
                       <label for="tipo_certificacion-field">Tipo_certificacion</label>
                       {!! Form::text("tipo_certificacion", null, array("class" => "form-control", "id" => "tipo_certificacion-field")) !!}
                       @if($errors->has("tipo_certificacion"))
                        <span class="help-block">{{ $errors->first("tipo_certificacion") }}</span>
                       @endif
                    </div>