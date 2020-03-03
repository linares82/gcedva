@extends('plantillas.admin_template')

@include('hCalifPonderacions._common')

@section('header')

    <ol class="breadcrumb">
    	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
        <!--
        @if ( $query_params = Request::input('q') )

            <li class="active"><a href="{{ route('hCalifPonderacions.index') }}">@yield('hCalifPonderacionsAppTitle')</a></li>
            <li class="active">condition(  

            @foreach( $query_params as $key => $value )
                @if (!$loop->first) / @endif {{ $key }} : {{ $value }}
            @endforeach
            )</li>
        @else
            <li class="active">@yield('hCalifPonderacionsAppTitle')</li>
        @endif
        -->
        <li class="active">@yield('hCalifPonderacionsAppTitle')</li>
    </ol>

    <div class="">
        <h3>
            <i class="glyphicon glyphicon-align-justify"></i> @yield('hCalifPonderacionsAppTitle')
            @permission('hCalifPonderacions.create')
            <a class="btn btn-success pull-right" href="{{ route('hCalifPonderacions.create') }}"><i class="glyphicon glyphicon-plus"></i> Crear</a>
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
                    <form class="HCalifPonderacion_search" id="search" action="{{ route('hCalifPonderacions.index') }}" accept-charset="UTF-8" method="get">
                        <input type="hidden" name="q[s]" value="{{ @(Request::input('q')['s']) ?: '' }}" />
                        <div class="form-horizontal">

                            <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_calificacion_ponderacion_id_gt">CALIFICACION_PONDERACION_ID</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['calificacion_ponderacion_id_gt']) ?: '' }}" name="q[calificacion_ponderacion_id_gt]" id="q_calificacion_ponderacion_id_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['calificacion_ponderacion_id_lt']) ?: '' }}" name="q[calificacion_ponderacion_id_lt]" id="q_calificacion_ponderacion_id_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_calificacion_ponderacion_id_cont">CALIFICACION_PONDERACION_ID</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['calificacion_ponderacion_id_cont']) ?: '' }}" name="q[calificacion_ponderacion_id_cont]" id="q_calificacion_ponderacion_id_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_calificacion_id_gt">CALIFICACION_ID</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['calificacion_id_gt']) ?: '' }}" name="q[calificacion_id_gt]" id="q_calificacion_id_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['calificacion_id_lt']) ?: '' }}" name="q[calificacion_id_lt]" id="q_calificacion_id_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_calificacion_id_cont">CALIFICACION_ID</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['calificacion_id_cont']) ?: '' }}" name="q[calificacion_id_cont]" id="q_calificacion_id_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_carga_pondercaion_id_gt">CARGA_PONDERCAION_ID</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['carga_pondercaion_id_gt']) ?: '' }}" name="q[carga_pondercaion_id_gt]" id="q_carga_pondercaion_id_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['carga_pondercaion_id_lt']) ?: '' }}" name="q[carga_pondercaion_id_lt]" id="q_carga_pondercaion_id_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_carga_pondercaion_id_cont">CARGA_PONDERCAION_ID</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['carga_pondercaion_id_cont']) ?: '' }}" name="q[carga_pondercaion_id_cont]" id="q_carga_pondercaion_id_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_calificacion_parcial_gt">CALIFICACION_PARCIAL</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['calificacion_parcial_gt']) ?: '' }}" name="q[calificacion_parcial_gt]" id="q_calificacion_parcial_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['calificacion_parcial_lt']) ?: '' }}" name="q[calificacion_parcial_lt]" id="q_calificacion_parcial_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_calificacion_parcial_cont">CALIFICACION_PARCIAL</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['calificacion_parcial_cont']) ?: '' }}" name="q[calificacion_parcial_cont]" id="q_calificacion_parcial_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_calificacon_parcial_calculada_gt">CALIFICACON_PARCIAL_CALCULADA</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['calificacon_parcial_calculada_gt']) ?: '' }}" name="q[calificacon_parcial_calculada_gt]" id="q_calificacon_parcial_calculada_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['calificacon_parcial_calculada_lt']) ?: '' }}" name="q[calificacon_parcial_calculada_lt]" id="q_calificacon_parcial_calculada_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_calificacon_parcial_calculada_cont">CALIFICACON_PARCIAL_CALCULADA</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['calificacon_parcial_calculada_cont']) ?: '' }}" name="q[calificacon_parcial_calculada_cont]" id="q_calificacon_parcial_calculada_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_ponderacion_gt">PONDERACION</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['ponderacion_gt']) ?: '' }}" name="q[ponderacion_gt]" id="q_ponderacion_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['ponderacion_lt']) ?: '' }}" name="q[ponderacion_lt]" id="q_ponderacion_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_ponderacion_cont">PONDERACION</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['ponderacion_cont']) ?: '' }}" name="q[ponderacion_cont]" id="q_ponderacion_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_tiene_detalle_gt">TIENE_DETALLE</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['tiene_detalle_gt']) ?: '' }}" name="q[tiene_detalle_gt]" id="q_tiene_detalle_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['tiene_detalle_lt']) ?: '' }}" name="q[tiene_detalle_lt]" id="q_tiene_detalle_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_tiene_detalle_cont">TIENE_DETALLE</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['tiene_detalle_cont']) ?: '' }}" name="q[tiene_detalle_cont]" id="q_tiene_detalle_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_padre_id_gt">PADRE_ID</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['padre_id_gt']) ?: '' }}" name="q[padre_id_gt]" id="q_padre_id_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['padre_id_lt']) ?: '' }}" name="q[padre_id_lt]" id="q_padre_id_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_padre_id_cont">PADRE_ID</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['padre_id_cont']) ?: '' }}" name="q[padre_id_cont]" id="q_padre_id_cont" />
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
            @if($hCalifPonderacions->count())
                <table class="table table-condensed table-striped">
                    <thead>
                        <tr>
                            <th>@include('plantillas.getOrderLink', ['column' => 'id', 'title' => 'ID'])</th>
                            <th>@include('CrudDscaffold::getOrderlink', ['column' => 'calificacion_ponderacion_id', 'title' => 'CALIFICACION_PONDERACION_ID'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'calificacion_id', 'title' => 'CALIFICACION_ID'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'carga_pondercaion_id', 'title' => 'CARGA_PONDERCAION_ID'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'calificacion_parcial', 'title' => 'CALIFICACION_PARCIAL'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'calificacon_parcial_calculada', 'title' => 'CALIFICACON_PARCIAL_CALCULADA'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'ponderacion', 'title' => 'PONDERACION'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'tiene_detalle', 'title' => 'TIENE_DETALLE'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'padre_id', 'title' => 'PADRE_ID'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'usu_alta_id', 'title' => 'USU_ALTA_ID'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'usu_mod_id', 'title' => 'USU_MOD_ID'])</th>
                            <th class="text-right">OPCIONES</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($hCalifPonderacions as $hCalifPonderacion)
                            <tr>
                                <td><a href="{{ route('hCalifPonderacions.show', $hCalifPonderacion->id) }}">{{$hCalifPonderacion->id}}</a></td>
                                <td>{{$hCalifPonderacion->calificacion_ponderacion_id}}</td>
                    <td>{{$hCalifPonderacion->calificacion_id}}</td>
                    <td>{{$hCalifPonderacion->carga_pondercaion_id}}</td>
                    <td>{{$hCalifPonderacion->calificacion_parcial}}</td>
                    <td>{{$hCalifPonderacion->calificacon_parcial_calculada}}</td>
                    <td>{{$hCalifPonderacion->ponderacion}}</td>
                    <td>{{$hCalifPonderacion->tiene_detalle}}</td>
                    <td>{{$hCalifPonderacion->padre_id}}</td>
                    <td>{{$hCalifPonderacion->usu_alta_id}}</td>
                    <td>{{$hCalifPonderacion->usu_mod_id}}</td>
                                <td class="text-right">
                                    @permission('hCalifPonderacions.edit')
                                    <a class="btn btn-xs btn-primary" href="{{ route('hCalifPonderacions.duplicate', $hCalifPonderacion->id) }}"><i class="glyphicon glyphicon-duplicate"></i> Duplicate</a>
                                    @endpermission
                                    @permission('hCalifPonderacions.edit')
                                    <a class="btn btn-xs btn-warning" href="{{ route('hCalifPonderacions.edit', $hCalifPonderacion->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                                    @endpermission
                                    @permission('hCalifPonderacions.destroy')
                                    {!! Form::model($hCalifPonderacion, array('route' => array('hCalifPonderacions.destroy', $hCalifPonderacion->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? ¿Esta seguro?')) { return true } else {return false };")) !!}
                                        <button type="submit" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i> Borrar</button>
                                    {!! Form::close() !!}
                                    @endpermission
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {!! $hCalifPonderacions->appends(Request::except('page'))->render() !!}
            @else
                <h3 class="text-center alert alert-info">Vacio!</h3>
            @endif

        </div>
    </div>

@endsection