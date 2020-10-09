@extends('plantillas.admin_template')

@include('hCalificacions._common')

@section('header')

    <ol class="breadcrumb">
    	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
        <!--
        @if ( $query_params = Request::input('q') )

            <li class="active"><a href="{{ route('hCalificacions.index') }}">@yield('hCalificacionsAppTitle')</a></li>
            <li class="active">condition(  

            @foreach( $query_params as $key => $value )
                @if (!$loop->first) / @endif {{ $key }} : {{ $value }}
            @endforeach
            )</li>
        @else
            <li class="active">@yield('hCalificacionsAppTitle')</li>
        @endif
        -->
        <li class="active">@yield('hCalificacionsAppTitle')</li>
    </ol>

    <div class="">
        <h3>
            <i class="glyphicon glyphicon-align-justify"></i> @yield('hCalificacionsAppTitle')
            @permission('hCalificacions.create')
            <a class="btn btn-success pull-right" href="{{ route('hCalificacions.create') }}"><i class="glyphicon glyphicon-plus"></i> Crear</a>
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
                    <form class="HCalificacion_search" id="search" action="{{ route('hCalificacions.index') }}" accept-charset="UTF-8" method="get">
                        <input type="hidden" name="q[s]" value="{{ @(Request::input('q')['s']) ?: '' }}" />
                        <div class="form-horizontal">

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
                            
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_clientes.nombre_cont">CLIENTE_NOMBRE</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['clientes.nombre_cont']) ?: '' }}" name="q[clientes.nombre_cont]" id="q_clientes.nombre_cont" />
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_calificacions.calificacion_gt">CALIFICACION_CALIFICACION</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['calificacions.calificacion_gt']) ?: '' }}" name="q[calificacions.calificacion_gt]" id="q_calificacions.calificacion_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['calificacions.calificacion_lt']) ?: '' }}" name="q[calificacions.calificacion_lt]" id="q_calificacions.calificacion_lt" />
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_calificacions.calificacion_cont">CALIFICACION_CALIFICACION</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['calificacions.calificacion_cont']) ?: '' }}" name="q[calificacions.calificacion_cont]" id="q_calificacions.calificacion_cont" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_h_calificacions.calificacion_ponderacion_id_cont">CALIFICACION_PONDERACION</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['h_calificacions.calificacion_ponderacion_id_cont']) ?: '' }}" name="q[h_calificacions.calificacion_ponderacion_id_cont]" id="q_h_calificacions.calificacion_ponderacion_id_cont" />
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_carga_ponderacions.name_gt">CARGA_PONDERACION_NAME</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['carga_ponderacions.name_gt']) ?: '' }}" name="q[carga_ponderacions.name_gt]" id="q_carga_ponderacions.name_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['carga_ponderacions.name_lt']) ?: '' }}" name="q[carga_ponderacions.name_lt]" id="q_carga_ponderacions.name_lt" />
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_carga_ponderacions.name_cont">CARGA_PONDERACION_NAME</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['carga_ponderacions.name_cont']) ?: '' }}" name="q[carga_ponderacions.name_cont]" id="q_carga_ponderacions.name_cont" />
                                </div>
                            </div>
                                                    
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_calificacion_parcial_anterior_gt">CALIFICACION_PARCIAL_ANTERIOR</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['calificacion_parcial_anterior_gt']) ?: '' }}" name="q[calificacion_parcial_anterior_gt]" id="q_calificacion_parcial_anterior_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['calificacion_parcial_anterior_lt']) ?: '' }}" name="q[calificacion_parcial_anterior_lt]" id="q_calificacion_parcial_anterior_lt" />
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_calificacion_parcial_anterior_cont">CALIFICACION_PARCIAL_ANTERIOR</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['calificacion_parcial_anterior_cont']) ?: '' }}" name="q[calificacion_parcial_anterior_cont]" id="q_calificacion_parcial_anterior_cont" />
                                </div>
                            </div>
                                                    
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_calificacion_parcial_actual_gt">CALIFICACION_PARCIAL_ACTUAL</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['calificacion_parcial_actual_gt']) ?: '' }}" name="q[calificacion_parcial_actual_gt]" id="q_calificacion_parcial_actual_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['calificacion_parcial_actual_lt']) ?: '' }}" name="q[calificacion_parcial_actual_lt]" id="q_calificacion_parcial_actual_lt" />
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_calificacion_parcial_actual_cont">CALIFICACION_PARCIAL_ACTUAL</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['calificacion_parcial_actual_cont']) ?: '' }}" name="q[calificacion_parcial_actual_cont]" id="q_calificacion_parcial_actual_cont" />
                                </div>
                            </div>
                                  
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
                            
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_usu_alta_id_cont">USU_ALTA_ID</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['usu_alta_id_cont']) ?: '' }}" name="q[usu_alta_id_cont]" id="q_usu_alta_id_cont" />
                                </div>
                            </div>
                                                    
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
                            -->
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
            @if($hCalificacions->count())
                <table class="table table-condensed table-striped">
                    <thead>
                        <tr>
                            
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'carga_ponderacions.name', 'title' => 'CARGA PONDERACION'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'calificacion_parcial_anterior', 'title' => 'CALIFICACION ANTERIOR'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'calificacion_parcial_actual', 'title' => 'CALIFICACION ACTUAL'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'usu_alta_id', 'title' => 'ALTA'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'usu_mod_id', 'title' => 'U. MODIFICACION'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'created_at', 'title' => 'CREADA EL'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'updated_at', 'title' => 'ACTUALIZADA EL'])</th>
                            <th class="text-right">OPCIONES</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($hCalificacions as $hCalificacion)
                            <tr>
                            
                    <td>{{$hCalificacion->cargaPonderacion->name}}</td>
                    <td>{{$hCalificacion->calificacion_parcial_anterior}}</td>
                    <td>{{$hCalificacion->calificacion_parcial_actual}}</td>
                    <td>{{$hCalificacion->usu_alta->name}}</td>
                    <td>{{$hCalificacion->usu_mod->name}}</td>
                    <td>{{$hCalificacion->created_at}}</td>
                    <td>{{$hCalificacion->updated_at}}</td>
                                <td class="text-right">
                                    @permission('hCalificacions.edit')
                                    <a class="btn btn-xs btn-primary" href="{{ route('hCalificacions.duplicate', $hCalificacion->id) }}"><i class="glyphicon glyphicon-duplicate"></i> Duplicate</a>
                                    @endpermission
                                    @permission('hCalificacions.edit')
                                    <a class="btn btn-xs btn-warning" href="{{ route('hCalificacions.edit', $hCalificacion->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                                    @endpermission
                                    @permission('hCalificacions.destroy')
                                    {!! Form::model($hCalificacion, array('route' => array('hCalificacions.destroy', $hCalificacion->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? ¿Esta seguro?')) { return true } else {return false };")) !!}
                                        <button type="submit" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i> Borrar</button>
                                    {!! Form::close() !!}
                                    @endpermission
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {!! $hCalificacions->appends(Request::except('page'))->render() !!}
            @else
                <h3 class="text-center alert alert-info">Vacio!</h3>
            @endif

        </div>
    </div>

@endsection