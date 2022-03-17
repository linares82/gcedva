                <div class="form-group col-md-4 @if($errors->has('razon_social')) has-error @endif">
                       <label for="razon_social-field">Razon Social</label>
                       {!! Form::text("razon_social", null, array("class" => "form-control", "id" => "razon_social-field")) !!}
                       @if($errors->has("razon_social"))
                        <span class="help-block">{{ $errors->first("razon_social") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('nombre_contacto')) has-error @endif">
                       <label for="nombre_contacto-field">Nombre Contacto</label>
                       {!! Form::text("nombre_contacto", null, array("class" => "form-control", "id" => "nombre_contacto-field")) !!}
                       @if($errors->has("nombre_contacto"))
                        <span class="help-block">{{ $errors->first("nombre_contacto") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('tel_fijo')) has-error @endif">
                       <label for="tel_fijo-field">Tel. fijo</label>
                       {!! Form::text("tel_fijo", null, array("class" => "form-control", "id" => "tel_fijo-field")) !!}
                       @if($errors->has("tel_fijo"))
                        <span class="help-block">{{ $errors->first("tel_fijo") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('tel_cel')) has-error @endif">
                       <label for="tel_cel-field">Tel. Cel.</label>
                       {!! Form::text("tel_cel", null, array("class" => "form-control", "id" => "tel_cel-field")) !!}
                       @if($errors->has("tel_cel"))
                        <span class="help-block">{{ $errors->first("tel_cel") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('correo1')) has-error @endif">
                       <label for="correo1-field">Correo 1</label>
                       {!! Form::text("correo1", null, array("class" => "form-control", "id" => "correo1-field")) !!}
                       @if($errors->has("correo1"))
                        <span class="help-block">{{ $errors->first("correo1") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('correo2')) has-error @endif">
                       <label for="correo2-field">Correo 2</label>
                       {!! Form::text("correo2", null, array("class" => "form-control", "id" => "correo2-field")) !!}
                       @if($errors->has("correo2"))
                        <span class="help-block">{{ $errors->first("correo2") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-12 @if($errors->has('direccion')) has-error @endif">
                       <label for="direccion-field">Direccion</label>
                       {!! Form::text("direccion", null, array("class" => "form-control", "id" => "direccion-field")) !!}
                       @if($errors->has("direccion"))
                        <span class="help-block">{{ $errors->first("direccion") }}</span>
                       @endif
                    </div>
                    