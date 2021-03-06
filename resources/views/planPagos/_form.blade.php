<div class="box box-default box-solid">
                    <div class="box-header">
                        <h3 class="box-title">PLAN PAGOS</h3>
                        <div class="box-tools">
                            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                    <div class="form-group col-md-4 @if($errors->has('name')) has-error @endif">
                       <label for="name-field">Plan Pago</label>
                       {!! Form::text("name", null, array("class" => "form-control", "id" => "name-field")) !!}
                       @if($errors->has("name"))
                        <span class="help-block">{{ $errors->first("name") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('ciclo_matricula_id')) has-error @endif">
                     <label for="ciclo_matricula_id-field">Ciclo</label>
                     {!! Form::select("ciclo_matricula_id", $list["CicloMatricula"], null, array("class" => "form-control select_seguridad", "id" => "ciclo_matricula_id-field")) !!}
                     @if($errors->has("ciclo_matricula_id"))
                      <span class="help-block">{{ $errors->first("ciclo_matricula_id") }}</span>
                     @endif
                  </div>
                    <div class="form-group @if($errors->has('activo')) has-error @endif">
                       <label for="activo-field">Activo</label>
                       {!! Form::checkbox("activo", 1, null, [ "id" => "activo-field"]) !!}
                       @if($errors->has("activo"))
                        <span class="help-block">{{ $errors->first("activo") }}</span>
                       @endif
                    </div>
                   </div>
</div>


@if(isset($planPago->id) and count($planPago->lineas)==0)
<div class="box box-default box-solid collapsed-box">
                    <div class="box-header">
                        <h3 class="box-title">GENERAR PAGOS AUTOMATICOS</h3>
                        <div class="box-tools">
                            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="box-body collapse">
                    <div class="form-group col-md-4 @if($errors->has('name')) has-error @endif">
                       <label for="incripcion-field">Monto Inscripcion $</label>
                       {!! Form::text("inscripcion", null, array("class" => "form-control", "id" => "inscripcion-field")) !!}
                       @if($errors->has("inscripcion"))
                        <span class="help-block">{{ $errors->first("inscripcion") }}</span>
                       @endif
                    </div>
                        
                    <div class="form-group col-md-4 @if($errors->has('uniforme')) has-error @endif">
                       <label for="uniforme-field">Monto Uniforme $</label>
                       {!! Form::text("uniforme", null, array("class" => "form-control", "id" => "uniforme-field")) !!}
                       @if($errors->has("uniforme"))
                        <span class="help-block">{{ $errors->first("uniforme") }}</span>
                       @endif
                    </div>
                    
                    <div class="form-group col-md-4 @if($errors->has('tramites')) has-error @endif">
                       <label for="tramites-field">Monto Tramites Administrativo $</label>
                       {!! Form::text("tramites", null, array("class" => "form-control", "id" => "tramites-field")) !!}
                       @if($errors->has("tramites"))
                        <span class="help-block">{{ $errors->first("tramites") }}</span>
                       @endif
                    </div>
                        
                    <div class="form-group col-md-4 @if($errors->has('mensualidad')) has-error @endif">
                       <label for="mensualidad-field">Monto Mensualidad $</label>
                       {!! Form::text("mensualidad", null, array("class" => "form-control", "id" => "mensualidad-field")) !!}
                       @if($errors->has("mensualidad"))
                        <span class="help-block">{{ $errors->first("mensualidad") }}</span>
                       @endif
                    </div>
                    
                    <div class="form-group col-md-4 @if($errors->has('cuantas_mensualidad')) has-error @endif">
                       <label for="cuantas_mensualidad-field">Cuantas Mensualidades </label>
                       {!! Form::number("cuantas_mensualidad", null, array("class" => "form-control", "id" => "cuantas_mensualidad-field", "min"=>"1", "max"=>"31")) !!}
                       @if($errors->has("cuantas_mensualidad"))
                        <span class="help-block">{{ $errors->first("cuantas_mensualidad") }}</span>
                       @endif
                    </div>
                    
                    <div class="form-group col-md-4 @if($errors->has('fecha_pago')) has-error @endif">
                            <label for="fecha_pago-field">Dia Pago Mensualidad</label>
                            {!! Form::text("fecha_pago", null, array("class" => "form-control", "id" => "fecha_pago-field")) !!}
                            @if($errors->has("fecha_pago"))
                            <span class="help-block">{{ $errors->first("fecha_pago") }}</span>
                            @endif
                    </div>
                    
                    <div class="form-group col-md-4 @if($errors->has('seguro')) has-error @endif">
                       <label for="seguro-field">Monto Seguro $</label>
                       {!! Form::text("seguro", null, array("class" => "form-control", "id" => "seguro-field")) !!}
                       @if($errors->has("seguro"))
                        <span class="help-block">{{ $errors->first("seguro") }}</span>
                       @endif
                    </div>
                    
                    
                        
                   </div>
</div>
<div class="box box-default box-solid collapsed-box">
   <div class="box-header">
       <h3 class="box-title">GENERAR PAGOS DEFINIR</h3>
       <div class="box-tools">
           <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
       </div>
   </div>
   <div class="box-body collapse">
      <div id="repetirFrm">
         <div class="col-xs-12">
            
            <div class="form-group col-md-2 has-error">
               <label for="caja_concepto_id-field">Caja Concepto</label><br/>
                  {!! Form::select("caja_concepto_id[]", $list2["CajaConcepto"], null, array("class" => "form-control select_seguridad1", "id" => "caja_concepto_id-crear","data-validacion-tipo"=>"requerido")) !!}
                  {!! Form::hidden("plan_pago_id[]", $planPago->id, array("class" => "form-control", "id" => "plan_pago_id-crear")) !!}
            </div>
            <div class="form-group col-md-2 has-error">
               <label for="cuenta_contable_id-field">Cuenta Contable</label><br/>
               {!! Form::select("cuenta_contable_id[]", $list2["CuentaContable"], null, array("class" => "form-control select_seguridad1", "id" => "cuenta_contable_id-crear","data-validacion-tipo"=>"requerido")) !!}
            </div>
            <div class="form-group col-md-2 has-error">
               <label for="cuenta_recargo_id-field">Cuenta Recargo</label><br/>
               {!! Form::select("cuenta_recargo_id[]", $list2["CuentaContable"], null, array("class" => "form-control select_seguridad1", "id" => "cuenta_recargo_id-crear","data-validacion-tipo"=>"requerido")) !!}
            </div>
            <div class="form-group col-md-2 has-error">
               <label for="fecha_p-field">Fecha Pago</label>
               {!! Form::text("fecha_p[]", null, array("class" => "form-control fecha_calendario", "id" => "fecha_p-crear","data-validacion-tipo"=>"requerido")) !!}
            </div>
            <div class="form-group col-md-2 has-error">
               <label for="monto-field">Monto</label>
               <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-dollar"></i></span>
                  {!! Form::text("monto[]", null, array("class" => "form-control", "id" => "monto-crear","data-validacion-tipo"=>"requerido")) !!}
               </div>
            </div>
            <!--<div class="form-group col-md-1">
               <label for="inicial_bnd-field">Inicial</label>
               @{!! Form::checkbox("inicial_bnd[]", 1, null, [ "id" => "inicial_bnd-crear"]) !!}
            </div>-->
            
         </div>
      </div>
      <div id="areaFrm" class="row">
         <div class="row"></div>   
         <div class="row col-md-12">
            <div class="form-group col-sm-2">
            
               <button id="nuevoFrm" class="btn btn-sm btn-success" type="button">Agregar</button>                
            
            </div>
         </div>
      </div>
  </div>
</div>


@endif

@push('scripts')
<script type="text/javascript">
$(document).ready(function() {
   var formulario = $("#repetirFrm").html();

   $('#fecha_pago-field').Zebra_DatePicker({
      days:['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'],
         months:['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
         readonly_element: false,
         lang_clear_date: 'Limpiar',
         show_select_today: 'Hoy',
   });

   $('.fecha_calendario').Zebra_DatePicker({
    days:['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'],
    months:['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
    readonly_element: false,
    lang_clear_date: 'Limpiar',
    show_select_today: 'Hoy',
    onChange: function(view, elements) {
      $(this).closest('.form-group').removeClass('has-error');
    }
    });

   $('.form-control').change(function(){
      $(this).closest('.form-group').removeClass('has-error');
   });

   

       
   // El encargado de agregar más formularios
   $("#nuevoFrm").click(function(){
      // Agregamos el formulario
      $("#areaFrm").append(formulario);
   
      // Agregamos un boton para retirar el formulario
      $("#areaFrm .col-xs-12:last").append('<div class="form-group col-md-2"><button class="btn-danger btn btn-retirar" type="button">Retirar</button></div>');
   
      // Hacemos focus en el primer input del formulario
      $("#areaFrm .col-xs-12:first input:first").focus();
   
      // Volvemos a cargar todo los plugins que teníamos, dentro de esta función esta el del datepicker assets/js/ini.js
      //$(".select_seguridad").select2({ width: '100%' });
      //$(".select_seguridad").select2({ width: '100%', 'reload' });
      $('.form-control').change(function(){
         $(this).closest('.form-group').removeClass('has-error');
      });
      $('.fecha_calendario').Zebra_DatePicker({
         days:['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'],
                  months:['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
                  readonly_element: false,
                  lang_clear_date: 'Limpiar',
                  show_select_today: 'Hoy',
         onChange: function(view, elements) {
            $(this).closest('.form-group').removeClass('has-error');
         }      
         });
   });
            
   // Cuando hacemos click en el boton de retirar
   $("#areaFrm").on('click', '.btn-retirar', function(){
      $(this).closest('.col-xs-12').remove();
   })
               
            
});
</script>
@endpush