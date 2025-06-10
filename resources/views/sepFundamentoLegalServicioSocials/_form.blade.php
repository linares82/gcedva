                <div class="form-group @if($errors->has('id_fundamento_legal_servicio_social')) has-error @endif">
                       <label for="id_fundamento_legal_servicio_social-field">Id_fundamento_legal_servicio_social</label>
                       {!! Form::text("id_fundamento_legal_servicio_social", null, array("class" => "form-control", "id" => "id_fundamento_legal_servicio_social-field")) !!}
                       @if($errors->has("id_fundamento_legal_servicio_social"))
                        <span class="help-block">{{ $errors->first("id_fundamento_legal_servicio_social") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('fundamento_legal_servicio_social')) has-error @endif">
                       <label for="fundamento_legal_servicio_social-field">Fundamento_legal_servicio_social</label>
                       {!! Form::text("fundamento_legal_servicio_social", null, array("class" => "form-control", "id" => "fundamento_legal_servicio_social-field")) !!}
                       @if($errors->has("fundamento_legal_servicio_social"))
                        <span class="help-block">{{ $errors->first("fundamento_legal_servicio_social") }}</span>
                       @endif
                    </div>