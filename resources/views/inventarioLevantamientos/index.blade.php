@extends('plantillas.admin_template')

@include('inventarioLevantamientos._common')

@section('header')

<ol class="breadcrumb">
    <li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
    <!--
        @if ( $query_params = Request::input('q') )

            <li class="active"><a href="{{ route('inventarioLevantamientos.index') }}">@yield('inventarioLevantamientosAppTitle')</a></li>
            <li class="active">condition(  

            @foreach( $query_params as $key => $value )
                @if (!$loop->first) / @endif {{ $key }} : {{ $value }}
            @endforeach
            )</li>
        @else
            <li class="active">@yield('inventarioLevantamientosAppTitle')</li>
        @endif
        -->
    <li class="active">@yield('inventarioLevantamientosAppTitle')</li>
</ol>

<div class="">
    <h3>
        <i class="glyphicon glyphicon-align-justify"></i> @yield('inventarioLevantamientosAppTitle')
        @permission('inventarioLevantamientos.create')
        <a class="btn btn-success pull-right" href="{{ route('inventarioLevantamientos.create') }}"><i class="glyphicon glyphicon-plus"></i> Crear</a>
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
                <form class="InventarioLevantamiento_search" id="search" action="{{ route('inventarioLevantamientos.index') }}" accept-charset="UTF-8" method="get">
                    <input type="hidden" name="q[s]" value="{{ @(Request::input('q')['s']) ?: '' }}" />
                    <div >
                            <div class="form-group col-md-4" >
                                <label for="q_inventario_levantamientos.name_lt">NOMBRE</label>
                                <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['name_cont']) ?: '' }}" name="q[name_cont]" id="q_name_cont" />
                            </div>
                        
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_fecha_gt">FECHA</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm fecha" type="search" value="{{ @(Request::input('q')['fecha_gt']) ?: '' }}" name="q[fecha_gt]" id="q_fecha_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm fecha" type="search" value="{{ @(Request::input('q')['fecha_lt']) ?: '' }}" name="q[fecha_lt]" id="q_fecha_lt" />
                                </div>
                            </div>
                        <!--    
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="q_fecha_dateF">ENTRE FECHA</label>
                            <div class=" col-sm-9">
                                <input class="form-control input-sm fecha" type="search" value="{{ @(Request::input('q')['inventario_levantamientos.fecha']) ?: '' }}" name="q[inventario_levantamientos.fecha]" id="inventario_levantamientos.fecha" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="q_fecha_dateT"> Y FECHA</label>
                            <div class=" col-sm-9">
                                <input class="form-control input-sm fecha" type="search" value="{{ @(Request::input('q')['inventario_levantamientos.fecha']) ?: '' }}" name="q[inventario_levantamientos.fecha]" id="inventario_levantamientos.fecha" />
                            </div>
                        </div>
            -->
                        
                        <div class="form-group col-md-4" >
                                <label for="q_inventario_levantamientos.plantel_inventario_id_cont">PLANTEL</label>
                                    {!! Form::select("plantel_inventario_id", $planteles, "{{ @(Request::input('q')['inventario_levantamiento_id_lt']) ?: '' }}", array("class" => "form-control select_seguridad", "name"=>"q[plantel_inventario_id_lt]", "id"=>"q_plantel_inventario_id_lt", "style"=>"width:100%;")) !!}
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
@php
    
