                <div class="form-group col-md-4 @if($errors->has('name')) has-error @endif">
                       <label for="name-field">Nombre</label>
                       {!! Form::text("name", null, array("class" => "form-control", "id" => "name-field")) !!}
                       @if($errors->has("name"))
                        <span class="help-block">{{ $errors->first("name") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('clave')) has-error @endif">
                       <label for="clave-field">Clave</label>
                       {!! Form::text("clave", null, array("class" => "form-control", "id" => "clave-field")) !!}
                       @if($errors->has("clave"))
                        <span class="help-block">{{ $errors->first("clave") }}</span>
                       @endif
                    </div>
                    <div class="row"></div>
                    <div class="form-group col-md-12"><label>Datos Para Generar Series y Folios, no debe usar el año en curso o años anteriores</label></div>
                <div class="form-group col-md-4 @if($errors->has('anio')) has-error @endif">
                       <label for="anio-field">Año</label>
                       {!! Form::text("anio", null, array("class" => "form-control", "id" => "anio-field")) !!}
                       @if($errors->has("anio"))
                        <span class="help-block">{{ $errors->first("anio") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('serie')) has-error @endif">
                       <label for="serie-field">Serie</label>
                       {!! Form::text("serie", null, array("class" => "form-control", "id" => "serie-field")) !!}
                       @if($errors->has("serie"))
                        <span class="help-block">{{ $errors->first("serie") }}</span>
                       @endif
                    </div>