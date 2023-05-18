                <div class="form-group col-md-4 @if($errors->has('plantel_inventario_id')) has-error @endif">
                       <label for="plantel_inventario_id-field">Plantel</label>
                       {!! Form::select("plantel_inventario_id", $list["PlantelInventario"], null, array("class" => "form-control", "id" => "plantel_inventario_id-field")) !!}
                       @if($errors->has("plantel_inventario_id"))
                        <span class="help-block">{{ $errors->first("plantel_inventario_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('area')) has-error @endif">
                       <label for="area-field">Area</label>
                       {!! Form::text("area", null, array("class" => "form-control", "id" => "area-field")) !!}
                       @if($errors->has("area"))
                        <span class="help-block">{{ $errors->first("area") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('escuela')) has-error @endif">
                       <label for="escuela-field">Escuela</label>
                       {!! Form::text("escuela", null, array("class" => "form-control", "id" => "escuela-field")) !!}
                       @if($errors->has("escuela"))
                        <span class="help-block">{{ $errors->first("escuela") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('tipo_inventario')) has-error @endif">
                       <label for="tipo_inventario-field">Tipo inventario</label>
                       {!! Form::text("tipo_inventario", null, array("class" => "form-control", "id" => "tipo_inventario-field")) !!}
                       @if($errors->has("tipo_inventario"))
                        <span class="help-block">{{ $errors->first("tipo_inventario") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('ubicacion')) has-error @endif">
                       <label for="ubicacion-field">Ubicacion</label>
                       {!! Form::text("ubicacion", null, array("class" => "form-control", "id" => "ubicacion-field")) !!}
                       @if($errors->has("ubicacion"))
                        <span class="help-block">{{ $errors->first("ubicacion") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('cantidad')) has-error @endif">
                       <label for="cantidad-field">Cantidad</label>
                       {!! Form::text("cantidad", null, array("class" => "form-control", "id" => "cantidad-field")) !!}
                       @if($errors->has("cantidad"))
                        <span class="help-block">{{ $errors->first("cantidad") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('nombre')) has-error @endif">
                       <label for="nombre-field">Nombre</label>
                       {!! Form::text("nombre", null, array("class" => "form-control", "id" => "nombre-field")) !!}
                       @if($errors->has("nombre"))
                        <span class="help-block">{{ $errors->first("nombre") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('medida')) has-error @endif">
                       <label for="medida-field">Medida</label>
                       {!! Form::text("medida", null, array("class" => "form-control", "id" => "medida-field")) !!}
                       @if($errors->has("medida"))
                        <span class="help-block">{{ $errors->first("medida") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('marca')) has-error @endif">
                       <label for="marca-field">Marca</label>
                       {!! Form::text("marca", null, array("class" => "form-control", "id" => "marca-field")) !!}
                       @if($errors->has("marca"))
                        <span class="help-block">{{ $errors->first("marca") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('observaciones')) has-error @endif">
                       <label for="observaciones-field">Observaciones</label>
                       {!! Form::text("observaciones", null, array("class" => "form-control", "id" => "observaciones-field")) !!}
                       @if($errors->has("observaciones"))
                        <span class="help-block">{{ $errors->first("observaciones") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('existe_si')) has-error @endif">
                       <label for="existe_si-field">Existe si</label>
                       {!! Form::select("existe_si", $catExiste, null, array("class" => "form-control", "id" => "existe_si-field")) !!}
                       @if($errors->has("existe_si"))
                        <span class="help-block">{{ $errors->first("existe_si") }}</span>
                       @endif
                    </div>
                    
                    <div class="form-group col-md-4 @if($errors->has('estado_bueno')) has-error @endif">
                       <label for="estado_bueno-field">Estado bueno</label>
                       {!! Form::select("estado_bueno", $catEstado, null, array("class" => "form-control", "id" => "estado_bueno-field")) !!}
                       @if($errors->has("estado_bueno"))
                        <span class="help-block">{{ $errors->first("estado_bueno") }}</span>
                       @endif
                    </div>
                    
                    