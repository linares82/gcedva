                    <div class="form-group col-md-4 @if($errors->has('plantel_id')) has-error @endif">
                       <label for="plantel_id-field">Plantel</label>
                       {!! Form::select("plantel_id", $list["Plantel"], null, array("class" => "form-control select_seguridad", "id" => "plantel_id-field")) !!}
                       @if($errors->has("plantel_id"))
                       <span class="help-block">{{ $errors->first("plantel_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('name')) has-error @endif">
                       <label for="name-field">Materia(Oficial)</label>
                       {!! Form::text("name", null, array("class" => "form-control input-sm", "id" => "name-field")) !!}
                       @if($errors->has("name"))
                       <span class="help-block">{{ $errors->first("name") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('orden')) has-error @endif">
                       <label for="orden-field">Orden</label>
                       {!! Form::text("orden", null, array("class" => "form-control input-sm", "id" => "orden-field")) !!}
                       @if($errors->has("orden"))
                       <span class="help-block">{{ $errors->first("orden") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('abreviatura')) has-error @endif">
                       <label for="abreviatura-field">Abreviatura</label>
                       {!! Form::text("abreviatura", null, array("class" => "form-control input-sm", "id" => "abreviatura-field")) !!}
                       @if($errors->has("abreviatura"))
                       <span class="help-block">{{ $errors->first("abreviatura") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('codigo')) has-error @endif">
                       <label for="codigo-field">Codigo</label>
                       {!! Form::text("codigo", null, array("class" => "form-control input-sm", "id" => "codigo-field")) !!}
                       @if($errors->has("codigo"))
                       <span class="help-block">{{ $errors->first("codigo") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('creditos')) has-error @endif">
                       <label for="creditos-field">creditos</label>
                       {!! Form::text("creditos", null, array("class" => "form-control input-sm", "id" => "creditos-field")) !!}
                       @if($errors->has("creditos"))
                       <span class="help-block">{{ $errors->first("creditos") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('seriada_bnd')) has-error @endif">
                       <label for="seriada_bnd-field">Seriada</label>
                       {!! Form::checkbox("seriada_bnd", 1, null, [ "id" => "seriada_bnd-field"]) !!}
                       @if($errors->has("seriada_bnd"))
                       <span class="help-block">{{ $errors->first("seriada_bnd") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('bnd_oficial')) has-error @endif">
                       <label for="bnd_oficial-field">Oficial</label>
                       {!! Form::checkbox("bnd_oficial", 1, null, [ "id" => "bnd_oficial-field"]) !!}
                       @if($errors->has("bnd_oficial"))
                       <span class="help-block">{{ $errors->first("bnd_oficial") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('bnd_tiene_nombre_oficial')) has-error @endif">
                       <label for="bnd_tiene_nombre_oficial-field">Tiene Nombre Operativo</label>
                       {!! Form::checkbox("bnd_tiene_nombre_oficial", 1, null, [ "id" => "bnd_tiene_nombre_oficial-field"]) !!}
                       @if($errors->has("bnd_tiene_nombre_oficial"))
                       <span class="help-block">{{ $errors->first("bnd_tiene_nombre_oficial") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('nombre_oficial')) has-error @endif">
                       <label for="nombre_oficial-field">Nombre Operativo</label>
                       {!! Form::text("nombre_oficial", null, array("class" => "form-control input-sm", "id" => "nombre_oficial-field")) !!}
                       @if($errors->has("nombre_oficial"))
                       <span class="help-block">{{ $errors->first("nombre_oficial") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('id_asignatura_certificado')) has-error @endif">
                       <label for="id_asignatura_certificado-field">Id Asignatura Certificado</label>
                       {!! Form::text("id_asignatura_certificado", null, array("class" => "form-control input-sm", "id" => "id_asignatura_certificado-field")) !!}
                       @if($errors->has("id_asignatura_certificado"))
                       <span class="help-block">{{ $errors->first("id_asignatura_certificado") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('serie_anterior')) has-error @endif">
                       <label for="serie_anterior-field">Serie anterior</label>
                       {!! Form::select("serie_anterior", $materiales_ls, null, array("class" => "form-control select_seguridad", "id" => "serie_anterior-field")) !!}
                       <div id='loading3' style='display: none'><img src="{{ asset('images/ajax-loader.gif') }}" title="Enviando" /></div>
                       @if($errors->has("serie_anterior"))
                       <span class="help-block">{{ $errors->first("serie_anterior") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('modulo_id')) has-error @endif">
                       <label for="modulo_id-field">Modulo</label>
                       {!! Form::select("modulo_id", $list["Modulo"], null, array("class" => "form-control select_seguridad", "id" => "modulo_id-field")) !!}
                       @if($errors->has("modulo_id"))
                       <span class="help-block">{{ $errors->first("modulo_id") }}</span>
                       @endif
                    </div>

                    <div class="form-group col-md-4 @if($errors->has('ponderacion_id')) has-error @endif" style="clear:left;">
                       <label for="ponderacion_id-field">Ponderacion basada en porcentaje</label>
                       {!! Form::select("ponderacion_id", $list["Ponderacion"], null, array("class" => "form-control select_seguridad", "id" => "ponderacion_id-field")) !!}
                       @if($errors->has("ponderacion_id"))
                       <span class="help-block">{{ $errors->first("ponderacion_id") }}</span>
                       @endif
                    </div>
                    
                    @permission('materias.ponderacionBasadaEnMaterias')
                    <div class="form-group col-md-4 @if($errors->has('bnd_ponderacion')) has-error @endif">
                     <label for="bnd_ponderacion-field">Ponderacion Para Otra Materia: </label>
                     {!! Form::checkbox("bnd_ponderacion", true, null, [ "id" => "bnd_ponderacion-field", 'class'=>'minimal']) !!}
                     @if($errors->has("bnd_ponderacion"))
                     <span class="help-block">{{ $errors->first("bnd_ponderacion") }}</span>
                     @endif
                 </div>

                  <div class="form-group col-md-4 @if($errors->has('hijos')) has-error @endif">
                     <label for="hijos-field">Ponderacion basada en Materias</label>
                     {!! Form::select("hijos[]", isset($ponderacionMaterias) ? $ponderacionMaterias : array(), isset($materium) ? $materium->ponderacionMaterias->pluck('id') : null, array("class" => "form-control select_seguridad", "id" => "hijos-field", 'multiple'=>true)) !!}
                     @if($errors->has("hijos"))
                     <span class="help-block">{{ $errors->first("hijos") }}</span>
                     @endif
                  </div>
                  
                  @if(isset($materium))
                  <div class="form-group col-md-4 @if($errors->has('hijos')) has-error @endif">
                     <label for="hijos-field">Ponderacion de: </label>
                  <ul>
                     @foreach($materium->padre as $padre)
                     <li><a href="{{ route('materias.edit', $padre->id) }}" target="blank"> {{ $padre->name }} </a> </li>
                     @endforeach
                  </ul>
                  </div>
                  @endif
                  @endpermission
                  
                    @push('scripts')

                    <script type="text/javascript">
                       $(document).ready(function() {
                          getCmbMateria();
                          @if(!isset($ponderacionMaterias))
                          getPonderacionMaterias();
                          @endif
                          
                          $('#plantel_id-field').change(function() {
                              console.log('fil');
                             getCmbMateria();
                             getPonderacionMaterias();
                          });
                       });

                       function getCmbMateria() {

                          $.ajax({
                             url: '{{ route("materias.getCmbMateria2") }}',
                             type: 'GET',
                             data: "plantel_id=" + $('#plantel_id-field option:selected').val() +
                                "&materium_id=" + $('#serie_anterior-field option:selected').val(),
                             dataType: 'json',
                             beforeSend: function() {
                                $("#loading3").show();
                             },
                             complete: function() {
                                $("#loading3").hide();
                             },
                             success: function(data) {
                                //$example.select2("destroy");
                                //$('#serie_anterior-field').html('');
                                $('#serie_anterior-field').empty();
                                //$('#especialidad_id-field').empty();
                                $('#serie_anterior-field').append($('<option></option>').text('Seleccionar Opción').val('0'));

                                $.each(data, function(i) {
                                   //alert(data[i].name);
                                   $('#serie_anterior-field').append("<option " + data[i].selectec + " value=\"" + data[i].id + "\">" + data[i].name + "<\/option>");

                                });
                                $('#serie_anterior-field').change();
                             }
                          });
                       }

                       function getPonderacionMaterias() {

                        $.ajax({
                           url: '{{ route("materias.getMateriasParaPonderacion") }}',
                           type: 'GET',
                           data: "plantel_id=" + $('#plantel_id-field option:selected').val(),
                           dataType: 'json',
                           beforeSend: function() {
                              $("#loading3").show();
                           },
                           complete: function() {
                              $("#loading3").hide();
                           },
                           success: function(data) {
                              //$example.select2("destroy");
                              //$('#serie_anterior-field').html('');
                              $('#hijos-field').empty();
                              //$('#especialidad_id-field').empty();
                              $('#hijos-field').append($('<option></option>').text('Seleccionar Opción').val('0'));

                              $.each(data, function(i) {
                                 //alert(data[i].name);
                                 $('#hijos-field').append("<option " + data[i].selectec + " value=\"" + data[i].id + "\">" + data[i].name + "<\/option>");

                              });
                              $('#hijos-field').change();
                           }
                        });
                        }
                    </script>
                    @endpush