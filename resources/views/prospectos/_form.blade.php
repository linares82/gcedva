<div class="form-group col-md-4 @if($errors->has('nombre')) has-error @endif">
   <label for="nombre-field">Primer nombre</label>
   {!! Form::text("nombre", null, array("class" => "form-control input-sm", "id" => "nombre-field")) !!}
   @if($errors->has("nombre"))
   <span class="help-block">{{ $errors->first("nombre") }}</span>
   @endif
</div>
<div class="form-group col-md-4 @if($errors->has('nombre2')) has-error @endif">
   <label for="nombre2-field">Segundo nombre</label>
   {!! Form::text("nombre2", null, array("class" => "form-control input-sm", "id" => "nombre2-field")) !!}
   @if($errors->has("nombre2"))
   <span class="help-block">{{ $errors->first("nombre2") }}</span>
   @endif
</div>
<div class="form-group col-md-4 @if($errors->has('ape_paterno')) has-error @endif">
   <label for="ape_paterno-field">A. Paterno</label>
   {!! Form::text("ape_paterno", null, array("class" => "form-control input-sm", "id" => "ape_paterno-field")) !!}
   @if($errors->has("ape_paterno"))
   <span class="help-block">{{ $errors->first("ape_paterno") }}</span>
   @endif
</div>
<div class="form-group col-md-4 @if($errors->has('ape_materno')) has-error @endif">
   <label for="ape_materno-field">A. Materno</label>
   {!! Form::text("ape_materno", null, array("class" => "form-control input-sm", "id" => "ape_materno-field")) !!}
   @if($errors->has("ape_materno"))
   <span class="help-block">{{ $errors->first("ape_materno") }}</span>
   @endif
</div>
<div class="form-group col-md-4 @if($errors->has('bnd_liga_enviada')) has-error @endif">
   <label for="bnd_liga_enviada-field">Liga Enviada</label>
   {!! Form::checkbox("bnd_liga_enviada", 1, null, [ "id" => "bnd_liga_enviada-field"]) !!}
   @if($errors->has("bnd_liga_enviada"))
   <span class="help-block">{{ $errors->first("bnd_liga_enviada") }}</span>
   @endif
</div>

<div class="form-group col-md-4 @if($errors->has('tel_fijo')) has-error @endif">
   <label for="tel_fijo-field">Telefono Fijo</label>
   {!! Form::text("tel_fijo", null, array("class" => "form-control input-sm", "id" => "tel_fijo-field")) !!}
   @if($errors->has("tel_fijo"))
   <span class="help-block">{{ $errors->first("tel_fijo") }}</span>
   @endif
</div>
<div class="form-group col-md-4 @if($errors->has('tel_cel')) has-error @endif">
   <label for="tel_cel-field">Telefono Celular(10 digitos)</label>
   {!! Form::text("tel_cel", null, array("class" => "form-control input-sm", "id" => "tel_cel-field")) !!}
   @if($errors->has("tel_cel"))
   <span class="help-block">{{ $errors->first("tel_cel") }}</span>
   @endif
</div>
<div class="form-group col-md-4 @if($errors->has('mail')) has-error @endif" style="clear:left;">
   <label for="mail-field">Correo ElectrOnico</label>
   {!! Form::text("mail", null, array("class" => "form-control input-sm", "id" => "mail-field")) !!}
   @if($errors->has("mail"))
   <span class="help-block">{{ $errors->first("mail") }}</span>
   @endif
</div>
<div class="form-group col-md-4 @if($errors->has('plantel_id')) has-error @endif">
   <label for="plantel_id-field">Plantel</label>
   {!! Form::select("plantel_id", $planteles, null, array("class" => "form-control select_seguridad", "id" => "plantel_id-field")) !!}
   @if($errors->has("plantel_id"))
   <span class="help-block">{{ $errors->first("plantel_id") }}</span>
   @endif
</div>
<div class="form-group col-md-4 @if($errors->has('especialidad')) has-error @endif">
   <label for="especialidad-field">Especialidad</label>
   {!! Form::hidden("combinacion", null, array("class" => "form-control input-sm", "id" => "combinacion-field")) !!}
   {!! Form::select("especialidad_id", $list["Especialidad"], null, array("class" => "form-control select_seguridad", "id" => "especialidad_id-field")) !!}
   <div id='loading10' style='display: none'><img src="{{ asset('images/ajax-loader.gif') }}" title="Enviando" /></div>
   @if($errors->has("especialidad"))
   <span class="help-block">{{ $errors->first("especialidad") }}</span>
   @endif