@endphp
<div class="row">
    <div class="col-md-12">
        @if($inventarioLevantamientos->count())
        <table class="table table-condensed table-striped">
            <thead>
                <tr>
                    <th>@include('plantillas.getOrderLink', ['column' => 'id', 'title' => 'ID'])</th>
                    <th>@include('CrudDscaffold::getOrderlink', ['column' => 'name', 'title' => 'NOMBRE'])</th>
                    <th>@include('CrudDscaffold::getOrderlink', ['column' => 'fecha', 'title' => 'FECHA'])</th>
                    <th>@include('CrudDscaffold::getOrderlink', ['column' => 'plantel_inventario_id', 'title' => 'PLANTEL'])</th>
                    <th>@include('CrudDscaffold::getOrderlink', ['column' => 'inventario_levantamiento_id', 'title' => 'ESTATUS'])</th>
                    <!--<th>DESCARGA</th>-->
                    <th>Observaciones</th>
                    <th class="text-right">OPCIONES</th>
                </tr>
            </thead>

            <tbody>
                @foreach($inventarioLevantamientos as $inventarioLevantamiento)
                <tr>
                    <td><a href="{{ route('inventarioLevantamientos.show', array('q[inventario_levantamiento_id_lt]'=>$inventarioLevantamiento->id)) }}">{{$inventarioLevantamiento->id}}</a></td>
                    <td>{{$inventarioLevantamiento->name}}</td>
                    <td>{{$inventarioLevantamiento->fecha}}</td>
                    <td>{{optional($inventarioLevantamiento->plantelInventario)->name}}</td>
                    <td>{{$inventarioLevantamiento->inventarioLevantamientoSt->name}}</td>
                    <!--
                    <td>
                        
                        @permission('inventarioLevantamientos.descargarCsv')
                            {!! Form::model($inventarioLevantamiento,
                            array(
                            'route' => array('inventarioLevantamientos.descargarCsv', $inventarioLevantamiento->id),
                            'method' => 'get',
                            'target' => 'blank',
                            'style' => 'display: inline;'
                            )) !!}
                            <div class="form-group col-md-4 @if($errors->has('plantel_id')) has-error @endif">
                                <label for="plantel_id-field">Plantel</label>
                                {!! Form::select("plantel_id", $planteles, null, array("class" => "form-control select_seguridad", "id" => "plantel_id-field")) !!}
                                {!! Form::hidden("id", $inventarioLevantamiento->id, array("class" => "form-control", "id" => "id-field")) !!}
                                <label for="bnd_trabaja-field">CSV {!! Form::checkbox("csv", 1, null, [ "id" => "csv-field", 'class'=>'minimal']) !!}</label>
                                @if($errors->has("plantel_id"))
                                <span class="help-block">{{ $errors->first("plantel_id") }}</span>
                                @endif
                            </div>
                            <button type="submit" class="btn btn-xs btn-success" id="btn-enviar"><i class="glyphicon glyphicon-print"></i> Descargar</button>
                            {!! Form::close() !!}


                        @endpermission
                    </td>
                            -->
                    <td>
                    @permission('inventarioObservacions.create')
                    <a class="btn btn-success btn-xs" href="{{ route('inventarioObservacions.create', array('inventarioLevantamiento'=>$inventarioLevantamiento->id)) }}"><i class="glyphicon glyphicon-plus"></i> Crear</a>
                    @endpermission
                    @permission('inventarioObservacions.index')
                        <a class="btn btn-xs btn-info" target="_blank" href="{{ route('inventarioObservacions.index',array('q[inventario_levantamiento_id_lt]'=>$inventarioLevantamiento->id)) }}" target="_blank"><i class="glyphicon glyphicon-plus"></i> Obs.</a>
                    @endpermission
                    @permission('inventarioLevantamientos.dictamen')
                        {!! Form::model($inventarioLevantamiento,
                            array(
                            'route' => array('inventarioLevantamientos.dictamen', $inventarioLevantamiento->id),
                            'method' => 'get',
                            'target' => 'blank',
                            'style' => 'display: inline;'
                            )) !!}
                            <div class="form-group col-md-4 @if($errors->has('plantel_id')) has-error @endif">
                                {!! Form::hidden("plantel_id", $inventarioLevantamiento->plantel_inventario_id, array("class" => "form-control", "id" => "id-field")) !!}
                                {!! Form::hidden("id", $inventarioLevantamiento->id, array("class" => "form-control", "id" => "id-field")) !!}
                                @if($errors->has("plantel_id"))
                                <span class="help-block">{{ $errors->first("plantel_id") }}</span>
                                @endif
                            </div>
                            <button type="submit" class="btn btn-xs btn-success"><i class="glyphicon glyphicon-print"></i> Dictamen</button>
                            {!! Form::close() !!}
                    @endpermission
                    </td>
                    <td class="text-right">
                        @if($inventarioLevantamiento->inventario_levantamiento_st_id==1)
                            @permission('inventarioLevantamientos.cargarCsv')
                            <a class="btn btn-xs btn-info" href="{{ route('inventarioLevantamientos.cargarCsv', array('inventario_levantamiento_id'=>$inventarioLevantamiento->id)) }}"><i class="glyphicon glyphicon-edit"></i> Crear con Csv</a>
                            
                            <a class="btn btn-xs btn-success" href="{{ route('inventarioLevantamientos.copiarAnterior', array('destino'=>$inventarioLevantamiento->id)) }}"><i class="glyphicon glyphicon-duplicate"></i> Copiar</a>
                            @endpermission
                            <a class="btn btn-xs btn-info" href="{{ route('inventarioLevantamientos.actualizarCsv', array('inventario_levantamiento_id'=>$inventarioLevantamiento->id)) }}"><i class="glyphicon glyphicon-edit"></i> Actualizar con Csv</a>
                            @permission('inventarioLevantamientos.edit')
                            @permission('inventarioLevantamientos.actualizarCsv')
                            <a class="btn btn-xs btn-warning" href="{{ route('inventarioLevantamientos.edit', $inventarioLevantamiento->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                            @endpermission
                            @endpermission
                        
                        
                        @permission('inventarioLevantamientos.destroy')
                        {!! Form::model($inventarioLevantamiento, array('route' => array('inventarioLevantamientos.destroy', $inventarioLevantamiento->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? ¿Esta seguro?')) { return true } else {return false };")) !!}
                        <button type="submit" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i> Borrar</button>
                        {!! Form::close() !!}
                        @endpermission
                        @else
                        @permission('inventarioLevantamientos.editExcepcionEstatus')
                        <a class="btn btn-xs btn-warning" href="{{ route('inventarioLevantamientos.edit', $inventarioLevantamiento->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                        @endpermission
                        @endif

                        
                        
                            
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {!! $inventarioLevantamientos->appends(Request::except('page'))->render() !!}
        @else
        <h3 class="text-center alert alert-info">Vacio!</h3>
        @endif

    </div>
</div>

@endsection

@push('scripts')
  <script type="text/javascript">
    $(document).ready(function() {
        
    });

    $("#btn-enviar").click(function(){{
        setTimeout(() => {  $(this).prop('disabled', false); }, 5000);
    }
    
});
    
    </script>
@endpush
    
