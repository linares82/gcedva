                <div class="form-group col-md-4 @if($errors->has('name')) has-error @endif">
                       <label for="name-field">Documento</label>
                       {!! Form::text("name", null, array("class" => "form-control input-sm", "id" => "name-field")) !!}
                       @if($errors->has("name"))
                        <span class="help-block">{{ $errors->first("name") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('doc_ebligatorio')) has-error @endif">
                       <label for="doc_obligatorio-field">Obligatorio</label>
                       {!! Form::checkbox("doc_obligatorio", 1, null, [ "id" => "doc_obligatorio-field"]) !!}
                       @if($errors->has("doc_obligatorio"))
                        <span class="help-block">{{ $errors->first("doc_obligatorio") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('bnd_portal_alumnos')) has-error @endif">
                            <label for="bnd_portal_alumnos-field">¿Portal Alumnos?</label>
                            {!! Form::checkbox("bnd_portal_alumnos", 1, null, [ "id" => "bnd_portal_alumnos-field", 'class'=>'minimal']) !!}
                            @if($errors->has("bnd_portal_alumnos"))
                            <span class="help-block">{{ $errors->first("bnd_portal_alumnos") }}</span>
                            @endif
                        </div>
                     <div class="form-group col-md-4 @if($errors->has('bnd_pdf')) has-error @endif">
                            <label for="bnd_pdf-field">¿PDF?</label>
                            {!! Form::checkbox("bnd_pdf", 1, null, [ "id" => "bnd_pdf-field", 'class'=>'minimal']) !!}
                            @if($errors->has("bnd_pdf"))
                            <span class="help-block">{{ $errors->first("bnd_pdf") }}</span>
                            @endif
                        </div>
                    <div class="form-group col-md-4 @if($errors->has('bnd_imagen')) has-error @endif">
                            <label for="bnd_imagen-field">¿Imagen?</label>
                            {!! Form::checkbox("bnd_imagen", 1, null, [ "id" => "bnd_imagen-field", 'class'=>'minimal']) !!}
                            @if($errors->has("bnd_imagen"))
                            <span class="help-block">{{ $errors->first("bnd_imagen") }}</span>
                            @endif
                        </div>
                    