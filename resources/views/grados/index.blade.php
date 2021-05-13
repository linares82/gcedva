@extends('plantillas.admin_template')

@include('grados._common')

@section('header')

    <ol class="breadcrumb">
    	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
        <!--
        @if ( $query_params = Request::input('q') )

            <li class="active"><a href="{{ route('grados.index') }}">@yield('gradosAppTitle')</a></li>
            <li class="active">condition(  

            @foreach( $query_params as $key => $value )
                @if (!$loop->first) / @endif {{ $key }} : {{ $value }}
            @endforeach
            )</li>
        @else
            <li class="active">@yield('gradosAppTitle')</li>
        @endif
        -->
        <li class="active">@yield('gradosAppTitle')</li>
    </ol>

    <div class="">
        <h3>
            <i class="glyphicon glyphicon-align-justify"></i> @yield('gradosAppTitle')
            @permission('grados.create')
            <a class="btn btn-success pull-right" href="{{ route('grados.create') }}"><i class="glyphicon glyphicon-plus"></i> Crear</a>
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
                    <form class="Grado_search" id="search" action="{{ route('grados.index') }}" accept-charset="UTF-8" method="get">
                        <input type="hidden" name="q[s]" value="{{ @(Request::input('q')['s']) ?: '' }}" />
                        <div class="form-horizontal">

                            <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_nivel_id_gt">NIVEL_ID</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm", type="search" value="{{ @(Request::input('q')['nivel_id_gt']) ?: '' }}" name="q[nivel_id_gt]" id="q_nivel_id_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm", type="search" value="{{ @(Request::input('q')['nivel_id_lt']) ?: '' }}" name="q[nivel_id_lt]" id="q_nivel_id_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group col-md-4" >
                                <label for="q_grados.plantel_id_lt">PLANTEL</label>
                                
                                    {!! Form::select("grados.plantel_id", $list["Plantel"], "{{ @(Request::input('q')['grados.plantel_id_lt']) ?: '' }}", array("class" => "form-control select_seguridad", "name"=>"q[grados.plantel_id_lt]", "id"=>"q_grados.plantel_id_lt", "style"=>"width:100%;")) !!}
                                    <div id='loading10' style='display: none'><img src="{{ asset('images/ajax-loader.gif') }}" title="Enviando" /></div> 
                            </div>
                            
                            <div class="form-group col-md-4" >
                                <label for="q_grados.especialidad_id_lt">ESPECIALIDAD</label>
                                
                                    {!! Form::select("grados.especialidad_id", $list["Especialidad"], "{{ @(Request::input('q')['grados.especialidad_id_lt']) ?: '' }}", array("class" => "form-control select_seguridad", "name"=>"q[grados.especialidad_id_lt]", "id"=>"q_grados.especialidad_id_lt", "style"=>"width:100%;")) !!}
                                
                            </div>
                            <div class="form-group col-md-4">
                                <label for="q_nivel_id_cont">NIVEL</label>
                                
                                    {!! Form::select("grados.nivel_id", $list["Nivel"], "{{ @(Request::input('q')['grados.nivel_id_lt']) ?: '' }}", array("class" => "form-control select_seguridad", "name"=>"q[grados.nivel_id_lt]", "id"=>"q_grados.nivel_id_lt", "style"=>"width:100%;")) !!}
                                
                            </div>
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
                                <label for="q_name_cont">GRADO</label>
                                
                                    <input class="form-control input-sm", type="search" value="{{ @(Request::input('q')['name_cont']) ?: '' }}" name="q[name_cont]" id="q_name_cont" />
                                
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
            @if($grados->count())
                <table class="table table-condensed table-striped">
                    <thead>
                        <tr>
                            <th>@include('plantillas.getOrderLink', ['column' => 'id', 'title' => 'ID'])</th>
                            <th>@include('plantillas.getOrderlink', ['column' => 'plantel_id', 'title' => 'PLANTEL'])</th>
                            <th>@include('plantillas.getOrderlink', ['column' => 'especialidad_id', 'title' => 'ESPECIALIDAD'])</th>
                            <th>@include('plantillas.getOrderlink', ['column' => 'nivel_id', 'title' => 'NIVEL'])</th>
                            <th>@include('plantillas.getOrderlink', ['column' => 'name', 'title' => 'GRADO'])</th>
                            
                        
                            <th class="text-right">OPCIONES</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($grados as $grado)
                            <tr>
                                <td><a href="{{ route('grados.show', $grado->id) }}">{{$grado->id}}</a></td>
                                <td>{{$grado->plantel->razon}}</td>
                                <td>{{$grado->especialidad->name}}</td>
                                <td>{{$grado->nivel->name}}</td>
                                <td>{{$grado->name}}</td>
                                
                                <td class="text-right">
                                    @permission('grados.edit')
                                    <a class="btn btn-xs btn-primary" href="{{ route('grados.duplicate', $grado->id) }}"><i class="glyphicon glyphicon-duplicate"></i> Duplicar</a>
                                    @endpermission
                                    @permission('grados.edit')
                                    <a class="btn btn-xs btn-warning" href="{{ route('grados.edit', $grado->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                                    @endpermission
                                    @permission('grados.destroy')
                                    {!! Form::model($grado, array('route' => array('grados.destroy', $grado->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? ¿Esta seguro?')) { return true } else {return false };")) !!}
                                        <button type="submit" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i> Borrar</button>
                                    {!! Form::close() !!}
                                    @endpermission
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {!! $grados->appends(Request::except('page'))->render() !!}
            @else
                <h3 class="text-center alert alert-info">Vacio!</h3>
            @endif

        </div>
    </div>

@endsection