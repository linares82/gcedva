@extends('plantillas.admin_template')

@include('especialidads._common')

@section('header')

    <ol class="breadcrumb">
    	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
        <!--
        @if ( $query_params = Request::input('q') )

            <li class="active"><a href="{{ route('especialidads.index') }}">@yield('especialidadsAppTitle')</a></li>
            <li class="active">condition(  

            @foreach( $query_params as $key => $value )
                @if (!$loop->first) / @endif {{ $key }} : {{ $value }}
            @endforeach
            )</li>
        @else
            <li class="active">@yield('especialidadsAppTitle')</li>
        @endif
        -->
        <li class="active">@yield('especialidadsAppTitle')</li>
    </ol>

    <div class="">
        <h3>
            <i class="glyphicon glyphicon-align-justify"></i> @yield('especialidadsAppTitle')
            @permission('especialidads.create')
            <a class="btn btn-success pull-right" href="{{ route('especialidads.create') }}"><i class="glyphicon glyphicon-plus"></i> Crear</a>
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
                    <form class="Especialidad_search" id="search" action="{{ route('especialidads.index') }}" accept-charset="UTF-8" method="get">
                        <input type="hidden" name="q[s]" value="{{ @(Request::input('q')['s']) ?: '' }}" />
                        <div class="">

                            <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_name_gt">NAME</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm", type="search" value="{{ @(Request::input('q')['name_gt']) ?: '' }}" name="q[name_gt]" id="q_name_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm", type="search" value="{{ @(Request::input('q')['name_lt']) ?: '' }}" name="q[name_lt]" id="q_name_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group col-md-4" >
                                <label for="q_especialidads.plantel_id_lt">PLANTEL</label>
                                
                                    {!! Form::select("especialidads.plantel_id", $list["Plantel"], "{{ @(Request::input('q')['especialidads.plantel_id_lt']) ?: '' }}", array("class" => "form-control select_seguridad", "name"=>"q[especialidads.plantel_id_lt]", "id"=>"q_especialidads.plantel_id_lt", "style"=>"width:100%;")) !!}
                                    <div id='loading10' style='display: none'><img src="{{ asset('images/ajax-loader.gif') }}" title="Enviando" /></div> 
                            </div>
                            <div class="form-group col-md-4">
                                <label class="col-sm-12 control-label" for="q_name_cont">Especialidad</label>
                                <div class="col-sm-12">
                                    <input class="form-control input-sm", type="search" value="{{ @(Request::input('q')['name_cont']) ?: '' }}" name="q[name_cont]" id="q_name_cont" />
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
            @if($especialidads->count())
                <table class="table table-condensed table-striped">
                    <thead>
                        <tr>
                            <th>@include('plantillas.getOrderLink', ['column' => 'id', 'title' => 'ID'])</th>
                            <th>@include('plantillas.getOrderlink', ['column' => 'plantel_id', 'title' => 'PLANTEL'])</th>
                            <th>@include('plantillas.getOrderlink', ['column' => 'name', 'title' => 'ESPECIALIDAD'])</th>
                            <th>@include('plantillas.getOrderlink', ['column' => 'vencimiento_rvoe', 'title' => 'VENCIMIENTO RVOE'])</th>
                            <th class="text-right"></th>
                            <th class="text-right"></th>
                            <th class="text-right">OPCIONES</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($especialidads as $especialidad)
                            <tr>
                                <td><a href="{{ route('especialidads.show', $especialidad->id) }}">{{$especialidad->id}}</a></td>
                                <td>{{$especialidad->plantel->razon}}</td>
                                <td>{{$especialidad->name}}</td>
                                <td>
                                    <?php 
                                    if(!is_null($especialidad->vencimiento_rvoe)){
                                        $vencimiento=\Carbon\Carbon::createFromFormat('Y-m-d', $especialidad->vencimiento_rvoe); 
                                        $vencimiento_minus30=\Carbon\Carbon::createFromFormat('Y-m-d', $especialidad->vencimiento_rvoe)->subMonth();
                                        $hoy=\Carbon\Carbon::createFromFormat('Y-m-d', Date('Y-m-d'));
                                    }
                                          ?>
                                    <span
                                        @if(!is_null($especialidad->vencimiento_rvoe))
                                          @if($vencimiento<=$hoy and !is_null($especialidad->vencimiento_rvoe))
                                           class="text-red"
                                          @elseif($hoy<$vencimiento and $hoy>$vencimiento_minus30 and !is_null($especialidad->vencimiento_rvoe))
                                           class="text-yellow"
                                          @else
                                           class="text-green"
                                          @endif
                                        @endif
                                           >{{$especialidad->vencimiento_rvoe}}</span>
                                </td>
                                <td>
                                    
                                    <img src="{{asset('storage/especialidads/'.$especialidad->imagen)}}" alt="Logo" height="42" width="42" > </td>
                                </td>
                                <td>
                                    <img src="{{asset('storage/especialidads/'.$especialidad->fondo_credencial)}}" alt="Fondo Credencial" height="42" width="42" > </td>
                                </td>
                                <td class="text-right">
                                    @permission('especialidads.edit')
                                    <a class="btn btn-xs btn-primary" href="{{ route('especialidads.duplicate', $especialidad->id) }}"><i class="glyphicon glyphicon-duplicate"></i> Duplicar</a>
                                    @endpermission
                                    @permission('especialidads.edit')
                                    <a class="btn btn-xs btn-warning" href="{{ route('especialidads.edit', $especialidad->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                                    @endpermission
                                    @permission('especialidads.destroy')
                                    {!! Form::model($especialidad, array('route' => array('especialidads.destroy', $especialidad->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? ¿Esta seguro?')) { return true } else {return false };")) !!}
                                        <button type="submit" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i> Borrar</button>
                                    {!! Form::close() !!}
                                    @endpermission
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {!! $especialidads->appends(Request::except('page'))->render() !!}
            @else
                <h3 class="text-center alert alert-info">Vacio!</h3>
            @endif

        </div>
    </div>

@endsection