                <div class="form-group col-md-4 @if($errors->has('name')) has-error @endif">
                       <label for="name-field">Name</label>
                       {!! Form::text("name", null, array("class" => "form-control", "id" => "name-field")) !!}
                       @if($errors->has("name"))
                        <span class="help-block">{{ $errors->first("name") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('email')) has-error @endif">
                       <label for="email-field">Email</label>
                       {!! Form::text("email", null, array("class" => "form-control", "id" => "email-field")) !!}
                       @if($errors->has("email"))
                        <span class="help-block">{{ $errors->first("email") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('password')) has-error @endif">
                       <label for="password-field">Password</label>
                       {!! Form::text("password", null, array("class" => "form-control", "id" => "password-field")) !!}
                       @if($errors->has("password"))
                        <span class="help-block">{{ $errors->first("password") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('nivel')) has-error @endif">
                       <label for="nivel-field">Nivel</label>
                       {!! Form::text("nivel", null, array("class" => "form-control", "id" => "nivel-field")) !!}
                       @if($errors->has("nivel"))
                        <span class="help-block">{{ $errors->first("nivel") }}</span>
                       @endif
                    </div>
                    