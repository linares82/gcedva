                  <div class="form-group col-md-4 @if($errors->has('asignado_a')) has-error @endif">
                     <label for="detalle-field">{!! Form::radio('bnd_notificacion', '1') !!}Notificacion</label>
                     <label for="detalle-field">{!! Form::radio('bnd_notificacion', '0') !!}Nota</label>                     
                  </div>
                    <div class="form-group col-md-12 @if($errors->has('detalle')) has-error @endif">
                       <label for="detalle-field">Detalle</label>
                       {!! Form::hidden("ticket_id", $ticket->id, array("class" => "form-control", "id" => "ticket_id-field")) !!}
                       {!! Form::text("detalle", null, array("class" => "form-control", "id" => "detalle-field")) !!}
                       @if($errors->has("detalle"))
                        <span class="help-block">{{ $errors->first("detalle") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('asignado_a')) has-error @endif">
                     <label for="asignado_a-field">Asignado A</label>
                     {!! Form::select("asignado_a", $list["User"], $ticket->asignado_a, array("class" => "form-control select_seguridad", "id" => "asignado_a-field")) !!}
                     @if($errors->has("asignado_a"))
                      <span class="help-block">{{ $errors->first("asignado_a") }}</span>
                     @endif
                  </div>
                  <div class="form-group col-md-4 @if($errors->has('st_ticket_id')) has-error @endif">
                     <label for="st_ticket_id-field">Estatus</label></label>
                     {!! Form::select("st_ticket_id", $list["StTicket"], $ticket->st_ticket_id, array("class" => "form-control select_seguridad", "id" => "st_ticket_id-field")) !!}
                     @if($errors->has("st_ticket_id"))
                      <span class="help-block">{{ $errors->first("st_ticket_id") }}</span>
                     @endif
                  </div>
                    