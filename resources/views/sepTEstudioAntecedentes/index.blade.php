@extends('plantillas.admin_template')

@include('sepTEstudioAntecedentes._common')

@section('header')

    <ol class="breadcrumb">
    	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
        <!--
        @if ( $query_params = Request::input('q') )

            <li class="active"><a href="{{ route('sepTEstudioAntecedentes.index') }}">@yield('sepTEstudioAntecedentesAppTitle')</a></li>
            <li class="active">condition(  

            @foreach( $query_params as $key => $value )
                @if (!$loop->first) / @endif {{ $key }} : {{ $value }}
            @endforeach
            )</li>
        @else
            <li class="active">@yield('sepTEstudioAntecedentesAppTitle')</li>
        @endif
        -->
        <li class="active">@yield('sepTEstudioAntecedentesAppTitle')</li>
    </ol>

    <div class="">
        <h3>
            <i class="glyphicon glyphicon-align-justify"></i> @yield('sepTEstudioAntecedentesAppTitle')
            @permission('sepTEstudioAntecedentes.create')
            <a class="btn btn-success pull-right" href="{{ route('sepTEstudioAntecedentes.create') }}"><i class="glyphicon glyphicon-plus"></i> Crear</a>
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
                    <form class="SepTEstudioAntecedente_search" id="search" action="{{ route('sepTEstudioAntecedentes.index') }}" accept-charset="UTF-8" method="get">
                        <input type="hidden" name="q[s]" value="{{ @(Request::input('q')['s']) ?: '' }}" />
                        <div class="form-horizontal">

                            <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_id_t_estudio_antecedente_gt">ID_T_ESTUDIO_ANTECEDENTE</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['id_t_estudio_antecedente_gt']) ?: '' }}" name="q[id_t_estudio_antecedente_gt]" id="q_id_t_estudio_antecedente_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['id_t_estudio_antecedente_lt']) ?: '' }}" name="q[id_t_estudio_antecedente_lt]" id="q_id_t_estudio_antecedente_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_id_t_estudio_antecedente_cont">ID_T_ESTUDIO_ANTECEDENTE</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['id_t_estudio_antecedente_cont']) ?: '' }}" name="q[id_t_estudio_antecedente_cont]" id="q_id_t_estudio_antecedente_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_t_estudio_antecedente_gt">T_ESTUDIO_ANTECEDENTE</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['t_estudio_antecedente_gt']) ?: '' }}" name="q[t_estudio_antecedente_gt]" id="q_t_estudio_antecedente_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['t_estudio_antecedente_lt']) ?: '' }}" name="q[t_estudio_antecedente_lt]" id="q_t_estudio_antecedente_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_t_estudio_antecedente_cont">T_ESTUDIO_ANTECEDENTE</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['t_estudio_antecedente_cont']) ?: '' }}" name="q[t_estudio_antecedente_cont]" id="q_t_estudio_antecedente_cont" />
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
            @if($sepTEstudioAntecedentes->count())
                <table class="table table-condensed table-striped">
                    <thead>
                        <tr>
                            <th>@include('plantillas.getOrderLink', ['column' => 'id', 'title' => 'ID'])</th>
                            <th>@include('CrudDscaffold::getOrderlink', ['column' => 'id_t_estudio_antecedente', 'title' => 'ID_T_ESTUDIO_ANTECEDENTE'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 't_estudio_antecedente', 'title' => 'T_ESTUDIO_ANTECEDENTE'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'tipo_educativo', 'title' => 'TIPO_EDUCATIVO'])</th>
                            <th class="text-right">OPCIONES</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($sepTEstudioAntecedentes as $sepTEstudioAntecedente)
                            <tr>
                                <td>{{$sepTEstudioAntecedente->id}}
                                </td>
                                <td>{{$sepTEstudioAntecedente->id_t_estudio_antecedente}}</td>
                    <td>{{$sepTEstudioAntecedente->t_estudio_antecedente}}</td>
                    <td>{{$sepTEstudioAntecedente->tipo_educativo}}</td>
                                <td class="text-right">
                                    @permission('sepTEstudioAntecedentes.edit')
                                    <a class="btn btn-xs btn-primary" href="{{ route('sepTEstudioAntecedentes.duplicate', $sepTEstudioAntecedente->id) }}"><i class="glyphicon glyphicon-duplicate"></i> Duplicate</a>
                                    @endpermission
                                    @permission('sepTEstudioAntecedentes.edit')
                                    <a class="btn btn-xs btn-warning" href="{{ route('sepTEstudioAntecedentes.edit', $sepTEstudioAntecedente->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                                    @endpermission
                                    @permission('sepTEstudioAntecedentes.destroy')
                                    {!! Form::model($sepTEstudioAntecedente, array('route' => array('sepTEstudioAntecedentes.destroy', $sepTEstudioAntecedente->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? ¿Esta seguro?')) { return true } else {return false };")) !!}
                                        <button type="submit" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i> Borrar</button>
                                    {!! Form::close() !!}
                                    @endpermission
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {!! $sepTEstudioAntecedentes->appends(Request::except('page'))->render() !!}
            @else
                <h3 class="text-center alert alert-info">Vacio!</h3>
            @endif

        </div>
    </div>

@endsection