@extends('plantillas.admin_template')

@include('calendarioExaExtras._common')

@section('header')

    <ol class="breadcrumb">
    	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
        <!--
        @if ( $query_params = Request::input('q') )

            <li class="active"><a href="{{ route('calendarioExaExtras.index') }}">@yield('calendarioExaExtrasAppTitle')</a></li>
            <li class="active">condition(  

            @foreach( $query_params as $key => $value )
                @if (!$loop->first) / @endif {{ $key }} : {{ $value }}
            @endforeach
            )</li>
        @else
            <li class="active">@yield('calendarioExaExtrasAppTitle')</li>
        @endif
        -->
        <li class="active">@yield('calendarioExaExtrasAppTitle')</li>
    </ol>

    <div class="">
        <h3>
            <i class="glyphicon glyphicon-align-justify"></i> @yield('calendarioExaExtrasAppTitle')
            @permission('calendarioExaExtras.create')
            <a class="btn btn-success pull-right" href="{{ route('calendarioExaExtras.create') }}"><i class="glyphicon glyphicon-plus"></i> Crear</a>
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
                    <form class="CalendarioExaExtra_search" id="search" action="{{ route('calendarioExaExtras.index') }}" accept-charset="UTF-8" method="get">
                        <input type="hidden" name="q[s]" value="{{ @(Request::input('q')['s']) ?: '' }}" />
                        <div class="">

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
                            <div class="form-group col-md-4">
                                <label class="control-label" for="q_plantels.razon_cont">PLANTEL</label>
                                <div class="">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['plantels.razon_cont']) ?: '' }}" name="q[plantels.razon_cont]" id="q_plantels.razon_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_duracion_periodos.name_gt">DURACION_PERIODO_NAME</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['duracion_periodos.name_gt']) ?: '' }}" name="q[duracion_periodos.name_gt]" id="q_duracion_periodos.name_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['duracion_periodos.name_lt']) ?: '' }}" name="q[duracion_periodos.name_lt]" id="q_duracion_periodos.name_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group col-md-4">
                                <label class="control-label" for="q_duracion_periodos.name_cont">DURACION</label>
                                <div class="">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['duracion_periodos.name_cont']) ?: '' }}" name="q[duracion_periodos.name_cont]" id="q_duracion_periodos.name_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_fec_inicio_gt">FEC_INICIO</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['fec_inicio_gt']) ?: '' }}" name="q[fec_inicio_gt]" id="q_fec_inicio_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['fec_inicio_lt']) ?: '' }}" name="q[fec_inicio_lt]" id="q_fec_inicio_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group col-md-4">
                                <label class="control-label" for="q_fec_inicio_cont">FEC. INICIO</label>
                                <div class="">
                                    <input class="form-control input-sm fecha" type="search" value="{{ @(Request::input('q')['fec_inicio_cont']) ?: '' }}" name="q[fec_inicio_cont]" id="q_fec_inicio_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_fec_fin_gt">FEC_FIN</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['fec_fin_gt']) ?: '' }}" name="q[fec_fin_gt]" id="q_fec_fin_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['fec_fin_lt']) ?: '' }}" name="q[fec_fin_lt]" id="q_fec_fin_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group col-md-4">
                                <label class="control-label" for="q_fec_fin_cont">FEC. FIN</label>
                                <div class="">
                                    <input class="form-control input-sm fecha" type="search" value="{{ @(Request::input('q')['fec_fin_cont']) ?: '' }}" name="q[fec_fin_cont]" id="q_fec_fin_cont" />
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
            @if($calendarioExaExtras->count())
                <table class="table table-condensed table-striped">
                    <thead>
                        <tr>
                            <th>@include('plantillas.getOrderLink', ['column' => 'id', 'title' => 'ID'])</th>
                            <th>@include('CrudDscaffold::getOrderlink', ['column' => 'plantels.razon', 'title' => 'PLANTEL'])</th>
                            <th>@include('CrudDscaffold::getOrderlink', ['column' => 'duracion_periodos.name', 'title' => 'DURACION'])</th>
                            <th>@include('CrudDscaffold::getOrderlink', ['column' => 'fec_inicio', 'title' => 'FEC. INICIO'])</th>
                            <th>@include('CrudDscaffold::getOrderlink', ['column' => 'fec_fin', 'title' => 'FEC. FIN'])</th>
                        
                            <th class="text-right">OPCIONES</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($calendarioExaExtras as $calendarioExaExtra)
                            <tr>
                                <td><a href="{{ route('calendarioExaExtras.show', $calendarioExaExtra->id) }}">{{$calendarioExaExtra->id}}</a></td>
                                <td>{{$calendarioExaExtra->plantel->razon}}</td>
                    <td>{{$calendarioExaExtra->duracionPeriodo->name}}</td>
                    <td>{{$calendarioExaExtra->fec_inicio}}</td>
                    <td>{{$calendarioExaExtra->fec_fin}}</td>
                                <td class="text-right">
                                    
                                    @permission('calendarioExaExtras.edit')
                                    <a class="btn btn-xs btn-warning" href="{{ route('calendarioExaExtras.edit', $calendarioExaExtra->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                                    @endpermission
                                    @permission('calendarioExaExtras.destroy')
                                    {!! Form::model($calendarioExaExtra, array('route' => array('calendarioExaExtras.destroy', $calendarioExaExtra->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? ¿Esta seguro?')) { return true } else {return false };")) !!}
                                        <button type="submit" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i> Borrar</button>
                                    {!! Form::close() !!}
                                    @endpermission
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {!! $calendarioExaExtras->appends(Request::except('page'))->render() !!}
            @else
                <h3 class="text-center alert alert-info">Vacio!</h3>
            @endif

        </div>
    </div>

@endsection