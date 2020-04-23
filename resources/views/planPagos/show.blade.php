@extends('plantillas.admin_template')

@include('planPagos._common')

@section('header')

<style>
        .panel-heading {
            padding: 0;
        }
        .panel-heading ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
            overflow: hidden;
        }
        .panel-heading li {
            float: left;
            border-right:1px solid #bbb;
            display: block;
            padding: 14px 16px;
            text-align: center;
        }
        .panel-heading li:last-child:hover {
            background-color: #ccc;
        }
        .panel-heading li:last-child {
            border-right: none;
        }
        .panel-heading li a:hover {
            text-decoration: none;
        }

        .table.table-bordered tbody td {
            vertical-align: baseline;
        }
        /* icheck checkboxes */
        .iradio_flat-yellow {
            background: url(https://cdnjs.cloudflare.com/ajax/libs/iCheck/1.0.2/skins/square/yellow.png) no-repeat;
        }
    </style>

<ol class="breadcrumb">
	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
    <li><a href="{{ route('planPagos.index') }}">@yield('planPagosAppTitle')</a></li>
    <li class="active">{{ $planPago->name }}</li>
</ol>

<div class="page-header">
        <h1>@yield('planPagosAppTitle') / Mostrar {{$planPago->id}}

            {!! Form::model($planPago, array('route' => array('planPagos.destroy', $planPago->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? Estas seguro?')) { return true } else {return false };")) !!}
                <div class="btn-group pull-right" role="group" aria-label="...">
                    @permission('planPago.edit')
                    <a class="btn btn-warning btn-group" role="group" href="{{ route('planPagos.edit', $planPago->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                    @endpermission
                    @permission('planPago.destroy')
                    <button type="submit" class="btn btn-danger">Borrar <i class="glyphicon glyphicon-trash"></i><
                    /button>
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
                <div class="form-group col-sm-4">
                    <label for="nome">ID</label>
                    <p class="form-control-static">{{$planPago->id}}</p>
                </div>
                <div class="form-group col-sm-4">
                     <label for="name">PLAN PAGOS</label>
                     <p class="form-control-static">{{$planPago->name}}</p>
                </div>
                    <div class="form-group col-sm-4">
                     <label for="activo">ACTIVO</label>
                     <p class="form-control-static">{{$planPago->activo}}</p>
                </div>
                    <div class="form-group col-sm-4">
                     <label for="usu_alta_id">ALTA</label>
                     <p class="form-control-static">{{$planPago->usu_alta->name}}</p>
                </div>
                    <div class="form-group col-sm-4">
                     <label for="usu_mod_id">ULTIMA MODIFICACION</label>
                     <p class="form-control-static">{{$planPago->usu_mod->name}}</p>
                </div>
            </form>

            <div class="row">
            </div>
            <a class="btn btn-link" href="{{ route('planPagos.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>
            <div class="row">
                <h3>Pagos</h3>
                <a href="#" class="add-modal btn btn-success btn-xs">Agregar Pago</a>
                
                <div class="row col-md-12" id='loading3' style='display: none'>
                    <h3>Actualizando... Por Favor Espere.</h3>
                    <div class="progress progress-striped active page-progress-bar">
                        <div class="progress-bar" style="width: 100%;"></div>
                    </div>
                </div>
            </div>

            
            <div class="panel-body">
                
            <table class="table table-striped table-bordered table-hover" id="postTable" style="visibility: hidden;">
                <thead>
                    <tr>
                        <th>Concepto</th>
                        <!--<th>Cuenta Contable</th>
                        <th>Cuenta Recargo</th>-->
                        <th>Fecha Pago</th>
                        <th>Monto</th>
                        <th>Inicial</th>
                        <th>Promocion</th>
                        <th>R. Desc. Rec.</th>
                        <th></th>
                    </tr>
                    {{ csrf_field() }}
                </thead>
                <tbody>
                    @foreach($planPago->lineas as $linea)
                        <tr class="item{{$linea->id}}">
                            <td>{{$linea->cajaConcepto->name}}</td>
                            <!--<td>{{$linea->cuentaContable->name}}</td>
                            <td>{{$linea->cuentaRecargo->name}}</td>-->
                            <td>{{$linea->fecha_pago}}</td>
                            <td>{{$linea->monto}}</td>
                            <td>@if($linea->inicial_bnd==1)
                                SI
                                @else
                                NO
                                @endif
                            </td>
                            <td>
                                @foreach($linea->promoPlanLns as $promoPlanLn)
                                    {{$promoPlanLn->fec_inicio." / ".$promoPlanLn->fec_fin." / ".$promoPlanLn->descuento}} 
                                    <button class="edit-promo-modal btn btn-default btn-xs" data-promo_plan_pago_id="{{$promoPlanLn->id}}" 
                                                                                          data-fec_inicio="{{$promoPlanLn->fec_inicio}}"
                                                                                          data-fec_fin="{{$promoPlanLn->fec_fin}}"
                                                                                          data-descuento="{{$promoPlanLn->descuento}}">
                                <span class="glyphicon glyphicon-star"></span> Editar </button><br/>
                                <a class="btn btn-danger btn-xs" href="{{route('promoPlanLns.destroy',$promoPlanLn->id)}}">Borrar</a>
                                @endforeach
                            </td>
                            
                            <td>
                                <button class="reglas-modal btn btn-warning btn-xs" data-id="{{$linea->id}}" 
                                    data-plan_pago_id="{{$linea->plan_pago_id}}" >
                                <span class="glyphicon glyphicon-edit"></span> Reglas Descuento Recargo </button>
                                <br>
                                @foreach($linea->reglaRecargos as $regla)
                                {{ $regla->name }}
                                <br>
                                @endforeach
                            </td>

                            <td>
                                <button class="edit-modal btn btn-info btn-xs" data-id="{{$linea->id}}" 
                                                                               data-plan_pago_id="{{$linea->plan_pago_id}}" 
                                                                               data-caja_concepto_id="{{$linea->caja_concepto_id}}" 
                                                                               data-cuenta_contable_id="{{$linea->cuenta_contable_id}}"
                                                                               data-cuenta_recargo_id="{{$linea->cuenta_recargo_id}}"
                                                                               data-fecha_pago="{{$linea->fecha_pago}}"
                                                                               data-monto="{{$linea->monto}}"
                                                                               data-inicial_bnd="{{$linea->inicial_bnd}}">
                                <span class="glyphicon glyphicon-edit"></span> Editar </button>
                                
                                
                                <button class="promo-modal btn btn-success btn-xs" data-plan_pago_ln_id="{{$linea->id}}" >
                                <span class="glyphicon glyphicon-star"></span> Crear Promoción </button>
                                
                                
                                
                                
                                <button class="delete-modal btn btn-danger btn-xs" data-id="{{$linea->id}}" 
                                                                               data-plan_pago_id="{{$linea->plan_pago_id}}" 
                                                                               data-caja_concepto_id="{{$linea->caja_concepto_id}}" 
                                                                               data-cuenta_contable_id="{{$linea->cuenta_contable_id}}"
                                                                               data-cuenta_recargo_id="{{$linea->cuenta_recargo_id}}"
                                                                               data-fecha_pago="{{$linea->fecha_pago}}"
                                                                               data-monto="{{$linea->monto}}"
                                                                               data-inicial_bnd="{{$linea->inicial_bnd}}">
                                <span class="glyphicon glyphicon-trash"></span> Borrar </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
                
            </div>
        </div>
    </div>

<!-- Modal form to add a post -->
    <div id="addModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">×</button>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body">
                    {!! Form::open(array('route' => 'planPagoLns.store')) !!}
                         <div class="form-group col-md-6 @if($errors->has('caja_concepto_id')) has-error @endif">
                            <label for="caja_concepto_id-field">Caja Concepto</label><br/>
                            {!! Form::select("caja_concepto_id", $list["CajaConcepto"], null, array("class" => "form-control select_seguridad", "id" => "caja_concepto_id-crear")) !!}
                            {!! Form::hidden("plan_pago_id", null, array("class" => "form-control", "id" => "plan_pago_id-crear")) !!}
                            <p class="errorCajaConcepto text-center alert alert-danger hidden"></p>
                         </div>
                         <div class="form-group col-md-6 @if($errors->has('cuenta_contable_id')) has-error @endif">
                            <label for="cuenta_contable_id-field">Cuenta Contable</label><br/>
                            {!! Form::select("cuenta_contable_id", $list["CuentaContable"], null, array("class" => "form-control select_seguridad", "id" => "cuenta_contable_id-crear")) !!}
                            <p class="errorCuentaContable text-center alert alert-danger hidden"></p>
                         </div>
                         <div class="form-group col-sm-6 @if($errors->has('cuenta_recargo_id')) has-error @endif" style="clear:left;">
                            <label for="cuenta_recargo_id-field">Cuenta Recargo</label><br/>
                            {!! Form::select("cuenta_recargo_id", $list["CuentaContable"], null, array("class" => "form-control select_seguridad", "id" => "cuenta_recargo_id-crear")) !!}
                            <p class="errorCuentaRecargo text-center alert alert-danger hidden"></p>
                         </div>
                         <div class="form-group col-sm-6 @if($errors->has('fecha_pago')) has-error @endif">
                            <label for="fecha_pago-field">Fecha Pago</label>
                            {!! Form::text("fecha_pago", null, array("class" => "form-control", "id" => "fecha_pago-crear")) !!}
                            <p class="errorFechaPago text-center alert alert-danger hidden"></p>
                         </div>
                         <div class="form-group col-sm-6 @if($errors->has('monto')) has-error @endif">
                            <label for="monto-field">Monto</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-dollar"></i></span>
                                {!! Form::text("monto", null, array("class" => "form-control", "id" => "monto-crear")) !!}
                            </div>
                            <p class="errorMonto text-center alert alert-danger hidden"></p>
                         </div>
                         <div class="form-group col-sm-6 @if($errors->has('inicial_bnd')) has-error @endif">
                            <label for="inicial_bnd-field">Inicial</label>
                            {!! Form::checkbox("inicial_bnd", 1, null, [ "id" => "inicial_bnd-crear"]) !!}
                            <p class="errorInicialBnd text-center alert alert-danger hidden"></p>
                         </div>
                    {!! Form::close() !!}
                    <div class="row"></div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success add" id="Agregar" data-dismiss="modal">
                            <span id="" class='glyphicon glyphicon-check'></span> Crear
                        </button>
                        <button type="button" class="btn btn-warning" data-dismiss="modal">
                            <span class='glyphicon glyphicon-remove'></span> Cerrar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

<!-- Modal form to edit a form -->
    <div id="editModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">×</button>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" role="form">
                        <div class="form-group col-md-6 @if($errors->has('caja_concepto_id')) has-error @endif">
                            <label for="caja_concepto_id-field">Caja Concepto</label><br/>
                            {!! Form::select("caja_concepto_id", $list["CajaConcepto"], null, array("class" => "form-control select_seguridad", "id" => "caja_concepto_id-editar")) !!}
                            {!! Form::hidden("plan_pago_id", null, array("class" => "form-control", "id" => "plan_pago_id-editar")) !!}
                            <p class="errorCajaConcepto text-center alert alert-danger hidden"></p>
                         </div>
                         <div class="form-group col-md-6 @if($errors->has('cuenta_contable_id')) has-error @endif">
                            <label for="cuenta_contable_id-field">Cuenta Contable</label><br/>
                            {!! Form::select("cuenta_contable_id", $list["CuentaContable"], null, array("class" => "form-control select_seguridad", "id" => "cuenta_contable_id-editar")) !!}
                            <p class="errorCuentaContable text-center alert alert-danger hidden"></p>
                         </div>
                         <div class="form-group col-sm-6 @if($errors->has('cuenta_recargo_id')) has-error @endif" style="clear:left;">
                            <label for="cuenta_recargo_id-field">Cuenta Recargo</label><br/>
                            {!! Form::select("cuenta_recargo_id", $list["CuentaContable"], null, array("class" => "form-control select_seguridad", "id" => "cuenta_recargo_id-editar")) !!}
                            <p class="errorCuentaRecargo text-center alert alert-danger hidden"></p>
                         </div>
                         <div class="form-group col-sm-6 @if($errors->has('fecha_pago')) has-error @endif">
                            <label for="fecha_pago-field">Fecha Pago</label>
                            {!! Form::text("fecha_pago", null, array("class" => "form-control", "id" => "fecha_pago-editar")) !!}
                            <p class="errorFechaPago text-center alert alert-danger hidden"></p>
                         </div>
                         <div class="form-group col-sm-6 @if($errors->has('monto')) has-error @endif">
                            <label for="monto-field">Monto</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-dollar"></i></span>
                                {!! Form::text("monto", null, array("class" => "form-control", "id" => "monto-editar")) !!}
                            </div>
                            <p class="errorMonto text-center alert alert-danger hidden"></p>
                         </div>
                         <div class="form-group col-sm-6 @if($errors->has('inicial_bnd')) has-error @endif">
                            <label for="inicial_bnd-field">Inicial</label>
                            {!! Form::checkbox("inicial_bnd", 1, null, [ "id" => "inicial_bnd-editar"]) !!}
                            <p class="errorInicialBnd text-center alert alert-danger hidden"></p>
                         </div>
                    </form>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary edit" id="Editar" data-dismiss="modal">
                            <span class='glyphicon glyphicon-check'></span> Editar
                        </button>
                        <button type="button" class="btn btn-warning" data-dismiss="modal">
                            <span class='glyphicon glyphicon-remove'></span> Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal form to edit a form -->
    <div id="reglasModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">×</button>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" role="form">
                        <div class="row_reglas_relacionadas">
                            <div class="form-group col-md-6 @if($errors->has('caja_concepto_id')) has-error @endif">
                                <label for="caja_concepto_id-field">Reglas Descuentos y Recargos</label><br/>
                                {!! Form::hidden("plan_pago_ln_id", null, array("class" => "form-control", "id" => "plan_pago_ln_id-editar")) !!}
                             </div>
                            <div class="row"></div>
                            <div class="col-xs-5">
                                {!! Form::select("select-regla_recargo_id", array(), null, array("class" => "form-control select-multiple", "id" => "select-reglas_recargos_from", "name"=>"from[]", 'multiple'=>'multiple', 'style'=>'height:200px;')) !!}
                            </div>

                            <div class="col-xs-2">
                                <!--<button type="button" id="right_All_1" class="btn btn-block"><i class="glyphicon glyphicon-forward"></i></button>-->
                                <button type="button" id="right_Selected" class="btn btn-block"><i class="glyphicon glyphicon-chevron-right"></i></button>
                                <button type="button" id="left_Selected" class="btn btn-block"><i class="glyphicon glyphicon-chevron-left"></i></button>
                                <!--<button type="button" id="left_All_1" class="btn btn-block"><i class="glyphicon glyphicon-backward"></i></button>-->
                            </div>

                            <div class="col-xs-5">
                                {!! Form::select("select-regla_recargo_id", array(), null, array("class" => "form-control select-multiple", "id" => "select-reglas_recargos_to", "name"=>"to[]", 'multiple'=>'multiple', 'style'=>'height:200px;')) !!}
                            </div>
                        </div> 
                    </form>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary edit closeReglas" data-dismiss="modal">
                            <span class='glyphicon glyphicon-check'></span> Editar
                        </button>
                        <button type="button" class="btn btn-warning" data-dismiss="modal">
                            <span class='glyphicon glyphicon-remove'></span> Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Modal form to edit a Promocion -->
    <div id="promoModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">×</button>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" role="form">
                        <div class="row_reglas_relacionadas">
                            <div class="form-group col-md-6 @if($errors->has('plan_pago_ln_id')) has-error @endif">
                                {!! Form::hidden("plan_pago_ln_id", null, array("class" => "form-control", "id" => "plan_pago_ln_id-crear")) !!}
                             </div>
                            <div class="row"></div>
                            <div class="form-group col-sm-6 @if($errors->has('inicial_bnd')) has-error @endif">
                            <label for="inicial_bnd-field">Inicial</label>
                                {!! Form::text("fec_inicio", null, array("class" => "fec_calendario form-control", "id" => "fec_inicio-crear")) !!}
                            </div>
                            
                            <div class="form-group col-sm-6 @if($errors->has('fec_fin')) has-error @endif">
                            <label for="fec_fin-field">Fecha Fin</label>
                                {!! Form::text("fec_fin", null, array("class" => "fec_calendario form-control", "id" => "fec_fin-crear")) !!}
                            </div>

                            <div class="form-group col-sm-6 @if($errors->has('fec_fin')) has-error @endif">
                            <label for="descuento-editar">Porcentaje de descuento en decimales</label>
                                {!! Form::text("descuento", null, array("class" => "form-control", "id" => "descuento-crear")) !!}
                            </div>
                            <div class="row"></div>
                        </div> 
                    </form>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id="Promo-crear" data-dismiss="modal">
                            <span class='glyphicon glyphicon-check'></span> Crear
                        </button>
                        <button type="button" class="btn btn-warning" data-dismiss="modal">
                            <span class='glyphicon glyphicon-remove'></span> Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal form to edit a Promocion -->
    <div id="editPromoModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">×</button>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" role="form">
                        <div class="row_reglas_relacionadas">
                            <div class="form-group col-md-6 @if($errors->has('plan_pago_ln_id')) has-error @endif">
                                {!! Form::hidden("promo_plan_pago_id", null, array("class" => "form-control", "id" => "promo_plan_pago_id-editar")) !!}
                             </div>
                            <div class="row"></div>
                            <div class="form-group col-sm-6 @if($errors->has('inicial_bnd')) has-error @endif">
                            <label for="inicial_bnd-field">Inicial</label>
                                {!! Form::text("fec_inicio", null, array("class" => "fec_calendario form-control", "id" => "fec_inicio-editar")) !!}
                            </div>
                            
                            <div class="form-group col-sm-6 @if($errors->has('fec_fin')) has-error @endif">
                            <label for="fec_fin-field">Fecha Fin</label>
                                {!! Form::text("fec_fin", null, array("class" => "fec_calendario form-control", "id" => "fec_fin-editar")) !!}
                            </div>

                            <div class="form-group col-sm-6 @if($errors->has('fec_fin')) has-error @endif">
                            <label for="descuento-editar">Porcentaje de descuento en decimales</label>
                                {!! Form::text("descuento", null, array("class" => "form-control", "id" => "descuento-editar")) !!}
                            </div>
                            <div class="row"></div>
                        </div> 
                    </form>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id="Promo-editar" data-dismiss="modal">
                            <span class='glyphicon glyphicon-check'></span> Crear
                        </button>
                        <button type="button" class="btn btn-warning" data-dismiss="modal">
                            <span class='glyphicon glyphicon-remove'></span> Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal form to delete a form -->
    <div id="deleteModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">×</button>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body">
                    <h3 class="text-center">¿Borrar registro?</h3>
                    <br />
                    <form class="form-horizontal" role="form">
                        <div class="form-group col-md-6 @if($errors->has('caja_concepto_id')) has-error @endif">
                            <label for="caja_concepto_id-field">Caja Concepto</label><br/>
                            {!! Form::select("caja_concepto_id", $list["CajaConcepto"], null, array("class" => "form-control select_seguridad", "id" => "caja_concepto_id-eliminar")) !!}
                            {!! Form::hidden("plan_pago_id", null, array("class" => "form-control", "id" => "plan_pago_id-eliminar")) !!}
                            <p class="errorCajaConcepto text-center alert alert-danger hidden"></p>
                         </div>
                         <div class="form-group col-md-6 @if($errors->has('cuenta_contable_id')) has-error @endif">
                            <label for="cuenta_contable_id-field">Cuenta Contable</label><br/>
                            {!! Form::select("cuenta_contable_id", $list["CuentaContable"], null, array("class" => "form-control select_seguridad", "id" => "cuenta_contable_id-eliminar")) !!}
                            <p class="errorCuentaContable text-center alert alert-danger hidden"></p>
                         </div>
                         <div class="form-group col-sm-6 @if($errors->has('cuenta_recargo_id')) has-error @endif" style="clear:left;">
                            <label for="cuenta_recargo_id-field">Cuenta Recargo</label><br/>
                            {!! Form::select("cuenta_recargo_id", $list["CuentaContable"], null, array("class" => "form-control select_seguridad", "id" => "cuenta_recargo_id-eliminar")) !!}
                            <p class="errorCuentaRecargo text-center alert alert-danger hidden"></p>
                         </div>
                         <div class="form-group col-sm-6 @if($errors->has('fecha_pago')) has-error @endif">
                            <label for="fecha_pago-field">Fecha Pago</label>
                            {!! Form::text("fecha_pago", null, array("class" => "form-control", "id" => "fecha_pago-eliminar")) !!}
                            <p class="errorFechaPago text-center alert alert-danger hidden"></p>
                         </div>
                         <div class="form-group col-sm-6 @if($errors->has('monto')) has-error @endif">
                            <label for="monto-field">Monto</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-dollar"></i></span>
                                {!! Form::text("monto", null, array("class" => "form-control", "id" => "monto-eliminar")) !!}
                            </div>
                            <p class="errorMonto text-center alert alert-danger hidden"></p>
                         </div>
                         <div class="form-group col-sm-6 @if($errors->has('inicial_bnd')) has-error @endif">
                            <label for="inicial_bnd-field">Inicial</label>
                            {!! Form::checkbox("inicial_bnd", 1, null, [ "id" => "inicial_bnd-eliminar"]) !!}
                            <p class="errorInicialBnd text-center alert alert-danger hidden"></p>
                         </div>
                    </form>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger delete" id="Eliminar" data-dismiss="modal">
                            <span id="" class='glyphicon glyphicon-trash'></span> Borrar
                        </button>
                        <button type="button" class="btn btn-warning" data-dismiss="modal">
                            <span class='glyphicon glyphicon-remove'></span> Cerrar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
<link href="{{asset('bower_components/AdminLTE/plugins/jquery.loading.css')}}" rel="stylesheet">
    <script src="{{ asset('bower_components/AdminLTE/plugins/multiselect.js') }}"></script>
    <script src="{{ asset('bower_components/AdminLTE/plugins/jquery.loading.js') }}"></script>
<script>
    $(window).load(function(){
        $('#postTable').removeAttr('style');
    })
</script>
<script>
    $('#fecha_pago-crear').Zebra_DatePicker({
    days:['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'],
            months:['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
            readonly_element: false,
            lang_clear_date: 'Limpiar',
            show_select_today: 'Hoy',
    });
    $('#fecha_pago-editar').Zebra_DatePicker({
    days:['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'],
            months:['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
            readonly_element: false,
            lang_clear_date: 'Limpiar',
            show_select_today: 'Hoy',
    });
    
    $('.fec_calendario').Zebra_DatePicker({
                        days:['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'],
                                months:['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
                                readonly_element: false,
                                lang_clear_date: 'Limpiar',
                                show_select_today: 'Hoy',
                        });
    
    //crear registro
    $(document).on('click', '.add-modal', function() {
        $('.modal-title').text('Agregar Pago');
        
        //Limpiar valores
        $('#caja_concepto_id-crear').val(0).change();
        $('#cuenta_contable_id-crear').val(0).change();
        $('#cuenta_recargo_id-crear').val(0).change();
        $('#fecha_pago-crear').val('');
        $('#monto-crear').val(0);
        $('#inicial_bnd-crear').prop("checked", false);
        
        $('#addModal').modal('show');
        $('#plan_pago_id-crear').val({{$planPago->id}});
    });
    
    $('.modal-footer').on('click', '.add', '#Agregar', function() {
        if( $('#inicial_bnd-crear').prop('checked') ) {
            bnd=1;
        }else{
            bnd=0;
        }
        $.ajax({
            type: 'POST',
            url: '{{route("planPagoLns.store")}}',
            data: {
                '_token': $('input[name=_token]').val(),
                'plan_pago_id': $('#plan_pago_id-crear').val(),
                'caja_concepto_id': $('#caja_concepto_id-crear').val(),
                'cuenta_contable_id': $('#cuenta_contable_id-crear').val(),
                'cuenta_recargo_id': $('#cuenta_recargo_id-crear').val(),
                'fecha_pago': $('#fecha_pago-crear').val(),
                'monto': $('#monto-crear').val(),
                'inicial_bnd': bnd,
            },
            beforeSend : function(){$("#loading3").show(); },
            complete : function(){$("#loading3").hide(); },
            success: function(data) {
                location.reload;
                $('.errorTitle').addClass('hidden');
                $('.errorContent').addClass('hidden');

                if ((data.errors)) {
                    setTimeout(function () {
                        $('#addModal').modal('show');
                        toastr.error('Validation error!', 'Error Alert', {timeOut: 5000});
                    }, 500);

                    if (data.errors.caja_concepto_id) {
                        $('.errorCajaConcepto').removeClass('hidden');
                        $('.errorCajaConcepto').text(data.errors.caja_concepto_id);
                    }
                    if (data.errors.cuenta_contable_id) {
                        $('.errorCuentaContable').removeClass('hidden');
                        $('.errorCuentaContable').text(data.errors.cuenta_contable_id);
                    }
                    if (data.errors.cuenta_recargo_id) {
                        $('.errorCuentaRecargo').removeClass('hidden');
                        $('.errorCuentaRecargo').text(data.errors.cuenta_recargo_id);
                    }
                    if (data.errors.fecha_pago) {
                        $('.errorFechaPago').removeClass('hidden');
                        $('.errorFechaPago').text(data.errors.fecha_pago);
                    }
                    if (data.errors.monto) {
                        $('.errorMonto').removeClass('hidden');
                        $('.errorMonto').text(data.errors.monto);
                    }
                } else {
                    //toastr.success('Successfully added Post!', 'Success Alert', {timeOut: 5000});
                    bnd=(data.inicial_bnd==1)?"SI":"NO";
                    
                    $('#postTable').append("<tr class='item" + data.id +"'><td>" + data.caja_concepto + 
                        "</td><td>" + data.cuenta_contable + 
                        "</td><td>" + data.cuenta_recargo + 
                        "</td><td>" + data.fecha_pago + 
                        "</td><td>" + data.monto + 
                        "</td><td>" + bnd + 
                        "</td><td><button class='edit-modal btn btn-info btn-xs' data-id='" + data.id + 
                                                                "' data-plan_pago_id='" + data.plan_pago_id + 
                                                                "' data-caja_concepto_id='" + data.caja_concepto_id +
                                                                "' data-cuenta_contable_id='" + data.cuenta_contable_id +
                                                                "' data-cuenta_recargo_id='" + data.cuenta_recargo_id +
                                                                "' data-fecha_pago='" + data.fecha_pago +
                                                                "' data-monto='" + data.monto +
                                                                "' data-inicial_bnd='" + data.inicial_bnd +
                        "'><span class='glyphicon glyphicon-edit'></span> Editar</button><button class='reglas-modal btn btn-warning btn-xs' data-id='" + data.id + 
                                                                "' data-plan_pago_id='" + data.plan_pago_id + 
                        "'><span class='glyphicon glyphicon-edit'></span> Reglas Descuento Recargo</button> <button class='delete-modal btn btn-danger btn-xs' data-id='" + data.id + 
                                                                "' data-plan_pago_id='" + data.plan_pago_id + 
                                                                "' data-caja_concepto_id='" + data.caja_concepto_id +
                                                                "' data-cuenta_contable_id='" + data.cuenta_contable_id +
                                                                "' data-cuenta_recargo_id='" + data.cuenta_recargo_id +
                                                                "' data-fecha_pago='" + data.fecha_pago +
                                                                "' data-monto='" + data.monto +
                                                                "' data-inicial_bnd='" + data.inicial_bnd +
                        "'><span class='glyphicon glyphicon-trash'></span> Borrar </button></td></tr>");
                }
            },
        });
    });
    // Edit a post
    id_editar=0;
    $(document).on('click', '.edit-modal', function() {
        $('.modal-title').text('Editar');
        $('#plan_pago_id-editar').val($(this).data('plan_pago_id'));
        $('#caja_concepto_id-editar').val($(this).data('caja_concepto_id')).change();
        $('#cuenta_contable_id-editar').val($(this).data('cuenta_contable_id')).change();
        $('#cuenta_recargo_id-editar').val($(this).data('cuenta_recargo_id')).change();
        $('#fecha_pago-editar').val($(this).data('fecha_pago'));
        
        $('#monto-editar').val($(this).data('monto'));
        if ($(this).data('inicial_bnd')==1) {
            $('#inicial_bnd-editar').prop("checked", true);
        }else{
            $('#inicial_bnd-editar').prop("checked", false);
        }
        
        $('#editModal').modal('show');
        id_editar=$(this).data('id');
        //alert(id);
    });
    
    
     $('.modal-footer').on('click', '#Editar', function() {
        var ruta='{{url("planPagoLns/update")}}' + '/' + id_editar;
        //alert(ruta);
        if( $('#inicial_bnd-editar').prop('checked') ) {
            bnd=1;
        }else{
            bnd=0;
        }
        //alert(bnd);
        $.ajax({
            type: 'POST',
            url: ruta,
            data: {
                '_token': $('input[name=_token]').val(),
                'plan_pago_id': $('#plan_pago_id-editar').val(),
                'caja_concepto_id': $('#caja_concepto_id-editar').val(),
                'cuenta_contable_id': $('#cuenta_contable_id-editar').val(),
                'cuenta_recargo_id': $('#cuenta_recargo_id-editar').val(),
                'fecha_pago': $('#fecha_pago-editar').val(),
                'monto': $('#monto-editar').val(),
                'inicial_bnd': bnd,
            },
            beforeSend : function(){$("#loading3").show(); },
            complete : function(){$("#loading3").hide(); },
            success: function(data) {
                location.reload();
                $('.errorTitle').addClass('hidden');
                $('.errorContent').addClass('hidden');

                if ((data.errors)) {
                    setTimeout(function () {
                        $('#editModal').modal('show');
                        toastr.error('Validation error!', 'Error Alert', {timeOut: 5000});
                    }, 500);

                    if (data.errors.caja_concepto_id) {
                        $('.errorCajaConcepto').removeClass('hidden');
                        $('.errorCajaConcepto').text(data.errors.caja_concepto_id);
                    }
                    if (data.errors.cuenta_contable_id) {
                        $('.errorCuentaContable').removeClass('hidden');
                        $('.errorCuentaContable').text(data.errors.cuenta_contable_id);
                    }
                    if (data.errors.cuenta_recargo_id) {
                        $('.errorCuentaRecargo').removeClass('hidden');
                        $('.errorCuentaRecargo').text(data.errors.cuenta_recargo_id);
                    }
                    if (data.errors.fecha_pago) {
                        $('.errorFechaPago').removeClass('hidden');
                        $('.errorFechaPago').text(data.errors.fecha_pago);
                    }
                    if (data.errors.monto) {
                        $('.errorMonto').removeClass('hidden');
                        $('.errorMonto').text(data.errors.monto);
                    }
                } else {
                    //toastr.success('Successfully updated Post!', 'Success Alert', {timeOut: 5000});
                    bnd1=(data.inicial_bnd==1)?"SI":"NO";
                    //alert(bnd1);

                    $('.item' + data.id).replaceWith("<tr class='item" + data.id +"'><td>" + data.caja_concepto + 
                                               "</td><td>" + data.cuenta_contable + 
                                               "</td><td>" + data.cuenta_recargo + 
                                               "</td><td>" + data.fecha_pago + 
                                               "</td><td>" + data.monto + 
                                               "</td><td>" + bnd1 + 
                                               "</td><td><button class='edit-modal btn btn-info btn-xs' data-id='" + data.id + 
                                                                                       "' data-plan_pago_id='" + data.plan_pago_id + 
                                                                                       "' data-caja_concepto_id='" + data.caja_concepto_id +
                                                                                       "' data-cuenta_contable_id='" + data.cuenta_contable_id +
                                                                                       "' data-cuenta_recargo_id='" + data.cuenta_recargo_id +
                                                                                       "' data-fecha_pago='" + data.fecha_pago +
                                                                                       "' data-monto='" + data.monto +
                                                                                       "' data-inicial_bnd='" + data.inicial_bnd +
                                                "'><span class='glyphicon glyphicon-edit'></span> Editar</button><button class='reglas-modal btn btn-warning btn-xs' data-id='" + data.id + 
                                                                                       "' data-plan_pago_id='" + data.plan_pago_id + 
                                               "'><span class='glyphicon glyphicon-edit'></span> Reglas Descuento Recargo</button> <button class='delete-modal btn btn-danger btn-xs' data-id='" + data.id + 
                                                                                       "' data-plan_pago_id='" + data.plan_pago_id + 
                                                                                       "' data-caja_concepto_id='" + data.caja_concepto_id +
                                                                                       "' data-cuenta_contable_id='" + data.cuenta_contable_id +
                                                                                       "' data-cuenta_recargo_id='" + data.cuenta_recargo_id +
                                                                                       "' data-fecha_pago='" + data.fecha_pago +
                                                                                       "' data-monto='" + data.monto +
                                                                                       "' data-inicial_bnd='" + data.inicial_bnd +
                                               "'><span class='glyphicon glyphicon-trash'></span> Borrar </button></td></tr>");

                }
            }
        });
    });
    
    // Regla a post
    $(document).on('click', '.reglas-modal', function() {
        $('.modal-title').text('Editar');
        $('#plan_pago_id-editar').val($(this).data('plan_pago_id'));
        id_regla=$(this).data('id');
        
        $.ajax({
            url: '{{ route("reglaRecargos.getReglaXLinea") }}',
            type: 'GET',
            data: "linea=" + id_regla,
            dataType: 'json',
            beforeSend: function () {
                //$("#loading10").show();
            },
            complete: function () {
                //$("#loading10").hide();
            },
            success: function (data) {
                //$example.select2("destroy");
                $('#select-reglas_recargos_to').empty();
                $.each(data, function (i) {
                    //alert(data[i].name);
                    $('#select-reglas_recargos_to').append("<option " + data[i].selectec + " value=\"" + data[i].id + "\">" + data[i].name + "<\/option>");
                });
                //$example.select2();
            }
        });
        
        $.ajax({
            url: '{{ route("reglaRecargos.getNoReglaXLinea") }}',
            type: 'GET',
            data: "linea=" + id_regla,
            dataType: 'json',
            beforeSend: function () {
                //$("#loading10").show();
            },
            complete: function () {
                //$("#loading10").hide();
            },
            success: function (data) {
                //$example.select2("destroy");
                $('#select-reglas_recargos_from').empty();
                $.each(data, function (i) {
                    //alert(data[i].name);
                    $('#select-reglas_recargos_from').append("<option " + data[i].selectec + " value=\"" + data[i].id + "\">" + data[i].name + "<\/option>");
                });
                //$example.select2();
            }
        });
        
        $('#reglasModal').modal('show');
        
        //alert(id);
    });

    $('.modal-footer').on('click', '.closeReglas', function() {
        //alert('fil');
        location.reload();
    });
    
    // Crear una Promocion
    $(document).on('click', '.promo-modal', function() {
        $('.modal-title').text('Promocion');
        $('#plan_pago_ln_id-crear').val($(this).data('plan_pago_ln_id'));
        $('#fec_inicio-crear').val("").change();
        $('#fec_fin-crear').val("").change();
        $('#descuento-crear').val("").change();
        id=$('#plan_pago_ln_id-crear').val()
        
        $('#promoModal').modal('show');
        
        //alert(id);
    });
    
    //Botones para crear promocion
    $('.modal-footer').on('click', '#Promo-crear', function() {
        var ruta='{{url("promoPlanLns/store")}}';
        //alert(ruta);
        
        //alert(bnd);
        $.ajax({
            type: 'POST',
            url: ruta,
            data: {
                '_token': $('input[name=_token]').val(),
                'plan_pago_ln_id': $('#plan_pago_ln_id-crear').val(),
                'fec_inicio': $('#fec_inicio-crear').val(),
                'fec_fin': $('#fec_fin-crear').val(),
                'descuento': $('#descuento-crear').val()
            },
            dataType:'json',
            beforeSend : function(){$("#loading3").show(); },
            complete : function(){$("#loading3").hide(); },
            success: function(data) {
                
                location.reload(); 
            }
        });
    });
    
    // Editar una promocion
    
    $(document).on('click', '.edit-promo-modal', function() {
        $('.modal-title').text('Editar Promoción');
        $('#promo_plan_pago_id-editar').val($(this).data('promo_plan_pago_id'));
        $('#fec_inicio-editar').val($(this).data('fec_inicio')).change();
        $('#fec_fin-editar').val($(this).data('fec_fin')).change();
        $('#descuento-editar').val($(this).data('descuento'));
        
        //alert($('#descuento-editar').val());
        //console.log($(this).data('descuento'));
        id_promo=$(this).data('promo_plan_pago_id');
        
        $('#editPromoModal').modal('show');
    });
    
    //botones para editar una promocion
    $('.modal-footer').on('click', '#Promo-editar', function() {
        var ruta='{{url("/promoPlanLns/update")}}' + '/' + id_promo;
        //alert(ruta);
        
        //alert(bnd);
        $.ajax({
            type: 'POST',
            url: ruta,
            data: {
                '_token': $('input[name=_token]').val(),
                'id': id_promo,
                'fec_inicio': $('#fec_inicio-editar').val(),
                'fec_fin': $('#fec_fin-editar').val(),
                'descuento': $('#descuento-editar').val()
            },
            beforeSend : function(){$("#loading3").show(); },
            complete : function(){$("#loading3").hide(); },
            success: function(data) {
                location.reload(); 
            }
        });
    });
    
    // delete a post
    $(document).on('click', '.delete-modal', '#Eliminar', function() {
        $('.modal-title').text('Eliminar');
        $('#plan_pago_id-eliminar').val($(this).data('plan_pago_id'));
        $('#caja_concepto_id-eliminar').val($(this).data('caja_concepto_id')).change();
        $('#cuenta_contable_id-eliminar').val($(this).data('cuenta_contable_id')).change();
        $('#cuenta_recargo_id-eliminar').val($(this).data('cuenta_recargo_id')).change();
        $('#fecha_pago-eliminar').val($(this).data('fecha_pago'));
        $('#monto-eliminar').val($(this).data('monto'));
        $('#inicial_bnd-eliminar').val($(this).data('inicial_bnd'));
        $('#deleteModal').modal('show');
        id_deleted=$(this).data('id');
    });
    $('.modal-footer').on('click', '.delete', function() {
        var ruta='{{url("planPagoLns/destroy")}}' + '/' + id_deleted;
        $.ajax({
            type: 'GET',
            url: ruta,
            data: {
                '_token': $('input[name=_token]').val(),
            },
            beforeSend : function(){$("#loading3").show(); },
            complete : function(){$("#loading3").hide(); },
            success: function(data) {
                //toastr.success('Successfully deleted Post!', 'Success Alert', {timeOut: 5000});
                $('.item' + data.id).remove();
            }
        });
    });
    
    $('#caja_concepto_id-crear').change(function(){
        getCosto($('#caja_concepto_id-crear option:selected').val());
    });
    
    $('#caja_concepto_id-editar').change(function(){
        if($('#caja_concepto_id-editar').val()==""){
			getCosto($('#caja_concepto_id-editar option:selected').val());
		}
    });
    
    function getCosto(concepto){
        $.ajax({
            url: '{{ route("cajaconceptos.getCostoConcepto") }}',
                type: 'GET',
                data: "concepto=" + concepto,
                dataType: 'json',
                beforeSend : function(){$("#loading1").show(); },
                complete : function(){$("#loading1").hide(); },
                success: function(data){
                        $('#monto-crear').val(data);
                        $('#monto-editar').val(data);
                }
            });
    }
    //https://jmkleger.com/post/ajax-crud-for-laravel-5-4 ejemplo
    
    $(document).ready(function () {
        $('#select-reglas_recargos_from').multiselect({
            right: '#select-reglas_recargos_to',
            search: {
                left: '<input type="text" name="q" class="form-control" placeholder="Buscar..." />',
                right: '<input type="text" name="q" class="form-control" placeholder="Buscar..." />',
            },
            fireSearch: function (value) {
                return value.length > 3;
            },
            rightAll: '#right_All',
            rightSelected: '#right_Selected',
            leftSelected: '#left_Selected',
            leftAll: '#left_All',
            beforeMoveToLeft: function ($left, $right, $options) {
                var regla = $("select#select-reglas_recargos_to option:selected").val();
                $.ajax({
                    url: '{{ route("planPagoLns.lessRegla") }}',
                    type: 'GET',
                    data: "linea="+id_regla+"&regla=" + regla + "",
                    dataType: 'json',
                    beforeSend: function () {
                        /*$('.row_reglas_relacionadas').loading({
                            theme: 'dark',
                            message: 'Procesando..',
                        });*/
                    },
                    complete: function () {
                        //$('.row_reglas_relacionadas').loading('stop');
                    },
                    success: function (data) {

                    }
                });
                return true;
            },
            beforeMoveToRight: function ($left, $right, $options) {
                var actividad = $("select#select-reglas_recargos_from option:selected").val();
                $.ajax({
                    url: '{{ route("planPagoLns.addRegla") }}',
                    type: 'GET',
                    data: "linea="+id_regla+"&regla=" + actividad + "",
                    dataType: 'json',
                    beforeSend: function () {
                        $('.row_reglas_relacionadas').loading({
                            theme: 'dark',
                            message: 'Procesando..',
                        });
                    },
                    complete: function () {
                        $('.row_reglas_relacionadas').loading('stop');
                    },
                    success: function (data) {

                    }
                });
                return true;

            },
        });
    });
</script>
@endpush
