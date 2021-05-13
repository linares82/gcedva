@extends('plantillas.admin_template')

@include('egresos._common')

@section('header')

    <ol class="breadcrumb">
    	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
        <!--
        @if ( $query_params = Request::input('q') )

            <li class="active"><a href="{{ route('egresos.index') }}">@yield('egresosAppTitle')</a></li>
            <li class="active">condition(  

            @foreach( $query_params as $key => $value )
                @if (!$loop->first) / @endif {{ $key }} : {{ $value }}
            @endforeach
            )</li>
        @else
            <li class="active">@yield('egresosAppTitle')</li>
        @endif
        -->
        <li class="active">@yield('egresosAppTitle')</li>
    </ol>

    <div class="">
        <h3>
            <i class="glyphicon glyphicon-align-justify"></i> @yield('egresosAppTitle')
            @permission('egresos.create')
            <a class="btn btn-success pull-right" href="{{ route('egresos.create') }}"><i class="glyphicon glyphicon-plus"></i> Crear</a>
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
                    <form class="Egreso_search" id="search" action="{{ route('egresos.index') }}" accept-charset="UTF-8" method="get">
                        <input type="hidden" name="q[s]" value="{{ @(Request::input('q')['s']) ?: '' }}" />
                        <div class="form-horizontal">

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
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_fecha_cont">FECHA</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['fecha_cont']) ?: '' }}" name="q[fecha_cont]" id="q_fecha_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_egresos_conceptos.name_gt">EGRESOS_CONCEPTO_NAME</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['egresos_conceptos.name_gt']) ?: '' }}" name="q[egresos_conceptos.name_gt]" id="q_egresos_conceptos.name_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['egresos_conceptos.name_lt']) ?: '' }}" name="q[egresos_conceptos.name_lt]" id="q_egresos_conceptos.name_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_egresos_conceptos.name_cont">EGRESOS_CONCEPTO_NAME</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['egresos_conceptos.name_cont']) ?: '' }}" name="q[egresos_conceptos.name_cont]" id="q_egresos_conceptos.name_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_detalle_gt">DETALLE</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['detalle_gt']) ?: '' }}" name="q[detalle_gt]" id="q_detalle_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['detalle_lt']) ?: '' }}" name="q[detalle_lt]" id="q_detalle_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_detalle_cont">DETALLE</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['detalle_cont']) ?: '' }}" name="q[detalle_cont]" id="q_detalle_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_forma_pagos.name_gt">FORMA_PAGO_NAME</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['forma_pagos.name_gt']) ?: '' }}" name="q[forma_pagos.name_gt]" id="q_forma_pagos.name_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['forma_pagos.name_lt']) ?: '' }}" name="q[forma_pagos.name_lt]" id="q_forma_pagos.name_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_forma_pagos.name_cont">FORMA_PAGO_NAME</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['forma_pagos.name_cont']) ?: '' }}" name="q[forma_pagos.name_cont]" id="q_forma_pagos.name_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_cuentas_efectivos.name_gt">CUENTAS_EFECTIVO_NAME</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['cuentas_efectivos.name_gt']) ?: '' }}" name="q[cuentas_efectivos.name_gt]" id="q_cuentas_efectivos.name_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['cuentas_efectivos.name_lt']) ?: '' }}" name="q[cuentas_efectivos.name_lt]" id="q_cuentas_efectivos.name_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_cuentas_efectivos.name_cont">CUENTAS_EFECTIVO_NAME</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['cuentas_efectivos.name_cont']) ?: '' }}" name="q[cuentas_efectivos.name_cont]" id="q_cuentas_efectivos.name_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_monto_gt">MONTO</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['monto_gt']) ?: '' }}" name="q[monto_gt]" id="q_monto_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['monto_lt']) ?: '' }}" name="q[monto_lt]" id="q_monto_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_monto_cont">MONTO</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['monto_cont']) ?: '' }}" name="q[monto_cont]" id="q_monto_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_empleados.nombre_gt">EMPLEADO_NOMBRE</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['empleados.nombre_gt']) ?: '' }}" name="q[empleados.nombre_gt]" id="q_empleados.nombre_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['empleados.nombre_lt']) ?: '' }}" name="q[empleados.nombre_lt]" id="q_empleados.nombre_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_empleados.nombre_cont">EMPLEADO_NOMBRE</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['empleados.nombre_cont']) ?: '' }}" name="q[empleados.nombre_cont]" id="q_empleados.nombre_cont" />
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
            @if($egresos->count())
                <table class="table table-condensed table-striped">
                    <thead>
                        <tr>
                            <th>@include('plantillas.getOrderLink', ['column' => 'id', 'title' => 'ID'])</th>
                            <th>@include('plantillas.getOrderlink', ['column' => 'plantels.plantel', 'title' => 'PLANTEL'])</th>
                            <th>@include('plantillas.getOrderlink', ['column' => 'fecha', 'title' => 'FECHA'])</th>
                        <th>@include('plantillas.getOrderlink', ['column' => 'egresos_conceptos.name', 'title' => 'EGRESOS CONCEPTO'])</th>
                        <th>@include('plantillas.getOrderlink', ['column' => 'forma_pagos.name', 'title' => 'FORMA PAGO'])</th>
                        <th>@include('plantillas.getOrderlink', ['column' => 'cuentas_efectivos.name', 'title' => 'CUENTA EFECTIVO'])</th>
                        <th>@include('plantillas.getOrderlink', ['column' => 'monto', 'title' => 'MONTO'])</th>
                        <th>@include('plantillas.getOrderlink', ['column' => 'empleado.nombre', 'title' => 'RESPONSABLE'])</th>
                        <th>COMPROBANTE</th>
                        
                            <th class="text-right">OPCIONES</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($egresos as $egreso)
                            <tr>
                                <td><a href="{{ route('egresos.show', $egreso->id) }}">{{$egreso->id}}</a></td>
                                <td>{{$egreso->plantel->razon}}</td>
                                <td>{{$egreso->fecha}}</td>
                    <td>{{$egreso->egresosConcepto->name}}</td>
                    <td>{{$egreso->formaPago->name}}</td>
                    <td>{{$egreso->cuentasEfectivo->name}}</td>
                    <td>{{$egreso->monto}}</td>
                    <td>{{$egreso->empleado->nombre}} {{$egreso->empleado->ape_paterno}} {{$egreso->empleado->ape_materno}}</td>
                    <td>
                        @if (!is_null($egreso->archivo))
                       <a href="{!! asset('imagenes/egresos/'.$egreso->id.'/'.$egreso->archivo) !!}"  target="_blank"> VER </a>
                       @else
                       <form action="{{ route('egresos.update',$egreso->id) }}" method="post" style="display: none" id="avatarForm">
                            <input type="hidden" name="_token" id="_token"  value="<?= csrf_token(); ?>"> 
                            <input type="file" id="comprobante_file" name="comprobante_file">
                        </form>
                        <a href='#' id="avatarImage">Cargar</a>
                       @endif
                        
                    </td>
                                <td class="text-right">
                                    @permission('egresos.edit')
