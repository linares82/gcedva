@extends('plantillas.admin_template')

@include('serieFolioSimplificados._common')

@section('header')

    <ol class="breadcrumb">
    	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
        <!--
        @if ( $query_params = Request::input('q') )

            <li class="active"><a href="{{ route('serieFolioSimplificados.index') }}">@yield('serieFolioSimplificadosAppTitle')</a></li>
            <li class="active">condition(  

            @foreach( $query_params as $key => $value )
                @if (!$loop->first) / @endif {{ $key }} : {{ $value }}
            @endforeach
            )</li>
        @else
            <li class="active">@yield('serieFolioSimplificadosAppTitle')</li>
        @endif
        -->
        <li class="active">@yield('serieFolioSimplificadosAppTitle')</li>
    </ol>

    <div class="">
        <h3>
            <i class="glyphicon glyphicon-align-justify"></i> @yield('serieFolioSimplificadosAppTitle')
            @permission('serieFolioSimplificados.create')
            <a class="btn btn-success pull-right" href="{{ route('serieFolioSimplificados.create', array('cuentap'=>$cuentap)) }}"><i class="glyphicon glyphicon-plus"></i> Crear</a>
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
                    <form class="SerieFolioSimplificado_search" id="search" action="{{ route('serieFolioSimplificados.index') }}" accept-charset="UTF-8" method="get">
                        <input type="hidden" name="q[s]" value="{{ @(Request::input('q')['s']) ?: '' }}" />
                        <div class="form-horizontal">
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_cuenta_p_id_lt">ID</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['cuenta_p_id_lt']) ?: '' }}" name="q[cuenta_p_id_lt]" id="q_cuenta_p_id_lt" />
                                </div>
                            </div>
                            <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_cuenta_ps.name_gt">CUENTA_P_NAME</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['cuenta_ps.name_gt']) ?: '' }}" name="q[cuenta_ps.name_gt]" id="q_cuenta_ps.name_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['cuenta_ps.name_lt']) ?: '' }}" name="q[cuenta_ps.name_lt]" id="q_cuenta_ps.name_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_cuenta_ps.name_cont">CUENTA_P_NAME</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['cuenta_ps.name_cont']) ?: '' }}" name="q[cuenta_ps.name_cont]" id="q_cuenta_ps.name_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_serie_gt">SERIE</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['serie_gt']) ?: '' }}" name="q[serie_gt]" id="q_serie_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['serie_lt']) ?: '' }}" name="q[serie_lt]" id="q_serie_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_serie_cont">SERIE</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['serie_cont']) ?: '' }}" name="q[serie_cont]" id="q_serie_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_folio_inicial_gt">FOLIO_INICIAL</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['folio_inicial_gt']) ?: '' }}" name="q[folio_inicial_gt]" id="q_folio_inicial_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['folio_inicial_lt']) ?: '' }}" name="q[folio_inicial_lt]" id="q_folio_inicial_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_folio_inicial_cont">FOLIO_INICIAL</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['folio_inicial_cont']) ?: '' }}" name="q[folio_inicial_cont]" id="q_folio_inicial_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_folio_actual_gt">FOLIO_ACTUAL</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['folio_actual_gt']) ?: '' }}" name="q[folio_actual_gt]" id="q_folio_actual_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['folio_actual_lt']) ?: '' }}" name="q[folio_actual_lt]" id="q_folio_actual_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_folio_actual_cont">FOLIO_ACTUAL</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['folio_actual_cont']) ?: '' }}" name="q[folio_actual_cont]" id="q_folio_actual_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_anio_gt">ANIO</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['anio_gt']) ?: '' }}" name="q[anio_gt]" id="q_anio_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['anio_lt']) ?: '' }}" name="q[anio_lt]" id="q_anio_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_anio_cont">ANIO</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['anio_cont']) ?: '' }}" name="q[anio_cont]" id="q_anio_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_mes_id_gt">MES_ID</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['mes_id_gt']) ?: '' }}" name="q[mes_id_gt]" id="q_mes_id_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['mes_id_lt']) ?: '' }}" name="q[mes_id_lt]" id="q_mes_id_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_mes_id_cont">MES_ID</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['mes_id_cont']) ?: '' }}" name="q[mes_id_cont]" id="q_mes_id_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_bnd_activo_gt">BND_ACTIVO</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['bnd_activo_gt']) ?: '' }}" name="q[bnd_activo_gt]" id="q_bnd_activo_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['bnd_activo_lt']) ?: '' }}" name="q[bnd_activo_lt]" id="q_bnd_activo_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_bnd_activo_cont">BND_ACTIVO</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['bnd_activo_cont']) ?: '' }}" name="q[bnd_activo_cont]" id="q_bnd_activo_cont" />
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
            @if($serieFolioSimplificados->count())
                <table class="table table-condensed table-striped">
                    <thead>
                        <tr>
                            <th>@include('plantillas.getOrderLink', ['column' => 'id', 'title' => 'ID'])</th>
                            <th>@include('CrudDscaffold::getOrderlink', ['column' => 'cuenta_ps.name', 'title' => 'CUENTA'])</th>
                            <th>@include('CrudDscaffold::getOrderlink', ['column' => 'serie', 'title' => 'SERIE'])</th>
                            <th>@include('CrudDscaffold::getOrderlink', ['column' => 'folio_inicial', 'title' => 'FOLIO INICIAL'])</th>
                            <th>@include('CrudDscaffold::getOrderlink', ['column' => 'folio_actual', 'title' => 'FOLIO ACTUAL'])</th>
                            <th>@include('CrudDscaffold::getOrderlink', ['column' => 'anio', 'title' => 'AÑIO'])</th>
                            <th>@include('CrudDscaffold::getOrderlink', ['column' => 'mes_id', 'title' => 'MES'])</th>
                            <th>@include('CrudDscaffold::getOrderlink', ['column' => 'bnd_activo', 'title' => 'ACTIVO'])</th>
                            <th>@include('CrudDscaffold::getOrderlink', ['column' => 'bnd_activo', 'title' => 'FISCAL'])</th>
                            <th class="text-right">OPCIONES</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($serieFolioSimplificados as $serieFolioSimplificado)
                            <tr>
                                <td><a href="{{ route('serieFolioSimplificados.show', $serieFolioSimplificado->id) }}">{{$serieFolioSimplificado->id}}</a></td>
                                <td>{{$serieFolioSimplificado->cuentaP->name}}</td>
                    <td>{{$serieFolioSimplificado->serie}}</td>
                    <td>{{$serieFolioSimplificado->folio_inicial}}</td>
                    <td>{{$serieFolioSimplificado->folio_actual}}</td>
                    <td>{{$serieFolioSimplificado->anio}}</td>
                    <td>{{$serieFolioSimplificado->mes1->name}}</td>
                    <td>@if($serieFolioSimplificado->bnd_activo==1) SI @else NO @endif</td>
                    <td>@if($serieFolioSimplificado->bnd_fiscal==1) SI @else NO @endif</td>
                    
                                <td class="text-right">
                                    @permission('serieFolioSimplificados.edit')
                                    <a class="btn btn-xs btn-primary" href="{{ route('serieFolioSimplificados.duplicate', $serieFolioSimplificado->id) }}"><i class="glyphicon glyphicon-duplicate"></i> Duplicate</a>
                                    @endpermission
                                    @permission('serieFolioSimplificados.edit')
                                    <a class="btn btn-xs btn-warning" href="{{ route('serieFolioSimplificados.edit', $serieFolioSimplificado->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                                    @endpermission
                                    @permission('serieFolioSimplificados.destroy')
                                    {!! Form::model($serieFolioSimplificado, array('route' => array('serieFolioSimplificados.destroy', $serieFolioSimplificado->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? ¿Esta seguro?')) { return true } else {return false };")) !!}
                                        <button type="submit" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i> Borrar</button>
                                    {!! Form::close() !!}
                                    @endpermission
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {!! $serieFolioSimplificados->appends(Request::except('page'))->render() !!}
            @else
                <h3 class="text-center alert alert-info">Vacio!</h3>
            @endif

        </div>
    </div>

@endsection