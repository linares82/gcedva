@extends('plantillas.admin_template')

@include('devolucionesCajas._common')

@section('header')

    <ol class="breadcrumb">
    	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
        <!--
        @if ( $query_params = Request::input('q') )

            <li class="active"><a href="{{ route('devolucionesCajas.index') }}">@yield('devolucionesCajasAppTitle')</a></li>
            <li class="active">condition(  

            @foreach( $query_params as $key => $value )
                @if (!$loop->first) / @endif {{ $key }} : {{ $value }}
            @endforeach
            )</li>
        @else
            <li class="active">@yield('devolucionesCajasAppTitle')</li>
        @endif
        -->
        <li class="active">@yield('devolucionesCajasAppTitle')</li>
    </ol>

    <div class="">
        <h3>
            <i class="glyphicon glyphicon-align-justify"></i> @yield('devolucionesCajasAppTitle')
            @permission('devolucionesCajas.create')
            <a class="btn btn-success pull-right" href="{{ route('devolucionesCajas.create') }}"><i class="glyphicon glyphicon-plus"></i> Crear</a>
            @endpermission
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
                    <form class="DevolucionesCaja_search" id="search" action="{{ route('devolucionesCajas.index') }}" accept-charset="UTF-8" method="get">
                        <input type="hidden" name="q[s]" value="{{ @(Request::input('q')['s']) ?: '' }}" />
                        <div class="form-horizontal">

                            <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_cajas.consecutivo_gt">CAJA_CONSECUTIVO</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['cajas.consecutivo_gt']) ?: '' }}" name="q[cajas.consecutivo_gt]" id="q_cajas.consecutivo_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['cajas.consecutivo_lt']) ?: '' }}" name="q[cajas.consecutivo_lt]" id="q_cajas.consecutivo_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_cajas.consecutivo_cont">CAJA_CONSECUTIVO</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['cajas.consecutivo_cont']) ?: '' }}" name="q[cajas.consecutivo_cont]" id="q_cajas.consecutivo_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_clientes.nombre_gt">CLIENTE_NOMBRE</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['clientes.nombre_gt']) ?: '' }}" name="q[clientes.nombre_gt]" id="q_clientes.nombre_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['clientes.nombre_lt']) ?: '' }}" name="q[clientes.nombre_lt]" id="q_clientes.nombre_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_clientes.nombre_cont">CLIENTE_NOMBRE</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['clientes.nombre_cont']) ?: '' }}" name="q[clientes.nombre_cont]" id="q_clientes.nombre_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_plantels.razon_gt">PLANTEL_RAZON</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['plantels.razon_gt']) ?: '' }}" name="q[plantels.razon_gt]" id="q_plantels.razon_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['plantels.razon_lt']) ?: '' }}" name="q[plantels.razon_lt]" id="q_plantels.razon_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_plantels.razon_cont">PLANTEL_RAZON</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['plantels.razon_cont']) ?: '' }}" name="q[plantels.razon_cont]" id="q_plantels.razon_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_monto_gt">MONTO</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['monto_gt']) ?: '' }}" name="q[monto_gt]" id="q_monto_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['monto_lt']) ?: '' }}" name="q[monto_lt]" id="q_monto_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_monto_cont">MONTO</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['monto_cont']) ?: '' }}" name="q[monto_cont]" id="q_monto_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_caja_conceptos.name_gt">CAJA_CONCEPTO_NAME</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['caja_conceptos.name_gt']) ?: '' }}" name="q[caja_conceptos.name_gt]" id="q_caja_conceptos.name_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['caja_conceptos.name_lt']) ?: '' }}" name="q[caja_conceptos.name_lt]" id="q_caja_conceptos.name_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_caja_conceptos.name_cont">CAJA_CONCEPTO_NAME</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['caja_conceptos.name_cont']) ?: '' }}" name="q[caja_conceptos.name_cont]" id="q_caja_conceptos.name_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_grados.name_gt">GRADO_NAME</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['grados.name_gt']) ?: '' }}" name="q[grados.name_gt]" id="q_grados.name_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['grados.name_lt']) ?: '' }}" name="q[grados.name_lt]" id="q_grados.name_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_grados.name_cont">GRADO_NAME</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['grados.name_cont']) ?: '' }}" name="q[grados.name_cont]" id="q_grados.name_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_motivos_dev_cajas.name_gt">MOTIVOS_DEV_CAJA_NAME</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['motivos_dev_cajas.name_gt']) ?: '' }}" name="q[motivos_dev_cajas.name_gt]" id="q_motivos_dev_cajas.name_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['motivos_dev_cajas.name_lt']) ?: '' }}" name="q[motivos_dev_cajas.name_lt]" id="q_motivos_dev_cajas.name_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_motivos_dev_cajas.name_cont">MOTIVOS_DEV_CAJA_NAME</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['motivos_dev_cajas.name_cont']) ?: '' }}" name="q[motivos_dev_cajas.name_cont]" id="q_motivos_dev_cajas.name_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_vobo_gt">VOBO</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['vobo_gt']) ?: '' }}" name="q[vobo_gt]" id="q_vobo_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['vobo_lt']) ?: '' }}" name="q[vobo_lt]" id="q_vobo_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_vobo_cont">VOBO</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['vobo_cont']) ?: '' }}" name="q[vobo_cont]" id="q_vobo_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_obs_gt">OBS</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['obs_gt']) ?: '' }}" name="q[obs_gt]" id="q_obs_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['obs_lt']) ?: '' }}" name="q[obs_lt]" id="q_obs_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_obs_cont">OBS</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['obs_cont']) ?: '' }}" name="q[obs_cont]" id="q_obs_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_usu_alta_id_gt">USU_ALTA_ID</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['usu_alta_id_gt']) ?: '' }}" name="q[usu_alta_id_gt]" id="q_usu_alta_id_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['usu_alta_id_lt']) ?: '' }}" name="q[usu_alta_id_lt]" id="q_usu_alta_id_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_usu_alta_id_cont">USU_ALTA_ID</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['usu_alta_id_cont']) ?: '' }}" name="q[usu_alta_id_cont]" id="q_usu_alta_id_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_usu_mod_id_gt">USU_MOD_ID</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['usu_mod_id_gt']) ?: '' }}" name="q[usu_mod_id_gt]" id="q_usu_mod_id_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['usu_mod_id_lt']) ?: '' }}" name="q[usu_mod_id_lt]" id="q_usu_mod_id_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_usu_mod_id_cont">USU_MOD_ID</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['usu_mod_id_cont']) ?: '' }}" name="q[usu_mod_id_cont]" id="q_usu_mod_id_cont" />
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-10 col-sm-offset-2">
                                    <input type="submit" name="commit" value="Buscar" class="btn btn-default btn-xs" />
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            @if($devolucionesCajas->count())
                <table class="table table-condensed table-striped">
                    <thead>
                        <tr>
                            <th>@include('plantillas.getOrderLink', ['column' => 'id', 'title' => 'ID'])</th>
                            <th>@include('CrudDscaffold::getOrderlink', ['column' => 'cajas.consecutivo', 'title' => 'CAJA CONSECUTIVO'])</th>
                            <th>@include('CrudDscaffold::getOrderlink', ['column' => 'plantels.razon', 'title' => 'PLANTEL'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'clientes.nombre', 'title' => 'CLIENTE NOMBRE'])</th>
                        
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'grados.name', 'title' => 'GRADO'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'caja_conceptos.name', 'title' => 'CONCEPTO'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'monto', 'title' => 'MONTO'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'motivos_dev_cajas.name', 'title' => 'MOTIVO'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'vobo', 'title' => 'VO.BO.'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'obs', 'title' => 'OBS.'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'usu_alta_id', 'title' => 'CREADO POR'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'st_dev_caja_id', 'title' => 'ESTATUS'])</th>
                        
                            <th class="text-right">OPCIONES</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($devolucionesCajas as $devolucionesCaja)
                            <tr>
                                <td><a href="{{ route('devolucionesCajas.show', $devolucionesCaja->id) }}">{{$devolucionesCaja->id}}</a></td>
                                <td>{{$devolucionesCaja->caja->consecutivo}}</td>
                                <td>{{$devolucionesCaja->plantel->razon}}</td>
                                <td>{{$devolucionesCaja->cliente_id}}-{{$devolucionesCaja->cliente->nombre}} {{$devolucionesCaja->cliente->nombre2}} {{$devolucionesCaja->cliente->ape_paterno}} {{$devolucionesCaja->cliente->ape_materno}}</td>
                                <td>{{$devolucionesCaja->grado->seccion}}-{{$devolucionesCaja->grado->name}}</td>
                                <td>{{$devolucionesCaja->cajaConcepto->name}}</td>
                    <td>{{$devolucionesCaja->monto}}</td>
                    <td>{{$devolucionesCaja->motivosDevCaja->name}}</td>
                    <td>{{$devolucionesCaja->vobo}}</td>
                    <td>{{$devolucionesCaja->obs}}</td>
                    <td>{{$devolucionesCaja->usu_alta->name}}</td>
                    <td>{{$devolucionesCaja->stDevCaja->name}}</td>
                                <td class="text-right">
                                    
                                    @permission('devolucionesCajas.edit')
                                    <a class="btn btn-xs btn-warning" href="{{ route('devolucionesCajas.edit', $devolucionesCaja->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                                    @endpermission
                                    @permission('devolucionesCajas.destroy')
                                    {!! Form::model($devolucionesCaja, array('route' => array('devolucionesCajas.destroy', $devolucionesCaja->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? ¿Esta seguro?')) { return true } else {return false };")) !!}
                                        <button type="submit" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i> Borrar</button>
                                    {!! Form::close() !!}
                                    @endpermission
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {!! $devolucionesCajas->appends(Request::except('page'))->render() !!}
            @else
                <h3 class="text-center alert alert-info">Vacio!</h3>
            @endif

        </div>
    </div>

@endsection