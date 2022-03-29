@extends('plantillas.admin_template')

@include('captacions._common')

@section('header')

    <ol class="breadcrumb">
    	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
        <!--
        @if ( $query_params = Request::input('q') )

            <li class="active"><a href="{{ route('captacions.index') }}">@yield('captacionsAppTitle')</a></li>
            <li class="active">condition(  

            @foreach( $query_params as $key => $value )
                @if (!$loop->first) / @endif {{ $key }} : {{ $value }}
            @endforeach
            )</li>
        @else
            <li class="active">@yield('captacionsAppTitle')</li>
        @endif
        -->
        <li class="active">@yield('captacionsAppTitle')</li>
    </ol>

    <div class="">
        <h3>
            <i class="glyphicon glyphicon-align-justify"></i> @yield('captacionsAppTitle')
            @permission('captacions.create')
            <a class="btn btn-success pull-right" href="{{ route('captacions.create') }}"><i class="glyphicon glyphicon-plus"></i> Crear</a>
            <a class="btn btn-warning pull-right" href="{{ route('captacions.carga') }}"><i class="glyphicon glyphicon-plus"></i> Carga Archivo</a>
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
                    <form class="Captacion_search" id="search" action="{{ route('captacions.index') }}" accept-charset="UTF-8" method="get">
                        <input type="hidden" name="q[s]" value="{{ @(Request::input('q')['s']) ?: '' }}" />
                        <div class="form-horizontal">

                            <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_plantel_gt">PLANTEL</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['plantel_gt']) ?: '' }}" name="q[plantel_gt]" id="q_plantel_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['plantel_lt']) ?: '' }}" name="q[plantel_lt]" id="q_plantel_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_plantel_cont">PLANTEL</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['plantel_cont']) ?: '' }}" name="q[plantel_cont]" id="q_plantel_cont" />
                                </div>
                            </div>
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
                                <label class="col-sm-2 control-label" for="q_tel_cel_gt">TEL_CEL</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['tel_cel_gt']) ?: '' }}" name="q[tel_cel_gt]" id="q_tel_cel_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['tel_cel_lt']) ?: '' }}" name="q[tel_cel_lt]" id="q_tel_cel_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_tel_cel_cont">TEL_CEL</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['tel_cel_cont']) ?: '' }}" name="q[tel_cel_cont]" id="q_tel_cel_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_tel_fijo_gt">TEL_FIJO</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['tel_fijo_gt']) ?: '' }}" name="q[tel_fijo_gt]" id="q_tel_fijo_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['tel_fijo_lt']) ?: '' }}" name="q[tel_fijo_lt]" id="q_tel_fijo_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_tel_fijo_cont">TEL_FIJO</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['tel_fijo_cont']) ?: '' }}" name="q[tel_fijo_cont]" id="q_tel_fijo_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_pais_gt">PAIS</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['pais_gt']) ?: '' }}" name="q[pais_gt]" id="q_pais_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['pais_lt']) ?: '' }}" name="q[pais_lt]" id="q_pais_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_pais_cont">PAIS</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['pais_cont']) ?: '' }}" name="q[pais_cont]" id="q_pais_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_medios.name_gt">MEDIO_NAME</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['medios.name_gt']) ?: '' }}" name="q[medios.name_gt]" id="q_medios.name_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['medios.name_lt']) ?: '' }}" name="q[medios.name_lt]" id="q_medios.name_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_medios.name_cont">MEDIO_NAME</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['medios.name_cont']) ?: '' }}" name="q[medios.name_cont]" id="q_medios.name_cont" />
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
            @if($captacions->count())
                <table class="table table-condensed table-striped">
                    <thead>
                        <tr>
                            <th>@include('plantillas.getOrderLink', ['column' => 'id', 'title' => 'ID'])</th>
                            <th>@include('CrudDscaffold::getOrderlink', ['column' => 'plantel', 'title' => 'PLANTEL'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'nombre', 'title' => 'NOMBRE'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'nombre2', 'title' => 'NOMBRE2'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'ape_paterno', 'title' => 'A. PATERNO'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'ape_materno', 'title' => 'A. MATERNO'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'mail', 'title' => 'MAIL'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'tel_fijo', 'title' => 'TEL. FIJO'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'medios.name', 'title' => 'MEDIO'])</th>
                            <th class="text-right">OPCIONES</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($captacions as $captacion)
                            <tr>
                                <td><a href="{{ route('captacions.show', $captacion->id) }}">{{$captacion->id}}</a></td>
                                <td>{{$captacion->plantel}}</td>
                    <td>{{$captacion->nombre}}</td>
                    <td>{{$captacion->nombre2}}</td>
                    <td>{{$captacion->ape_paterno}}</td>
                    <td>{{$captacion->ape_materno}}</td>
                    <td>{{$captacion->mail}}</td>
                    <td>{{$captacion->tel_fijo}}</td>
                    <td>{{$captacion->medio->name}}</td>
                                <td class="text-right">
                                    @permission('captacions.edit')
                                    <a class="btn btn-xs btn-primary" href="{{ route('captacions.duplicate', $captacion->id) }}"><i class="glyphicon glyphicon-duplicate"></i> Duplicate</a>
                                    @endpermission
                                    @permission('captacions.edit')
                                    <a class="btn btn-xs btn-warning" href="{{ route('captacions.edit', $captacion->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                                    @endpermission
                                    @permission('captacions.destroy')
                                    {!! Form::model($captacion, array('route' => array('captacions.destroy', $captacion->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? ¿Esta seguro?')) { return true } else {return false };")) !!}
                                        <button type="submit" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i> Borrar</button>
                                    {!! Form::close() !!}
                                    @endpermission
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {!! $captacions->appends(Request::except('page'))->render() !!}
            @else
                <h3 class="text-center alert alert-info">Vacio!</h3>
            @endif

        </div>
    </div>

@endsection