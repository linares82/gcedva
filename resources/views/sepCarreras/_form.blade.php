                <div class="form-group @if($errors->has('cve_carrera')) has-error @endif">
                       <label for="cve_carrera-field">Cve_carrera</label>
                       {!! Form::text("cve_carrera", null, array("class" => "form-control", "id" => "cve_carrera-field")) !!}
                       @if($errors->has("cve_carrera"))
                        <span class="help-block">{{ $errors->first("cve_carrera") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('descripcion')) has-error @endif">
                       <label for="descripcion-field">Descripcion</label>
                       {!! Form::text("descripcion", null, array("class" => "form-control", "id" => "descripcion-field")) !!}
                       @if($errors->has("descripcion"))
                        <span class="help-block">{{ $errors->first("descripcion") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('id_area')) has-error @endif">
                       <label for="id_area-field">Id_area</label>
                       {!! Form::text("id_area", null, array("class" => "form-control", "id" => "id_area-field")) !!}
                       @if($errors->has("id_area"))
                        <span class="help-block">{{ $errors->first("id_area") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('area')) has-error @endif">
                       <label for="area-field">Area</label>
                       {!! Form::text("area", null, array("class" => "form-control", "id" => "area-field")) !!}
                       @if($errors->has("area"))
                        <span class="help-block">{{ $errors->first("area") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('cve_subarea')) has-error @endif">
                       <label for="cve_subarea-field">Cve_subarea</label>
                       {!! Form::text("cve_subarea", null, array("class" => "form-control", "id" => "cve_subarea-field")) !!}
                       @if($errors->has("cve_subarea"))
                        <span class="help-block">{{ $errors->first("cve_subarea") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('area')) has-error @endif">
                       <label for="area-field">Area</label>
                       {!! Form::text("area", null, array("class" => "form-control", "id" => "area-field")) !!}
                       @if($errors->has("area"))
                        <span class="help-block">{{ $errors->first("area") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('id_nivel_sirep')) has-error @endif">
                       <label for="id_nivel_sirep-field">Id_nivel_sirep</label>
                       {!! Form::text("id_nivel_sirep", null, array("class" => "form-control", "id" => "id_nivel_sirep-field")) !!}
                       @if($errors->has("id_nivel_sirep"))
                        <span class="help-block">{{ $errors->first("id_nivel_sirep") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('nivel_educativo')) has-error @endif">
                       <label for="nivel_educativo-field">Nivel_educativo</label>
                       {!! Form::text("nivel_educativo", null, array("class" => "form-control", "id" => "nivel_educativo-field")) !!}
                       @if($errors->has("nivel_educativo"))
                        <span class="help-block">{{ $errors->first("nivel_educativo") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('num_rvoe')) has-error @endif">
                       <label for="num_rvoe-field">Num_rvoe</label>
                       {!! Form::text("num_rvoe", null, array("class" => "form-control", "id" => "num_rvoe-field")) !!}
                       @if($errors->has("num_rvoe"))
                        <span class="help-block">{{ $errors->first("num_rvoe") }}</span>
                       @endif
                    </div>