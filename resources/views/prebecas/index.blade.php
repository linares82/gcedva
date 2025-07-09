@extends('plantillas.admin_template')

@include('prebecas._common')

@section('header')

    <ol class="breadcrumb">
    	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
        <!--
        @if ( $query_params = Request::input('q') )

            <li class="active"><a href="{{ route('prebecas.index') }}">@yield('prebecasAppTitle')</a></li>
            <li class="active">condition(  

            @foreach( $query_params as $key => $value )
                @if (!$loop->first) / @endif {{ $key }} : {{ $value }}
            @endforeach
            )</li>
        @else
            <li class="active">@yield('prebecasAppTitle')</li>
        @endif
        -->
        <li class="active">@yield('prebecasAppTitle')</li>
    </ol>

    <div class="">
        <h3>
            <i class="glyphicon glyphicon-align-justify"></i> @yield('prebecasAppTitle')
            @permission('prebecas.create')
            <a class="btn btn-success pull-right" href="{{ route('prebecas.create') }}"><i class="glyphicon glyphicon-plus"></i> Crear</a>
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
                    <form class="Prebeca_search" id="search" action="{{ route('prebecas.index') }}" accept-charset="UTF-8" method="get">
                        <input type="hidden" name="q[s]" value="{{ @(Request::input('q')['s']) ?: '' }}" />
                        <div class="form-horizontal">

                            <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_cliente_id_gt">CLIENTE_ID</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['cliente_id_gt']) ?: '' }}" name="q[cliente_id_gt]" id="q_cliente_id_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['cliente_id_lt']) ?: '' }}" name="q[cliente_id_lt]" id="q_cliente_id_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_cliente_id_cont">CLIENTE_ID</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['cliente_id_cont']) ?: '' }}" name="q[cliente_id_cont]" id="q_cliente_id_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_motivo_beca_id_gt">MOTIVO_BECA_ID</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['motivo_beca_id_gt']) ?: '' }}" name="q[motivo_beca_id_gt]" id="q_motivo_beca_id_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['motivo_beca_id_lt']) ?: '' }}" name="q[motivo_beca_id_lt]" id="q_motivo_beca_id_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_motivo_beca_id_cont">MOTIVO_BECA_ID</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['motivo_beca_id_cont']) ?: '' }}" name="q[motivo_beca_id_cont]" id="q_motivo_beca_id_cont" />
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
                                <label class="col-sm-2 control-label" for="q_procentaje_beca_id_gt">PROCENTAJE_BECA_ID</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['procentaje_beca_id_gt']) ?: '' }}" name="q[procentaje_beca_id_gt]" id="q_procentaje_beca_id_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['procentaje_beca_id_lt']) ?: '' }}" name="q[procentaje_beca_id_lt]" id="q_procentaje_beca_id_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_procentaje_beca_id_cont">PROCENTAJE_BECA_ID</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['procentaje_beca_id_cont']) ?: '' }}" name="q[procentaje_beca_id_cont]" id="q_procentaje_beca_id_cont" />
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
            @if($prebecas->count())
                <table class="table table-condensed table-striped">
                    <thead>
                        <tr>
                            <th>@include('plantillas.getOrderLink', ['column' => 'id', 'title' => 'ID'])</th>
                            <th>@include('CrudDscaffold::getOrderlink', ['column' => 'cliente_id', 'title' => 'CLIENTE_ID'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'motivo_beca_id', 'title' => 'MOTIVO_BECA_ID'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'observaciones', 'title' => 'OBSERVACIONES'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'procentaje_beca_id', 'title' => 'PROCENTAJE_BECA_ID'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'usu_alta_id', 'title' => 'USU_ALTA_ID'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'usu_mod_id', 'title' => 'USU_MOD_ID'])</th>
                            <th class="text-right">OPCIONES</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($prebecas as $prebeca)
                            <tr>
                                <td><a href="{{ route('prebecas.show', $prebeca->id) }}">{{$prebeca->id}}</a></td>
                                <td>{{$prebeca->cliente_id}}</td>
                    <td>{{$prebeca->motivo_beca_id}}</td>
                    <td>{{$prebeca->observaciones}}</td>
                    <td>{{$prebeca->procentaje_beca_id}}</td>
                    <td>{{$prebeca->usu_alta_id}}</td>
                    <td>{{$prebeca->usu_mod_id}}</td>
                                <td class="text-right">
                                    @permission('prebecas.edit')
                                    <a class="btn btn-xs btn-primary" href="{{ route('prebecas.duplicate', $prebeca->id) }}"><i class="glyphicon glyphicon-duplicate"></i> Duplicate</a>
                                    @endpermission
                                    @permission('prebecas.edit')
                                    <a class="btn btn-xs btn-warning" href="{{ route('prebecas.edit', $prebeca->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                                    @endpermission
                                    @permission('prebecas.destroy')
                                    {!! Form::model($prebeca, array('route' => array('prebecas.destroy', $prebeca->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? ¿Esta seguro?')) { return true } else {return false };")) !!}
                                        <button type="submit" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i> Borrar</button>
                                    {!! Form::close() !!}
                                    @endpermission
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {!! $prebecas->appends(Request::except('page'))->render() !!}
            @else
                <h3 class="text-center alert alert-info">Vacio!</h3>
            @endif

        </div>
    </div>

@endsection