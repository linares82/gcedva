                <div class="form-group col-md-4 @if($errors->has('name')) has-error @endif">
                       <label for="name-field">FORMA PAGO</label>
                       {!! Form::text("name", null, array("class" => "form-control", "id" => "name-field")) !!}
                       @if($errors->has("name"))
                        <span class="help-block">{{ $errors->first("name") }}</span>
                       @endif
                    </div>
               <div class="form-group col-md-4 @if($errors->has('cve_multipagos')) has-error @endif">
                     <label for="cve_multipagos-field">Clave Multipagos</label>
                     {!! Form::text("cve_multipagos", null, array("class" => "form-control", "id" => "cve_multipagos-field")) !!}
                     @if($errors->has("name"))
                      <span class="help-block">{{ $errors->first("cve_multipagos") }}</span>
                     @endif
                  </div>
                  