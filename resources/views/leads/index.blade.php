@extends('plantillas.admin_template')

@include('leads._common')

@section('header')

    <ol class="breadcrumb">
    	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
        <!--
        @if ( $query_params = Request::input('q') )

            <li class="active"><a href="{{ route('leads.index') }}">@yield('leadsAppTitle')</a></li>
            <li class="active">condition(  

            @foreach( $query_params as $key => $value )
                @if (!$loop->first) / @endif {{ $key }} : {{ $value }}
            @endforeach
            )</li>
        @else
            <li class="active">@yield('leadsAppTitle')</li>
        @endif
        -->
        <li class="active">@yield('leadsAppTitle')</li>
    </ol>

    <div class="">
        <h3>
            <i class="glyphicon glyphicon-align-justify"></i> @yield('leadsAppTitle')
            @permission('leads.create')
            <a class="btn btn-success pull-right" href="{{ route('leads.create') }}"><i class="glyphicon glyphicon-plus"></i> Crear</a>
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
                    <form class="Lead_search" id="search" action="{{ route('leads.index') }}" accept-charset="UTF-8" method="get">
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
                                <label class="col-sm-2 control-label" for="q_email_gt">EMAIL</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['email_gt']) ?: '' }}" name="q[email_gt]" id="q_email_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['email_lt']) ?: '' }}" name="q[email_lt]" id="q_email_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_email_cont">EMAIL</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['email_cont']) ?: '' }}" name="q[email_cont]" id="q_email_cont" />
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
                                <label class="col-sm-2 control-label" for="q_ciclo_interesado_gt">CICLO_INTERESADO</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['ciclo_interesado_gt']) ?: '' }}" name="q[ciclo_interesado_gt]" id="q_ciclo_interesado_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['ciclo_interesado_lt']) ?: '' }}" name="q[ciclo_interesado_lt]" id="q_ciclo_interesado_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_ciclo_interesado_cont">CICLO_INTERESADO</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['ciclo_interesado_cont']) ?: '' }}" name="q[ciclo_interesado_cont]" id="q_ciclo_interesado_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_observaciones_gt">OBSERVACIONES</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['observaciones_gt']) ?: '' }}" name="q[observaciones_gt]" id="q_observaciones_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['observaciones_lt']) ?: '' }}" name="q[observaciones_lt]" id="q_observaciones_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_observaciones_cont">OBSERVACIONES</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['observaciones_cont']) ?: '' }}" name="q[observaciones_cont]" id="q_observaciones_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_st_leads.name_gt">ST_LEAD_NAME</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['st_leads.name_gt']) ?: '' }}" name="q[st_leads.name_gt]" id="q_st_leads.name_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['st_leads.name_lt']) ?: '' }}" name="q[st_leads.name_lt]" id="q_st_leads.name_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_st_leads.name_cont">ST_LEAD_NAME</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['st_leads.name_cont']) ?: '' }}" name="q[st_leads.name_cont]" id="q_st_leads.name_cont" />
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
            @if($leads->count())
                <table class="table table-condensed table-striped">
                    <thead>
                        <tr>
                            <th>@include('plantillas.getOrderLink', ['column' => 'id', 'title' => 'ID'])</th>
                            <th>@include('CrudDscaffold::getOrderlink', ['column' => 'nombre', 'title' => 'NOMBRE'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'tel_cel', 'title' => 'TEL.'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'medios.name', 'title' => 'MEDIO'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'ciclo_interesado', 'title' => 'CICLO INTERESADO'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'observaciones', 'title' => 'OBSERVACIONES'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'st_leads.name', 'title' => 'ESTATUS'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'st_leads.created_at', 'title' => 'CREADO EN'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'st_leads.contador_llamadas', 'title' => 'LLAMADAS'])</th>
                            <th class="text-right">OPCIONES</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($leads as $lead)
                            <tr>
                                <td><a href="{{ route('leads.show', $lead->id) }}">{{$lead->id}}</a></td>
                                <td>{{$lead->nombre}} {{$lead->nombre2}} {{$lead->ape_paterno}} {{$lead->ape_materno}}</td>
                    <td>{{$lead->tel_cel}}</td>
                    <td>{{$lead->medio->name}}</td>
                    <td>{{$lead->ciclo_interesado}}</td>
                    <td>{{$lead->observaciones}}</td>
                    <td>{{$lead->stLead->name}}</td>
                    <td>{{$lead->created_at}}</td>
                    <td>
                        {{$lead->contador_llamadas}}
                        @if($lead->contador_llamadas<10)
                        @permission('leads.agregarLlamada')
                        <a class="btn btn-xs btn-success" data-toggle="tooltip" title data-original-title="Agregar llamada" href="{{ route('leads.agregarLlamada', $lead->id) }}"><i class="glyphicon glyphicon-plus"></i> </a>
                        @endpermission
                        @permission('leads.quitarLlamada')
                        <a class="btn btn-xs btn-danger" data-toggle="tooltip" title data-original-title="Quitar llamada" href="{{ route('leads.quitarLlamada', $lead->id) }}"><i class="glyphicon glyphicon-minus"></i> </a>
                        @endpermission
                        @endif
                    </td>
                                <td class="text-right">
                                    @permission('leads.generarProspecto')
                                        <a class="btn btn-xs btn-success" target="_blank" data-toggle="tooltip" title data-original-title="Generar prospecto" href="{{ route('leads.generarProspecto', $lead->id) }}"><i class="glyphicon glyphicon-plus"></i>G. Prospecto </a>
                                    @endpermission
                                    @permission('leads.edit')
                                    <a class="btn btn-xs btn-warning" href="{{ route('leads.edit', $lead->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                                    @endpermission
                                    @permission('leads.destroy')
                                    {!! Form::model($lead, array('route' => array('leads.destroy', $lead->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? ¿Esta seguro?')) { return true } else {return false };")) !!}
                                        <button type="submit" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i> Borrar</button>
                                    {!! Form::close() !!}
                                    @endpermission
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {!! $leads->appends(Request::except('page'))->render() !!}
            @else
                <h3 class="text-center alert alert-info">Vacio!</h3>
            @endif

        </div>
    </div>

@endsection

@push('scripts')



<script>
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    });    
    $('#tooltip').tooltip();
    
</script>
@endpush