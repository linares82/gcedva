@extends('plantillas.admin_template')

@include('cuentasEfectivos._common')

@section('header')

    <ol class="breadcrumb">
    	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
        <!--
        @if ( $query_params = Request::input('q') )

            <li class="active"><a href="{{ route('cuentasEfectivos.index') }}">@yield('cuentasEfectivosAppTitle')</a></li>
            <li class="active">condition(  

            @foreach( $query_params as $key => $value )
                @if (!$loop->first) / @endif {{ $key }} : {{ $value }}
            @endforeach
            )</li>
        @else
            <li class="active">@yield('cuentasEfectivosAppTitle')</li>
        @endif
        -->
        <li class="active">@yield('cuentasEfectivosAppTitle')</li>
    </ol>

    <div class="">
        <h3>
            <i class="glyphicon glyphicon-align-justify"></i> @yield('cuentasEfectivosAppTitle')
            @permission('cuentasEfectivos.create')
            <a class="btn btn-success pull-right" href="{{ route('cuentasEfectivos.create') }}"><i class="glyphicon glyphicon-plus"></i> Crear</a>
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
                    <form class="CuentasEfectivo_search" id="search" action="{{ route('cuentasEfectivos.index') }}" accept-charset="UTF-8" method="get">
                        <input type="hidden" name="q[s]" value="{{ @(Request::input('q')['s']) ?: '' }}" />
                        <div class="form-horizontal">

                            <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_name_gt">NAME</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['name_gt']) ?: '' }}" name="q[name_gt]" id="q_name_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['name_lt']) ?: '' }}" name="q[name_lt]" id="q_name_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_name_cont">NAME</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['name_cont']) ?: '' }}" name="q[name_cont]" id="q_name_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_clabe_gt">CLABE</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['clabe_gt']) ?: '' }}" name="q[clabe_gt]" id="q_clabe_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['clabe_lt']) ?: '' }}" name="q[clabe_lt]" id="q_clabe_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_clabe_cont">CLABE</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['clabe_cont']) ?: '' }}" name="q[clabe_cont]" id="q_clabe_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_no_cuenta_gt">NO_CUENTA</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['no_cuenta_gt']) ?: '' }}" name="q[no_cuenta_gt]" id="q_no_cuenta_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['no_cuenta_lt']) ?: '' }}" name="q[no_cuenta_lt]" id="q_no_cuenta_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_no_cuenta_cont">NO_CUENTA</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['no_cuenta_cont']) ?: '' }}" name="q[no_cuenta_cont]" id="q_no_cuenta_cont" />
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
            @if($cuentasEfectivos->count())
                <table class="table table-condensed table-striped">
                    <thead>
                        <tr>
                            <th>@include('plantillas.getOrderLink', ['column' => 'id', 'title' => 'ID'])</th>
                            <th>@include('CrudDscaffold::getOrderlink', ['column' => 'name', 'title' => 'NOMBRE'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'clabe', 'title' => 'CLABE'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'no_cuenta', 'title' => 'NO. CUENTA'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'saldo_inicial', 'title' => 'SALDO INICIAL'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'fecha_saldo_inicial', 'title' => 'FECHA SALDO INICIAL'])</th>
                        <th>@include('CrudDscaffold::getOrderlink', ['column' => 'saldo_caculado', 'title' => 'SALDO CALCULADO'])</th>
                            <th class="text-right">OPCIONES</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($cuentasEfectivos as $cuentasEfectivo)
                            <?php 
                            $empleado=App\Empleado::where('user_id',Auth::user()->id)->first();
                            
                            $plantels=App\Plantel::where('director_id',$empleado->id)->orWhere('responsable_id',$empleado->id)->get();
                            $marcador=0;
                            if(count($plantels)>0){
                                foreach($plantels as $plantel){
                                    foreach($cuentasEfectivo->plantels as $plantel_cuentas){
                                        if($plantel_cuentas->id==$plantel->id){
                                            $marcador++;
                                        }
                                    }

                                }
                            }elseif(Auth::user()->id==1 or Auth::user()->id==3){
                                $marcador=1;
                            }

                            ?>
                            @if($marcador>0)
                            <tr>
                                <td><a href="{{ route('cuentasEfectivos.show', $cuentasEfectivo->id) }}">{{$cuentasEfectivo->id}}</a></td>
                                <td>{{$cuentasEfectivo->name}}</td>
                                <td>{{$cuentasEfectivo->clabe}}</td>
                                <td>{{$cuentasEfectivo->no_cuenta}}</td>
                                <td>{{$cuentasEfectivo->saldo_inicial}}</td>
                                <td>{{$cuentasEfectivo->fecha_saldo_inicial}}</td>
                                <td>{{$cuentasEfectivo->saldo_actualizado}}</td>
                                <td class="text-right">
                                    @permission('cuentasEfectivos.edit')
                                    <a class="btn btn-xs btn-primary" href="{{ route('cuentasEfectivos.duplicate', $cuentasEfectivo->id) }}"><i class="glyphicon glyphicon-duplicate"></i> Duplicate</a>
                                    @endpermission
                                    @permission('cuentasEfectivos.edit')
                                    <a class="btn btn-xs btn-warning" href="{{ route('cuentasEfectivos.edit', $cuentasEfectivo->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                                    @endpermission
                                    @permission('cuentasEfectivos.destroy')
                                    {!! Form::model($cuentasEfectivo, array('route' => array('cuentasEfectivos.destroy', $cuentasEfectivo->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? ¿Esta seguro?')) { return true } else {return false };")) !!}
                                        <button type="submit" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i> Borrar</button>
                                    {!! Form::close() !!}
                                    @endpermission
                                </td>
                            </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
                {!! $cuentasEfectivos->appends(Request::except('page'))->render() !!}
            @else
                <h3 class="text-center alert alert-info">Vacio!</h3>
            @endif

        </div>
    </div>

@endsection