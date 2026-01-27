@extends('plantillas.admin_template')

@include('incidenciasCalificacions._common')

@section('header')

    <ol class="breadcrumb">
    	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
        <!--
        @if ( $query_params = Request::input('q') )

            <li class="active"><a href="{{ route('incidenciasCalificacions.index') }}">@yield('incidenciasCalificacionsAppTitle')</a></li>
            <li class="active">condition(  

            @foreach( $query_params as $key => $value )
                @if (!$loop->first) / @endif {{ $key }} : {{ $value }}
            @endforeach
            )</li>
        @else
            <li class="active">@yield('incidenciasCalificacionsAppTitle')</li>
        @endif
        -->
        <li class="active">@yield('incidenciasCalificacionsAppTitle')</li>
    </ol>

    <div class="">
        <h3>
            <i class="glyphicon glyphicon-align-justify"></i> @yield('incidenciasCalificacionsAppTitle')
            @permission('incidenciasCalificacions.create')
            <a class="btn btn-success pull-right" href="{{ route('incidenciasCalificacions.create') }}"><i class="glyphicon glyphicon-plus"></i> Crear</a>
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
                    <form class="IncidenciasCalificacion_search" id="search" action="{{ route('incidenciasCalificacions.index') }}" accept-charset="UTF-8" method="get">
                        <input type="hidden" name="q[s]" value="{{ @(Request::input('q')['s']) ?: '' }}" />
                        <div class="form-horizontal">

                            <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_calificacion_id_gt">CALIFICACION_ID</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['calificacion_id_gt']) ?: '' }}" name="q[calificacion_id_gt]" id="q_calificacion_id_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['calificacion_id_lt']) ?: '' }}" name="q[calificacion_id_lt]" id="q_calificacion_id_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_cliente_id_cont">CLIENTE ID</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['cliente_id_cont']) ?: '' }}" name="q[cliente_id_cont]" id="q_cliente_id_cont" />
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
            @if($incidenciasCalificacions->count())
                <table class="table table-condensed table-striped">
                    <thead>
                        <tr>
                            <th>@include('plantillas.getOrderLink', ['column' => 'id', 'title' => 'ID'])</th>
                            <th>@include('CrudDscaffold::getOrderlink', ['column' => 'cliente_id', 'title' => 'CLIENTE'])</th>
                            <th>CALIFICACION PODERACION</th>
                            <th>@include('CrudDscaffold::getOrderlink', ['column' => 'materium_id', 'title' => 'MATERIA'])</th>
                            <th>CALIFICACION ANTERIOR</th>
                            <th>@include('CrudDscaffold::getOrderlink', ['column' => 'calificacion_nueva', 'title' => 'CALIFICACION NUEVA'])</th>
                            <th>@include('CrudDscaffold::getOrderlink', ['column' => 'justificacion', 'title' => 'JUSTIFICACION'])</th>
                            <th>@include('CrudDscaffold::getOrderlink', ['column' => 'usu_alta_id', 'title' => 'ALTA'])</th>
                            <th>Estatus</th>
                            <th>RESPUESTA</th>
                            <th class="text-right">OPCIONES</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($incidenciasCalificacions as $incidenciasCalificacion)
                            <tr>
                                <td><a href="{{ route('incidenciasCalificacions.show', $incidenciasCalificacion->id) }}">{{$incidenciasCalificacion->id}}</a></td>
                                <td>{{$incidenciasCalificacion->cliente_id}} {{$incidenciasCalificacion->cliente->nombre}} {{$incidenciasCalificacion->cliente->nombre2}} {{$incidenciasCalificacion->cliente->ape_paterno}} {{$incidenciasCalificacion->cliente->ape_materno}}</td>
                                <td>{{$incidenciasCalificacion->calificacionPonderacion->cargaPonderacion->name}}</td>
                                <td>{{$incidenciasCalificacion->materium->name}}</td>
                                <td>{{$incidenciasCalificacion->calificacionPonderacion->calificacion_parcial}}</td>
                                <td>{{$incidenciasCalificacion->calificacion_nueva}}</td>
                                <td>
                                    @if(!is_null($incidenciasCalificacion->imagen))
                                    <a target="_blank" href="{{ asset('storage/incidencias_calificacions/' . $incidenciasCalificacion->imagen) }}">
                                        {{$incidenciasCalificacion->justificacion}}
                                    </a>
                                    @else
                                        {{$incidenciasCalificacion->justificacion}}
                                    @endif
                                    
                                </td>
                                <td>{{$incidenciasCalificacion->usu_alta->name}}</td>
                                <td>
                                    @if($incidenciasCalificacion->bnd_autorizada==1)
                                    Aprobada
                                    @elseif($incidenciasCalificacion->bnd_rechazada==1)
                                    Rechazada
                                    @else
                                    Sin revisar
                                    @endif
                                </td>
                                <td>{{$incidenciasCalificacion->respuesta}}</td>
                                <td class="text-right">
                                    @permission('incidenciasCalificacions.edit')
                                    @if($incidenciasCalificacion->bnd_autorizada==0 && $incidenciasCalificacion->bnd_rechazada==0)
                                    <a class="btn btn-xs btn-warning" href="{{ route('incidenciasCalificacions.edit', $incidenciasCalificacion->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                                    @endif
                                    @endpermission
                                    @permission('incidenciasCalificacions.destroy')
                                    {!! Form::model($incidenciasCalificacion, array('route' => array('incidenciasCalificacions.destroy', $incidenciasCalificacion->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? ¿Esta seguro?')) { return true } else {return false };")) !!}
                                        <button type="submit" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i> Borrar</button>
                                    {!! Form::close() !!}
                                    @endpermission
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {!! $incidenciasCalificacions->appends(Request::except('page'))->render() !!}
            @else
                <h3 class="text-center alert alert-info">Vacio!</h3>
            @endif

        </div>
    </div>

@endsection