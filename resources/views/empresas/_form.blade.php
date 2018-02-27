@inject('respuestasVisibles','App\Http\Controllers\CuestionarioDatosController')
<div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
        <li class="active">
            <a data-toggle="tab" href="#tab1">Empresa</a>
        </li>
        <li class="">
            <a data-toggle="tab" href="#tab2">Cuestionario</a>
        </li>
    </ul>
    <div class="tab-content">
        <div id="tab1" class="tab-pane active">
            <div class="box box-default box-solid">
                <div class="box-header">
                    <h3 class="box-title">IDENTIFICACIÓN</h3>
                    <div class="box-tools">
                        <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div>
                </div>
                <div class="box-body">
                    <div class="form-group col-md-4 @if($errors->has('razon_social')) has-error @endif">
                        <label for="razon_social-field">Razon Social</label>
                        {!! Form::text("razon_social", null, array("class" => "form-control input-sm", "id" => "razon_social-field")) !!}
                        @if($errors->has("razon_social"))
                        <span class="help-block">{{ $errors->first("razon_social") }}</span>
                        @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('nombre_contacto')) has-error @endif">
                        <label for="nombre_contacto-field">Nombre Contacto</label>
                        {!! Form::text("nombre_contacto", null, array("class" => "form-control input-sm", "id" => "nombre_contacto-field")) !!}
                        @if($errors->has("nombre_contacto"))
                        <span class="help-block">{{ $errors->first("nombre_contacto") }}</span>
                        @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('tel_fijo')) has-error @endif">
                        <label for="tel_fijo-field">Tel. Fijo</label>
                        {!! Form::text("tel_fijo", null, array("class" => "form-control input-sm", "id" => "tel_fijo-field")) !!}
                        @if($errors->has("tel_fijo"))
                        <span class="help-block">{{ $errors->first("tel_fijo") }}</span>
                        @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('tel_cel')) has-error @endif">
                        <label for="tel_cel-field">Tel. Cel</label>
                        {!! Form::text("tel_cel", null, array("class" => "form-control input-sm", "id" => "tel_cel-field")) !!}
                        @if($errors->has("tel_cel"))
                        <span class="help-block">{{ $errors->first("tel_cel") }}</span>
                        @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('correo1')) has-error @endif">
                        <label for="correo1-field">Correo 1</label>
                        {!! Form::text("correo1", null, array("class" => "form-control input-sm", "id" => "correo1-field")) !!}
                        @if($errors->has("correo1"))
                        <span class="help-block">{{ $errors->first("correo1") }}</span>
                        @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('correo2')) has-error @endif">
                        <label for="correo2-field">Correo 2</label>
                        {!! Form::text("correo2", null, array("class" => "form-control input-sm", "id" => "correo2-field")) !!}
                        @if($errors->has("correo2"))
                        <span class="help-block">{{ $errors->first("correo2") }}</span>
                        @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('calle')) has-error @endif">
                        <label for="calle-field">Calle</label>
                        {!! Form::text("calle", null, array("class" => "form-control input-sm", "id" => "calle-field")) !!}
                        @if($errors->has("calle"))
                        <span class="help-block">{{ $errors->first("calle") }}</span>
                        @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('no_int')) has-error @endif">
                        <label for="no_int-field">No. Int.</label>
                        {!! Form::text("no_int", null, array("class" => "form-control input-sm", "id" => "no_int-field")) !!}
                        @if($errors->has("no_int"))
                        <span class="help-block">{{ $errors->first("no_int") }}</span>
                        @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('no_ex')) has-error @endif">
                        <label for="no_ex-field">No. Ext.</label>
                        {!! Form::text("no_ex", null, array("class" => "form-control input-sm", "id" => "no_ex-field")) !!}
                        @if($errors->has("no_ex"))
                        <span class="help-block">{{ $errors->first("no_ex") }}</span>
                        @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('colonia')) has-error @endif">
                        <label for="colonia-field">Colonia</label>
                        {!! Form::text("colonia", null, array("class" => "form-control input-sm", "id" => "colonia-field")) !!}
                        @if($errors->has("colonia"))
                        <span class="help-block">{{ $errors->first("colonia") }}</span>
                        @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('estado_id')) has-error @endif">
                        <label for="estado_id-field">Estado</label>
                        {!! Form::select("estado_id", $list["Estado"], null, array("class" => "form-control select_seguridad", "id" => "estado_id-field")) !!}
                        @if($errors->has("estado_id"))
                        <span class="help-block">{{ $errors->first("estado_id") }}</span>
                        @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('municipio_id')) has-error @endif">
                        <label for="municipio_id-field">Municipio</label>
                        {!! Form::select("municipio_id", $list["Municipio"], null, array("class" => "form-control select_seguridad", "id" => "municipio_id-field")) !!}
                        @if($errors->has("municipio_id"))
                        <span class="help-block">{{ $errors->first("municipio_id") }}</span>
                        @endif
                    </div>

                    <div class="form-group col-md-4 @if($errors->has('cp')) has-error @endif" style="clear:left;">
                        <label for="cp-field">C.P.</label>
                        {!! Form::text("cp", null, array("class" => "form-control input-sm", "id" => "cp-field")) !!}
                        @if($errors->has("cp"))
                        <span class="help-block">{{ $errors->first("cp") }}</span>
                        @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('giro_id')) has-error @endif">
                        <label for="giro_id-field">Giro</label>
                        {!! Form::select("giro_id", $list["Giro"], null, array("class" => "form-control select_seguridad", "id" => "giro_id-field")) !!}
                        @if($errors->has("giro_id"))
                        <span class="help-block">{{ $errors->first("giro_id") }}</span>
                        @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('cuestionario_id')) has-error @endif">
                        <label for="cuestionario_id-field">Cuestionario</label>
                        {!! Form::select("cuestionario_id", $list["Cuestionario"], null, array("class" => "form-control select_seguridad", "id" => "cuestionario_id-field")) !!}
                        @if($errors->has("cuestionario_id"))
                        <span class="help-block">{{ $errors->first("cuestionario_id") }}</span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="box box-default box-solid">
                <div class="box-header">
                    <h3 class="box-title">Datos relacionados</h3>
                    <div class="box-tools">
                        <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div>
                </div>
                <div class="box-body">
                    <div class="form-group col-md-4 @if($errors->has('especialidad_id')) has-error @endif">
                        <label for="especialidad_id-field">Especialidad</label>
                        {!! Form::hidden("plantel_id", $p, array("class" => "form-control input-sm", "id" => "plantel_id-field")) !!}
                        {!! Form::select("especialidad_id", $list["Especialidad"], null, array("class" => "form-control select_seguridad", "id" => "especialidad_id-field")) !!}
                        @if($errors->has("especialidad_id"))
                        <span class="help-block">{{ $errors->first("especialidad_id") }}</span>
                        @endif
                    </div>
                    <div class="row">
                    </div>
                    @if(isset($empresa))
                    <div class="form-group"><strong>Actividades Relacionadas</strong> </div>
                    <div class="row_actividades_relacionados">

                        <div class="col-xs-5">
                            Elegir
                            {!! Form::select("select-actividad_id", $actividadesList, null, array("class" => "form-control select-multiple", "id" => "select-actividades_from", "name"=>"from[]", 'multiple'=>'multiple')) !!}
                        </div>

                        <div class="col-xs-2">
                            <!--<button type="button" id="right_All_1" class="btn btn-block"><i class="glyphicon glyphicon-forward"></i></button>-->
                            <button type="button" id="right_Selected_1" class="btn btn-success btn-block"><i class="glyphicon glyphicon-chevron-right"></i></button>
                            <button type="button" id="left_Selected_1" class="btn btn-success btn-block"><i class="glyphicon glyphicon-chevron-left"></i></button>
                            <!--<button type="button" id="left_All_1" class="btn btn-block"><i class="glyphicon glyphicon-backward"></i></button>-->
                        </div>

                        <div class="col-xs-5">
                            Seleccionadas
                            {!! Form::select("select-actividad_id", $actividadesRelacionados, null, array("class" => "form-control select-multiple", "id" => "select-actividades_to", "name"=>"to[]", 'multiple'=>'multiple')) !!}
                        </div>
                        <div class="col-md-12 col-xs-12" >
                            <fieldset>
                                <div class="form-group col-md-3 @if($errors->has('nivel_id')) has-error @endif">
                                    <label for="nivel_id-field">Nivel</label>
                                    {!! Form::select("nivel_id", $list1["Nivel"], null, array("class" => "form-control select_seguridad", "id" => "nivel_id-field")) !!}
                                    <div id='loading11' style='display: none'><img src="{{ asset('images/ajax-loader.gif') }}" title="Enviando" /></div> 
                                    @if($errors->has("nivel_id"))
                                    <span class="help-block">{{ $errors->first("nivel_id") }}</span>
                                    @endif
                                </div>
                                <div class="form-group col-md-4 @if($errors->has('grado_id')) has-error @endif">
                                    <label for="grado_id-field">Grado</label>
                                    {!! Form::select("grado_id", $list1["Grado"], null, array("class" => "form-control select_seguridad", "id" => "grado_id-field")) !!}
                                    <div id='loading12' style='display: none'><img src="{{ asset('images/ajax-loader.gif') }}" title="Enviando" /></div> 
                                    @if($errors->has("grado_id"))
                                    <span class="help-block">{{ $errors->first("grado_id") }}</span>
                                    @endif
                                </div>
                                @permission('inscripcions.create')
                                <div class="form-group col-md-1 @if($errors->has('grado_id')) has-error @endif">
                                    <br/><input type="button" class="btn btn-primary" value="Inscribir" onclick="CrearCombinacionEmpresa()" />
                                </div>
                                @endpermission    
                            </fieldset>
                        </div>
                    </div>
                    @endif
                </div>
                @if(isset($empresa))
                <table class="table table-condensed table-striped">
                    <thead>
                    <td>Nivel</td>
                    <td>Grado</td>
                    <td></td>
                    </thead>
                    <tbody>
                        @foreach($empresa->combinaciones as $c)
                        <tr>
                            <td>{{$c->nivel->name}}</td>
                            <td>{{$c->grado->name}}</td>
                            <td> <a href="{!! route('combinacionEmpresas.destroy', $c->id) !!}" class="btn btn-xs btn-danger">Eliminar</a>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @endif
            </div>
        </div>
        @if(isset($empresa->cuestionario) and $empresa->cuestionario->id<>0)
        <div id="tab2" class="tab-pane">
            <h3>{{$empresa->cuestionario->name}}</h3> 
                @foreach($empresa->cuestionario->preguntas as $p)
                <div class="form-group col-md-12 @if($errors->has('especialidad_id')) has-error @endif">
                    <label>{{ $p->numero.". ".$p->name }}</label>
                    <div class="row">
                    @foreach($p->respuestas as $r)
                    {!! Form::radio($p->id, $r->id, $respuestasVisibles->visible($empresa->id,$empresa->cuestionario->id,$p->id,$r->id)) !!} {{$r->clave.". ".$r->name }} <br/>
                    @endforeach
                    
                    </div>
                </div>
                @endforeach
        </div>
        @endif
    </div>
    @push('scripts')
    <link href="{{asset('bower_components/AdminLTE/plugins/jquery.loading.css')}}" rel="stylesheet">
    <script src="{{ asset('bower_components/AdminLTE/plugins/multiselect.js') }}"></script>
    <script src="{{ asset('bower_components/AdminLTE/plugins/jquery.loading.js') }}"></script>
    <script type="text/javascript">
                                $(document).ready(function () {
                                    @if(isset($empresa))
                                    $('#select-actividades_from').multiselect({
                                        right: '#select-actividades_to',
                                        search: {
                                            left: '<input type="text" name="q" class="form-control" placeholder="Buscar..." />',
                                            right: '<input type="text" name="q" class="form-control" placeholder="Buscar..." />',
                                        },
                                        fireSearch: function (value) {
                                            return value.length > 3;
                                        },
                                        rightAll: '#right_All_1',
                                        rightSelected: '#right_Selected_1',
                                        leftSelected: '#left_Selected_1',
                                        leftAll: '#left_All_1',
                                        beforeMoveToLeft: function ($left, $right, $options) {
                                            var actividad = $("select#select-actividades_to option:selected").val();
                                            $.ajax({
                                                url: '{{ route("empresas.lessActividad") }}',
                                                type: 'GET',
                                                data: "empresa={{$empresa->id}}&actividad=" + actividad + "",
                                                dataType: 'json',
                                                beforeSend: function () {
                                                    $('.row_actividades_relacionados').loading({
                                                        theme: 'dark',
                                                        message: 'Procesando..',
                                                    });
                                                },
                                                complete: function () {
                                                    $('.row_actividades_relacionados').loading('stop');
                                                },
                                                success: function (data) {

                                                }
                                            });
                                            return true;
                                        },
                                        beforeMoveToRight: function ($left, $right, $options) {
                                            var actividad = $("select#select-actividades_from option:selected").val();
                                            $.ajax({
                                                url: '{{ route("empresas.addActividad") }}',
                                                type: 'GET',
                                                data: "empresa={{$empresa->id}}&actividad=" + actividad + "",
                                                dataType: 'json',
                                                beforeSend: function () {
                                                    $('.row_actividades_relacionados').loading({
                                                        theme: 'dark',
                                                        message: 'Procesando..',
                                                    });
                                                },
                                                complete: function () {
                                                    $('.row_actividades_relacionados').loading('stop');
                                                },
                                                success: function (data) {

                                                }
                                            });
                                            return true;

                                        },
                                    });
                                    @endif
                                    getCmbEspecialidad();
                                    $('#especialidad_id-field').change(function () {
                                        getCmbActividad();
                                    });
                                    getCmbNivel();
                                    $('#especialidad_id-field').change(function () {
                                        getCmbNivel();
                                    });
                                    @if(isset($empresa))
                                    getCmbGrado();
                                    $('#nivel_id-field').change(function () {
                                        getCmbGrado();
                                    });
                                    @endif
                                    $('#estado_id-field').change(function () {
                                        $.get("{{ url('getCmbMunicipios')}}",
                                                {estado: $(this).val()},
                                                function (data) {
                                                    $('#municipio_id-field').empty();
                                                    $.each(data, function (key, element) {
                                                        $('#municipio_id-field').append("<option value='" + key + "'>" + element + "</option>");
                                                    });
                                                });
                                    });
                                });
                                function getCmbEspecialidad() {
                                    //var $example = $("#especialidad_id-field").select2();
                                    var a = $('#frm_cliente').serialize();
                                    $.ajax({
                                        url: '{{ route("especialidads.getCmbEspecialidad") }}',
                                        type: 'GET',
                                        data: "plantel_id=" + $('#plantel_id-field').val() + "&especialidad_id=" + $('#especialidad_id-field option:selected').val() + "",
                                        dataType: 'json',
                                        beforeSend: function () {
                                            $("#loading10").show();
                                        },
                                        complete: function () {
                                            $("#loading10").hide();
                                        },
                                        success: function (data) {
                                            //$example.select2("destroy");
                                            $('#especialidad_id-field').empty();
                                            $('#especialidad_id-field').append($('<option></option>').text('Seleccionar').val('0'));
                                            $.each(data, function (i) {
                                                //alert(data[i].name);
                                                $('#especialidad_id-field').append("<option " + data[i].selectec + " value=\"" + data[i].id + "\">" + data[i].name + "<\/option>");
                                            });
                                            //$example.select2();
                                        }
                                    });
                                }
                                @if(isset($empresa))
                                function getCmbGrado() {
    //var $example = $("#especialidad_id-field").select2();
                                    var a = $('#frm_cliente').serialize();
                                    $.ajax({
                                        url: '{{ route("grados.getCmbGrados") }}',
                                        type: 'GET',
                                        data: "plantel_id={{$pl}}&especialidad_id=" + $('#especialidad_id-field option:selected').val() + "&nivel_id=" + $('#nivel_id-field option:selected').val() + "&grado_id=" + $('#grado_id-field option:selected').val() + "",
                                        dataType: 'json',
                                        beforeSend: function () {
                                            $("#loading12").show();
                                        },
                                        complete: function () {
                                            $("#loading12").hide();
                                        },
                                        success: function (data) {
                                            //alert(data);
                                            //$example.select2("destroy");
                                            $('#grado_id-field').html('');
                                            //$('#especialidad_id-field').empty();
                                            $('#grado_id-field').append($('<option></option>').text('Seleccionar').val('0'));
                                            $.each(data, function (i) {
                                                //alert(data[i].name);
                                                $('#grado_id-field').append("<option " + data[i].selectec + " value=\"" + data[i].id + "\">" + data[i].name + "<\/option>");
                                            });
                                            //$example.select2();
                                        }
                                    });
                                }

                                function getCmbActividad() {
                                    //var $example = $("#especialidad_id-field").select2();
                                    var a = $('#frm_cliente').serialize();
                                    $.ajax({
                                        url: '{{ route("actividadEmpresas.getCmbActividad") }}',
                                        type: 'GET',
                                        data: "plantel_id=" + $('#plantel_id-field').val() + "&especialidad_id=" + $('#especialidad_id-field option:selected').val() + "",
                                        dataType: 'json',
                                        beforeSend: function () {
                                            $("#loading10").show();
                                        },
                                        complete: function () {
                                            $("#loading10").hide();
                                        },
                                        success: function (data) {
                                            //$example.select2("destroy");
                                            $('#select-actividades_from').empty();
                                            //$('#select-actividades_from').append($('<option></option>').text('Seleccionar').val('0'));
                                            $.each(data, function (i) {
                                                //alert(data[i].name);
                                                $('#select-actividades_from').append("<option " + data[i].selectec + " value=\"" + data[i].id + "\">" + data[i].name + "<\/option>");
                                            });
                                            //$example.select2();
                                        }
                                    });
                                }
                                @endif
                                function getCmbNivel() {
                                    //var $example = $("#especialidad_id-field").select2();
                                    //alert($('#especialidad_id-field option:selected').val());

                                    $.ajax({
                                        url: '{{ route("nivels.getCmbNivels") }}',
                                        type: 'GET',
                                        data: "plantel_id={{$pl}}&especialidad_id=" + $('#especialidad_id-field option:selected').val() + "&nivel_id=" + $('#nivel_id-field option:selected').val() + "",
                                        dataType: 'json',
                                        beforeSend: function () {
                                            $("#loading11").show();
                                        },
                                        complete: function () {
                                            $("#loading11").hide();
                                        },
                                        success: function (data) {
                                            //alert(data);
                                            //$example.select2("destroy");
                                            $('#nivel_id-field').html('');
                                            //$('#especialidad_id-field').empty();
                                            $('#nivel_id-field').append($('<option></option>').text('Seleccionar').val('0'));
                                            $.each(data, function (i) {
                                                //alert(data[i].name);
                                                $('#nivel_id-field').append("<option " + data[i].selectec + " value=\"" + data[i].id + "\">" + data[i].name + "<\/option>");
                                            });
                                            //$example.select2();
                                        }
                                    });
                                }
                                @if(isset($empresa))
                                function CrearCombinacionEmpresa() {
                                    $.ajax({
                                        url: '{{ route("combinacionEmpresas.store") }}',
                                        type: 'POST',
                                        data: "empresa_id={{$empresa->id}}&plantel_id={{$pl}}&especialidad_id=" + $('#especialidad_id-field option:selected').val() + "&nivel_id=" + $('#nivel_id-field option:selected').val() + "&grado_id=" + $('#grado_id-field option:selected').val() + "",
                                        dataType: 'json',
                                        beforeSend: function () {
                                            $("#loading11").show();
                                        },
                                        complete: function () {
                                            location.reload();
                                        },

                                    });
                                }
                                @endif
    </script>

    @endpush                    