@extends('plantillas.admin_template')

@include('sepCertificadoCs._common')

@section('header')

    <ol class="breadcrumb">
    	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
        <!--
        @if ( $query_params = Request::input('q') )

            <li class="active"><a href="{{ route('sepCertificadoCs.index') }}">@yield('sepCertificadoCsAppTitle')</a></li>
            <li class="active">condition(  

            @foreach( $query_params as $key => $value )
                @if (!$loop->first) / @endif {{ $key }} : {{ $value }}
            @endforeach
            )</li>
        @else
            <li class="active">@yield('sepCertificadoCsAppTitle')</li>
        @endif
        -->
        <li class="active">@yield('sepCertificadoCsAppTitle')</li>
    </ol>

    <div class="">
        <h3>
            <i class="glyphicon glyphicon-align-justify"></i> @yield('sepCertificadoCsAppTitle')
            @permission('sepCertificadoCs.create')
            <a class="btn btn-success pull-right" href="{{ route('sepCertificadoCs.create') }}"><i class="glyphicon glyphicon-plus"></i> Crear</a>
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
                    <form class="SepCertificadoC_search" id="search" action="{{ route('sepCertificadoCs.index') }}" accept-charset="UTF-8" method="get">
                        <input type="hidden" name="q[s]" value="{{ @(Request::input('q')['s']) ?: '' }}" />
                        <div class="form-horizontal">

                            <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_plantel_id_gt">PLANTEL_ID</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['plantel_id_gt']) ?: '' }}" name="q[plantel_id_gt]" id="q_plantel_id_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['plantel_id_lt']) ?: '' }}" name="q[plantel_id_lt]" id="q_plantel_id_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_plantel_id_cont">PLANTEL_ID</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['plantel_id_cont']) ?: '' }}" name="q[plantel_id_cont]" id="q_plantel_id_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_empleado_id_gt">EMPLEADO_ID</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['empleado_id_gt']) ?: '' }}" name="q[empleado_id_gt]" id="q_empleado_id_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['empleado_id_lt']) ?: '' }}" name="q[empleado_id_lt]" id="q_empleado_id_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_empleado_id_cont">EMPLEADO_ID</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['empleado_id_cont']) ?: '' }}" name="q[empleado_id_cont]" id="q_empleado_id_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_sep_cargo_id_gt">SEP_CARGO_ID</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['sep_cargo_id_gt']) ?: '' }}" name="q[sep_cargo_id_gt]" id="q_sep_cargo_id_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['sep_cargo_id_lt']) ?: '' }}" name="q[sep_cargo_id_lt]" id="q_sep_cargo_id_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_sep_cargo_id_cont">SEP_CARGO_ID</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['sep_cargo_id_cont']) ?: '' }}" name="q[sep_cargo_id_cont]" id="q_sep_cargo_id_cont" />
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
            @if($sepCertificadoCs->count())
                <table class="table table-condensed table-striped">
                    <thead>
                        <tr>
                            <th>@include('plantillas.getOrderLink', ['column' => 'id', 'title' => 'ID'])</th>
                            <th>@include('CrudDscaffold::getOrderlink', ['column' => 'plantel_id', 'title' => 'PLANTEL_ID'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'empleado_id', 'title' => 'EMPLEADO_ID'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'sep_cargo_id', 'title' => 'SEP_CARGO_ID'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'especialidad_id', 'title' => 'ESPECIALIDAD_ID'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'nivel_id', 'title' => 'NIVEL_ID'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'grado_id', 'title' => 'GRADO_ID'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'usu_alta_id', 'title' => 'USU_ALTA_ID'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'usu_mod_id', 'title' => 'USU_MOD_ID'])</th>
                            <th class="text-right">OPCIONES</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($sepCertificadoCs as $sepCertificadoC)
                            <tr>
                                <td><a href="{{ route('sepCertificadoCs.show', $sepCertificadoC->id) }}">{{$sepCertificadoC->id}}</a></td>
                                <td>{{$sepCertificadoC->plantel_id}}</td>
                    <td>{{$sepCertificadoC->empleado_id}}</td>
                    <td>{{$sepCertificadoC->sep_cargo_id}}</td>
                    <td>{{$sepCertificadoC->especialidad_id}}</td>
                    <td>{{$sepCertificadoC->nivel_id}}</td>
                    <td>{{$sepCertificadoC->grado_id}}</td>
                    <td>{{$sepCertificadoC->usu_alta_id}}</td>
                    <td>{{$sepCertificadoC->usu_mod_id}}</td>
                                <td class="text-right">
                                    @permission('sepCertificadoCs.edit')
                                    <a class="btn btn-xs btn-primary" href="{{ route('sepCertificadoCs.duplicate', $sepCertificadoC->id) }}"><i class="glyphicon glyphicon-duplicate"></i> Duplicate</a>
                                    @endpermission
                                    @permission('sepCertificadoCs.edit')
                                    <a class="btn btn-xs btn-warning" href="{{ route('sepCertificadoCs.edit', $sepCertificadoC->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                                    @endpermission
                                    @permission('sepCertificadoCs.destroy')
                                    {!! Form::model($sepCertificadoC, array('route' => array('sepCertificadoCs.destroy', $sepCertificadoC->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? ¿Esta seguro?')) { return true } else {return false };")) !!}
                                        <button type="submit" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i> Borrar</button>
                                    {!! Form::close() !!}
                                    @endpermission
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {!! $sepCertificadoCs->appends(Request::except('page'))->render() !!}
            @else
                <h3 class="text-center alert alert-info">Vacio!</h3>
            @endif

        </div>
    </div>

@endsection