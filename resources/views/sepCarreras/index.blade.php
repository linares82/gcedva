@extends('plantillas.admin_template')

@include('sepCarreras._common')

@section('header')

    <ol class="breadcrumb">
    	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
        <!--
        @if ( $query_params = Request::input('q') )

            <li class="active"><a href="{{ route('sepCarreras.index') }}">@yield('sepCarrerasAppTitle')</a></li>
            <li class="active">condition(  

            @foreach( $query_params as $key => $value )
                @if (!$loop->first) / @endif {{ $key }} : {{ $value }}
            @endforeach
            )</li>
        @else
            <li class="active">@yield('sepCarrerasAppTitle')</li>
        @endif
        -->
        <li class="active">@yield('sepCarrerasAppTitle')</li>
    </ol>

    <div class="">
        <h3>
            <i class="glyphicon glyphicon-align-justify"></i> @yield('sepCarrerasAppTitle')
            @permission('sepCarreras.create')
            <a class="btn btn-success pull-right" href="{{ route('sepCarreras.create') }}"><i class="glyphicon glyphicon-plus"></i> Crear</a>
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
                    <form class="SepCarrera_search" id="search" action="{{ route('sepCarreras.index') }}" accept-charset="UTF-8" method="get">
                        <input type="hidden" name="q[s]" value="{{ @(Request::input('q')['s']) ?: '' }}" />
                        <div class="form-horizontal">

                            <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_cve_carrera_gt">CVE_CARRERA</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['cve_carrera_gt']) ?: '' }}" name="q[cve_carrera_gt]" id="q_cve_carrera_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['cve_carrera_lt']) ?: '' }}" name="q[cve_carrera_lt]" id="q_cve_carrera_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_cve_carrera_cont">CVE_CARRERA</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['cve_carrera_cont']) ?: '' }}" name="q[cve_carrera_cont]" id="q_cve_carrera_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_descripcion_gt">DESCRIPCION</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['descripcion_gt']) ?: '' }}" name="q[descripcion_gt]" id="q_descripcion_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['descripcion_lt']) ?: '' }}" name="q[descripcion_lt]" id="q_descripcion_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_descripcion_cont">DESCRIPCION</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['descripcion_cont']) ?: '' }}" name="q[descripcion_cont]" id="q_descripcion_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_id_area_gt">ID_AREA</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['id_area_gt']) ?: '' }}" name="q[id_area_gt]" id="q_id_area_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['id_area_lt']) ?: '' }}" name="q[id_area_lt]" id="q_id_area_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_id_area_cont">ID_AREA</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['id_area_cont']) ?: '' }}" name="q[id_area_cont]" id="q_id_area_cont" />
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
                                <label class="col-sm-2 control-label" for="q_cve_subarea_gt">CVE_SUBAREA</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['cve_subarea_gt']) ?: '' }}" name="q[cve_subarea_gt]" id="q_cve_subarea_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['cve_subarea_lt']) ?: '' }}" name="q[cve_subarea_lt]" id="q_cve_subarea_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_cve_subarea_cont">CVE_SUBAREA</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['cve_subarea_cont']) ?: '' }}" name="q[cve_subarea_cont]" id="q_cve_subarea_cont" />
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
                                <label class="col-sm-2 control-label" for="q_id_nivel_sirep_gt">ID_NIVEL_SIREP</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['id_nivel_sirep_gt']) ?: '' }}" name="q[id_nivel_sirep_gt]" id="q_id_nivel_sirep_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['id_nivel_sirep_lt']) ?: '' }}" name="q[id_nivel_sirep_lt]" id="q_id_nivel_sirep_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_id_nivel_sirep_cont">ID_NIVEL_SIREP</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['id_nivel_sirep_cont']) ?: '' }}" name="q[id_nivel_sirep_cont]" id="q_id_nivel_sirep_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_nivel_educativo_gt">NIVEL_EDUCATIVO</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['nivel_educativo_gt']) ?: '' }}" name="q[nivel_educativo_gt]" id="q_nivel_educativo_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['nivel_educativo_lt']) ?: '' }}" name="q[nivel_educativo_lt]" id="q_nivel_educativo_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_nivel_educativo_cont">NIVEL_EDUCATIVO</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['nivel_educativo_cont']) ?: '' }}" name="q[nivel_educativo_cont]" id="q_nivel_educativo_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_num_rvoe_gt">NUM_RVOE</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['num_rvoe_gt']) ?: '' }}" name="q[num_rvoe_gt]" id="q_num_rvoe_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['num_rvoe_lt']) ?: '' }}" name="q[num_rvoe_lt]" id="q_num_rvoe_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_num_rvoe_cont">NUM_RVOE</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['num_rvoe_cont']) ?: '' }}" name="q[num_rvoe_cont]" id="q_num_rvoe_cont" />
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
            @if($sepCarreras->count())
                <table class="table table-condensed table-striped">
                    <thead>
                        <tr>
                            <th>@include('plantillas.getOrderLink', ['column' => 'id', 'title' => 'ID'])</th>
                            <th>@include('CrudDscaffold::getOrderlink', ['column' => 'cve_carrera', 'title' => 'CVE_CARRERA'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'descripcion', 'title' => 'DESCRIPCION'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'id_area', 'title' => 'ID_AREA'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'area', 'title' => 'AREA'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'cve_subarea', 'title' => 'CVE_SUBAREA'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'area', 'title' => 'AREA'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'id_nivel_sirep', 'title' => 'ID_NIVEL_SIREP'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'nivel_educativo', 'title' => 'NIVEL_EDUCATIVO'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'num_rvoe', 'title' => 'NUM_RVOE'])</th>
                            <th class="text-right">OPCIONES</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($sepCarreras as $sepCarrera)
                            <tr>
                                <td>{{$sepCarrera->id}}</td>
                                <td>{{$sepCarrera->cve_carrera}}</td>
                    <td>{{$sepCarrera->descripcion}}</td>
                    <td>{{$sepCarrera->id_area}}</td>
                    <td>{{$sepCarrera->area}}</td>
                    <td>{{$sepCarrera->cve_subarea}}</td>
                    <td>{{$sepCarrera->area}}</td>
                    <td>{{$sepCarrera->id_nivel_sirep}}</td>
                    <td>{{$sepCarrera->nivel_educativo}}</td>
                    <td>{{$sepCarrera->num_rvoe}}</td>
                                <td class="text-right">
                                    @permission('sepCarreras.edit')
                                    <a class="btn btn-xs btn-primary" href="{{ route('sepCarreras.duplicate', $sepCarrera->id) }}"><i class="glyphicon glyphicon-duplicate"></i> Duplicate</a>
                                    @endpermission
                                    @permission('sepCarreras.edit')
                                    <a class="btn btn-xs btn-warning" href="{{ route('sepCarreras.edit', $sepCarrera->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                                    @endpermission
                                    @permission('sepCarreras.destroy')
                                    {!! Form::model($sepCarrera, array('route' => array('sepCarreras.destroy', $sepCarrera->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? ¿Esta seguro?')) { return true } else {return false };")) !!}
                                        <button type="submit" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i> Borrar</button>
                                    {!! Form::close() !!}
                                    @endpermission
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {!! $sepCarreras->appends(Request::except('page'))->render() !!}
            @else
                <h3 class="text-center alert alert-info">Vacio!</h3>
            @endif

        </div>
    </div>

@endsection