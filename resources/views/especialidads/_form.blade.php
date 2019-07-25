                    <div class="box box-default box-solid">
                        <div class="box-header">
                            <h3 class="box-title">DATOS ESPECIALIDAD</h3>
                            <div class="box-tools">
                                <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                            </div>
                        </div>
                        <div class="box-body">
                            <div class="form-group col-md-4 @if($errors->has('plantel_id')) has-error @endif">
                                  <label for="plantel_id-field">Plantel</label>
                                  {!! Form::select("plantel_id", $list["Plantel"], null, array("class" => "form-control select_seguridad", "id" => "plantel_id-field")) !!}
                                  @if($errors->has("plantel_id"))
                                    <span class="help-block">{{ $errors->first("plantel_id") }}</span>
                                  @endif
                                </div>
                            <div class="form-group col-md-4 @if($errors->has('name')) has-error @endif">
                               <label for="name-field">Especialidad</label>
                               {!! Form::text("name", null, array("class" => "form-control input-sm", "id" => "name-field")) !!}
                               @if($errors->has("name"))
                                <span class="help-block">{{ $errors->first("name") }}</span>
                               @endif
                            </div>
                            <div class="form-group col-md-4 @if($errors->has('rvoe')) has-error @endif">
                               <label for="rvoe-field">RVOE</label>
                               {!! Form::text("rvoe", null, array("class" => "form-control input-sm", "id" => "rvoe-field")) !!}
                               @if($errors->has("rvoe"))
                                <span class="help-block">{{ $errors->first("rvoe") }}</span>
                               @endif
                            </div>
                            <div class="form-group col-md-4 @if($errors->has('vencimiento_rvoe')) has-error @endif">
                               <label for="vencimiento_rvoe-field">Vencimiento RVOE</label>
                               {!! Form::text("vencimiento_rvoe", null, array("class" => "form-control input-sm", "id" => "vencimiento_rvoe-field")) !!}
                               @if($errors->has("vencimiento_rvoe"))
                                <span class="help-block">{{ $errors->first("rvoe") }}</span>
                               @endif
                            </div>
                            <div class="form-group col-md-4 @if($errors->has('ccte')) has-error @endif">
                               <label for="ccte-field">CCTE</label>
                               {!! Form::text("ccte", null, array("class" => "form-control input-sm", "id" => "ccte-field")) !!}
                               @if($errors->has("ccte"))
                                <span class="help-block">{{ $errors->first("ccte") }}</span>
                               @endif
                            </div>
                            <div class="form-group col-md-4 @if($errors->has('meta')) has-error @endif">
                               <label for="meta-field">Meta Empleado</label>
                               {!! Form::text("meta", null, array("class" => "form-control input-sm", "id" => "meta-field")) !!}
                               @if($errors->has("meta"))
                                <span class="help-block">{{ $errors->first("meta") }}</span>
                               @endif
                            </div>
                            <div class="form-group col-md-4 @if($errors->has('abreviatura')) has-error @endif">
                               <label for="abreviatura-field">Abreviatura</label>
                               {!! Form::text("abreviatura", null, array("class" => "form-control input-sm", "id" => "abreviatura-field")) !!}
                               @if($errors->has("abreviatura"))
                                <span class="help-block">{{ $errors->first("abreviatura") }}</span>
                               @endif
                            </div>
                            @if(isset($especialidad))
                            <input type="hidden" name="_token" id="_token"  value="<?= csrf_token(); ?>"> 
                            <div class="form-group">
                                <div class="btn btn-default btn-file">
                                    <i class="fa fa-paperclip"></i> Adjuntar Archivo
                                    <input type="file"  id="file" name="file" class="email_archivo" >
                                </div>
                                <p class="help-block"  >Max. 20MB</p>
                                <div id="texto_notificacion">

                                </div>
                            </div>
                            @endif
                        </div>
                    </div>

                    <div class="box box-default box-solid">
                        <div class="box-header">
                            <h3 class="box-title">PARAMETROS GRAFICAS</h3>
                            <div class="box-tools">
                                <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                            </div>
                        </div>
                        <div class="box-body">
                            <!--
                            <div class="form-group col-md-2 @if($errors->has('bnd_usar_lectivo')) has-error @endif">
                                <label for="bnd_usar_lectivo-field">Usar Lectivo</label>
                                {!! Form::checkbox("bnd_usar_lectivo", 1, null, [ "id" => "bnd_usar_lectivo-field"]) !!}
                                @if($errors->has("bnd_usar_lectivo"))
                                 <span class="help-block">{{ $errors->first("bnd_usar_lectivo") }}</span>
                                @endif
                             </div>
                            -->
                            <div class="form-group col-md-4 @if($errors->has('lectivo_id')) has-error @endif">
                                  <label for="lectivo_id-field">Lectivo</label>
                                  {!! Form::select("lectivo_id", $lectivos, null, array("class" => "form-control select_seguridad", "id" => "lectivo_id-field")) !!}
                                  @if($errors->has("lectivo_id"))
                                    <span class="help-block">{{ $errors->first("lectivo_id") }}</span>
                                  @endif
                                </div>
                            <!-- 
                            <div class="form-group col-md-4 @if($errors->has('f_inicio')) has-error @endif">
                                <label for="f_inicio-field">Fecha Inicio</label>
                                {!! Form::text("f_inicio", null, array("class" => "form-control input-sm", "id" => "f_inicio-field")) !!}
                                @if($errors->has("f_inicio"))
                                 <span class="help-block">{{ $errors->first("f_inicio") }}</span>
                                @endif
                             </div>
                             <div class="form-group col-md-4 @if($errors->has('f_fin')) has-error @endif">
                                <label for="f_fin-field">Fecha Fin</label>
                                {!! Form::text("f_fin", null, array("class" => "form-control input-sm", "id" => "f_fin-field")) !!}
                                @if($errors->has("f_fin"))
                                 <span class="help-block">{{ $errors->first("f_fin") }}</span>
                                @endif
                             </div>
                            -->
                        </div>
                    </div>
                    
