@extends('plantillas.admin_template')

@include('peticionMultipagos._common')

@section('header')

    <ol class="breadcrumb">
    	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
        <!--
        @if ( $query_params = Request::input('q') )

            <li class="active"><a href="{{ route('peticionMultipagos.index') }}">@yield('peticionMultipagosAppTitle')</a></li>
            <li class="active">condition(  

            @foreach( $query_params as $key => $value )
                @if (!$loop->first) / @endif {{ $key }} : {{ $value }}
            @endforeach
            )</li>
        @else
            <li class="active">@yield('peticionMultipagosAppTitle')</li>
        @endif
        -->
        <li class="active">@yield('peticionMultipagosAppTitle')</li>
    </ol>

    <div class="">
        <h3>
            <i class="glyphicon glyphicon-align-justify"></i> @yield('peticionMultipagosAppTitle')
            @permission('peticionMultipagos.create')
            <a class="btn btn-success pull-right" href="{{ route('peticionMultipagos.create') }}"><i class="glyphicon glyphicon-plus"></i> Crear</a>
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
                    <form class="PeticionMultipago_search" id="search" action="{{ route('peticionMultipagos.index') }}" accept-charset="UTF-8" method="get">
                        <input type="hidden" name="q[s]" value="{{ @(Request::input('q')['s']) ?: '' }}" />
                        <div class="form-horizontal">

                            <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_mp_account_gt">MP_ACCOUNT</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['mp_account_gt']) ?: '' }}" name="q[mp_account_gt]" id="q_mp_account_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['mp_account_lt']) ?: '' }}" name="q[mp_account_lt]" id="q_mp_account_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_mp_account_cont">MP_ACCOUNT</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['mp_account_cont']) ?: '' }}" name="q[mp_account_cont]" id="q_mp_account_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_mp_product_gt">MP_PRODUCT</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['mp_product_gt']) ?: '' }}" name="q[mp_product_gt]" id="q_mp_product_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['mp_product_lt']) ?: '' }}" name="q[mp_product_lt]" id="q_mp_product_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_mp_product_cont">MP_PRODUCT</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['mp_product_cont']) ?: '' }}" name="q[mp_product_cont]" id="q_mp_product_cont" />
                                </div>
                            </div>
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
                                <label class="col-sm-2 control-label" for="q_mp_node_gt">MP_NODE</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['mp_node_gt']) ?: '' }}" name="q[mp_node_gt]" id="q_mp_node_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['mp_node_lt']) ?: '' }}" name="q[mp_node_lt]" id="q_mp_node_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_mp_node_cont">MP_NODE</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['mp_node_cont']) ?: '' }}" name="q[mp_node_cont]" id="q_mp_node_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_mp_concept_gt">MP_CONCEPT</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['mp_concept_gt']) ?: '' }}" name="q[mp_concept_gt]" id="q_mp_concept_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['mp_concept_lt']) ?: '' }}" name="q[mp_concept_lt]" id="q_mp_concept_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_mp_concept_cont">MP_CONCEPT</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['mp_concept_cont']) ?: '' }}" name="q[mp_concept_cont]" id="q_mp_concept_cont" />
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
                                <label class="col-sm-2 control-label" for="q_mp_customername_gt">MP_CUSTOMERNAME</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['mp_customername_gt']) ?: '' }}" name="q[mp_customername_gt]" id="q_mp_customername_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['mp_customername_lt']) ?: '' }}" name="q[mp_customername_lt]" id="q_mp_customername_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_mp_customername_cont">MP_CUSTOMERNAME</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['mp_customername_cont']) ?: '' }}" name="q[mp_customername_cont]" id="q_mp_customername_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_mp_currency_gt">MP_CURRENCY</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['mp_currency_gt']) ?: '' }}" name="q[mp_currency_gt]" id="q_mp_currency_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['mp_currency_lt']) ?: '' }}" name="q[mp_currency_lt]" id="q_mp_currency_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_mp_currency_cont">MP_CURRENCY</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['mp_currency_cont']) ?: '' }}" name="q[mp_currency_cont]" id="q_mp_currency_cont" />
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
                                <label class="col-sm-2 control-label" for="q_mp_urlsuccess_gt">MP_URLSUCCESS</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['mp_urlsuccess_gt']) ?: '' }}" name="q[mp_urlsuccess_gt]" id="q_mp_urlsuccess_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['mp_urlsuccess_lt']) ?: '' }}" name="q[mp_urlsuccess_lt]" id="q_mp_urlsuccess_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_mp_urlsuccess_cont">MP_URLSUCCESS</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['mp_urlsuccess_cont']) ?: '' }}" name="q[mp_urlsuccess_cont]" id="q_mp_urlsuccess_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_mp_urlfailure_gt">MP_URLFAILURE</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['mp_urlfailure_gt']) ?: '' }}" name="q[mp_urlfailure_gt]" id="q_mp_urlfailure_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['mp_urlfailure_lt']) ?: '' }}" name="q[mp_urlfailure_lt]" id="q_mp_urlfailure_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_mp_urlfailure_cont">MP_URLFAILURE</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['mp_urlfailure_cont']) ?: '' }}" name="q[mp_urlfailure_cont]" id="q_mp_urlfailure_cont" />
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
            @if($peticionMultipagos->count())
                <table class="table table-condensed table-striped">
                    <thead>
                        <tr>
                            <th>@include('plantillas.getOrderLink', ['column' => 'id', 'title' => 'ID'])</th>
                            <th>@include('CrudDscaffold::getOrderlink', ['column' => 'mp_account', 'title' => 'MP_ACCOUNT'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'mp_product', 'title' => 'MP_PRODUCT'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'mp_order', 'title' => 'MP_ORDER'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'mp_reference', 'title' => 'MP_REFERENCE'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'mp_node', 'title' => 'MP_NODE'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'mp_concept', 'title' => 'MP_CONCEPT'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'mp_amount', 'title' => 'MP_AMOUNT'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'mp_customername', 'title' => 'MP_CUSTOMERNAME'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'mp_currency', 'title' => 'MP_CURRENCY'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'mp_signature', 'title' => 'MP_SIGNATURE'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'mp_urlsuccess', 'title' => 'MP_URLSUCCESS'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'mp_urlfailure', 'title' => 'MP_URLFAILURE'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'usu_alta_id', 'title' => 'USU_ALTA_ID'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'usu_mod_id', 'title' => 'USU_MOD_ID'])</th>
                            <th class="text-right">OPCIONES</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($peticionMultipagos as $peticionMultipago)
                            <tr>
                                <td><a href="{{ route('peticionMultipagos.show', $peticionMultipago->id) }}">{{$peticionMultipago->id}}</a></td>
                                <td>{{$peticionMultipago->mp_account}}</td>
                    <td>{{$peticionMultipago->mp_product}}</td>
                    <td>{{$peticionMultipago->mp_order}}</td>
                    <td>{{$peticionMultipago->mp_reference}}</td>
                    <td>{{$peticionMultipago->mp_node}}</td>
                    <td>{{$peticionMultipago->mp_concept}}</td>
                    <td>{{$peticionMultipago->mp_amount}}</td>
                    <td>{{$peticionMultipago->mp_customername}}</td>
                    <td>{{$peticionMultipago->mp_currency}}</td>
                    <td>{{$peticionMultipago->mp_signature}}</td>
                    <td>{{$peticionMultipago->mp_urlsuccess}}</td>
                    <td>{{$peticionMultipago->mp_urlfailure}}</td>
                    <td>{{$peticionMultipago->usu_alta_id}}</td>
                    <td>{{$peticionMultipago->usu_mod_id}}</td>
                                <td class="text-right">
                                    @permission('peticionMultipagos.edit')
                                    <a class="btn btn-xs btn-primary" href="{{ route('peticionMultipagos.duplicate', $peticionMultipago->id) }}"><i class="glyphicon glyphicon-duplicate"></i> Duplicate</a>
                                    @endpermission
                                    @permission('peticionMultipagos.edit')
                                    <a class="btn btn-xs btn-warning" href="{{ route('peticionMultipagos.edit', $peticionMultipago->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                                    @endpermission
                                    @permission('peticionMultipagos.destroy')
                                    {!! Form::model($peticionMultipago, array('route' => array('peticionMultipagos.destroy', $peticionMultipago->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? ¿Esta seguro?')) { return true } else {return false };")) !!}
                                        <button type="submit" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i> Borrar</button>
                                    {!! Form::close() !!}
                                    @endpermission
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {!! $peticionMultipagos->appends(Request::except('page'))->render() !!}
            @else
                <h3 class="text-center alert alert-info">Vacio!</h3>
            @endif

        </div>
    </div>

@endsection