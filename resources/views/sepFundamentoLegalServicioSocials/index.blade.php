@extends('plantillas.admin_template')

@include('sepFundamentoLegalServicioSocials._common')

@section('header')

    <ol class="breadcrumb">
    	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
        <!--
        @if ( $query_params = Request::input('q') )

            <li class="active"><a href="{{ route('sepFundamentoLegalServicioSocials.index') }}">@yield('sepFundamentoLegalServicioSocialsAppTitle')</a></li>
            <li class="active">condition(  

            @foreach( $query_params as $key => $value )
                @if (!$loop->first) / @endif {{ $key }} : {{ $value }}
            @endforeach
            )</li>
        @else
            <li class="active">@yield('sepFundamentoLegalServicioSocialsAppTitle')</li>
        @endif
        -->
        <li class="active">@yield('sepFundamentoLegalServicioSocialsAppTitle')</li>
    </ol>

    <div class="">
        <h3>
            <i class="glyphicon glyphicon-align-justify"></i> @yield('sepFundamentoLegalServicioSocialsAppTitle')
            @permission('sepFundamentoLegalServicioSocials.create')
            <a class="btn btn-success pull-right" href="{{ route('sepFundamentoLegalServicioSocials.create') }}"><i class="glyphicon glyphicon-plus"></i> Crear</a>
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
                    <form class="SepFundamentoLegalServicioSocial_search" id="search" action="{{ route('sepFundamentoLegalServicioSocials.index') }}" accept-charset="UTF-8" method="get">
                        <input type="hidden" name="q[s]" value="{{ @(Request::input('q')['s']) ?: '' }}" />
                        <div class="form-horizontal">

                            <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_id_fundamento_legal_servicio_social_gt">ID_FUNDAMENTO_LEGAL_SERVICIO_SOCIAL</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['id_fundamento_legal_servicio_social_gt']) ?: '' }}" name="q[id_fundamento_legal_servicio_social_gt]" id="q_id_fundamento_legal_servicio_social_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['id_fundamento_legal_servicio_social_lt']) ?: '' }}" name="q[id_fundamento_legal_servicio_social_lt]" id="q_id_fundamento_legal_servicio_social_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_id_fundamento_legal_servicio_social_cont">ID_FUNDAMENTO_LEGAL_SERVICIO_SOCIAL</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['id_fundamento_legal_servicio_social_cont']) ?: '' }}" name="q[id_fundamento_legal_servicio_social_cont]" id="q_id_fundamento_legal_servicio_social_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_fundamento_legal_servicio_social_gt">FUNDAMENTO_LEGAL_SERVICIO_SOCIAL</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['fundamento_legal_servicio_social_gt']) ?: '' }}" name="q[fundamento_legal_servicio_social_gt]" id="q_fundamento_legal_servicio_social_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['fundamento_legal_servicio_social_lt']) ?: '' }}" name="q[fundamento_legal_servicio_social_lt]" id="q_fundamento_legal_servicio_social_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_fundamento_legal_servicio_social_cont">FUNDAMENTO_LEGAL_SERVICIO_SOCIAL</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['fundamento_legal_servicio_social_cont']) ?: '' }}" name="q[fundamento_legal_servicio_social_cont]" id="q_fundamento_legal_servicio_social_cont" />
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
            @if($sepFundamentoLegalServicioSocials->count())
                <table class="table table-condensed table-striped">
                    <thead>
                        <tr>
                            <th>@include('plantillas.getOrderLink', ['column' => 'id', 'title' => 'ID'])</th>
                            <th>@include('CrudDscaffold::getOrderlink', ['column' => 'id_fundamento_legal_servicio_social', 'title' => 'ID_FUNDAMENTO_LEGAL_SERVICIO_SOCIAL'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'fundamento_legal_servicio_social', 'title' => 'FUNDAMENTO_LEGAL_SERVICIO_SOCIAL'])</th>
                            <th class="text-right">OPCIONES</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($sepFundamentoLegalServicioSocials as $sepFundamentoLegalServicioSocial)
                            <tr>
                                <td>{{$sepFundamentoLegalServicioSocial->id}}</td>
                                <td>{{$sepFundamentoLegalServicioSocial->id_fundamento_legal_servicio_social}}</td>
                    <td>{{$sepFundamentoLegalServicioSocial->fundamento_legal_servicio_social}}</td>
                                <td class="text-right">
                                    @permission('sepFundamentoLegalServicioSocials.edit')
                                    <a class="btn btn-xs btn-primary" href="{{ route('sepFundamentoLegalServicioSocials.duplicate', $sepFundamentoLegalServicioSocial->id) }}"><i class="glyphicon glyphicon-duplicate"></i> Duplicate</a>
                                    @endpermission
                                    @permission('sepFundamentoLegalServicioSocials.edit')
                                    <a class="btn btn-xs btn-warning" href="{{ route('sepFundamentoLegalServicioSocials.edit', $sepFundamentoLegalServicioSocial->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                                    @endpermission
                                    @permission('sepFundamentoLegalServicioSocials.destroy')
                                    {!! Form::model($sepFundamentoLegalServicioSocial, array('route' => array('sepFundamentoLegalServicioSocials.destroy', $sepFundamentoLegalServicioSocial->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? ¿Esta seguro?')) { return true } else {return false };")) !!}
                                        <button type="submit" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i> Borrar</button>
                                    {!! Form::close() !!}
                                    @endpermission
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {!! $sepFundamentoLegalServicioSocials->appends(Request::except('page'))->render() !!}
            @else
                <h3 class="text-center alert alert-info">Vacio!</h3>
            @endif

        </div>
    </div>

@endsection