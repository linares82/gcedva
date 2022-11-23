@extends('plantillas.admin_template')

@include('prospectos._common')

@section('header')

    <ol class="breadcrumb">
    	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
        <!--
        @if ( $query_params = Request::input('q') )

            <li class="active"><a href="{{ route('prospectos.index') }}">@yield('prospectosAppTitle')</a></li>
            <li class="active">condition(  

            @foreach( $query_params as $key => $value )
                @if (!$loop->first) / @endif {{ $key }} : {{ $value }}
            @endforeach
            )</li>
        @else
            <li class="active">@yield('prospectosAppTitle')</li>
        @endif
        -->
        <li class="active">@yield('prospectosAppTitle')</li>
    </ol>

    <div class="">
        <h3>
            <i class="glyphicon glyphicon-align-justify"></i> @yield('prospectosAppTitle')
            @permission('prospectos.create')
            <a class="btn btn-success pull-right" href="{{ route('prospectos.create') }}"><i class="glyphicon glyphicon-plus"></i> Crear</a>
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
                    <form class="Prospecto_search" id="search" action="{{ route('prospectos.index') }}" accept-charset="UTF-8" method="get">
                        <input type="hidden" name="q[s]" value="{{ @(Request::input('q')['s']) ?: '' }}" />
                        <div class="">
                        <div class="form-group col-md-4">
                            <label class=" control-label" for="q_id_cont">Id</label>
                                <div class="">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['id_cont']) ?: '' }}" name="q[id_cont]" id="q_id_cont" />
                                </div>
                            </div>
                            <!--
                            <div class="form-group">
                                <label class=" control-label" for="q_nombre_gt">NOMBRE</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['nombre_gt']) ?: '' }}" name="q[nombre_gt]" id="q_nombre_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['nombre_lt']) ?: '' }}" name="q[nombre_lt]" id="q_nombre_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group col-md-4">
                                <label class=" control-label" for="q_nombre_cont">NOMBRE</label>
                                <div class="">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['nombre_cont']) ?: '' }}" name="q[nombre_cont]" id="q_nombre_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class=" control-label" for="q_nombre2_gt">NOMBRE2</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['nombre2_gt']) ?: '' }}" name="q[nombre2_gt]" id="q_nombre2_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['nombre2_lt']) ?: '' }}" name="q[nombre2_lt]" id="q_nombre2_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group col-md-4">
                                <label class=" control-label" for="q_nombre2_cont"> SEGUNDO NOMBRE</label>
                                <div class="">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['nombre2_cont']) ?: '' }}" name="q[nombre2_cont]" id="q_nombre2_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class=" control-label" for="q_ape_paterno_gt">APE_PATERNO</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['ape_paterno_gt']) ?: '' }}" name="q[ape_paterno_gt]" id="q_ape_paterno_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['ape_paterno_lt']) ?: '' }}" name="q[ape_paterno_lt]" id="q_ape_paterno_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group col-md-4">
                                <label class=" control-label" for="q_ape_paterno_cont">A. PATERNO</label>
                                <div class="">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['ape_paterno_cont']) ?: '' }}" name="q[ape_paterno_cont]" id="q_ape_paterno_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class=" control-label" for="q_ape_materno_gt">APE_MATERNO</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['ape_materno_gt']) ?: '' }}" name="q[ape_materno_gt]" id="q_ape_materno_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['ape_materno_lt']) ?: '' }}" name="q[ape_materno_lt]" id="q_ape_materno_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group col-md-4">
                                <label class=" control-label" for="q_ape_materno_cont">A. MATERNO</label>
                                <div class="">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['ape_materno_cont']) ?: '' }}" name="q[ape_materno_cont]" id="q_ape_materno_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class=" control-label" for="q_tel_fijo_gt">TEL_FIJO</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['tel_fijo_gt']) ?: '' }}" name="q[tel_fijo_gt]" id="q_tel_fijo_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['tel_fijo_lt']) ?: '' }}" name="q[tel_fijo_lt]" id="q_tel_fijo_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group col-md-4">
                                <label class=" control-label" for="q_tel_fijo_cont">T. FIJO</label>
                                <div class="">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['tel_fijo_cont']) ?: '' }}" name="q[tel_fijo_cont]" id="q_tel_fijo_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class=" control-label" for="q_tel_cel_gt">TEL_CEL</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['tel_cel_gt']) ?: '' }}" name="q[tel_cel_gt]" id="q_tel_cel_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['tel_cel_lt']) ?: '' }}" name="q[tel_cel_lt]" id="q_tel_cel_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group col-md-4">
                                <label class=" control-label" for="q_tel_cel_cont">T. CELULAR</label>
                                <div class="">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['tel_cel_cont']) ?: '' }}" name="q[tel_cel_cont]" id="q_tel_cel_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class=" control-label" for="q_mail_gt">MAIL</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['mail_gt']) ?: '' }}" name="q[mail_gt]" id="q_mail_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['mail_lt']) ?: '' }}" name="q[mail_lt]" id="q_mail_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group col-md-4">
                                <label class=" control-label" for="q_mail_cont">MAIL</label>
                                <div class="">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['mail_cont']) ?: '' }}" name="q[mail_cont]" id="q_mail_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class=" control-label" for="q_plantels.razon_gt">PLANTEL_RAZON</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['plantels.razon_gt']) ?: '' }}" name="q[plantels.razon_gt]" id="q_plantels.razon_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['plantels.razon_lt']) ?: '' }}" name="q[plantels.razon_lt]" id="q_plantels.razon_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group col-md-4" >
                                <label for="q_prospectos.prospectos_id_lt">PLANTEL</label>
                                
                                    {!! Form::select("prospectos.plantel_id", $list["Plantel"], "{{ @(Request::input('q')['prospectos.plantel_id_lt']) ?: '' }}", array("class" => "form-control select_seguridad", "name"=>"q[prospectos.plantel_id_lt]", "id"=>"q_prospectos.plantel_id_lt", "style"=>"width:100%;")) !!}
                                    <div id='loading10' style='display: none'><img src="{{ asset('images/ajax-loader.gif') }}" title="Enviando" /></div> 
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class=" control-label" for="q_especialidads.name_gt">ESPECIALIDAD_NAME</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['especialidads.name_gt']) ?: '' }}" name="q[especialidads.name_gt]" id="q_especialidads.name_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['especialidads.name_lt']) ?: '' }}" name="q[especialidads.name_lt]" id="q_especialidads.name_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group col-md-4" >
                                <label for="q_prospectos.especialidad_id_lt">ESPECIALIDAD</label>
                                    {!! Form::select("prospectos.especialidad_id", $list["Especialidad"], "{{ @(Request::input('q')['prospectos.especialidad_id_lt']) ?: '' }}", array("class" => "form-control select_seguridad", "name"=>"q[prospectos.especialidad_id_lt]", "id"=>"q_prospectos.especialidad_id_lt", "style"=>"width:100%;")) !!}
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class=" control-label" for="q_nivels.name_gt">NIVEL_NAME</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['nivels.name_gt']) ?: '' }}" name="q[nivels.name_gt]" id="q_nivels.name_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['nivels.name_lt']) ?: '' }}" name="q[nivels.name_lt]" id="q_nivels.name_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group col-md-4" >
                                <label for="q_prospectos.nivel_id_lt">nivel</label>
                                    {!! Form::select("prospectos.nivel_id", $list["Nivel"], "{{ @(Request::input('q')['prospectos.nivel_id_lt']) ?: '' }}", array("class" => "form-control select_seguridad", "name"=>"q[prospectos.nivel_id_lt]", "id"=>"q_prospectos.nivel_id_lt", "style"=>"width:100%;")) !!}
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class=" control-label" for="q_medios.name_gt">MEDIO_NAME</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['medios.name_gt']) ?: '' }}" name="q[medios.name_gt]" id="q_medios.name_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['medios.name_lt']) ?: '' }}" name="q[medios.name_lt]" id="q_medios.name_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group col-md-4">
                                <label for="q_prospectos.medio_id_lt">MEDIO</label>
                                    {!! Form::select("medio_id", $list["Medio"], "{{ @(Request::input('q')['prospectos.medio_id_lt']) ?: '' }}", array("class" => "form-control select_seguridad", "name"=>"q[prospectos.medio_id_lt]", "id"=>"q_prospectos.medio_id_lt", "style"=>"width:100%;" )) !!}
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class=" control-label" for="q_st_prospectos.name_gt">ST_PROSPECTO_NAME</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['st_prospectos.name_gt']) ?: '' }}" name="q[st_prospectos.name_gt]" id="q_st_prospectos.name_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['st_prospectos.name_lt']) ?: '' }}" name="q[st_prospectos.name_lt]" id="q_st_prospectos.name_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group col-md-4" style="clear:left;">
                                <label for="q_prospectos.st_prospecto_id_lt">ESTATUS</label>
                                    {!! Form::select("st_prospecto_id", $list["StProspecto"], "{{ @(Request::input('q')['prospectos.st_cliente_id_lt']) ?: '' }}", array("class" => "form-control select_seguridad", "name"=>"q[prospectos.st_prospecto_id_lt]", "id"=>"q_prospectos.st_prospecto_id_lt", "style"=>"width:100%;" )) !!}
                            </div>
                            
                            <div class="form-group col-md-4" style="clear:left;">
                                <label for="q_prospecto_seguimientos.prospecto_st_seg_id_lt">ESTATUS SEGUIMIENTO</label>
                                    {!! Form::select("prospecto_seguimientos.prospecto_st_seg_id", $estatus, "{{ @(Request::input('q')['prospecto_seguimientos.prospecto_st_seg_id_lt']) ?: '' }}", array("class" => "form-control select_seguridad", "name"=>"q[prospecto_seguimientos.prospecto_st_seg_id_lt]", "id"=>"q_prospecto_seguimientos.prospecto_st_seg_id_lt", "style"=>"width:100%;" )) !!}
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class=" control-label" for="q_usu_alta_id_gt">USU_ALTA_ID</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['usu_alta_id_gt']) ?: '' }}" name="q[usu_alta_id_gt]" id="q_usu_alta_id_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['usu_alta_id_lt']) ?: '' }}" name="q[usu_alta_id_lt]" id="q_usu_alta_id_lt" />
                                </div>
                            </div>
                            -->
                            
                                                    <!--
                            <div class="form-group">
                                <label class=" control-label" for="q_usu_mod_id_gt">USU_MOD_ID</label>
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
            @if($prospectos->count())
                <table class="table table-condensed table-striped">
                    <thead>
                        <tr>
                            <th>@include('plantillas.getOrderLink', ['column' => 'id', 'title' => 'ID'])</th>
                            <th>@include('plantillas.getOrderLink', ['column' => 'nombre', 'title' => 'NOMBRE'])</th>
                        <th>@include('plantillas.getOrderLink', ['column' => 'nombre2', 'title' => 'NOMBRE2'])</th>
                        <th>@include('plantillas.getOrderLink', ['column' => 'ape_paterno', 'title' => 'A.PATERNO'])</th>
                        <th>@include('plantillas.getOrderLink', ['column' => 'ape_materno', 'title' => 'A. MATERNO'])</th>
                        <th>@include('plantillas.getOrderLink', ['column' => 'mail', 'title' => 'MAIL'])</th>
                        <th>@include('plantillas.getOrderLink', ['column' => 'tel_cel', 'title' => 'CELULAR'])</th>
                        <th>@include('plantillas.getOrderLink', ['column' => 'plantels.razon', 'title' => 'PLANTEL'])</th>
                        <th>@include('plantillas.getOrderLink', ['column' => 'created_at', 'title' => 'CREADO EL'])</th>
                        <th>Liga Enviada</th>
                        <th>@include('plantillas.getOrderLink', ['column' => 'st_prospectos.name', 'title' => 'ESTATUS'])</th>
                        <th>St. Seguimiento</th>
                            <th class="text-right">OPCIONES</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($prospectos as $prospecto)
                            <tr>
                                <td><a href="{{ route('prospectos.show', $prospecto->id) }}">{{$prospecto->id}}</a></td>
                                <td>{{$prospecto->nombre}}</td>
                                <td>{{$prospecto->nombre2}}</td>
                                <td>{{$prospecto->ape_paterno}}</td>
                                <td>{{$prospecto->ape_materno}}</td>
                                <td>{{$prospecto->mail}}</td>
                                <td>{{$prospecto->tel_cel}}</td>
                                <td>{{$prospecto->plantel->razon}}</td>
                                <td>{{$prospecto->created_at}}</td>
                                <td>
                                    @if($prospecto->bnd_liga_enviada==1)
                                    SI
                                    @else
                                    NO
                                    @endif
                                </td>
                                <td>
                                    @if($prospecto->st_prospecto_id==3)
                                        <a href="{{ route('clientes.edit', $prospecto->cliente_id)}}" target="_blank">{{$prospecto->stProspecto->name}}</a>
                                    @else
                                        {{$prospecto->stProspecto->name}}
                                    @endif
                                    {{ $prospecto->cliente_id }}
                                </td>
                                <td>
                                    @if(isset($prospecto->prospectoSeguimiento))
                                    <span class="@if($prospecto->prospectoSeguimiento->prospecto_st_seg_id==1)
                                     badge bg-red 
                                     @elseif($prospecto->prospectoSeguimiento->prospecto_st_seg_id==2)
                                     badge bg-yellow
                                     @elseif($prospecto->prospectoSeguimiento->prospecto_st_seg_id==3)
                                     badge bg-orange 
                                     @elseif($prospecto->prospectoSeguimiento->prospecto_st_seg_id==4)
                                     badge bg-purple
                                     @elseif($prospecto->prospectoSeguimiento->prospecto_st_seg_id==5)
                                     badge bg-green 
                                     @endif">
                                    {{$prospecto->prospectoSeguimiento->prospectoStSeg->name}}
                                    </span>
                                    @endif
                                </td>
                    
                                <td class="text-right">
                                    @permission('prospectos.aceptar')
                                    @if($prospecto->st_prospecto_id==1 or $prospecto->st_prospecto_id==2)
                                    <a class="btn btn-xs btn-success" target="_blank" href="{{ route('prospectos.aceptar', array('prospecto'=>$prospecto->id)) }}"><i class="fa fa-thumbs-o-up"></i> Aceptar</a>
                                    @endif
                                    @endpermission
                                    @permission('prospectos.rechazar')
                                    @if($prospecto->st_prospecto_id==1 or $prospecto->st_prospecto_id==2)
                                    <a class="btn btn-xs btn-danger" href="{{ route('prospectos.rechazar', array('prospecto'=>$prospecto->id)) }}"><i class="fa fa-thumbs-o-down"></i> Rechazar</a>
                                    @endif
                                    @endpermission
                                    @permission('prospectos.regresarAsesores')
                                    @if($prospecto->st_prospecto_id==4)
                                    <a class="btn btn-xs btn-info" href="{{ route('prospectos.regresarAsesores', array('prospecto'=>$prospecto->id)) }}"><i class=""></i> Regresar A.</a>
                                    @endif
                                    @endpermission
                                    @permission('prospectos.regresarCallCenter')
                                    @if($prospecto->st_prospecto_id==4)
                                    <a class="btn btn-xs btn-info" href="{{ route('prospectos.regresarCallCenter', array('prospecto'=>$prospecto->id)) }}"><i class=""></i> Regresar CC.</a>
                                    @endif
                                    @endpermission
                                    @permission('prospectos.edit')
                                    <a class="btn btn-xs btn-warning" href="{{ route('prospectos.edit', $prospecto->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                                    @endpermission
                                    @permission('prospectos.destroy')
                                    {!! Form::model($prospecto, array('route' => array('prospectos.destroy', $prospecto->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? ¿Esta seguro?')) { return true } else {return false };")) !!}
                                        <button type="submit" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i> Borrar</button>
                                    {!! Form::close() !!}
                                    @endpermission
                                    @permission('prospectoSeguimientos.show')
                                    <a class="btn btn-xs btn-info" href="{{ route('prospectoSeguimientos.show', $prospecto->id) }}"><i class="glyphicon glyphicon-edit"></i> Seguimiento</a>
                                    @endpermission
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {!! $prospectos->appends(Request::except('page'))->render() !!}
            @else
                <h3 class="text-center alert alert-info">Vacio!</h3>
            @endif

        </div>
    </div>

@endsection