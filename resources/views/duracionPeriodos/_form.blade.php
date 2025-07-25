<div class="form-group col-md-4 @if($errors->has('name')) has-error @endif">
      <label for="name-field">Name</label>
      {!! Form::text("name", null, array("class" => "form-control", "id" => "name-field")) !!}
      @if($errors->has("name"))
      <span class="help-block">{{ $errors->first("name") }}</span>
      @endif
   </div>
   <div class="form-group col-md-4 @if($errors->has('bloqueo_cantidad_reprobadas')) has-error @endif">
      <label for="bloqueo_cantidad_reprobadas-field">Bloqueo por Materias Reprobadas</label>
      {!! Form::text("bloqueo_cantidad_reprobadas", null, array("class" => "form-control", "id" => "bloqueo_cantidad_reprobadas-field")) !!}
      @if($errors->has("bloqueo_cantidad_reprobadas"))
      <span class="help-block">{{ $errors->first("bloqueo_cantidad_reprobadas") }}</span>
      @endif
   </div>
   <div class="form-group col-md-4 @if($errors->has('id_tipo_periodo_certificado')) has-error @endif">
      <label for="id_tipo_periodo_certificado-field">Certificado-Tipo Periodo</label>
      {!! Form::text("id_tipo_periodo_certificado", null, array("class" => "form-control", "id" => "id_tipo_periodo_certificado-field")) !!}
      @if($errors->has("id_tipo_periodo_certificado"))
      <span class="help-block">{{ $errors->first("id_tipo_periodo_certificado") }}</span>
      @endif
   </div>                