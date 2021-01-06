<div class="col-md-4">
   <div class="form-group @if($errors->has('categoria_ticket_id')) has-error @endif">
      <label for="categoria_ticket_id-field">Categoria</label>
      {!! Form::select("categoria_ticket_id", $list["CategoriaTicket"], null, array("class" => "form-control select_seguridad", "id" => "categoria_ticket_id-field")) !!}
      @if($errors->has("categoria_ticket_id"))
       <span class="help-block">{{ $errors->first("categoria_ticket_id") }}</span>
      @endif
   </div>
   <div class="form-group form-group @if($errors->has('nombre_corto')) has-error @endif">
    <label for="nombre_corto-field">Nombre Corto</label>
    {!! Form::text("nombre_corto", null, array("class" => "form-control", "id" => "nombre_corto-field")) !!}
    @if($errors->has("nombre_corto"))
     <span class="help-block">{{ $errors->first("nombre_corto") }}</span>
    @endif
 </div>
 <div class="form-group form-group @if($errors->has('fecha')) has-error @endif">
    <label for="fecha-field">Fecha</label>
    {!! Form::text("fecha", null, array("class" => "form-control fecha", "id" => "fecha-field")) !!}
    @if($errors->has("fecha"))
     <span class="help-block">{{ $errors->first("fecha") }}</span>
    @endif
 </div>
   
   
   <div class="form-group @if($errors->has('prioridad_id')) has-error @endif">
    <label for="prioridad_id-field">Prioridad</label>
    {!! Form::select("prioridad_ticket_id", $list["PrioridadTicket"], null, array("class" => "form-control select_seguridad", "id" => "prioridad_ticket_id-field")) !!}
    @if($errors->has("prioridad_id"))
     <span class="help-block">{{ $errors->first("prioridad_id") }}</span>
    @endif
 </div>
   <div class="form-group @if($errors->has('asignado_a')) has-error @endif">
      <label for="asignado_a-field">Asignado A</label>
      {!! Form::select("asignado_a", $users, null, array("class" => "form-control select_seguridad", "id" => "asignado_a-field")) !!}
      @if($errors->has("asignado_a"))
       <span class="help-block">{{ $errors->first("asignado_a") }}</span>
      @endif
   </div>
   <div class="form-group @if($errors->has('st_ticket_id')) has-error @endif">
      <label for="st_ticket_id-field">Estatus</label></label>
      {!! Form::select("st_ticket_id", $list["StTicket"], null, array("class" => "form-control select_seguridad", "id" => "st_ticket_id-field")) !!}
      @if($errors->has("st_ticket_id"))
       <span class="help-block">{{ $errors->first("st_ticket_id") }}</span>
      @endif
   </div>
</div>
<div class="col-md-8">
   <div class="form-group form-group col-md-12 @if($errors->has('detalle')) has-error @endif">
      <label for="detalle-field">Detalle</label>
      {!! Form::textArea("detalle", null, array("class" => "form-control", "id" => "detalle-field", "rows"=>'3')) !!}
      @if($errors->has("detalle"))
       <span class="help-block">{{ $errors->first("detalle") }}</span>
      @endif
   </div>
   <div class="form-group col-md-4 @if($errors->has('etiquetas')) has-error @endif">
      <label for="etiquetas-field">Etiquetas</label></label>
      {!! Form::select("etiquetas[]", $etiquetas, null, array("class" => "form-control select_seguridad", "id" => "etiquetas-field", 'multiple'=>true)) !!}
      @if($errors->has("etiquetas"))
       <span class="help-block">{{ $errors->first("st_ticket_id") }}</span>
      @endif
   </div>
</div>
                  
                    

                    