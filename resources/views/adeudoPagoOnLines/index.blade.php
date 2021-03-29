@extends('plantillas.admin_template')

@include('adeudoPagoOnLines._common')

@section('header')

    <ol class="breadcrumb">
    	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
        <!--
        @if ( $query_params = Request::input('q') )

            <li class="active"><a href="{{ route('adeudoPagoOnLines.index') }}">@yield('adeudoPagoOnLinesAppTitle')</a></li>
            <li class="active">condition(  

            @foreach( $query_params as $key => $value )
                @if (!$loop->first) / @endif {{ $key }} : {{ $value }}
            @endforeach
            )</li>
        @else
            <li class="active">@yield('adeudoPagoOnLinesAppTitle')</li>
        @endif
        -->
        <li class="active">@yield('adeudoPagoOnLinesAppTitle')</li>
    </ol>

    <div class="">
        <h3>
            <i class="glyphicon glyphicon-align-justify"></i> @yield('adeudoPagoOnLinesAppTitle')
            @permission('adeudoPagoOnLines.create')
            <a class="btn btn-success pull-right" href="{{ route('adeudoPagoOnLines.create') }}"><i class="glyphicon glyphicon-plus"></i> Crear</a>
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
                    <form class="AdeudoPagoOnLine_search" id="search" action="{{ route('adeudoPagoOnLines.index') }}" accept-charset="UTF-8" method="get">
                        <input type="hidden" name="q[s]" value="{{ @(Request::input('q')['s']) ?: '' }}" />
                        <div class="form-horizontal">

                            <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_adeudos.id_gt">ADEUDO_ID</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['adeudos.id_gt']) ?: '' }}" name="q[adeudos.id_gt]" id="q_adeudos.id_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['adeudos.id_lt']) ?: '' }}" name="q[adeudos.id_lt]" id="q_adeudos.id_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_adeudos.id_cont">ADEUDO_ID</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['adeudos.id_cont']) ?: '' }}" name="q[adeudos.id_cont]" id="q_adeudos.id_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_subtotal_gt">SUBTOTAL</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['subtotal_gt']) ?: '' }}" name="q[subtotal_gt]" id="q_subtotal_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['subtotal_lt']) ?: '' }}" name="q[subtotal_lt]" id="q_subtotal_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_subtotal_cont">SUBTOTAL</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['subtotal_cont']) ?: '' }}" name="q[subtotal_cont]" id="q_subtotal_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_descuento_gt">DESCUENTO</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['descuento_gt']) ?: '' }}" name="q[descuento_gt]" id="q_descuento_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['descuento_lt']) ?: '' }}" name="q[descuento_lt]" id="q_descuento_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_descuento_cont">DESCUENTO</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['descuento_cont']) ?: '' }}" name="q[descuento_cont]" id="q_descuento_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_recargo_gt">RECARGO</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['recargo_gt']) ?: '' }}" name="q[recargo_gt]" id="q_recargo_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['recargo_lt']) ?: '' }}" name="q[recargo_lt]" id="q_recargo_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_recargo_cont">RECARGO</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['recargo_cont']) ?: '' }}" name="q[recargo_cont]" id="q_recargo_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_cliente_id_gt">CLIENTE_ID</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['cliente_id_gt']) ?: '' }}" name="q[cliente_id_gt]" id="q_cliente_id_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['cliente_id_lt']) ?: '' }}" name="q[cliente_id_lt]" id="q_cliente_id_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_cliente_id_cont">CLIENTE_ID</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['cliente_id_cont']) ?: '' }}" name="q[cliente_id_cont]" id="q_cliente_id_cont" />
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
            @if($adeudoPagoOnLines->count())
                <table class="table table-condensed table-striped">
                    <thead>
                        <tr>
                            <th>@include('plantillas.getOrderLink', ['column' => 'id', 'title' => 'ID'])</th>
                            <th>@include('CrudDscaffold::getOrderlink', ['column' => 'adeudos.id', 'title' => 'ADEUDO_ID'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'subtotal', 'title' => 'SUBTOTAL'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'descuento', 'title' => 'DESCUENTO'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'recargo', 'title' => 'RECARGO'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'cliente_id', 'title' => 'CLIENTE_ID'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'usu_alta_id', 'title' => 'USU_ALTA_ID'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'usu_mod_id', 'title' => 'USU_MOD_ID'])</th>
                            <th class="text-right">OPCIONES</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($adeudoPagoOnLines as $adeudoPagoOnLine)
                            <tr>
                                <td><a href="{{ route('adeudoPagoOnLines.show', $adeudoPagoOnLine->id) }}">{{$adeudoPagoOnLine->id}}</a></td>
                                <td>{{$adeudoPagoOnLine->adeudo->id}}</td>
                    <td>{{$adeudoPagoOnLine->subtotal}}</td>
                    <td>{{$adeudoPagoOnLine->descuento}}</td>
                    <td>{{$adeudoPagoOnLine->recargo}}</td>
                    <td>{{$adeudoPagoOnLine->cliente_id}}</td>
                    <td>{{$adeudoPagoOnLine->usu_alta_id}}</td>
                    <td>{{$adeudoPagoOnLine->usu_mod_id}}</td>
                                <td class="text-right">
                                    @permission('adeudoPagoOnLines.edit')
                                    <a class="btn btn-xs btn-primary" href="{{ route('adeudoPagoOnLines.duplicate', $adeudoPagoOnLine->id) }}"><i class="glyphicon glyphicon-duplicate"></i> Duplicate</a>
                                    @endpermission
                                    @permission('adeudoPagoOnLines.edit')
                                    <a class="btn btn-xs btn-warning" href="{{ route('adeudoPagoOnLines.edit', $adeudoPagoOnLine->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                                    @endpermission
                                    @permission('adeudoPagoOnLines.destroy')
                                    {!! Form::model($adeudoPagoOnLine, array('route' => array('adeudoPagoOnLines.destroy', $adeudoPagoOnLine->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? ¿Esta seguro?')) { return true } else {return false };")) !!}
                                        <button type="submit" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i> Borrar</button>
                                    {!! Form::close() !!}
                                    @endpermission
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {!! $adeudoPagoOnLines->appends(Request::except('page'))->render() !!}
            @else
                <h3 class="text-center alert alert-info">Vacio!</h3>
            @endif

        </div>
    </div>

@endsection