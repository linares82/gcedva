@extends('plantillas.admin_template')

@include('tickets._common')

@section('header')

    <ol class="breadcrumb">
    	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
        <!--
        @if ( $query_params = Request::input('q') )

            <li class="active"><a href="{{ route('tickets.index') }}">@yield('ticketsAppTitle')</a></li>
            <li class="active">condition(  

            @foreach( $query_params as $key => $value )
                @if (!$loop->first) / @endif {{ $key }} : {{ $value }}
            @endforeach
            )</li>
        @else
            <li class="active">@yield('ticketsAppTitle')</li>
        @endif
        -->
        <li class="active">@yield('ticketsAppTitle')</li>
    </ol>

    <div class="">
        <h3>
            <i class="glyphicon glyphicon-align-justify"></i> @yield('ticketsAppTitle')
            @permission('tickets.create')
            <a class="btn btn-success pull-right" href="{{ route('tickets.create') }}"><i class="glyphicon glyphicon-plus"></i> Crear</a>
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
                    <form class="Ticket_search" id="search" action="{{ route('tickets.index') }}" accept-charset="UTF-8" method="get">
                        <input type="hidden" name="q[s]" value="{{ @(Request::input('q')['s']) ?: '' }}" />
                        <div class="form-horizontal">

                            <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_categoria_tickets.name_gt">CATEGORIA_TICKET_NAME</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['categoria_tickets.name_gt']) ?: '' }}" name="q[categoria_tickets.name_gt]" id="q_categoria_tickets.name_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['categoria_tickets.name_lt']) ?: '' }}" name="q[categoria_tickets.name_lt]" id="q_categoria_tickets.name_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_categoria_tickets.name_cont">CATEGORIA_TICKET_NAME</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['categoria_tickets.name_cont']) ?: '' }}" name="q[categoria_tickets.name_cont]" id="q_categoria_tickets.name_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_detalle_gt">DETALLE</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['detalle_gt']) ?: '' }}" name="q[detalle_gt]" id="q_detalle_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['detalle_lt']) ?: '' }}" name="q[detalle_lt]" id="q_detalle_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_detalle_cont">DETALLE</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['detalle_cont']) ?: '' }}" name="q[detalle_cont]" id="q_detalle_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_fecha_gt">FECHA</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['fecha_gt']) ?: '' }}" name="q[fecha_gt]" id="q_fecha_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['fecha_lt']) ?: '' }}" name="q[fecha_lt]" id="q_fecha_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_fecha_cont">FECHA</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['fecha_cont']) ?: '' }}" name="q[fecha_cont]" id="q_fecha_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_asignado_a_gt">ASIGNADO_A</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['asignado_a_gt']) ?: '' }}" name="q[asignado_a_gt]" id="q_asignado_a_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['asignado_a_lt']) ?: '' }}" name="q[asignado_a_lt]" id="q_asignado_a_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_asignado_a_cont">ASIGNADO_A</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['asignado_a_cont']) ?: '' }}" name="q[asignado_a_cont]" id="q_asignado_a_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_st_tickets.name_gt">ST_TICKET_NAME</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['st_tickets.name_gt']) ?: '' }}" name="q[st_tickets.name_gt]" id="q_st_tickets.name_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['st_tickets.name_lt']) ?: '' }}" name="q[st_tickets.name_lt]" id="q_st_tickets.name_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_st_tickets.name_cont">ST_TICKET_NAME</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['st_tickets.name_cont']) ?: '' }}" name="q[st_tickets.name_cont]" id="q_st_tickets.name_cont" />
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
            @if($tickets->count())
                <table class="table table-condensed table-striped">
                    <thead>
                        <tr>
                            <th>@include('plantillas.getOrderLink', ['column' => 'id', 'title' => 'ID'])</th>
                            <th>@include('CrudDscaffold::getOrderlink', ['column' => 'categoria_tickets.name', 'title' => 'CATEGORIA'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'fecha', 'title' => 'FECHA'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'asignado_a', 'title' => 'ASIGNADO A'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'st_tickets.name', 'title' => 'ESTATUS'])</th>
                        <th>ETIQUETAS</th>
                            <th class="text-right">OPCIONES</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($tickets as $ticket)
                            <tr>
                                <td><a href="{{ route('tickets.show', $ticket->id) }}">{{$ticket->id}}</a></td>
                                <td>{{$ticket->categoriaTicket->name}}</td>
                                <td>{{$ticket->fecha}}</td>
                                <td>{{$ticket->asignadoA->name}}</td>
                                <td>{{$ticket->stTicket->name}}</td>
                                <td>
                                    @foreach ($ticket->etiquetas as $etiqueta)
                                        <span class="badge bg-blue">{{ $etiqueta->name }}</span>    
                                                
                                    @endforeach
                                </td>
                                <td class="text-right">
                                    @permission('tickets.edit')
                                    <a class="btn btn-xs btn-primary" href="{{ route('tickets.duplicate', $ticket->id) }}"><i class="glyphicon glyphicon-duplicate"></i> Duplicate</a>
                                    @endpermission
                                    @permission('tickets.edit')
                                    <a class="btn btn-xs btn-warning" href="{{ route('tickets.edit', $ticket->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                                    @endpermission
                                    @permission('tickets.destroy')
                                    {!! Form::model($ticket, array('route' => array('tickets.destroy', $ticket->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? ¿Esta seguro?')) { return true } else {return false };")) !!}
                                        <button type="submit" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i> Borrar</button>
                                    {!! Form::close() !!}
                                    @endpermission
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {!! $tickets->appends(Request::except('page'))->render() !!}
            @else
                <h3 class="text-center alert alert-info">Vacio!</h3>
            @endif

        </div>
    </div>

@endsection