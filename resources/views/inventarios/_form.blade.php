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
                    @if(isset($inventario))
                    <div class="form-group col-md-6 @if($errors->has('video1')) has-error @endif">
                        <div class="form-group col-sm-8">
                           <label for="video1-field">Archivo Video MP4 1</label>
                           {!! Form::file('video1', array('accept'=>"video/mp4")) !!}
                           @if($errors->has("video1"))
                           <span class="help-block">{{ $errors->first("video1") }}</span>
                           @endif
                        </div>
                        @if(!is_null($inventario->video1))
                        <div class="form-group col-sm-4">
                              <label for="origen">Ver</label>
                              <p class="form-control-static">
                              <a href="{{Storage::disk('do')->url($inventario->video1)}}" target="_blank">Ver</a>
                              </p>
                        </div>
                        @endif
                     </div>
                    <div class="form-group col-md-6 @if($errors->has('video2')) has-error @endif">
                        <div class="form-group col-sm-8">
                           <label for="video2-field">Archivo Video MP4 2</label>
                           {!! Form::file('video2', array('accept'=>"video/mp4")) !!}
                           @if($errors->has("video2"))
                           <span class="help-block">{{ $errors->first("video2") }}</span>
                           @endif
                        </div>
                        @if(!is_null($inventario->video2))
                        <div class="form-group col-sm-4">
                              <label for="origen">Ver</label>
                              <p class="form-control-static">
                              <a href="{{Storage::disk('do')->url($inventario->video2)}}" target="_blank">Ver</a>
                              </p>
                        </div>
                        @endif
                     </div>
                    <div class="form-group col-md-6 @if($errors->has('img1')) has-error @endif">
                        <div class="form-group col-sm-8">
                           <label for="img1-field">Imagen 1</label>
                           {!! Form::file('img1', array('accept'=>"image/jpeg")) !!}
                           @if($errors->has("img1"))
                           <span class="help-block">{{ $errors->first("img1") }}</span>
                           @endif
                        </div>
                        @if(!is_null($inventario->img1))
                        <div class="form-group col-sm-4">
                              <label for="origen">Ver</label>
                              <p class="form-control-static">
                              <a href="{{Storage::disk('do')->url($inventario->img1)}}"  target="_blank">Ver</a>
                              </p>
                        </div>
                        @endif
                    </div>
                    
                    <div class="form-group col-md-6 @if($errors->has('img2')) has-error @endif">
                        <div class="form-group col-sm-8">
                           <label for="img2-field">Imagen 2</label>
                           {!! Form::file('img2', array('accept'=>"image/jpeg")) !!}
                           @if($errors->has("img2"))
                           <span class="help-block">{{ $errors->first("img2") }}</span>
                           @endif
                        </div>
                        @if(!is_null($inventario->img2))
                        <div class="form-group col-sm-2">
                              <label for="origen">Ver</label>
                              <p class="form-control-static">
                              <a href="{{Storage::disk('do')->url($inventario->img2)}}"  target="_blank">Ver</a>
                              </p>
                        </div>
                        @endif
                     </div>
                    <div class="form-group col-md-6 @if($errors->has('img3')) has-error @endif">
                        <div class="form-group col-sm-8">
                           <label for="img3-field">Imagen 3</label>
                           {!! Form::file('img3', array('accept'=>"image/jpeg")) !!}
                           @if($errors->has("img3"))
                           <span class="help-block">{{ $errors->first("img3") }}</span>
                           @endif
                        </div>
                        @if(!is_null($inventario->img3))
                        <div class="form-group col-sm-2">
                              <label for="origen">Ver</label>
                              <p class="form-control-static">
                              <a href="{{Storage::disk('do')->url($inventario->img3)}}"  target="_blank">Ver</a>
                              </p>
                        </div>
                        @endif
                     </div>
                    <div class="form-group col-md-6 @if($errors->has('img4')) has-error @endif">
                        <div class="form-group col-sm-8">
                           <label for="img4-field">Imagen 4</label>
                           {!! Form::file('img4', array('accept'=>"image/jpeg")) !!}
                           @if($errors->has("img4"))
                           <span class="help-block">{{ $errors->first("img4") }}</span>
                           @endif
                        </div>
                        @if(!is_null($inventario->img4))
                        <div class="form-group col-sm-2">
                              <label for="origen">Ver</label>
                              <p class="form-control-static">
                              <a href="{{Storage::disk('do')->url($inventario->img4)}}"  target="_blank">Ver</a>
                              </p>
                        </div>
                        @endif
                     </div>
                    <div class="form-group col-md-6 @if($errors->has('img5')) has-error @endif">
                        <div class="form-group col-sm-8">
                           <label for="img5-field">Imagen 5</label>
                           {!! Form::file('img5', array('accept'=>"image/jpeg")) !!}
                           @if($errors->has("img5"))
                           <span class="help-block">{{ $errors->first("img5") }}</span>
                           @endif
                        </div>
                        @if(!is_null($inventario->img5))
                        <div class="form-group col-sm-2">
                              <label for="origen">Ver</label>
                              <p class="form-control-static">
                              <a href="{{Storage::disk('do')->url($inventario->img5)}}"  target="_blank">Ver</a>
                              </p>
                        </div>
                        @endif
                    </div>
                    <div class="form-group col-md-6 @if($errors->has('img6')) has-error @endif">
                        <div class="form-group col-sm-8">
                              <label for="img6-field">Imagen 6</label>
                              {!! Form::file('img6', array('accept'=>"image/jpeg")) !!}
                              @if($errors->has("img6"))
                              <span class="help-block">{{ $errors->first("img6") }}</span>
                              @endif
                        </div>
                        @if(!is_null($inventario->img6))
                        <div class="form-group col-sm-2">
                              <label for="origen">Ver</label>
                              <p class="form-control-static">
                              <a href="{{Storage::disk('do')->url($inventario->img6)}}"  target="_blank">Ver</a>
                              </p>
                        </div>
                        @endif
                     </div>
                    @endif