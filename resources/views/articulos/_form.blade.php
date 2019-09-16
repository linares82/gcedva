                <div class="form-group col-md-4 @if($errors->has('name')) has-error @endif">
                       <label for="name-field">Articulo</label>
                       {!! Form::text("name", null, array("class" => "form-control", "id" => "name-field")) !!}
                       @if($errors->has("name"))
                        <span class="help-block">{{ $errors->first("name") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('unidad_uso')) has-error @endif">
                       <label for="unidad_uso-field">Unidad Uso</label>
                       {!! Form::select("unidad_uso", $unidades, null, array("class" => "form-control select_seguridad", "id" => "unidad_uso-field")) !!}
                       @if($errors->has("unidad_uso"))
                        <span class="help-block">{{ $errors->first("unidad_uso") }}</span>
                       @endif
                    </div>
                    
                    <div class="form-group col-md-4 @if($errors->has('categoria_id')) has-error @endif">
                       <label for="categoria_id-field">Categoria</label>
                       {!! Form::select("categoria_articulo_id", $list["CategoriaArticulo"], null, array("class" => "form-control select_seguridad", "id" => "categoria_articulo_id-field")) !!}
                       @if($errors->has("categoria_id"))
                        <span class="help-block">{{ $errors->first("categoria_id") }}</span>
                       @endif
                    </div>
                    