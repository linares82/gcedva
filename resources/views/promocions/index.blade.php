@extends('plantillas.admin_template')

@include('promocions._common')

@section('header')

    <ol class="breadcrumb">
    	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
        <!--
        @if ( $query_params = Request::input('q') )

            <li class="active"><a href="{{ route('promocions.index') }}">@yield('promocionsAppTitle')</a></li>
            <li class="active">condition(  

            @foreach( $query_params as $key => $value )
                @if (!$loop->first) / @endif {{ $key }} : {{ $value }}
            @endforeach
            )</li>
        @else
            <li class="active">@yield('promocionsAppTitle')</li>
        @endif
        -->
        <li class="active">@yield('promocionsAppTitle')</li>
    </ol>

    <div class="">
        <h3>
            <i class="glyphicon glyphicon-align-justify"></i> @yield('promocionsAppTitle')
            @permission('promocions.create')
            <a class="btn btn-success pull-right" href="{{ route('promocions.create') }}"><i class="glyphicon glyphicon-plus"></i> Crear</a>
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
                    <form class="Promocion_search" id="search" action="{{ route('promocions.index') }}" accept-charset="UTF-8" method="get">
                        <input type="hidden" name="q[s]" value="{{ @(Request::input('q')['s']) ?: '' }}" />
                        <div class="form-horizontal">

                            <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_name_gt">NAME</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm", type="search" value="{{ @(Request::input('q')['name_gt']) ?: '' }}" name="q[name_gt]" id="q_name_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm", type="search" value="{{ @(Request::input('q')['name_lt']) ?: '' }}" name="q[name_lt]" id="q_name_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group col-md-4">
                                <label class="col-sm-12 control-label" for="q_name_cont">PROMOCION</label>
                                <div class="col-sm-12">
                                    <input class="form-control input-sm", type="search" value="{{ @(Request::input('q')['name_cont']) ?: '' }}" name="q[name_cont]" id="q_name_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_inicio_gt">INICIO</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm", type="search" value="{{ @(Request::input('q')['inicio_gt']) ?: '' }}" name="q[inicio_gt]" id="q_inicio_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm", type="search" value="{{ @(Request::input('q')['inicio_lt']) ?: '' }}" name="q[inicio_lt]" id="q_inicio_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group col-md-4">
                                <label class="col-sm-12 control-label" for="q_inicio_cont">INICIO</label>
                                <div class="col-sm-12">
                                    <input class="form-control input-sm", type="search" value="{{ @(Request::input('q')['inicio_cont']) ?: '' }}" name="q[inicio_cont]" id="q_inicio_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_fin_gt">FIN</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm", type="search" value="{{ @(Request::input('q')['fin_gt']) ?: '' }}" name="q[fin_gt]" id="q_fin_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm", type="search" value="{{ @(Request::input('q')['fin_lt']) ?: '' }}" name="q[fin_lt]" id="q_fin_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group col-md-4">
                                <label class="col-sm-12 control-label" for="q_fin_cont">FIN</label>
                                <div class="col-sm-12">
                                    <input class="form-control input-sm", type="search" value="{{ @(Request::input('q')['fin_cont']) ?: '' }}" name="q[fin_cont]" id="q_fin_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_activa_gt">ACTIVA</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm", type="search" value="{{ @(Request::input('q')['activa_gt']) ?: '' }}" name="q[activa_gt]" id="q_activa_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm", type="search" value="{{ @(Request::input('q')['activa_lt']) ?: '' }}" name="q[activa_lt]" id="q_activa_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group col-md-4">
                                <label class="col-sm-12 control-label" for="q_activa_cont">ACTIVA</label>
                                <div class="col-sm-12">
                                    <input class="form-control input-sm", type="search" value="{{ @(Request::input('q')['activa_cont']) ?: '' }}" name="q[activa_cont]" id="q_activa_cont" />
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
            @if($promocions->count())
                <table class="table table-condensed table-striped">
                    <thead>
                        <tr>
                            <th>@include('plantillas.getOrderLink', ['column' => 'id', 'title' => 'ID'])</th>
                            <th>@include('plantillas.getOrderLink', ['column' => 'name', 'title' => 'NAME'])</th>
                            <th>@include('plantillas.getOrderLink', ['column' => 'inicio', 'title' => 'INICIO'])</th>
                            <th>@include('plantillas.getOrderLink', ['column' => 'fin', 'title' => 'FIN'])</th>
                            <th>@include('plantillas.getOrderLink', ['column' => 'activa', 'title' => 'ACTIVA'])</th>
                            <th class="text-right">OPCIONES</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($promocions as $promocion)
                            <tr>
                                <td><a href="{{ route('promocions.show', $promocion->id) }}">{{$promocion->id}}</a></td>
                                <td>{{$promocion->name}}</td>
                                <td>{{$promocion->inicio}}</td>
                                <td>{{$promocion->fin}}</td>
                                <td>{{$promocion->activa}}</td>
                                <td class="text-right">
                                    @permission('promocions.edit')
                                    <a class="btn btn-xs btn-primary" href="{{ route('promocions.duplicate', $promocion->id) }}"><i class="glyphicon glyphicon-duplicate"></i> Duplicar</a>
                                    @endpermission
                                    @permission('promocions.edit')
                                    <a class="btn btn-xs btn-warning" href="{{ route('promocions.edit', $promocion->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                                    @endpermission
                                    @permission('promocions.destroy')
                                    {!! Form::model($promocion, array('route' => array('promocions.destroy', $promocion->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? ¿Esta seguro?')) { return true } else {return false };")) !!}
                                        <button type="submit" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i> Borrar</button>
                                    {!! Form::close() !!}
                                    @endpermission
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {!! $promocions->appends(Request::except('page'))->render() !!}
            @else
                <h3 class="text-center alert alert-info">Vacio!</h3>
            @endif

        </div>
    </div>

@endsection