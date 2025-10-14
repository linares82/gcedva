                
                    <div class="form-group col-md-4 @if($errors->has('name')) has-error @endif">
                       <label for="name-field">Nombre</label>
                       {!! Form::text("name", null, array("class" => "form-control", "id" => "name-field")) !!}
                       @if($errors->has("name"))
                        <span class="help-block">{{ $errors->first("name") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if ($errors->has('titulacion_grupo_id')) has-error @endif">
                       <label for="titulacion_grupo_id-field">Grupo</label>
                       {!! Form::select('titulacion_grupo_id', $list['TitulacionGrupo'], null, [
                           'class' => 'form-control select_seguridad',
                           'id' => 'titulacion_grupo_id-field',
                       ]) !!}
                       @if ($errors->has('titulacion_grupo_id'))
                           <span class="help-block">{{ $errors->first('titulacion_grupo_id') }}</span>
                       @endif
                   </div>
                    <div class="form-group col-md-12 @if($errors->has('clientes')) has-error @endif">
                       <label for="clientes-field">Clientes (id's separados por "," y sin espacios)</label>
                       {!! Form::textArea("clientes", null, array("class" => "form-control", "id" => "clientes-field", 'rows'=>'3')) !!}
                       @if($errors->has("clientes"))
                        <span class="help-block">{{ $errors->first("clientes") }}</span>
                       @endif
                    </div>
                    
                    