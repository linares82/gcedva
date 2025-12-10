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
				<div class="form-group col-md-4 @if($errors->has('cve_sat')) has-error @endif">
                     <label for="cve_sat-field">Clave SAT</label>
                     {!! Form::text("cve_sat", null, array("class" => "form-control", "id" => "cve_sat-field")) !!}
                     @if($errors->has("cve_sat"))
                      <span class="help-block">{{ $errors->first("cve_sat") }}</span>
                     @endif
                  </div>  
            <div class="form-group col-md-3 @if($errors->has('bnd_en_linea')) has-error @endif">
                            <label for="bnd_en_linea-field">¿En Línea?</label>
                            {!! Form::checkbox("bnd_en_linea", 1, null, [ "id" => "bnd_en_linea-field", 'class'=>'minimal']) !!}
                            @if($errors->has("bnd_en_linea"))
                            <span class="help-block">{{ $errors->first("bnd_en_linea") }}</span>
                            @endif
                        </div>      
                  