                <div class="form-group @if($errors->has('id_autorizacion_reconocimiento')) has-error @endif">
                       <label for="id_autorizacion_reconocimiento-field">Id_autorizacion_reconocimiento</label>
                       {!! Form::text("id_autorizacion_reconocimiento", null, array("class" => "form-control", "id" => "id_autorizacion_reconocimiento-field")) !!}
                       @if($errors->has("id_autorizacion_reconocimiento"))
                        <span class="help-block">{{ $errors->first("id_autorizacion_reconocimiento") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('autorizacion_reconocimiento')) has-error @endif">
                       <label for="autorizacion_reconocimiento-field">Autorizacion_reconocimiento</label>
                       {!! Form::text("autorizacion_reconocimiento", null, array("class" => "form-control", "id" => "autorizacion_reconocimiento-field")) !!}
                       @if($errors->has("autorizacion_reconocimiento"))
                        <span class="help-block">{{ $errors->first("autorizacion_reconocimiento") }}</span>
                       @endif
                    </div>