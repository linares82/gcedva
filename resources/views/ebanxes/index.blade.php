@extends('plantillas.admin_template')

@include('ebanxes._common')

@section('header')

    <ol class="breadcrumb">
    	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
        <!--
        @if ( $query_params = Request::input('q') )

            <li class="active"><a href="{{ route('ebanxes.index') }}">@yield('ebanxesAppTitle')</a></li>
            <li class="active">condition(  

            @foreach( $query_params as $key => $value )
                @if (!$loop->first) / @endif {{ $key }} : {{ $value }}
            @endforeach
            )</li>
        @else
            <li class="active">@yield('ebanxesAppTitle')</li>
        @endif
        -->
        <li class="active">@yield('ebanxesAppTitle')</li>
    </ol>

    <div class="">
        <h3>
            <i class="glyphicon glyphicon-align-justify"></i> @yield('ebanxesAppTitle')
            @permission('ebanxes.create')
            <a class="btn btn-success pull-right" href="{{ route('ebanxes.create') }}"><i class="glyphicon glyphicon-plus"></i> Crear</a>
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
                    <form class="Ebanx_search" id="search" action="{{ route('ebanxes.index') }}" accept-charset="UTF-8" method="get">
                        <input type="hidden" name="q[s]" value="{{ @(Request::input('q')['s']) ?: '' }}" />
                        <div class="form-horizontal">

                            <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_nombre_gt">NOMBRE</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['nombre_gt']) ?: '' }}" name="q[nombre_gt]" id="q_nombre_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['nombre_lt']) ?: '' }}" name="q[nombre_lt]" id="q_nombre_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_nombre_cont">NOMBRE</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['nombre_cont']) ?: '' }}" name="q[nombre_cont]" id="q_nombre_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_nombre2_gt">NOMBRE2</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['nombre2_gt']) ?: '' }}" name="q[nombre2_gt]" id="q_nombre2_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['nombre2_lt']) ?: '' }}" name="q[nombre2_lt]" id="q_nombre2_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_nombre2_cont">NOMBRE2</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['nombre2_cont']) ?: '' }}" name="q[nombre2_cont]" id="q_nombre2_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_ape_paterno_gt">APE_PATERNO</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['ape_paterno_gt']) ?: '' }}" name="q[ape_paterno_gt]" id="q_ape_paterno_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['ape_paterno_lt']) ?: '' }}" name="q[ape_paterno_lt]" id="q_ape_paterno_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_ape_paterno_cont">APE_PATERNO</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['ape_paterno_cont']) ?: '' }}" name="q[ape_paterno_cont]" id="q_ape_paterno_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_ape_materno_gt">APE_MATERNO</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['ape_materno_gt']) ?: '' }}" name="q[ape_materno_gt]" id="q_ape_materno_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['ape_materno_lt']) ?: '' }}" name="q[ape_materno_lt]" id="q_ape_materno_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_ape_materno_cont">APE_MATERNO</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['ape_materno_cont']) ?: '' }}" name="q[ape_materno_cont]" id="q_ape_materno_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_fel_fijo_gt">FEL_FIJO</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['fel_fijo_gt']) ?: '' }}" name="q[fel_fijo_gt]" id="q_fel_fijo_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['fel_fijo_lt']) ?: '' }}" name="q[fel_fijo_lt]" id="q_fel_fijo_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_fel_fijo_cont">TEL_FIJO</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['fel_tijo_cont']) ?: '' }}" name="q[tel_fijo_cont]" id="q_tel_fijo_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_mail_gt">MAIL</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['mail_gt']) ?: '' }}" name="q[mail_gt]" id="q_mail_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['mail_lt']) ?: '' }}" name="q[mail_lt]" id="q_mail_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_mail_cont">MAIL</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['mail_cont']) ?: '' }}" name="q[mail_cont]" id="q_mail_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_plantel_id_gt">PLANTEL_ID</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['plantel_id_gt']) ?: '' }}" name="q[plantel_id_gt]" id="q_plantel_id_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['plantel_id_lt']) ?: '' }}" name="q[plantel_id_lt]" id="q_plantel_id_lt" />
                                </div>
                            </div>
                            -->
                            
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_grado_id_cont">GRADO_ID</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['grado_id_cont']) ?: '' }}" name="q[grado_id_cont]" id="q_grado_id_cont" />
                                </div>
                            </div>
                            
                            
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_paise_id_cont">PAISE_ID</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['paise_id_cont']) ?: '' }}" name="q[paise_id_cont]" id="q_paise_id_cont" />
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
            @if($ebanxes->count())
                <table class="table table-condensed table-striped">
                    <thead>
                        <tr>
                            <th>@include('plantillas.getOrderLink', ['column' => 'id', 'title' => 'ID'])</th>
                            <th>@include('CrudDscaffold::getOrderlink', ['column' => 'nombre', 'title' => 'PRIMER NOMBRE'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'nombre2', 'title' => 'SEGUNDO NOMBRE'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'ape_paterno', 'title' => 'A. PATERNO'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'ape_materno', 'title' => 'A. MATERNO'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'tel_fijo', 'title' => 'TEL. FIJO'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'mail', 'title' => 'MAIL'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'grado_id', 'title' => 'GRADO'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'tel_cel', 'title' => 'T. CELULAR'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'paise_id', 'title' => 'PAIS'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'bnd_pagado', 'title' => 'PAGADO'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'fecha_pagado', 'title' => 'FECHA'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'bnd_procesado', 'title' => 'PROCESADO'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'fecha_procesado', 'title' => 'FECHA'])</th>
                            <th class="text-right">OPCIONES</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($ebanxes as $ebanx)
                            <tr>
                                @if($ebanx->cliente_id>0)
                                    <td><a href="{{route('clientes.edit', $ebanx->cliente_id)}}">{{$ebanx->id}}</a></td>
                                @else
                                    <td>{{$ebanx->id}}</td>
                                @endif
                                <td>{{$ebanx->nombre}}</td>
                                <td>{{$ebanx->nombre2}}</td>
                                <td>{{$ebanx->ape_paterno}}</td>
                                <td>{{$ebanx->ape_materno}}</td>
                                <td>{{$ebanx->tel_fijo}}</td>
                                <td>{{$ebanx->mail}}</td>
                                <td>{{$ebanx->grado->name}}</td>
                                <td>{{$ebanx->pais->marcado."-".$ebanx->tel_cel}}</td>
                                <td>{{$ebanx->pais->name}}</td>
                                <td>
                                    @if($ebanx->bnd_pagado==1)
                                    SI
                                    @else
                                    NO
                                    @endif
                                    
                                </td>
                                <td>
                                    @if($ebanx->bnd_pagado==1)
                                    {{$ebanx->fecha_pago}}
                                    @else
                                    
                                    @endif
                                </td>
                                <td>@if($ebanx->bnd_procesado==1)
                                    SI
                                    @else
                                    NO
                                    @endif
                                </td>
                                <td>
                                    @if($ebanx->bnd_procesado==1)
                                    {{$ebanx->fecha_procesado}}
                                    @else
                                    
                                    @endif
                                </td>
                                <td class="text-right">
                                    
                                    @permission('ebanxes.pagar')
                                    <a class="btn btn-xs btn-primary" href="{{ route('ebanxes.pagar', array('id'=>$ebanx->id)) }}" data-toggle="tooltip" title="Pagar" data-placement="top"><i class="fa fa-fw fa-money"></i> </a>
                                    @endpermission
                                    @permission('ebanxes.procesar')
                                    <a class="btn btn-xs btn-success" href="{{ route('ebanxes.procesar', array('id'=>$ebanx->id)) }}" data-toggle="tooltip" title="Procesar" data-placement="top"><i class="fa fa-fw fa-upload"></i></a>
                                    @endpermission
                                    @permission('ebanxes.edit')
                                    <a class="btn btn-xs btn-warning" href="{{ route('ebanxes.edit', $ebanx->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                                    @endpermission
                                    @permission('ebanxes.destroy')
                                    {!! Form::model($ebanx, array('route' => array('ebanxes.destroy', $ebanx->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? ¿Esta seguro?')) { return true } else {return false };")) !!}
                                        <button type="submit" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i> Borrar</button>
                                    {!! Form::close() !!}
                                    @endpermission
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {!! $ebanxes->appends(Request::except('page'))->render() !!}
            @else
                <h3 class="text-center alert alert-info">Vacio!</h3>
            @endif

        </div>
    </div>
@endsection
@push('scripts')
<script type="text/javascript">

$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();
});

</script>
@endpush