@extends('plantillas.admin_template')

@include('clientes._common')

@section('header')

    <ol class="breadcrumb">
    	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
        <!--
        @if ( $query_params = Request::input('q') )

            <li class="active"><a href="{{ route('clientes.index') }}">@yield('clientesAppTitle')</a></li>
            <li class="active">condition(  

            @foreach( $query_params as $key => $value )
                @if (!$loop->first) / @endif {{ $key }} : {{ $value }}
            @endforeach
            )</li>
        @else
            <li class="active">@yield('clientesAppTitle')</li>
        @endif
        -->
        <li class="active">@yield('clientesAppTitle')</li>
    </ol>

    <div class="">
        <h3>
            <i class="glyphicon glyphicon-align-justify"></i> @yield('clientesAppTitle')
            
        </h3>

    </div>

    <div aria-multiselectable="true" role="tablist" id="accordion" class="panel-group">
        <div class="panel panel-default">
            <div id="headingOne" role="tab" class="panel-heading">
                <h4 class="panel-title">
                <a aria-controls="collapseOne" aria-expanded="true" href="#collapseOne" data-parent="#accordion" data-toggle="collapse" role="button">
                    <span aria-hidden="true" class="glyphicon glyphicon-search"></span> Buscar
                </a>
                </h4>
            </div>
            <div aria-labelledby="headingOne" role="tabpanel" class="panel-collapse collapse" id="collapseOne">
                <div class="panel-body">
                    <form class="Cliente_search" id="search" action="{{ route('clientes.indexEventos') }}" accept-charset="UTF-8" method="get">
                        <input type="hidden" name="q[s]" value="{{ @(Request::input('q')['s']) ?: '' }}" />
                        <div class="row">
                            <div class="col-md-12">

                            <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_cve_cliente_gt">CVE_CLIENTE</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm", type="search" value="{{ @(Request::input('q')['cve_cliente_gt']) ?: '' }}" name="q[cve_cliente_gt]" id="q_cve_cliente_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm", type="search" value="{{ @(Request::input('q')['cve_cliente_lt']) ?: '' }}" name="q[cve_cliente_lt]" id="q_cve_cliente_lt" />
                                </div>
                            </div>
                            -->
                            
                    

                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_nombre_gt">NOMBRE</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm", type="search" value="{{ @(Request::input('q')['nombre_gt']) ?: '' }}" name="q[nombre_gt]" id="q_nombre_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm", type="search" value="{{ @(Request::input('q')['nombre_lt']) ?: '' }}" name="q[nombre_lt]" id="q_nombre_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group col-md-4">
                                <label for="q_clientes.id_cont">ID</label>
                                    <input class="form-control input-sm", type="search" value="{{ @(Request::input('q')['clientes.id_lt']) ?: '' }}" name="q[clientes.id_lt]" id="q_clientes.id_lt" />
                            </div>
                            
                            <div class="form-group col-md-4">
                                <label for="q_clientes.nombre_cont">PRIMER NOMBRE</label>
                                
                                    <input class="form-control input-sm", type="search" value="{{ @(Request::input('q')['clientes.nombre_cont']) ?: '' }}" name="q[clientes.nombre_cont]" id="q_clientes.nombre_cont" />
                                
                            </div>
                            <div class="form-group col-md-4">
                                <label for="q_clientes.nombre2_cont">SEGUNDO NOMBRE</label>
                                
                                    <input class="form-control input-sm", type="search" value="{{ @(Request::input('q')['clientes.nombre2_cont']) ?: '' }}" name="q[clientes.nombre2_cont]" id="q_clientes.nombre2_cont" />
                                
                            </div>
                            <div class="form-group col-md-4">
                                <label for="q_clientes.ape_paterno_cont">APELLIDO PATERNO</label>
                                
                                    <input class="form-control input-sm", type="search" value="{{ @(Request::input('q')['clientes.ape_paterno_cont']) ?: '' }}" name="q[clientes.ape_paterno_cont]" id="q_clientes.ape_paterno_cont" />
                                
                            </div>
                            <div class="form-group col-md-4">
                                <label for="q_clientes.ape_materno_cont">APELLIDO MATERNO</label>
                                
                                    <input class="form-control input-sm", type="search" value="{{ @(Request::input('q')['clientes.ape_materno_cont']) ?: '' }}" name="q[clientes.ape_materno_cont]" id="q_clientes.ape_materno_cont" />
                                
                            </div>
                            <!--<div class="form-group col-md-4">
                                <label for="q_clientes.matricula_cont">MATRICULA</label>
                                    <input class="form-control input-sm", type="search" value="{{ @(Request::input('q')['clientes.matricula_cont']) ?: '' }}" name="q[clientes.matricula_cont]" id="q_clientes.matricula_cont" />
                            </div>-->
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_fec_registro_gt">FEC_REGISTRO</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm", type="search" value="{{ @(Request::input('q')['fec_registro_gt']) ?: '' }}" name="q[fec_registro_gt]" id="q_fec_registro_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm", type="search" value="{{ @(Request::input('q')['fec_registro_lt']) ?: '' }}" name="q[fec_registro_lt]" id="q_fec_registro_lt" />
                                </div>
                            </div>
                            -->
                            
                            <div class="form-group col-md-4">
                                <label for="q_clientes.medio_id_lt">MEDIO</label>
                                    {!! Form::select("medio_id", $list1["Medio"], "{{ @(Request::input('q')['clientes.medio_id_lt']) ?: '' }}", array("class" => "form-control select_seguridad", "name"=>"q[clientes.medio_id_lt]", "id"=>"q_clientes.medio_id_lt", "style"=>"width:100%;" )) !!}
                            </div>
                            
                            <div class="form-group col-md-4" style="clear:left;">
                                <label for="q_clientes.st_cliente_id_lt">ESTATUS</label>
                                    {!! Form::select("st_cliente_id", $list1["StCliente"], "{{ @(Request::input('q')['clientes.st_cliente_id_lt']) ?: '' }}", array("class" => "form-control select_seguridad", "name"=>"q[clientes.st_cliente_id_lt]", "id"=>"q_clientes.st_cliente_id_lt", "style"=>"width:100%;" )) !!}
                            </div>
                        
                            <div class="form-group col-md-4">
                                <label for="q_st_seguimiento_id_lt">ESTATUS SEGUIMIENTO</label>
                                    {!! Form::select("st_seguimiento_id", $list["StSeguimiento"], "{{ @(Request::input('q')['st_seguimiento_id_lt']) ?: '' }}", array("class" => "form-control select_seguridad", "name"=>"q[st_seguimiento_id_lt]", "id"=>"q_st_seguimiento_id_lt", "style"=>"width:100%;" )) !!}
                            </div>

                            
                            <div class="form-group col-md-4" >
                                <label for="q_clientes.plantel_id_lt">PLANTEL</label>
                                
                                    {!! Form::select("clientes.plantel_id", $list1["Plantel"], "{{ @(Request::input('q')['clientes.plantel_id_lt']) ?: '' }}", array("class" => "form-control select_seguridad", "name"=>"q[clientes.plantel_id_lt]", "id"=>"q_clientes.plantel_id_lt", "style"=>"width:100%;", "onchange"=>"cambioOpcion()")) !!}
                                    <div id='loading10' style='display: none'><img src="{{ asset('images/ajax-loader.gif') }}" title="Enviando" /></div> 
                            </div>
                            
                            <div class="form-group col-md-4" >
                                <label for="q_clientes.especialidad_id_lt">ESPECIALIDAD</label>
                                
                                    {!! Form::select("clientes.especialidad_id", $list1["Especialidad"], "{{ @(Request::input('q')['clientes.especialidad_id_lt']) ?: '' }}", array("class" => "form-control select_seguridad", "name"=>"q[clientes.especialidad_id_lt]", "id"=>"q_clientes.especialidad_id_lt", "style"=>"width:100%;")) !!}
                                
                            </div>
                            
                            <div class="form-group col-md-4">
                                <label for="q_clientes.empleado_id_lt">EMPLEADO</label>
                                    {!! Form::select("clientes.empleado_id", $list1["Empleado"], "{{ @(Request::input('q')['clientes.empleado_id_lt']) ?: '' }}", array("class" => "form-control select_seguridad", "name"=>"q[clientes.empleado_id_lt]", "id"=>"q_clientes.empleado_id_lt", "style"=>"width:100%;" )) !!}
                            </div>
                            
                            <div class="form-group col-md-4">
                                <label for="q_clientes.tpo_informe_id_lt">TIPO INFORME</label>
                                    {!! Form::select("clientes.tpo_informe_id", $list1["TpoInforme"], "{{ @(Request::input('q')['clientes.tpo_informe_id_lt']) ?: '' }}", array("class" => "form-control select_seguridad", "name"=>"q[clientes.tpo_informe_id_lt]", "id"=>"q_clientes.tpo_informe_id_lt", "style"=>"width:100%;" )) !!}
                            </div>
                            
                            <div class="form-group col-md-4">
                                <label for="q_clientes.usu_alta_id_cont">Usuario Alta</label>
                                {!! Form::select("usu_alta_id", $users, "{{ @(Request::input('q')['clientes.usu_alta_id_lt']) ?: '' }}", array("class" => "form-control select_seguridad", "name"=>"q[clientes.usu_alta_id_lt]", "id"=>"q_clientes.usu_alta_id_lt", "style"=>"width:100%;" )) !!}    
                            </div>
                            
                            <div class="form-group col-md-4 fec @if($errors->has('created_at_mayorq')) has-error @endif">
                            <label for="fec_alta-field">Fecha Alta Mayor Que(aaaa-mm-dd hh:mm:ss)</label>
                            <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['clientes.created_at_mayorq']) ?: '' }}" name="q[clientes.created_at_mayorq]" id="q_clientes.created_at_mayorq" />
                            </div>
                            
                            <div class="form-group col-md-4 fec @if($errors->has('created_at_menorq')) has-error @endif">
                            <label for="fec_alta-field">Fecha Alta Menor Que(aaaa-mm-dd hh:mm:ss)</label>
                            <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['clientes.created_at_menorq']) ?: '' }}" name="q[clientes.created_at_menorq]" id="q_clientes.created_at_menorq" />
                            </div>

                            <div class="form-group col-md-4">
                                <label for="q_clientes.matricula_cont">MATRICULA</label>
                                
                                    <input class="form-control input-sm", type="search" value="{{ @(Request::input('q')['clientes.matricula_cont']) ?: '' }}" name="q[clientes.matricula_cont]" id="q_clientes.matricula_cont" />
                                
                            </div>

                            <div class="form-group" id='ultimo'>
                                <div class="col-sm-10 col-sm-offset-2">
                                    <input type="submit" name="commit" value="Buscar" class="btn btn-default btn-xs" />
                                </div>
                            </div>
                        </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div>
        @if(session('message'))
            <div class="alert alert-danger">
                {!! session('message') !!}
            </div>
        @endif
        
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            @if($clientes->count())
                <table class="table table-condensed table-striped tblEnc">
                    <thead>
                        <tr>
                            <th>@include('plantillas.getOrderLink', ['column' => 'cliente_id', 'title' => 'ID'])</th>
                            <th>@include('CrudDscaffold::getOrderlink', ['column' => 'clientes.nombre', 'title' => 'PRIMER NOMBRE'])</th>
                            <th>@include('CrudDscaffold::getOrderlink', ['column' => 'clientes.nombre2', 'title' => 'SEGUNDO NOMBRE'])</th>
                            <th>@include('CrudDscaffold::getOrderlink', ['column' => 'clientes.ape_paterno', 'title' => 'APELLIDO PATERNO'])</th>
                            <th>@include('CrudDscaffold::getOrderlink', ['column' => 'clientes.ape_materno', 'title' => 'APELLIDO MATERNO'])</th>
                            <th>@include('CrudDscaffold::getOrderlink', ['column' => 'clientes.plantel_id', 'title' => 'PLANTEL'])</th>
                            <th>@include('CrudDscaffold::getOrderlink', ['column' => 'clientes.pais_id', 'title' => 'PAIS'])</th>
                            <th>@include('CrudDscaffold::getOrderlink', ['column' => 'clientes.st_cliente_id', 'title' => 'ESTATUS CLIENTE'])</th>
                            <th>Eventos</th>
                            <th>Vinculacion</th>
                            <th class="text-right">OPCIONES</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($clientes as $cliente)
                            <tr>
                                <td><a href="{{ route('clientes.edit', $cliente->cliente_id) }}">{{$cliente->cliente_id}}</a></td>
                                <td>{{$cliente->cliente->nombre}}</td>
                                <td>{{$cliente->cliente->nombre2}}</td>
                                <td>{{$cliente->cliente->ape_paterno}}</td>
                                <td>{{$cliente->cliente->ape_materno}}</td>
                                <td>{{$cliente->cliente->empleado->nombre." ".$cliente->cliente->empleado->ape_paterno." ".$cliente->cliente->empleado->ape_materno}}</td>
                                <td> {{$cliente->cliente->paise->name}} </td>
                                <td>{{$cliente->cliente->stCliente->name}}</td>
                                <td>
                                    @permission('historiaClientes.create')
                                    <a class="btn btn-xs btn-success" href="{{ route('historiaClientes.create',array('cliente'=>$cliente->cliente->id)) }}"><i class="glyphicon glyphicon-plus"></i> Crear</a>
                                    <a class="btn btn-xs btn-warning" href="{{ route('historiaClientes.index',array('q[cliente_id_lt]'=>$cliente->cliente->id)) }}" target='_blank'><i class="glyphicon glyphicon-plus"></i> Ver</a>
                                    @endpermission
                                </td>
                                <td>
                                    @permission('vinculacions.create')
                                    <a class="btn btn-xs btn-success" href="{{ route('vinculacions.create',array('cliente'=>$cliente->cliente->id)) }}"><i class="glyphicon glyphicon-plus"></i> Crear</a>
                                    <a class="btn btn-xs btn-warning" href="{{ route('vinculacions.index',array('q[cliente_id_lt]'=>$cliente->cliente->id)) }}" target='_blank'><i class="glyphicon glyphicon-plus"></i> Ver</a>
                                    @endpermission
                                </td>
                                <td class="text-right">
                                    <a class="btn btn-xs bg-maroon" href="{{ route('clientes.boleta', array('id'=>$cliente->cliente->id)) }}"><i class="glyphicon glyphicon-calendar"></i> Boleta</a>
                                    <a class="btn btn-xs bg-purple" href="{{ route('autorizacionBecas.findByClienteId', array('cliente_id'=>$cliente->cliente->id)) }}">
                                        <i class="fa fa-eye"></i> S. Becas
                                    </a>
           <!--                         
                                    <button class="btn btn-success btnVerLineas pull-right btn-xs" lang="mesaj" data-check="{{$cliente->cliente->id}}" data-href="formation_json_parents" style="margin-left:10px;" >
                                        <span class="fa fa-eye" aria-hidden="true"></span> Ver Becas
                                    </button>
             -->                       
                                    @permission('correos.redactar')
                                    @if(isset($cliente->cliente->mail))
                                    <a class="btn btn-xs btn-success" href="{{ url('correos/redactar').'/'.$cliente->cliente->mail.'/'.$cliente->cliente->nombre.'/0' }}"><i class="glyphicon glyphicon-envelope"></i> Correo </a>
                                    @endif
                                    @endpermission
                                    @permission('seguimientos.show')
                                    <a class="btn btn-xs btn-default" href="{{ route('seguimientos.show', $cliente->cliente->id) }}"><i class="glyphicon glyphicon-edit"></i> Seguimiento</a>
                                    @endpermission
                                    @php
                                    $planteles = array();
                                    foreach ($empleado->plantels as $plantel) {
                                        array_push($planteles, $plantel->id);
                                    }
                                    @endphp
                                    @if(array_search($cliente->cliente->plantel_id,$planteles)<>false)
                                    @permission('clientes.edit')
                                    <a class="btn btn-xs btn-warning" href="{{ route('clientes.edit', $cliente->cliente->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                                    @endpermission
                                    @endif
                                    @permission('corporativo.editarCliente')
                                    <a class="btn btn-xs btn-warning" href="{{ route('clientes.edit', $cliente->cliente->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                                    @endpermission
                                    @php
                                     $usuario=\App\usuarioCliente::where('name',$cliente->cliente->matricula)->first();   
                                    @endphp
                                    @permission('usuarioClientes.edit')
                                    @if(!is_null($usuario))
                                    <a class="btn btn-xs btn-info" href="{{ route('usuarioClientes.edit', $usuario->id) }}"><i class="glyphicon glyphicon-user"></i> Editar Usuario</a>
                                    @endif
                                    @endpermission
                                    @permission('clientes.destroy')
                                    {!! Form::model($cliente, array('route' => array('clientes.destroy', $cliente->cliente->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? ¿Esta seguro?')) { return true } else {return false };")) !!}
                                        <button type="submit" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i> Borrar</button>
                                    {!! Form::close() !!}
                                    @endpermission
                                    
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {!! $clientes->appends(Request::except('page'))->render() !!}
            @else
                <h3 class="text-center alert alert-info">Vacio!</h3>
            @endif

        </div>
    </div>

@endsection

@push('scripts')
<script src="{{ asset ('/bower_components/AdminLTE/plugins/input-mask/jquery.inputmask.js') }}"></script>
<script src="{{ asset ('/bower_components/AdminLTE/plugins/input-mask/jquery.inputmask.extensions.js') }}"></script>
<script src="{{ asset ('/bower_components/AdminLTE/plugins/input-mask/jquery.inputmask.phone.extensions.js') }}"></script>
  <script>

      $('#search').children().last().children().children('.fec').children('input').inputmask({ mask: "9999-99-99 99:99:99"}); //specifying options
      //ale=$('#q_clientes.st_cliente_id_lt option:selected').val();
      //document.getElementById('q_clientes.st_cliente_id_lt').value=4;
      //$('#search').submit();
      
        function cambioOpcion(){
            getCmbEspecialidad();
        }
       
        function removeOptions(selectbox)
        {
            var i;
            for(i = selectbox.options.length - 1 ; i >= 0 ; i--)
            {
                selectbox.remove(i);
            }
        }
        
        function getCmbEspecialidad(){
                var plantel=document.getElementById('q_clientes.plantel_id_lt');
                var especialidad=document.getElementById('q_clientes.especialidad_id_lt');
                
                $.ajax({
                url: '{{ route("especialidads.getCmbEspecialidad") }}',
                        type: 'GET',
                        data: "plantel_id=" + plantel.options[plantel.selectedIndex].value + "&especialidad_id=" + especialidad.options[especialidad.selectedIndex].value + "",
                        dataType: 'json',
                        beforeSend : function(){$("#loading10").show(); },
                        complete : function(){$("#loading10").hide(); },
                        success: function(data){
                        removeOptions(document.getElementById("q_clientes.especialidad_id_lt"));
                        $.each(data, function(i) {
                        //$('#q_clientes.especialidad_id_lt-field').append("<option " + data[i].selectec + " value=\"" + data[i].id + "\">" + data[i].name + "<\/option>");
                            var opt = document.createElement('option');
                            opt.value = data[i].id;
                            opt.innerHTML = data[i].name;
                            especialidad.appendChild(opt);
                        });
                        
                        }
                });
                }

  </script>
@endpush