</div>
<div class="form-group col-md-4 @if($errors->has('nivel_id')) has-error @endif" style="clear:left;">
   <label for="nivel_id-field">Nivel</label>
   {!! Form::select("nivel_id", $list["Nivel"], null, array("class" => "form-control select_seguridad", "id" => "nivel_id-field")) !!}
   <div id='loading11' style='display: none'><img src="{{ asset('images/ajax-loader.gif') }}" title="Enviando" /></div>
   @if($errors->has("nivel_id"))
   <span class="help-block">{{ $errors->first("nivel_id") }}</span>
   @endif
</div>

<div class="form-group col-md-4 @if($errors->has('grado_id')) has-error @endif">
   <label for="grado_id-field">Grado </label>
   {!! Form::select("grado_id", $list["Grado"], null, array("class" => "form-control select_seguridad", "id" => "grado_id-field")) !!}
   <div id='loading12' style='display: none'><img src="{{ asset('images/ajax-loader.gif') }}" title="Enviando" /></div>
   @if($errors->has("grado_id"))
   <span class="help-block">{{ $errors->first("grado_id") }}</span>
   @endif
</div>

<div class="form-group col-md-4 @if($errors->has('medio_id')) has-error @endif">
   <label for="medio_id-field">Medio por el que se entero</label>
   {!! Form::select("medio_id", $medios, null, array("class" => "form-control select_seguridad", "id" => "medio_id-field")) !!}
   @if($errors->has("medio_id"))
   <span class="help-block">{{ $errors->first("medio_id") }}</span>
   @endif
</div>


<div class="form-group col-md-4 @if($errors->has('st_prospecto_id')) has-error @endif">
   <label for="st_prospecto_id-field">Estatus Prospecto</label>
   {!! Form::select("st_prospecto_id", $estatus, !isset($prospecto) ? 1 : null, array("class" => "form-control select_seguridad", "id" => "st_prospecto_id-field")) !!}
   @if($errors->has("st_prospecto_id"))
   <span class="help-block">{{ $errors->first("st_prospecto_id") }}</span>
   @endif
</div>

<div class="form-group col-md-4 @if($errors->has('fec_apartado')) has-error @endif">
   <label for="fec_apartado-field" id="lbl_fec_apartado">Fec. Apartado</label>
   @permission('prospectos.fec_apartado')
   {!! Form::text("fec_apartado", null, array("class" => "form-control", "id" => "fec_apartado-field")) !!}
   @endpermission
   @if(isset($prospecto))
   @if(!is_null($prospecto->fec_apartado))
   {{ $prospecto->fec_apartado }}
   @endif
   @endif
   @if($errors->has("fec_apartado"))
   <span class="help-block">{{ $errors->first("fec_apartado") }}</span>
   @endif
</div>

<div class="form-group col-md-4 @if($errors->has('bot_resumen')) has-error @endif">
   <label for="bot_resumen-field">Bot</label>
   {!! Form::textArea("bot_resumen", null, array("class" => "form-control input-sm", "id" => "bot_resumen-field")) !!}
   @if($errors->has("bot_resumen"))
   <span class="help-block">{{ $errors->first("bot_resumen") }}</span>
   @endif
</div>

@permission('prospectos.inscripcion_campo')
<div class="form-group col-md-3 @if($errors->has('bnd_inscripcion')) has-error @endif">
   <label for="bnd_inscripcion-field">Inscripcion</label>
   {!! Form::checkbox("bnd_inscripcion", 1, null, [ "id" => "bnd_inscripcion-field", 'class'=>'minimal']) !!}
   @if($errors->has("bnd_inscripcion"))
   <span class="help-block">{{ $errors->first("bnd_inscripcion") }}</span>
   @endif
