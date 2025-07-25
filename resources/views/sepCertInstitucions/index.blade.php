@extends('plantillas.admin_template')

@include('sepCertInstitucions._common')

@section('header')

    <ol class="breadcrumb">
    	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
        <!--
        @if ( $query_params = Request::input('q') )

            <li class="active"><a href="{{ route('sepCertInstitucions.index') }}">@yield('sepCertInstitucionsAppTitle')</a></li>
            <li class="active">condition(  

            @foreach( $query_params as $key => $value )
                @if (!$loop->first) / @endif {{ $key }} : {{ $value }}
            @endforeach
            )</li>
        @else
            <li class="active">@yield('sepCertInstitucionsAppTitle')</li>
        @endif
        -->
        <li class="active">@yield('sepCertInstitucionsAppTitle')</li>
    </ol>

    <div class="">
        <h3>
            <i class="glyphicon glyphicon-align-justify"></i> @yield('sepCertInstitucionsAppTitle')
            @permission('sepCertInstitucions.create')
            <a class="btn btn-success pull-right" href="{{ route('sepCertInstitucions.create') }}"><i class="glyphicon glyphicon-plus"></i> Crear</a>
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
                    <form class="SepCertInstitucion_search" id="search" action="{{ route('sepCertInstitucions.index') }}" accept-charset="UTF-8" method="get">
                        <input type="hidden" name="q[s]" value="{{ @(Request::input('q')['s']) ?: '' }}" />
                        <div class="form-horizontal">

                            <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_id_institucion_gt">ID_INSTITUCION</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['id_institucion_gt']) ?: '' }}" name="q[id_institucion_gt]" id="q_id_institucion_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['id_institucion_lt']) ?: '' }}" name="q[id_institucion_lt]" id="q_id_institucion_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_id_institucion_cont">ID_INSTITUCION</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['id_institucion_cont']) ?: '' }}" name="q[id_institucion_cont]" id="q_id_institucion_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_descripcion_gt">DESCRIPCION</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['descripcion_gt']) ?: '' }}" name="q[descripcion_gt]" id="q_descripcion_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['descripcion_lt']) ?: '' }}" name="q[descripcion_lt]" id="q_descripcion_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_descripcion_cont">DESCRIPCION</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['descripcion_cont']) ?: '' }}" name="q[descripcion_cont]" id="q_descripcion_cont" />
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
            @if($sepCertInstitucions->count())
                <table class="table table-condensed table-striped">
                    <thead>
                        <tr>
                            <th>@include('plantillas.getOrderLink', ['column' => 'id', 'title' => 'ID'])</th>
                            <th>@include('CrudDscaffold::getOrderlink', ['column' => 'id_institucion', 'title' => 'ID_INSTITUCION'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'descripcion', 'title' => 'DESCRIPCION'])</th>
                            <th class="text-right">OPCIONES</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($sepCertInstitucions as $sepCertInstitucion)
                            <tr>
                                <td>{{$sepCertInstitucion->id}}</td>
                                <td>{{$sepCertInstitucion->id_institucion}}</td>
                    <td>{{$sepCertInstitucion->descripcion}}</td>
                                <td class="text-right">
                                    @permission('sepCertInstitucions.edit')
                                    <a class="btn btn-xs btn-primary" href="{{ route('sepCertInstitucions.duplicate', $sepCertInstitucion->id) }}"><i class="glyphicon glyphicon-duplicate"></i> Duplicate</a>
                                    @endpermission
                                    @permission('sepCertInstitucions.edit')
                                    <a class="btn btn-xs btn-warning" href="{{ route('sepCertInstitucions.edit', $sepCertInstitucion->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                                    @endpermission
                                    @permission('sepCertInstitucions.destroy')
                                    {!! Form::model($sepCertInstitucion, array('route' => array('sepCertInstitucions.destroy', $sepCertInstitucion->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? ¿Esta seguro?')) { return true } else {return false };")) !!}
                                        <button type="submit" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i> Borrar</button>
                                    {!! Form::close() !!}
                                    @endpermission
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {!! $sepCertInstitucions->appends(Request::except('page'))->render() !!}
            @else
                <h3 class="text-center alert alert-info">Vacio!</h3>
            @endif

        </div>
    </div>

@endsection