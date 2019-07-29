                <div class="form-group @if($errors->has('doc_plantel_id')) has-error @endif">
                       <label for="doc_plantel_id-field">Doc_plantel_name</label>
                       {!! Form::select("doc_plantel_id", $list["DocPlantel"], null, array("class" => "form-control", "id" => "doc_plantel_id-field")) !!}
                       @if($errors->has("doc_plantel_id"))
                        <span class="help-block">{{ $errors->first("doc_plantel_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('plantel_id')) has-error @endif">
                       <label for="plantel_id-field">Plantel_razon</label>
                       {!! Form::select("plantel_id", $list["Plantel"], null, array("class" => "form-control", "id" => "plantel_id-field")) !!}
                       @if($errors->has("plantel_id"))
                        <span class="help-block">{{ $errors->first("plantel_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('fec_vigencia')) has-error @endif">
                       <label for="fec_vigencia-field">Fec_vigencia</label>
                       {!! Form::text("fec_vigencia", null, array("class" => "form-control", "id" => "fec_vigencia-field")) !!}
                       @if($errors->has("fec_vigencia"))
                        <span class="help-block">{{ $errors->first("fec_vigencia") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('usu_alta_id')) has-error @endif">
                       <label for="usu_alta_id-field">Usu_alta_id</label>
                       {!! Form::text("usu_alta_id", null, array("class" => "form-control", "id" => "usu_alta_id-field")) !!}
                       @if($errors->has("usu_alta_id"))
                        <span class="help-block">{{ $errors->first("usu_alta_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('usu_mod_id')) has-error @endif">
                       <label for="usu_mod_id-field">Usu_mod_id</label>
                       {!! Form::text("usu_mod_id", null, array("class" => "form-control", "id" => "usu_mod_id-field")) !!}
                       @if($errors->has("usu_mod_id"))
                        <span class="help-block">{{ $errors->first("usu_mod_id") }}</span>
                       @endif
                    </div>