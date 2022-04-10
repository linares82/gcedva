<div class="box box-default">
                <div class="box-body">
                    
                    <div class="form-group col-md-4 @if($errors->has('empresas_vinculacion_id')) has-error @endif">
                        <label for="empresa_id-field">Empresa</label>
                        @if(isset($vinculacion))
                        <a href="{{ route('empresasVinculacions.show', $vinculacion->empresas_vinculacion_id) }}" target="_blank">Ver</a>
                        @endif
                        {!! Form::select("empresas_vinculacion_id", $list["EmpresasVinculacion"], null, array("class" => "form-control select_seguridad", "id" => "empresas_vinculacion_id-field", 'style'=>'width:100%')) !!}

                        @if($errors->has("empresas_vinculacion_id"))
                        <span class="help-block">{{ $errors->first("empresas_vinculacion_id") }}</span>
                        @endif
                    </div>
                    @if(isset($vinculacion))
                    <div class="form-group col-md-4 @if($errors->has('area')) has-error @endif">
                        @php
                            $combinacion=\App\CombinacionCliente::where('cliente_id',$vinculacion->cliente_id)->first();
                        @endphp
                        <label for="area-field">Especialidad: {{ $combinacion->especialidad->name }}</label>
                     </div>
                     @endif
                    <div class="form-group col-md-4 @if($errors->has('area')) has-error @endif">
                        <label for="area-field">Area</label>
                        {!! Form::text("area", null, array("class" => "form-control", "id" => "area-field")) !!}
                        @if($errors->has("area"))
                         <span class="help-block">{{ $errors->first("area") }}</span>
                        @endif
                     </div>
                    <div class="form-group col-md-4 @if($errors->has('lugar_practica')) has-error @endif">
                       <label for="lugar_practica-field">Lugar Practica</label>
                       {!! Form::text("lugar_practica", null, array("class" => "form-control", "id" => "lugar_practica-field")) !!}
                       {!! Form::hidden("cliente_id", $cliente, array("class" => "form-control", "id" => "cliente_id-field")) !!}
                       @if($errors->has("lugar_practica"))
                        <span class="help-block">{{ $errors->first("lugar_practica") }}</span>
                       @endif
                    </div>
                    
                    <div class="form-group col-md-4 @if($errors->has('tel_fijo')) has-error @endif">
                       <label for="tel_fijo-field">Tel. Fijo</label>
                       {!! Form::text("tel_fijo", null, array("class" => "form-control", "id" => "tel_fijo-field")) !!}
                       @if($errors->has("tel_fijo"))
                        <span class="help-block">{{ $errors->first("tel_fijo") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('tel_cel')) has-error @endif">
                       <label for="tel_cel-field">Tel. Celular</label>
                       {!! Form::text("tel_cel", null, array("class" => "form-control", "id" => "tel_cel-field")) !!}
                       @if($errors->has("tel_cel"))
                        <span class="help-block">{{ $errors->first("tel_cel") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('nombre_contacto')) has-error @endif">
                       <label for="nombre_contacto-field">Nombre Contacto</label>
                       {!! Form::text("nombre_contacto", null, array("class" => "form-control", "id" => "nombre_contacto-field")) !!}
                       @if($errors->has("nombre_contacto"))
                        <span class="help-block">{{ $errors->first("nombre_contacto") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('puesto')) has-error @endif">
                        <label for="area-field">Puesto</label>
                        {!! Form::text("puesto", null, array("class" => "form-control", "id" => "puesto-field")) !!}
                        @if($errors->has("puesto"))
                         <span class="help-block">{{ $errors->first("puesto") }}</span>
                        @endif
                     </div>
                    <div class="form-group col-md-4 @if($errors->has('mail_contacto')) has-error @endif">
                       <label for="mail_contacto-field">Mail Contacto</label>
                       {!! Form::text("mail_contacto", null, array("class" => "form-control", "id" => "mail_contacto-field")) !!}
                       @if($errors->has("mail_contacto"))
                        <span class="help-block">{{ $errors->first("mail_contacto") }}</span>
                       @endif
                    </div>
                    
                    <div class="form-group col-md-4 @if($errors->has('fec_inicio')) has-error @endif">
                       <label for="fec_inicio-field">Fecha Inicio</label>
                       {!! Form::text("fec_inicio", null, array("class" => "form-control", "id" => "fec_inicio-field")) !!}
                       @if($errors->has("fec_inicio"))
                        <span class="help-block">{{ $errors->first("fec_inicio") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('fec_fin')) has-error @endif">
                       <label for="fec_fin-field">Fecha Fin</label>
                       {!! Form::text("fec_fin", null, array("class" => "form-control", "id" => "fec_fin-field")) !!}
                       @if($errors->has("fec_fin"))
                        <span class="help-block">{{ $errors->first("fec_fin") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('aseguradora')) has-error @endif">
                        <label for="aseguradora-field">Aseguradora</label>
                        {!! Form::text("aseguradora", null, array("class" => "form-control", "id" => "aseguradora-field")) !!}
                        @if($errors->has("aseguradora"))
                         <span class="help-block">{{ $errors->first("aseguradora") }}</span>
                        @endif
                     </div>
                     <div class="form-group col-md-4 @if($errors->has('no_poliza')) has-error @endif">
                        <label for="no_poliza-field">No. Poliza</label>
                        {!! Form::text("no_poliza", null, array("class" => "form-control", "id" => "no_poliza-field")) !!}
                        @if($errors->has("no_poliza"))
                         <span class="help-block">{{ $errors->first("no_poliza") }}</span>
                        @endif
                     </div>
                    <div class="form-group col-md-4 @if($errors->has('st_vinculacion_id')) has-error @endif">
                        <label for="st_vinculacion_id-field">Estatus</label>
                        {!! Form::select("st_vinculacion_id", $list["StVinculacion"], null, array("class" => "form-control select_seguridad", "id" => "st_vinculacion_id-field", 'style'=>'width:100%')) !!}
                        @if($errors->has("st_vinculacion_id"))
                        <span class="help-block">{{ $errors->first("st_vinculacion_id") }}</span>
                        @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('clasificacion_id')) has-error @endif">
                        <label for="clasificacion_id-field">Clasificación</label>
                        {!! Form::select("clasificacion_id", $list["Clasificacion"], null, array("class" => "form-control select_seguridad", "id" => "clasificacion_id-field", 'style'=>'width:100%')) !!}
                        @if($errors->has("clasificacion_id"))
                        <span class="help-block">{{ $errors->first("clasificacion_id") }}</span>
                        @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('csc_vinculacion')) has-error @endif">
                        <label for="csc_vinculacion-field">Consecutivo Vinculacion</label>
                        {!! Form::text("csc_vinculacion", null, array("class" => "form-control input-sm", "id" => "csc_vinculacion-field", 'disabled'=>true)) !!}
                        @if($errors->has("csc_vinculacion"))
                         <span class="help-block">{{ $errors->first("csc_vinculacion") }}</span>
                        @endif
                     </div>
                    <div class="form-group col-md-4 @if($errors->has('bnd_constancia_entregada')) has-error @endif">
                       <label for="bnd_constancia_entregada-field">DV4 Entregada</label>
                       {!! Form::checkbox("bnd_constancia_entregada", 1, null, [ "id" => "bnd_constancia_entregada-field", 'class'=>'minimal']) !!}
                       @if($errors->has("bnd_constancia_entregada"))
                        <span class="help-block">{{ $errors->first("bnd_constancia_entregada") }}</span>
                       @endif
                    </div>
                </div>
</div>
<div class="box box-default">
    <div class="box-body"> 


@if(isset($vinculacion))
@permission('vinculacion.controlHoras')        
<div class="row"></div>

<strong>Carga de Horas</strong>
<div class="row"></div>    
    <div class="form-group col-md-2 @if($errors->has('fec_inicio')) has-error @endif">
        <label for="fec_inicio-field">Fecha Inicio</label>
        {!! Form::text("fec_inicio1", null, array("class" => "form-control fecha", "id" => "fec_inicio1-field")) !!}
        @if($errors->has("fec_inicio"))
         <span class="help-block">{{ $errors->first("fec_inicio") }}</span>
        @endif
     </div>
     <div class="form-group col-md-2 @if($errors->has('fec_fin')) has-error @endif">
        <label for="fec_fin-field">Fecha Fin</label>
        {!! Form::text("fec_fin1", null, array("class" => "form-control fecha", "id" => "fec_fin1-field")) !!}
        @if($errors->has("fec_fin"))
         <span class="help-block">{{ $errors->first("fec_fin") }}</span>
        @endif
     </div>
     <div class="form-group col-md-1 @if($errors->has('horas')) has-error @endif">
        <label for="horas-field">Horas</label>
        {!! Form::number("horas", null, array("class" => "form-control", "id" => "horas-field")) !!}
        @if($errors->has("lugar_practica"))
         <span class="help-block">{{ $errors->first("horas") }}</span>
        @endif
     </div>

     <div class="form-group col-md-2">
            <div class="btn btn-default btn-file">
                <i class="fa fa-paperclip"></i> Adjuntar Archivo
                <input type="file"  id="file_fv6" name="file_fv6" class="cliente_archivo_fv6" >
                <input type="hidden" name="_token" id="_token"  value="<?= csrf_token(); ?>"> 
                <input type="hidden"  id="file_hidden" name="file_hidden" >
            </div>
            <br/>
            <p class="help-block"  >Max. 20MB</p>
            <div id="texto_notificacion">
            </div>
    </div>

     <div class="form-group col-md-1 @if($errors->has('horas')) has-error @endif">
         <button class="btn btn-success btn-md" id="btn_horas"> <span class="glyphicon glyphicon-ok">Cargar</span> </btn>
     </div>
     <div class="form-group col-md-4 @if($errors->has('horas')) has-error @endif">
        <table class="table table-condensed table-striped">
            <thead>
                <tr>
                    <th>F. Inicio</th><th>F. Fin</th><th>horas</th><th></th>
                </tr>
            </thead>
            <tbody>
                <?php $total_horas=0; ?>
                @foreach($vinculacion->vinculacionHoras as $vh)
                <tr>
                    <td>
                        {{ $vh->fec_inicio }}
                    </td>
                    <td>
                        {{ $vh->fec_fin }}
                    </td>
                    <td>
                        {{ $vh->horas }}
                    </td>
                    <td>
                        @if(!is_null($vh->fv6))
                        <a href="{{ asset('/imagenes/fv6/'.$vh->fv6) }}" target="_blank">Ver</a>
                        @endif
                    </td>
                    <td>
                        <a class="btn btn-xs btn-danger" href="{{url('vinculacionHoras/destroy', $vh->id)}}">Eliminar</a>
                    </td>
                </tr>
                <?php $total_horas=$total_horas+$vh->horas ?>
                @endforeach
                <tr>
                    <td colspan='2'><strong>Horas Sumadas</strong></td><td><strong>{{$total_horas}}</strong></td><td></td><td></td>
                </tr>
            </tbody>
        </table>
     </div>
    </div>
</div>
@endpermission

@permission('vinculacion.cargaDocumentos')
<div class="box box-default">
    <div class="box-body"> 
<strong>Carga de Documentos</strong>
<div class="row"></div>    
    
    <div>
                <div class="form-group col-md-2 @if($errors->has('doc_fec_inicio')) has-error @endif">
                    <label for="doc_fec_inicio-field">Inicio</label>
                    {!! Form::hidden("doc_vinculacion_vinculacion_id-field", null, array("class" => "form-control input-sm", "id" => "doc_vinculacion_vinculacion_id-field")) !!}
                    {!! Form::text("doc_fec_inicio", null, array("class" => "form-control input-sm fecha", "id" => "doc_fec_inicio-field")) !!}
                    @if($errors->has("doc_fec_inicio"))
                    <span class="help-block">{{ $errors->first("doc_fec_inicio") }}</span>
                    @endif
                </div>

                <div class="form-group col-md-2 @if($errors->has('doc_fec_fin')) has-error @endif">
                    <label for="doc_fec_fin-field">Fin</label>
                    {!! Form::text("doc_fec_fin", null, array("class" => "form-control input-sm fecha", "id" => "doc_fec_fin-field")) !!}
                    @if($errors->has("doc_fec_fin"))
                    <span class="help-block">{{ $errors->first("doc_fec_fin") }}</span>
                    @endif
                </div>

                <div class="form-group col-md-4 @if($errors->has('doc_vinculacion_id')) has-error @endif">
                    <label for="doc_vinculacion_id-field">Documento</label>
                    {!! Form::select("doc_vinculacion_id", $documentos_vinculacion, null, array("class" => "form-control select_seguridad", "id" => "doc_vinculacion_id-field", 'style'=>'width:100%')) !!}
                    @if($errors->has("doc_vinculacion_id"))
                    <span class="help-block">{{ $errors->first("doc_vinculacion_id") }}</span>
                    @endif
                </div>
                
                <div class="form-group col-md-4">
                        <div class="btn btn-default btn-file">
                            <i class="fa fa-paperclip"></i> Adjuntar Archivo
                            <input type="file"  id="file" name="file" class="cliente_archivo" >
                            <input type="hidden" name="_token" id="_token"  value="<?= csrf_token(); ?>"> 
                            <input type="hidden"  id="file_hidden" name="file_hidden" >
                        </div>
                        <button class="btn btn-success btn-xs" id="btn_archivo"> <span class="glyphicon glyphicon-ok">Cargar/Crear</span> </btn>
                        <button class="btn btn-warning btn-xs" id="btn_archivoEditar"> <span class="glyphicon glyphicon-ok">Cargar/Editar</span> </btn>
                        
                        <div id="texto_notificacion">
                        </div>
                </div>

                <div class="row"></div>
                <div class="form-group col-md-6">
                        <table class="table table-condensed table-striped">
                            <thead>
                                <tr><th>Orden</th>
                                    <th>Inicio</th><th>Fin</th>
                                    <th>Documento Agregados</th><th>Link</th><th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($vinculacion->docVinculacionVinculacions as $doc)
                                <tr><td>{{ $doc->docVinculacion->orden }}</td>
                                    <td>{{ $doc->fec_inicio }}</td><td>{{ $doc->fec_fin }}</td>
                                    <td>
                                        {{$doc->docVinculacion->name}}
                                    </td>
                                    <td>@if(!is_null($doc->archivo))
                                        <a href="{{ asset('/imagenes/vinculacions/'.$vinculacion->id."/".$doc->archivo) }}" target="_blank">Ver</a>
                                        @endif
                                    </td>
                                    
                                    <td>
                                        <a class="btn btn-xs btn-danger" href="{{url('docVinculacionVinculacions/destroy', $doc->id)}}">Eliminar</a>
                                        <button class="btn btn-info btn-xs" id="btn_editar_archivo" 
                                            data-id="{{ $doc->id }}"
                                            data-fec_inicio="{{ $doc->fec_inicio }}"
                                            data-fec_fin="{{ $doc->fec_fin }}"
                                            data-documento_id="{{ $doc->doc_vinculacion_id }}"
                                            data-doc_vinculacion_vinculacion_id={{ $doc->id }}
                                            > 
                                            <span class="glyphicon glyphicon-ok">Editar</span> 
                                        </button>
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
                                    <th>Orden</th>
                                    <th>Documentos Faltantes</th><th>Obligatorio</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($documentos_faltantes as $df)
                                <tr>
                                    <td>{{ $df->orden }}</td>
                                    <td>
                                        {{ $df->name }}
                                    </td>
                                    <td>
                                        @if($df->bnd_obligatorio == 1)
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
    </div>
@endpermission

@permission('vinculacion.controlCargaDocumentos')        

@endpermission

@endif

@push('scripts')
  <script type="text/javascript">
    $(document).ready(function() {
    $('#fec_inicio-field').Zebra_DatePicker({
        days:['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'],
        months:['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
        readonly_element: false,
        lang_clear_date: 'Limpiar',
        show_select_today: 'Hoy',
      });
      $('#fec_fin-field').Zebra_DatePicker({
        days:['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'],
        months:['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
        readonly_element: false,
        lang_clear_date: 'Limpiar',
        show_select_today: 'Hoy',
      });
      $('.fecha').Zebra_DatePicker({
        days:['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'],
        months:['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
        readonly_element: false,
        lang_clear_date: 'Limpiar',
        show_select_today: 'Hoy',
      });
      
    });
    
    
    $(document).on("click", "#btn_archivo", function (e) {
        e.preventDefault();
        if($('#doc_vinculacion_id-field option:selected').val()==0){
            alert("Elegir Documento para Cargar");
        }
        var miurl = "{{route('vinculacions.cargarImg')}}";
        // var fileup=$("#file").val();
        var divresul = "texto_notificacion";

        var data = new FormData();
        data.append('file', $('#file')[0].files[0]);
        data.append('doc_vinculacion_id', $('#doc_vinculacion_id-field option:selected').val());
        data.append('fec_inicio', $('#doc_fec_inicio-field').val());
        data.append('fec_fin', $('#doc_fec_fin-field').val());
        @if(isset($vinculacion))
            data.append('vinculacion', {{$vinculacion->id}});
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
            beforeSend: function () {
                $("#" + divresul + "").html($("#cargador_empresa").html());
            },
            //una vez finalizado correctamente
            success: function (data) {
                if (confirm('¿Deseas Actualizar la Página?')){
                    location.reload();
                }

            },
            //si ha ocurrido un error
            error: function (data) {


            }
        });
    })
    
    @if(isset($vinculacion))
    $(document).on("click", "#btn_horas", function (e) {
        e.preventDefault();
        var miurl = "{{route('vinculacionHoras.store')}}";
        // var fileup=$("#file").val();
        var divresul = "texto_notificacion";

        var data = new FormData();
        
        data.append('file', $('#file_fv6')[0].files[0]);
        data.append('vinculacion_id', {{$vinculacion->id}});
        data.append('fec_inicio', $('#fec_inicio1-field').val());
        data.append('fec_fin', $('#fec_fin1-field').val());
        data.append('horas', $('#horas-field').val());

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
            beforeSend: function () {
                $("#" + divresul + "").html($("#cargador_empresa").html());
            },
            //una vez finalizado correctamente
            success: function (data) {
                if (confirm('¿Deseas Actualizar la Página?')){
                    location.reload();
                }

            },
            //si ha ocurrido un error
            error: function (data) {


            }
        });
    })
    @endif

    $(document).on("click", "#btn_editar_archivo", function (e) {
        e.preventDefault();

        console.log($(this).data('fec_inicio'));
        $('#doc_fec_inicio-field').val($(this).data('fec_inicio')).data('Zebra_DatePicker');
        
        
        $('#doc_fec_fin-field').val($(this).data('fec_fin')).data('Zebra_DatePicker');
        
        $('#doc_vinculacion_id-field').val($(this).data('documento_id')).change();
        $('#doc_vinculacion_vinculacion_id-field').val($(this).data('doc_vinculacion_vinculacion_id'));
        
    });

    $(document).on("click", "#btn_archivoEditar", function (e) {
        e.preventDefault();
        if($('#doc_vinculacion_id-field option:selected').val()==0){
            alert("Elegir Documento para Cargar");
        }
        var miurl = "{{route('vinculacions.cargarImgEditar')}}";
        // var fileup=$("#file").val();
        var divresul = "texto_notificacion";

        var data = new FormData();
        data.append('file', $('#file')[0].files[0]);
        data.append('doc_vinculacion_id', $('#doc_vinculacion_id-field option:selected').val());
        data.append('fec_inicio', $('#doc_fec_inicio-field').val());
        data.append('fec_fin', $('#doc_fec_fin-field').val());
        data.append('id', $('#doc_vinculacion_vinculacion_id-field').val());
        @if(isset($vinculacion))
            data.append('vinculacion', {{$vinculacion->id}});
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
            beforeSend: function () {
                $("#" + divresul + "").html($("#cargador_empresa").html());
            },
            //una vez finalizado correctamente
            success: function (data) {
                if (confirm('¿Deseas Actualizar la Página?')){
                    location.reload();
                }

            },
            //si ha ocurrido un error
            error: function (data) {


            }
        });
    });
    </script>
@endpush                    