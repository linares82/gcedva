@extends('plantillas.admin_template')

@include('peticionOpenpays._common')

@section('header')

    <ol class="breadcrumb">
    	<li><a href="/"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
        <li class="active">Peticiones Openpay</li>
        <!--
        @if ( $query_params = Request::input('q') )

            <li class="active"><a href="{{ route('peticionOpenpays.index') }}">@yield('peticionOpenpaysAppTitle')</a></li>
            <li class="active">condition(  

            @foreach( $query_params as $key => $value )
                @if (!$loop->first) / @endif {{ $key }} : {{ $value }}
            @endforeach
            )</li>
        @else
            <li class="active">@yield('peticionOpenpaysAppTitle')</li>
        @endif
        -->
        <li class="active">@yield('peticionOpenpaysAppTitle')</li>
    </ol>

    <div class="">
        <h3>
            <i class="glyphicon glyphicon-align-justify"></i> @yield('peticionOpenpaysAppTitle')
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
                    <form class="Apple_search" id="search" action="{{ route('peticionOpenpays.index') }}" accept-charset="UTF-8" method="get">
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
                            
                            <div class="form-group col-md-4">
                                <label for="q_clientes.cliente_id_cont">Cliente id</label>
                                    <input class="form-control input-sm", type="search" value="{{ @(Request::input('q')['cliente_id_lt']) ?: '' }}" name="q[cliente_id_lt]" id="q_clientes_id_lt" />
                            </div>
                            -->

                            <div class="form-group col-md-4">
                                <label class="col-sm-12 control-label" for="q_rdescription_cont">Description</label>
                                <div class="col-sm-12">
                                    <input class="form-control input-sm", type="search" value="{{ @(Request::input('q')['rdescription_cont']) ?: '' }}" name="q[rdescription_cont]" id="q_rdesription_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_apple_type_id_gt">APPLE_TYPE_ID</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm", type="search" value="{{ @(Request::input('q')['apple_type_id_gt']) ?: '' }}" name="q[apple_type_id_gt]" id="q_apple_type_id_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm", type="search" value="{{ @(Request::input('q')['apple_type_id_lt']) ?: '' }}" name="q[apple_type_id_lt]" id="q_apple_type_id_lt" />
                                </div>
                            </div>
                            -->
                            
                            <div class="form-group">
                                <div class="col-sm-10 col-sm-offset-2">
                                    <input type="submit" name="commit" value="Search" class="btn btn-default btn-xs" />
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
            @if($peticionOpenpays->count())
                <table class="table table-condensed table-striped">
                    <thead>
                        <tr>
                            <th>@include('plantillas.getOrderLink', ['column' => 'id', 'title' => 'ID'])</th>
                            <th>@include('plantillas.getOrderLink', ['column' => 'cliente_id', 'title' => 'Cliente'])</th>
                            <th>@include('plantillas.getOrderLink', ['column' => 'rdescription', 'title' => 'Description'])</th>
                            <th>@include('plantillas.getOrderLink', ['column' => 'fecha_limite', 'title' => 'Fecha Limite'])</th>
                            <th>@include('plantillas.getOrderLink', ['column' => 'status', 'title' => 'Status'])</th>
                            <th>@include('plantillas.getOrderLink', ['column' => 'status', 'title' => 'Error Message'])</th>
                            <th>@include('plantillas.getOrderLink', ['column' => 'created_at', 'title' => 'Creado El'])</th>
                            <th class="text-right">OPTIONS</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($peticionOpenpays as $peticionOpenpay)
                            <tr>
                                <td>{{$peticionOpenpay->id}}</td>
                                <td>{{ $peticionOpenpay->cliente_id }}  {{$peticionOpenpay->cliente->nombre}} {{$peticionOpenpay->cliente->nombre2}} {{$peticionOpenpay->cliente->ape_paterno}} {{$peticionOpenpay->cliente->ape_materno}}</td>
                                <td>{{$peticionOpenpay->rdescription}}</td>
                                <td>{{$peticionOpenpay->fecha_limite}}</td>
                                <td>{{$peticionOpenpay->rstatus}}</td>
                                <td>{{$peticionOpenpay->rerror_message}}</td>
                                <td>{{$peticionOpenpay->created_at}}</td>
                                <td class="text-right">
                            
                                    {!! Form::model($peticionOpenpay, array('route' => array('peticionOpenpays.destroy', $peticionOpenpay->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? ¿Esta seguro?')) { return true } else {return false };")) !!}
                                        <button type="submit" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i> Borrar</button>
                                    {!! Form::close() !!}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {!! $peticionOpenpays->appends(Request::except('page'))->render() !!}
            @else
                <h3 class="text-center alert alert-info">Vacio!</h3>
            @endif

        </div>
    </div>

@endsection