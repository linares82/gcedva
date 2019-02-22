@inject('respuestasVisibles','App\Http\Controllers\CcuestionarioDatosController')
<div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
        <li class="active">
            <a data-toggle="tab" href="#tab1">Cliente</a>
        </li>
        <li class="">
            <a data-toggle="tab" href="#tab2">Preguntas</a>
        </li>
        @permission('inscripcions.create')
        <li class="">
            <a data-toggle="tab" href="#tab3">Otros Datos</a>
        </li>
        <li class="">
            <a data-toggle="tab" href="#tab4">Responsables</a>
        </li>
        <li class="">
            <a data-toggle="tab" href="#tab5">Inscripciones</a>
        </li>
        <li class="">
            <a data-toggle="tab" href="#tab6">Documentos</a>
        </li>
        @endpermission
    </ul>
    <div class="tab-content">
        <div id="tab1" class="tab-pane active">
            <fieldset>
                <div class="box box-default box-solid">
                    <div class="box-header">
                        <h3 class="box-title">IDENTIFICACIÓN</h3>
                        <div class="box-tools">
                            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="form-group col-md-4 @if($errors->has('curp')) has-error @endif">
                            <label for="curp-field">CURP</label>
                            {!! Form::text("curp", null, array("class" => "form-control input-sm", "id" => "curp-field")) !!}
                            @if($errors->has("curp"))
                            <span class="help-block">{{ $errors->first("curp") }}</span>
                            @endif
                        </div>
                        <div class="form-group col-md-4 @if($errors->has('escuela_procedencia')) has-error @endif">
                            <label for="escuela_procedencia-field">Escuela Procedencia</label><div id="contador"></div>
                            {!! Form::text("escuela_procedencia", null, array("class" => "form-control input-sm", "id" => "escuela_procedencia-field")) !!}
                            @if($errors->has("escuela_procedencia"))
                            <span class="help-block">{{ $errors->first("escuela_procedencia") }}</span>
                            @endif
                        </div>

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

                        <div class="form-group col-md-4 @if($errors->has('tel_fijo')) has-error @endif">
                            <label for="tel_fijo-field">Teléfono Fijo</label>
                            {!! Form::text("tel_fijo", null, array("class" => "form-control input-sm", "id" => "tel_fijo-field")) !!}
                            @if($errors->has("tel_fijo"))
                            <span class="help-block">{{ $errors->first("tel_fijo") }}</span>
                            @endif
                        </div>
                        <div class="form-group col-md-4 @if($errors->has('st_cliente_id')) has-error @endif">
                            <label for="st_cliente_id-field">Estatus</label>
                            {!! Form::select("st_cliente_id", $list["StCliente"], null, array("class" => "form-control select_seguridad", "id" => "st_cliente_id-field")) !!}
                            @if($errors->has("st_cliente_id"))
                            <span class="help-block">{{ $errors->first("st_cliente_id") }}</span>
                            @endif
                        </div>
                        <div class="form-group col-md-4 @if($errors->has('plantel_id')) has-error @endif">
                            <label for="plantel_id-field">Plantel</label>
                            {!! Form::select("plantel_id", $list["Plantel"], null, array("class" => "form-control select_seguridad", "id" => "plantel_id-field")) !!}
                            @if($errors->has("plantel_id"))
                            <span class="help-block">{{ $errors->first("plantel_id") }}</span>
                            @endif
                        </div>
                        <div class="form-group col-md-4 @if($errors->has('empleado_id')) has-error @endif" style="clear:left;">
                            <label for="empleado_id-field">Empleado</label>
                            {!! Form::select("empleado_id", $empleados, null, array("class" => "form-control select_seguridad", "id" => "empleado_id-field")) !!}
                            <div id='loading3' style='display: none'><img src="{{ asset('images/ajax-loader.gif') }}" title="Enviando" /></div> 
                            @if($errors->has("empleado_id"))
                            <span class="help-block">{{ $errors->first("empleado_id") }}</span>
                            @endif
                        </div>

                        <div class="form-group col-md-4 @if($errors->has('empresa_id')) has-error @endif">
                            <label for="empresa_id-field">Empresa</label>
                            {!! Form::select("empresa_id", $list["Empresa"], null, array("class" => "form-control select_seguridad", "id" => "empresa_id-field", 'readonly'=>'readonly')) !!}
                            @if($errors->has("empresa_id"))
                            <span class="help-block">{{ $errors->first("empresa_id") }}</span>
                            @endif
                        </div>

                        <div class="form-group col-md-4 @if($errors->has('ciclo_id')) has-error @endif">
                            <label for="ciclo_id-field">Ciclo</label>
                            {!! Form::select("ciclo_id", $list["Ciclo"], null, array("class" => "form-control select_seguridad", "id" => "ciclo_id-field")) !!}
                            @if($errors->has("ciclo_id"))
                            <span class="help-block">{{ $errors->first("ciclo_id") }}</span>
                            @endif
                        </div>
                        
                        <div class="form-group col-md-4 @if($errors->has('cve_cliente')) has-error @endif">
                            {!! Form::hidden("id", null, array("class" => "form-control input-sm", "id" => "id-field")) !!}
                            <label for="cve_cliente-field">codigo SMS(Max. 160 catacteres)</label><div id="contador"></div>
                            {!! Form::textArea("cve_cliente", null, array("class" => "form-control input-sm", "id" => "cve_cliente-field", 'rows'=>'3', 'maxlength'=>'160')) !!}
                            @if($errors->has("cve_cliente"))
                            <span class="help-block">{{ $errors->first("cve_cliente") }}</span>
                            @endif
                        </div>

                        @if(isset($cliente))
                        <div class="form-group col-md-4 @if($errors->has('paise_id')) has-error @endif">
                            <label for="paise_id-field">Pais:{{$cliente->paise->name}}</label>
                            {!! Form::hidden("pais_id", $cliente->paise_id, array("class" => "form-control input-sm", "id" => "pais_id-field")) !!}
                        </div>
                        @endif
                        
                    </div>
                </div>
                <div class="box box-default box-solid">
                    <div class="box-header">
                        <h3 class="box-title">CONTACTO DIRECTO</h3>
                        <div class="box-tools bg-white">
                            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="form-group col-md-4 @if($errors->has('tel_cel')) has-error @endif">
                            <label for="tel_cel-field">Teléfono Celular(10 dígitos)</label>
                            {!! Form::text("tel_cel", null, array("class" => "form-control input-sm", "id" => "tel_cel-field")) !!}
                            @if($errors->has("tel_cel"))
                            <span class="help-block">{{ $errors->first("tel_cel") }}</span>
                            @endif
                        </div>
                        <div class="form-group col-md-3 @if($errors->has('celular_confirmado')) has-error @endif">
                            <label for="celular_confirmado-field">Celular Confirmado</label>
                            {!! Form::checkbox("celular_confirmado", 1, null, [ "id" => "celular_confirmado-field", 'class'=>'minimal']) !!}
                            @if($errors->has("celular_confirmado"))
                            <span class="help-block">{{ $errors->first("celular_confirmado") }}</span>
                            @endif
                        </div>
                        @if(isset($cliente))
                        <div class="form-group col-md-2">
                            <label for="celular_confirmado-field">Enviados:</label>
                            {!! $cliente->contador_sms !!}
                        </div>
                        @endif
                        @if(isset($cliente))
                        @permission('clientes.enviaSms')
                        <div class="form-group col-md-3">
                            <button type="button" class="btn btn-primary" id="btn_sms">Enviar SMS Bienvenida</button>   
                            <div id='loading1' style='display: none'><img src="{{ asset('images/ajax-loader.gif') }}" title="Enviando" /></div> 
                            <div id='msj'></div>
                        </div>
                        @endpermission
                        @endif

                        <div class="form-group col-md-4 @if($errors->has('mail')) has-error @endif" style="clear:left;">
                            <label for="mail-field">Correo Electrónico</label>
                            {!! Form::text("mail", null, array("class" => "form-control input-sm", "id" => "mail-field")) !!}
                            @if($errors->has("mail"))
                            <span class="help-block">{{ $errors->first("mail") }}</span>
                            @endif
                        </div>
                        <div class="form-group col-md-3 @if($errors->has('correo_confirmado')) has-error @endif">
                            <label for="correo_confirmado-field">Correo Confirmado</label>
                            {!! Form::checkbox("correo_confirmado", 1, null, [ "id" => "correo_confirmado-field", 'disabled'=>"disabled", 'class'=>'minimal']) !!}
                            <div id='loading2' style='display: none'><img src="{{ asset('images/ajax-loader.gif') }}" title="Enviando" /></div> 
                            @if($errors->has("correo_confirmado"))
                            <span class="help-block">{{ $errors->first("correo_confirmado") }}</span>
                            @endif
                        </div>
                        @if(isset($cliente))
                        <div class="form-group col-md-2">
                            <label for="celular_confirmado-field">Enviados:</label>
                            {!! $cliente->contador_mail !!}
                            
                            
                        </div>
                        @endif
                        @if(isset($cliente))
                        @permission('clientes.enviaMail')
                        <div class="form-group col-md-3">
                            <button type="button" class="btn btn-primary" id="btn_mail">Enviar Mail Bienvenida</button>   
                            <div class="row_1"><div id='loading1' style='display: none'><img src="{{ asset('images/ajax-loader.gif') }}" title="Loading" /></div> </div>
                            <div id='msj'></div>
                        </div>
                        @endpermission
                        @endif
                    </div>
                </div>

                @if(isset($cliente))
                <div class="box box-default box-solid">
                    <div class="box-header">
                        <h3 class="box-title">INTERESES DEL CLIENTE</h3>
                        <div class="box-tools">

                            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        </div>
                    </div>
                    
                    <div class="box-body">   
                        <div class="form-group col-md-3 @if($errors->has('especialidad')) has-error @endif">
                            <label for="especialidad-field">Especialidad</label>
                            {!! Form::select("especialidad_id", $list["Especialidad"], null, array("class" => "form-control select_seguridad", "id" => "especialidad_id-field")) !!}
                            <div id='loading10' style='display: none'><img src="{{ asset('images/ajax-loader.gif') }}" title="Enviando" /></div> 
                            @if($errors->has("especialidad"))
                            <span class="help-block">{{ $errors->first("especialidad") }}</span>
                            @endif
                        </div>
                        <div class="form-group col-md-2 @if($errors->has('nivel_id')) has-error @endif">
                            <label for="nivel_id-field">Nivel</label>
                            {!! Form::select("nivel_id", $list["Nivel"], null, array("class" => "form-control select_seguridad", "id" => "nivel_id-field")) !!}
                            <div id='loading11' style='display: none'><img src="{{ asset('images/ajax-loader.gif') }}" title="Enviando" /></div> 
                            @if($errors->has("nivel_id"))
                            <span class="help-block">{{ $errors->first("nivel_id") }}</span>
                            @endif
                        </div>
                        <div class="form-group col-md-4 @if($errors->has('grado_id')) has-error @endif">
                            <label for="grado_id-field">Grado</label>
                            {!! Form::select("grado_id", $list["Grado"], null, array("class" => "form-control select_seguridad", "id" => "grado_id-field")) !!}
                            <div id='loading12' style='display: none'><img src="{{ asset('images/ajax-loader.gif') }}" title="Enviando" /></div> 
                            @if($errors->has("grado_id"))
                            <span class="help-block">{{ $errors->first("grado_id") }}</span>
                            @endif
                        </div>
                        <div class="form-group col-md-2 @if($errors->has('turno_id')) has-error @endif">
                            <label for="turno_id-field">Turno</label>
                            {!! Form::select("turno_id", $list["Turno"], null, array("class" => "form-control select_seguridad", "id" => "turno_id-field")) !!}
                            <div id='loading12' style='display: none'><img src="{{ asset('images/ajax-loader.gif') }}" title="Enviando" /></div> 
                            @if($errors->has("turno_id"))
                            <span class="help-block">{{ $errors->first("turno_id") }}</span>
                            @endif
                        </div>
                        
                        @permission('combinacionClientes.store')
                        <div class="form-group col-md-1 @if($errors->has('grado_id')) has-error @endif">
                            <br/><input type="button" class="btn btn-xs btn-block btn-success" value="Crear" onclick="CrearCombinacionCliente()" />
                        </div>
                        @endpermission    
                        <div class="row col-md-12">
                            
                            <table class="table table-condensed table-striped">
                                <thead>
                                        <th>Especialidad</th>
                                        <th>Nivel</th>
                                        <th>Grado</th>
                                        <th>Turno</th>
                                        <th>Inscribir</th>
                                        <th>Plan Pago</th>
                                        <th></th>
                                </thead>
                                <tbody>
                                    @foreach($cliente->combinaciones as $c)
                                    @if($c->especialidad_id<>0 and $c->nivel_id<>0 and $c->grado_id<>0 and $c->turno_id<>0)
                                    <tr>
                                        <td>{{$c->especialidad->name}}</td>
                                        <td>{{$c->nivel->name}}</td>
                                        <td>{{$c->grado->name}}</td>
                                        <td>{{$c->turno->name}}</td>
                                        <td>
                                        @if($c->bnd_inscrito==1)  
                                            Si
                                        @endif
                                        </td>
                                        <td>
                                            {!! Form::select("plan_pago_id", $list2["PlanPago"], $c->plan_pago_id, array("class" => "form-control select_seguridad plan_pago", "id" => "plan_pago_id-field", "style"=>"width:75%;", 'data-combinacion'=>$c->id)) !!}
                                            <div id='loading120' style='display: none'><img src="{{ asset('images/ajax-loader.gif') }}" title="Enviando" /></div> 
                                            Impresiones:{{$c->cuenta_ticket_pago}}
                                            @if($c->plan_pago_id<>0)
                                            <a href="{{route('adeudos.imprimirInicial', array('cliente'=>$cliente->id, 'combinacion'=>$c->id))}}" class="btn btn-xs btn-primary" target="_blank" >Imprimir Pago Inicial y Generar Adeudos</a>
                                            @endif
                                            @if(count($cliente->cajas)==0 and count($cliente->adeudos)>0)
                                                <a href="{{route('adeudos.destroyAll', array('cliente'=>$cliente->id, 'combinacion'=>$c->id))}}" class="btn btn-xs btn-primary" >Eliminar Adeudos(Sin Inf. en Caja)</a>
                                            @endif
                                        </td>
                                        <td>
                                            @permission('inscripcions.create')
                                            <td> <a href="{!! route('combinacionClientes.destroy', $c->id) !!}" class="btn btn-xs btn-block btn-danger">Eliminar</a>
                                            <input type="button" class="btn btn-xs btn-block btn-primary" value="Inscribir" onclick="Inscribir({{$c->cliente_id}},{{$c->plantel_id}},{{$c->especialidad_id}},{{$c->nivel_id}},{{$c->grado_id}},{{$c->turno_id}})" />
                                            @endpermission
                                        </td>
                                    </tr>
                                    @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                
                @endif
                
                <div class="box box-default box-solid">
                    <div class="box-header">
                        <h3 class="box-title">INFORMACIÓN DE PUBLICIDAD Y PROPAGANDA</h3>
                        <div class="box-tools">

                            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="form-group col-md-4 @if($errors->has('fec_registro')) has-error @endif">
                            <label for="fec_registro-field">Fecha Registro</label>
                            {!! Form::text("fec_registro", null, array("class" => "form-control input-sm", "id" => "fec_registro-field")) !!}
                            @if($errors->has("fec_registro"))
                            <span class="help-block">{{ $errors->first("fec_registro") }}</span>
                            @endif
                        </div>
                        <div class="form-group col-md-4 @if($errors->has('ofertum_id')) has-error @endif">
                            <label for="ofertum_id-field">Oferta</label>
                            {!! Form::select("ofertum_id", $list['Ofertum'],null, array("class" => "form-control select_seguridad", "id" => "ofertum_id-field")) !!}
                            @if($errors->has("ofertum_id"))
                            <span class="help-block">{{ $errors->first("oferta_id") }}</span>
                            @endif
                        </div>
                        <div class="form-group col-md-4 @if($errors->has('tpo_informe_id')) has-error @endif" >
                            <label for="tpo_informe-field">Tipo Informe</label>
                            {!! Form::select("tpo_informe_id", $list["TpoInforme"], null, array("class" => "form-control select_seguridad", "id" => "tpo_informe_id-field")) !!}
                            @if($errors->has("tpo_informe_id"))
                            <span class="help-block">{{ $errors->first("tpo_informe_id") }}</span>
                            @endif
                        </div>
                        <div class="form-group col-md-4 @if($errors->has('medio_id')) has-error @endif" style="clear:left;">
                            <label for="medio_id-field">Medio por el que se enteró</label>
                            {!! Form::select("medio_id", $list["Medio"], null, array("class" => "form-control select_seguridad", "id" => "medio_id-field")) !!}
                            @if($errors->has("medio_id"))
                            <span class="help-block">{{ $errors->first("medio_id") }}</span>
                            @endif
                        </div>
                        <div class="form-group col-md-4 @if($errors->has('segmento_mercado_id')) has-error @endif" >
                            <label for="segmento_mercado_id-field">Segmento Mercado</label>
                            {!! Form::select("segmento_mercado_id", $list["SegmentoMercado"], null, array("class" => "form-control select_seguridad", "id" => "segmento_mercado_id-field")) !!}
                            @if($errors->has("segmento_mercado_id"))
                            <span class="help-block">{{ $errors->first("segmento_mercado_id") }}</span>
                            @endif
                        </div>
                        <div class="form-group col-md-4 @if($errors->has('expo')) has-error @endif" id="expo-group" >
                            <label for="expo-field">Expo</label>
                            {!! Form::text("expo",null, array("class" => "form-control input-sm", "id" => "expo-field")) !!}
                            @if($errors->has("expo"))
                            <span class="help-block">{{ $errors->first("expo") }}</span>
                            @endif
                        </div>
                        <div class="form-group col-md-4 @if($errors->has('otro_medio')) has-error @endif" id="otro_medio-group">
                            <label for="otro_medio-field">Otro Medio</label>
                            {!! Form::text("otro_medio", null, array("class" => "form-control input-sm", "id" => "otro_medio-field")) !!}
                            @if($errors->has("otro_medio"))
                            <span class="help-block">{{ $errors->first("otro_medio") }}</span>
                            @endif
                        </div>


                        <div class="form-group col-md-4 @if($errors->has('promociones')) has-error @endif">
                            <label for="promociones-field">Promociones</label>
                            {!! Form::checkbox("promociones", 1, null, [ "id" => "promociones-field"]) !!}
                            @if($errors->has("promociones"))
                            <span class="help-block">{{ $errors->first("promociones") }}</span>
                            @endif
                        </div>
                        <div class="form-group col-md-4 @if($errors->has('promo_cel')) has-error @endif">
                            <label for="promo_cel-field">Promociones por Celular</label>
                            {!! Form::checkbox("promo_cel", 1, null, [ "id" => "promo_cel-field"]) !!}
                            @if($errors->has("promo_cel"))
                            <span class="help-block">{{ $errors->first("promo_cel") }}</span>
                            @endif
                        </div>
                        <div class="form-group col-md-4 @if($errors->has('promo_correo')) has-error @endif">
                            <label for="promo_correo-field">Promociones por Correo</label>
                            {!! Form::checkbox("promo_correo", 1, null, [ "id" => "promo_correo-field"]) !!}
                            @if($errors->has("promo_correo"))
                            <span class="help-block">{{ $errors->first("promo_correo") }}</span>
                            @endif
                        </div>
                    </div>
                </div>
                

                <div class="box box-default box-solid">
                    <div class="box-header">
                        <h3 class="box-title">BECA</h3>
                        <div class="box-tools">
                            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="box-body">    
                        <div class="form-group col-md-3 @if($errors->has('beca_bnd')) has-error @endif">
                            <label for="beca_bnd-field">Becado</label>
                            {!! Form::checkbox("beca_bnd", 1, null, [ "id" => "beca_bnd-field", 'class'=>'minimal']) !!}
                            @if($errors->has("beca_bnd"))
                            <span class="help-block">{{ $errors->first("beca_bnd") }}</span>
                            @endif
                        </div>
                        <div class="form-group col-md-8 @if($errors->has('justificacion_beca')) has-error @endif">
                            <label for="justificacion_beca-field">Justificacion</label>
                            {!! Form::text("justificacion_beca", null, array("class" => "form-control input-sm", "id" => "justificacion_beca-field")) !!}
                            @if($errors->has("justificacion_beca"))
                            <span class="help-block">{{ $errors->first("justificacion_beca") }}</span>
                            @endif
                        </div>
                        <div class="form-group col-md-4 @if($errors->has('beca_porcentaje')) has-error @endif">
                            <label for="beca_porcentaje-field">Monto Inscripcion(0.00)</label>
                            {!! Form::text("beca_porcentaje", null, array("class" => "form-control input-sm", "id" => "beca_porcentaje-field")) !!}
                            @if($errors->has("beca_porcentaje"))
                            <span class="help-block">{{ $errors->first("beca_porcentaje") }}</span>
                            @endif
                        </div>
                        <div class="form-group col-md-4 @if($errors->has('monto_mensualidad')) has-error @endif">
                            <label for="monto_mensualidad-field">Monto Mensualidad(0.00)</label>
                            {!! Form::text("monto_mensualidad", null, array("class" => "form-control input-sm", "id" => "monto_mensualidad-field")) !!}
                            @if($errors->has("monto_mensualidad"))
                            <span class="help-block">{{ $errors->first("monto_mensualidad") }}</span>
                            @endif
                        </div>
                        
                        @if(isset($cliente))
                        <div class="form-group col-md-4 @if($errors->has('beca_nota')) has-error @endif">
                            <label > {{ $cliente->beca_nota }}</label>
                        </div>
                        @endif
                    
                    </div>
                </div>
                
                <div class="box box-default box-solid">
                    <div class="box-header">
                        <h3 class="box-title">DIRECCIÓN DEL CLIENTE</h3>
                        <div class="box-tools">
                            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="box-body">    
                        <div class="form-group col-md-4 @if($errors->has('calle')) has-error @endif">
                            <label for="calle-field">Calle</label>
                            {!! Form::text("calle", null, array("class" => "form-control input-sm", "id" => "calle-field")) !!}
                            @if($errors->has("calle"))
                            <span class="help-block">{{ $errors->first("calle") }}</span>
                            @endif
                        </div>
                        <div class="form-group col-md-4 @if($errors->has('no_exterior')) has-error @endif">
                            <label for="no_exterior-field">No. Exterior</label>
                            {!! Form::text("no_exterior", null, array("class" => "form-control input-sm", "id" => "no_exterior-field")) !!}
                            @if($errors->has("no_exterior"))
                            <span class="help-block">{{ $errors->first("no_exterior") }}</span>
                            @endif
                        </div>
                        <div class="form-group col-md-4 @if($errors->has('no_interior')) has-error @endif">
                            <label for="no_interior-field">No. Interior</label>
                            {!! Form::text("no_interior", null, array("class" => "form-control input-sm", "id" => "no_interior-field")) !!}
                            @if($errors->has("no_interior"))
                            <span class="help-block">{{ $errors->first("no_interior") }}</span>
                            @endif
                        </div>
                        <div class="form-group col-md-4 @if($errors->has('colonia')) has-error @endif">
                            <label for="colonia-field">Colonia</label>
                            {!! Form::text("colonia", null, array("class" => "form-control input-sm", "id" => "colonia-field")) !!}
                            @if($errors->has("colonia"))
                            <span class="help-block">{{ $errors->first("colonia") }}</span>
                            @endif
                        </div>
                        <div class="form-group col-md-4 @if($errors->has('cp')) has-error @endif">
                            <label for="cp-field">C.P.</label>
                            {!! Form::text("cp", null, array("class" => "form-control input-sm", "id" => "cp-field")) !!}
                            @if($errors->has("cp"))
                            <span class="help-block">{{ $errors->first("cp") }}</span>
                            @endif
                        </div>
                        <div class="form-group col-md-4 @if($errors->has('estado_id')) has-error @endif">
                            <label for="estado_id-field">Estado</label>
                            {!! Form::select("estado_id", $list["Estado"], null, array("class" => "form-control select_seguridad", "id" => "estado_id-field")) !!}
                            @if($errors->has("estado_id"))
                            <span class="help-block">{{ $errors->first("estado_id") }}</span>
                            @endif
                        </div>
                        <div class="form-group col-md-4 @if($errors->has('municipio_id')) has-error @endif" style="clear:left;">
                            <label for="municipio_id-field">Municipio</label>
                            {!! Form::select("municipio_id", $list["Municipio"], null, array("class" => "form-control select_seguridad", "id" => "municipio_id-field")) !!}
                            @if($errors->has("municipio_id"))
                            <span class="help-block">{{ $errors->first("municipio_id") }}</span>
                            @endif
                        </div>
                    </div>
                </div>
            </fieldset>
        </div>
        <div id="tab2" class="tab-pane">
            <fieldset>
                <div class="form-group col-md-4 @if($errors->has('ccuestionario_id')) has-error @endif">
                    <label for="ccuestionario_id-field">Cuestionario</label>
                    {!! Form::select("ccuestionario_id", $cuestionarios, null, array("class" => "form-control select_seguridad", "id" => "ccuestionario_id-field", "style"=>"width:100%")) !!}
                    @if($errors->has("ccuestionario_id"))
                    <span class="help-block">{{ $errors->first("ccuestionario_id") }}</span>
                    @endif
                </div>
                <div class="form-group col-md-8 @if($errors->has('ccuestionario_id')) has-error @endif">
                    <label for="ccuestionario_id-field">Solo despues de elegir y guardar un cuestionario puede proceder a visualizar las preguntas</label>
                </div>
                @if(isset($cliente->ccuestionario) and $cliente->ccuestionario->id<>0)
                <div id="tab2" class="tab-pane">
                        @foreach($cliente->ccuestionario->ccuestionarioPreguntas as $p)
                        <div class="form-group col-md-12 @if($errors->has('especialidad_id')) has-error @endif">
                            <label>{{ $p->numero.". ".$p->name }}</label>
                            <div class="row">
                            @foreach($p->ccuestionarioRespuesta as $r)
                            {!! Form::radio($p->id, $r->id, $respuestasVisibles->visible($cliente->id,$cliente->ccuestionario->id,$p->id,$r->id)) !!} {{$r->clave.". ".$r->name }} <br/>
                            @endforeach
                            </div>
                        </div>
                        @endforeach
                </div>
                @endif
            </fieldset>
        </div>
        <div id="tab3" class="tab-pane">
            <fieldset>
                <div class="form-group col-md-4 @if($errors->has('matricula')) has-error @endif">
                    <label for="matricula-field">Matricula</label><div id="contador"></div>
                    {!! Form::text("matricula", null, array("class" => "form-control input-sm", "id" => "matricula-field")) !!}
                    @if($errors->has("matricula"))
                    <span class="help-block">{{ $errors->first("matricula") }}</span>
                    @endif
                </div>
                <div class="form-group col-md-4 @if($errors->has('cve_alumno')) has-error @endif">
                    <label for="cve_alumno-field">Clave Alumno</label>
                    {!! Form::text("cve_alumno", null, array("class" => "form-control input-sm", "id" => "cve_alumno-field")) !!}
                    @if($errors->has("cve_alumno"))
                    <span class="help-block">{{ $errors->first("cve_alumno") }}</span>
                    @endif
                </div>
                
                <div class="form-group col-md-4 @if($errors->has('genero')) has-error @endif">
                    <label for="Genero-field">Género</label><br/>
                    {!! Form::radio("genero", 1, null, [ "id" => "genero-field"]) !!}
                    <label for="Genero-field">Masculino</label>
                    {!! Form::radio("genero", 2, null, [ "id" => "genero-field"]) !!}
                    <label for="Genero-field">Femenino</label>
                    @if($errors->has("genero"))
                    <span class="help-block">{{ $errors->first("genero") }}</span>
                    @endif
                </div>
                <div class="form-group col-md-4 @if($errors->has('fec_nacimiento')) has-error @endif">
                    <label for="fec_nacimiento-field">F. Nacimiento</label>
                    {!! Form::text("fec_nacimiento", null, array("class" => "form-control input-sm", "id" => "fec_nacimiento-field")) !!}
                    @if($errors->has("fec_nacimiento"))
                    <span class="help-block">{{ $errors->first("fec_nacimiento") }}</span>
                    @endif
                </div>
                <div class="form-group col-md-4 @if($errors->has('lugar_nacimiento')) has-error @endif">
                    <label for="lugar_nacimiento-field">Lugar Nacimiento</label>
                    {!! Form::text("lugar_nacimiento", null, array("class" => "form-control input-sm", "id" => "lugar_nacimiento-field")) !!}
                    @if($errors->has("lugar_nacimiento"))
                    <span class="help-block">{{ $errors->first("lugar_nacimiento") }}</span>
                    @endif
                </div>
                <div class="form-group col-md-4 @if($errors->has('extranjero')) has-error @endif">
                    <label for="extranjero-field">Extranjero</label>
                    {!! Form::checkbox("extranjero_bnd", 1, null, [ "id" => "extranjero_bnd-field"]) !!}
                    @if($errors->has("extranjero"))
                    <span class="help-block">{{ $errors->first("extranjero") }}</span>
                    @endif
                </div>
                <div class="form-group col-md-4 @if($errors->has('distancia_escuela')) has-error @endif">
                    <label for="distancia_escuela-field">Distancia Escuela</label>
                    {!! Form::text("distancia_escuela", null, array("class" => "form-control input-sm", "id" => "distancia_escuela-field")) !!}
                    @if($errors->has("distancia_escuela"))
                    <span class="help-block">{{ $errors->first("distancia_escuela") }}</span>
                    @endif
                </div>
                <div class="form-group col-md-4 @if($errors->has('peso')) has-error @endif">
                    <label for="peso-field">Peso</label>
                    {!! Form::text("peso", null, array("class" => "form-control input-sm", "id" => "peso-field")) !!}
                    @if($errors->has("peso"))
                    <span class="help-block">{{ $errors->first("peso") }}</span>
                    @endif
                </div>
                <div class="form-group col-md-4 @if($errors->has('estatura')) has-error @endif">
                    <label for="estatura-field">Estatura</label>
                    {!! Form::text("estatura", null, array("class" => "form-control input-sm", "id" => "estatura-field")) !!}
                    @if($errors->has("estatura"))
                    <span class="help-block">{{ $errors->first("estatura") }}</span>
                    @endif
                </div>
                <div class="form-group col-md-4 @if($errors->has('tipo_sangre')) has-error @endif">
                    <label for="tipo_sangre-field">Tipo Sangre</label>
                    {!! Form::text("tipo_sangre", null, array("class" => "form-control input-sm", "id" => "tipo_sangre-field")) !!}
                    @if($errors->has("tipo_sangre"))
                    <span class="help-block">{{ $errors->first("tipo_sangre") }}</span>
                    @endif
                </div>
                <div class="form-group col-md-4 @if($errors->has('alergias')) has-error @endif">
                    <label for="alergias-field">Alergias</label>
                    {!! Form::text("alergias", null, array("class" => "form-control input-sm", "id" => "alergias-field")) !!}
                    @if($errors->has("alergias"))
                    <span class="help-block">{{ $errors->first("alergias") }}</span>
                    @endif
                </div>
                <div class="form-group col-md-4 @if($errors->has('medicinas_contraindicadas')) has-error @endif">
                    <label for="medicinas_contraindicadas-field">Medicinas Contraindicadas</label>
                    {!! Form::text("medicinas_contraindicadas", null, array("class" => "form-control input-sm", "id" => "medicinas_contraindicadas-field")) !!}
                    @if($errors->has("medicinas_contraindicadas"))
                    <span class="help-block">{{ $errors->first("medicinas_contraindicadas") }}</span>
                    @endif
                </div>
                <div class="form-group col-md-4 @if($errors->has('color_piel')) has-error @endif">
                    <label for="color_piel-field">Color Piel</label>
                    {!! Form::text("color_piel", null, array("class" => "form-control input-sm", "id" => "color_piel-field")) !!}
                    @if($errors->has("color_piel"))
                    <span class="help-block">{{ $errors->first("color_piel") }}</span>
                    @endif
                </div>
                <div class="form-group col-md-4 @if($errors->has('color_cabello')) has-error @endif">
                    <label for="color_cabello-field">Color Cabello</label>
                    {!! Form::text("color_cabello", null, array("class" => "form-control input-sm", "id" => "color_cabello-field")) !!}
                    @if($errors->has("color_cabello"))
                    <span class="help-block">{{ $errors->first("color_cabello") }}</span>
                    @endif
                </div>
                <div class="form-group col-md-4 @if($errors->has('senas_particulares')) has-error @endif">
                    <label for="senas_particulares-field">Señas Particulares</label>
                    {!! Form::text("senas_particulares", null, array("class" => "form-control input-sm", "id" => "senas_particulares-field")) !!}
                    @if($errors->has("senas_particulares"))
                    <span class="help-block">{{ $errors->first("senas_particulares") }}</span>
                    @endif
                </div>
            </fieldset>
        </div>
        <div id="tab4" class="tab-pane">
            <fieldset>
                <div class="box box-default box-solid">
                    <div class="box-header">
                        <h3 class="box-title">PADRE</h3>
                        <div class="box-tools">

                            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="form-group col-md-4 @if($errors->has('nombre_padre')) has-error @endif">
                            <label for="nombre_padre-field">Nombre Completo</label>
                            {!! Form::text("nombre_padre", null, array("class" => "form-control input-sm", "id" => "nombre_padre-field")) !!}
                            @if($errors->has("nombre_padre"))
                            <span class="help-block">{{ $errors->first("nombre_padre") }}</span>
                            @endif
                        </div>
                        <div class="form-group col-md-4 @if($errors->has('curp_padre')) has-error @endif">
                            <label for="curp_padre-field">CURP</label>
                            {!! Form::text("curp_padre", null, array("class" => "form-control input-sm", "id" => "curp_padre-field")) !!}
                            @if($errors->has("curp_padre"))
                            <span class="help-block">{{ $errors->first("curp_padre") }}</span>
                            @endif
                        </div>
                        <div class="form-group col-md-4 @if($errors->has('dir_padre')) has-error @endif">
                            <label for="dir_padre-field">Dirección</label>
                            {!! Form::text("dir_padre", null, array("class" => "form-control input-sm", "id" => "dir_padre-field")) !!}
                            @if($errors->has("dir_padre"))
                            <span class="help-block">{{ $errors->first("dir_padre") }}</span>
                            @endif
                        </div>
                        <div class="form-group col-md-4 @if($errors->has('tel_padre')) has-error @endif">
                            <label for="tel_padre-field">Teléfono Fijo</label>
                            {!! Form::text("tel_padre", null, array("class" => "form-control input-sm", "id" => "tel_padre-field")) !!}
                            @if($errors->has("tel_padre"))
                            <span class="help-block">{{ $errors->first("tel_padre") }}</span>
                            @endif
                        </div>
                        <div class="form-group col-md-4 @if($errors->has('cel_padre')) has-error @endif">
                            <label for="cel_padre-field">Teléfono Celular</label>
                            {!! Form::text("cel_padre", null, array("class" => "form-control input-sm", "id" => "cel_padre-field")) !!}
                            @if($errors->has("cel_padre"))
                            <span class="help-block">{{ $errors->first("cel_padre") }}</span>
                            @endif
                        </div>
                        <div class="form-group col-md-4 @if($errors->has('tel_ofi_padre')) has-error @endif">
                            <label for="tel_ofi_padre-field">Teléfono Trabajo</label>
                            {!! Form::text("tel_ofi_padre", null, array("class" => "form-control input-sm", "id" => "tel_ofi_padre-field")) !!}
                            @if($errors->has("tel_ofi_padre"))
                            <span class="help-block">{{ $errors->first("tel_ofi_padre") }}</span>
                            @endif
                        </div>
                        <div class="form-group col-md-4 @if($errors->has('mail_padre')) has-error @endif">
                            <label for="mail_padre-field">Correo Electrónico</label>
                            {!! Form::text("mail_padre", null, array("class" => "form-control input-sm", "id" => "mail_padre-field")) !!}
                            @if($errors->has("mail_padre"))
                            <span class="help-block">{{ $errors->first("mail_padre") }}</span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="box box-default box-solid">
                    <div class="box-header">
                        <h3 class="box-title">MADRE</h3>
                        <div class="box-tools">

                            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="form-group col-md-4 @if($errors->has('nombre_madre')) has-error @endif">
                            <label for="nombre_madre-field">Nombre Completo </label>
                            {!! Form::text("nombre_madre", null, array("class" => "form-control input-sm", "id" => "nombre_madre-field")) !!}
                            @if($errors->has("nombre_madre"))
                            <span class="help-block">{{ $errors->first("nombre_madre") }}</span>
                            @endif
                        </div>
                        <div class="form-group col-md-4 @if($errors->has('curp_madre')) has-error @endif">
                            <label for="curp_madre-field">CURP</label>
                            {!! Form::text("curp_madre", null, array("class" => "form-control input-sm", "id" => "curp_madre-field")) !!}
                            @if($errors->has("curp_madre"))
                            <span class="help-block">{{ $errors->first("curp_madre") }}</span>
                            @endif
                        </div>
                        <div class="form-group col-md-4 @if($errors->has('dir_madre')) has-error @endif">
                            <label for="dir_madre-field">Dirección</label>
                            {!! Form::text("dir_madre", null, array("class" => "form-control input-sm", "id" => "dir_madre-field")) !!}
                            @if($errors->has("dir_madre"))
                            <span class="help-block">{{ $errors->first("dir_madre") }}</span>
                            @endif
                        </div>
                        <div class="form-group col-md-4 @if($errors->has('tel_madre')) has-error @endif">
                            <label for="tel_madre-field">Teléfono Fijo</label>
                            {!! Form::text("tel_madre", null, array("class" => "form-control input-sm", "id" => "tel_madre-field")) !!}
                            @if($errors->has("tel_madre"))
                            <span class="help-block">{{ $errors->first("tel_madre") }}</span>
                            @endif
                        </div>
                        <div class="form-group col-md-4 @if($errors->has('cel_madre')) has-error @endif">
                            <label for="cel_madre-field">Teléfono Celular</label>
                            {!! Form::text("cel_madre", null, array("class" => "form-control input-sm", "id" => "cel_madre-field")) !!}
                            @if($errors->has("cel_madre"))
                            <span class="help-block">{{ $errors->first("cel_madre") }}</span>
                            @endif
                        </div>
                        <div class="form-group col-md-4 @if($errors->has('tel_ofi_madre')) has-error @endif">
                            <label for="tel_ofi_madre-field">Teléfono Trabajo</label>
                            {!! Form::text("tel_ofi_madre", null, array("class" => "form-control input-sm", "id" => "tel_ofi_madre-field")) !!}
                            @if($errors->has("tel_ofi_madre"))
                            <span class="help-block">{{ $errors->first("tel_ofi_madre") }}</span>
                            @endif
                        </div>
                        <div class="form-group col-md-4 @if($errors->has('mail_madre')) has-error @endif">
                            <label for="mail_madre-field">Correo Electrónico</label>
                            {!! Form::text("mail_madre", null, array("class" => "form-control input-sm", "id" => "mail_madre-field")) !!}
                            @if($errors->has("mail_madre"))
                            <span class="help-block">{{ $errors->first("mail_madre") }}</span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="box box-default box-solid">
                    <div class="box-header">
                        <h3 class="box-title">ACUDIENTE</h3>
                        <div class="box-tools">

                            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="form-group col-md-4 @if($errors->has('nombre_acudiente')) has-error @endif">
                            <label for="nombre_acudiente-field">Nombre Completo</label>
                            {!! Form::text("nombre_acudiente", null, array("class" => "form-control input-sm", "id" => "nombre_acudiente-field")) !!}
                            @if($errors->has("nombre_acudiente"))
                            <span class="help-block">{{ $errors->first("nombre_acudiente") }}</span>
                            @endif
                        </div>
                        <div class="form-group col-md-4 @if($errors->has('curp_acudiente')) has-error @endif">
                            <label for="curp_acudiente-field">CURP</label>
                            {!! Form::text("curp_acudiente", null, array("class" => "form-control input-sm", "id" => "curp_acudiente-field")) !!}
                            @if($errors->has("curp_acudiente"))
                            <span class="help-block">{{ $errors->first("curp_acudiente") }}</span>
                            @endif
                        </div>
                        <div class="form-group col-md-4 @if($errors->has('dir_acudiente')) has-error @endif">
                            <label for="dir_acudiente-field">Dirrección</label>
                            {!! Form::text("dir_acudiente", null, array("class" => "form-control input-sm", "id" => "dir_acudiente-field")) !!}
                            @if($errors->has("dir_acudiente"))
                            <span class="help-block">{{ $errors->first("dir_acudiente") }}</span>
                            @endif
                        </div>
                        <div class="form-group col-md-4 @if($errors->has('tel_acudiente')) has-error @endif">
                            <label for="tel_acudiente-field">Teléfono Fijo</label>
                            {!! Form::text("tel_acudiente", null, array("class" => "form-control input-sm", "id" => "tel_acudiente-field")) !!}
                            @if($errors->has("tel_acudiente"))
                            <span class="help-block">{{ $errors->first("tel_acudiente") }}</span>
                            @endif
                        </div>
                        <div class="form-group col-md-4 @if($errors->has('cel_acudiente')) has-error @endif">
                            <label for="cel_acudiente-field">Teléfono Celular</label>
                            {!! Form::text("cel_acudiente", null, array("class" => "form-control input-sm", "id" => "cel_acudiente-field")) !!}
                            @if($errors->has("cel_acudiente"))
                            <span class="help-block">{{ $errors->first("cel_acudiente") }}</span>
                            @endif
                        </div>
                        <div class="form-group col-md-4 @if($errors->has('tel_ofi_acudiente')) has-error @endif">
                            <label for="tel_ofi_acudiente-field">Teléfono Trabajo</label>
                            {!! Form::text("tel_ofi_acudiente", null, array("class" => "form-control input-sm", "id" => "tel_ofi_acudiente-field")) !!}
                            @if($errors->has("tel_ofi_acudiente"))
                            <span class="help-block">{{ $errors->first("tel_ofi_acudiente") }}</span>
                            @endif
                        </div>
                        <div class="form-group col-md-4 @if($errors->has('mail_acudiente')) has-error @endif">
                            <label for="mail_acudiente-field">Correo Electrónico</label>
                            {!! Form::text("mail_acudiente", null, array("class" => "form-control input-sm", "id" => "mail_acudiente-field")) !!}
                            @if($errors->has("mail_acudiente"))
                            <span class="help-block">{{ $errors->first("mail_acudiente") }}</span>
                            @endif
                        </div>

                    </div>
                </div>
            </fieldset>
        </div>
        <div id="tab5" class="tab-pane">
            @if(isset($cliente->inscripciones))
            @foreach($cliente->inscripciones as $i)
            <table class="table table-condensed table-striped">
                <thead style="color: #ffffff;background: #0B0B3B;">
                <td>Plantel</td><td>Especialidad</td><td>Nivel</td>
                <td>Grado</td><td>Grupo</td><td>Periodo</td><td>F. Inscripcion</td>
                <td>Periodo Lectivo</td><td></td>
                </thead>
                <tbody>

                    <tr style="color: #ffffff;background:#6495ED;">
                        <td>{{$i->plantel->razon}}</td>
                        <td>{{$i->especialidad->name}}</td>
                        <td>{{$i->nivel->name}}</td>
                        <td>{{$i->grado->name}}</td>
                        <td>{{$i->grupo->name}}</td>
                        <td>{{$i->periodo_estudio->name}}</td>
                        <td>{{$i->fec_inscripcion}}</td>
                        <td>{{$i->lectivo->name}}</td>
                        <td>
                            @permission('inscripcions.edit')
                            <a class="btn btn-xs btn-primary" href="#" onclick="EditarInscripcion({{ $i->id }})"><i class="glyphicon glyphicon-edit"></i>Editar</a>
                            @endpermission
                            @permission('inscripcions.registrarMaterias')
                            <a class="btn btn-xs btn-warning" href="{{ route('inscripcions.registrarMaterias', $i->id) }}"><i class="glyphicon glyphicon-edit"></i>Registrar Materias</a>
                            @endpermission
                            @permission('inscripcions.destroy')
                            <a class="btn btn-xs btn-danger" href="{{ route('inscripcions.destroyCli', $i->id) }}"><i class="glyphicon glyphicon-trash"></i>Borrar</a>
                            @endpermission
                        </td>
                    </tr>
                    <tr>
                <table class="table table-condensed table-striped">
                    <thead style="color: #ffffff;background: #27ae60;">
                    <td>Materia</td><td>Estatus</td><td></td><td></td>
                    </thead>
                    <tbody>
                        @foreach($i->hacademicas as $a)
                        <tr>
                            <td>{{$a->materia->name}}</td><td>{{$a->stMateria->name}}</td>
                            <td>
                                <a href="{{ route('hacademicas.destroy', $a->id) }}" class="btn btn-xs btn-danger" ><i class="glyphicon glyphicon-trash"></i> Eliminar</a>
                            </td>
                            <td colspan="2">
                                <table class="table table-condensed table-striped">
                                    <thead>
                                    <td>Examen</td><td>Calificación</td>
                                    </thead>
                                    <tbody>
                                        @foreach($a->calificaciones as $cali)
                                        <tr>
                                            <td>
                                                {{$cali->tpoExamen->name}}
                                            </td>
                                            <td>
                                                {{$cali->calificacion}}
                                            </td>
                                        <tr>
                                            @endforeach
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    </tbody>
                    </tr>

                    </tbody>
                </table>
                @endforeach
                @endif
        </div>
        <div id="tab6" class="tab-pane">
            @if(isset($cliente))
            <div class="box box-default">
                <div class="box-body">
                    <div class="form-group col-md-6 @if($errors->has('doc_cliente_id')) has-error @endif">
                        <label for="doc_cliente_id-field">Documento</label>
                        {!! Form::select("doc_cliente_id", $list1["DocAlumno"], null, array("class" => "form-control select_seguridad", "id" => "doc_cliente_id-field", 'style'=>'width:100%')) !!}
                        @if($errors->has("doc_cliente_id"))
                        <span class="help-block">{{ $errors->first("doc_cliente_id") }}</span>
                        @endif
                    </div>
                    <div class="form-group col-md-6 @if($errors->has('archivo')) has-error @endif">
                        <button type="button" onclick="BrowseServer('archivo-field');">Elegir Archivo</button>
                        {!! Form::text("archivo", null, array("class" => "form-control input-sm", "id" => "archivo-field")) !!}
                        @if($errors->has("archivo"))
                        <span class="help-block">{{ $errors->first("archivo") }}</span>
                        @endif
                    </div>
                    <div class="form-group col-md-6">
                        <table class="table table-condensed table-striped">
                            <thead>
                                <tr>
                                    <th>Documento Agregados</th><th>Link</th><th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($cliente->pivotDocCliente as $doc)
                                <tr>
                                    <td>
                                        {{$doc->docAlumno->name}}
                                    </td>
                                    <td>
                                        <a href="{{$doc->archivo}}" target="_blank">Ver</a>
                                    </td>
                                    <td>
                                        <a class="btn btn-xs btn-danger" href="{{route('pivotDocClientes.destroy', $doc->id)}}">Eliminar</a>
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
                                    <th>Documentos Faltantes</th><th>Obligatorio</th>
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
            </div>
            @endif
        </div>    
    </div>