@push('scripts')
  <script type="text/javascript">
    $(document).ready(function() {
    $('#vencimiento_rvoe-field').Zebra_DatePicker({
        days:['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'],
        months:['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
        readonly_element: false,
        lang_clear_date: 'Limpiar',
        show_select_today: 'Hoy',
    });
    $('#f_fin-field').Zebra_DatePicker({
        days:['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'],
        months:['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
        readonly_element: false,
        lang_clear_date: 'Limpiar',
        show_select_today: 'Hoy',
      });
      $('#f_inicio-field').Zebra_DatePicker({
        days:['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'],
        months:['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
        readonly_element: false,
        lang_clear_date: 'Limpiar',
        show_select_today: 'Hoy',
      });
    
    });
    
    @if(isset($especialidad))
    $(document).on("change", ".email_archivo", function (e) {

        var miurl = "{{route('especialidads.cargaArchivo')}}";
        // var fileup=$("#file").val();
        var divresul = "texto_notificacion";

        var data = new FormData();
        data.append('file', $('#file')[0].files[0]);
        data.append('especialidad', {{$especialidad->id}});

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
            beforeSend: function () {
                $("#" + divresul + "").html($("#cargador_empresa").html());
            },
            //una vez finalizado correctamente
            success: function (data) {
                var codigo = '<div class="mailbox-attachment-info"><a href="#" class="mailbox-attachment-name"><i class="fa fa-paperclip"></i>' + data + '</a><span class="mailbox-attachment-size"> </span></div>';
                $("#" + divresul + "").html(codigo);

            },
            //si ha ocurrido un error
            error: function (data) {
                $("#" + divresul + "").html(data);

            }
        });

    })
    @endif
    
    </script>
@endpush                