                <div class="form-group col-md-4 @if($errors->has('ponderacion_id')) has-error @endif">
                       <label for="ponderacion_id-field">Ponderacion_id</label>
                       
                       {!! Form::select("ponderacion_id", $ponderaciones, null, array("class" => "form-control select_seguridad", "id" => "ponderacion_id-field")) !!}
                       @if($errors->has("ponderacion_id"))
                        <span class="help-block">{{ $errors->first("ponderacion_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('name')) has-error @endif">
                       <label for="name-field">Name</label>
                       {!! Form::text("name", null, array("class" => "form-control input-sm", "id" => "name-field")) !!}
                       @if($errors->has("name"))
                        <span class="help-block">{{ $errors->first("name") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('porcentaje')) has-error @endif">
                       <label for="porcentaje-field">Porcentaje</label>
                       {!! Form::text("porcentaje", null, array("class" => "form-control input-sm", "id" => "porcentaje-field")) !!}
                       @if($errors->has("porcentaje"))
                        <span class="help-block">{{ $errors->first("porcentaje") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('bnd_activo')) has-error @endif">
                     <label for="bnd_activo-field">Activo</label>
                     {!! Form::checkbox("bnd_activo", 1, null, [ "id" => "bnd_activo-field", 'class'=>'minimal']) !!}
                     @if($errors->has("bnd_activo"))
                     <span class="help-block">{{ $errors->first("bnd_activo") }}</span>
                     @endif
                 </div>
                    <div class="form-group col-md-4 @if($errors->has('tiene_detalle')) has-error @endif">
                            <label for="tiene_detalle-field">Tiene Detalle</label>
                            {!! Form::checkbox("tiene_detalle", 1, null, [ "id" => "tiene_detalle-field", 'class'=>'minimal']) !!}
                            @if($errors->has("tiene_detalle"))
                            <span class="help-block">{{ $errors->first("tiene_detalle") }}</span>
                            @endif
                        </div>
                    <div class="form-group col-md-4 @if($errors->has('padre_id')) has-error @endif">
                         <label for="padre_id-field">Padre</label>
                         {!! Form::select("padre_id", $padre, null, array("class" => "form-control select_seguridad", "id" => "padre_id-field")) !!}
                         @if($errors->has("padre_id"))
                          <span class="help-block">{{ $errors->first("padre_id") }}</span>
                         @endif
                      </div>