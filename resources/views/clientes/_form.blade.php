@inject('respuestasVisibles','App\Http\Controllers\CcuestionarioDatosController')
<div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
        <li class="active">
            <a data-toggle="tab" href="#tab1">Cliente</a>
        </li>
        <li class="">
            <a data-toggle="tab" href="#tab2">Preguntas</a>
        </li>
        
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
        <li class="">
            <a data-toggle="tab" href="#tab7">Facturación</a>
        </li>
        <li class="">
            <a data-toggle="tab" href="#tab8">Procedencia</a>
        </li>
        <li class="">
            <a data-toggle="tab" href="#tab9">Solicitud de Beca</a>
        </li>
    </ul>
    <div class="tab-content">
        <div id="tab1" class="tab-pane active">
            <fieldset>
                <div class="box box-default box-solid">
                    <div class="box-header">
                        <h3 class="box-title">IDENTIFICACION</h3>
                        <div class="box-tools">
                            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="form-group col-md-2 @if($errors->has('curp')) has-error @endif">
                            <label for="curp-field">CURP</label>
                            {!! Form::text("curp", null, array("class" => "form-control input-sm", "id" => "curp-field")) !!}
                            {!! Form::hidden("fec_valida_curp", null, array("class" => "form-control input-sm", "id" => "fec_valida_curp-field", 'readonly'=>true)) !!}
                            @if($errors->has("curp"))
                            <span class="help-block">{{ $errors->first("curp") }}</span>
                            @endif
                        </div>
                        @if(isset($cliente))
                        <div class="form-group col-md-2 @if($errors->has('curp')) has-error @endif">
                            @if(!is_null($cliente->fec_valida_curp))
                            Validacion:{{$cliente->fec_valida_curp}}
                            @endif
                            @permission('clientes.apiValidaCurp')
                            <input type="button" id="btnValidarCurp" value="Validar">
                            {{$cliente->bnd_consulta_curp==1 ? '-Si validado' : 'No validado'}}
                            @endpermission
                            {!! Form::hidden("bnd_consulta_curp", null, array("class" => "form-control input-sm", "id" => "bnd_consulta_curp-field")) !!}
                            @permission('clientes.desbloqueoCurp')
                            <input type="button" id="btnDesbloqueoCurp" value="Desbloquear Curp">
                            @endpermission
                        </div>
                        @endif
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
                            <label for="tel_fijo-field">Telefono Fijo</label>
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
                            {!! Form::select("plantel_id", $plantels, null, array("class" => "form-control select_seguridad", "id" => "plantel_id-field")) !!}
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
                        <!--<div class="form-group col-md-4 @if($errors->has('paise_id')) has-error @endif">
                            <label for="paise_id-field">Pais:{{$cliente->paise->name}}</label>
                            {!! Form::hidden("pais_id", $cliente->paise_id, array("class" => "form-control input-sm", "id" => "pais_id-field")) !!}
                        </div>
                    -->
                        @endif
                        <div class="form-group col-md-4 @if($errors->has('nacionalidad')) has-error @endif">
                            <label for="nacionalidad-field">Nacionalidad</label>
                            {!! Form::text("nacionalidad", null, array("class" => "form-control input-sm", "id" => "nacionalidad-field")) !!}
                            @if($errors->has("nacionalidad"))
                            <span class="help-block">{{ $errors->first("nacionalidad") }}</span>
                            @endif
                        </div>
                        <div class="form-group col-md-4 @if($errors->has('escolaridad_id')) has-error @endif">
                            <label for="escolaridad_id-field">Escolaridad</label>
                            {!! Form::select("escolaridad_id", $list["Escolaridad"], null, array("class" => "form-control select_seguridad", "id" => "escolaridad_id-field")) !!}
                            @if($errors->has("escolaridad_id"))
                            <span class="help-block">{{ $errors->first("escolaridad_id") }}</span>
                            @endif
                        </div>
                        <div class="row"></div>
                        <div class="form-group col-md-4 @if($errors->has('discapacidad_id')) has-error @endif">
                            <label for="discapacidad_id-field">Discapacidad</label>
                            {!! Form::select("discapacidad_id", $list["Discapacidad"], null, array("class" => "form-control select_seguridad", "id" => "discapacidad_id-field")) !!}
                            @if($errors->has("discapacidad_id"))
                            <span class="help-block">{{ $errors->first("discapacidad_id") }}</span>
                            @endif
                        </div>
                        <div class="form-group col-md-3 @if($errors->has('bnd_trabaja')) has-error @endif">
                            <label for="bnd_trabaja-field">¿Trabaja?</label>
                            {!! Form::checkbox("bnd_trabaja", 1, null, [ "id" => "bnd_trabaja-field", 'class'=>'minimal']) !!}
                            @if($errors->has("bnd_trabaja"))
                            <span class="help-block">{{ $errors->first("bnd_trabaja") }}</span>
                            @endif
                        </div>
                        <div class="form-group col-md-3 @if($errors->has('bnd_indigena')) has-error @endif">
                            <label for="bnd_indigena-field">Â¿Es indigena?</label>
                            {!! Form::checkbox("bnd_indigena", 1, null, [ "id" => "bnd_indigena-field", 'class'=>'minimal']) !!}
                            @if($errors->has("bnd_indigena"))
                            <span class="help-block">{{ $errors->first("bnd_indigena") }}</span>
                            @endif
                        </div>
                        
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
                            <label for="tel_cel-field">Telefono Celular(10 digitos)</label>
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
                            <label for="mail-field">Correo ElectrOnico</label>
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

                <div class="box box-default box-solid">
                    <div class="box-header">
                        <h3 class="box-title">CUESTIONARIO</h3>
                        <div class="box-tools bg-white">
                            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        
                        <div class="form-group col-md-4 @if($errors->has('interes_estudio_id')) has-error @endif">
                            <label for="interes_estudio_id-field">Ã‚Â¿Por que te interesa estudiar nuestra carrera tecnica?</label>
                            {!! Form::select("interes_estudio_id", $list["InteresEstudio"], null, array("class" => "form-control select_seguridad", "id" => "interes_estudio_id-field")) !!}
                            @if($errors->has("interes_estudio_id"))
                            <span class="help-block">{{ $errors->first("interes_estudio_id") }}</span>
                            @endif
                        </div>
                        <div class="row"></div>
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
                    </div>
                </div>
                
                
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
                            {!! Form::hidden("combinacion", null, array("class" => "form-control input-sm", "id" => "combinacion-field")) !!}
                            {!! Form::select("especialidad_id", $list["Especialidad"], null, array("class" => "form-control select_seguridad", "id" => "especialidad_id-field")) !!}
                            <div id='loading10' style='display: none'><img src="{{ asset('images/ajax-loader.gif') }}" title="Enviando" /></div> 
                            @if($errors->has("especialidad"))
                            <span class="help-block">{{ $errors->first("especialidad") }}</span>
                            @endif
                        </div>
                        <div class="form-group col-md-2 @if($errors->has('nivel_id')) has-error @endif">
                            <label for="nivel_id-field">Nivel</label>
                            {!! Form::select("nivel_id", (isset($cliente->nivel_id) and $cliente->nivel_id<>0) ? $list["Nivel"] : [], null, array("class" => "form-control select_seguridad", "id" => "nivel_id-field")) !!}
                            <div id='loading11' style='display: none'><img src="{{ asset('images/ajax-loader.gif') }}" title="Enviando" /></div> 
                            @if($errors->has("nivel_id"))
                            <span class="help-block">{{ $errors->first("nivel_id") }}</span>
                            @endif
                        </div>
                        <div class="form-group col-md-4 @if($errors->has('grado_id')) has-error @endif">
                            <label for="grado_id-field">Grado </label>
                            {!! Form::select("grado_id", (isset($cliente->grado_id) and $cliente->grado_id<>0) ? $list["Grado"] : [], null, array("class" => "form-control select_seguridad", "id" => "grado_id-field")) !!}
                            <div id='loading12' style='display: none'><img src="{{ asset('images/ajax-loader.gif') }}" title="Enviando" /></div> 
                            @if($errors->has("grado_id"))
                            <span class="help-block">{{ $errors->first("grado_id") }}</span>
                            @endif
                        </div>
                        <div class="form-group col-md-2 @if($errors->has('turno_id')) has-error @endif">
                            <label for="turno_id-field">Turno</label>
                            {!! Form::select("turno_id", (isset($cliente->turno_id) and $cliente->turno_id<>0) ? $list["Turno"] : [], null, array("class" => "form-control select_seguridad", "id" => "turno_id-field")) !!}
                            <div id='loading12' style='display: none'><img src="{{ asset('images/ajax-loader.gif') }}" title="Enviando" /></div> 
                            @if($errors->has("turno_id"))
                            <span class="help-block">{{ $errors->first("turno_id") }}</span>
                            @endif
                        </div>
                        
                        @permission('combinacionClientes.store')
                        @if(isset($cliente))
                            @php
                                $combinaciones=\App\CombinacionCliente::where('cliente_id',$cliente->id)
                                ->where('plantel_id','<>',0)
                                ->where('especialidad_id','<>',0)
                                ->where('nivel_id','<>',0)
                                ->where('grado_id','<>',0)
                                ->where('turno_id','<>',0)
                                ->where('plan_pago_id','<>',0)
                                ->get();
                            @endphp
                            
                            @if($combinaciones->count()==0)
                                <div class="form-group col-md-1 @if($errors->has('grado_id')) has-error @endif">
                                    <input type="button" id="crearCombinacion" class="btn btn-xs btn-block btn-success" value="Crear" onclick="CrearCombinacionCliente()" />
                                    <!--<a href=# class="btn btn-xs btn-warning btn-block" id="btnConsultaPlan">Ver Plan</a>-->
                                </div>
                                <div class="form-group col-md-1 @if($errors->has('grado_id')) has-error @endif">
                                    <br/><input type="button" id="actualizarCombinacion" class="btn btn-xs btn-block btn-success" value="Guardar" onclick="ActualizarCombinacionCliente()" style="display:none;" />
                                    
                                </div>
                            @else
                                @permission('combinacionClientes.storeMasDeUno')
                                    <div class="form-group col-md-1 @if($errors->has('grado_id')) has-error @endif">
                                        <input type="button" id="crearCombinacion" class="btn btn-xs btn-block btn-success" value="Crear" onclick="CrearCombinacionCliente()" />
                                        <!--<a href=# class="btn btn-xs btn-warning btn-block" id="btnConsultaPlan">Ver Plan</a>-->
                                    </div>
                                @endpermission
                                @permission('combinacionClientes.editarCombinacion')
                                <div class="form-group col-md-1 @if($errors->has('grado_id')) has-error @endif">
                                    <br/><input type="button" id="actualizarCombinacion" class="btn btn-xs btn-block btn-success" value="Guardar" onclick="ActualizarCombinacionCliente()" style="display:none;" />
                                </div>
                                @endpermission
                            @endif
                        @endif
                        @endpermission    
                        
                        <div class="row col-md-12">
                            @if(isset($cliente))
                            <table class="table table-condensed table-striped">
                                <thead>
                                    <th>Editar</th>
                                    <th>Especialidad</th>
                                    <th>Nivel</th>
                                    <th>Grado</th>
                                    <th>Turno</th>
                                    <th>InscripciÃ³n</th>
                                    <th>Plan Pago</th>
                                    <th>beca</th>
                                    <th></th>
                                </thead>
                                <tbody>
                                    @foreach($cliente->combinaciones as $c)
                                    @if($c->especialidad_id<>0 and $c->nivel_id<>0 and $c->grado_id<>0)
                                    <tr>
                                        <td>
                                            {!! Form::checkbox("editar_combinacion", 1, null, [ "class" => "editar_combinacion minimal",  
                                            'data-combinacion'=>$c->id,
                                            'data-especialidad'=>$c->especialidad_id,
                                            'data-nivel'=>$c->nivel_id,
                                            'data-grado'=>$c->grado_id,
                                            'data-turno'=>$c->turno_id]) !!}    
                                        </td>
                                        <td>{{$c->especialidad->name}}</td>
                                        
                                        <td>
                                            {{$c->nivel->name}}
                                         
                                        </td>
                                        <td>
                                            {{optional($c->grado)->name}}
                                         
                                        </td>
                                        <td>
                                            {{optional($c->turno)->name}}  
                                            <a href={{ route('planPagos.show',optional($c->planPago)->id) }} target="_blank" class="btn btn-xs btn-warning">Ver Plan</a>
                                        </td>
                                        <td>
                                        @if($c->bnd_inscrito==1)  
                                            Si
                                        @elseif($c->inscripcion)
                                            Si
                                        @endif
                                        
                                        </td>
                                        <td>
                                           <!--@{!! Form::select("plan_pago_id", $c->turno->planes->pluck('name','id'),$c->plan_pago_id,array("class"=>"form-control select_seguridad plan_pago","id"=>"plan_pago_id-field","style"=>"width:75%;",'data-combinacion'=>$c->id)) !!} -->
                                           
                                           @if($cliente->adeudos->count()==0)
                                           <select class="form-control select_seguridad plan_pago" id="plan_pago_id-field" name="plan_pago_id" data-combinacion="{{$c->id}}">
                                            <option data-combinacion="{{$c->id}}" value="" style="display: none;" {{ old('plan_pago_id', optional($c)->plan_pago_id ?: '') == '' ? 'selected' : '' }} disabled selected>Seleccionar opcion </option>
                                                @foreach (optional($c->turno->planes())->get() as $plan)
                                                    <option data-combinacion="{{$c->id}}" value="{{ $plan->id }}" {{ old('plan_pago_id', optional($c)->plan_pago_id) == $plan->id ? 'selected' : '' }}>
                                                        {{ $plan->name }}
                                                    </option>
                                                @endforeach
                                                
                                            </select>
                                            @endif
                                            @permission('clientes.editarPlanPagosAsignado'):
                                            
                                            <select class="form-control select_seguridad plan_pago" id="plan_pago_id-field" name="plan_pago_id" data-combinacion="{{$c->id}}">
                                                <option data-combinacion="{{$c->id}}" value="" style="display: none;" {{ old('plan_pago_id', optional($c)->plan_pago_id ?: '') == '' ? 'selected' : '' }} disabled selected>Seleccionar opcion </option>
                                                    @foreach (optional($c->turno->planes())->get() as $plan)
                                                    @if($plan->activo==1)    
                                                        <option data-combinacion="{{$c->id}}" value="{{ $plan->id }}" {{ old('plan_pago_id', optional($c)->plan_pago_id) == $plan->id ? 'selected' : '' }}>
                                                            {{ $plan->name }}
                                                        </option>
                                                    @else
                                                        <option disabled=true data-combinacion="{{$c->id}}" value="{{ $plan->id }}" {{ old('plan_pago_id', optional($c)->plan_pago_id) == $plan->id ? 'selected' : '' }}>
                                                            {{ $plan->name }}
                                                        </option>
                                                    @endif
                                                    @endforeach
                                                    
                                                </select>
                                            @endpermission

                                           {{ optional($c->planPago)->name }} <br>
                                            <div id='loading120' style='display: none'><img src="{{ asset('images/ajax-loader.gif') }}" title="Enviando" /></div> 
                                            Impresiones:{{$c->cuenta_ticket_pago}}
                                            @if($c->plan_pago_id<>0)
                                            <a href="{{route('adeudos.imprimirInicial', array('cliente'=>$cliente->id, 'combinacion'=>$c->id))}}" class="btn btn-xs btn-primary" target="_blank" >Imprimir Pago Inicial y Generar Adeudos</a>
                                            @endif
                                            @if(count($cliente->cajas)==0 and count($cliente->adeudos)>0)
                                                <a href="{{route('adeudos.destroyAll', array('cliente'=>$cliente->id, 'combinacion'=>$c->id))}}" class="btn btn-xs btn-primary" >Eliminar Adeudos(Sin Inf. en Caja)</a>
                                            @endif
                                            @permission('adeudos.cambiarPlanPagos') 
                                            <a href="{!! route('adeudos.cambiarPlanPagos', array('cliente'=>$cliente->id, 'combinacion'=>$c->id)) !!}" class="btn btn-xs btn-warning">Ajustar Adeudos segun Plan</a>
                                            @endpermission
                                        </td>
                                        <td>
                                            {!! Form::checkbox("bnd_beca", 1, $c->bnd_beca, [ "class" => "bnd_beca-field", 'data-combinacion'=>$c->id]) !!}
                                            <div id='loading33' style='display: none'><img src="{{ asset('images/ajax-loader.gif') }}" title="Enviando" /></div> 
                                        </td>
                                        <td>
                                            @permission('combinacionClientes.destroy')
                                            <a href="{!! route('combinacionClientes.destroy', $c->id) !!}" class="btn btn-xs btn-block btn-danger">Eliminar</a>
                                            @endpermission

                                            @permission('inscripcions.create') 
                                                
                                                
                                                <!--@@if($cliente->seguimiento->st_seguimiento_id==2 and $cliente->st_cliente_id==22)-->
                                                <button class="inscribir-create btn btn-primary btn-xs" data-cliente_id="{{$c->cliente_id}}"
                                                                                                   data-cliente_nombre="{{$cliente->nombre.' '.$cliente->nombre2.' '.$cliente->ape_paterno.' '.$cliente->ape_materno}}"
                                                                                                   data-plantel="{{$c->plantel_id}}"
                                                                                                   data-especialidad="{{$c->especialidad_id}}"
                                                                                                   data-nivel="{{$c->nivel_id}}"
                                                                                                   data-grado="{{$c->grado_id}}"
                                                                                                   data-turno="{{$c->turno_id}}"
                                                                                                   data-combinacion="{{$c->id}}"
                                                                                                   data-st_cliente="{{$cliente->st_cliente_id}}">
                                                <span class="glyphicon glyphicon-star"></span> Inscribir </button>
                                                <!--@@endif-->
                                            @endpermission
                                            
                                        </td>
                                    </tr>
                                    @endif
                                    @endforeach
                                </tbody>
                            </table>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="box box-default box-solid">
                    <div class="box-header">
                        <h3 class="box-title">INCIDENCIAS</h3>
                        <div class="box-tools">

                            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        </div>
                    </div>
                    
                    <div class="box-body">   
                        <div class="form-group col-md-3 @if($errors->has('incidence_cliente_id')) has-error @endif">
                            <label for="incidence_cliente_id-field">Incidencias</label>
                            {!! Form::select("incidence_cliente_id", $incidencias, null, array("class" => "form-control select_seguridad", "id" => "incidence_cliente_id-field")) !!}
                            
                            @if($errors->has("incidence_cliente_id"))
                            <span class="help-block">{{ $errors->first("incidence_cliente_id") }}</span>
                            @endif
                        </div>
                        <div class="form-group col-md-4 @if($errors->has('detalle')) has-error @endif">
                            <label for="detalle-field">Detalle</label>
                            {!! Form::text("detalle", null, array("class" => "form-control input-sm", "id" => "detalle-field")) !!}
                            @if($errors->has("detalle"))
                            <span class="help-block">{{ $errors->first("detalle") }}</span>
                            @endif
                        </div>

                        <div class="form-group col-md-4 @if($errors->has('fecha')) has-error @endif">
                            <label for="fecha-field">Fecha</label>
                            {!! Form::text("fecha", null, array("class" => "form-control input-sm fecha", "id" => "fecha-field")) !!}
                            @if($errors->has("fecha"))
                            <span class="help-block">{{ $errors->first("fecha") }}</span>
                            @endif
                        </div>
                        
                        @permission('incidencesClientes.store')
                        @if(isset($cliente))
                                <div class="form-group col-md-1 @if($errors->has('grado_id')) has-error @endif">
                                    <a class="btn btn-xs btn-block btn-success" id="crearIncidencia" href="#">Crear</a> 
                                </div>
                                <div class="form-group col-md-1 @if($errors->has('grado_id')) has-error @endif">
                                    <br/>
                                    
                                </div>
                            
                        @endif
                        @endpermission    
                        
                        <div class="row col-md-12">
                            @if(isset($cliente))
                            <table class="table table-condensed table-striped">
                                <thead>
                                    <th>Incidencia</th><th>Detalle</th><th>Fecha</th><th></th>
                                </thead>
                                <tbody>
                                    @foreach($cliente->incidencesClientes as $incidencia)
                                    <tr>
                                        <td>{{ $incidencia->incidenceCliente->name }}</td><td>{{ $incidencia->detalle }}</td><td>{{ $incidencia->fecha }}</td>
                                        <td>
                                            @permission('incidenceClientes.destroy')
                                            
                                            <a href="{!! route('incidencesClientes.destroy', $incidencia->id) !!}" class="btn btn-xs btn-block btn-danger">Eliminar</a>
                                            @endpermission
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>    
                                
                            @endif
                        </div>
                    </div>
                </div>
                
                
                
                <div class="box box-default box-solid">
                    <div class="box-header">
                        <h3 class="box-title">INFORMACION DE PUBLICIDAD Y PROPAGANDA</h3>
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
                            <label for="medio_id-field">Medio por el que se enterO</label>
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
                        @if(isset($cliente))
                        @php 
                            $cliente->load('autorizacionBeca'); 
                        @endphp
                        
                        <table class="table table-condensed table-striped">
                            <thead>
                                <th>Solicitud</th><th>Porcentaje Beca</th><th>Estatus A. Final</th><th>Lectivo</th>
                            </thead>
                            <tbody>
                                @foreach($cliente->autorizacionBecas as $beca)
                                <tr>
                                    <td>{{ $beca->solicitud }}</td>
                                    <td>{{ $beca->monto_mensualidad }}</td>
                                    <td>
                                        @if($beca->aut_dueno<>0)
                                        @php
                                            $autDueno=App\StBeca::find($beca->aut_dueno);
                                        @endphp
                                        @if($autDueno->id==4)
                                        <span class="badge bg-green">
                                            {{ $autDueno->name }}
                                        </span>
                                         @else
                                         <span class="badge bg-red">
                                            {{ $autDueno->name }}
                                        </span>
                                         @endif
                                         @endif
                                    </td>
                                    <td>{{ optional($beca->lectivo)->name }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @endif
                        <!--
                        <div class="form-group col-md-3 @if($errors->has('beca_bnd')) has-error @endif">
                            <label for="beca_bnd-field">Becado</label>
                            {!! Form::checkbox("beca_bnd", 1, null, [ "id" => "beca_bnd-field", 'class'=>'minimal', 'disabled'=>'disabled']) !!}
                            @if($errors->has("beca_bnd"))
                            <span class="help-block">{{ $errors->first("beca_bnd") }}</span>
                            @endif
                        </div>
                        <div class="form-group col-md-8 @if($errors->has('justificacion_beca')) has-error @endif">
                            <label for="justificacion_beca-field">Justificacion</label>
                            {!! Form::text("justificacion_beca", null, array("class" => "form-control input-sm", "id" => "justificacion_beca-field", 'readonly'=>'readonly')) !!}
                            @if($errors->has("justificacion_beca"))
                            <span class="help-block">{{ $errors->first("justificacion_beca") }}</span>
                            @endif
                        </div>
                        <div class="form-group col-md-4 @if($errors->has('beca_porcentaje')) has-error @endif">
                            <label for="beca_porcentaje-field">Monto Inscripcion(0.00)</label>
                            {!! Form::text("beca_porcentaje", null, array("class" => "form-control input-sm", "id" => "beca_porcentaje-field", 'readonly'=>'readonly')) !!}
                            @if($errors->has("beca_porcentaje"))
                            <span class="help-block">{{ $errors->first("beca_porcentaje") }}</span>
                            @endif
                        </div>
                        <div class="form-group col-md-4 @if($errors->has('monto_mensualidad')) has-error @endif">
                            <label for="monto_mensualidad-field">Monto Mensualidad(0.00)</label>
                            {!! Form::text("monto_mensualidad", null, array("class" => "form-control input-sm", "id" => "monto_mensualidad-field", 'readonly'=>'readonly')) !!}
                            @if($errors->has("monto_mensualidad"))
                            <span class="help-block">{{ $errors->first("monto_mensualidad") }}</span>
                            @endif
                        </div>
                        
                        @if(isset($cliente))
                        <div class="form-group col-md-4 @if($errors->has('beca_nota')) has-error @endif">
                            <label > {{ $cliente->beca_nota }}</label>
                        </div>
                        @endif
                    -->
                    </div>
                </div>
                
                <div class="box box-default box-solid">
                    <div class="box-header">
                        <h3 class="box-title">DIRECCION DEL CLIENTE</h3>
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
                
            </fieldset>
        </div>
        <div id="tab3" class="tab-pane">
            <fieldset>
                <div class="form-group col-md-4 @if($errors->has('matricula')) has-error @endif">
                    <label for="matricula-field">Matricula</label><div id="contador"></div>
                    @permission('clientes.editMatricula')
                    {!! Form::text("matricula", null, array("class" => "form-control input-sm", "id" => "matricula-field")) !!}
                    @endpermission
                    
                    @if(isset($cliente))
                    {!! Form::text("matricul", $cliente->matricula, array("class" => "form-control input-sm", "id" => "matricula1-field", 'readonly'=>true)) !!}
        		    @endif

                    @if(isset($cliente))
                    @permission('clientes.generarMatricula')
                    <a href="{{ route('clientes.generarMatricula', array('cliente'=>$cliente->id)) }}" class="btn">Crear Matricula-Usuario</a>
                    @endpermission
                    @if($cliente->matricula<>"")
                    @permission('clientes.generarUsuarioPortal')
                    <a href="{{ route('clientes.generarUsuarioPortal', array('cliente'=>$cliente->id)) }}" target="_blank" class="btn">G. Usuario Portal</a>
                    @endpermission
                    @endif
                    @endif
                </div>
                                            
                @permission('clientes.historiaMatricula')
                @if(isset($cliente))
                <div class="form-group col-md-2 @if($errors->has('bnd_reclasificado')) has-error @endif">
                    <a href="{{route('clientes.historiaMatricula', array('cliente'=>$cliente->id))}}" class="btn btn-default" target="_blank">Cambios Matricula</a>
                </div>
                @endif
                @endpermission


                <div class="form-group col-md-2 @if($errors->has('bnd_reclasificado')) has-error @endif">
                  <label for="bnd_reclasificado-field">Reclasificado: @if(isset($cliente->bnd_reclasificado) and $cliente->bnd_reclasificado==1) SI @else NO @endif</label>
                    @permission('clientes.reclasificado')
                    {!! Form::select("bnd_reclasificado", array(0=>'No', 1=>"Si"), null, array("class" => "form-control select_seguridad", "id" => "bnd_reclasificado-field", 'style'=>'width:100%')) !!}
                    @endpermission
                    @if($errors->has("bnd_reclasificado"))
                    <span class="help-block">{{ $errors->first("bnd_reclasificado") }}</span>
                    @endif
                </div>
                

                <div class="form-group col-md-4 @if($errors->has('cve_alumno')) has-error @endif">
                    <label for="cve_alumno-field">Clave Alumno</label>
                    {!! Form::text("cve_alumno", null, array("class" => "form-control input-sm", "id" => "cve_alumno-field")) !!}
                    @if($errors->has("cve_alumno"))
                    <span class="help-block">{{ $errors->first("cve_alumno") }}</span>
                    @endif
                </div>
                <div class="form-group col-md-4 @if($errors->has('no_poliza')) has-error @endif">
                    <label for="no_poliza-field">No. Poliza</label>
                    {!! Form::text("no_poliza", null, array("class" => "form-control input-sm", "id" => "no_poliza-field")) !!}
                    @if($errors->has("no_poliza"))
                    <span class="help-block">{{ $errors->first("no_poliza") }}</span>
                    @endif
                </div>
                <div class="form-group col-md-4 @if($errors->has('genero')) has-error @endif">
                    <label for="Genero-field">Genero</label><br/>
                    {!! Form::radio("genero", 1, null, [ "id" => "genero-field"]) !!}
                    <label for="Genero-field">Masculino</label>
                    {!! Form::radio("genero", 2, null, [ "id" => "genero-field"]) !!}
                    <label for="Genero-field">Femenino</label>
                    @if($errors->has("genero"))
                    <span class="help-block">{{ $errors->first("genero") }}</span>
                    @endif
                </div>
                <div class="form-group col-md-4 @if($errors->has('estado_civil_id')) has-error @endif">
                    <label for="estado_civil_id-field">Estado Civil</label>
                    {!! Form::select("estado_civil_id", $estado_civiles, null, array("class" => "form-control select_seguridad", "id" => "estado_civil_id-field")) !!}
                    @if($errors->has("estado_civil_id"))
                    <span class="help-block">{{ $errors->first("estado_civil_id") }}</span>
                    @endif
                </div>
                <div class="form-group col-md-4 @if($errors->has('fec_nacimiento')) has-error @endif">
                    <label for="fec_nacimiento-field">F. Nacimiento</label>
                    {!! Form::text("fec_nacimiento", null, array("class" => "form-control input-sm", "id" => "fec_nacimiento-field")) !!}
                    @if($errors->has("fec_nacimiento"))
                    <span class="help-block">{{ $errors->first("fec_nacimiento") }}</span>
                    @endif
                </div>
                <div class="form-group col-md-4 @if($errors->has('estado_nacimiento_id')) has-error @endif">
                    <label for="estado_nacimiento_id-field">Estado Nacimiento</label>
                    {!! Form::text("abreviatura_estado", null, array("class" => "form-control input-sm", "id" => "abreviatura_estado-field", 'readonly'=>true)) !!}
                    {!! Form::select("estado_nacimiento_id", $list["Estado"], null, array("class" => "form-control select_seguridad", "id" => "estado_nacimiento_id-field", 'disabled'=>true)) !!}
                    @if($errors->has("estado_nacimiento_id"))
                    <span class="help-block">{{ $errors->first("estado_nacimiento_id") }}</span>
                    @endif
                </div>
                <div class="form-group col-md-4 @if($errors->has('edad')) has-error @endif">
                    <label for="edad-field">Edad</label>
                    {!! Form::text("edad", null, array("class" => "form-control input-sm", "id" => "edad-field")) !!}
                    @if($errors->has("edad"))
                    <span class="help-block">{{ $errors->first("edad") }}</span>
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
                <div class="form-group col-md-4 @if($errors->has('fec_reingreso')) has-error @endif">
                    <label for="fec_reingreso-field">F. Reingreso</label>
                    {!! Form::text("fec_reingreso", null, array("class" => "form-control input-sm fecha", "id" => "fec_reingreso-field")) !!}
                    @if($errors->has("fec_reingreso"))
                    <span class="help-block">{{ $errors->first("fec_reingreso") }}</span>
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
                    <label for="senas_particulares-field">SeÃ±as Particulares</label>
                    {!! Form::text("senas_particulares", null, array("class" => "form-control input-sm", "id" => "senas_particulares-field")) !!}
                    @if($errors->has("senas_particulares"))
                    <span class="help-block">{{ $errors->first("senas_particulares") }}</span>
                    @endif
                </div>
                <div class="form-group col-md-4 @if($errors->has('pagador_id')) has-error @endif">
                    <label for="pagador_id-field">Quien Paga</label>
                    {!! Form::select("pagador_id", $list["Pagador"], null, array("class" => "form-control select_seguridad", "id" => "pagador_id-field", 'style'=>'width:100%')) !!}
                    @if($errors->has("pagador_id"))
                    <span class="help-block">{{ $errors->first("pagador_id") }}</span>
                    @endif
                </div>

                <div class="form-group col-md-4 @if($errors->has('fec_vencimiento_cred')) has-error @endif">
                            <label for="fec_vencimiento_cred-field">Fecha Vencimiento Cred.</label>
                            {!! Form::text("fec_vencimiento_cred", null, array("class" => "form-control input-sm fecha", "id" => "fec_vencimiento_cred-field")) !!}
                            @if($errors->has("fec_vencimiento_cred"))
                            <span class="help-block">{{ $errors->first("fec_vencimiento_cred") }}</span>
                            @endif
                        </div>
                <div class="form-group col-md-12 @if($errors->has('observaciones')) has-error @endif">
                    <label for="observaciones-field">Observaciones</label>
                    {!! Form::textArea("observaciones", null, array("class" => "form-control input-sm", "id" => "observaciones-field")) !!}
                    @if($errors->has("observaciones"))
                    <span class="help-block">{{ $errors->first("observaciones") }}</span>
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
                            <label for="dir_padre-field">DirecciOn</label>
                            {!! Form::text("dir_padre", null, array("class" => "form-control input-sm", "id" => "dir_padre-field")) !!}
                            @if($errors->has("dir_padre"))
                            <span class="help-block">{{ $errors->first("dir_padre") }}</span>
                            @endif
                        </div>
                        <div class="form-group col-md-4 @if($errors->has('tel_padre')) has-error @endif">
                            <label for="tel_padre-field">Telefono Fijo</label>
                            {!! Form::text("tel_padre", null, array("class" => "form-control input-sm", "id" => "tel_padre-field")) !!}
                            @if($errors->has("tel_padre"))
                            <span class="help-block">{{ $errors->first("tel_padre") }}</span>
                            @endif
                        </div>
                        <div class="form-group col-md-4 @if($errors->has('cel_padre')) has-error @endif">
                            <label for="cel_padre-field">Telefono Celular</label>
                            {!! Form::text("cel_padre", null, array("class" => "form-control input-sm", "id" => "cel_padre-field")) !!}
                            @if($errors->has("cel_padre"))
                            <span class="help-block">{{ $errors->first("cel_padre") }}</span>
                            @endif
                        </div>
                        <div class="form-group col-md-4 @if($errors->has('tel_ofi_padre')) has-error @endif">
                            <label for="tel_ofi_padre-field">Telefono Trabajo</label>
                            {!! Form::text("tel_ofi_padre", null, array("class" => "form-control input-sm", "id" => "tel_ofi_padre-field")) !!}
                            @if($errors->has("tel_ofi_padre"))
                            <span class="help-block">{{ $errors->first("tel_ofi_padre") }}</span>
                            @endif
                        </div>
                        <div class="form-group col-md-4 @if($errors->has('mail_padre')) has-error @endif">
                            <label for="mail_padre-field">Correo ElectrOnico</label>
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
                            <label for="dir_madre-field">Direccion</label>
                            {!! Form::text("dir_madre", null, array("class" => "form-control input-sm", "id" => "dir_madre-field")) !!}
                            @if($errors->has("dir_madre"))
                            <span class="help-block">{{ $errors->first("dir_madre") }}</span>
                            @endif
                        </div>
                        <div class="form-group col-md-4 @if($errors->has('tel_madre')) has-error @endif">
                            <label for="tel_madre-field">Telefono Fijo</label>
                            {!! Form::text("tel_madre", null, array("class" => "form-control input-sm", "id" => "tel_madre-field")) !!}
                            @if($errors->has("tel_madre"))
                            <span class="help-block">{{ $errors->first("tel_madre") }}</span>
                            @endif
                        </div>
                        <div class="form-group col-md-4 @if($errors->has('cel_madre')) has-error @endif">
                            <label for="cel_madre-field">Telefono Celular</label>
                            {!! Form::text("cel_madre", null, array("class" => "form-control input-sm", "id" => "cel_madre-field")) !!}
                            @if($errors->has("cel_madre"))
                            <span class="help-block">{{ $errors->first("cel_madre") }}</span>
                            @endif
                        </div>
                        <div class="form-group col-md-4 @if($errors->has('tel_ofi_madre')) has-error @endif">
                            <label for="tel_ofi_madre-field">Telefono Trabajo</label>
                            {!! Form::text("tel_ofi_madre", null, array("class" => "form-control input-sm", "id" => "tel_ofi_madre-field")) !!}
                            @if($errors->has("tel_ofi_madre"))
                            <span class="help-block">{{ $errors->first("tel_ofi_madre") }}</span>
                            @endif
                        </div>
                        <div class="form-group col-md-4 @if($errors->has('mail_madre')) has-error @endif">
                            <label for="mail_madre-field">Correo ElectrOnico</label>
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
                            <label for="dir_acudiente-field">Direccion</label>
                            {!! Form::text("dir_acudiente", null, array("class" => "form-control input-sm", "id" => "dir_acudiente-field")) !!}
                            @if($errors->has("dir_acudiente"))
                            <span class="help-block">{{ $errors->first("dir_acudiente") }}</span>
                            @endif
                        </div>
                        <div class="form-group col-md-4 @if($errors->has('tel_acudiente')) has-error @endif">
                            <label for="tel_acudiente-field">Telefono Fijo</label>
                            {!! Form::text("tel_acudiente", null, array("class" => "form-control input-sm", "id" => "tel_acudiente-field")) !!}
                            @if($errors->has("tel_acudiente"))
                            <span class="help-block">{{ $errors->first("tel_acudiente") }}</span>
                            @endif
                        </div>
                        <div class="form-group col-md-4 @if($errors->has('cel_acudiente')) has-error @endif">
                            <label for="cel_acudiente-field">Telefono Celular</label>
                            {!! Form::text("cel_acudiente", null, array("class" => "form-control input-sm", "id" => "cel_acudiente-field")) !!}
                            @if($errors->has("cel_acudiente"))
                            <span class="help-block">{{ $errors->first("cel_acudiente") }}</span>
                            @endif
                        </div>
                        <div class="form-group col-md-4 @if($errors->has('tel_ofi_acudiente')) has-error @endif">
                            <label for="tel_ofi_acudiente-field">Telefono Trabajo</label>
                            {!! Form::text("tel_ofi_acudiente", null, array("class" => "form-control input-sm", "id" => "tel_ofi_acudiente-field")) !!}
                            @if($errors->has("tel_ofi_acudiente"))
                            <span class="help-block">{{ $errors->first("tel_ofi_acudiente") }}</span>
                            @endif
                        </div>
                        <div class="form-group col-md-4 @if($errors->has('mail_acudiente')) has-error @endif">
                            <label for="mail_acudiente-field">Correo ElectrOnico</label>
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
            @if(isset($historia) and count($historia)>0)
                <div aria-multiselectable="true" role="tablist" id="accordion" class="panel-group">
                    <div class="panel panel-default">
                        <div id="headingOne" role="tab" class="panel-heading">
                            <h4 class="panel-title">
                            <a aria-controls="collapseOne" aria-expanded="true" href="#collapseOne" data-parent="#accordion" data-toggle="collapse" role="button">
                                <span aria-hidden="true" class="glyphicon glyphicon-search"></span> Historia Sistema Anterior
                            </a>
                            @permission('consultaCalificacions.create')
                            <a class="btn btn-success btn-xs pull-right" href="{{ route('consultaCalificacions.create',array('cliente'=>$cliente->id)) }}" target="_blank"><i class="glyphicon glyphicon-plus"></i> Crear</a>
                            @endpermission
                            </h4>
                        </div>
                        <div aria-labelledby="headingOne" role="tabpanel" class="panel-collapse collapse" id="collapseOne">
                            <div class="panel-body">
                                <table class="table table-condensed table-striped">
                                    <head>
                                        <th>
                                            
                                        </th>
                                    <th>Periodo Escolar</th><th>Asignatura</th><th>Clave</th><th>Creditos</th><th>Periodo</th><th>Calificacion</th>
                                    <th>Tipo Evaluacion</th><th>Oficial</th>
                                    </head>
                                    <body>
                                    @foreach($historia as $registro)
                                        <tr>
                                            <td>
                                                @permission('consultaCalificacions.edit')
                                                <a class="btn btn-xs btn-warning" href="{{ route('consultaCalificacions.edit', array('id'=>$registro->id, 'cliente'=>$cliente->id)) }}" target="_blank"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                                                @endpermission
                                                @permission('consultaCalificacions.destroy')
                                                <a class="btn btn-xs btn-danger eliminar_consulta_calificacion" href="{{ route('consultaCalificacions.destroy', $registro->id) }}" onclick="return confirm('Estas seguro?')"><i class="glyphicon glyphicon-edit"></i> Eliminar</a>
                                                @endpermission
                                            </td>
                                            <td>{{$registro->periodo_escolar}}</td>
                                            <td>{{$registro->materia}}</td>
                                            <td>{{$registro->codigo}}</td>
                                            <td>{{$registro->creditos}}</td>
                                            <td>{{$registro->lectivo}}</td>
                                            <td>{{$registro->calificacion}}</td>
                                            <td>{{$registro->tipo_examen}}</td>
                                            <td>
                                                @if($registro->bnd_oficial==1)
                                                SI
                                                @else
                                                NO
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    </body>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            
            @if(isset($cliente->inscripciones))
            @foreach($cliente->inscripciones as $i)
            <table class="table table-condensed table-striped">
                <thead style="color: #ffffff;background: #0B0B3B;">
                <td>Plantel</td><td>Especialidad</td><td>Nivel</td>
                <td>Grado</td>
                <td>
                    Grupo
                    @permission('inscripcions.alumnosXinscripcion')
                    <a href="{{ route('inscripcions.alumnosXinscripcion',array('id'=>$i->id) )}}" target="_blank" class="btn btn-primary btn-xs"> 
                    <span class="glyphicon glyphicon-star"></span> Ver Alumnos </a>
                    @endpermission
                </td>
                <td>
                    Periodo
                </td>
                <td>F. Inscripcion</td>
                <td>Periodo Lectivo</td><td>Matricula</td><td>Control</td><td>Estatus</td><td></td>
                </thead>
                <tbody>

                    <tr style="color: #ffffff;background:#6495ED;">
                        <td>{{$i->plantel->razon}}</td>
                        <td>{{optional($i->especialidad)->name}}</td>
                        <td>{{optional($i->nivel)->name}}</td>
                        <td>{{optional($i->grado)->name}}</td>
                        <td>{{optional($i->grupo)->name}}</td>
                        <td>{{optional($i->periodo_estudio)->name}}</td>
                        <td>{{$i->fec_inscripcion}}</td>
                        <td>{{optional($i->lectivo)->name}}</td>
                        <td>{{$i->matricula}}</td>
                        <td>{{$i->control}}</td>
                        <td>{{$i->stInscripcion->name}}</td>
                        <td>
                            @permission('inscripcions.edit')
                            
                            <button class="inscribir-edit btn btn-primary btn-xs" data-cliente_id="{{$i->cliente_id}}"
                                                                                                   data-inscripcion="{{$i->id}}"
                                                                                                   data-cliente_nombre="{{$cliente->nombre.' '.$cliente->nombre2.' '.$cliente->ape_paterno.' '.$cliente->ape_materno}}"
                                                                                                   data-plantel="{{$i->plantel_id}}"
                                                                                                   data-especialidad="{{$i->especialidad_id}}"
                                                                                                   data-nivel="{{$i->nivel_id}}"
                                                                                                   data-grado="{{$i->grado_id}}"
                                                                                                   data-grupo="{{$i->grupo_id}}"
                                                                                                   data-periodo_estudio="{{$i->periodo_estudio_id}}"
                                                                                                   data-fec_inscripcion="{{$i->fec_inscripcion}}"
                                                                                                   data-matricula="{{$i->matricula}}"
                                                                                                   data-lectivo="{{$i->lectivo_id}}"
                                                                                                   data-turno="{{$i->turno_id}}"
                                                                                                   data-st_inscripcion="{{$i->st_inscripcion_id}}">
                                                <span class="glyphicon glyphicon-star"></span> Editar </button>
                            @endpermission
                            @permission('inscripcions.registrarMaterias')
                            <a class="btn btn-xs btn-warning" href="{{ route('inscripcions.registrarMaterias', $i->id) }}"><i class="glyphicon glyphicon-edit"></i>Registrar Materias</a>
                            @endpermission
                            @permission('clientes.verificaMateriasAdeudosPendientes')
                            @if($cliente->st_cliente_id==4 or $cliente->st_cliente_id==31)
                            <a class="btn btn-xs btn-warning" href="{{ route('clientes.verificaMateriasAdeudosPendientes', array('id'=>$cliente->id)) }}"><i class="glyphicon glyphicon-edit"></i>Plan E. Completo</a>
                            @endif
                            @endpermission
                            <a class="btn btn-xs btn-default" href='{{route("inscripcions.historial", array('inscripcion'=>$i))}}' target="_blank">Historial</a>
                            <a class="btn btn-xs btn-success" href='{{route("inscripcions.historialOficial", array('inscripcion'=>$i))}}' target="_blank">Historial O.</a>
                            @permission('inscripcions.destroy')
                            <a class="btn btn-xs btn-danger" href="{{ route('inscripcions.destroyCli', $i->id) }}" onclick="return confirm('Confirmar borrado de inscripcion.');"><i class="glyphicon glyphicon-trash"></i>Borrar</a>
                            @endpermission
                            <a class="btn btn-xs btn-default" href="{{ route('clientes.credencial_anverso', array('id'=>$cliente->id, 'inscripcion'=>$i)) }}" target="_blank"><i class="fa fa-newspaper-o"></i> C. Anverso</a>
                        </td>
                    </tr>
                    <tr>
                    <tr>
                        @permission('inscripcions.registrarMateriaAdicional')
                        <div class="form-group col-md-4 registrarMateriaAdicional">
                        <label for="materia_adicional-field">Materia Adicional</label>  {!! Form::select("materia_adicional", $materias, null, array("class" => "form-control select_seguridad", "id" => "materia_adicional-field", 'style'=>'width:100%')) !!}
                        <a href="#" data-inscripcion_id="{{ $i->id }}" class="btn btn-default btn-xs registrar_materia_adicional">Registrar Materia Adicional</a>
                        </div>
                        @endpermission
                    </tr>
                <table class="table table-condensed table-striped">
                    <thead style="color: #ffffff;background: #27ae60;">
                    <td>Materia</td><td>Oficial</td><td>Grupo</td><td>Lectivo</td><td>Estatus</td><td></td><td></td>
                    </thead>
                    <tbody>
                        @foreach($i->hacademicas as $a)
                        <tr>
                            <td><a href='{{url("asignacionAcademicas/index")}}?&q%5Basignacion_academicas.lectivo_id_lt%5D={{$a->lectivo_id}}&q%5Basignacion_academicas.plantel_id_lt%5D={{$a->plantel_id}}&q%5Basignacion_academicas.empleado_id_lt%5D={{$a->empleado_id}}&q%5Basignacion_academicas.materium_id_lt%5D={{$a->materium_id}}&q%5Basignacion_academicas.grupo_id_lt%5D={{$a->grupo_id}}' target='_blank'>{{optional($a->materia)->id}}-{{optional($a->materia)->codigo}}-{{optional($a->materia)->name}}</a></td>
                            <td>
                                @if(isset($a->materia) and $a->materia->bnd_oficial==1)
                                SI
                                @else
                                NO
                                @endif
                            </td>
                            <td>{{optional($a->grupo)->name}}</td>
                            <td>{{optional($a->lectivo)->name}}</td>
                            <td>{{optional($a->stMateria)->name}}</td>

                            <td>
                            @permission('inscripcions.regenerarCalificacionPonderacion')
                            <a href="{{ route('inscripcions.regenerarCalificacionPonderacion', $a->id) }}" class="btn btn-xs btn-warning" ><i class="glyphicon glyphicon-loading"></i> Regenerar Ponderacion</a>
                            @endpermission
                                <a href="{{ route('hacademicas.destroy', $a->id) }}" class="btn btn-xs btn-danger" ><i class="glyphicon glyphicon-trash"></i> Eliminar</a>
                            </td>
                            <td colspan="2">
                                <table class="table table-condensed table-striped">
                                    <thead>
                                    <td>[L]Examen</td><td>CalificaciOn</td><td></td>
                                    </thead>
                                    <tbody>
                                        @foreach($a->calificaciones as $cali)
                                        <tr>
                                            <td>
                                                <a href="{{ route('lectivos.show',$cali->lectivo_id) }}">[{{$cali->lectivo_id}}]</a>  
                                                {{$cali->tpoExamen->name}}
                                            </td>
                                            <td>
                                                @if($cali->calificacion>6)
                                                {{round($cali->calificacion)}}
                                                @else
                                                {{intdiv($cali->calificacion,1)}}
                                                @endif
                                            </td>
                                            <td>
                                                @permission('calificacions.destroy')
                                                @if($cali->tpo_examen_id<>1 )
                                                <a href="{{ route('calificacions.destroy', $cali->id) }}" class="btn btn-xs btn-danger" ><i class="glyphicon glyphicon-trash"></i> Eliminar</a>
                                                @endif
                                                @endpermission
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
                    <div class="row">

                        <a class="btn btn-xs btn-primary" href="{{ route('pivotDocClientes.crearListaCheck', array('cliente_id'=>$cliente->id)) }}" >Generar lista</a>

                    </div>
                    @permission('clientes.todos_docs_entegados')
                    <div class="form-group col-md-4 @if($errors->has('bnd_doc_oblig_entregados')) has-error @endif">
                        <label for="bnd_doc_oblig_entregados-field">Todos los documentos entregados: 
                            @if(isset($cliente->bnd_doc_oblig_entregados) and $cliente->bnd_doc_oblig_entregados==1) 
                                SI 
                            @else
                                NO 
                            @endif
                        </label>
                        @if($cliente->bnd_doc_oblig_entregados<>1 or Auth::user()->can('clientes.edit_bnd_doc_oblig_entregados'))
                        {!! Form::select("bnd_doc_oblig_entregados", array(0=>'No', 1=>"Si"), null, array("class" => "form-control select_seguridad", "id" => "bnd_doc_oblig_entregados-field", 'style'=>'width:100%')) !!} 
                        @endif
                        @if($errors->has("bnd_doc_oblig_entregados"))
                        <span class="help-block">{{ $errors->first("bnd_doc_oblig_entregados") }}</span>
                        @endif
                    </div>
                    <div class="form-group col-md-8 @if($errors->has('obs_docs')) has-error @endif">
                        <label for="obs_docs-field">Observaciones Documentos</label>
                        {!! Form::text("obs_docs", null, array("class" => "form-control input-sm", "id" => "obs_docs-field")) !!}
                        @if($errors->has("obs_docs"))
                        <span class="help-block">{{ $errors->first("obs_docs") }}</span>
                        @endif
                    </div>
                    @endpermission
                    @if(isset($cliente))
                    <div class="form-group col-md-8 @if($errors->has('obs_docs')) has-error @endif">
                        <label for="obs_docs-field">Observaciones Documentos: {{$cliente->obs_docs}}</label>
                    </div>
                    @endif
                    
                    <div class="row"></div>

                    <!--
                    <div class="form-group col-md-6 @if($errors->has('doc_cliente_id')) has-error @endif">
                        <label for="doc_cliente_id-field">Documento</label>
                        {!! Form::select("doc_cliente_id", $list1["DocAlumno"], null, array("class" => "form-control select_seguridad", "id" => "doc_cliente_id-field", 'style'=>'width:100%')) !!}
                        @if($errors->has("doc_cliente_id"))
                        <span class="help-block">{{ $errors->first("doc_cliente_id") }}</span>
                        @endif
                    </div>

                    <div class="form-group col-md-6">
                        <div class="btn btn-default btn-file">
                            <i class="fa fa-paperclip"></i> Adjuntar Archivo
                            <input type="file"  id="file" name="file" class="cliente_archivo" >
                            <input type="hidden" name="_token" id="_token"  value="<?= csrf_token(); ?>"> 
                            <input type="hidden"  id="file_hidden" name="file_hidden" >
                        </div>
                        <button class="btn btn-success btn-xs" id="btn_archivo"> <span class="glyphicon glyphicon-ok">Cargar</span> </btn>
                        <br/>
                        <p class="help-block"  >Max. 20MB</p>
                        <div id="texto_notificacion">

                        </div>
                    </div>-->
                    <div class="form-group col-md-8">
                        <table class="table table-condensed table-striped">
                            <thead>
                                <tr>
                                    <th>Subido por</th><th>Documentos</th><th>Recibido</th><th>Obligatorio</th><th>Link</th><th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($cliente->pivotDocCliente as $doc)
                                <tr>
                                    <td>{{ $doc->usu_alta->name }}</td>
                                    <td>
                                        {{$doc->docAlumno->name}}
                                    </td>
                                    <td>
                                        @if($doc->doc_entregado==1)
                                        SI
                                        @else
                                        @if($cliente->bnd_doc_oblig_entregados<>1 or Auth::user()->can('clientes.edit_bnd_doc_oblig_entregados')) 
                                        <div id='doc_recibido'>
                                            <a class="btn btn-warning btn-xs btn_recibir_doc" 
                                                data-documento='{{ $doc->id }}'> Recibir
                                            </a>
                                            <div id="spinner_doc_recibido" style="display:none;">
                                                ...guardando
                                            </div>
                                        </div>
                                        @endif
                                        @endif
                                    </td>
                                    <td>
                                        @if($doc->docAlumno->doc_obligatorio==1)
                                        SI
                                        @else
                                        NO
                                        @endif
                                    </td>
                                    <td>
                                        @if(!is_null($doc->archivo))
                                        @php
                                            $cadena_img = explode('/', $doc->archivo);
                                        @endphp
                                        <a href="{{asset("imagenes/clientes/".$cliente->id."/".end($cadena_img))}}" target="_blank">Ver</a>
                                        @else
                                            @if($cliente->bnd_doc_oblig_entregados<>1 or Auth::user()->can('clientes.edit_bnd_doc_oblig_entregados')) 
                                            <div id="div_archivo{{ $doc->id }}">
                                            <div class="btn btn-xs btn-file">
                                                <i class="fa fa-paperclip"></i> Adjuntar
                                                <input type="file"  id="file{{ $doc->id }}" name="file" class="cliente_archivo" >
                                                <input type="hidden" name="_token" id="_token"  value="<?= csrf_token(); ?>"> 
                                                <input type="hidden"  id="file_hidden" name="file_hidden" >
                                            </div>
                                            <button class="btn btn-success btn-xs btn_archivo" id="btn_archivo{{ $doc->id }}"
                                                data-doc_id="{{ $doc->doc_alumno_id }}"
                                                data-documento='{{ $doc->id }}'> 
                                                <span class="glyphicon glyphicon-ok">Max. 200KB</span> 
                                            </button>
                                            <br/>
                                            <div id="texto_notificacion{{ $doc->id }}">
                    
                                            </div>
                                            </div>
                                            @endif
                                        @endif
                                    </td>
                                    <td>
                                        @if(!is_null($doc->archivo) and ($cliente->bnd_doc_oblig_entregados<>1 or Auth::user()->can('clientes.edit_bnd_doc_oblig_entregados'))) 
                                        <a class="btn btn-xs btn-danger" href="{{route('pivotDocClientes.destroy', $doc->id)}}">Eliminar</a>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="form-group col-md-4">
                        <table class="table table-condensed table-striped">
                            <thead>
                                <tr>
                                    <th>Documentos</th><th>Obligatorio</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($documentos_faltantes as $df)
                                @if(is_null($df->deleted_at))
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
                                @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif
        </div>    

        <div id="tab7" class="tab-pane">
            <fieldset>
                <div class="box box-default box-solid">
                    <div class="box-header">
                        <h3 class="box-title">Facturacion</h3>
                        <div class="box-tools">
                            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="form-group col-md-4 @if($errors->has('tipo_persona_id')) has-error @endif">
                            <label for="tipo_persona_id-field">Tipo Persona</label>
                            {!! Form::select("tipo_persona_id", $list["TipoPersona"], null, array("class" => "form-control select_seguridad", "id" => "tipo_persona_id-field", 'style'=>'width:100%')) !!}
                            @if($errors->has("tipo_persona_id"))
                            <span class="help-block">{{ $errors->first("tipo_persona_id") }}</span>
                            @endif
                        </div>
                        <div class="form-group col-md-4 @if($errors->has('uso_factura_id')) has-error @endif">
                            <label for="uso_factura_id-field">Uso Factura</label>
                            {!! Form::select("uso_factura_id", $list["UsoFactura"], null, array("class" => "form-control select_seguridad", "id" => "uso_factura_id-field", 'style'=>'width:100%')) !!}
                            @if($errors->has("uso_factura_id"))
                            <span class="help-block">{{ $errors->first("uso_factura_id") }}</span>
                            @endif
                        </div>
                        <div class="form-group col-md-4 @if($errors->has('frazon')) has-error @endif">
                            <label for="frazon-field">Nombre o Razon Social</label>
                            {!! Form::text("frazon", null, array("class" => "form-control input-sm", "id" => "frazon-field")) !!}
                            @if($errors->has("frazon"))
                            <span class="help-block">{{ $errors->first("frazon") }}</span>
                            @endif
                        </div>
                        <div class="form-group col-md-4 @if($errors->has('frfc')) has-error @endif">
                            <label for="frfc-field">RFC</label>
                            {!! Form::text("frfc", null, array("class" => "form-control input-sm", "id" => "frfc-field")) !!}
                            @if($errors->has("frfc"))
                            <span class="help-block">{{ $errors->first("frfc") }}</span>
                            @endif
                        </div>
                        <div class="form-group col-md-4 @if($errors->has('fmail')) has-error @endif">
                            <label for="fmail-field">Correo electronico</label>
                            {!! Form::text("fmail", null, array("class" => "form-control input-sm", "id" => "fmail-field")) !!}
                            @if($errors->has("fmail"))
                            <span class="help-block">{{ $errors->first("frfc") }}</span>
                            @endif
                        </div>
                        <div class="form-group col-md-4 @if($errors->has('fcalle')) has-error @endif">
                            <label for="fcalle-field">Calle</label>
                            {!! Form::text("fcalle", null, array("class" => "form-control input-sm", "id" => "fcalle-field")) !!}
                            @if($errors->has("fcalle"))
                            <span class="help-block">{{ $errors->first("fcalle") }}</span>
                            @endif
                        </div>
                        <div class="form-group col-md-4 @if($errors->has('fno_exterior')) has-error @endif">
                            <label for="fno_exterior-field">No. Exterior</label>
                            {!! Form::text("fno_exterior", null, array("class" => "form-control input-sm", "id" => "fno_exterior-field")) !!}
                            @if($errors->has("fno_exterior"))
                            <span class="help-block">{{ $errors->first("fno_exterior") }}</span>
                            @endif
                        </div>
                        <div class="form-group col-md-4 @if($errors->has('fno_interior')) has-error @endif">
                            <label for="fno_interior-field">No. Interior</label>
                            {!! Form::text("fno_interior", null, array("class" => "form-control input-sm", "id" => "fno_interior-field")) !!}
                            @if($errors->has("fno_interior"))
                            <span class="help-block">{{ $errors->first("fno_interior") }}</span>
                            @endif
                        </div>
                        <div class="form-group col-md-4 @if($errors->has('fcolonia')) has-error @endif">
                            <label for="fcolonia-field">Colonia</label>
                            {!! Form::text("fcolonia", null, array("class" => "form-control input-sm", "id" => "fcolonia-field")) !!}
                            @if($errors->has("fcolonia"))
                            <span class="help-block">{{ $errors->first("fcolonia") }}</span>
                            @endif
                        </div>
                        <div class="form-group col-md-4 @if($errors->has('fciudad')) has-error @endif">
                            <label for="fciudad-field">Ciudad</label>
                            {!! Form::text("fciudad", null, array("class" => "form-control input-sm", "id" => "fciudad-field")) !!}
                            @if($errors->has("fciudad"))
                            <span class="help-block">{{ $errors->first("fciudad") }}</span>
                            @endif
                        </div>
                        <div class="form-group col-md-4 @if($errors->has('festado')) has-error @endif">
                            <label for="festado-field">Estado</label>
                            {!! Form::text("festado", null, array("class" => "form-control input-sm", "id" => "festado-field")) !!}
                            @if($errors->has("festado"))
                            <span class="help-block">{{ $errors->first("festado") }}</span>
                            @endif
                        </div>
                        <div class="form-group col-md-4 @if($errors->has('fpais')) has-error @endif">
                            <label for="fpais-field">Pais</label>
                            {!! Form::text("fpais", null, array("class" => "form-control input-sm", "id" => "fpais-field")) !!}
                            @if($errors->has("fpais"))
                            <span class="help-block">{{ $errors->first("fpais") }}</span>
                            @endif
                        </div>
                        <div class="form-group col-md-4 @if($errors->has('fcp')) has-error @endif">
                            <label for="fcp-field">C.P.</label>
                            {!! Form::text("fcp", null, array("class" => "form-control input-sm", "id" => "fcp-field")) !!}
                            @if($errors->has("fcp"))
                            <span class="help-block">{{ $errors->first("fcp") }}</span>
                            @endif
                        </div>
                        <div class="form-group col-md-4 @if($errors->has('regimen_fiscal_id')) has-error @endif">
                            <label for="regimen_fiscal_id-field">Regimen Fiscal</label>
                            {!! Form::select("regimen_fiscal_id", $list["RegimenFiscal"], null, array("class" => "form-control select_seguridad", "id" => "regimen_fiscal_id-field", 'style'=>'width:100%')) !!}
                            @if($errors->has("regimen_fiscal_id"))
                            <span class="help-block">{{ $errors->first("regimen_fiscal_id") }}</span>
                            @endif
                        </div>
                    </div>
                </div>
            </fieldset>
        </div>

        <div id="tab8" class="tab-pane">
            @if(isset($cliente->procedenciaAlumno))
                <fieldset>
                    <div class="form-group col-md-4 @if($errors->has('institucion_procedencia')) has-error @endif">
                       <label for="institucion_procedencia-field">Institucion Procedencia</label>
                       {!! Form::text("institucion_procedencia", $cliente->procedenciaAlumno->institucion_procedencia, array("class" => "form-control", "id" => "institucion_procedencia-field")) !!}
                       @if($errors->has("institucion_procedencia"))
                        <span class="help-block">{{ $errors->first("institucion_procedencia") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('sep_t_estudio_antecedente_id')) has-error @endif">
                       <label for="sep_t_estudio_antecedente_id-field">Sep Tipo Estudio</label>
                       {!! Form::select("sep_t_estudio_antecedente_id", $sepTipoEstudioAntecedente, $cliente->procedenciaAlumno->sep_t_estudio_antecedente_id, array("class" => "form-control select_seguridad", "id" => "sep_t_estudio_antecedente_id-field")) !!}
                       @if($errors->has("sep_t_estudio_antecedente_id"))
                        <span class="help-block">{{ $errors->first("sep_t_estudio_antecedente_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('estado_procedencia_id')) has-error @endif">
                       <label for="estado_procedencia_id-field">Estado</label>
                       {!! Form::select("estado_procedencia_id", $list["Estado"], $cliente->procedenciaAlumno->estado_id, array("class" => "form-control select_seguridad", "id" => "estado_procedencia_id-field")) !!}
                       @if($errors->has("estado_procedencia_id"))
                        <span class="help-block">{{ $errors->first("estado_procedencia_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('fecha_inicio')) has-error @endif">
                       <label for="fecha_inicio-field">Fecha Inicio</label>
                       {!! Form::text("fecha_inicio", $cliente->procedenciaAlumno->fecha_inicio, array("class" => "form-control fecha", "id" => "fecha_inicio-field")) !!}
                       @if($errors->has("fecha_inicio"))
                        <span class="help-block">{{ $errors->first("fecha_inicio") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('fecha_terminacion')) has-error @endif">
                       <label for="fecha_terminacion-field">Fecha Terminación</label>
                       {!! Form::text("fecha_terminacion", $cliente->procedenciaAlumno->fecha_terminacion, array("class" => "form-control fecha", "id" => "fecha_terminacion-field")) !!}
                       @if($errors->has("fecha_terminacion"))
                        <span class="help-block">{{ $errors->first("fecha_terminacion") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('numero_cedula')) has-error @endif">
                       <label for="numero_cedula-field">Numero Cedula</label>
                       {!! Form::text("numero_cedula", $cliente->procedenciaAlumno->numero_cedula, array("class" => "form-control", "id" => "numero_cedula-field")) !!}
                       @if($errors->has("numero_cedula"))
                        <span class="help-block">{{ $errors->first("numero_cedula") }}</span>
                       @endif
                    </div>            
                </fieldset>
            @endif
        </div>

        <div id="tab9" class="tab-pane">
            @if(isset($cliente->prebeca))
                <fieldset>
                    <div class="form-group col-md-2 @if($errors->has('motivo_beca_id')) has-error @endif">
                       <label for="motivo_beca_id-field">Motivo Beca</label>
                       {!! Form::select("motivo_beca_id", $motivosBeca, $cliente->prebeca->motivo_beca_id, array("class" => "form-control select_seguridad", "id" => "motivo_beca_id-field")) !!}
                       @if($errors->has("motivo_beca_id"))
                        <span class="help-block">{{ $errors->first("motivo_beca_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-6 @if($errors->has('porcentaje_beca_id')) has-error @endif">
                       <label for="porcentaje_beca_id-field">Porcentaje Beca</label>
                       {!! Form::select("porcentaje_beca_id", $porcentajeBeca, $cliente->prebeca->porcentaje_beca_id, array("class" => "form-control select_seguridad", "id" => "porcentaje_beca_id-field")) !!}
                       @if($errors->has("porcentaje_beca_id"))
                        <span class="help-block">{{ $errors->first("porcentaje_beca_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('obs_prebeca')) has-error @endif">
                       <label for="obs_prebeca-field">Obs.</label>
                       {!! Form::textArea("obs_prebeca", $cliente->prebeca->obs_prebeca, array("class" => "form-control", "id" => "obs_prebeca-field",'rows'=>3)) !!}
                       @if($errors->has("obs_prebeca"))
                        <span class="help-block">{{ $errors->first("obs_prebeca") }}</span>
                       @endif
                    </div>
                </fieldset>
            @endif
        </div>
    </div>
</div>    


@push('scripts')
<script src="{{ asset ('/bower_components/AdminLTE/plugins/input-mask/jquery.inputmask.js') }}"></script>
<script src="{{ asset ('/bower_components/AdminLTE/plugins/input-mask/jquery.inputmask.extensions.js') }}"></script>
<script src="{{ asset ('/bower_components/AdminLTE/plugins/input-mask/jquery.inputmask.phone.extensions.js') }}"></script>
<script type="text/javascript">


@php
if(isset($cliente)){
    $pagos_validar=App\Adeudo::where('cliente_id',$cliente->id)->where('pagado_bnd',1)->get();    
}
@endphp

@if((isset($cliente) and $pagos_validar->count()>0) or (isset($combinaciones) and $combinaciones->count()>=1))
    document.getElementById("plantel_id-field").disabled=true;
@endif
$(document).on("click", ".btn_archivo", function (e) {
    e.preventDefault();
    
    var miurl = "{{route('clientes.cargarImg')}}";
    // var fileup=$("#file").val();
    var divresul = "texto_notificacion"+$(this).data('documento');

    var data = new FormData();
    data.append('file', $('#file'+$(this).data('documento'))[0].files[0]);
    data.append('doc_cliente_id', $(this).data('doc_id'));
    data.append('documento', $(this).data('documento'));
    
    documento=$(this).data('documento');
    
    @if(isset($cliente))
	data.append('cliente', {{$cliente->id}});
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
            $("#" + divresul + "").html('guardando...');
        },
        complete: function () {
            $("#" + divresul + "").html('ok');
        },
        //una vez finalizado correctamente
        success: function (data) {
            if (confirm('Â¿Deseas Actualizar la PÃ¡gina?')){
                location.reload();
            }
            $(this).text('OK');
        },
        //si ha ocurrido un error
        error: function (data) {

        }
    });
})    
$(document).ready(function() {
    
    deshabilitarNombre();
    @if(!isset($cliente))
        $('#especialidad_id-field').prop('disabled',true);
        $('#nivel_id-field').prop('disabled',true);
        $('#grado_id-field').prop('disabled',true);
        $('#turno_id-field').prop('disabled',true);
    @endif

    function deshabilitarNombre(){
        @if(isset($cliente))
        @if($cliente->st_cliente_id<>0 and $cliente->st_cliente_id<>1 and $cliente->st_cliente_id<>22)
        @if($cliente->seguimiento->st_seguimiento_id==2 or $cliente->seguimiento->st_seguimiento_id==6 or 
        $cliente->seguimiento->st_seguimiento_id==7)
        
        $("#nombre-field").prop('readonly', true);
        $("#nombre2-field").prop('readonly', true);
        $("#ape_paterno-field").prop('readonly', true);
        $("#ape_materno-field").prop('readonly', true);

        @endif
        @endif
        @endif
    }

    @permission('clientes.editarNombre')
        $("#nombre-field").prop('readonly', false);
        $("#nombre2-field").prop('readonly', false);
        $("#ape_paterno-field").prop('readonly', false);
        $("#ape_materno-field").prop('readonly', false);
    @endpermission

    $("#btnConsultaPlan").click(function(event) {
        event.preventDefault();
        var plan=0;
        $.ajax({
                  url: '{{ route("planPagos.getPlanPago") }}',
                  type: 'GET',
                  data: {
                      'turno':$('#turno_id-field option:selected').val()
                  },
                  dataType: 'json',
                  beforeSend : function(){$("#loading13").show();},
                  complete : function(){$("#loading13").hide();},
                  success: function(data){
                    window.open("{{ url('planPagos/show') }}"+"/"+data, '_blank');
                  }
              });
      
      return false;
   });

    longitudCurp();
      $('#curp-field').on('keydown', function(){
         longitudCurp();
      });

      function longitudCurp(){
         //console.log($('#tel_cel-field').val().length);
         if($('#curp-field').val().length>=18 && $('#bnd_consulta_curp-field').val()==1){
            $('#curp-field').attr('readonly', true);
            $('#nombre-field').attr('readonly', true);
            $('#nombre2-field').attr('readonly', true);
            $('#ape_paterno-field').attr('readonly', true);
            $('#ape_materno-field').attr('readonly', true);
            $('#nacionalidad-field').attr('readonly', true);
            $('#fec_nacimiento-field').attr('readonly', true);
            $('#lugar_nacimiento-field').attr('readonly', true);
         }
      }

      @permission('clientes.desbloqueoCurp')
      $("#btnDesbloqueoCurp").click(function(event) {
        $('#curp-field').attr('readonly', false);
        $('#bnd_consulta_curp-field').val(0);
      });
      @endpermission

   $("#btnValidarCurp").click(function(event) {
        
        event.preventDefault();
        if($('#curp-field').val()===""){
            alert('CURP necesaria para validar');    
        }else{
            $('#curp-field').val($('#curp-field').val().toUpperCase());
            
                        
                            
        $.ajax({
            url: '{{ $api_valida_curp["url"]."obtener_datos" }}',
            type: 'GET',
            data: {
                'token':'{{$api_valida_curp["token"]}}',
                'curp': $('#curp-field').val()
            },
            dataType: 'json',
            beforeSend:function(){$("#btnValidarCurp").attr('disabled', true);},
            complete: function(){$("#btnValidarCurp").attr('disabled', false);},
            error: function(data){
                alert('Curp invalida');
                //console.log(data.responseJson.error_message);
                //alert(data.responseJson.error_message);
            },
            success: function(data){
                if(data.error){
                    alert(data.error_message);
                }else{
                    let solicitante=data.response.Solicitante;
                    $('#bnd_consulta_curp-field').val(1);
                    $('#nombre-field').val(solicitante.Nombres);
                    $('#nombre2-field').val("");
                    $('#ape_paterno-field').val(solicitante.ApellidoPaterno);
                    $('#ape_materno-field').val(solicitante.ApellidoMaterno);
                    if(solicitante.ClaveSexo=="H"){
                        $('input[name=genero][value=1]').attr('checked', true);
                    }else{
                        $('input[name=genero][value=2]').attr('checked', true);
                    }
                    $('#nacionalidad-field').val(solicitante.Nacionalidad);
                    $('#fec_nacimiento-field').val(solicitante.FechaNacimiento);
                    $('#lugar_nacimiento-field').val(solicitante.EntidadNacimiento);
                    $('#abreviatura_estado-field').val(solicitante.ClaveEntidadNacimiento);
                    $('#fec_valida_curp-field').val('{{date('Y-m-d')}}');
                    
                    alert('Datos consultados y copiados correctamente');
                    }
                
            }
        });
    
                       
                 
      
        }
        
      return false;
   });

    $('#grupo_id-crear').change(function(){
          getDisponiblesCrear($('#disponibles-crear'));
          getCmbPeriodosEstudio();
        });
        
    $('#grupo_id-editar').change(function(){
	  getDisponibles($('#disponibles-editar'));
          getCmbPeriodosEstudioEditar();
        });
    
<?php
$r = DB::table('params')->where('llave', 'st_cliente_final')->first();
?>
        
        $('#plantel_id-crear').change(function(){
          getCmbGrupo();
        });
        $('#lectivo_id-crear').change(function(){
          getCmbGrupo();
        });

        $('#plantel_id-editar').change(function(){
          getCmbGrupoEditar();
        });
        $('#lectivo_id-editar').change(function(){
          getCmbGrupoEditar();
        });
        
    function getCmbGrupo(){
          //var $example = $("#especialidad_id-field").select2();
          var a= $('#frm_academica').serialize();
              $.ajax({
                  url: '{{ route("asignacionAcademica.getCmbGrupo") }}',
                  type: 'GET',
                  data: "plantel_id=" + $('#plantel_id-crear option:selected').val() + 
                        "&grupo_id=" + $('#grupo_id-crear option:selected').val() + 
                        "&nivel_id=" + $('#nivel_id-crear option:selected').val() + 
                        "&lectivo_id=" + $('#lectivo_id-crear option:selected').val() + "",
                  dataType: 'json',
                  beforeSend : function(){$("#loading13").show();},
                  complete : function(){$("#loading13").hide();},
                  success: function(data){
                      //$example.select2("destroy");
                      $('#grupo_id-crear').html('');
                      
                      //$('#especialidad_id-field').empty();
                      $('#grupo_id-crear').append($('<option></option>').text('Seleccionar').val('0'));
                      
                      $.each(data, function(i) {
                          //alert(data[i].name);
                          $('#grupo_id-crear').append("<option "+data[i].selectec+" value=\""+data[i].id+"\">"+data[i].name+"<\/option>");
                      });
                      //$example.select2();
                  }
              });       
      }

      function getCmbGrupoEditar(){
          //var $example = $("#especialidad_id-field").select2();
          var a= $('#frm_academica').serialize();
              $.ajax({
                  url: '{{ route("asignacionAcademica.getCmbGrupo") }}',
                  type: 'GET',
                  data: "plantel_id=" + $('#plantel_id-editar option:selected').val() + 
                        "&grupo_id=" + $('#grupo_id-editar option:selected').val() + 
                        "&nivel_id=" + $('#nivel_id-editar option:selected').val() + 
                        "&lectivo_id=" + $('#lectivo_id-editar option:selected').val() + "",
                  dataType: 'json',
                  beforeSend : function(){$("#loading13").show();},
                  complete : function(){$("#loading13").hide();},
                  success: function(data){
                      //$example.select2("destroy");
                      $('#grupo_id-editar').html('');
                      
                      //$('#especialidad_id-field').empty();
                      $('#grupo_id-editar').append($('<option></option>').text('Seleccionar').val('0'));
                      
                      $.each(data, function(i) {
                          //alert(data[i].name);
                          $('#grupo_id-editar').append("<option "+data[i].selectec+" value=\""+data[i].id+"\">"+data[i].name+"<\/option>");
                      });
                      //$example.select2();
                  }
              });       
      }
      
    function getCmbPeriodosEstudio(){
          //var $example = $("#especialidad_id-field").select2();
          var a= $('#frm_academica').serialize();
              $.ajax({
                  url: '{{ route("periodoEstudios.getCmbPeriodoInscripcion") }}',
                  type: 'GET',
                  data: "grupo_id=" + $('#grupo_id-crear option:selected').val() + "&periodo_estudio_id=" + $('#periodo_estudio_id-crear option:selected').val() + "",
                  dataType: 'json',
                  beforeSend : function(){$(".loading3").show();},
                  complete : function(){$(".loading3").hide();},
                  success: function(data){
                      //$example.select2("destroy");
                      $('#periodo_estudio_id-crear').html('');
                      
                      //$('#especialidad_id-field').empty();
                      $('#periodo_estudio_id-crear').append($('<option></option>').text('Seleccionar').val('0'));
                      
                      $.each(data, function(i) {
                          //alert(data[i].name);
                          $('#periodo_estudio_id-crear').append("<option "+data[i].selectec+" value=\""+data[i].id+"\">"+data[i].name+"<\/option>");
                      });
                      //$example.select2();
                  }
              });       
      }    
      
    function getCmbPeriodosEstudioEditar(){
          //var $example = $("#especialidad_id-field").select2();
          var a= $('#frm_academica').serialize();
              $.ajax({
                  url: '{{ route("periodoEstudios.getCmbPeriodoInscripcion") }}',
                  type: 'GET',
                  data: "grupo_id=" + $('#grupo_id-editar option:selected').val() + "&periodo_estudio_id=" + $('#periodo_estudio_id-editar option:selected').val() + "",
                  dataType: 'json',
                  beforeSend : function(){$(".loading3").show();},
                  complete : function(){$(".loading3").hide();},
                  success: function(data){
                      //$example.select2("destroy");
                      $('#periodo_estudio_id-editar').html('');
                      
                      //$('#especialidad_id-field').empty();
                      $('#periodo_estudio_id-editar').append($('<option></option>').text('Seleccionar').val('0'));
                      
                      $.each(data, function(i) {
                          //alert(data[i].name);
                          $('#periodo_estudio_id-editar').append("<option "+data[i].selectec+" value=\""+data[i].id+"\">"+data[i].name+"<\/option>");
                      });
                      //$example.select2();
                  }
              });       
      }      
    
        
    function getDisponibles(obj){
          var miobj=obj;
          //console.log(miobj.prop('id'));
          //var a= $('#frm_cliente').serialize();
              $.ajax({
                  url: '{{ route("grupos.getDisponibles") }}',
                  type: 'GET',
                  data: "plantel_id=" + $('#plantel_id-editar option:selected').val() + 
                        "&especialidad_id=" + $('#especialidad_id-editar option:selected').val() + 
                        "&nivel_id=" + $('#nivel_id-editar option:selected').val() + 
                        "&grado_id=" + $('#grado_id-editar option:selected').val() + 
                        "&lectivo_id=" + $('#lectivo_id-editar option:selected').val() + 
                        "&grupo_id=" + $('#grupo_id-editar option:selected').val() + "",
                  //data: "grupo_id=" + migrupo,
                  dataType: 'json',
                  beforeSend : function(){$(".loading3").show();},
                  complete : function(){$(".loading3").hide();},
                  success: function(data){
                      miobj.val('');
                      miobj.val(data);
                      if(data<=0){
                        $('.div_disponibles').addClass('has-error');
                        $('.msjDisponiblesError').html('Cupo maximo alcanzado')
                      }
                      
                  }
              });       
      }

     function getDisponiblesCrear(obj){
          var miobj=obj;
          //console.log(miobj.prop('id'));
          //var a= $('#frm_cliente').serialize();
              $.ajax({
                  url: '{{ route("grupos.getDisponibles") }}',
                  type: 'GET',
                  data: "plantel_id=" + $('#plantel_id-crear option:selected').val() + 
                        "&especialidad_id=" + $('#especialidad_id-crear option:selected').val() + 
                        "&nivel_id=" + $('#nivel_id-crear option:selected').val() + 
                        "&grado_id=" + $('#grado_id-crear option:selected').val() + 
                        "&lectivo_id=" + $('#lectivo_id-crear option:selected').val() + 
                        "&grupo_id=" + $('#grupo_id-crear option:selected').val() ,
                  //data: "grupo_id=" + migrupo,
                  dataType: 'json',
                  beforeSend : function(){$(".loading3").show();},
                  complete : function(){$(".loading3").hide();},
                  success: function(data){
                      miobj.val('');
                      miobj.val(data);
                      if(data<=0){
                        $('.div_disponibles').addClass('has-error');
                        $('.msjDisponiblesError').html('Cupo maximo alcanzado')
                      }
                      
                  }
              });       
      }

    /*
     * Crear Inscripcion 
     */    
    //crear registro
    $(document).on('click', '.inscribir-create', function(e) {
        e.preventDefault();
        if($(this).data('st_cliente')==3){
            alert('Alumno con estatus de Baja, no es posible generar inscripcion');
        }else{
            $('.modal-title').text('Inscribir');
        
            //Limpiar valores
            $('#cliente_id-crear').val($(this).data('cliente_id')).change();
            $('#cliente-crear').val($(this).data('cliente_nombre')).change();
            $('#plantel_id-crear').val($(this).data('plantel'));
            $('#especialidad_id-crear').val($(this).data('especialidad'));
            $('#nivel_id-crear').val($(this).data('nivel'));
            $('#grado_id-crear').val($(this).data('grado'));
            $('#turno_id-crear').val($(this).data('turno')).change();
            $('#combinacion_cliente_id-crear').val($(this).data('combinacion')).change();
            
            $('#crearInscripcionModal').modal('show');
            
            $('#plantel_id-crear').change();
            $('#especialidad_id-crear').change();
            $('#nivel_id-crear').change();
            $('#grado_id-crear').change();
            
        }
        

        
        
    });
    
    $('.modal-footer').on('click', '#inscripcion-crear', function() {
        
        $.ajax({
            type: 'POST',
            url: '{{route("inscripcions.store")}}',
            data: {
                '_token': $('input[name=_token]').val(),
                'cliente_id': $('#cliente_id-crear').val(),
                'plantel_id': $('#plantel_id-crear option:selected').val(),
                'especialidad_id': $('#especialidad_id-crear option:selected').val(),
                'nivel_id': $('#nivel_id-crear option:selected').val(),
                'grado_id': $('#grado_id-crear option:selected').val(),
                'lectivo_id': $('#lectivo_id-crear option:selected').val(),
                'grupo_id': $('#grupo_id-crear option:selected').val(),
                'periodo_estudio_id': $('#periodo_estudio_id-crear option:selected').val(),
                'turno_id': $('#turno_id-crear option:selected').val(),
                'fec_inscripcion': $('#fec_inscripcion-crear').val(),
                'matricula': $('#matricula-crear').val(),
                'combinacion_cliente_id': $('#combinacion_cliente_id-crear').val(),
            },
            beforeSend : function(){$("#loading3").show(); },
            complete : function(){$("#loading3").hide(); },
            success: function(data) {
                location.reload();
            },
        });
    });
    
    $(document).on('click', '.inscribir-edit', function(e) {
        e.preventDefault();
        $('.modal-title').text('Editar InscripciOn');
        
        
        //Limpiar valores
        
        $('#cliente_id-editar').val($(this).data('cliente_id')).change();
        $('#cliente-editar').val($(this).data('cliente_nombre')).change();
        $('#plantel_id-editar').val($(this).data('plantel'));
        $('#especialidad_id-editar').val($(this).data('especialidad'));
        $('#nivel_id-editar').val($(this).data('nivel'));
        $('#grado_id-editar').val($(this).data('grado'));
        $('#lectivo_id-editar').val($(this).data('lectivo')).change();
        $('#grupo_id-editar').val($(this).data('grupo')).change();
        $('#periodo_estudio_id-editar').val($(this).data('periodo_estudio')).change();
        $('#turno_id-editar').val($(this).data('turno'));
        $('#fec_inscripcion-editar').val($(this).data('fec_inscripcion'));
        $('#matricula-editar').val($(this).data('matricula'));
        $('#st_inscripcion_id-editar').val($(this).data('st_inscripcion')).change();
        
        $('#editarInscripcionModal').modal('show');
        inscripcion=$(this).data('inscripcion')
        
        $('#plantel_id-editar').change();
        $('#especialidad_id-editar').change();
        $('#nivel_id-editar').change();
        $('#grado_id-editar').change();
        $('#turno_id-editar').change();
    });
    
    $('.modal-footer').on('click', '#inscripcion-editar', function() {
        
        $.ajax({
            type: 'POST',
            url: '{{url("inscripcions/update")}}'+'/'+inscripcion,
            data: {
                '_token': $('input[name=_token]').val(),
                'cliente_id': $('#cliente_id-editar').val(),
                'plantel_id': $('#plantel_id-editar option:selected').val(),
                'especialidad_id': $('#especialidad_id-editar option:selected').val(),
                'nivel_id': $('#nivel_id-editar option:selected').val(),
                'grado_id': $('#grado_id-editar option:selected').val(),
                'lectivo_id': $('#lectivo_id-editar option:selected').val(),
                'grupo_id': $('#grupo_id-editar option:selected').val(),
                'periodo_estudio_id': $('#periodo_estudio_id-editar option:selected').val(),
                'turno_id': $('#turno_id-editar option:selected').val(),
                'fec_inscripcion': $('#fec_inscripcion-editar').val(),
                'matricula': $('#matricula-editar').val(),
                'st_inscripcion_id': $('#st_inscripcion_id-editar option:selected').val(),
            },
            beforeSend : function(){$("#loading3").show(); },
            complete : function(){$("#loading3").hide(); },
            success: function(data) {
                location.reload();
            },
        });
    });
        
                        $("#st_cliente_id-field option[value*={{ $r->valor }}]").prop('readonly', true);
                        @permission('clientes.cambioEstatus')
                        @foreach($list["StCliente"] as $key=>$item)
                            $("#st_cliente_id-field option[value*={{ $key }}]").prop('disabled', true);
                        @endforeach
                        @endpermission

			            @if(isset($cliente) and $cliente->seguimiento->st_seguimiento_id==2)
                            @foreach($empleados as $key=>$item)
				@if($key<>"")
                                $("#empleado_id-field option[value*={{ $key }}]").prop('disabled', true);
				@endif
                            @endforeach
                        @endif

                        @permission('clientes.cambiarEmpleado')
                            @foreach($empleados as $key=>$item)
				                @if($key<>"")
                                $("#empleado_id-field option[value*={{ $key }}]").prop('disabled', false);
				                @endif
                            @endforeach
                        @endpermission
                        
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
                        $('#fec_inscripcion-crear').Zebra_DatePicker({
                            days:['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'],
                            months:['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
                            readonly_element: false,
                            lang_clear_date: 'Limpiar',
                            show_select_today: 'Hoy',
                          });
                         $('#fec_inscripcion-editar').Zebra_DatePicker({
                            days:['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'],
                            months:['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
                            readonly_element: false,
                            lang_clear_date: 'Limpiar',
                            show_select_today: 'Hoy',
                          });
                          $('#fec_nacimiento-field').Zebra_DatePicker({
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
                                    //$('#plantel_id-field').val(data).change();
                                    $("#loading3").hide();
                                    }
                            );
                        });
                        
                        
                        //trabaja el campo plantel 
                        @permission('Icliente.modificarPlantel')
                                $('#plantel_id-field').prop('disabled', false);
                        @endpermission
                        /*$("#frm_cliente").submit(function() {
                            $('#plantel_id-field').prop('disabled', false);
                        return true;
                        });*/
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
                        
                        //combos dependientes
                        getCmbEspecialidad();
                        
                        getCmbEspecialidad2();
                        
                        getCmbNivel();
                        
                        getCmbGrado();
                        
                        getCmbTurno();
                        
                        $('#plantel_id-field').change(function(){
                        getCmbEspecialidad();
                        });
                        $('#especialidad_id-field').change(function(){
                        getCmbNivel();
                        });
                        $('#nivel_id-field').change(function(){
                        getCmbGrado();
                        });
                        $('#grado_id-field').change(function(){
                        getCmbTurno();
                        });

                        $('.editar_combinacion').click(function(){
                            
                            if($(this).is(':checked')==true){
                                $('#combinacion-field').val($(this).data('combinacion'));
                                $('#especialidad_id-field').val(0).change();
                                $('#nivel_id-field').val(0).change();
                                $('#grado_id-field').val(0).change();
                                //alert($(this).data('nivel'));
                                $('#turno_id-field').val(0).change();
                                $('#actualizarCombinacion').show();
                                $('#crearCombinacion').hide();
                            }else{
                                $('#actualizarCombinacion').hide();
                                $('#crearCombinacion').show();
                            }
                            
                            //getCmbTurno2();
                            
                        });
                        
                        
                        /*getCmbEspecialidadCrear();
                        getCmbNivelCrear();
                        getCmbGradoCrear();
                        getCmbTurnoCrear();
                        */
                        $('#plantel_id-crear').change(function(){
                        getCmbEspecialidadCrear();
                        });
                        $('#especialidad_id-crear').change(function(){
                        getCmbNivelCrear();
                        });
                        $('#nivel_id-crear').change(function(){
                        getCmbGradoCrear();
                        });
                        
                        $('#plantel_id-editar').change(function(){
                        getCmbEspecialidadEditar();
                        });
                        $('#especialidad_id-editar').change(function(){
                        getCmbNivelEditar();
                        });
                        $('#nivel_id-editar').change(function(){
                        getCmbGradoEditar();
                        });
			$('#grado_id-editar').change(function(){
                        getCmbTurnoEditar();
                        });
                        
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
                                if($('#plantel_id-field option:selected').val()!=0){
                                    $('#especialidad_id-field').prop('disabled',false);
                                }
                                
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
                        
                        function getCmbEspecialidadCrear(){
                        //var $example = $("#especialidad_id-field").select2();
                        
                        $.ajax({
                        url: '{{ route("especialidads.getCmbEspecialidad") }}',
                                type: 'GET',
                                data: "plantel_id=" + $('#plantel_id-crear option:selected').val() + "&especialidad_id=" + $('#especialidad_id-crear option:selected').val() + "",
                                dataType: 'json',
                                beforeSend : function(){$("#loading10").show(); },
                                complete : function(){$("#loading10").hide(); },
                                success: function(data){
                                //$example.select2("destroy");
                                $('#especialidad_id-crear').empty();
                                $('#especialidad_id-crear').append($('<option></option>').text('Seleccionar').val('0'));
                                $.each(data, function(i) {
                                //alert(data[i].name);
                                $('#especialidad_id-crear').append("<option " + data[i].selectec + " value=\"" + data[i].id + "\">" + data[i].name + "<\/option>");
                                });
                                //$example.select2();
                                }
                        });
                        //console.log("fil");
                        }
                        
                        function getCmbEspecialidadEditar(){
                        //var $example = $("#especialidad_id-field").select2();
                        
                        $.ajax({
                        url: '{{ route("especialidads.getCmbEspecialidad") }}',
                                type: 'GET',
                                data: "plantel_id=" + $('#plantel_id-editar option:selected').val() + "&especialidad_id=" + $('#especialidad_id-editar option:selected').val() + "",
                                dataType: 'json',
                                beforeSend : function(){$("#loading10").show(); },
                                complete : function(){$("#loading10").hide(); },
                                success: function(data){
                                //$example.select2("destroy");
                                $('#especialidad_id-editar').empty();
                                $('#especialidad_id-editar').append($('<option></option>').text('Seleccionar').val('0'));
                                $.each(data, function(i) {
                                //alert(data[i].name);
                                $('#especialidad_id-editar').append("<option " + data[i].selectec + " value=\"" + data[i].id + "\">" + data[i].name + "<\/option>");
                                });
                                //$example.select2();
                                }
                        });
                        }


                        @if(isset($cliente))
                        $('#crearIncidencia').click(function() {
                            $('#crearIncidencia').prop('disabled', true);
                            $.ajax({
                            url: '{{ route("incidencesClientes.store") }}',
                                    type: 'GET',
                                    data: {
                                        "cliente_id":{{ $cliente->id}},
                                        "incidence_cliente_id":$('#incidence_cliente_id-field option:selected').val(),
                                        "detalle":$('#detalle-field').val(),
                                        "fecha":$('#fecha-field').val()
                                    },
                                    dataType: 'json',
                                    beforeSend: function () {
                                    $("#loading_incidencia").show();
                                    },
                                    complete: function () {
                                    location.reload();
                                    },
                            });
                        });
                        function CrearCombinacionCliente() {
                            if($('#especialidad_id-field option:selected').val()==0 ||
                            $('#nivel_id-field option:selected').val()==0 ||
                            $('#grado_id-field option:selected').val()==0 ||
                            $('#turno_id-field option:selected').val()==0 
                            ){
                                alert("campo en intereses del cliente, contiene valor incorrecto");
                            }else{
                            $('#crearCombinacion').prop('disabled', true);
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
                        });}
                        }
                        function ActualizarCombinacionCliente(){
                            $.ajax({
                        url: '{{ url("combinacionClientes/update") }}'+"/"+$('#combinacion-field').val(),
                                type: 'GET',
                                data:{
                                    cliente_id :{{ $cliente->id  }},
                                    plantel_id:$('#plantel_id-field option:selected').val(),
                                    especialidad_id:$('#especialidad_id-field option:selected').val(),
                                    nivel_id:$('#nivel_id-field option:selected').val(),
                                    grado_id:$('#grado_id-field option:selected').val(),
                                    turno_id:$('#turno_id-field option:selected').val()
                                },
                                //dataType: 'json',
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
                        
                        function getCmbNivel(){
                        //var $example = $("#especialidad_id-field").select2();
                        //alert($('#especialidad_id-field option:selected').val());
                        
                        //$("#grado_id-field option[value=0]").attr('selected', 'selected');
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
                                if($('#especialidad_id-field option:selected').val()!=0){
                                    $('#nivel_id-field').prop('disabled',false);
                                }
                                
                                $('#nivel_id-field').html('');
                                //$('#especialidad_id-field').empty();
                                $('#nivel_id-field').append($('<option></option>').text('Seleccionar').val('0'));
                                $.each(data, function(i) {
                                //alert(data[i].name);
                                $('#nivel_id-field').append("<option " + data[i].selectec + " value=\"" + data[i].id + "\">" + data[i].name + "<\/option>");
                                });
                                $('#nivel_id-field').trigger('change');
                                }
                        });
                        }
                        
                        function getCmbNivelCrear(){
                        //var $example = $("#especialidad_id-field").select2();
                        //alert($('#especialidad_id-field option:selected').val());
                        
                        $.ajax({
                        url: '{{ route("nivels.getCmbNivels") }}',
                                type: 'GET',
                                data: "plantel_id=" + $('#plantel_id-crear option:selected').val() + "&especialidad_id=" + $('#especialidad_id-crear option:selected').val() + "&nivel_id=" + $('#nivel_id-crear option:selected').val() + "",
                                dataType: 'json',
                                beforeSend : function(){$("#loading11").show(); },
                                complete : function(){$("#loading11").hide(); },
                                success: function(data){
                                //alert(data);
                                //$example.select2("destroy");
                                $('#nivel_id-crear').html('');
                                //$('#especialidad_id-field').empty();
                                $('#nivel_id-crear').append($('<option></option>').text('Seleccionar').val('0'));
                                $.each(data, function(i) {
                                //alert(data[i].name);
                                $('#nivel_id-crear').append("<option " + data[i].selectec + " value=\"" + data[i].id + "\">" + data[i].name + "<\/option>");
                                });
                                //$example.select2();
                                }
                        });
                        }
                        
                        function getCmbNivelEditar(){
                        //var $example = $("#especialidad_id-field").select2();
                        //alert($('#especialidad_id-field option:selected').val());
                        
                        $.ajax({
                        url: '{{ route("nivels.getCmbNivels") }}',
                                type: 'GET',
                                data: "plantel_id=" + $('#plantel_id-editar option:selected').val() + "&especialidad_id=" + $('#especialidad_id-editar option:selected').val() + "&nivel_id=" + $('#nivel_id-editar option:selected').val() + "",
                                dataType: 'json',
                                beforeSend : function(){$("#loading11").show(); },
                                complete : function(){$("#loading11").hide(); },
                                success: function(data){
                                //alert(data);
                                //$example.select2("destroy");
                                $('#nivel_id-editar').html('');
                                //$('#especialidad_id-field').empty();
                                $('#nivel_id-editar').append($('<option></option>').text('Seleccionar').val('0'));
                                $.each(data, function(i) {
                                //alert(data[i].name);
                                $('#nivel_id-editar').append("<option " + data[i].selectec + " value=\"" + data[i].id + "\">" + data[i].name + "<\/option>");
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
                                if($('#nivel_id-field option:selected').val()!=0){
                                    $('#grado_id-field').prop('disabled',false);
                                }
                                
                                $('#grado_id-field').html('');
                                //$('#especialidad_id-field').empty();
                                $('#grado_id-field').append($('<option></option>').text('Seleccionar').val('0'));
                                $.each(data, function(i) {
                                //alert(data[i].name);
                                $('#grado_id-field').append("<option " + data[i].selectec +
                                                            " value=\"" + data[i].id + "\">" + 
                                                            data[i].name + "<\/option>");
                                });
                                $('#grado_id-field').trigger('change');
                                }
                        });
                        }
                        
                        function getCmbGradoCrear(){
                        //var $example = $("#especialidad_id-field").select2();
                        
                        $.ajax({
                        url: '{{ route("grados.getCmbGrados") }}',
                                type: 'GET',
                                data: "plantel_id=" + $('#plantel_id-crear option:selected').val() + "&especialidad_id=" + $('#especialidad_id-crear option:selected').val() + "&nivel_id=" + $('#nivel_id-crear option:selected').val() + "&grado_id=" + $('#grado_id-crear option:selected').val() + "",
                                dataType: 'json',
                                beforeSend : function(){$("#loading12").show(); },
                                complete : function(){$("#loading12").hide(); },
                                success: function(data){
                                //alert(data);
                                //$example.select2("destroy");
                                $('#grado_id-crear').html('');
                                //$('#especialidad_id-field').empty();
                                $('#grado_id-crear').append($('<option></option>').text('Seleccionar').val('0'));
                                $.each(data, function(i) {
                                //alert(data[i].name);
                                $('#grado_id-crear').append("<option " + data[i].selectec + " value=\"" + data[i].id + "\">" + data[i].name + "<\/option>");
                                });
                                //$example.select2();
                                }
                        });
                        }
                        
                        function getCmbGradoEditar(){
                        //var $example = $("#especialidad_id-field").select2();
                        
                        $.ajax({
                        url: '{{ route("grados.getCmbGrados") }}',
                                type: 'GET',
                                data: "plantel_id=" + $('#plantel_id-editar option:selected').val() + "&especialidad_id=" + $('#especialidad_id-editar option:selected').val() + "&nivel_id=" + $('#nivel_id-editar option:selected').val() + "&grado_id=" + $('#grado_id-editar option:selected').val() + "",
                                dataType: 'json',
                                beforeSend : function(){$("#loading12").show(); },
                                complete : function(){$("#loading12").hide(); },
                                success: function(data){
                                //alert(data);
                                //$example.select2("destroy");
                                $('#grado_id-editar').html('');
                                //$('#especialidad_id-field').empty();
                                $('#grado_id-editar').append($('<option></option>').text('Seleccionar').val('0'));
                                $.each(data, function(i) {
                                //alert(data[i].name);
                                $('#grado_id-editar').append("<option " + data[i].selectec + " value=\"" + data[i].id + "\">" + data[i].name + "<\/option>");
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
                                if($('#grado_id-field option:selected').val()!=0){
                                    $('#turno_id-field').prop('disabled',false);
                                }
                                
                                $('#turno_id-field').html('');
                                //$('#especialidad_id-field').empty();
                                $('#turno_id-field').append($('<option></option>').text('Seleccionar').val('0'));
                                $.each(data, function(i) {
                                //alert(data[i].name);
                                $('#turno_id-field').append("<option " + data[i].selectec + " value=\"" + data[i].id + "\">" + data[i].name + "<\/option>");
                                });
                                $('#turno_id-field').trigger('change');
                                }
                        });
                        }

		        function getCmbTurnoEditar(){
                        $.ajax({
                        url: '{{ route("turnos.getCmbTurno") }}',
                                type: 'GET',
                                data: "plantel_id=" + $('#plantel_id-editar option:selected').val() + "&especialidad_id=" + $('#especialidad_id-editar option:selected').val() + "&nivel_id=" + $('#nivel_id-editar option:selected').val() + "&grado_id=" + $('#grado_id-editar option:selected').val() + "&turno_id=" + $('#turno_id-editar option:selected').val() + "",
                                dataType: 'json',
                                beforeSend : function(){$("#loading12").show(); },
                                complete : function(){$("#loading12").hide(); },
                                success: function(data){
                                //alert(data);
                                //$example.select2("destroy");
                                $('#turno_id-editar').html('');
                                //$('#especialidad_id-field').empty();
                                $('#turno_id-editar').append($('<option></option>').text('Seleccionar').val('0'));
                                $.each(data, function(i) {
                                //alert(data[i].name);
                                $('#turno_id-editar').append("<option " + data[i].selectec + " value=\"" + data[i].id + "\">" + data[i].name + "<\/option>");
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
                                data: "plantel_id=" + $('#cTurno_id-field').data('plantel') + "&especialidad_id=" + $('#cTurno_id-field').data('especialidad') + "&nivel_id=" + $('#cTurno_id-field').data('nivel') + "&grado_id=" + $('#cTurno_id-field').data('grado') + "&turno_id=" + $('#cTurno_id-field option:selected').val() + "",
                                dataType: 'json',
                                beforeSend : function(){$("#loading12").show(); },
                                complete : function(){$("#loading12").hide(); },
                                success: function(data){
                                //alert(data);
                                //$example.select2("destroy");
                                $('#cTurno_id-field').html('');
                                //$('#especialidad_id-field').empty();
                                $('#cTurno_id-field').append($('<option></option>').text('Seleccionar').val('0'));
                                $.each(data, function(i) {
                                //alert(data[i].name);
                                $('#cTurno_id-field').append("<option " + data[i].selectec + " value=\"" + data[i].id + "\">" + data[i].name + "<\/option>");
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
                        
                        $('.bnd_beca-field').click(function(){
                            
                            bnd_beca=0;
                            if($(this).is(':checked')){
                                bnd_beca=1;
                            }
                            $.ajax({
                            url: '{{ route("combinacionClientes.saveBndBeca") }}',
                                    type: 'GET',
                                    data: "bnd_beca=" + bnd_beca + "&combinacion=" + $(this).data('combinacion'),
                                    dataType: 'json',
                                    beforeSend : function(){$("#loading33").show(); },
                                    complete : function(){$("#loading33").hide(); },
                                    success: function(data){
                                        //location.reload();
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

                        

                        $(':input[type="submit"]').click(function(){
                            //$('input.submitForm').read
                            $(':input[type="submit"]').prop('disabled', true);
                            $('form#frm_cliente').submit();
                        });

                        
                        $('.registrar_materia_adicional').on('click', function (e) {
                            e.preventDefault;
                            boton=$(this);
                            materia=$(this).parent().children('#materia_adicional-field');
                            
                            $.ajax({
                                type: 'GET',
                                url: '{{route("inscripcions.registrarMateriaAdicional")}}',
                                data: {
                                    'inscripcion_id': boton.attr('data-inscripcion_id'),
                                    'materia_id': materia.val(),
                                },
                                dataType:"json",
                                //beforeSend : function(){$("#loading3").show(); },
                                //complete : function(){$("#loading3").hide(); },
                                success: function(data) {
                                    location.reload(); 
                                }
                                }); 
                            
                        });

                        $('.btn_recibir_doc').on('click', function (e) {
                            e.preventDefault;
                            
                            $.ajax({
                                type: 'GET',
                                url: '{{route("pivotDocClientes.recibirDocumento")}}',
                                data: {
                                    'documento': $(this).data('documento'),
                                },
                                dataType:"json",
                                beforeSend : function(){$("#spinner_doc_recibido").show(); },
                                complete : function(){$("#spinner_doc_recibido").hide(); },
                                success: function(data) {
                                    if (confirm('Â¿Deseas Actualizar la PÃ¡gina?')){
                                        location.reload();
                                    }
                                }
                                }); 
                            
                        });

                        $(".eliminar_consulta_calificacion1").click( function(e) {
                            e.preventDefault;
                            var url = this.href;
                            result=confirm('Estas seguro que deseas eliminar este registro?');
                            if(result==true){
                                location.href = url;
                            }
                        });
                        
                        
    
</script>
@endpush