</div>    

@push('scripts')
<script src="{{ asset ('/bower_components/AdminLTE/plugins/input-mask/jquery.inputmask.js') }}"></script>
<script src="{{ asset ('/bower_components/AdminLTE/plugins/input-mask/jquery.inputmask.extensions.js') }}"></script>
<script src="{{ asset ('/bower_components/AdminLTE/plugins/input-mask/jquery.inputmask.phone.extensions.js') }}"></script>
<script type="text/javascript">
                        $(document).ready(function() {
<?php
$r = DB::table('params')->where('llave', 'st_cliente_final')->first();
?>
                        $("#st_cliente_id-field option[value*={{ $r->valor }}]").prop('readonly', true);
                        collapseTable();
                        $('.header').click(function(){
                        collapseTable();
                        });
                        function collapseTable(){
                        $('.header').find('span').text(function(_, value){return value == '-'?'+':'-'});
                        $('.header').nextUntil('tr.header').slideToggle(100); // or just use "toggle()"
                        }

                        $('#tel_cel-field').inputmask({"mask": "(999) 999-9999"}); //specifying options
                        $('#tel_fijo-field').inputmask({"mask": "(999) 999-9999"}); //specifying options
                        $('#expo-group').hide();
                        $('#otro_medio-group').hide();
                        ocultaExpo();
                        $("#btn_sms").click(function(event) {
                        enviaSms();
                        });
                        $("#btn_mail").click(function(event) {
                        enviaMail();
                        });
                        //coloca la fecha del dia si esta vacio el campo
                        if ($.trim($("#fec_registro-field").val()) == ''){
                        var fullDate = new Date()
                                //Thu May 19 2011 17:25:38 GMT+1000 {}
                                //convert month to 2 digits
                                var twoDigitMonth = ((fullDate.getMonth().length + 1) === 1)? (fullDate.getMonth() + 1) : '0' + (fullDate.getMonth() + 1);
                        var currentDate = fullDate.getFullYear() + "-" + twoDigitMonth + "-" + fullDate.getDate();
                        //alert(currentDate);

                        $("#fec_registro-field").val(currentDate);
                        }
                        // assuming the controls you want to attach the plugin to
                        // have the "datepicker" class set
                        //Campo de fecha
                        $('#fec_registro-field').Zebra_DatePicker({
                        days:['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'],
                                months:['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
                                readonly_element: false,
                                lang_clear_date: 'Limpiar',
                                show_select_today: 'Hoy',
                        });
                        //Ocultar expo y otro
                        $('#medio_id-field').change(function(){
                        ocultaExpo();
                        });
                        function ocultaExpo(){
                        if ($('#medio_id-field option:selected').val() == 1){
                        $('#expo-group').show();
                        $('#otro_medio-group').hide();
                        } else if ($('#medio_id-field option:selected').val() == 6){
                        $('#otro_medio-group').show();
                        $('#expo-group').hide()
                        } else{
                        $('#otro_medio-group').hide();
                        $('#expo-group').hide()
                        }
                        }

                        function enviaSms(){
                        var a = $('#frm_cliente').serialize();
                        $.ajax({
                        url: '{{ route("clientes.enviaSms") }}',
                                type: 'POST',
                                data: a,
                                dataType: 'json',
                                beforeSend : function(){$("#loading1").show(); },
                                complete : function(){$("#loading1").hide(); },
                                default: function(parametros){
                                if (parametros == true){
                                $('#msj').html('Sms enviado');
                                } else{
                                $('#msj').html('Envio de sms fallo');
                                }
                                }
                        });
                        }
                        function enviaMail(){
                        var a = $('#frm_cliente').serialize();
                        $.ajax({
                        url: '{{ route("clientes.enviaMail") }}',
                                type: 'POST',
                                data: a,
                                dataType: 'json',
                                beforeSend : function(){$("#loading2").show(); },
                                complete : function(){$("#loading2").hide(); },
                                success: function(parametros){
                                if (parametros == true){
                                $('#msj').html('Email enviado');
                                } else{
                                $('#msj').html('Envio de email fallo');
                                }
                                },
                                error: function(e){
                                $('#msj').html(e);
                                }
                        });
                        }

                        //Asigna el plantel segun el empleado
                        $('#empleado_id-field').change(function(){
                        $("#loading3").show();
                        $.get("{{ url('getPlantel')}}",
                        { empleado: $(this).val() },
                                function(data) {
                                $('#plantel_id-field').val(data).change();
                                $("#loading3").hide();
                                }
                        );
                        });
                        /*$('#plantel_id-field').change(function(){
                         getCmbEmpleados();
                         });
                         */
                        /*function getCmbEmpleados(){
                         //$('#empleado_id_field option:selected').val($('#empleado_id_campo option:selected').val()).change();
                         var a= $('#frm_cliente').serialize();
                         $.ajax({
                         url: '{{ route("empleados.getEmpleadosXplantel") }}',
                         type: 'GET',
                         data: a,
                         dataType: 'json',
                         beforeSend : function(){$("#loading3").show();},
                         complete : function(){$("#loading3").hide();},
                         success: function(data){
                         //$example.select2("destroy");
                         //alert($('#plantel_id-field option:selected').val());
                         $('#empleado_id-field').html('');
                         //$('#especialidad_id-field').empty();
                         $('#empleado_id-field').append($('<option></option>').text('Seleccionar Opción').val('0'));
                         
                         //alert($('#plantel_id2-field option:selected').val());
                         $.each(data, function(i) {
                         //alert(data[i].name);
                         $('#empleado_id-field').append("<option "+data[i].selectec+" value=\""+data[i].id+"\">"+data[i].nombre+"<\/option>");
                         
                         });
                         //$('#empleado_id-field').change();
                         //$example.select2();
                         }
                         });       
                         }
                         */


                        /*
                         $.ajax({
                         url: '{{ url('getPlantel')}}',
                         type: 'GET',
                         data: (empleado=$('#empleado_id-field').val),
                         beforeSend : function(){$("#loading3").show();},
                         complete : function(){$("#loading3").hide();},
                         success: function(data){
                         $('#plantel_id-field').val(data).change();
                         }
                         });*/

                        //trabaja el campo plantel 
                        @permission('Icliente.modificarPlantel')
                                $('#plantel_id-field').prop('disabled', true);
                        @endpermission
                                $("#frm_cliente").submit(function() {
                        $('#plantel_id-field').prop('disabled', false);
                        return true;
                        });
                        //Campo combos dependientes
                        $('#estado_id-field').change(function(){
                        $.get("{{ url('getCmbMunicipios')}}",
                        { estado: $(this).val() },
                                function(data) {
                                $('#municipio_id-field').empty();
                                $.each(data, function(key, element) {
                                $('#municipio_id-field').append("<option value='" + key + "'>" + element + "</option>");
                                });
                                });
                        });
                        /*
                         //Campo combos dependientes
                         $('#nivel_id-field').change(function(){
                         $("#loading4").show();
                         $.get("{{ url('getCmbGrados')}}",
                         { nivel: $(this).val() },
                         function(data) {
                         $('#grado_id-field').empty();
                         $.each(data, function(key, element) {
                         $('#grado_id-field').append("<option value='" + key + "'>" + element + "</option>");
                         });
                         $("#loading4").hide();
                         });
                         }); 
                         
                         //Campo combos dependientes
                         $('#curso_id-field').change(function(){
                         $("#loading5").show();
                         $.get("{{ url('getCmbSubcursos')}}",
                         { curso: $(this).val() },
                         function(data) {
                         $('#subcurso_id-field').empty();
                         $.each(data, function(key, element) {
                         $('#subcurso_id-field').append("<option value='" + key + "'>" + element + "</option>");
                         });
                         $("#loading5").hide();
                         });
                         }); 
                         
                         //Campo combos dependientes
                         $('#diplomado_id-field').change(function(){
                         $("#loading6").show();
                         $.get("{{ url('getCmbSubdiplomados')}}",
                         { diplomado: $(this).val() },
                         function(data) {
                         $('#subdiplomado_id-field').empty();
                         $.each(data, function(key, element) {
                         $('#subdiplomado_id-field').append("<option value='" + key + "'>" + element + "</option>");
                         });
                         $("#loading6").hide();
                         });
                         }); 
                         
                         //Campo combos dependientes
                         $('#otro_id-field').change(function(){
                         $("#loading7").show();
                         $.get("{{ url('getCmbSubotros')}}",
                         { otro: $(this).val() },
                         function(data) {
                         $('#subotro_id-field').empty();
                         $.each(data, function(key, element) {
                         $('#subotro_id-field').append("<option value='" + key + "'>" + element + "</option>");
                         });
                         $("#loading7").hide();
                         });
                         });    
                         */
                        //combos dependientes
                        getCmbEspecialidad();
                        getCmbEspecialidad2();
                        /*getCmbEspecialidad3();
                         getCmbEspecialidad4();
                         */
                        getCmbNivel();
                        /*getCmbNivel2();
                         getCmbNivel3();
                         getCmbNivel4();
                         */getCmbGrado();
                        /*getCmbGrado2();
                         getCmbGrado3();
                         getCmbGrado4();
                         */getCmbTurno();
                        /*getCmbTurno2();
                         getCmbTurno3();
                         getCmbTurno4();
                         */$('#plantel_id-field').change(function(){
                        getCmbEspecialidad();
                        /*getCmbEspecialidad2();
                         getCmbEspecialidad3();
                         getCmbEspecialidad4();
                         */});
                        $('#especialidad_id-field').change(function(){
                        getCmbNivel();
                        });
                        /*$('#especialidad2_id-field').change(function(){
                         getCmbNivel2();
                         });
                         $('#especialidad3_id-field').change(function(){
                         getCmbNivel3();
                         });
                         $('#especialidad4_id-field').change(function(){
                         getCmbNivel4();
                         });
                         */$('#nivel_id-field').change(function(){
                        getCmbGrado();
                        });
                        /*$('#curso_id-field').change(function(){
                         getCmbGrado2();
                         });
                         $('#diplomado_id-field').change(function(){
                         getCmbGrado3();
                         });
                         $('#otro_id-field').change(function(){
                         getCmbGrado4();
                         });
                         */$('#grado_id-field').change(function(){
                        getCmbTurno();
                        });
                        /*$('#subcurso_id-field').change(function(){
                         getCmbTurno2();
                         });
                         $('#subdiplomado_id-field').change(function(){
                         getCmbTurno3();
                         });
                         $('#subotro_id-field').change(function(){
                         getCmbTurno4();
                         });
                         *///fin combos dependientes

                        //
                        $(function() {
                        $("#expo-field").autocomplete({
                        source: "{!! route('clientes.autocomplete') !!}",
                                minLength: 2,
                                autofocus:true,
                                select: function(event, ui) {
                                $('#expo-field').val(ui.item.label);
                                }
                        });
                        });
                        });
                        function getCmbEspecialidad(){
                        //var $example = $("#especialidad_id-field").select2();
                        var a = $('#frm_cliente').serialize();
                        $.ajax({
                        url: '{{ route("especialidads.getCmbEspecialidad") }}',
                                type: 'GET',
                                data: "plantel_id=" + $('#plantel_id-field option:selected').val() + "&especialidad_id=" + $('#especialidad_id-field option:selected').val() + "",
                                dataType: 'json',
                                beforeSend : function(){$("#loading10").show(); },
                                complete : function(){$("#loading10").hide(); },
                                success: function(data){
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

                        @if(isset($cliente))
                        function CrearCombinacionCliente() {
                        $.ajax({
                        url: '{{ route("combinacionClientes.store") }}',
                                type: 'GET',
                                data: "cliente_id={{$cliente->id}}&plantel_id=" + $('#plantel_id-field option:selected').val() + "&especialidad_id=" + $('#especialidad_id-field option:selected').val() + "&nivel_id=" + $('#nivel_id-field option:selected').val() + "&grado_id=" + $('#grado_id-field option:selected').val() + "&turno_id=" + $('#turno_id-field option:selected').val() + "",
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

                        function getCmbEspecialidad2(){
                        //var $example = $("#especialidad_id-field").select2();
                        var a = $('#frm_cliente').serialize();
                        $.ajax({
                        url: '{{ route("especialidads.getCmbEspecialidad") }}',
                                type: 'GET',
                                data: "plantel_id=" + $('#plantel_id-field option:selected').val() + "&especialidad_id=" + $('#especialidad2_id-field option:selected').val() + "",
                                dataType: 'json',
                                beforeSend : function(){$("#loading10").show(); },
                                complete : function(){$("#loading10").hide(); },
                                success: function(data){
                                $('#especialidad2_id-field').empty();
                                $('#especialidad2_id-field').append($('<option></option>').text('Seleccionar').val('0'));
                                $.each(data, function(i) {
                                //alert(data[i].name);
                                $('#especialidad2_id-field').append("<option " + data[i].selectec + " value=\"" + data[i].id + "\">" + data[i].name + "<\/option>");
                                });
                                //$example.select2();
                                }
                        });
                        }
                        function getCmbEspecialidad3(){
                        //var $example = $("#especialidad_id-field").select2();
                        var a = $('#frm_cliente').serialize();
                        $.ajax({
                        url: '{{ route("especialidads.getCmbEspecialidad") }}',
                                type: 'GET',
                                data: "plantel_id=" + $('#plantel_id-field option:selected').val() + "&especialidad_id=" + $('#especialidad3_id-field option:selected').val() + "",
                                dataType: 'json',
                                beforeSend : function(){$("#loading10").show(); },
                                complete : function(){$("#loading10").hide(); },
                                success: function(data){
                                $('#especialidad3_id-field').empty();
                                $('#especialidad3_id-field').append($('<option></option>').text('Seleccionar').val('0'));
                                $.each(data, function(i) {
                                //alert(data[i].name);
                                $('#especialidad3_id-field').append("<option " + data[i].selectec + " value=\"" + data[i].id + "\">" + data[i].name + "<\/option>");
                                });
                                //$example.select2();
                                }
                        });
                        }
                        function getCmbEspecialidad4(){
                        //var $example = $("#especialidad_id-field").select2();
                        var a = $('#frm_cliente').serialize();
                        $.ajax({
                        url: '{{ route("especialidads.getCmbEspecialidad") }}',
                                type: 'GET',
                                data: "plantel_id=" + $('#plantel_id-field option:selected').val() + "&especialidad_id=" + $('#especialidad4_id-field option:selected').val() + "",
                                dataType: 'json',
                                beforeSend : function(){$("#loading10").show(); },
                                complete : function(){$("#loading10").hide(); },
                                success: function(data){
                                $('#especialidad4_id-field').empty();
                                $('#especialidad4_id-field').append($('<option></option>').text('Seleccionar').val('0'));
                                $.each(data, function(i) {
                                //alert(data[i].name);
                                $('#especialidad4_id-field').append("<option " + data[i].selectec + " value=\"" + data[i].id + "\">" + data[i].name + "<\/option>");
                                });
                                //$example.select2();
                                }
                        });
                        }
                        function getCmbNivel(){
                        //var $example = $("#especialidad_id-field").select2();
                        //alert($('#especialidad_id-field option:selected').val());
                        var a = $('#frm_cliente').serialize();
                        $.ajax({
                        url: '{{ route("nivels.getCmbNivels") }}',
                                type: 'GET',
                                data: "plantel_id=" + $('#plantel_id-field option:selected').val() + "&especialidad_id=" + $('#especialidad_id-field option:selected').val() + "&nivel_id=" + $('#nivel_id-field option:selected').val() + "",
                                dataType: 'json',
                                beforeSend : function(){$("#loading11").show(); },
                                complete : function(){$("#loading11").hide(); },
                                success: function(data){
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
                        function getCmbNivel2(){
                        //var $example = $("#especialidad_id-field").select2();
                        var a = $('#frm_cliente').serialize();
                        $.ajax({
                        url: '{{ route("nivels.getCmbNivels") }}',
                                type: 'GET',
                                data: "plantel_id=" + $('#plantel_id-field option:selected').val() + "&especialidad_id=" + $('#especialidad2_id-field option:selected').val() + "&nivel_id=" + $('#curso_id-field option:selected').val() + "",
                                dataType: 'json',
                                beforeSend : function(){$("#loading11").show(); },
                                complete : function(){$("#loading11").hide(); },
                                success: function(data){
                                //alert(data);
                                //$example.select2("destroy");
                                $('#curso_id-field').html('');
                                //$('#especialidad_id-field').empty();
                                $('#curso_id-field').append($('<option></option>').text('Seleccionar').val('0'));
                                $.each(data, function(i) {
                                //alert(data[i].name);
                                $('#curso_id-field').append("<option " + data[i].selectec + " value=\"" + data[i].id + "\">" + data[i].name + "<\/option>");
                                });
                                //$example.select2();
                                }
                        });
                        }
                        function getCmbNivel3(){
                        //var $example = $("#especialidad_id-field").select2();
                        var a = $('#frm_cliente').serialize();
                        $.ajax({
                        url: '{{ route("nivels.getCmbNivels") }}',
                                type: 'GET',
                                data: "plantel_id=" + $('#plantel_id-field option:selected').val() + "&especialidad_id=" + $('#especialidad3_id-field option:selected').val() + "&nivel_id=" + $('#diplomado_id-field option:selected').val() + "",
                                dataType: 'json',
                                beforeSend : function(){$("#loading11").show(); },
                                complete : function(){$("#loading11").hide(); },
                                success: function(data){
                                //alert(data);
                                //$example.select2("destroy");
                                $('#diplomado_id-field').html('');
                                //$('#especialidad_id-field').empty();
                                $('#diplomado_id-field').append($('<option></option>').text('Seleccionar').val('0'));
                                $.each(data, function(i) {
                                //alert(data[i].name);
                                $('#diplomado_id-field').append("<option " + data[i].selectec + " value=\"" + data[i].id + "\">" + data[i].name + "<\/option>");
                                });
                                //$example.select2();
                                }
                        });
                        }
                        function getCmbNivel4(){
                        //var $example = $("#especialidad_id-field").select2();
                        var a = $('#frm_cliente').serialize();
                        $.ajax({
                        url: '{{ route("nivels.getCmbNivels") }}',
                                type: 'GET',
                                data: "plantel_id=" + $('#plantel_id-field option:selected').val() + "&especialidad_id=" + $('#especialidad4_id-field option:selected').val() + "&nivel_id=" + $('#otro_id-field option:selected').val() + "",
                                dataType: 'json',
                                beforeSend : function(){$("#loading11").show(); },
                                complete : function(){$("#loading11").hide(); },
                                success: function(data){
                                //alert(data);
                                //$example.select2("destroy");
                                $('#otro_id-field').html('');
                                //$('#especialidad_id-field').empty();
                                $('#otro_id-field').append($('<option></option>').text('Seleccionar').val('0'));
                                $.each(data, function(i) {
                                //alert(data[i].name);
                                $('#otro_id-field').append("<option " + data[i].selectec + " value=\"" + data[i].id + "\">" + data[i].name + "<\/option>");
                                });
                                //$example.select2();
                                }
                        });
                        }
                        function getCmbGrado(){
                        //var $example = $("#especialidad_id-field").select2();
                        var a = $('#frm_cliente').serialize();
                        $.ajax({
                        url: '{{ route("grados.getCmbGrados") }}',
                                type: 'GET',
                                data: "plantel_id=" + $('#plantel_id-field option:selected').val() + "&especialidad_id=" + $('#especialidad_id-field option:selected').val() + "&nivel_id=" + $('#nivel_id-field option:selected').val() + "&grado_id=" + $('#grado_id-field option:selected').val() + "",
                                dataType: 'json',
                                beforeSend : function(){$("#loading12").show(); },
                                complete : function(){$("#loading12").hide(); },
                                success: function(data){
                                //alert(data);
                                //$example.select2("destroy");
                                $('#grado_id-field').html('');
                                //$('#especialidad_id-field').empty();
                                $('#grado_id-field').append($('<option></option>').text('Seleccionar').val('0'));
                                $.each(data, function(i) {
                                //alert(data[i].name);
                                $('#grado_id-field').append("<option " + data[i].selectec + " value=\"" + data[i].id + "\">" + data[i].name + "<\/option>");
                                });
                                //$example.select2();
                                }
                        });
                        }
                        function getCmbGrado2(){
                        //var $example = $("#especialidad_id-field").select2();
                        var a = $('#frm_cliente').serialize();
                        $.ajax({
                        url: '{{ route("grados.getCmbGrados") }}',
                                type: 'GET',
                                data: "plantel_id=" + $('#plantel_id-field option:selected').val() + "&especialidad_id=" + $('#especialidad2_id-field option:selected').val() + "&nivel_id=" + $('#curso_id-field option:selected').val() + "&grado_id=" + $('#subcurso_id-field option:selected').val() + "",
                                dataType: 'json',
                                beforeSend : function(){$("#loading12").show(); },
                                complete : function(){$("#loading12").hide(); },
                                success: function(data){
                                //alert(data);
                                //$example.select2("destroy");
                                $('#subcurso_id-field').html('');
                                //$('#especialidad_id-field').empty();
                                $('#subcurso_id-field').append($('<option></option>').text('Seleccionar').val('0'));
                                $.each(data, function(i) {
                                //alert(data[i].name);
                                $('#subcurso_id-field').append("<option " + data[i].selectec + " value=\"" + data[i].id + "\">" + data[i].name + "<\/option>");
                                });
                                //$example.select2();
                                }
                        });
                        }
                        function getCmbGrado3(){
                        //var $example = $("#especialidad_id-field").select2();
                        var a = $('#frm_cliente').serialize();
                        $.ajax({
                        url: '{{ route("grados.getCmbGrados") }}',
                                type: 'GET',
                                data: "plantel_id=" + $('#plantel_id-field option:selected').val() + "&especialidad_id=" + $('#especialidad3_id-field option:selected').val() + "&nivel_id=" + $('#diplomado_id-field option:selected').val() + "&grado_id=" + $('#subdiplomado_id-field option:selected').val() + "",
                                dataType: 'json',
                                beforeSend : function(){$("#loading12").show(); },
                                complete : function(){$("#loading12").hide(); },
                                success: function(data){
                                //alert(data);
                                //$example.select2("destroy");
                                $('#subdiplomado_id-field').html('');
                                //$('#especialidad_id-field').empty();
                                $('#subdiplomado_id-field').append($('<option></option>').text('Seleccionar').val('0'));
                                $.each(data, function(i) {
                                //alert(data[i].name);
                                $('#subdiplomado_id-field').append("<option " + data[i].selectec + " value=\"" + data[i].id + "\">" + data[i].name + "<\/option>");
                                });
                                //$example.select2();
                                }
                        });
                        }
                        function getCmbGrado4(){
                        //var $example = $("#especialidad_id-field").select2();
                        var a = $('#frm_cliente').serialize();
                        $.ajax({
                        url: '{{ route("grados.getCmbGrados") }}',
                                type: 'GET',
                                data: "plantel_id=" + $('#plantel_id-field option:selected').val() + "&especialidad_id=" + $('#especialidad4_id-field option:selected').val() + "&nivel_id=" + $('#otro_id-field option:selected').val() + "&grado_id=" + $('#subotro_id-field option:selected').val() + "",
                                dataType: 'json',
                                beforeSend : function(){$("#loading12").show(); },
                                complete : function(){$("#loading12").hide(); },
                                success: function(data){
                                //alert(data);
                                //$example.select2("destroy");
                                $('#subotro_id-field').html('');
                                //$('#especialidad_id-field').empty();
                                $('#subotro_id-field').append($('<option></option>').text('Seleccionar').val('0'));
                                $.each(data, function(i) {
                                //alert(data[i].name);
                                $('#subotro_id-field').append("<option " + data[i].selectec + " value=\"" + data[i].id + "\">" + data[i].name + "<\/option>");
                                });
                                //$example.select2();
                                }
                        });
                        }
                        function getCmbTurno(){
                        //var $example = $("#especialidad_id-field").select2();
                        var a = $('#frm_cliente').serialize();
                        $.ajax({
                        url: '{{ route("turnos.getCmbTurno") }}',
                                type: 'GET',
                                data: "plantel_id=" + $('#plantel_id-field option:selected').val() + "&especialidad_id=" + $('#especialidad_id-field option:selected').val() + "&nivel_id=" + $('#nivel_id-field option:selected').val() + "&grado_id=" + $('#grado_id-field option:selected').val() + "&turno_id=" + $('#turno_id-field option:selected').val() + "",
                                dataType: 'json',
                                beforeSend : function(){$("#loading12").show(); },
                                complete : function(){$("#loading12").hide(); },
                                success: function(data){
                                //alert(data);
                                //$example.select2("destroy");
                                $('#turno_id-field').html('');
                                //$('#especialidad_id-field').empty();
                                $('#turno_id-field').append($('<option></option>').text('Seleccionar').val('0'));
                                $.each(data, function(i) {
                                //alert(data[i].name);
                                $('#turno_id-field').append("<option " + data[i].selectec + " value=\"" + data[i].id + "\">" + data[i].name + "<\/option>");
                                });
                                //$example.select2();
                                }
                        });
                        }
                        function getCmbTurno2(){
                        //var $example = $("#especialidad_id-field").select2();
                        var a = $('#frm_cliente').serialize();
                        $.ajax({
                        url: '{{ route("turnos.getCmbTurno") }}',
                                type: 'GET',
                                data: "plantel_id=" + $('#plantel_id-field option:selected').val() + "&especialidad_id=" + $('#especialidad_id-field option:selected').val() + "&nivel_id=" + $('#nivel_id-field option:selected').val() + "&grado_id=" + $('#subcurso_id-field option:selected').val() + "&turno_id=" + $('#turno2_id-field option:selected').val() + "",
                                dataType: 'json',
                                beforeSend : function(){$("#loading12").show(); },
                                complete : function(){$("#loading12").hide(); },
                                success: function(data){
                                //alert(data);
                                //$example.select2("destroy");
                                $('#turno2_id-field').html('');
                                //$('#especialidad_id-field').empty();
                                $('#turno2_id-field').append($('<option></option>').text('Seleccionar').val('0'));
                                $.each(data, function(i) {
                                //alert(data[i].name);
                                $('#turno2_id-field').append("<option " + data[i].selectec + " value=\"" + data[i].id + "\">" + data[i].name + "<\/option>");
                                });
                                //$example.select2();
                                }
                        });
                        }
                        function getCmbTurno3(){
                        //var $example = $("#especialidad_id-field").select2();
                        var a = $('#frm_cliente').serialize();
                        $.ajax({
                        url: '{{ route("turnos.getCmbTurno") }}',
                                type: 'GET',
                                data: "plantel_id=" + $('#plantel_id-field option:selected').val() + "&especialidad_id=" + $('#especialidad_id-field option:selected').val() + "&nivel_id=" + $('#nivel_id-field option:selected').val() + "&grado_id=" + $('#subdiplomado_id-field option:selected').val() + "&turno_id=" + $('#turno3_id-field option:selected').val() + "",
                                dataType: 'json',
                                beforeSend : function(){$("#loading12").show(); },
                                complete : function(){$("#loading12").hide(); },
                                success: function(data){
                                //alert(data);
                                //$example.select2("destroy");
                                $('#turno3_id-field').html('');
                                //$('#especialidad_id-field').empty();
                                $('#turno3_id-field').append($('<option></option>').text('Seleccionar').val('0'));
                                $.each(data, function(i) {
                                //alert(data[i].name);
                                $('#turno3_id-field').append("<option " + data[i].selectec + " value=\"" + data[i].id + "\">" + data[i].name + "<\/option>");
                                });
                                //$example.select2();
                                }
                        });
                        }
                        function getCmbTurno4(){
                        //var $example = $("#especialidad_id-field").select2();
                        var a = $('#frm_cliente').serialize();
                        $.ajax({
                        url: '{{ route("turnos.getCmbTurno") }}',
                                type: 'GET',
                                data: "plantel_id=" + $('#plantel_id-field option:selected').val() + "&especialidad_id=" + $('#especialidad_id-field option:selected').val() + "&nivel_id=" + $('#nivel_id-field option:selected').val() + "&grado_id=" + $('#subotro_id-field option:selected').val() + "&turno_id=" + $('#turno4_id-field option:selected').val() + "",
                                dataType: 'json',
                                beforeSend : function(){$("#loading12").show(); },
                                complete : function(){$("#loading12").hide(); },
                                success: function(data){
                                //alert(data);
                                //$example.select2("destroy");
                                $('#turno4_id-field').html('');
                                //$('#especialidad_id-field').empty();
                                $('#turno4_id-field').append($('<option></option>').text('Seleccionar').val('0'));
                                $.each(data, function(i) {
                                //alert(data[i].name);
                                $('#turno4_id-field').append("<option " + data[i].selectec + " value=\"" + data[i].id + "\">" + data[i].name + "<\/option>");
                                });
                                //$example.select2();
                                }
                        });
                        }
                        
                        $('.plan_pago').change(function(){
                            $.ajax({
                            url: '{{ route("combinacionClientes.savePlanPago") }}',
                                    type: 'GET',
                                    data: "plan_pago=" + $(this).val() + "&combinacion=" + $(this).data('combinacion'),
                                    dataType: 'json',
                                    beforeSend : function(){$("#loading12").show(); },
                                    complete : function(){$("#loading12").hide(); },
                                    success: function(data){
                                        location.reload();
                                    }
                            });
                        });
                        


                        //codigo de trabajo del cargador de imagenes
                        // File Picker modification for FCK Editor v2.0 - www.fckeditor.net
                        // by: Pete Forde <pete@unspace.ca> @ Unspace Interactive
                        var urlobj;
                        function BrowseServer(obj)
                        {
                        urlobj = obj;
                        OpenServerBrowser(
                                "{{ url('filemanager/show') }}",
                                screen.width * 0.7,
                                screen.height * 0.7);
                        }

                        function OpenServerBrowser(url, width, height)
                        {
                        var iLeft = (screen.width - width) / 2;
                        var iTop = (screen.height - height) / 2;
                        var sOptions = "toolbar=no,status=no,resizable=yes,dependent=yes";
                        sOptions += ",width=" + width;
                        sOptions += ",height=" + height;
                        sOptions += ",left=" + iLeft;
                        sOptions += ",top=" + iTop;
                        var oWindow = window.open(url, "BrowseWindow", sOptions);
                        }

                        function SetUrl(url, width, height, alt)
                        {
                        document.getElementById(urlobj).value = url;
                        oWindow = null;
                        }

                        //pantalla flotante
                        @if (isset($cliente))
                                var popup;
                        function Inscribir(cliente, plantel, especialidad, nivel, grado, turno){
                            popup = window.open("{{route('inscripcions.create')}}", "Popup", "width=800,height=650");
                            popup.onload = function(){
                                popup.document.getElementById('plantel_id-field').value = plantel;
                                popup.document.getElementById('cliente_id-field').value = cliente;
                                popup.location.reload();
                                popup.document.getElementById('especialidad_id-field').value = especialidad;
                                popup.document.getElementById('nivel_id-field').value = nivel;
                                popup.document.getElementById('grado_id-field').value = grado;
                                popup.document.getElementById('turno_id-field').value = turno;
                            }
                        }
                        function InscribirCliente(numero) {
                            
                        var plantel = $('#plantel_id-field option:selected').val();
                        var especialidad1 = $('#especialidad_id-field option:selected').val();
                        var nivel1 = $('#nivel_id-field option:selected').val();
                        var grado1 = $('#grado_id-field option:selected').val();
                        var turno1 = $('#turno_id-field option:selected').val();
                        var especialidad2 = $('#especialidad2_id-field option:selected').val();
                        var nivel2 = $('#curso_id-field option:selected').val();
                        var grado2 = $('#subcurso_id-field option:selected').val();
                        var turno2 = $('#turno2_id-field option:selected').val();
                        var especialidad3 = $('#especialidad3_id-field option:selected').val();
                        var nivel3 = $('#diplomado_id-field option:selected').val();
                        var grado3 = $('#subdiplomado_id-field option:selected').val();
                        var turno3 = $('#turno3_id-field option:selected').val();
                        var especialidad4 = $('#especialidad4_id-field option:selected').val();
                        var nivel4 = $('#otro_id-field option:selected').val();
                        var grado4 = $('#subotro_id-field option:selected').val();
                        var turno4 = $('#turno4_id-field option:selected').val();
                        popup = window.open("{{route('inscripcions.create')}}", "Popup", "width=800,height=650");
                        popup.onload = function(){
                        popup.document.getElementById('plantel_id-field').value = plantel;
                        popup.document.getElementById('cliente_id-field').value = {{$cliente -> id}};
                        popup.location.reload();
                        if (numero == 1){
                        popup.document.getElementById('especialidad_id-field').value = especialidad1;
                        popup.document.getElementById('nivel_id-field').value = nivel1;
                        popup.document.getElementById('grado_id-field').value = grado1;
                        popup.document.getElementById('turno_id-field').value = turno1;
                        } else if (numero == 2){
                        popup.document.getElementById('especialidad_id-field').value = especialidad2;
                        popup.document.getElementById('nivel_id-field').value = nivel2;
                        popup.document.getElementById('grado_id-field').value = grado2;
                        popup.document.getElementById('turno_id-field').value = turno2;
                        } else if (numero == 3){
                        popup.document.getElementById('especialidad_id-field').value = especialidad3;
                        popup.document.getElementById('nivel_id-field').value = nivel3;
                        popup.document.getElementById('grado_id-field').value = grado3;
                        popup.document.getElementById('turno_id-field').value = turno3;
                        } else if (numero == 4){
                        popup.document.getElementById('especialidad_id-field').value = especialidad4;
                        popup.document.getElementById('nivel_id-field').value = nivel4;
                        popup.document.getElementById('grado_id-field').value = grado4;
                        popup.document.getElementById('turno_id-field').value = turno4;
                        }
                        //$('#plantel_id-field').val(plantel).change();
                        }
                        popup.focus();
                        return false
                        }
                        var popup2;
                        function EditarInscripcion(numero) {
                        popup = window.open("{{ url('inscripcions/edit') }}" + "/" + numero, "Popup", "width=800,height=650");
                        popup.focus();
                        return false
                        }
                        @endif

                        $(':input[type="submit"]').click(function(){
                            //$('input.submitForm').read
                            $(':input[type="submit"]').prop('disabled', true);
                            $('form#frm_cliente').submit();
                        });
</script>
@endpush
