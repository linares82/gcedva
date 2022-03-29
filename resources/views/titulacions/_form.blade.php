   <div class="box">
       <div class="box-body">
           <div class="col-md-4">
               <div class="form-group @if ($errors->has('fec_inicio')) has-error @endif">
                   <label for="fec_inicio-field">F. inicio proceso</label>
                   {!! Form::hidden('cliente_id', isset($cliente) ? $cliente : null, ['class' => 'form-control', 'id' => 'cliente_id-field']) !!}
                   {!! Form::text('fec_inicio', null, ['class' => 'form-control fecha', 'id' => 'fec_inicio-field']) !!}
                   @if ($errors->has('fec_inicio'))
                       <span class="help-block">{{ $errors->first('fec_inicio') }}</span>
                   @endif
               </div>
               <div class="form-group @if ($errors->has('opcion_titulacion_id')) has-error @endif">
                   <label for="opcion_titulacion_id-field">Opcion Titulacion</label>
                   {!! Form::select('opcion_titulacion_id', $opciones_titulacion, null, ['class' => 'form-control select_seguridad', 'id' => 'opcion_titulacion_id-field']) !!}
                   @if ($errors->has('opcion_titulacion_id'))
                       <span class="help-block">{{ $errors->first('opcion_titulacion_id') }}</span>
                   @endif
               </div>
               
               <div class="form-group @if ($errors->has('titulacion_documento_id')) has-error @endif">
                  <label for="titulacion_documento_id-field">Documento</label>
                  {!! Form::select('titulacion_documento_id', $documentos, null, ['class' => 'form-control select_seguridad', 'id' => 'titulacion_documento_id-field', 'style' => 'width:100%']) !!}
                  @if ($errors->has('titulacion_documento_id'))
                      <span class="help-block">{{ $errors->first('titulacion_documento_id') }}</span>
                  @endif
              </div>
              <div class="form-group">
                  <div class="btn btn-default btn-file">
                      <i class="fa fa-paperclip"></i> Adjuntar Archivo
                      <input type="file" id="file" name="file" class="cliente_archivo">
                      <input type="hidden" name="_token" id="_token" value="<?= csrf_token() ?>">
                      <input type="hidden" id="file_hidden" name="file_hidden">
                  </div>
                  <button class="btn btn-success btn-xs" id="btn_archivo"> <span
                          class="glyphicon glyphicon-ok">Cargar</span> </btn>
                      <br />
                      <p class="help-block">Max. 20MB</p>
                      <div id="texto_notificacion">

                      </div>
              </div>
              
           </div>
           @if(isset($titulacion))
           <div class="col-md-8">  
               <div class="form-group col-md-6">
                  <table class="table table-condensed table-striped">
                      <thead>
                          <tr>
                              <th>Documento Agregados</th><th>Link</th><th></th>
                          </tr>
                      </thead>
                      <tbody>
                          @foreach($titulacion->titulacionDocumentacions as $doc)
                          <tr>
                              <td>
                                  {{$doc->titulacionDocumento->name}}
                              </td>
                              <td>
                                  <a href="{{asset("imagenes/titulacion/".$titulacion->id."/".$doc->archivo)}}" target="_blank">Ver</a>
                              </td>
                              <td>
                                  <a class="btn btn-xs btn-danger" href="{{route('titulacionDocumentacions.destroy', $doc->id)}}">Eliminar</a>
                              </td>
                          </tr>
                          @endforeach
                      </tbody>
                  </table>
               </div>
              <div class="form-group col-md-6">
                  <table class="table table-condensed table-striped">
                     <thead>
                        <tr>
                              <th>Documentos Faltantes</th>
                        </tr>
                     </thead>
                     <tbody>
                        @foreach($documentos_faltantes as $df)
                        <tr>
                              <td>
                                 {{ $df->name }}
                              </td>
                              <td>
                                 @if($df->doc_obligatorio == 1)
                                 <button class="btn btn-success btn-xs"><span class="glyphicon glyphicon-ok"></span></button>
                                 @else
                                 <button class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-remove"></span></button>
                                 

                                 @endif
                              </td>

                        </tr>
                        @endforeach
                     </tbody>
                  </table>
               </div>
           </div>
           @endif
      </div>
   </div>
   @if (isset($titulacion))
   <div class="row">
    <div class="col-md-6">
        <div class="box">
            <div class="box-body">
                <div class="form-group col-md-4 @if ($errors->has('fecha')) has-error @endif">
                    <label for="intento-field">Fecha</label>
                    {!! Form::hidden('pago_id', null, ['class' => 'form-control', 'id' => 'pago_id-field']) !!}
                    {!! Form::hidden('titulacion_id', $titulacion->id, ['class' => 'form-control', 'id' => 'titulacion_id-field']) !!}
                    {!! Form::text('fecha', null, ['class' => 'form-control fecha', 'id' => 'fecha-field']) !!}
                    @if ($errors->has('fecha'))
                        <span
                            class="help-block">{{ $errors->first('fecha') }}</span>
                    @endif
                </div>
                <div class="form-group col-md-3 @if ($errors->has('monto')) has-error @endif">
                    <label for="monto-field">Monto</label>
                    {!! Form::text('monto', null, ['class' => 'form-control', 'id' => 'monto-field']) !!}
                    @if ($errors->has('monto'))
                        <span
                            class="help-block">{{ $errors->first('monto') }}</span>
                    @endif
                </div>
                <div class="form-group col-md-5 @if ($errors->has('observaciones')) has-error @endif">
                    <label for="observaciones-field">Observaciones</label>
                    {!! Form::text('observaciones', null, ['class' => 'form-control', 'id' => 'observaciones-field']) !!}
                    @if ($errors->has('observaciones'))
                        <span
                            class="help-block">{{ $errors->first('observaciones') }}</span>
                    @endif
                </div>
                <div class="row"></div>
                <button class="btn btn-xs btn-success" id="btn-guardar-pago" data-titulacion="{{ $titulacion->id }}">Crear</button>
                <button class="btn btn-xs btn-warning" id="btn-update-pago" style="display:none">Guardar</button>
                <button class="btn btn-xs btn-danger btn-cancelar-pago">Cancelar</button>
                
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="box">
            <div class="box-body">
                <table class="table table-condensed table-striped">
                    <thead>
                        <th>Fecha</th>
                        <th>Monto</th>
                        <th>Obs.</th>
                        <th>O. Pagos</th>
                    </thead>
                    <tbody>
                        @foreach ($titulacion->titulacionPagos as $pago)
                            <tr>
                                <td>{{ $pago->fecha }}</td>
                                <td>{{ $pago->monto }}</td>
                                <td>{{ $pago->observaciones }}</td>
                                <td>
                                    
                                    <button
                                        class="btn btn-xs btn-warning btn-editar-pago"
                                        data-pago_id="{{ $pago->id }}"
                                        data-titulacion_id="{{ $pago->titulacion_id }}"
                                        data-fecha="{{ $pago->fecha }}"
                                        data-monto="{{ $pago->monto }}"
                                        data-observaciones="{{ $pago->observaciones }}"
                                        >
                                        Editar
                                    </button>
                                    <a class="btn btn-xs btn-danger"
                                                                               id="btn-eliminar-pago"
                                                                               href="{{ route('titulacionPagos.destroy', $pago->id) }}"
                                                                               method="delete">Eliminar</a>
                                </td>
                            </tr>
                        @endforeach
                        <tr><td></td><td>{{ $suma_pagos=$titulacion->titulacionPagos->where('titulacion_id', $titulacion->id)->sum('monto') }}</td><td></td><td></td></tr>
                    </tbody>
                </table>
                
                                            
                                
            </div>
        </div>
    </div>
