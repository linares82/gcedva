                <div class="form-group col-md-4 @if ($errors->has('plantel_id')) has-error @endif">
                    <label for="plantel_id-field">Plantel</label>
                    {!! Form::select('plantel_id', $planteles, null, [
                        'class' => 'form-control select_seguridad',
                        'id' => 'plantel_id-field',
                    ]) !!}
                    @if ($errors->has('plantel_id'))
                        <span class="help-block">{{ $errors->first('plantel_id') }}</span>
                    @endif
                </div>
                <div class="form-group col-md-12 @if ($errors->has('nombre')) has-error @endif">
                    <label for="nombre-field">Nombre</label>
                    {!! Form::text('nombre', null, ['class' => 'form-control', 'id' => 'nombre-field']) !!}
                    @if ($errors->has('nombre'))
                        <span class="help-block">{{ $errors->first('nombre') }}</span>
                    @endif
                </div>
                <!--
                    <div class="form-group col-md-4 @if ($errors->has('nombre2')) has-error @endif">
                       <label for="nombre2-field">Segundo Nombre</label>
                       {!! Form::text('nombre2', null, ['class' => 'form-control', 'id' => 'nombre2-field']) !!}
                       @if ($errors->has('nombre2'))
<span class="help-block">{{ $errors->first('nombre2') }}</span>
@endif
                    </div>
                    <div class="form-group col-md-4 @if ($errors->has('ape_paterno')) has-error @endif">
                       <label for="ape_paterno-field">A. Paterno</label>
                       {!! Form::text('ape_paterno', null, ['class' => 'form-control', 'id' => 'ape_paterno-field']) !!}
                       @if ($errors->has('ape_paterno'))
<span class="help-block">{{ $errors->first('ape_paterno') }}</span>
@endif
                    </div>
                    <div class="form-group col-md-4 @if ($errors->has('ape_materno')) has-error @endif">
                       <label for="ape_materno-field">A. Materno</label>
                       {!! Form::text('ape_materno', null, ['class' => 'form-control', 'id' => 'ape_materno-field']) !!}
                       @if ($errors->has('ape_materno'))
<span class="help-block">{{ $errors->first('ape_materno') }}</span>
@endif
                    </div>
                  -->
                <!--<div class="form-group col-md-4 @if ($errors->has('tel_fijo')) has-error @endif">
                       <label for="tel_fijo-field">Tel. Fijo</label>
                       {!! Form::text('tel_fijo', null, ['class' => 'form-control', 'id' => 'tel_fijo-field']) !!}
                       @if ($errors->has('tel_fijo'))
<span class="help-block">{{ $errors->first('tel_fijo') }}</span>
@endif
                    </div>
                  -->
                <div class="form-group col-md-4 @if ($errors->has('tel_cel')) has-error @endif">
                    <label for="tel_cel-field">Tel. Cel</label>
                    {!! Form::text('tel_cel', null, ['class' => 'form-control', 'id' => 'tel_cel-field']) !!}
                    @if ($errors->has('tel_cel'))
                        <span class="help-block">{{ $errors->first('tel_cel') }}</span>
                    @endif
                </div>
                <!--
                    <div class="form-group col-md-4 @if ($errors->has('email')) has-error @endif">
                       <label for="email-field">Email</label>
                       {!! Form::text('email', null, ['class' => 'form-control', 'id' => 'email-field']) !!}
                       @if ($errors->has('email'))
<span class="help-block">{{ $errors->first('email') }}</span>
@endif
                    </div>
                  -->
                <div class="form-group col-md-4 @if ($errors->has('medio_id')) has-error @endif">
                    <label for="medio_id-field">Medio</label>
                    {!! Form::select('medio_id', $medios, null, ['class' => 'form-control', 'id' => 'medio_id-field']) !!}
                    @if ($errors->has('medio_id'))
                        <span class="help-block">{{ $errors->first('medio_id') }}</span>
                    @endif
                </div>
                <div class="form-group col-md-4 @if ($errors->has('ciclo_interesado')) has-error @endif">
                    <label for="ciclo_interesado-field">Ciclo Interesado</label>
                    {!! Form::text('ciclo_interesado', null, ['class' => 'form-control', 'id' => 'ciclo_interesado-field']) !!}
                    @if ($errors->has('ciclo_interesado'))
                        <span class="help-block">{{ $errors->first('ciclo_interesado') }}</span>
                    @endif
                </div>
                <div class="form-group col-md-12 @if ($errors->has('observaciones')) has-error @endif">
                    <label for="observaciones-field">Observaciones</label>
                    {!! Form::textArea('observaciones', null, [
                        'class' => 'form-control',
                        'id' => 'observaciones-field',
                        'rows' => 3,
                    ]) !!}
                    @if ($errors->has('observaciones'))
                        <span class="help-block">{{ $errors->first('observaciones') }}</span>
                    @endif
                </div>
                <!--
                    <div class="form-group col-md-4 @if ($errors->has('st_lead_id')) has-error @endif">
                       <label for="st_lead_id-field">St_lead_name</label>
                       {!! Form::select('st_lead_id', $list['StLead'], null, ['class' => 'form-control', 'id' => 'st_lead_id-field']) !!}
                       @if ($errors->has('st_lead_id'))
<span class="help-block">{{ $errors->first('st_lead_id') }}</span>
@endif
                    </div>
                  -->
