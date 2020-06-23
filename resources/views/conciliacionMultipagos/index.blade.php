@extends('plantillas.admin_template')

@include('conciliacionMultipagos._common')

@section('header')

    <ol class="breadcrumb">
    	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
        <!--
        @if ( $query_params = Request::input('q') )

            <li class="active"><a href="{{ route('conciliacionMultipagos.index') }}">@yield('conciliacionMultipagosAppTitle')</a></li>
            <li class="active">condition(  

            @foreach( $query_params as $key => $value )
                @if (!$loop->first) / @endif {{ $key }} : {{ $value }}
            @endforeach
            )</li>
        @else
            <li class="active">@yield('conciliacionMultipagosAppTitle')</li>
        @endif
        -->
        <li class="active">@yield('conciliacionMultipagosAppTitle')</li>
    </ol>

    <div class="">
        <h3>
            <i class="glyphicon glyphicon-align-justify"></i> @yield('conciliacionMultipagosAppTitle')
            @permission('conciliacionMultipagos.create')
            <a class="btn btn-success pull-right" href="{{ route('conciliacionMultipagos.create') }}"><i class="glyphicon glyphicon-plus"></i> Crear</a>
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
                    <form class="ConciliacionMultipago_search" id="search" action="{{ route('conciliacionMultipagos.index') }}" accept-charset="UTF-8" method="get">
                        <input type="hidden" name="q[s]" value="{{ @(Request::input('q')['s']) ?: '' }}" />
                        <div class="form-horizontal">

                            <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_fecha_carga_gt">FECHA_CARGA</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['fecha_carga_gt']) ?: '' }}" name="q[fecha_carga_gt]" id="q_fecha_carga_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['fecha_carga_lt']) ?: '' }}" name="q[fecha_carga_lt]" id="q_fecha_carga_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_fecha_carga_cont">FECHA_CARGA</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['fecha_carga_cont']) ?: '' }}" name="q[fecha_carga_cont]" id="q_fecha_carga_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_archivo_gt">ARCHIVO</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['archivo_gt']) ?: '' }}" name="q[archivo_gt]" id="q_archivo_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['archivo_lt']) ?: '' }}" name="q[archivo_lt]" id="q_archivo_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_archivo_cont">ARCHIVO</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['archivo_cont']) ?: '' }}" name="q[archivo_cont]" id="q_archivo_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_registros_gt">REGISTROS</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['registros_gt']) ?: '' }}" name="q[registros_gt]" id="q_registros_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['registros_lt']) ?: '' }}" name="q[registros_lt]" id="q_registros_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_registros_cont">REGISTROS</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['registros_cont']) ?: '' }}" name="q[registros_cont]" id="q_registros_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_contador_ejecucion_gt">CONTADOR_EJECUCION</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['contador_ejecucion_gt']) ?: '' }}" name="q[contador_ejecucion_gt]" id="q_contador_ejecucion_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['contador_ejecucion_lt']) ?: '' }}" name="q[contador_ejecucion_lt]" id="q_contador_ejecucion_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_contador_ejecucion_cont">CONTADOR_EJECUCION</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['contador_ejecucion_cont']) ?: '' }}" name="q[contador_ejecucion_cont]" id="q_contador_ejecucion_cont" />
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
            @if($conciliacionMultipagos->count())
                <table class="table table-condensed table-striped">
                    <thead>
                        <tr>
                            <th>@include('plantillas.getOrderLink', ['column' => 'id', 'title' => 'ID'])</th>
                            <th>@include('CrudDscaffold::getOrderlink', ['column' => 'fecha_carga', 'title' => 'F. CARGA'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'archivo', 'title' => 'ARCHIVO'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'registros', 'title' => 'REGISTROS'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'contador_ejecucion', 'title' => 'CONTADOR EJECUCION'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'usu_alta_id', 'title' => 'ALTA'])</th>
                            <th class="text-right">OPCIONES</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($conciliacionMultipagos as $conciliacionMultipago)
                            <tr>
                                <td>{{$conciliacionMultipago->id}}</td>
                                <td>{{$conciliacionMultipago->fecha_carga}}</td>
                    <td>{{$conciliacionMultipago->archivo}}</td>
                    <td>{{$conciliacionMultipago->registros}}</td>
                    <td>{{$conciliacionMultipago->contador_ejecucion}}</td>
                    <td>{{$conciliacionMultipago->usu_alta->name}}</td>
                                <td class="text-right">
                                    @permission('conciliacionMultipagos.ejecutarConciliacion')
                                    <a class="btn btn-xs btn-primary" href="{{ route('conciliacionMultipagos.ejecutarConciliacion', array('id'=>$conciliacionMultipago->id)) }}"><i class="glyphicon glyphicon-check"></i> Ejecutar</a>
                                    @endpermission
                                    @permission('conciliacionMultipagos.edit')
                                    <a class="btn btn-xs btn-primary" href="{{ route('conciliacionMultipagos.duplicate', $conciliacionMultipago->id) }}"><i class="glyphicon glyphicon-duplicate"></i> Duplicate</a>
                                    @endpermission
                                    @permission('conciliacionMultipagos.edit')
                                    <a class="btn btn-xs btn-warning" href="{{ route('conciliacionMultipagos.edit', $conciliacionMultipago->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                                    @endpermission
                                    @permission('conciliacionMultipagos.destroy')
                                    {!! Form::model($conciliacionMultipago, array('route' => array('conciliacionMultipagos.destroy', $conciliacionMultipago->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? ¿Esta seguro?')) { return true } else {return false };")) !!}
                                        <button type="submit" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i> Borrar</button>
                                    {!! Form::close() !!}
                                    @endpermission
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {!! $conciliacionMultipagos->appends(Request::except('page'))->render() !!}
            @else
                <h3 class="text-center alert alert-info">Vacio!</h3>
            @endif

        </div>
    </div>

@endsection