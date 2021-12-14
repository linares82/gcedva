@extends('plantillas.admin_template')

@include('calificacions._common')

@section('header')

    <ol class="breadcrumb">
    	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
        <!--
        @if ( $query_params = Request::input('q') )

            <li class="active"><a href="{{ route('calificacions.index') }}">@yield('calificacionsAppTitle')</a></li>
            <li class="active">condition(  

            @foreach( $query_params as $key => $value )
                @if (!$loop->first) / @endif {{ $key }} : {{ $value }}
            @endforeach
            )</li>
        @else
            <li class="active">@yield('calificacionsAppTitle')</li>
        @endif
        -->
        <li class="active">@yield('calificacionsAppTitle')</li>
    </ol>

    <div class="">
        <h3>
            <i class="glyphicon glyphicon-align-justify"></i> @yield('calificacionsAppTitle')
            @permission('hacademicas.examenesVarios')
            <a class="btn btn-success pull-right" href="{{ route('hacademicas.examenesVarios') }}"><i class="glyphicon glyphicon-plus"></i> Generar Evaluaciones</a>
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
                    <form class="Calificacion_search" id="search" action="{{ route('calificacions.index') }}" accept-charset="UTF-8" method="get">
                        <input type="hidden" name="q[s]" value="{{ @(Request::input('q')['s']) ?: '' }}" />
                        <div class="form-horizontal">

                            <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_hacademica_id_gt">HACADEMICA_ID</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm", type="search" value="{{ @(Request::input('q')['hacademica_id_gt']) ?: '' }}" name="q[hacademica_id_gt]" id="q_hacademica_id_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm", type="search" value="{{ @(Request::input('q')['hacademica_id_lt']) ?: '' }}" name="q[hacademica_id_lt]" id="q_hacademica_id_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_hacademicas.cliente_id_lt">CLIENTE</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm", type="search" value="{{ @(Request::input('q')['hacademicas.cliente_id_lt']) ?: '' }}" name="q[hacademicas.cliente_id_lt]" id="q_hacademicas.cliente_id_lt" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_examen_id_gt">EXAMEN_ID</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm", type="search" value="{{ @(Request::input('q')['examen_id_gt']) ?: '' }}" name="q[examen_id_gt]" id="q_examen_id_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm", type="search" value="{{ @(Request::input('q')['examen_id_lt']) ?: '' }}" name="q[examen_id_lt]" id="q_examen_id_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_examen_id_cont">TIPO EXAMEN</label>
                                <div class=" col-sm-9">
                                    {!! Form::select("st_cliente_id", $tiposExamen, "{{ @(Request::input('q')['tpo_examen_id_lt']) ?: '' }}", array("class" => "form-control select_seguridad", "name"=>"q[tpo_examen_id_lt]", "id"=>"q_tpo_examen_id_lt", "style"=>"width:100%;" )) !!}
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
            @if($calificacions->count())
                <table class="table table-condensed table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>CLIENTE</th>
                            <th>MATERIA</th>
                            <th>T. EXAMEN</th>
                            <th>CALIFICACION</th>
                            <th>LECTIVO</th>
                            <th class="text-right">OPCIONES</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($calificacions as $calificacion)
                            <tr>
                                <td><a href="{{ route('calificacions.edit', $calificacion->id) }}">{{$calificacion->id}}</a></td>
                                <td>{{$calificacion->cliente_id}}
                                    {{$calificacion->nombre}} 
                                    {{$calificacion->nombre2}}
                                    {{$calificacion->ape_paterno}}
                                    {{$calificacion->materno}}</td>
                                <td>{{$calificacion->materia}}</td>
                                <td>{{$calificacion->tpo_examen}}</td>
                                <td>{{$calificacion->calificacion}}</td>
                                <td>{{$calificacion->lectivo}}</td>
                                
                                <td class="text-right">
                                    
                                    @permission('calificacions.edit')
                                    <a class="btn btn-xs btn-warning" href="{{ route('calificacions.edit', $calificacion->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                                    @endpermission
                                    @permission('calificacions.destroy')
                                    {!! Form::model($calificacion, array('route' => array('calificacions.destroy', $calificacion->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? ¿Esta seguro?')) { return true } else {return false };")) !!}
                                        <button type="submit" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i> Borrar</button>
                                    {!! Form::close() !!}
                                    @endpermission
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {!! $calificacions->appends(Request::except('page'))->render() !!}
            @else
                <h3 class="text-center alert alert-info">Vacio!</h3>
            @endif

        </div>
    </div>

@endsection