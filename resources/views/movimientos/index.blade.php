@extends('plantillas.admin_template')

@include('movimientos._common')

@section('header')

    <ol class="breadcrumb">
    	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
        <!--
        @if ( $query_params = Request::input('q') )

            <li class="active"><a href="{{ route('movimientos.index') }}">@yield('movimientosAppTitle')</a></li>
            <li class="active">condition(  

            @foreach( $query_params as $key => $value )
                @if (!$loop->first) / @endif {{ $key }} : {{ $value }}
            @endforeach
            )</li>
        @else
            <li class="active">@yield('movimientosAppTitle')</li>
        @endif
        -->
        <li class="active">@yield('movimientosAppTitle')</li>
    </ol>

    <div class="">
        <h3>
            <i class="glyphicon glyphicon-align-justify"></i> @yield('movimientosAppTitle')
            @permission('movimientos.create')
            <a class="btn btn-success pull-right" href="{{ route('movimientos.create') }}"><i class="glyphicon glyphicon-plus"></i> Crear</a>
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
                    <form class="Movimiento_search" id="search" action="{{ route('movimientos.index') }}" accept-charset="UTF-8" method="get">
                        <input type="hidden" name="q[s]" value="{{ @(Request::input('q')['s']) ?: '' }}" />
                        <div class="">

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
                            <div class="form-group col-md-4" >
                                <label for="q_movimientos.plantel_id_lt">PLANTEL</label>
                                
                                    {!! Form::select("movimientos.plantel_id", $list["Plantel"], "{{ @(Request::input('q')['movimientos.plantel_id_lt']) ?: '' }}", array("class" => "form-control select_seguridad", "name"=>"q[movimientos.plantel_id_lt]", "id"=>"q_movimientos.plantel_id_lt", "style"=>"width:100%;", 'onchange'=>'getUbicaciones()')) !!}
                                    <div id='loading10' style='display: none'><img src="{{ asset('images/ajax-loader.gif') }}" title="Enviando" /></div> 
                            </div>
                            <div class="form-group col-md-4" >
                                <label for="q_movimientos.ubicacion_art_id_lt">Ubicacion</label>
                                
                                    {!! Form::select("movimientos.ubicacion_art_id", array(), "{{ @(Request::input('q')['movimientos.ubicacion_art_id_lt']) ?: '' }}", array("class" => "form-control select_seguridad", "name"=>"q[movimientos.ubicacion_art_id_lt]", "id"=>"q_movimientos.ubicacion_art_id_lt", "style"=>"width:100%;")) !!}
                             
                            </div>
                            <div class="form-group col-md-4" >
                                <label for="q_movimientos.articulo_id_lt">Articulo</label>
                                
                                    {!! Form::select("movimientos.articulo_id", $list['Articulo'], "{{ @(Request::input('q')['movimientos.articulo_id_lt']) ?: '' }}", array("class" => "form-control select_seguridad", "name"=>"q[movimientos.articulo_id_lt]", "id"=>"q_movimientos.articulo_id_lt", "style"=>"width:100%;")) !!}
                             
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_articulos.name_gt">ARTICULO_NAME</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['articulos.name_gt']) ?: '' }}" name="q[articulos.name_gt]" id="q_articulos.name_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['articulos.name_lt']) ?: '' }}" name="q[articulos.name_lt]" id="q_articulos.name_lt" />
                                </div>
                            </div>
                            -->
                            
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_cantidad_gt">CANTIDAD</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['cantidad_gt']) ?: '' }}" name="q[cantidad_gt]" id="q_cantidad_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['cantidad_lt']) ?: '' }}" name="q[cantidad_lt]" id="q_cantidad_lt" />
                                </div>
                            </div>
                            -->
                            
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_fecha_gt">FECHA</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['fecha_gt']) ?: '' }}" name="q[fecha_gt]" id="q_fecha_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['fecha_lt']) ?: '' }}" name="q[fecha_lt]" id="q_fecha_lt" />
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_fecha_cont">FECHA</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['fecha_cont']) ?: '' }}" name="q[fecha_cont]" id="q_fecha_cont" />
                                </div>
                            </div>
                                                    
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_entrada_salidas.name_gt">ENTRADA_SALIDA_NAME</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['entrada_salidas.name_gt']) ?: '' }}" name="q[entrada_salidas.name_gt]" id="q_entrada_salidas.name_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['entrada_salidas.name_lt']) ?: '' }}" name="q[entrada_salidas.name_lt]" id="q_entrada_salidas.name_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group col-md-4" >
                                <label for="q_movimientos.entrada_salida_id_lt">TIPO</label>
                                
                                    {!! Form::select("movimientos.entrada_salida_id", $list['EntradaSalida'], "{{ @(Request::input('q')['movimientos.entrada_salida_id_lt']) ?: '' }}", array("class" => "form-control select_seguridad", "name"=>"q[movimientos.entrada_salida_id_lt]", "id"=>"q_movimientos.articulo_id_lt", "style"=>"width:100%;")) !!}
                             
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
    <div class="row">
        <div class="col-md-12">
            @if($movimientos->count())
                <table class="table table-condensed table-striped">
                    <thead>
                        <tr>
                            <th>@include('plantillas.getOrderLink', ['column' => 'id', 'title' => 'ID'])</th>
                            <th>@include('CrudDscaffold::getOrderlink', ['column' => 'plantels.razon', 'title' => 'PLANTEL'])</th>
                            <th>@include('CrudDscaffold::getOrderlink', ['column' => 'plantels.ubicacion_art_id', 'title' => 'UBICACION'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'articulos.name', 'title' => 'ARTICULO'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'cantidad', 'title' => 'CANTIDAD'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'fecha', 'title' => 'FECHA'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'entrada_salidas.name', 'title' => 'E/S'])</th>
                            <th class="text-right">OPCIONES</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($movimientos as $movimiento)
                            <tr>
                                <td><a href="{{ route('movimientos.show', $movimiento->id) }}">{{$movimiento->id}}</a></td>
                                <td>{{$movimiento->plantel->razon}}</td>
                                <td>{{$movimiento->ubicacionArt->ubicacion}}</td>
                    <td>{{$movimiento->articulo->name}}</td>
                    <td>{{$movimiento->cantidad}}</td>
                    <td>{{$movimiento->fecha}}</td>
                    <td>{{$movimiento->entradaSalida->name}}</td>
                                <td class="text-right">
                                    @permission('movimientos.edit')
                                    <a class="btn btn-xs btn-primary" href="{{ route('movimientos.duplicate', $movimiento->id) }}"><i class="glyphicon glyphicon-duplicate"></i> Duplicate</a>
                                    @endpermission
                                    @permission('movimientos')
                                    <a class="btn btn-xs btn-warning" href="{{ route('movimientos.edit', $movimiento->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                                    @endpermission
                                    @permission('movimientos.destroy')
                                    {!! Form::model($movimiento, array('route' => array('movimientos.destroy', $movimiento->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? ¿Esta seguro?')) { return true } else {return false };")) !!}
                                        <button type="submit" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i> Borrar</button>
                                    {!! Form::close() !!}
                                    @endpermission
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {!! $movimientos->appends(Request::except('page'))->render() !!}
            @else
                <h3 class="text-center alert alert-info">Vacio!</h3>
            @endif

        </div>
    </div>

@endsection

@push('scripts')

    <script>
        $(document).ready(function(){
        //getUbicaciones();
        
        $('#q_movimientos.plantel_id_lt').change(function(){
        //getUbicaciones();         
        });
        });

        function removeOptions(selectbox)
        {
            
            if((selectbox.options.length - 1)>0){
                var i;
                for(i = selectbox.options.length - 1 ; i >= 0 ; i--)
                {
                    selectbox.remove(i);
                }
            }
        }

        function getUbicaciones(){
            var vplantel=document.getElementById('q_movimientos.plantel_id_lt');
            var vubicacion=document.getElementById('q_movimientos.ubicacion_art_id_lt');
      $.ajax({
                url: '{{ route("ubicacionArts.getUbicacionesXPlantel") }}',
                type: 'GET',
                data: {
                   'plantel': vplantel.options[vplantel.selectedIndex].value,
                   'ubicacion': 0//vubicacion.options[vubicacion.selectedIndex].value
                },
                dataType: 'json',
                beforeSend : function(){$("#loading10").show();},
                complete : function(){$("#loading10").hide();},
                success: function(data){
                    if(data != null){   
                        removeOptions(vubicacion);
                        $.each(data, function(i) {
                            var opt = document.createElement('option');
                            opt.value = data[i].id;
                            opt.innerHTML = data[i].name;
                            vubicacion.appendChild(opt);
                        });
                    }else{
                        alert('Sin ubicaciones');
                    }
                }
            });
   }
    </script>

@endpush