</div>
@endpermission
@push('scripts')
<script src="{{ asset ('/bower_components/AdminLTE/plugins/input-mask/jquery.inputmask.js') }}"></script>
<script src="{{ asset ('/bower_components/AdminLTE/plugins/input-mask/jquery.inputmask.extensions.js') }}"></script>
<script src="{{ asset ('/bower_components/AdminLTE/plugins/input-mask/jquery.inputmask.phone.extensions.js') }}"></script>
<script type="text/javascript">

   $('#fec_apartado-field').Zebra_DatePicker({
        days:['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'],
        months:['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
        readonly_element: false,
        lang_clear_date: 'Limpiar',
        show_select_today: 'Hoy',
        direction: [1, 5]
      });
   $(document).ready(function() {
      /*
      $('#tel_cel-field').inputmask({
         "mask": "(999) 999-9999"
      });
      $('#tel_fijo-field').inputmask({
         "mask": "(999) 999-9999"
      });
*/
      @permission("prospectos.editarTelefonos")
      $("#tel_cel-field").dblclick(function() {
         $('#tel_cel-field').attr('readonly', false);
         $('#tel_cel-field').val("");
      });
      @endpermission

      longitudTelCel();
      $('#tel_cel-field').on('keydown', function(){
         longitudTelCel();
      });

      function longitudTelCel(){
         //console.log($('#tel_cel-field').val().length);
         if($('#tel_cel-field').val().length>=10){
            $('#tel_cel-field').attr('readonly', true);
         }
      }

      @permission("prospectos.editarTelefonos")
      $("#tel_fijo-field").dblclick(function() {
         $('#tel_fijo-field').attr('readonly', false);
         $('#tel_fijo-field').val("");
      });
      @endpermission
      longitudTelFijo();
      $('#tel_fijo-field').on('keydown', function(){
         longitudTelFijo();
      });

      function longitudTelFijo(){
         //console.log($('#tel_fijo-field').val().length);
         if($('#tel_fijo-field').val().length>=10){
            $('#tel_fijo-field').attr('readonly', true);
         }
      }
      

      getCmbEspecialidad();
      getCmbNivel();
      getCmbGrado();
      $('#plantel_id-field').change(function() {
         getCmbEspecialidad();
      });
      $('#especialidad_id-field').change(function() {
         getCmbNivel();
      });

      $('#nivel_id-field').change(function() {
         getCmbGrado();
      });

      $("#lbl_fec_apartado").dblclick(function() {
         if ($("#fec_apartado-field").is(':disabled')) {
            $("#fec_apartado-field").prop("disabled", false);
         } else {
            $("#fec_apartado-field").prop("disabled", true);
         }

      });
   });

   function getCmbEspecialidad() {
      //var $example = $("#especialidad_id-field").select2();
      var a = $('#frm_cliente').serialize();
      $.ajax({
         url: '{{ route("especialidads.getCmbEspecialidad") }}',
         type: 'GET',
         data: "plantel_id=" + $('#plantel_id-field option:selected').val() + "&especialidad_id=" + $('#especialidad_id-field option:selected').val() + "",
         dataType: 'json',
         beforeSend: function() {
            $("#loading10").show();
         },
         complete: function() {
            $("#loading10").hide();
         },
         success: function(data) {
            //$example.select2("destroy");
            $('#especialidad_id-field').empty();
            $('#especialidad_id-field').append($('<option></option>').text('Seleccionar').val('0'));
            $.each(data, function(i) {
               //alert(data[i].name);
               $('#especialidad_id-field').append("<option " + data[i].selectec + " value=\"" + data[i].id + "\">" + data[i].name + "<\/option>");
            });
            //$example.select2();
         }
      });
   }

   function getCmbNivel() {
      //var $example = $("#especialidad_id-field").select2();
      //alert($('#especialidad_id-field option:selected').val());
      var a = $('#frm_cliente').serialize();
      $.ajax({
         url: '{{ route("nivels.getCmbNivels") }}',
         type: 'GET',
         data: "plantel_id=" + $('#plantel_id-field option:selected').val() + "&especialidad_id=" + $('#especialidad_id-field option:selected').val() + "&nivel_id=" + $('#nivel_id-field option:selected').val() + "",
         dataType: 'json',
         beforeSend: function() {
            $("#loading11").show();
         },
         complete: function() {
            $("#loading11").hide();
         },
         success: function(data) {
            //alert(data);
            //$example.select2("destroy");
            $('#nivel_id-field').html('');
            //$('#especialidad_id-field').empty();
            $('#nivel_id-field').append($('<option></option>').text('Seleccionar').val('0'));
            $.each(data, function(i) {
               //alert(data[i].name);
               $('#nivel_id-field').append("<option " + data[i].selectec + " value=\"" + data[i].id + "\">" + data[i].name + "<\/option>");
            });
            //$example.select2();
         }
      });
   }

   function getCmbGrado() {
      $.ajax({
         url: '{{ route("grados.getCmbGrados") }}',
         type: 'GET',
         data: "plantel_id=" + $('#plantel_id-field option:selected').val() + "&especialidad_id=" + $('#especialidad_id-field option:selected').val() + "&nivel_id=" + $('#nivel_id-field option:selected').val() + "&grado_id=" + $('#grado_id-field option:selected').val() + "",
         dataType: 'json',
         beforeSend: function() {
            $("#loading12").show();
         },
         complete: function() {
            $("#loading12").hide();
         },
         success: function(data) {
            //alert(data);
            //$example.select2("destroy");
            if ($('#nivel_id-field option:selected').val() != 0) {
               $('#grado_id-field').prop('disabled', false);
            }

            $('#grado_id-field').html('');
            //$('#especialidad_id-field').empty();
            $('#grado_id-field').append($('<option></option>').text('Seleccionar').val('0'));
            $.each(data, function(i) {
               //alert(data[i].name);
               $('#grado_id-field').append("<option " + data[i].selectec + " value=\"" + data[i].id + "\">" + data[i].name + "<\/option>");
            });
            $('#grado_id-field').trigger('change');
         }
      });
   }
</script>
@endpush