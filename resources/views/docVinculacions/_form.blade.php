                <div class="form-group col-md-4 @if($errors->has('name')) has-error @endif">
                       <label for="name-field">Documento</label>
                       {!! Form::text("name", null, array("class" => "form-control", "id" => "name-field")) !!}
                       @if($errors->has("name"))
                        <span class="help-block">{{ $errors->first("name") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('orden')) has-error @endif">
                     <label for="orden-field">Orden</label>
                     {!! Form::text("orden", null, array("class" => "form-control", "id" => "orden-field")) !!}
                     @if($errors->has("orden"))
                      <span class="help-block">{{ $errors->first("orden") }}</span>
                     @endif
                  </div>
                  <div class="form-group col-md-4 @if($errors->has('clasificacion_id')) has-error @endif">
                     <label for="clasificacion_id-field">Clasificación</label>
                     {!! Form::select("clasificacion_id", $clasificacions, null, array("class" => "form-control select_seguridad", "id" => "clasificacion_id-field", 'style'=>'width:100%')) !!}
                     @if($errors->has("clasificacion_id"))
                     <span class="help-block">{{ $errors->first("clasificacion_id") }}</span>
                     @endif
                 </div>
                 <div class="row"></div>
                    <div class="form-group col-md-4 @if($errors->has('bnd_obligatorio')) has-error @endif">
                       <label for="bnd_obligatorio-field">Obligatorio</label>
                       {!! Form::checkbox("bnd_obligatorio", 1, null, [ "id" => "bnd_obligatorio-field"]) !!}
                       @if($errors->has("bnd_obligatorio"))
                        <span class="help-block">{{ $errors->first("bnd_obligatorio") }}</span>
                       @endif
                    </div>
                    