</div>


@if($titulacion->opcionTitulacion->costo==$suma_pagos)
       <div class="row">
           <div class="col-md-4">
               <div class="box">
                   <div class="box-body">
                       <div class="form-group col-md-6 @if ($errors->has('intento')) has-error @endif">
                           <label for="intento-field">Intento</label>
                           {!! Form::hidden('intento_id', null, ['class' => 'form-control', 'id' => 'intento_id-field']) !!}
                           {!! Form::hidden('titulacion_id', $titulacion->id, ['class' => 'form-control', 'id' => 'titulacion_id-field']) !!}
                           {!! Form::text('intento', null, ['class' => 'form-control', 'id' => 'intento-field']) !!}
                           @if ($errors->has('intento'))
                               <span class="help-block">{{ $errors->first('intento') }}</span>
                           @endif
                       </div>
                       <div class="form-group col-md-6 @if ($errors->has('fec_examen')) has-error @endif">
                           <label for="fec_examen-field">F. Examen</label>
                           {!! Form::text('fec_examen', null, ['class' => 'form-control fecha', 'id' => 'fec_examen-field']) !!}
                           @if ($errors->has('fec_examen'))
                               <span class="help-block">{{ $errors->first('fec_examen') }}</span>
                           @endif
                       </div>
                       <div class="form-group col-md-6 @if ($errors->has('bnd_titulado')) has-error @endif">
                           <label for="bnd_titulado-field">Titulado</label>
                           {!! Form::checkbox('bnd_titulado', 1, null, ['id' => 'bnd_titulado-field', 'class' => 'minimal']) !!}
                           @if ($errors->has('bnd_titulado'))
                               <span class="help-block">{{ $errors->first('bnd_titulado') }}</span>
                           @endif
                       </div>
                       <div class="row"></div>
                       <div class="form-group col-md-6">
                           <button class="btn btn-xs btn-success" id="btn-agregar-intento">Agregar Intento</button>
                           <button class="btn btn-xs btn-warning" id="btn-update-intento" style="display:none;">Guardar
                               Intento</button>
                           <button class="btn btn-xs btn-danger" id="btn-cancelar-intento">Cancelar Intento</button>
                       </div>
                   </div>
               </div>
           </div>

           <div class="col-md-8">
               <div class="box">
                   <div class="box-body">
                       <table class="table table-condensed table-striped">
                           <thead>
                               <th>Intento</th>
                               <th>Fecha</th>
                               <th>Titulado</th>
                               <th>O. Intentos</th>
                           </thead>
                           <tbody>
                               @foreach ($titulacion->titulacionIntentos as $intento)
                                   <tr>
                                       <td>{{ $intento->intento }}</td>
                                       <td>{{ $intento->fec_examen }}</td>
                                       <td>@if ($intento->bnd_titulado == 1) SI @else NO @endif</td>
                                       <td>
                                          
                                       </td>
                                       <td>
                                           <button class="btn btn-xs btn-warning btn-editar-intento"
                                               data-intento_id="{{ $intento->id }}"
                                               data-intento="{{ $intento->intento }}"
                                               data-fec_examen="{{ $intento->fec_examen }}"
                                               data-bnd_titulado="{{ $intento->bnd_titulado }}">
                                               Editar
                                           </button>
                                           <a class="btn btn-xs btn-danger" id="btn-eliminar-intento"
                                               href="{{ route('titulacionIntentos.destroy', $intento->id) }}"
                                               method="delete">Eliminar</a>
                                          
                                       </td>
                                   </tr>
                               @endforeach
                           </tbody>
                       </table>
                   </div>
               </div>
           </div>
       </div>
