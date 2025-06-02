<div class="form-group col-md-4 @if ($errors->has('plantel_id')) has-error @endif">
   <label for="plantel_id-field">Plantel</label>
   {!! Form::select('plantel_id', $list['Plantel'], null, [
      'class' => 'form-control select_seguridad',
      'id' => 'plantel_id-field',
   ]) !!}
   @if ($errors->has('plantel_id'))
      <span class="help-block">{{ $errors->first('plantel_id') }}</span>
   @endif
</div>
<div class="form-group col-md-4 @if ($errors->has('especialidad_id')) has-error @endif">
   <label for="especialidad_id-field">Especialidad</label>
   {!! Form::select('especialidad_id', $list['Especialidad'], null, [
      'class' => 'form-control select_seguridad',
      'id' => 'especialidad_id-field',
   ]) !!}
   <div id='loading2' style='display: none'><img src="{{ asset('images/ajax-loader.gif') }}"
            title="Enviando" /></div>
   @if ($errors->has('especialidad_id'))
      <span class="help-block">{{ $errors->first('especialidad_id') }}</span>
   @endif
</div>
<div class="form-group col-md-4 @if ($errors->has('nivel_id')) has-error @endif">
   <label for="nivel_id-field">Nivel</label>
   {!! Form::select('nivel_id', $list['Nivel'], null, [
      'class' => 'form-control select_seguridad',
      'id' => 'nivel_id-field',
   ]) !!}
   <div id='loading3' style='display: none'><img src="{{ asset('images/ajax-loader.gif') }}"
            title="Enviando" /></div>
   @if ($errors->has('nivel_id'))
      <span class="help-block">{{ $errors->first('nivel_id') }}</span>
   @endif
</div>
<div class="form-group col-md-4 @if ($errors->has('name')) has-error @endif">
   <label for="name-field">Grado</label>
   {!! Form::text('name', null, ['class' => 'form-control input-sm', 'id' => 'name-field']) !!}
   @if ($errors->has('name'))
      <span class="help-block">{{ $errors->first('name') }}</span>
   @endif
</div>
<div class="form-group col-md-4 @if ($errors->has('nombre2')) has-error @endif">
   <label for="nombre2-field">Nombre RVOE</label>
   {!! Form::text('nombre2', null, ['class' => 'form-control input-sm', 'id' => 'nombre2-field']) !!}
   @if ($errors->has('nombre2'))
      <span class="help-block">{{ $errors->first('nombre2') }}</span>
   @endif
</div>
<div class="form-group col-md-4 @if ($errors->has('denominacion')) has-error @endif">
   <label for="denominacion-field">Denominacion</label>
   {!! Form::text('denominacion', null, ['class' => 'form-control input-sm', 'id' => 'denominacion-field']) !!}
   @if ($errors->has('denominacion'))
      <span class="help-block">{{ $errors->first('denominacion') }}</span>
   @endif
</div>
<div class="form-group col-md-4 @if ($errors->has('rvoe')) has-error @endif">
   <label for="rvoe-field">RVOE</label>
   {!! Form::text('rvoe', null, ['class' => 'form-control input-sm', 'id' => 'rvoe-field']) !!}
   @if ($errors->has('rvoe'))
      <span class="help-block">{{ $errors->first('denominacion') }}</span>
   @endif
</div>
<div class="form-group col-md-4 @if ($errors->has('fec_rvoe')) has-error @endif">
   <label for="fec_rvoe-field">Fec. RVOE</label>
   {!! Form::text('fec_rvoe', null, ['class' => 'form-control input-sm fecha', 'id' => 'fec_rvoe-field']) !!}
   @if ($errors->has('fec_rvoe'))
      <span class="help-block">{{ $errors->first('fec_rvoe') }}</span>
   @endif
</div>
<div class="form-group col-md-4 @if ($errors->has('cct')) has-error @endif">
   <label for="cct-field">CCT</label>
   {!! Form::text('cct', null, ['class' => 'form-control input-sm', 'id' => 'cct-field']) !!}
   @if ($errors->has('cct'))
      <span class="help-block">{{ $errors->first('cct') }}</span>
   @endif
</div>
<div class="form-group col-md-4 @if ($errors->has('precio_online')) has-error @endif">
   <label for="precio_online-field">Precio Online</label>
   {!! Form::text('precio_online', null, ['class' => 'form-control input-sm', 'id' => 'precio_online-field']) !!}
   @if ($errors->has('precio_online'))
      <span class="help-block">{{ $errors->first('precio_online') }}</span>
   @endif
