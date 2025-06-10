                <div class="form-group @if($errors->has('name')) has-error @endif">
                       <label for="name-field">Name</label>
                       {!! Form::text("name", null, array("class" => "form-control", "id" => "name-field")) !!}
                       @if($errors->has("name"))
                        <span class="help-block">{{ $errors->first("name") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('cve_sep_cert')) has-error @endif">
                       <label for="cve_sep_cert-field">Cve_sep_cert</label>
                       {!! Form::text("cve_sep_cert", null, array("class" => "form-control", "id" => "cve_sep_cert-field")) !!}
                       @if($errors->has("cve_sep_cert"))
                        <span class="help-block">{{ $errors->first("cve_sep_cert") }}</span>
                       @endif
                    </div>