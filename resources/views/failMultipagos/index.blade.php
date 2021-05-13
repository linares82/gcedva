@extends('plantillas.admin_template')

@include('failMultipagos._common')

@section('header')

    <ol class="breadcrumb">
    	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
        <!--
        @if ( $query_params = Request::input('q') )

            <li class="active"><a href="{{ route('failMultipagos.index') }}">@yield('failMultipagosAppTitle')</a></li>
            <li class="active">condition(  

            @foreach( $query_params as $key => $value )
                @if (!$loop->first) / @endif {{ $key }} : {{ $value }}
            @endforeach
            )</li>
        @else
            <li class="active">@yield('failMultipagosAppTitle')</li>
        @endif
        -->
        <li class="active">@yield('failMultipagosAppTitle')</li>
    </ol>

    <div class="">
        <h3>
            <i class="glyphicon glyphicon-align-justify"></i> @yield('failMultipagosAppTitle')
            @permission('failMultipagos.create')
            <a class="btn btn-success pull-right" href="{{ route('failMultipagos.create') }}"><i class="glyphicon glyphicon-plus"></i> Crear</a>
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
                    <form class="FailMultipago_search" id="search" action="{{ route('failMultipagos.index') }}" accept-charset="UTF-8" method="get">
                        <input type="hidden" name="q[s]" value="{{ @(Request::input('q')['s']) ?: '' }}" />
                        <div class="form-horizontal">

                            <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_mp_order_gt">MP_ORDER</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['mp_order_gt']) ?: '' }}" name="q[mp_order_gt]" id="q_mp_order_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['mp_order_lt']) ?: '' }}" name="q[mp_order_lt]" id="q_mp_order_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_mp_order_cont">MP_ORDER</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['mp_order_cont']) ?: '' }}" name="q[mp_order_cont]" id="q_mp_order_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_mp_reference_gt">MP_REFERENCE</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['mp_reference_gt']) ?: '' }}" name="q[mp_reference_gt]" id="q_mp_reference_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['mp_reference_lt']) ?: '' }}" name="q[mp_reference_lt]" id="q_mp_reference_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_mp_reference_cont">MP_REFERENCE</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['mp_reference_cont']) ?: '' }}" name="q[mp_reference_cont]" id="q_mp_reference_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_mp_amount_gt">MP_AMOUNT</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['mp_amount_gt']) ?: '' }}" name="q[mp_amount_gt]" id="q_mp_amount_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['mp_amount_lt']) ?: '' }}" name="q[mp_amount_lt]" id="q_mp_amount_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_mp_amount_cont">MP_AMOUNT</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['mp_amount_cont']) ?: '' }}" name="q[mp_amount_cont]" id="q_mp_amount_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_mp_response_gt">MP_RESPONSE</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['mp_response_gt']) ?: '' }}" name="q[mp_response_gt]" id="q_mp_response_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['mp_response_lt']) ?: '' }}" name="q[mp_response_lt]" id="q_mp_response_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_mp_response_cont">MP_RESPONSE</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['mp_response_cont']) ?: '' }}" name="q[mp_response_cont]" id="q_mp_response_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_mp_responsemsg_gt">MP_RESPONSEMSG</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['mp_responsemsg_gt']) ?: '' }}" name="q[mp_responsemsg_gt]" id="q_mp_responsemsg_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['mp_responsemsg_lt']) ?: '' }}" name="q[mp_responsemsg_lt]" id="q_mp_responsemsg_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_mp_responsemsg_cont">MP_RESPONSEMSG</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['mp_responsemsg_cont']) ?: '' }}" name="q[mp_responsemsg_cont]" id="q_mp_responsemsg_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_mp_authorization_gt">MP_AUTHORIZATION</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['mp_authorization_gt']) ?: '' }}" name="q[mp_authorization_gt]" id="q_mp_authorization_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['mp_authorization_lt']) ?: '' }}" name="q[mp_authorization_lt]" id="q_mp_authorization_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_mp_authorization_cont">MP_AUTHORIZATION</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['mp_authorization_cont']) ?: '' }}" name="q[mp_authorization_cont]" id="q_mp_authorization_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_mp_signature_gt">MP_SIGNATURE</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['mp_signature_gt']) ?: '' }}" name="q[mp_signature_gt]" id="q_mp_signature_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['mp_signature_lt']) ?: '' }}" name="q[mp_signature_lt]" id="q_mp_signature_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_mp_signature_cont">MP_SIGNATURE</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['mp_signature_cont']) ?: '' }}" name="q[mp_signature_cont]" id="q_mp_signature_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_ usu_alta_id_gt"> USU_ALTA_ID</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')[' usu_alta_id_gt']) ?: '' }}" name="q[ usu_alta_id_gt]" id="q_ usu_alta_id_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')[' usu_alta_id_lt']) ?: '' }}" name="q[ usu_alta_id_lt]" id="q_ usu_alta_id_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_ usu_alta_id_cont"> USU_ALTA_ID</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')[' usu_alta_id_cont']) ?: '' }}" name="q[ usu_alta_id_cont]" id="q_ usu_alta_id_cont" />
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
            @if($failMultipagos->count())
                <table class="table table-condensed table-striped">
                    <thead>
                        <tr>
                            <th>@include('plantillas.getOrderLink', ['column' => 'id', 'title' => 'ID'])</th>
                            <th>@include('plantillas.getOrderlink', ['column' => 'mp_order', 'title' => 'MP_ORDER'])</th>
                        <th>@include('plantillas.getOrderlink', ['column' => 'mp_reference', 'title' => 'MP_REFERENCE'])</th>
                        <th>@include('plantillas.getOrderlink', ['column' => 'mp_amount', 'title' => 'MP_AMOUNT'])</th>
                        <th>@include('plantillas.getOrderlink', ['column' => 'mp_response', 'title' => 'MP_RESPONSE'])</th>
                        <th>@include('plantillas.getOrderlink', ['column' => 'mp_responsemsg', 'title' => 'MP_RESPONSEMSG'])</th>
                        <th>@include('plantillas.getOrderlink', ['column' => 'mp_authorization', 'title' => 'MP_AUTHORIZATION'])</th>
                        <th>@include('plantillas.getOrderlink', ['column' => 'mp_signature', 'title' => 'MP_SIGNATURE'])</th>
                        <th>@include('plantillas.getOrderlink', ['column' => ' usu_alta_id', 'title' => ' USU_ALTA_ID'])</th>
                        <th>@include('plantillas.getOrderlink', ['column' => 'usu_mod_id', 'title' => 'USU_MOD_ID'])</th>
                            <th class="text-right">OPCIONES</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($failMultipagos as $failMultipago)
                            <tr>
                                <td><a href="{{ route('failMultipagos.show', $failMultipago->id) }}">{{$failMultipago->id}}</a></td>
                                <td>{{$failMultipago->mp_order}}</td>
                    <td>{{$failMultipago->mp_reference}}</td>
                    <td>{{$failMultipago->mp_amount}}</td>
                    <td>{{$failMultipago->mp_response}}</td>
                    <td>{{$failMultipago->mp_responsemsg}}</td>
                    <td>{{$failMultipago->mp_authorization}}</td>
                    <td>{{$failMultipago->mp_signature}}</td>
                    <td>{{$failMultipago-> usu_alta_id}}</td>
                    <td>{{$failMultipago->usu_mod_id}}</td>
                                <td class="text-right">
                                    @permission('failMultipagos.edit')
                                    <a class="btn btn-xs btn-primary" href="{{ route('failMultipagos.duplicate', $failMultipago->id) }}"><i class="glyphicon glyphicon-duplicate"></i> Duplicate</a>
                                    @endpermission
                                    @permission('failMultipagos.edit')
                                    <a class="btn btn-xs btn-warning" href="{{ route('failMultipagos.edit', $failMultipago->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                                    @endpermission
                                    @permission('failMultipagos.destroy')
                                    {!! Form::model($failMultipago, array('route' => array('failMultipagos.destroy', $failMultipago->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? ¿Esta seguro?')) { return true } else {return false };")) !!}
                                        <button type="submit" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i> Borrar</button>
                                    {!! Form::close() !!}
                                    @endpermission
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {!! $failMultipagos->appends(Request::except('page'))->render() !!}
            @else
                <h3 class="text-center alert alert-info">Vacio!</h3>
            @endif

        </div>
    </div>

@endsection