</div>
<div class="form-group col-md-4 @if ($errors->has('seccion')) has-error @endif">
   <label for="seccion-field">Seccion</label>
   {!! Form::text('seccion', null, ['class' => 'form-control input-sm', 'id' => 'seccion-field']) !!}
   @if ($errors->has('seccion'))
      <span class="help-block">{{ $errors->first('seccion') }}</span>
   @endif
</div>
<div class="form-group col-md-4 @if ($errors->has('duracion_periodo_id')) has-error @endif">
   <label for="duracion_periodo_id-field">Duracion Periodo</label>
   {!! Form::select('duracion_periodo_id', $list['DuracionPeriodo'], null, [
      'class' => 'form-control select_seguridad',
      'id' => 'duracion_periodo_id-field',
   ]) !!}
   <div id='loading3' style='display: none'><img src="{{ asset('images/ajax-loader.gif') }}"
            title="Enviando" /></div>
   @if ($errors->has('duracion_periodo_id'))
      <span class="help-block">{{ $errors->first('duracion_periodo_id') }}</span>
   @endif
</div>
<div class="form-group col-md-4 @if ($errors->has('clave_servicio')) has-error @endif">
   <label for="clave_servicio-field">C. Producto o Servicio(Facturacion)</label>
   {!! Form::text('clave_servicio', null, ['class' => 'form-control input-sm', 'id' => 'clave_servicio-field']) !!}
   @if ($errors->has('clave_servicio'))
      <span class="help-block">{{ $errors->first('clave_servicio') }}</span>
   @endif
</div>
<div class="form-group col-md-4 @if ($errors->has('nivel_educativo_sat_id')) has-error @endif">
   <label for="nivel_educativo_sat_id-field">Nivel Educativo SAT</label>
   {!! Form::select('nivel_educativo_sat_id', $list['NivelEducativoSat'], null, [
      'class' => 'form-control select_seguridad',
      'id' => 'nivel_educativo_sat_id-field',
   ]) !!}
   @if ($errors->has('nivel_educativo_sat_id'))
      <span class="help-block">{{ $errors->first('modulo_final_id') }}</span>
   @endif
</div>
<div class="form-group col-md-4 @if ($errors->has('id_mapa')) has-error @endif">
   <label for="id_mapa-field">Id Mapa</label>
   {!! Form::text('id_mapa', null, ['class' => 'form-control input-sm', 'id' => 'id_mapa-field']) !!}
   @if ($errors->has('id_mapa'))
      <span class="help-block">{{ $errors->first('id_mapa') }}</span>
   @endif
</div>
<div class="form-group col-md-4 @if ($errors->has('modulo_final_id')) has-error @endif">
   <label for="modulo_final_id-field">Modulo final</label>
   {!! Form::select('modulo_final_id', $modulos, null, [
      'class' => 'form-control select_seguridad',
      'id' => 'modulo_final_id-field',
   ]) !!}
   @if ($errors->has('modulo_final_id'))
      <span class="help-block">{{ $errors->first('modulo_final_id') }}</span>
   @endif
</div>
<div class="form-group col-md-2 @if ($errors->has('mexico_bnd')) has-error @endif">
   <label for="mexico_bnd-field">Mexico(Solo para pagina)</label>
   {!! Form::checkbox('mexico_bnd', 1, null, ['id' => 'mexico_bnd-field']) !!}
   @if ($errors->has('mexico_bnd'))
      <span class="help-block">{{ $errors->first('mexico_bnd') }}</span>
   @endif
</div>
<div class="form-group col-md-4 @if ($errors->has('emision_rvoe')) has-error @endif">
   <label for="emision_rvoe-field">Emision Rvoe</label>
   {!! Form::text('emision_rvoe', null, ['class' => 'form-control input-sm fecha', 'id' => 'emision_rvoe-field']) !!}
   @if ($errors->has('emision_rvoe'))
      <span class="help-block">{{ $errors->first('emision_rvoe') }}</span>
   @endif
</div>
<div class="form-group col-md-4 @if ($errors->has('url_reglamento')) has-error @endif">
   <label for="url_reglamento-field">Url reglamento</label>
   {!! Form::text('url_reglamento', null, ['class' => 'form-control input-sm', 'id' => 'url_reglamento-field']) !!}
   @if ($errors->has('url_reglamento'))
      <span class="help-block">{{ $errors->first('url_reglamento') }}</span>
   @endif
