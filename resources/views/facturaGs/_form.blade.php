                <div class="form-group col-md-4 @if($errors->has('cuentas_efectivo_id')) has-error @endif">
                       <label for="cuentas_efectivo_id-field">Cuenta</label>
                       {!! Form::select("cuentas_efectivo_id", $cuentas, null, array("class" => "form-control select_seguridad", "id" => "cuentas_efectivo_id-field")) !!}
                       {!! Form::hidden("plantel_id", null, array("class" => "form-control", "id" => "plantel_id-field")) !!}
                       <div id="loading" style="display: none">Buscando...</div>
                       <div id="msj"></div>
                       @if($errors->has("cuentas_efectivo_id"))
                        <span class="help-block">{{ $errors->first("cuentas_efectivo_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('archivo')) has-error @endif">
                     <label for="archivo-field">Archivo</label>
                     
                     {!! Form::file('archivo') !!}
                     @if($errors->has("archivo"))
                      <span class="help-block">{{ $errors->first("archivo") }}</span>
                     @endif
                  </div>
                  
                    <div class="row col-md-12"></div>
                    <hr>
                    <div class="row col-md-12"> <label for="">Valores Default Cabecera</label></div>
                    <div class="form-group col-md-4 @if($errors->has('serie')) has-error @endif">
                       <label for="serie-field">Serie</label>
                       {!! Form::text("serie", null, array("class" => "form-control", "id" => "serie-field")) !!}
                       @if($errors->has("serie"))
                        <span class="help-block">{{ $errors->first("serie") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('folio')) has-error @endif">
                       <label for="folio-field">Folio</label>
                       {!! Form::text("folio", null, array("class" => "form-control", "id" => "folio-field")) !!}
                       @if($errors->has("folio"))
                        <span class="help-block">{{ $errors->first("folio") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('fecha')) has-error @endif">
                       <label for="fecha-field">Fecha (AAAA-MM-DD HH:MM:SS)</label>
                       {!! Form::text("fecha", date('Y-m-d h:m:i'), array("class" => "form-control", "id" => "fecha-field")) !!}
                       @if($errors->has("fecha"))
                        <span class="help-block">{{ $errors->first("fecha") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('tipo_comprobante')) has-error @endif">
                       <label for="tipo_comprobante-field">Tipo Comprobante</label>
                       {!! Form::text("tipo_comprobante", 'I', array("class" => "form-control", "id" => "tipo_comprobante-field")) !!}
                       @if($errors->has("tipo_comprobante"))
                        <span class="help-block">{{ $errors->first("tipo_comprobante") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('lugar_expedicion')) has-error @endif">
                       <label for="lugar_expedicion-field">Lugar Expedicion</label>
                       {!! Form::text("lugar_expedicion", null, array("class" => "form-control", "id" => "lugar_expedicion-field")) !!}
                       @if($errors->has("lugar_expedicion"))
                        <span class="help-block">{{ $errors->first("lugar_expedicion") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('exportacion')) has-error @endif">
                       <label for="exportacion-field">Exportacion</label>
                       {!! Form::text("exportacion", '01', array("class" => "form-control", "id" => "exportacion-field")) !!}
                       @if($errors->has("exportacion"))
                        <span class="help-block">{{ $errors->first("exportacion") }}</span>
                       @endif
                    </div>
                    <div class="row"></div>
                    <hr>
                    <div class="row col-md-12"><label for="">Valores Default Periodicidad</label></div>
                    <div class="form-group col-md-4 @if($errors->has('periodicidad')) has-error @endif">
                       <label for="periodicidad-field">Periodicidad</label>
                       {!! Form::text("periodicidad", '04', array("class" => "form-control", "id" => "periodicidad-field")) !!}
                       @if($errors->has("periodicidad"))
                        <span class="help-block">{{ $errors->first("periodicidad") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('meses')) has-error @endif">
                       <label for="meses-field">Meses</label>
                       {!! Form::text("meses", date('m'), array("class" => "form-control", "id" => "meses-field")) !!}
                       @if($errors->has("meses"))
                        <span class="help-block">{{ $errors->first("meses") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('anio')) has-error @endif">
                       <label for="anio-field">Año</label>
                       {!! Form::text("anio", date('Y'), array("class" => "form-control", "id" => "anio-field")) !!}
                       @if($errors->has("anio"))
                        <span class="help-block">{{ $errors->first("anio") }}</span>
                       @endif
                    </div>
                    <div class="row"></div>
                    <hr>
                    <div class="row col-md-12"><label for="">Valores Emisor</label></div>
                    <div class="form-group col-md-4 @if($errors->has('emisor_rfc')) has-error @endif">
                       <label for="emisor_rfc-field">Emisor RFC</label>
                       {!! Form::text("emisor_rfc", null, array("class" => "form-control", "id" => "emisor_rfc-field")) !!}
                       @if($errors->has("emisor_rfc"))
                        <span class="help-block">{{ $errors->first("emisor_rfc") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('emisor_nombre')) has-error @endif">
                       <label for="emisor_nombre-field">Emisor Nombre</label>
                       {!! Form::text("emisor_nombre", null, array("class" => "form-control", "id" => "emisor_nombre-field")) !!}
                       @if($errors->has("emisor_nombre"))
                        <span class="help-block">{{ $errors->first("emisor_nombre") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('emisor_regimen_fiscal')) has-error @endif">
                       <label for="emisor_regimen_fiscal-field">Emisor Regimen Fiscal</label>
                       {!! Form::text("emisor_regimen_fiscal", null, array("class" => "form-control", "id" => "emisor_regimen_fiscal-field")) !!}
                       @if($errors->has("emisor_regimen_fiscal"))
                        <span class="help-block">{{ $errors->first("emisor_regimen_fiscal") }}</span>
                       @endif
                    </div>
                  
                    @push('scripts')                    
                    <script>
                      $(document).ready(function() {
                        getPlantel();
                        $('#cuentas_efectivo_id-field').change(function(){
                            getPlantel();
                        });
                        function getPlantel(){
                                $.ajax({
                                    url: '{{ route("facturaGs.getPlantel") }}',
                                    type: 'GET',
                                    data: 
                                       'cuenta='+$('#cuentas_efectivo_id-field option:selected').val()
                                    ,
                                    dataType: 'json',
                                    beforeSend : function(){$("#loading").show();},
                                    complete : function(){$("#loading").hide();},
                                    success: function(data){
                                       console.log(data)
                                       $("#msj").html('plantel con id:'+data.plantel_id+' y matriz: '+data.matriz_id);
                                       $('#plantel_id-field').val(data.plantel_id);
                                        $('#lugar_expedicion-field').val(data.lugar_expedicion);
                                        $('#emisor_rfc-field').val(data.emisor_rfc);
                                        $('#emisor_nombre-field').val(data.emisor_nombre);
                                        $('#emisor_regimen_fiscal-field').val(data.emisor_regimen_fiscal);
                                    }
                                });       
                        }
                    
                      });
                    </script>
                    @endpush                    
