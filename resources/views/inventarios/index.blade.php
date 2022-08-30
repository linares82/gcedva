@extends('plantillas.admin_template')

@include('inventarios._common')

@section('header')

    <ol class="breadcrumb">
    	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
        <!--
        @if ( $query_params = Request::input('q') )

            <li class="active"><a href="{{ route('inventarios.index') }}">@yield('inventariosAppTitle')</a></li>
            <li class="active">condition(  

            @foreach( $query_params as $key => $value )
                @if (!$loop->first) / @endif {{ $key }} : {{ $value }}
            @endforeach
            )</li>
        @else
            <li class="active">@yield('inventariosAppTitle')</li>
        @endif
        -->
        <li class="active">@yield('inventariosAppTitle')</li>
    </ol>

    <div class="">
        <h3>
            <i class="glyphicon glyphicon-align-justify"></i> @yield('inventariosAppTitle')
            @permission('inventarios.create')
            <a class="btn btn-success pull-right" href="{{ route('inventarios.create') }}"><i class="glyphicon glyphicon-plus"></i> Crear</a>
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
                    <form class="Inventario_search" id="search" action="{{ route('inventarios.index') }}" accept-charset="UTF-8" method="get">
                        <input type="hidden" name="q[s]" value="{{ @(Request::input('q')['s']) ?: '' }}" />
                        <div class="form-horizontal">

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
                                <label class="col-sm-2 control-label" for="q_area_gt">AREA</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['area_gt']) ?: '' }}" name="q[area_gt]" id="q_area_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['area_lt']) ?: '' }}" name="q[area_lt]" id="q_area_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_area_cont">AREA</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['area_cont']) ?: '' }}" name="q[area_cont]" id="q_area_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_escuela_gt">ESCUELA</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['escuela_gt']) ?: '' }}" name="q[escuela_gt]" id="q_escuela_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['escuela_lt']) ?: '' }}" name="q[escuela_lt]" id="q_escuela_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_escuela_cont">ESCUELA</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['escuela_cont']) ?: '' }}" name="q[escuela_cont]" id="q_escuela_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_tipo_inventario_gt">TIPO_INVENTARIO</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['tipo_inventario_gt']) ?: '' }}" name="q[tipo_inventario_gt]" id="q_tipo_inventario_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['tipo_inventario_lt']) ?: '' }}" name="q[tipo_inventario_lt]" id="q_tipo_inventario_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_tipo_inventario_cont">TIPO_INVENTARIO</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['tipo_inventario_cont']) ?: '' }}" name="q[tipo_inventario_cont]" id="q_tipo_inventario_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_ubicacion_gt">UBICACION</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['ubicacion_gt']) ?: '' }}" name="q[ubicacion_gt]" id="q_ubicacion_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['ubicacion_lt']) ?: '' }}" name="q[ubicacion_lt]" id="q_ubicacion_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_ubicacion_cont">UBICACION</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['ubicacion_cont']) ?: '' }}" name="q[ubicacion_cont]" id="q_ubicacion_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_cantidad_gt">CANTIDAD</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['cantidad_gt']) ?: '' }}" name="q[cantidad_gt]" id="q_cantidad_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['cantidad_lt']) ?: '' }}" name="q[cantidad_lt]" id="q_cantidad_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_cantidad_cont">CANTIDAD</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['cantidad_cont']) ?: '' }}" name="q[cantidad_cont]" id="q_cantidad_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_nombre_gt">NOMBRE</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['nombre_gt']) ?: '' }}" name="q[nombre_gt]" id="q_nombre_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['nombre_lt']) ?: '' }}" name="q[nombre_lt]" id="q_nombre_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_nombre_cont">NOMBRE</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['nombre_cont']) ?: '' }}" name="q[nombre_cont]" id="q_nombre_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_medida_gt">MEDIDA</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['medida_gt']) ?: '' }}" name="q[medida_gt]" id="q_medida_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['medida_lt']) ?: '' }}" name="q[medida_lt]" id="q_medida_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_medida_cont">MEDIDA</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['medida_cont']) ?: '' }}" name="q[medida_cont]" id="q_medida_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_marca_gt">MARCA</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['marca_gt']) ?: '' }}" name="q[marca_gt]" id="q_marca_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['marca_lt']) ?: '' }}" name="q[marca_lt]" id="q_marca_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_marca_cont">MARCA</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['marca_cont']) ?: '' }}" name="q[marca_cont]" id="q_marca_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_observaciones_gt">OBSERVACIONES</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['observaciones_gt']) ?: '' }}" name="q[observaciones_gt]" id="q_observaciones_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['observaciones_lt']) ?: '' }}" name="q[observaciones_lt]" id="q_observaciones_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_observaciones_cont">OBSERVACIONES</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['observaciones_cont']) ?: '' }}" name="q[observaciones_cont]" id="q_observaciones_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_existe_si_gt">EXISTE_SI</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['existe_si_gt']) ?: '' }}" name="q[existe_si_gt]" id="q_existe_si_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['existe_si_lt']) ?: '' }}" name="q[existe_si_lt]" id="q_existe_si_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_existe_si_cont">EXISTE_SI</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['existe_si_cont']) ?: '' }}" name="q[existe_si_cont]" id="q_existe_si_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_existe_no_gt">EXISTE_NO</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['existe_no_gt']) ?: '' }}" name="q[existe_no_gt]" id="q_existe_no_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['existe_no_lt']) ?: '' }}" name="q[existe_no_lt]" id="q_existe_no_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_existe_no_cont">EXISTE_NO</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['existe_no_cont']) ?: '' }}" name="q[existe_no_cont]" id="q_existe_no_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_estado_bueno_gt">ESTADO_BUENO</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['estado_bueno_gt']) ?: '' }}" name="q[estado_bueno_gt]" id="q_estado_bueno_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['estado_bueno_lt']) ?: '' }}" name="q[estado_bueno_lt]" id="q_estado_bueno_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_estado_bueno_cont">ESTADO_BUENO</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['estado_bueno_cont']) ?: '' }}" name="q[estado_bueno_cont]" id="q_estado_bueno_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_estado_malo_gt">ESTADO_MALO</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['estado_malo_gt']) ?: '' }}" name="q[estado_malo_gt]" id="q_estado_malo_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['estado_malo_lt']) ?: '' }}" name="q[estado_malo_lt]" id="q_estado_malo_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_estado_malo_cont">ESTADO_MALO</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['estado_malo_cont']) ?: '' }}" name="q[estado_malo_cont]" id="q_estado_malo_cont" />
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
            @if($inventarios->count())
                <table class="table table-condensed table-striped">
                    <thead>
                        <tr>
                            <th>@include('plantillas.getOrderLink', ['column' => 'id', 'title' => 'ID'])</th>
                            <th>@include('CrudDscaffold::getOrderlink', ['column' => 'plantels.razon', 'title' => 'PLANTEL_RAZON'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'area', 'title' => 'AREA'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'escuela', 'title' => 'ESCUELA'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'tipo_inventario', 'title' => 'TIPO_INVENTARIO'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'ubicacion', 'title' => 'UBICACION'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'cantidad', 'title' => 'CANTIDAD'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'nombre', 'title' => 'NOMBRE'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'medida', 'title' => 'MEDIDA'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'marca', 'title' => 'MARCA'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'observaciones', 'title' => 'OBSERVACIONES'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'existe_si', 'title' => 'EXISTE_SI'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'existe_no', 'title' => 'EXISTE_NO'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'estado_bueno', 'title' => 'ESTADO_BUENO'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'estado_malo', 'title' => 'ESTADO_MALO'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'usu_alta_id', 'title' => 'USU_ALTA_ID'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'usu_mod_id', 'title' => 'USU_MOD_ID'])</th>
                            <th class="text-right">OPCIONES</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($inventarios as $inventario)
                            <tr>
                                <td><a href="{{ route('inventarios.show', $inventario->id) }}">{{$inventario->id}}</a></td>
                                <td>{{$inventario->plantel->razon}}</td>
                    <td>{{$inventario->area}}</td>
                    <td>{{$inventario->escuela}}</td>
                    <td>{{$inventario->tipo_inventario}}</td>
                    <td>{{$inventario->ubicacion}}</td>
                    <td>{{$inventario->cantidad}}</td>
                    <td>{{$inventario->nombre}}</td>
                    <td>{{$inventario->medida}}</td>
                    <td>{{$inventario->marca}}</td>
                    <td>{{$inventario->observaciones}}</td>
                    <td>{{$inventario->existe_si}}</td>
                    <td>{{$inventario->existe_no}}</td>
                    <td>{{$inventario->estado_bueno}}</td>
                    <td>{{$inventario->estado_malo}}</td>
                    <td>{{$inventario->usu_alta_id}}</td>
                    <td>{{$inventario->usu_mod_id}}</td>
                                <td class="text-right">
                                    @permission('inventarios.edit')
                                    <a class="btn btn-xs btn-primary" href="{{ route('inventarios.duplicate', $inventario->id) }}"><i class="glyphicon glyphicon-duplicate"></i> Duplicate</a>
                                    @endpermission
                                    @permission('inventarios.edit')
                                    <a class="btn btn-xs btn-warning" href="{{ route('inventarios.edit', $inventario->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                                    @endpermission
                                    @permission('inventarios.destroy')
                                    {!! Form::model($inventario, array('route' => array('inventarios.destroy', $inventario->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? ¿Esta seguro?')) { return true } else {return false };")) !!}
                                        <button type="submit" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i> Borrar</button>
                                    {!! Form::close() !!}
                                    @endpermission
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {!! $inventarios->appends(Request::except('page'))->render() !!}
            @else
                <h3 class="text-center alert alert-info">Vacio!</h3>
            @endif

        </div>
    </div>

@endsection