<!--                                    <a class="btn btn-xs btn-primary" href="{{ route('egresos.duplicate', $egreso->id) }}"><i class="glyphicon glyphicon-duplicate"></i> Duplicate</a>-->
                                    @endpermission
                                    @permission('egresos.edit')
<!--                                    <a class="btn btn-xs btn-warning" href="{{ route('egresos.edit', $egreso->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>-->
                                        <a class="btn btn-xs btn-warning" href="{{ route('egresos.recibo', array('egreso'=>$egreso->id)) }}" target='_blank'><i class="glyphicon glyphicon-print"></i> Imprimir Recibo</a>
                                    @endpermission
                                    @permission('egresos.destroy')
                                    {!! Form::model($egreso, array('route' => array('egresos.destroy', $egreso->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? ¿Esta seguro?')) { return true } else {return false };")) !!}
                                        <button type="submit" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i> Borrar</button>
                                    {!! Form::close() !!}
                                    @endpermission
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {!! $egresos->appends(Request::except('page'))->render() !!}
            @else
                <h3 class="text-center alert alert-info">Vacio!</h3>
            @endif

        </div>
    </div>

@endsection

@push('scripts')
<script type="text/javascript">
    $(function () {
    var $avatarImage, $avatarInput, $avatarForm;

    $avatarImage = $('#avatarImage');
    $avatarInput = $('#comprobante_file');
    $avatarForm = $('#avatarForm');

    $avatarImage.on('click', function () {
        $avatarInput.click();
    });

    $avatarInput.on('change', function () {
        var formData = new FormData();
            formData.append('comprobante_file', $avatarInput[0].files[0]);
            
            
            $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('#_token').val()
                }
            });
            $.ajax({
                url: $avatarForm.attr('action'),
                method: $avatarForm.attr('method'),
                cache: false,
                data: formData,
                processData: false,
                contentType: false
            }).done(function (data) {
                //if (data.success)
                    //$avatarImage.attr('src', data.path);
                    location.reload();
            }).fail(function () {
                alert('La imagen subida no tiene un formato correcto');
            });
    });
});
      
      
</script>
@endpush
                    