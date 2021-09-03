@extends('plantillas.admin_template')

@include('turnos._common')

@section('header')

    <ol class="breadcrumb">
    	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
        <!--
        @if ( $query_params = Request::input('q') )

            <li class="active"><a href="{{ route('turnos.index') }}">@yield('turnosAppTitle')</a></li>
            <li class="active">condition(  

            @foreach( $query_params as $key => $value )
                @if (!$loop->first) / @endif {{ $key }} : {{ $value }}
            @endforeach
            )</li>
        @else
            <li class="active">@yield('turnosAppTitle')</li>
        @endif
        -->
        <li class="active">@yield('turnosAppTitle')</li>
    </ol>

    @if (session('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif

    <div class="">
        <h3>
            <i class="glyphicon glyphicon-align-justify"></i> @yield('turnosAppTitle')
            @permission('turnos.create')
            <a class="btn btn-success pull-right" href="{{ route('turnos.create') }}"><i class="glyphicon glyphicon-plus"></i> Crear</a>
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
                    <form class="Turno_search" id="search" action="{{ route('turnos.index') }}" accept-charset="UTF-8" method="get">
                        <input type="hidden" name="q[s]" value="{{ @(Request::input('q')['s']) ?: '' }}" />
                        <div class="">

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
                                <label class="col-sm-2 control-label" for="q_name_cont">TURNO</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm", type="search" value="{{ @(Request::input('q')['name_cont']) ?: '' }}" name="q[name_cont]" id="q_name_cont" />
                                </div>
                            </div>
                            <div class="form-group col-md-4" >
                                <label for="q_turnos.plantel_id_lt">PLANTEL</label>
                                
                                    {!! Form::select("turnos.plantel_id", $list["Plantel"], "{{ @(Request::input('q')['clientes.plantel_id_lt']) ?: '' }}", array("class" => "form-control select_seguridad", "name"=>"q[turnos.plantel_id_lt]", "id"=>"q_turnos.plantel_id_lt", "style"=>"width:100%;")) !!}
                                    <div id='loading10' style='display: none'><img src="{{ asset('images/ajax-loader.gif') }}" title="Enviando" /></div> 
                            </div>
                            
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_usu_alta_id_gt">USU_ALTA_ID</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm", type="search" value="{{ @(Request::input('q')['usu_alta_id_gt']) ?: '' }}" name="q[usu_alta_id_gt]" id="q_usu_alta_id_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm", type="search" value="{{ @(Request::input('q')['usu_alta_id_lt']) ?: '' }}" name="q[usu_alta_id_lt]" id="q_usu_alta_id_lt" />
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
            @if($turnos->count())
                <table class="table table-condensed table-striped">
                    <thead>
                        <tr>
                            <th>@include('plantillas.getOrderLink', ['column' => 'id', 'title' => 'ID'])</th>
                            <th>@include('plantillas.getOrderLink', ['column' => 'plantel_id', 'title' => 'PLANTEL'])</th>
                            <th>@include('plantillas.getOrderLink', ['column' => 'especialidad_id', 'title' => 'ESPECIALIDAD'])</th>
                            <th>@include('plantillas.getOrderLink', ['column' => 'nivel_id', 'title' => 'NIVEL'])</th>
                            <th>@include('plantillas.getOrderLink', ['column' => 'grado_id', 'title' => 'GRADO'])</th>
                            <th>@include('plantillas.getOrderLink', ['column' => 'name', 'title' => 'TURNO'])</th>
                            <th class="text-right">OPCIONES</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($turnos as $turno)
                            <tr>
                                <td><a href="{{ route('turnos.show', $turno->id) }}">{{$turno->id}}</a></td>
                                <td>{{$turno->plantel->razon}}</td>
                                <td>{{optional($turno->especialidad)->name}}</td>
                                <td>{{optional($turno->nivel)->name}}</td>
                                <td>{{optional($turno->grado)->name}}</td>
                                <td>{{optional($turno)->name}}</td>
                                <td class="text-right">
                                    @permission('turnos.edit')
                                    <a class="btn btn-xs btn-primary" href="{{ route('turnos.duplicate', $turno->id) }}"><i class="glyphicon glyphicon-duplicate"></i> Duplicate</a>
                                    @endpermission
                                    @permission('turnos.edit')
                                    <a class="btn btn-xs btn-warning" href="{{ route('turnos.edit', $turno->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                                    @endpermission
                                    @permission('turnos.destroy')
                                    {!! Form::model($turno, array('route' => array('turnos.destroy', $turno->id),'method' => 'get', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? ¿Esta seguro?')) { return true } else {return false };")) !!}
                                        <button type="submit" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i> Borrar</button>
                                    {!! Form::close() !!}
                                    @endpermission
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {!! $turnos->appends(Request::except('page'))->render() !!}
            @else
                <h3 class="text-center alert alert-info">Vacio!</h3>
            @endif

        </div>
    </div>

@endsection