</div>
@if (isset($grado))
   <input type="hidden" name="_token" id="_token" value="<?= csrf_token() ?>">
   <div class="form-group col-md-4">
      <div class="btn btn-default btn-file">
            <i class="fa fa-paperclip"></i> Adjuntar Archivo
            <input type="file" id="file" name="file" class="email_archivo">
      </div>
      <p class="help-block">Max. 20MB</p>
      <div id="texto_notificacion">
      <img src="{{asset('storage/grados/'.$grado->imagen)}}" alt="Logo" height="42" width="42" >   
      </div>
   </div>
@endif

@push('scripts')
   <script>
      $(document).ready(function() {
            @if (isset($grado))
               $(document).on("change", ".email_archivo", function(e) {

                  var miurl = "{{ route('grados.cargaArchivo') }}";
                  // var fileup=$("#file").val();
                  var divresul = "texto_notificacion";

                  var data = new FormData();
                  data.append('file', $('#file')[0].files[0]);
                  data.append('grado', {{ $grado->id }});

                  $.ajaxSetup({
                        headers: {
                           'X-CSRF-TOKEN': $('#_token').val()
                        }
                  });
                  $.ajax({
                        url: miurl,
                        type: 'POST',

                        // Form data
                        //datos del formulario
                        data: data,
                        //necesario para subir archivos via ajax
                        cache: false,
                        contentType: false,
                        processData: false,
                        //mientras enviamos el archivo
                        beforeSend: function() {
                           $("#" + divresul + "").html($("#cargador_empresa").html());
                        },
                        //una vez finalizado correctamente
                        success: function(data) {
                           var codigo =
                              '<div class="mailbox-attachment-info"><a href="#" class="mailbox-attachment-name"><i class="fa fa-paperclip"></i>' +
                              data +
                              '</a><span class="mailbox-attachment-size"> </span></div>';
                           $("#" + divresul + "").html(codigo);

                        },
                        //si ha ocurrido un error
                        error: function(data) {
                           $("#" + divresul + "").html(data);

                        }
                  });

               })
            @endif
            getCmbEspecialidad();
            getCmbNivel();
            $('#plantel_id-field').change(function() {
               getCmbEspecialidad();
            });

            function getCmbEspecialidad() {
               //var $example = $("#especialidad_id-field").select2();
               var a = $('#frm_grados').serialize();
               $.ajax({
                  url: '{{ route('especialidads.getCmbEspecialidad') }}',
                  type: 'GET',
                  data: a,
                  dataType: 'json',
                  beforeSend: function() {
                        $("#loading2").show();
                  },
                  complete: function() {
                        $("#loading2").hide();
                  },
                  success: function(data) {
                        //$example.select2("destroy");
                        $('#especialidad_id-field').html('');
                        //$('#especialidad_id-field').empty();
                        $('#especialidad_id-field').append($('<option></option>').text('Seleccionar')
                           .val('0'));
                        $.each(data, function(i) {
                           //alert(data[i].name);
                           $('#especialidad_id-field').append("<option " + data[i].selectec +
                              " value=\"" + data[i].id + "\">" + data[i].name +
                              "<\/option>");
                        });
                        //$example.select2();
                  }
               });
            }
            $('#especialidad_id-field').change(function() {
               getCmbNivel();
            });

            function getCmbNivel() {
               //var $example = $("#especialidad_id-field").select2();
               var a = $('#frm_grados').serialize();
               $.ajax({
                  url: '{{ route('nivels.getCmbNivels') }}',
                  type: 'GET',
                  data: a,
                  dataType: 'json',
                  beforeSend: function() {
                        $("#loading3").show();
                  },
                  complete: function() {
                        $("#loading3").hide();
                  },
                  success: function(data) {
                        //alert(data);
                        //$example.select2("destroy");
                        $('#nivel_id-field').html('');
                        //$('#especialidad_id-field').empty();
                        $('#nivel_id-field').append($('<option></option>').text('Seleccionar').val(
                           '0'));

                        $.each(data, function(i) {
                           //alert(data[i].name);
                           $('#nivel_id-field').append("<option " + data[i].selectec +
                              " value=\"" + data[i].id + "\">" + data[i].name +
                              "<\/option>");
                        });
                        //$example.select2();
                  }
               });
            }
      });
   </script>
@endpush
