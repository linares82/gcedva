                <div class="form-group @if($errors->has('prospecto_id')) has-error @endif">
                       <label for="prospecto_id-field">Prospecto_Nombre</label>
                       {!! Form::select("prospecto_id", $list["Prospecto"], null, array("class" => "form-control", "id" => "prospecto_id-field")) !!}
                       @if($errors->has("prospecto_id"))
                        <span class="help-block">{{ $errors->first("prospecto_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('prospecto_st_seg_id')) has-error @endif">
                       <label for="prospecto_st_seg_id-field">Prospecto_st_seg_id</label>
                       {!! Form::text("prospecto_st_seg_id", null, array("class" => "form-control", "id" => "prospecto_st_seg_id-field")) !!}
                       @if($errors->has("prospecto_st_seg_id"))
                        <span class="help-block">{{ $errors->first("prospecto_st_seg_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('mes')) has-error @endif">
                       <label for="mes-field">Mes</label>
                       {!! Form::text("mes", null, array("class" => "form-control", "id" => "mes-field")) !!}
                       @if($errors->has("mes"))
                        <span class="help-block">{{ $errors->first("mes") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('contador_sms')) has-error @endif">
                       <label for="contador_sms-field">Contador_sms</label>
                       {!! Form::text("contador_sms", null, array("class" => "form-control", "id" => "contador_sms-field")) !!}
                       @if($errors->has("contador_sms"))
                        <span class="help-block">{{ $errors->first("contador_sms") }}</span>
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