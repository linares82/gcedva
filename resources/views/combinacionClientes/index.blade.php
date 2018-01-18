@extends('plantillas.admin_template')

@include('combinacionClientes._common')

@section('header')

    <ol class="breadcrumb">
    	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
        <!--
        @if ( $query_params = Request::input('q') )

            <li class="active"><a href="{{ route('combinacionClientes.index') }}">@yield('combinacionClientesAppTitle')</a></li>
            <li class="active">condition(  

            @foreach( $query_params as $key => $value )
                @if (!$loop->first) / @endif {{ $key }} : {{ $value }}
            @endforeach
            )</li>
        @else
            <li class="active">@yield('combinacionClientesAppTitle')</li>
        @endif
        -->
        <li class="active">@yield('combinacionClientesAppTitle')</li>
    </ol>

    <div class="">
        <h3>
            <i class="glyphicon glyphicon-align-justify"></i> @yield('combinacionClientesAppTitle')
            @permission('combinacionClientes.create')
            <a class="btn btn-success pull-right" href="{{ route('combinacionClientes.create') }}"><i class="glyphicon glyphicon-plus"></i> Crear</a>
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
                    <form class="CombinacionCliente_search" id="search" action="{{ route('combinacionClientes.index') }}" accept-charset="UTF-8" method="get">
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
                                <label class="col-sm-2 control-label" for="q_especialidad_id_gt">ESPECIALIDAD_ID</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['especialidad_id_gt']) ?: '' }}" name="q[especialidad_id_gt]" id="q_especialidad_id_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['especialidad_id_lt']) ?: '' }}" name="q[especialidad_id_lt]" id="q_especialidad_id_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_especialidad_id_cont">ESPECIALIDAD_ID</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['especialidad_id_cont']) ?: '' }}" name="q[especialidad_id_cont]" id="q_especialidad_id_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_nivel_id_gt">NIVEL_ID</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['nivel_id_gt']) ?: '' }}" name="q[nivel_id_gt]" id="q_nivel_id_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['nivel_id_lt']) ?: '' }}" name="q[nivel_id_lt]" id="q_nivel_id_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_nivel_id_cont">NIVEL_ID</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['nivel_id_cont']) ?: '' }}" name="q[nivel_id_cont]" id="q_nivel_id_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_grado_id_gt">GRADO_ID</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['grado_id_gt']) ?: '' }}" name="q[grado_id_gt]" id="q_grado_id_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['grado_id_lt']) ?: '' }}" name="q[grado_id_lt]" id="q_grado_id_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_grado_id_cont">GRADO_ID</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['grado_id_cont']) ?: '' }}" name="q[grado_id_cont]" id="q_grado_id_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_turno_id_gt">TURNO_ID</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['turno_id_gt']) ?: '' }}" name="q[turno_id_gt]" id="q_turno_id_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['turno_id_lt']) ?: '' }}" name="q[turno_id_lt]" id="q_turno_id_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_turno_id_cont">TURNO_ID</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['turno_id_cont']) ?: '' }}" name="q[turno_id_cont]" id="q_turno_id_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_bnd_inscrito_gt">BND_INSCRITO</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['bnd_inscrito_gt']) ?: '' }}" name="q[bnd_inscrito_gt]" id="q_bnd_inscrito_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['bnd_inscrito_lt']) ?: '' }}" name="q[bnd_inscrito_lt]" id="q_bnd_inscrito_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_bnd_inscrito_cont">BND_INSCRITO</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['bnd_inscrito_cont']) ?: '' }}" name="q[bnd_inscrito_cont]" id="q_bnd_inscrito_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_fec_inscrito_gt">FEC_INSCRITO</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['fec_inscrito_gt']) ?: '' }}" name="q[fec_inscrito_gt]" id="q_fec_inscrito_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['fec_inscrito_lt']) ?: '' }}" name="q[fec_inscrito_lt]" id="q_fec_inscrito_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_fec_inscrito_cont">FEC_INSCRITO</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['fec_inscrito_cont']) ?: '' }}" name="q[fec_inscrito_cont]" id="q_fec_inscrito_cont" />
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
            @if($combinacionClientes->count())
                <table class="table table-condensed table-striped">
                    <thead>
                        <tr>
                            <th>@include('plantillas.getOrderLink', ['column' => 'id', 'title' => 'ID'])</th>
                            <th>@include('CrudDscaffold::getOrderlink', ['column' => 'clientes.nombre', 'title' => 'CLIENTE_NOMBRE'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'plantels.razon', 'title' => 'PLANTEL_RAZON'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'especialidad_id', 'title' => 'ESPECIALIDAD_ID'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'nivel_id', 'title' => 'NIVEL_ID'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'grado_id', 'title' => 'GRADO_ID'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'turno_id', 'title' => 'TURNO_ID'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'bnd_inscrito', 'title' => 'BND_INSCRITO'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'fec_inscrito', 'title' => 'FEC_INSCRITO'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'usu_alta_id', 'title' => 'USU_ALTA_ID'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'usu_mod_id', 'title' => 'USU_MOD_ID'])</th>
                            <th class="text-right">OPCIONES</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($combinacionClientes as $combinacionCliente)
                            <tr>
                                <td><a href="{{ route('combinacionClientes.show', $combinacionCliente->id) }}">{{$combinacionCliente->id}}</a></td>
                                <td>{{$combinacionCliente->cliente->nombre}}</td>
                    <td>{{$combinacionCliente->plantel->razon}}</td>
                    <td>{{$combinacionCliente->especialidad_id}}</td>
                    <td>{{$combinacionCliente->nivel_id}}</td>
                    <td>{{$combinacionCliente->grado_id}}</td>
                    <td>{{$combinacionCliente->turno_id}}</td>
                    <td>{{$combinacionCliente->bnd_inscrito}}</td>
                    <td>{{$combinacionCliente->fec_inscrito}}</td>
                    <td>{{$combinacionCliente->usu_alta_id}}</td>
                    <td>{{$combinacionCliente->usu_mod_id}}</td>
                                <td class="text-right">
                                    @permission('combinacionClientes.edit')
                                    <a class="btn btn-xs btn-primary" href="{{ route('combinacionClientes.duplicate', $combinacionCliente->id) }}"><i class="glyphicon glyphicon-duplicate"></i> Duplicate</a>
                                    @endpermission
                                    @permission('combinacionClientes.edit')
                                    <a class="btn btn-xs btn-warning" href="{{ route('combinacionClientes.edit', $combinacionCliente->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                                    @endpermission
                                    @permission('combinacionClientes.destroy')
                                    {!! Form::model($combinacionCliente, array('route' => array('combinacionClientes.destroy', $combinacionCliente->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? ¿Esta seguro?')) { return true } else {return false };")) !!}
                                        <button type="submit" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i> Borrar</button>
                                    {!! Form::close() !!}
                                    @endpermission
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {!! $combinacionClientes->appends(Request::except('page'))->render() !!}
            @else
                <h3 class="text-center alert alert-info">Vacio!</h3>
            @endif

        </div>
    </div>

@endsection