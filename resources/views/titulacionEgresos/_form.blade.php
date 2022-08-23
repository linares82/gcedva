
                    <div class="form-group col-md-4 @if($errors->has('titulacion_concepto_id')) has-error @endif">
                       <label for="titulacion_concepto_id-field">Concepto</label>
                       {!! Form::hidden("titulacion_grupo_id", isset($titulacionGrupo) ? $titulacionGrupo : $titulacionEgreso->titulacion_grupo_id, array("class" => "form-control", "id" => "titulacion_grupo_id-field")) !!}
                       {!! Form::select("titulacion_concepto_id", $list["TitulacionConcepto"], null, array("class" => "form-control", "id" => "titulacion_concepto_id-field")) !!}
                       @if($errors->has("titulacion_concepto_id"))
                        <span class="help-block">{{ $errors->first("titulacion_concepto_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('fecha')) has-error @endif">
                       <label for="fecha-field">Fecha</label>
                       {!! Form::text("fecha", null, array("class" => "form-control fecha", "id" => "fecha-field")) !!}
                       @if($errors->has("fecha"))
                        <span class="help-block">{{ $errors->first("fecha") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('complemento')) has-error @endif">
                       <label for="complemento-field">Complemento</label>
                       {!! Form::text("complemento", null, array("class" => "form-control", "id" => "complemento-field")) !!}
                       @if($errors->has("complemento"))
                        <span class="help-block">{{ $errors->first("complemento") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-2 @if($errors->has('no_alumnos')) has-error @endif">
                       <label for="no_alumnos-field">No. Alumnos</label>
                       {!! Form::text("no_alumnos", null, array("class" => "form-control", "id" => "no_alumnos-field")) !!}
                       @if($errors->has("no_alumnos"))
                        <span class="help-block">{{ $errors->first("no_alumnos") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-2 @if($errors->has('cantidad')) has-error @endif">
                       <label for="cantidad-field">Cantidad(Grupo/Equipo/Sinodal)</label>
                       {!! Form::text("cantidad", null, array("class" => "form-control", "id" => "cantidad-field")) !!}
                       @if($errors->has("cantidad"))
                        <span class="help-block">{{ $errors->first("cantidad") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-2 @if($errors->has('no_horas')) has-error @endif">
                       <label for="no_horas-field">No. Horas</label>
                       {!! Form::text("no_horas", null, array("class" => "form-control", "id" => "no_horas-field")) !!}
                       @if($errors->has("no_horas"))
                        <span class="help-block">{{ $errors->first("no_horas") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-2 @if($errors->has('costo_unitario')) has-error @endif">
                       <label for="costo_unitario-field">Costo Unitario</label>
                       {!! Form::text("costo_unitario", null, array("class" => "form-control", "id" => "costo_unitario-field")) !!}
                       @if($errors->has("costo_unitario"))
                        <span class="help-block">{{ $errors->first("costo_unitario") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-2 @if($errors->has('monto_total')) has-error @endif">
                       <label for="monto-field">Monto Total</label>
                       {!! Form::text("monto_total", null, array("class" => "form-control", "id" => "monto_total-field")) !!}
                       @if($errors->has("monto_total"))
                        <span class="help-block">{{ $errors->first("monto_total") }}</span>
                       @endif
                    </div>
                    <div class="row"></div>
                    <div class="form-group col-md-4 @if($errors->has('observacion')) has-error @endif">
                       <label for="observacion-field">Observaciones</label>
                       {!! Form::text("observacion", null, array("class" => "form-control", "id" => "observacion-field")) !!}
                       @if($errors->has("observacion"))
                        <span class="help-block">{{ $errors->first("observacion") }}</span>
                       @endif
                    </div>

@push('scripts')
<script type="text/javascript">
$(document).ready(function() {
   $('#no_alumnos-field').val(0);
   $('#cantidad-field').val(0);
   $('#no_horas-field').val(0);
   $('#costo_unitario-field').val(0);
   $('#monto_total-field').val(0);

});                    

$('#no_alumnos-field').change(function(){
   calcularTotal();
});
$('#cantidad-field').change(function(){
   calcularTotal();
});
$('#no_horas-field').change(function(){
   calcularTotal();
});
$('#costo_unitario-field').change(function(){
   calcularTotal();
});
$('#monto_total-field').change(function(){
   calcularTotal();
});

function calcularTotal(){
   no_alumnos= $('#no_alumnos-field').val()==0 ? 1 :$('#no_alumnos-field').val() ;
   cantidad=$('#cantidad-field').val()==0 ? 1 : $('#cantidad-field').val();
   no_horas=$('#no_horas-field').val() ==0 ? 1 : $('#no_horas-field').val();
   costo_unitario=$('#costo_unitario-field').val()==0 ? 1 : $('#costo_unitario-field').val();
   $('#monto_total-field').val(no_alumnos*cantidad*no_horas*costo_unitario)
}
</script>
@endpush