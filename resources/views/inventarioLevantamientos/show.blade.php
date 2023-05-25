@extends('plantillas.admin_template')

@include('inventarioLevantamientos._common')

@section('header')

<ol class="breadcrumb">
    <li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
    <li><a href="{{ route('inventarioLevantamientos.index') }}">@yield('inventarioLevantamientosAppTitle')</a></li>
    <li class="active">{{ $inventarioLevantamiento->name }}</li>
</ol>

<div class="page-header">
    <h1>@yield('inventarioLevantamientosAppTitle') / Mostrar {{$inventarioLevantamiento->id}}

        {!! Form::model($inventarioLevantamiento, array('route' => array('inventarioLevantamientos.destroy', $inventarioLevantamiento->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? Estas seguro?')) { return true } else {return false };")) !!}
        <div class="btn-group pull-right" role="group" aria-label="...">
            @permission('inventarioLevantamiento.edit')
            <a class="btn btn-warning btn-group" role="group" href="{{ route('inventarioLevantamientos.edit', $inventarioLevantamiento->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
            @endpermission
            @permission('inventarioLevantamiento.destroy')
            <button type="submit" class="btn btn-danger">Borrar <i class="glyphicon glyphicon-trash"></i>
                < /button>
                    @endpermission
        </div>
        {!! Form::close() !!}

    </h1>
</div>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">

        <form action="#">
            <div class="form-group col-sm-3">
                <label for="nome">ID</label>
                <p class="form-control-static">{{$inventarioLevantamiento->id}}</p>
            </div>
            <div class="form-group col-sm-3">
                <label for="fecha">FECHA</label>
                <p class="form-control-static">{{$inventarioLevantamiento->fecha}}</p>
            </div>
            <div class="form-group col-sm-3">
                <label for="usu_alta_id">ALTA</label>
                <p class="form-control-static">{{$inventarioLevantamiento->usu_alta->name}}</p>
            </div>
            <div class="form-group col-sm-3">
                <label for="usu_mod_id">U. MODIFICACION</label>
                <p class="form-control-static">{{$inventarioLevantamiento->usu_mod->name}}</p>
            </div>
        </form>

        <div class="row">
        </div>

        <a class="btn btn-link" href="{{ route('inventarioLevantamientos.index') }}"><i class="glyphicon glyphicon-backward"></i> Regresar</a>

    </div>
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
                <form class="Inventario_search" id="search" action="{{ route('inventarioLevantamientos.show', $inventarioLevantamiento->id) }}" accept-charset="UTF-8" method="get">
                    <input type="hidden" name="q[s]" value="{{ @(Request::input('q')['s']) ?: '' }}" />
                    <div class="">
                        <div class="form-group col-md-4">
                            <label class="col-sm-2 control-label" for="q_inventarios.no_inventario_lt">No. Inventario</label>

                            <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['inventarios.no_inventario_lt']) ?: '' }}" name="q[inventarios.no_inventario_lt]" id="q_inventarios.no_inventario_lt" />

                        </div>
                        <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_plantels.razon_gt">PLANTEL_RAZON</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['plantels.razon_gt']) ?: '' }}" name="q[plantels.razon_gt]" id="q_plantels.razon_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['plantels.razon_lt']) ?: '' }}" name="q[plantels.razon_lt]" id="q_plantels.razon_lt" />
                                </div>
                            </div>
                            -->
                        <div class="form-group col-md-4">
                            <label for="q_inventarios.estado_bueno_lt">ESTADO</label>
                            {!! Form::select("inventarios.estado_bueno", $catEstado, "{{ @(Request::input('q')['inventarios.estado_bueno_cont']) ?: '' }}", array("class" => "form-control select_seguridad", "name"=>"q[inventarios.estado_bueno_cont]", "id"=>"q_inventarios.estado_bueno_cont", "style"=>"width:100%;")) !!}
                        </div>
                        <div class="form-group col-md-4">
                            <label for="q_inventarios.plantel_inventario_id_lt">PLANTEL</label>
                            <input class="form-control input-sm" type="hidden" value="{{ @(Request::input('q')['inventario_levantamiento_id_lt']) ?: '' }}" name="q[inventario_levantamiento_id_lt]" id="q_inventario_levantamiento_id_lt" />
                            {!! Form::select("inventarios.plantel_inventario_id", $planteles, "{{ @(Request::input('q')['inventarios.plantel_inventario_id_lt']) ?: '' }}", array("class" => "form-control select_seguridad", "name"=>"q[inventarios.plantel_inventario_id_lt]", "id"=>"q_inventarios.plantel_inventario_id_lt", "style"=>"width:100%;")) !!}
                            <div id='loading10' style='display: none'><img src="{{ asset('images/ajax-loader.gif') }}" title="Enviando" /></div>
                        </div>
                        <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_area_gt">AREA</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['area_gt']) ?: '' }}" name="q[area_gt]" id="q_area_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['area_lt']) ?: '' }}" name="q[area_lt]" id="q_area_lt" />
                                </div>
                            </div>
                            -->
                        <div class="form-group col-md-4">
                            <label class="col-sm-2 control-label" for="q_area_cont">AREA</label>

                            <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['area_cont']) ?: '' }}" name="q[area_cont]" id="q_area_cont" />

                        </div>
                        <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_escuela_gt">ESCUELA</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['escuela_gt']) ?: '' }}" name="q[escuela_gt]" id="q_escuela_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['escuela_lt']) ?: '' }}" name="q[escuela_lt]" id="q_escuela_lt" />
                                </div>
                            </div>
                            
                            <div class="form-group col-md-4">
                                <label class="col-sm-2 control-label" for="q_escuela_cont">ESCUELA</label>
                                
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['escuela_cont']) ?: '' }}" name="q[escuela_cont]" id="q_escuela_cont" />
                                
                            </div>
                                                    
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_tipo_inventario_gt">TIPO_INVENTARIO</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['tipo_inventario_gt']) ?: '' }}" name="q[tipo_inventario_gt]" id="q_tipo_inventario_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['tipo_inventario_lt']) ?: '' }}" name="q[tipo_inventario_lt]" id="q_tipo_inventario_lt" />
                                </div>
                            </div>
                            
                            <div class="form-group col-md-4">
                                <label class="col-sm-2 control-label" for="q_tipo_inventario_cont">TIPO INVENTARIO</label>
                                
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['tipo_inventario_cont']) ?: '' }}" name="q[tipo_inventario_cont]" id="q_tipo_inventario_cont" />
                                
                            </div>
                                                    
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_ubicacion_gt">UBICACION</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['ubicacion_gt']) ?: '' }}" name="q[ubicacion_gt]" id="q_ubicacion_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['ubicacion_lt']) ?: '' }}" name="q[ubicacion_lt]" id="q_ubicacion_lt" />
                                </div>
                            </div>
                            -->
                        <div class="form-group col-md-4">
                            <label class="col-sm-2 control-label" for="q_ubicacion_cont">UBICACION</label>

                            <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['ubicacion_cont']) ?: '' }}" name="q[ubicacion_cont]" id="q_ubicacion_cont" />

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
{!! $inventarios->appends(Request::except('page'))->render() !!}
<table class="table table-condensed table-striped">
    <thead>
        <th>No. Inventario</th>
        <th>Plantel</th>
        <th>Area</th>
        <th>Ubicacion</th>
        <th>Cantidad</th>
        <th>Nombre</th>
        <th>Medida</th>
        <th>Marca</th>
        <th>Observaciones</th>
        <th>Existe Si</th>
        <th>Estado Bueno</th>
        <th></th>
    </thead>
    <tbody>

        @foreach($inventarios as $inventario)
        <tr>
            <td>{{$inventario->no_inventario}}</td>
            <td>{{$inventario->plantelInventario->name}}</td>
            <td>{{$inventario->area}}</td>
            <td>{{$inventario->ubicacion}}</td>
            <td>{{$inventario->cantidad}}</td>
            <td>{{$inventario->nombre}}</td>
            <td>{{$inventario->medida}}</td>
            <td>{{$inventario->marca}}</td>
            <td>{{$inventario->observaciones}}</td>
            <td>
                <div class="editExiste">{{$inventario->existe_si}}</div>
                <div id="existeEditable" style="display:none;">
                    {!! Form::select("existe_si", $catExiste, null, array("class" => "form-control existe_si_edit-field",  'data-id' => $inventario->id )) !!}
                </div>
            </td>
            <td>
                <div class="editEstado">{{$inventario->estado_bueno}}</div>
                <div id="estadoEditable" style="display:none;">
                    {!! Form::select("estado_bueno", $catEstado, $inventario->estado_bueno, array("class" => "form-control estado_bueno_edit-field", 'data-id'=> $inventario->id )) !!}
                </div>
            </td>
            <td>

                @permission('inventarios.edit')
                <a class="btn btn-xs btn-warning" target="_blank" href="{{ route('inventarios.edit', $inventario->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                @endpermission
                @permission('inventarios.destroy')
                {!! Form::model($inventario, array('route' => array('inventarios.destroy', $inventario->id),'method' => 'delete', 'style' => 'display: inline;', 'target'=>'_blank', 'onsubmit'=> "if(confirm('¿Borrar? ¿Esta seguro?')) { return true } else {return false };")) !!}
                <button type="submit" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i> Borrar</button>
                {!! Form::close() !!}
                @endpermission

            </td>
        </tr>
        @endforeach

    </tbody>
</table>
{!! $inventarios->appends(Request::except('page'))->render() !!}

@endsection

@push('scripts')
<script type="text/javascript">
    $(document).ready(function() {

        $(".editExiste").dblclick(function(){
            $(this).next().show();
        });

        $(".existe_si_edit-field").change(function() {
            $.ajax({
                    url: '{{ route("inventarios.editExiste") }}',
                    type: 'GET',
                    data: {
                        'id':$(this).data('id'),
                        'existe_si': $(this).val()
                    },
                    dataType: 'json',
                    success: function(data) {
                        location.reload();
                    }
                });
        });

        $(".editEstado").dblclick(function(){
            $(this).next().show();
        });

        $('.estado_bueno_edit-field').change(function (){
            
                $.ajax({
                    url: '{{ route("inventarios.editEstado") }}',
                    type: 'GET',
                    data: {
                        'id':$(this).data('id'),
                        'estado_bueno': $(this).val()
                    },
                    dataType: 'json',
                    success: function(data) {
                        location.reload();
                    }
                });
        });

        
    });

</script>
@endpush