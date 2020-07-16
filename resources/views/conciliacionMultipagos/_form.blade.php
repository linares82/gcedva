<!--                <div class="form-group @if($errors->has('fecha_carga')) has-error @endif">
                       <label for="fecha_carga-field">Fecha_carga</label>
                       @{!! Form::text("fecha_carga", null, array("class" => "form-control", "id" => "fecha_carga-field")) !!}
                       @if($errors->has("fecha_carga"))
                        <span class="help-block">{{ $errors->first("fecha_carga") }}</span>
                       @endif
                    </div>-->
                    <div class="form-group col-md-4 @if($errors->has('archivo')) has-error @endif">
                       <label for="archivo-field">Archivo</label>
                       
                       {!! Form::file('archivo') !!}
                       @if($errors->has("archivo"))
                        <span class="help-block">{{ $errors->first("archivo") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('fec_inicio')) has-error @endif">
                        <label for="fec_inicio-field">Fecha Inicio</label>
                        {!! Form::text("fec_inicio", null, array("class" => "form-control fecha", "id" => "fec_inicio-field")) !!}
                        @if($errors->has("fec_inicio"))
                        <span class="help-block">{{ $errors->first("fec_inicio") }}</span>
                        @endif
                     </div>
                     <div class="form-group col-md-4 @if($errors->has('fec_fin')) has-error @endif">
                        <label for="fec_fin-field">Fecha Fin</label>
                        {!! Form::text("fec_fin", null, array("class" => "form-control fecha", "id" => "fec_fin-field")) !!}
                        @if($errors->has("fec_fin"))
                        <span class="help-block">{{ $errors->first("fec_fin") }}</span>
                        @endif
                     </div>
                  