                
                    <div class="form-group col-md-4 @if($errors->has('examen_id')) has-error @endif">
                       <label for="examen_id-field">Lectivo</label>
                       {!! Form::select("lectivo_id", $lectivos, null, array("class" => "form-control select_seguridad", "id" => "lectivo_id-field")) !!}
                       @if($errors->has("examen_id"))
                        <span class="help-block">{{ $errors->first("examen_id") }}</span>
                       @endif
                    </div>

                    