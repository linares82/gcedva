@extends('plantillas.admin_template')

@include('empresas._common')

@section('header')

    <ol class="breadcrumb">
    	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
        <!--
        @if ( $query_params = Request::input('q') )

            <li class="active"><a href="{{ route('empresas.index') }}">@yield('empresasAppTitle')</a></li>
            <li class="active">condition(  

            @foreach( $query_params as $key => $value )
                @if (!$loop->first) / @endif {{ $key }} : {{ $value }}
            @endforeach
            )</li>
        @else
            <li class="active">@yield('empresasAppTitle')</li>
        @endif
        -->
        <li class="active">@yield('empresasAppTitle')</li>
    </ol>

    <div class="">
        <h3>
            <i class="glyphicon glyphicon-align-justify"></i> @yield('empresasAppTitle')
            @permission('empresas.create')
            <a class="btn btn-success pull-right" href="{{ route('empresas.create') }}"><i class="glyphicon glyphicon-plus"></i> Crear</a>
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
                    <form class="Empresa_search" id="search" action="{{ route('empresas.index') }}" accept-charset="UTF-8" method="get">
                        <input type="hidden" name="q[s]" value="{{ @(Request::input('q')['s']) ?: '' }}" />
                        <div >

                            <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_razon_social_gt">RAZON_SOCIAL</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm", type="search" value="{{ @(Request::input('q')['razon_social_gt']) ?: '' }}" name="q[razon_social_gt]" id="q_razon_social_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm", type="search" value="{{ @(Request::input('q')['razon_social_lt']) ?: '' }}" name="q[razon_social_lt]" id="q_razon_social_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group col-md-4" style="">
                                <label for="q_empresas.id_lt">ID</label>
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['empresas.id_lt']) ?: '' }}" name="q[empresas.id_lt]" id="q_empresas.id_lt" />
                            </div>
                            <div class="form-group col-md-4">
                                <label class="control-label" for="q_razon_social_cont">RAZON SOCIAL</label>
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['razon_social_cont']) ?: '' }}" name="q[razon_social_cont]" id="q_razon_social_cont" />
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_nombre_contacto_gt">NOMBRE_CONTACTO</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm", type="search" value="{{ @(Request::input('q')['nombre_contacto_gt']) ?: '' }}" name="q[nombre_contacto_gt]" id="q_nombre_contacto_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm", type="search" value="{{ @(Request::input('q')['nombre_contacto_lt']) ?: '' }}" name="q[nombre_contacto_lt]" id="q_nombre_contacto_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group col-md-4">
                                <label class="control-label" for="q_nombre_contacto_cont">CONTACTO</label>
                                    <input class="form-control input-sm", type="search" value="{{ @(Request::input('q')['nombre_contacto_cont']) ?: '' }}" name="q[nombre_contacto_cont]" id="q_nombre_contacto_cont" />
                            </div>
                            
                            <div class="form-group col-md-4" style="">
                                <label for="q_empresas.estado_id_lt">ESTADO</label>
                                    {!! Form::select("estado_id", $list["Estado"], "{{ @(Request::input('q')['empresas.estado_id_lt']) ?: '' }}", array("class" => "form-control select_seguridad", "name"=>"q[empresas.estado_id_lt]", "id"=>"q_empresas.estado_id_lt", "style"=>"width:100%;" )) !!}
                            </div>
                            <div class="form-group col-md-4" style="">
                                <label for="q_empresas.giro_id_lt">giro</label>
                                    {!! Form::select("giro_id", $list["Giro"], "{{ @(Request::input('q')['empresas.giro_id_lt']) ?: '' }}", array("class" => "form-control select_seguridad", "name"=>"q[empresas.giro_id_lt]", "id"=>"q_empresas.giro_id_lt", "style"=>"width:100%;" )) !!}
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_tel_fijo_gt">TEL_FIJO</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm", type="search" value="{{ @(Request::input('q')['tel_fijo_gt']) ?: '' }}" name="q[tel_fijo_gt]" id="q_tel_fijo_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm", type="search" value="{{ @(Request::input('q')['tel_fijo_lt']) ?: '' }}" name="q[tel_fijo_lt]" id="q_tel_fijo_lt" />
                                </div>
                            </div>
                            -->
                            
                            <div class="form-group col-md-4" style="">
                                <label for="q_empresas.usu_alta_id_lt">Usuario Alta</label>
                                    {!! Form::select("usu_alta_id", $usuarios, "{{ @(Request::input('q')['empresas.usu_alta_id_lt']) ?: '' }}", array("class" => "form-control select_seguridad", "name"=>"q[empresas.usu_alta_id_lt]", "id"=>"q_empresas.usu_alta_id_lt", "style"=>"width:100%;" )) !!}
                            </div>
                            
                            <div class="form-group col-md-4">
                                <label class="control-label" for="q_empresas.created_at_date">Creado a partir del</label>
                                    <input class="form-control input-sm fec_busqueda" type="search" value="{{ @(Request::input('q')['empresas.created_at_dateF']) ?: '' }}" name="q[empresas.created_at_dateF]" id="q_empresas.created_at_dateF" />
                            </div>
                            
                            <div class="form-group col-md-4">
                                <label class="control-label" for="q_empresas.created_at_date">Hasta el</label>
                                    <input class="form-control input-sm fec_busqueda" type="search" value="{{ @(Request::input('q')['empresas.created_at_dateT']) ?: '' }}" name="q[empresas.created_at_dateT]" id="q_empresas.created_at_dateT" />
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
            @if($empresas->count())
                <table class="table table-condensed table-striped">
                    <thead>
                        <tr>
                            <th>@include('plantillas.getOrderLink', ['column' => 'id', 'title' => 'ID'])</th>
                            <th>@include('plantillas.getOrderLink', ['column' => 'razon_social', 'title' => 'RAZON SOCIAL'])</th>
                            <th>@include('plantillas.getOrderLink', ['column' => 'nombre_contacto', 'title' => 'NOMBRE CONTACTO'])</th>
                            <th>@include('plantillas.getOrderLink', ['column' => 'giro_id', 'title' => 'GIRO'])</th>
                            <th>@include('plantillas.getOrderLink', ['column' => 'estado_id', 'title' => 'ESTADO'])</th>
                            <th>@include('plantillas.getOrderLink', ['column' => 'st_empresa_id', 'title' => 'ESTATUS'])</th>
                            <th>@include('plantillas.getOrderLink', ['column' => 'created_at', 'title' => 'ALTA'])</th>
                            <th class="text-right">OPCIONES</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($empresas as $empresa)
                            <tr>
                                <td><a href="{{ route('empresas.show', $empresa->id) }}">{{$empresa->id}}</a></td>
                                <td>{{$empresa->razon_social}}</td>
                                <td>{{$empresa->nombre_contacto}}</td>
                                <td>{{$empresa->giro->name}}</td>
                                <td>{{$empresa->estado->name}}</td>
                                <td>{{$empresa->stEmpresa->name}}</td>
                                <td>{{$empresa->created_at}}</td>
                                <td class="text-right">
                                    @if(isset($empresa->correo1))
                                    <a class="btn btn-xs btn-success" href="{{ url('correos/redactar').'/'.$empresa->correo1.'/'.$empresa->nombre_contacto.'/1' }}"><i class="glyphicon glyphicon-envelope"></i> Correo </a>
                                    @endif
                                    @permission('empresas.edit')
                                    <a class="btn btn-xs btn-primary" href="{{ route('empresas.duplicate', $empresa->id) }}"><i class="glyphicon glyphicon-duplicate"></i> Duplicar</a>
                                    @endpermission
                                    @permission('empresas.edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('cotizacionCursos.cotizacionesEmpresa', array('empresa'=>$empresa->id)) }}"><i class="glyphicon glyphicon-duplicate"></i> Cotizaciones</a>
                                    @endpermission
                                    @permission('empresas.edit')
                                    <a class="btn btn-xs btn-warning" href="{{ route('empresas.edit', $empresa->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                                    @endpermission
                                    @permission('empresas.edit')
                                    <a class="btn btn-xs btn-default" href="{{ route('empresas.seguimiento', $empresa->id) }}"><i class="glyphicon glyphicon-edit"></i> Seguimiento</a>
                                    @endpermission
                                    @permission('empresas.destroy')
                                    {!! Form::model($empresa, array('route' => array('empresas.destroy', $empresa->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? ¿Esta seguro?')) { return true } else {return false };")) !!}
                                        <button type="submit" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i> Borrar</button>
                                    {!! Form::close() !!}
                                    @endpermission
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {!! $empresas->appends(Request::except('page'))->render() !!}
            @else
                <h3 class="text-center alert alert-info">Vacio!</h3>
            @endif

        </div>
    </div>

@endsection

@push('scripts')
<script type="text/javascript">
    $(document).ready(function() {
        
        $('.fec_busqueda').Zebra_DatePicker({
                        days:['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'],
                                months:['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
                                readonly_element: false,
                                lang_clear_date: 'Limpiar',
                                show_select_today: 'Hoy',
                        });
    });

</script>
@endpush