@endif


   @endif

   @push('scripts')
       <script type="text/javascript">
           $(document).ready(function() {


                       $('#btn-agregar-intento').click(function(event) {
                           event.preventDefault();

                           bnd_titulado = 0;
                           if ($("#bnd_titulado-field").is(':checked')) {
                               bnd_titulado = 1;
                           } else {
                               bnd_titulado = 0;
                           }

                           $.ajax({
                               url: '{{ route('titulacionIntentos.store') }}',
                               type: 'GET',
                               data: {
                                   'titulacion_id': $('#titulacion_id-field').val(),
                                   'intento': $('#intento-field').val(),
                                   'fec_examen': $('#fec_examen-field').val(),
                                   'bnd_titulado': bnd_titulado,
                               },
                               dataType: 'json',
                               success: function(data) {
                                   location.reload();
                               }
                           });
                       });

                       $('.btn-editar-intento').click(function(event) {
                           event.preventDefault();

                           $('#intento_id-field').val($(this).data('intento_id'));
                           $('#intento-field').val($(this).data('intento'));
                           $('#fec_examen-field').val($(this).data('fec_examen'));

                           if ($(this).data('bnd_titulado') == 1) {
                               $('#bnd_titulado-field').prop("checked", true);
                           } else {
                               $('#bnd_titulado-field').prop("checked", false);
                           }

                           $('#btn-update-intento').show();
                           $('#btn-agregar-intento').hide()

                       });

                       $('#btn-cancelar-intento').click(function(event) {
                           event.preventDefault();

                           $('#intento_id-field').val('');
                           $('#intento-field').val('');
                           $('#fec_examen-field').val('');
                           $('#bnd_titulado-field').prop("checked", false);


                           $('#btn-update-intento').hide();
                           $('#btn-agregar-intento').show()

                       });

                       $('#btn-update-intento').click(function(event) {
                           event.preventDefault();

                           bnd_titulado = 0;
                           if ($("#bnd_titulado-field").is(':checked')) {
                               bnd_titulado = 1;
                           } else {
                               bnd_titulado = 0;
                           }

                           $.ajax({
                               url: '{{ url('titulacionIntentos/update') }}' + '/' + $('#intento_id-field')
                                   .val(),
                               type: 'GET',
                               data: {
                                   'intento': $('#intento-field').val(),
                                   'fec_examen': $('#fec_examen-field').val(),
                                   'bnd_titulado': bnd_titulado,
                               },
                               dataType: 'json',
                               success: function(data) {
                                   location.reload();
                               }
                           });
                       });

                       /*
                       $('.btn-agregar-pago').click(function(event) {
                           event.preventDefault();
                           $('#datosPago' + $(this).data('intento')).show();
                       });*/

                       $('#btn-guardar-pago').click(function(event) {
                           event.preventDefault();
                           

                           $.ajax({
                               url: '{{ route('titulacionPagos.store') }}',
                               type: 'GET',
                               data: {
                                   'titulacion_id': {{ $titulacion->id }},
                                   'fecha': $('#fecha-field').val(),
                                   'monto': $('#monto-field').val(),
                                   'observaciones': $('#observaciones-field').val(),
                               },
                               dataType: 'json',
                               success: function(data) {
                                   location.reload();
                               }
                           });
                       });

                       $('.btn-editar-pago').click(function(event) {
                           event.preventDefault();
                           $('#pago_id-field').val($(this).data('pago_id'));
                           $('#titulacion_id-field').val($(this).data('titulacion_id'));
                           $('#fecha-field').val($(this).data('fecha'));
                           $('#monto-field').val($(this).data('monto'));
                           $('#observaciones-field').val($(this).data('observaciones'));

                           $('#btn-update-pago').show();
                           $('#btn-guardar-pago').hide();
                       });

                       $('.btn-cancelar-pago').click(function(event) {
                           event.preventDefault();
                           $('#pago_id-field').val('');
                           $('#titulacion_pago_id-field').val('');
                           $('#fecha-field').val('');
                           $('#observaciones-field').val('');
                           $('#monto-field').val('');

                           divPago.parent().find('.btn-agregar-pago').show();
                       });

                       $('#btn-update-pago').click(function(event) {
                           event.preventDefault();

                           $.ajax({
                               url: '{{ url('titulacionPagos/update') }}' + '/' + $(
                                   '#pago_id-field').val(),
                               type: 'GET',
                               data: {
                                   'fecha': $(this).parent().find('#fecha-field').val(),
                                   'monto': $(this).parent().find('#monto-field').val(),
                                   'observaciones': $(this).parent().find('#observaciones-field').val(),
                               },
                               dataType: 'json',
                               success: function(data) {
                                   location.reload();
                                   $('#btn-update-pago').hide();
                                    $('#btn-guardar-pago').show();
                               }
                           });
                       });

                       $(document).on("click", "#btn_archivo", function(e) {
                           e.preventDefault();
                           if ($('#titulacion_documento_id-field option:selected').val() == 0) {
                               alert("Elegir Documento para Cargar");
                           }
                           var miurl = "{{ route('titulacionDocumentacions.cargarImg') }}";
                           // var fileup=$("#file").val();
                           var divresul = "texto_notificacion";

                           var data = new FormData();
                           data.append('file', $('#file')[0].files[0]);
                           data.append('titulacion_documento_id', $('#titulacion_documento_id-field option:selected').val());
                           @if (isset($titulacion))
                               data.append('titulacion_id', {{ $titulacion->id }});
                           @endif

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
                               //dataType: "json",
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
                                   if (confirm('¿Deseas Actualizar la Página?')) {
                                       location.reload();
                                   }

                               },
                               //si ha ocurrido un error
                               error: function(data) {


                               }
                           });
                       });
                     });
       </script>
   @endpush
