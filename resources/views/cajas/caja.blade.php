@inject('cli_funciones','App\Http\Controllers\ClientesController')

@extends('plantillas.admin_template')

@include('cajas._common')

@section('header')

<ol class="breadcrumb">
    <li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
    <li><a href="{{route('cajas.caja')}}">Caja</a></li>
</ol>


@endsection

@section('content')
@include('error')
@if (session('ids_invalidos'))
    <?php 
    $ids=session('ids_invalidos'); 
    //dd($ids);
    ?>
    
    <div class="alert alert-error">
        Tickets con estatus Invalido: 
        @foreach($ids as $id)
        {{ $id['consecutivo'] }} en {{ $id['razon'] }} con cliente {{ $id['cliente_id'] }} <br/>
        @endforeach
    </div>
@endif
@if (session('msj'))
    
    <div class="alert alert-error">
        {{ session('msj') }}
    </div>
@endif

@php
//$suma_pagos=0;
//$contador_pagos=0;
    if(isset($caja)){
        $caja->load('cajaLns');
        $caja->load('plantel');
        $caja->load('pagos');
        $valores=$caja->plantel->conceptoMultipagos->pluck('id');
        //$contador_pagos=App\Pago::where('caja_id', $adeudo->caja_id)->count();
        
        //$suma_pagos=App\Pago::where('caja_id', $adeudo->caja_id)->sum('monto');
        //dd($caja->cajaLns->toArray());
    }
    if(isset($cliente)){
        $cliente->load('incidencesClientes');
        $cliente->load('autorizacionBecas');
        
    }
    
@endphp

<div class="row">
    <div class="col-md-6">
        <div class="box box-info">
            <div class="box-body">
                
                @permission('cajas.buscarVenta')
                {!! Form::open(array('route' => 'cajas.buscarVenta','id'=>'form-buscarVenta')) !!}
                
                <div class="input-group col-md-12">
                    @if(isset($caja))
                    {!! Form::select("plantel_id", $list["Plantel"], ($caja)?$caja->plantel_id:"", array("class" => "form-control select_seguridad", "id" => "plantel_id-field")) !!}
                    @else
                    {!! Form::select("plantel_id", $list["Plantel"], null, array("class" => "form-control select_seguridad", "id" => "plantel_id-field")) !!}
                    @endif
                </div>
                
                <div class="input-group form-group col-md-12">
                    @if(isset($caja))
                    {!! Form::hidden("cliente_caja", ($caja)?$caja->cliente_id:"", array("class" => "form-control ", 'placeholder'=>'cliente',"id" => "cliente_caja-field")) !!}
                    @else
                    {!! Form::hidden("cliente_caja", null, array("class" => "form-control ", 'placeholder'=>'Cliente', "id" => "cliente_caja-field")) !!}
                    @endif
                </div>

                <div class="input-group form-group col-md-12">
                    <div class="input-group-btn">
                        <button type="submit" class="btn btn-info" data-toggle="tooltip" title="Buscar Venta"><i class='fa fa-search'></i></button>
                    </div>

                    @if(isset($caja))
                    {!! Form::text("consecutivo", ($caja)?$caja->consecutivo:"", array("class" => "form-control ", 'placeholder'=>'No. de Venta',"id" => "consecutivo-field")) !!}
                    @else
                    {!! Form::text("consecutivo", null, array("class" => "form-control ", 'placeholder'=>'No. de Venta', "id" => "consecutivo-field")) !!}
                    @endif
                </div>
                                
                @if(isset($message))
                <div class="alert alert-danger alert-dismissable">
                    {{$message}}
                </div>
                @endif

                {!! Form::close() !!}
                @endpermission
                
                <div class="col-md-4">
                    <a class='btn btn-sm btn-warning' target='_blank' href="{{route('cajas.adeudosXplantel')}}"> Ver Adeudos</a>
                </div>
                
            
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="box box-info">
            <div class="box-header with-border">
                <div class="box-title">
                    <h4>Corte</h4> 
                </div>
                
            </div>
            <div class="box-body">
                @permission('cajaCortes.create')
                    <a class='btn btn-sm btn-success' target='_blank' href="{{route('cajaCortes.create')}}">Corte de Caja</a>
                @endpermission
                @permission('cajaCortes.index')
                    <a class='btn btn-sm btn-success' target='_blank' href="{{route('cajaCortes.index')}}">Historia</a>
                @endpermission
                
            </div>
        </div>
    </div>
    <div class="row"></div>
    <div class="col-md-6">
        <div class="col-md-4">
            <div class="box box-info">
                <div class="box-body">
                    {!! Form::open(array('route' => 'cajas.buscarCliente', 'id'=>'frmBuscarCliente')) !!}

                    <div class="input-group form-group col-md-12">
                        <div class="input-group-btn">
                            <button type="submit" class="btn btn-info" data-toggle="tooltip" title="Buscar Cliente"><i class='fa fa-search'></i></button>
                        </div>
                        @if(isset($cliente))
                        {!! Form::text("cliente_id", ($cliente)?$cliente->id:"", array("class" => "form-control ", 'placeholder'=>'No. de Cliente',"id" => "cliente_id-field")) !!}
                        @else
                        {!! Form::text("cliente_id", null, array("class" => "form-control ", 'placeholder'=>'No. de Cliente', "id" => "cliente_id-field")) !!}
                        @endif

                        @if($errors->has("cliente_id"))
                        <span class="help-block">{{ $errors->first("cliente_id") }}</span>
                        @endif
                    </div>

                    @if(isset($message))
                    <div class="alert alert-danger alert-dismissable">
    
                        {{$message}}
                    </div>
                    @endif

                    {!! Form::close() !!}


                    @if(isset($cliente))

                    {!! Form::open(array('route' => 'cajas.store','id'=>'frmCrearVenta')) !!} 
                    @permission('cajas.store')
                    <div class="input-group form-group col-md-12 @if($errors->has('cliente_id')) has-error @endif">
                        @php
                            $param_bloqueoXdoc=\App\Param::where('llave','bloqueo_caja_calif_asistenciasXDoc')->value('valor');
                            $excepcion_documentos=\App\Plantel::find($cliente->plantel_id);
                                
                                if($excepcion_documentos->bnd_excepcion_documentos==1){
                                    $param_bloqueoXdoc=0;
                                
                                }
                            $validaEntregaDocs3Meses=$cli_funciones->validaEntregaDocs3Meses($cliente->id);
                        @endphp
                        @if($param_bloqueoXdoc==1)
                        @if($cliente->bnd_doc_oblig_entregados==1 or $cliente->st_cliente_id==1 or $cliente->st_cliente_id==22 or $validaEntregaDocs3Meses)
                        <div class="input-group-btn">
                            <button type="submit" class="btn btn-warning" data-toggle="tooltip" title="Crear Venta" id="btnCrearVenta">
                                <i class='glyphicon glyphicon-plus-sign'></i>
                            </button>
                        </div>
                        @else
                            <span class="bg-red">Sin docs. entregados o fuera del plazo<span>
                        @endif
                        @else
                        <div class="input-group-btn">
                            <button type="submit" class="btn btn-warning" data-toggle="tooltip" title="Crear Venta" id="btnCrearVenta">
                                <i class='glyphicon glyphicon-plus-sign'></i>
                            </button>
                        </div>        
                        @endif
                        
                        {!! Form::select("forma_pago_id", $list["FormaPago"], null, array("class" => "form-control", "id" => "forma_pago_id1-field")) !!}
                        {!! Form::text("fecha", null, array("class" => "form-control fecha", "id" => "fecha-field", 'placeholder'=>'Fecha de Venta', 'style'=>"100%")) !!}
                        @permission('cajas.reactivarCliente')
                        <label>{!! Form::checkbox('bnd_sin_reactivacion', '1', false) !!} No Reactivar</label>
                        @endpermission
                        
                    </div>

                    @endpermission
                    {!! Form::hidden("cliente_id", $cliente->id, array("class" => "form-control", "id" => "cliente_id-field")) !!}
                    {!! Form::hidden("st_caja_id", 0, array("class" => "form-control", "id" => "st_caja_id_id-field")) !!}
                    {!! Form::close() !!}
                    <!--                    @if(isset($caja) and $caja->st_caja_id==0)
                                        <div class="form-group col-md-3">
                                            <div class='text-center'>
                                                
                                                {!! Form::open(array('route' => 'cajas.pagar')) !!}
                                                    <div class="form-group @if($errors->has('forma_pago_id')) has-error @endif">
                                                        <label for="forma_pago_id-field">Forma Pago</label>
                                                        {!! Form::select("forma_pago_id", $list["FormaPago"], null, array("class" => "form-control", "id" => "forma_pago_id-field")) !!}
                                                        {!! Form::text("referencia", $caja->referencia, array("class" => "form-control", "id" => "referencia_id-field", 'placeholder'=>'Referencia')) !!}
                                                        @if($errors->has("forma_pago_id"))
                                                        <span class="help-block">{{ $errors->first("forma_pago_id") }}</span>
                                                        @endif
                                                    </div>
                                                    {!! Form::hidden("caja", $caja->id, array("class" => "form-control", "id" => "caja_id-field")) !!}
                                                    <button type="submit" class="btn btn-success btn-sm "><i class="fa fa-money"></i> Pagar Venta</button>
                                                {!! Form::close() !!}
                                                
                                            </div>
                                        </div>
                                        @endif-->
                </div><!-- /.box-body -->
            </div>
        </div>
        <div class="col-md-8">
            <div class="box box-info">
                <div class="box-body">
                    @if(isset($caja))
                    
                    
                        @if($caja->st_caja_id==1 and ($cliente->st_cliente_id==4 or $cliente->st_cliente_id==22))
                        @permission('cajas.repetirActivarBs')
                        <div class="form-group col-md-4">
                            <div class='text-center'>
                                <a href="{{route('cajas.repetirActivarBs', array('cliente'=>$caja->cliente_id, 'caja'=>$caja->id))}}" class="btn btn-info btn-sm "><i class=""></i> R. Activar BS</a>
                            </div>
                        </div>
                        @endpermission
                        @endif
                        
                    <div class="form-group col-md-4">
                        <div class='text-center'>
                        @permission('cajas.eliminarRecargo')
                            @if(isset($caja) and $caja->pagos->count()==0)
                            <a href="{{route('cajas.eliminarRecargo', array('caja_id'=>$caja->id))}}" class="btn btn-info btn-sm "><i class=""></i> Eliminar Recargo</a>
                            @endif
                        @endpermission
                        </div>
                    </div>
                    @endif
                    @if(isset($caja))
                    <div class="form-group col-md-4">
                        <div class='text-center'>
                            @php
                                $referencia="";
                                $adeudo_pago_online=\App\AdeudoPagoOnLine::where('caja_id',$caja->id)
				                ->whereNotNull('peticion_multipago_id')
                                ->where('peticion_multipago_id','<>',0)
                                ->where('cliente_id',$caja->cliente_id)
				                ->where('caja_id',$caja->id)
                                ->first();

                                
                                if(!is_null($adeudo_pago_online) and $adeudo_pago_online->pago_id<>0){
                                    $referencia=$adeudo_pago_online->peticionMultipago->mp_reference;
                                }

                            @endphp
                            @permission('cajas.cancelar')
                            @if($referencia=="")
                                @if($caja->st_caja_id<>1 and $caja->st_caja_id<>2)
                                {!! Form::open(array('route' => 'cajas.cancelar','onsubmit'=> "if(confirm('¿Cancelar Caja? ¿Esta seguro?')) { return true } else {return false };")) !!}
                                {!! Form::hidden("caja", $caja->id, array("class" => "form-control", "id" => "caja_id-field")) !!}
                                <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-close"></i> Cancelar Venta</button>
                                {!! Form::close() !!}
                                @endif
                            @endif
                            @endpermission
                        </div>
                    </div>
                    <div class="form-group col-md-4">
                        <div class='text-center'>
                            @php
                                $indicadorPeticionenlinea=0;
                            @endphp
                            @permission('cajas.cancelarEnLinea')
                            @foreach($caja->pagos as $pago)
                                @if(isset($pago->peticionMultipago))
                                    @php
                                        $indicadorPeticionenlinea=1;
                                    @endphp
                                @endif
                            @endforeach
                            @if($caja->st_caja_id==0 and $indicadorPeticionenlinea==1))
                            <!--@@if($caja->st_caja_id<>1 and $caja->st_caja_id<>2)-->
                            {!! Form::open(array('route' => 'cajas.cancelarEnLinea','onsubmit'=> "if(confirm('¿Cancelar Proceso En Linea? ¿Esta seguro?')) { return true } else {return false };")) !!}
                            {!! Form::hidden("caja", $caja->id, array("class" => "form-control", "id" => "caja_id-field")) !!}
                            <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-close"></i> Cancelar En Linea</button>
                            {!! Form::close() !!}
                            <!--@@endif-->
                            @endif
                            @endpermission
                        </div>
                    </div>
                    @if($cliente->beca_bnd==-1)
                    <div class="form-group col-md-4">
                        <div class='text-center'>
                        
                            <a href="{{route('cajas.becaInscripcion', array('caja_id'=>$caja->id))}}" class="btn btn-warning btn-sm "><i class=""></i> Beca Inscripcion</a>
                        
                        </div>
                    </div>
                    <div class="form-group col-md-4">
                        <div class='text-center'>
                        
                            <a href="{{route('cajas.becaMensualidad', array('caja_id'=>$caja->id))}}" class="btn btn-warning btn-sm "><i class=""></i> Beca Mensualidad</a>
                        
                        </div>
                    </div>
                    @endif
                    @endif
                    @endif
                    
                    @if(isset($caja) and ($caja->st_caja_id==0 or $caja->st_caja_id==3))
                    @if(count($caja->cajaLns)==0)
                    <div class="form-group col-md-4">
                        <div class='text-center'>
                            <a href="#" class="add-modal btn btn-success btn-sm"><i class="glyphicon glyphicon-plus-sign"></i>Agregar Linea</a> 
                        </div>
                    </div>
                    @else
                    @permission('cajas.masDeUnaLinea')
                    <div class="form-group col-md-4">
                        <div class='text-center'>
                            <a href="#" class="add-modal btn btn-success btn-sm"><i class="glyphicon glyphicon-plus-sign"></i>Agregar Linea</a> 
                        </div>
                    </div>
                    @endpermission
                    @endif
                    
                    <div class="form-group col-md-4">
                        <div class='text-center'>
                            <a href="#" class="add-pago btn btn-success btn-sm" data-total_caja={{ $caja->total }}><i class="glyphicon glyphicon-plus-sign" ></i>Agregar Pago</a> 
                        </div>
                    </div>

                    @endif

                    @if(isset($caja) and ($caja->st_caja_id==0))
                    @permission('cajas.actualizarAdeudosPagos')
                    @foreach($caja->cajaLns as $ln)
                    <div class="form-group col-md-4">
                        <div class='text-center'>
                            <a href="{{ route('cajas.actualizarAdeudosPagos',array('adeudo'=>$ln->adeudo_id)) }}" class="btn btn-success btn-sm" >A. Montos Diferentes</a> 
                        </div>
                    </div>
                    @endforeach
                    @endpermission
                    @endif


                    @if(isset($caja))
                    @permission('cajas.aplicarRecargos')
                    <div class="form-group col-md-4">
                        <div class='text-center'>
                        <a href="{{ route('cajas.aplicarRecargos', array('caja'=>$caja->id)) }}" class="add-recargos btn btn-success btn-sm"><i class="glyphicon glyphicon-plus-sign"></i>Aplicar Recargos</a> 
                        </div>
                    </div>
                    @endpermission
                    @endif
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div>
    
        <div class="col-md-12">    
            <div class="box box-success">
                <div class="box-body no-padding">
                    <div class="box-header with-border editable_fecha">
                        @if(isset($caja))
                        <lable><strong>No. Ticket:</strong>{{$caja->consecutivo}}</lable>
                            <lable><strong>Fecha:</strong>{{$caja->fecha}}</lable>
                            <lable><strong>Estatus:</strong>{{$caja->stCaja->name}}</lable>
                            <lable><strong>F. Pago:</strong>{{$caja->formaPago->name}}</lable>
                            <lable><strong>No Reactivar:</strong>@if($caja->bnd_sin_reactivacion==1) SI @else NO @endif</lable>
                            <input class='fecha_editable form-control' value='{{$caja->fecha}}' data-id="{{$caja->id}}"></input>
                        <div class="box-tools pull-right">
                            <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                        </div><!-- /.box-tools -->
                        @endif
                    </div>
                    <div class="row col-md-12" id='loading3' style='display: none'>
                        <h3>Actualizando... Por Favor Espere.</h3>
                        <div class="progress progress-striped active page-progress-bar">
                            <div class="progress-bar" style="width: 100%;"></div>
                        </div>
                    </div>
                    @if(isset($caja))

                    <table class="table table-striped table-bordered table-hover" id="postTable" >
                        <thead>
                            <tr>
                                <th>Concepto</th>
                                <th>Monto</th>
                                <th>Desc.</th>
                                <th></th>
                            </tr>
                            {{ csrf_field() }}
                        </thead>
                        <tbody>
                        @php
                        /*$caja->load('cajaLns');
                        $caja->load('plantel');
                        $caja->load('pagos');
                        */
                        //dd($caja->cajaLns->toArray());
                        
                        //dd($lineas);
                        @endphp
                            @foreach($caja->cajaLns as $linea)
                            <tr>
                                @php
                                    //dd($linea);
                                    $valor=$linea->cajaConcepto->cve_multipagos;
                                    //$valores=$caja->plantel->conceptoMultipagos->pluck('id');
                                    $indicador=0;
                                    foreach($valores as $v){
                                        if($v==$valor){
                                            $indicador=1;
                                        }
                                    }
                                    
                                
                                    @endphp    
                                <td> 
                                {{$linea->cajaConcepto->name}} </td>
                                <td>{{ $linea->subtotal }}</td>
                                <td>{{ $linea->descuento }}</td>
                                <td>
                                    
                                    @if(isset($caja) and $caja->st_caja_id==0)
                                    @permission('cajaLns.destroy')
                                    @if($referencia=="")
                                    {!! Form::model($linea, array('route' => array('cajaLns.destroy', $linea->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('Ã‚Â¿Borrar? Ã‚Â¿Esta seguro?')) { return true } else {return false };")) !!}
                                    <button type="submit" class="btn btn-xs btn-danger" data-toggle="tooltip" title="Eliminar"><i class="glyphicon glyphicon-trash"></i></button>
                                    {!! Form::close() !!}
                                    @endif
                                    @endpermission
                                    @endif
                                </td>
                                
                            </tr>
                            @endforeach
                            <tr>
                                <td> Subtotal </td><td>{{ $caja->subtotal }}</td>
                            </tr>
                            <tr>
                                <td> Recargos </td><td>{{ $caja->recargo }}</td>
                            </tr>
                            <tr>
                                <td> Descuentos </td><td>{{ $caja->descuento }}</td>
                            </tr>
                            <tr>
                                <td> <strong>Total</strong> </td><td>{{ $caja->total }}</td>
                            </tr>
                        </tbody>
                    </table>
                    @endif
                </div><!-- /.box-body -->
            </div>
        </div>
        <div class="col-md-12">    
            <div class="box box-success">
                <div class="box-body no-padding">
                    <div class="box-header with-border">
                        @if(isset($caja))
                        <label>
                            <strong>Pagos</strong>
                        </label>
                        @php
                        $mensualidad=0;
                        foreach($caja->cajaLns as $linea){
                            if($linea->cajaConcepto->bnd_mensualidad==1){
                                $mensualidad=1;
                            }
                        }
                        @endphp
                        @if($caja->st_caja_id==1)
                        @if($mensualidad==1)
                        <a href="{{route('pagos.imprimirTodosFiscal', array('caja'=>$caja->id))}}" data-toggle="tooltip" title="Imprimir" class="btn btn-info btn-xs " target="_blank"><i class="fa fa-print"></i></a>
                        @else
                        <a href="{{route('pagos.imprimirTodosNoFiscal', array('caja'=>$caja->id))}}" data-toggle="tooltip" title="Imprimir" class="btn btn-info btn-xs " target="_blank"><i class="fa fa-print"></i></a>
                        @endif
                        @endif
                        
                        <div class="box-tools pull-right">
                            <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                        </div><!-- /.box-tools -->
                        @endif
                    </div>
                    <div class="row col-md-12" id='loading3' style='display: none'>
                        <h3>Actualizando... Por Favor Espere.</h3>
                        <div class="progress progress-striped active page-progress-bar">
                            <div class="progress-bar" style="width: 100%;"></div>
                        </div>
                    </div>
                    @if(isset($caja))

                    <table class="table table-striped table-bordered table-hover" id="postTable" >
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <!--<th>Ref.</th>
                                <th>C. Efectivo</th>-->
                                <!--<th>Consecutivo</th>-->
                                <th></th>
                            </tr>
                            {{ csrf_field() }}
                        </thead>
                        <tbody>
                            <?php $suma_pagos=0; ?>
                            @foreach($caja->pagos as $pago)
                            @if(is_null($pago->deleted_at))
                            <tr>
                                <td> 
                                    {{$pago->consecutivo}} <br/>
                                    @if($pago->bnd_pagado<>1)
                                    @permission('conciliacionOpenpay.peticionExistente')
                                    <button class="btn btn-xs btn-warning" id="btn_conciliar" data-pago_id="{{$pago->id}}">Conciliar</button>
                                    @endpermission
                                    @endif
                                </td>
                                <td><strong>Monto:</strong>{{ $pago->monto }} <br>
                                    <strong>Fecha:</strong> {{ $pago->fecha }} <br>
                                    @permission('ticket.fechaPago')
                                    <strong>Creado:</strong> {{ $pago->created_at }} <br>
                                    @endpermission
                                    <strong>Forma Pago:</strong> {{ $pago->formaPago->name }} <br>
                                    <strong>Folio y Serie:</strong> {{$pago->csc_simplificado}}<br>
                                    <strong>Referencia:</strong> {{ $pago->referencia }} <br>
                                    <strong>UUID:</strong> {{ $pago->uuid }} <br>
                                    @if($pago->cuenta_efectivo_id>0)
                                    <strong>C. Efectivo:</strong>{{ App\CuentasEfectivo::where('id', $pago->cuenta_efectivo_id)->value('name')}}
                                    @endif
                                    <br>
                                    <strong>Referencia EL:</strong>{{ optional($pago->peticionMultipago)->mp_reference }}<br>
                                    <strong>Referencia PC:</strong>{{ optional($pago->peticionPaycode)->rreference_number }}<br>
                                    <strong>Referencia Openpay:</strong>
                                    <table class="table table-striped table-bordered table-hover" >
                                        <thead><th>Order</th><th></th><th>Estatus</th> <th>Limite</th></thead>
                                    @foreach($pago->peticionOpenpays as $peticion)
                                    
                                    
                                        <tr>
                                            <td> {{ optional($peticion)->rorder_id }} </td>
                                            <td>
                                                @if(isset($caja) and $caja->st_caja_id==0)
                                                @permission('conciliacionOpenpay.peticionExistente')
                                                <a href="{{route('peticionOpenpays.peticionExistente', array('id'=>$peticion->rid,'limite'=>$peticion->fecha_limite))}}" class="btn btn-xs btn-info">Conciliar</a>
                                                @endpermission
                                                @endif
                                            </td>
                                            <td> {{ optional($peticion)->rstatus }} </td><td> {{$peticion->fecha_limite}} </td>
                                        </tr>
                                    
                                    @endforeach
                                    </table>
                                </td>

                                <!--<td>
                                </td>
                                <td></td>-->
                                <!--<td>{{ $pago->referencia }}</td>
                                <td>@if($pago->cuenta_efectivo_id<>0)
                                    {{ App\CuentasEfectivo::where('id', $pago->cuenta_efectivo_id)->value('name')}}
                                    @endif
                                </td>-->
                                <!--<td></td>-->
                                <td>
                                    
                                    
                                    @permission('cajas.eliminarPago')
                                    @if($pago->bnd_pagado==1)
                                    {!! Form::model($pago, array('route' => array('pagos.destroy', $pago->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? ¿Esta seguro?')) { return true } else {return false };")) !!}
                                        <button type="submit" class="btn btn-xs btn-danger" data-toggle="tooltip" title="Eliminar"><i class="glyphicon glyphicon-trash"></i> </button>
                                    {!! Form::close() !!}
                                    @endif
                                    @endpermission
                                    @php
                                    $mensualidad=0;
                                    foreach($caja->cajaLns as $linea){
                                        if($linea->cajaConcepto->bnd_mensualidad==1){
                                            $mensualidad=1;
                                        }
                                    }
                                    @endphp
                                    @if($caja->st_caja_id==1)
                                    @if($mensualidad==1)
                                    <!--<a href="{{route('pagos.imprimirFiscal', array('pago'=>$pago->id))}}" data-toggle="tooltip" title="Imprimir" class="btn btn-info btn-xs " target="_blank"><i class="fa fa-print"></i></a>-->
                                    @else
                                    <!--<a href="{{route('pagos.imprimirNoFiscal', array('pago'=>$pago->id))}}" data-toggle="tooltip" title="Imprimir" class="btn btn-info btn-xs " target="_blank"><i class="fa fa-print"></i></a>-->
                                    @endif
                                    @endif
                                </td>
                                
                                @if(optional($pago->peticionMultipago)->count()>0)
                                    
                                <tr>
                                <td><strong>Peticion Multipagos</strong></td>
                                    <td>
                                        @php
                                        
                                        $success=\App\SuccessMultipago::where('mp_order', $pago->peticionMultipago->mp_order)
                                        ->where('mp_reference', $pago->peticionMultipago->mp_reference)
                                        ->where('mp_amount', $pago->peticionMultipago->mp_amount)
                                        ->first();
                                        @endphp

                                        @if($pago->bnd_pagado==1) 
                                        <span class="">Pagado </span>
                                        @else 
                                        <span class=""> En proceso - {{  !is_null($success) ? $success->mp_responsemsg : ""}} <span>
                                        @endif
                                        
                                        
                                    </td> 
                                    <td>
                                        @if($pago->bnd_pagado<>1)  
                                        @permission('pagos.store')
                                        <button type="button" class="btn btn-success aRepetirPeticionEliminado" data-dismiss="modal" data-pago="{{$pago->id}}">
                                            <span class='glyphicon glyphicon-reload'></span> Solicitud ({{$pago->peticionMultipago->contador_peticiones}})
                                        </button>
                                        @endif
                                        @endif    
                                    </td>
                                </tr>
                                @endif
                            </tr>
                            @endif
                            <?php $suma_pagos=$suma_pagos+$pago->monto; ?>
                            @endforeach
                            <tr>
                                <td> <strong>Total</strong> </td><td>{{ $suma_pagos }}</td>
                            </tr>
                        </tbody>
                    </table>
                    @endif
                </div><!-- /.box-body -->
            </div>
        </div>
    </div>
    @if(isset($cliente))
    <?php $valores= collect(); $vfechas=collect();?>
    <div class="col-md-6" id="adeudos-lista">
        <div class="box box-danger">
            <div class="box-header">
                <a href="{{route('clientes.edit', $cliente->id)}}" class="btn btn-md btn-success" target="_blank">
                    
                        Adeudos-{{$cliente->nombre." ".$cliente->nombre2." ".$cliente->ape_paterno." ".$cliente->ape_materno}} - {{$cliente->stCliente->name}}
                        @if($cliente->beca_bnd==1)
                        - Becado
                        @endif

                    </a>
                    <a class="btn btn-md btn-default" href="#" id='estatusBs'><i class="glyphicon glyphicon-eye"></i> Bs-</a>
                    @permission('historiaClientes.create')
                    <a class="btn btn-md btn-warning" href="{{ route('historiaClientes.index',array('q[cliente_id_lt]'=>$cliente->id)) }}" target='_blank'><i class="glyphicon glyphicon-eye"></i> Eventos</a>
                    @endpermission

                    <a class="btn btn-md btn-info modal-incidencias" href="#" ><i class="glyphicon glyphicon-eye"></i> Incidencias</a>
            </div>
            <div class="box-body no-padding">
                
                <table class='table table-striped table-condensed' >

                    <tbody>

                        @foreach($combinaciones as $combinacion)
                        @if($combinacion->especialidad_id<>0 and $combinacion->nivel_id<>0 and $combinacion->grado_id<>0 and $combinacion->turno_id<>0)
                        <tr>
                            <td colspan='6'><strong>Grado:</strong>{{$combinacion->grado->name}}</td>
                            <td colspan='6'><strong>Becas Solicitadas:</strong>{{ $cliente->autorizacionBecas->count() }} </td>
                        </tr>
                        <tr>
                        <table id='conceptos_predefinidos' class='table table-striped table-condensed'>
                            <thead>
                                <tr>
                                    <th>
                                        <div class="procesar">
                                            @if(isset($caja) and count($caja->pagos)==0)
                                            <button class="procesarAdeudos btn btn-primary btn-xs" data-cliente_id="{{ $caja->cliente_id }}"
                                                                                                   data-caja="{{ $caja->id }}">
                                            <i class="glyphicon glyphicon-plus-sign"></i></button>    
                                            @endif
                                            
                                        </div>
                                        
                                    </th>
                                    <th>Concepto</th><th>ED</th><th>Monto</th> <th>Desc.</th> <th>Pagado</th><th>Borrar</th><th>Fecha</th><th>Ticket</th><th>Pag./Fact.</th><th>dias</th> 
                                </tr>
                            </thead>
                            <tbody>
                        <?php $regla_pago_seriado=0; 
                        $adeudos_lineas=App\Adeudo::where('combinacion_cliente_id', $combinacion->id)
                        ->orderBy('fecha_pago')
                        ->orderBy('id')
                        ->whereNull('deleted_at')
                        ->with('descuento')
                        ->with('caja')
                        ->with('cajaConcepto')
                        ->get();
                        ?>
                        @foreach($adeudos_lineas as $adeudo)
                        <?php
                        $dias = date_diff(date_create(), date_create($adeudo->fecha_pago));
                        //dd($dias);
                        $dia = $dias->format('%R%a') * -1;
                        
                        ?>
                        <tr class="
                            @if($dia>15)
                            bg-red
                            @elseif($dia<=15)
                            bg-green
                            @endif
                            ">
                            
                            <td>
                                @if($adeudo->pagado_bnd==0)
                                @if($adeudo->inicial_bnd==1)
                                    <?php 
                                    $regla_pago_seriado=0;
                                    ?>
                                    
                                @endif
                                
                                @if(isset($caja) and $adeudo->caja->consecutivo==0 and $regla_pago_seriado==0 and $caja->st_caja_id==0)
                                @php
                                $lns = App\CajaLn::where('caja_id',$caja->id)->whereNull('deleted_at')->count();
                                @endphp

                                {!! Form::open(array('route' => 'cajas.guardaAdeudoPredefinido','method' => 'post')) !!}
                                <input class="form-control" id="adeudo-field" name="adeudo" value="{{$adeudo->id}}" type="hidden">
                                <input class="form-control" id="cliente_id-field" name="cliente_id" value="{{$adeudo->cliente_id}}" type="hidden">
                                <input class="form-control" id="caja-field" name="caja" value="{{$caja->id}}" type="hidden">
<!--                                <button type="submit" class="btn btn-xs btn-info" data-toggle="tooltip" title="Agregar"><i class="glyphicon glyphicon-plus-sign"></i></button>-->
                                {!! Form::close() !!}
                                
                                @permission('cajas.inscripcion')
                                @if($adeudo->cajaConcepto->id==1 or 
                                $adeudo->cajaConcepto->id==23 or 
                                $adeudo->cajaConcepto->id==25)
                                @if($lns==0) <!--solo una linea en la caja    -->
                                    <input type="checkbox" class="adeudos_tomados" value="{{$adeudo->id}}" />
                                    @endif
                                @endif
                                @endpermission
                                @permission('cajas.no_inscripcion')
                                @if($lns==0) <!--solo una linea en la caja    -->
                                <input type="checkbox" class="adeudos_tomados" value="{{$adeudo->id}}" />
                                @endif
                                @endpermission
                                
                                @endif
                                @endif
                                @php
                                //$adeudo->load('descuento');
                                //$adeudo->load('caja');
                                @endphp
                            <td 
                                @permission('cajas.adeudo_descripcion')
                                @if($adeudo->pagado_bnd==0)
                                class='editarAdeudo' 
                                @endif        
                                @endpermission
                                
                                data-adeudo='{{$adeudo->id}}' 
                                data-caja_concepto='{{$adeudo->caja_concepto_id}}' 
                                data-fecha_pago='{{$adeudo->fecha_pago}}' 
                                data-monto='{{$adeudo->monto}}'
                                data-bnd_eximir_descuentos_beca='{{$adeudo->bnd_eximir_descuento_beca}}'
                                data-bnd_eximir_descuentos='{{$adeudo->bnd_eximir_descuentos}}'
                                data-bnd_eximir_descuentos_regla='{{$adeudo->bnd_eximir_descuento_regla}}'
                                data-comentario='{{$adeudo->comentario}}'
                                
                                data-porcentaje='{{optional($adeudo->descuento)->porcentaje}}'
                                data-justificacion='{{optional($adeudo->descuento)->justificacion}}'
                                data-autorizado_por='{{optional($adeudo->descuento)->autorizado_por}}'
                                data-autorizado_el='{{optional($adeudo->descuento)->autorizado_el}}'
                                
                                >
                                @if(isset($adeudo->comentario))
                                <button class="btn btn-box-tool" data-toggle="tooltip" rel="tooltip" title="{{$adeudo->comentario}}"><i class="fa fa-comments"></i></button>
                                @endif
                                {{$adeudo->cajaConcepto->name}} 
                                @permission('hadeudos.historia')    
                                <a class="btn btn-default btn-xs" href="{{ route('hadeudos.historia',array('adeudo'=>$adeudo->id)) }}" target="_blank">H.</a>
                                @endpermission
                            </td>
                            <td>
                                
                                @php
                                $eximir_descuento_beca=($adeudo->bnd_eximir_descuento_beca==1) ? "SI" : "NO";
                                $eximir_descuentos=($adeudo->bnd_eximir_descuentos==1) ? "SI" : "NO";
                                $eximir_descuento_regla=($adeudo->bnd_eximir_descuento_regla==1) ? "SI" : "NO";
                                @endphp
                                <button class="btn btn-box-tool" 
                                data-toggle="tooltip" 
                                rel="tooltip" 
                                title="Eximir Descuento Beca: {{$eximir_descuento_beca}} -    
                                Eximir Descuento Promocion: {{$eximir_descuentos}} -  
                                Eximir Descuento Regla: {{$eximir_descuento_regla}}">
                                <i class="fa fa-comments"></i>
                                </button>
                            </td>
                            <td class='editable'>
                                {{$adeudo->monto}}
                                <input class='monto_editable form-control' value='{{$adeudo->monto}}' data-id="{{$adeudo->id}}"></input>
                            </td>
                            
                            <td>{{optional($adeudo->descuento)->porcentaje}}</td>
                            <td>
                                <?php
                                
                                //$linea_caja= \App\CajaLn::where('adeudo_id',$adeudo->id)->whereNull('deleted_at')->first();    
                                $suma_pagos=0;
                                $contador_pagos=0;
                                $pagos=App\Pago::where('caja_id', $adeudo->caja_id)->get();
                                
                                $contador_pagos=0;
                                foreach($pagos as $pago){
                                    $contador_pagos++;
                                    $suma_pagos=$suma_pagos+$pago->monto;
                                }
                                
                                ?>
                                @if(isset($linea_caja) and !is_null($linea_caja))
                                {{$linea_caja->total}}
                                @endif
                                {{ $suma_pagos }}
                            </td>
                            <td>
                                @permission('adeudos.destroy')
                                    @if($adeudo->pagado_bnd<>1)
                                    {!! Form::model($adeudo, array('route' => array('adeudos.destroy', $adeudo->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? ¿Esta seguro?')) { return true } else {return false };")) !!}
                                        <button type="submit" class="btn btn-xs btn-danger" data-toggle="tooltip" title="Borrar Adeudo"><i class="glyphicon glyphicon-trash"></i> </button>
                                    {!! Form::close() !!}
                                    @endif
                                @endpermission
                            </td>
                            <td>{{$adeudo->fecha_pago}}</td>
                            
                            <td class="bg-gray">
                                @if($adeudo->caja->consecutivo==0)
                                {{$adeudo->caja->consecutivo}}
                                @else
                                <a href="#" onclick="abrirTicket({{$adeudo->caja->consecutivo}}, {{$adeudo->cliente_id}});" data-toggle="tooltip" title="Ir">{{$adeudo->caja->consecutivo}}</a>
                                @endif
                            </td>
                            
                            @if($adeudo->pagado_bnd==1) 
                                <td> 
                            @else 
                                <td class="bg-yellow"> 
                                <?php $regla_pago_seriado=1;?>
                            @endif
                                @if($adeudo->pagado_bnd==1) SI @else NO @endif
                                @if($adeudo->caja->consecutivo<>0)
                                @if($contador_pagos>1)
                                /Problema-Varios Pagos
                                @elseif(isset($pago) and is_null($pago->uuid)) 
                                / NO 
                                @elseif(isset($pago) and !is_null($pago->uuid))
                                / SI 
                                @endif   
                                @endif
                                 
                            </td>
                                
                            <td>{{$dia}}</td>
	
                        </tr>
        		
                        @endforeach
                        @endif
                        
                        @endforeach
                        </tr>
                        </tbody>
                        </table>
                        
                        <table id='conceptos_predefinidos' class='table table-striped table-condensed'>
                            <thead>
                                <tr>
                                    
                                    <th>Concepto</th><th>Fecha</th><th>Monto</th><th>Caja</th><th>Estatus</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    //dd($cajas->toArray());
                                @endphp
                                @foreach($cajas as $ln)
                                    
                                    <tr>
                                        
                                    <td> {{$ln->concepto}}</td> <td>{{$ln->fecha}}</td> <td>{{$ln->total}}</td><td>{{$ln->caja}}</td><td>{{$ln->estatus}}</td>
                                    </tr>
                                    
                                @endforeach
                                
                                
                            </tbody>
                        </table>
                    </tbody>
                </table>
            </div><!-- /.box-body -->
        </div>
    </div>
    @endif
</div>

<!--
Pantallas modales
Agregar nuevo registro
-->
<div id="modalIncidencias" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
<!--                <button type="button" class="close" data-dismiss="modal">X</button>-->
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body">
                <table class="table table-condensed table-striped">
                    <thead>
                        <th>Incidencia</th><th>Detalle</th><th>Fecha</th>
                    </thead>
                    <tbody>
			@if(isset($cliente))
                        @foreach($cliente->incidencesClientes as $incidencia)
                        <tr>
                            <td>{{ $incidencia->incidenceCliente->name }}</td><td>{{ $incidencia->detalle }}</td><td>{{ $incidencia->fecha }}</td>
                        </tr>
                        @endforeach
			@endif
                    </tbody>
                </table>    
                <div class="row"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-warning" data-dismiss="modal">
                        <span class='glyphicon glyphicon-remove'></span> Cerrar
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>




@if(isset($caja))
<div id="addModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
<!--                <button type="button" class="close" data-dismiss="modal">X</button>-->
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body">
                {!! Form::open(array('route' => 'cajaLns.store')) !!}
                <div class="form-group col-md-12 @if($errors->has('caja_concepto_id')) has-error @endif">
                    <label for="caja_concepto_id-field">Caja Concepto</label><br/>
                    {!! Form::select("caja_concepto_id", $list1["CajaConcepto"], null, array("class" => "form-control select_seguridad", "id" => "caja_concepto_id-crear", "style"=>"width: 100%")) !!}
                    <p class="errorCajaConcepto text-center alert alert-danger hidden"></p>
                </div>
                <div class="form-group col-md-12 @if($errors->has('monto_concepto')) has-error @endif">
                    <label for="monto_concepto-field">Monto(Dejar en 0 para tomar valor del concepto)</label>
                    {!! Form::text("monto_concepto", 0, array("class" => "form-control", "id" => "monto_concepto-crear", 'readonly'=>true)) !!}
                    @if($errors->has("monto_concepto"))
                     <span class="help-block">{{ $errors->first("monto_concepto") }}</span>
                    @endif
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


<div id="addPago" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                    
<!--                <button type="button" class="close" data-dismiss="modal">X</button>-->
                <h4 class="modal-title">Agregar Pago</h4>
            </div>
            <div class="modal-body">
                {!! Form::open(array('route' => 'cajaLns.store')) !!}
                    <div class="form-group col-md-6 @if($errors->has('monto')) has-error @endif">
                       <label for="monto-field">Monto</label>
                       {!! Form::hidden("caja_id", $caja->id, array("class" => "form-control", "id" => "caja_id-field")) !!}
                       {!! Form::text("monto", null, array("class" => "form-control", "id" => "monto-field")) !!}
                       <div id="msj_validacion"></div>
                       @if($errors->has("monto"))
                        <span class="help-block">{{ $errors->first("monto") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-6 @if($errors->has('fecha')) has-error @endif">
                       <label for="fecha-field">Fecha</label>
                       {!! Form::text("fecha", null, array("class" => "form-control fecha", "id" => "fecha_ln-field")) !!}
                       @if($errors->has("fecha"))
                        <span class="help-block">{{ $errors->first("fecha") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-6 @if($errors->has('forma_pago_id')) has-error @endif">
                       <label for="forma_pago_id-field">Forma Pago</label>
                       {!! Form::select("forma_pago_id", $list["FormaPago"], null, array("class" => "form-control", "id" => "forma_pago_id-field", 'disabled'=>true)) !!}
                       @if($errors->has("forma_pago_id"))
                        <span class="help-block">{{ $errors->first("forma_pago_id") }}</span>
                       @endif
                    </div>
                    <!--<div class="form-group col-md-3 @if($errors->has('bnd_referenciado')) has-error @endif">
                        <label for="bnd_referenciado-field">Pago Referenciado</label>
                        @{!! Form::checkbox("bnd_referenciado", 1, null, [ "id" => "bnd_referenciado-field", 'class'=>'minimal']) !!}
                        @if($errors->has("bnd_referenciado"))
                        <span class="help-block">{{ $errors->first("bnd_referenciado") }}</span>
                        @endif
                    </div>-->
                    <div class="form-group col-md-6 @if($errors->has('cuenta_efectivo_id')) has-error @endif">
                       <label for="cuenta_efectivo_id-field">Cuenta Efectivo</label>
                       {!! Form::select("cuenta_efectivo_id-field", App\CuentasEfectivo::pluck('name','id'), null, array("class" => "form-control", "id" => "cuenta_efectivo_id-field")) !!}
                       @if($errors->has("cuenta_efectivo_id"))
                        <span class="help-block">{{ $errors->first("cuenta_efectivo_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-6 @if($errors->has('referencia')) has-error @endif">
                       <label for="referencia-field">Referencia</label>
                       {!! Form::text("referencia", 0, array("class" => "form-control", "id" => "referencia-field")) !!}
                       @if($errors->has("referencia"))
                        <span class="help-block">{{ $errors->first("referencia") }}</span>
                       @endif
                    </div>
                    
                    <div class="form-group col-md-6 @if($errors->has('referencia')) has-error @endif">
                        <button type="button" class="btn btn-warning validarReferencia" id="validarReferencia">
                            <span id="" class='glyphicon glyphicon-check'></span> Validar
                        </button>
                        <div id='loadingValidar' style='display: none'><img src="{{ asset('images/ajax-loader.gif') }}" title="Enviando" /></div> 
                        <div id='resVal'></div>
                    </div>
                    
                {!! Form::close() !!}
                <div class="row"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" onclick="location.reload();" data-dismiss="modal">
                        <span id="" class='glyphicon glyphicon-loading'></span> Actualizar
                    </button>
                    <button type="button" class="btn btn-success addPagoB" id="AgregarPago" data-dismiss="modal">
                        <span id="" class='glyphicon glyphicon-check'></span> Crear
                    </button>
                    <button type="button" class="btn btn-warning" data-dismiss="modal" id='cerrarAgregarPago'>
                        <span class='glyphicon glyphicon-remove'></span> Cerrar
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="verPago" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                    
<!--                <button type="button" class="close" data-dismiss="modal">X</button>-->
                <h4 class="modal-title">Ver Pago</h4>
            </div>
            <div class="modal-body">
                {!! Form::open(array('route' => 'cajaLns.store')) !!}
                    <div class="form-group col-md-6 @if($errors->has('monto')) has-error @endif">
                       <label for="monto-field">Monto</label>
                       {!! Form::hidden("caja_id", $caja->id, array("class" => "form-control", "id" => "caja_id-field")) !!}
                       {!! Form::text("monto", null, array("class" => "form-control", "id" => "monto-field")) !!}
                       <div id="msj_validacion"></div>
                       @if($errors->has("monto"))
                        <span class="help-block">{{ $errors->first("monto") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-6 @if($errors->has('fecha')) has-error @endif">
                       <label for="fecha-field">Fecha</label>
                       {!! Form::text("fecha", null, array("class" => "form-control fecha", "id" => "fecha_ln-field")) !!}
                       @if($errors->has("fecha"))
                        <span class="help-block">{{ $errors->first("fecha") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-6 @if($errors->has('forma_pago_id')) has-error @endif">
                       <label for="forma_pago_id-field">Forma Pago</label>
                       {!! Form::select("forma_pago_id", $list["FormaPago"], null, array("class" => "form-control", "id" => "forma_pago_id-field", 'disabled'=>true)) !!}
                       @if($errors->has("forma_pago_id"))
                        <span class="help-block">{{ $errors->first("forma_pago_id") }}</span>
                       @endif
                    </div>
                    
                    <div class="form-group col-md-6 @if($errors->has('cuenta_efectivo_id')) has-error @endif">
                       <label for="cuenta_efectivo_id-field">Cuenta Efectivo</label>
                       {!! Form::select("cuenta_efectivo_id-field", App\CuentasEfectivo::pluck('name','id'), null, array("class" => "form-control", "id" => "cuenta_efectivo_id-field")) !!}
                       @if($errors->has("cuenta_efectivo_id"))
                        <span class="help-block">{{ $errors->first("cuenta_efectivo_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-6 @if($errors->has('referencia')) has-error @endif">
                       <label for="referencia-field">Referencia</label>
                       {!! Form::text("referencia", 0, array("class" => "form-control", "id" => "referencia-field")) !!}
                       @if($errors->has("referencia"))
                        <span class="help-block">{{ $errors->first("referencia") }}</span>
                       @endif
                    </div>
                    
                    <div class="form-group col-md-6 @if($errors->has('referencia')) has-error @endif">
                        <button type="button" class="btn btn-warning validarReferencia" id="validarReferencia">
                            <span id="" class='glyphicon glyphicon-check'></span> Validar
                        </button>
                        <div id='loadingValidar' style='display: none'><img src="{{ asset('images/ajax-loader.gif') }}" title="Enviando" /></div> 
                        <div id='resVal'></div>
                    </div>
                    
                {!! Form::close() !!}
                <div class="row"></div>
                <div class="modal-footer">
                    
                    <button type="button" class="btn btn-warning" data-dismiss="modal" id='cerrarAgregarPago'>
                        <span class='glyphicon glyphicon-remove'></span> Cerrar
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>


<div id="divActualizar" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                    
<!--                <button type="button" class="close" data-dismiss="modal">X</button>-->
                <h4 class="modal-title">Presione el boton para actualizar</h4>
            </div>
            <div class="modal-body">
                <div class="row"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" onclick="location.reload();" data-dismiss="modal">
                        <span id="" class='glyphicon glyphicon-loading'></span> Actualizar
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

@if(isset($cliente))
<div id="modalEditAdeudo" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
<!--                <button type="button" class="close" data-dismiss="modal">X</button>-->
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body">
                {!! Form::open(array('route' => 'adeudos.store')) !!}
                @permission('cajas.no_inscripcion')
                <div class="form-group col-md-6 @if($errors->has('caja_concepto_id')) has-error @endif">
                    <label for="caja_concepto_id-field">Caja Concepto</label><br/>
                    {!! Form::select("caja_concepto_id", $list1["CajaConcepto"], null, array("class" => "form-control select_seguridad", "id" => "caja_concepto_id-adeudo")) !!}
                    <p class="errorCajaConcepto text-center alert alert-danger hidden"></p>
                </div>
                <div class="form-group col-md-6 @if($errors->has('fecha_pago')) has-error @endif">
                    <label for="fecha_pago-field">Fecha Pago</label><br/>
                    {!! Form::text("fecha_pago", null, array("class" => "form-control fecha", "id" => "fecha_pago-adeudo")) !!}
                    <p class="errorCajaConcepto text-center alert alert-danger hidden"></p>
                </div>
                <div class="form-group col-md-6 @if($errors->has('monto')) has-error @endif">
                    <label for="monto-field">Monto</label><br/>
                    {!! Form::text("monto", null, array("class" => "form-control", "id" => "monto-adeudo")) !!}
                    <p class="errorCajaConcepto text-center alert alert-danger hidden"></p>
                </div>
                <div class="form-group col-md-3 @if($errors->has('bnd_eximir_descuentos_beca')) has-error @endif">
                    <label for="bnd_eximir_descuentos_beca-adeudo">Eximir Descuentos Beca</label>
                    {!! Form::checkbox("bnd_eximir_descuentos_beca", 1, null, [ "id" => "bnd_eximir_descuentos_beca-adeudo", 'class'=>'minimal']) !!}
                    @if($errors->has("bnd_eximir_descuentos_beca"))
                    <span class="help-block">{{ $errors->first("bnd_eximir_descuentos_beca") }}</span>
                    @endif
                </div>
                <div class="form-group col-md-3 @if($errors->has('bnd_eximir_descuentos')) has-error @endif">
                    <label for="bnd_eximir_descuentos-adeudo">Eximir Descuentos Promocion</label>
                    {!! Form::checkbox("bnd_eximir_descuentos", 1, null, [ "id" => "bnd_eximir_descuentos-adeudo", 'class'=>'minimal']) !!}
                    @if($errors->has("bnd_eximir_descuentos"))
                    <span class="help-block">{{ $errors->first("bnd_eximir_descuentos") }}</span>
                    @endif
                </div>
                <div class="form-group col-md-3 @if($errors->has('bnd_eximir_descuentos_regla')) has-error @endif">
                    <label for="bnd_eximir_descuentos_regla-adeudo">Eximir Descuentos Regla</label>
                    {!! Form::checkbox("bnd_eximir_descuentos_regla", 1, null, [ "id" => "bnd_eximir_descuentos_regla-adeudo", 'class'=>'minimal']) !!}
                    @if($errors->has("bnd_eximir_descuentos_regla"))
                    <span class="help-block">{{ $errors->first("bnd_eximir_descuentos_regla") }}</span>
                    @endif
                </div>
                <div class="form-group col-md-12 @if($errors->has('comentario')) has-error @endif">
                    <label for="comentario-field">Comentario</label><br/>
                    {!! Form::text("comentario", null, array("class" => "form-control", "id" => "comentario-adeudo")) !!}
                    <p class="errorCajaConcepto text-center alert alert-danger hidden"></p>
                </div>
                @endpermission
                <div class="row"></div>
                <hr>

                <div id="descuento_inscripcion" style='display: none'>
                <div class="form-group col-md-6 @if($errors->has('porcentaje')) has-error @endif">
                    <label for="porcentaje-field">Porcentaje (0.00)</label><br/>
                    {!! Form::number("porcentaje", null, array("class" => "form-control", "id" => "porcentaje-adeudo", 'placeholder'=>'Valor maximo 0.60', 'step'=>"0.05", 'min'=>"0", 'max'=>"0.60" )) !!}
                    <p class="errorCajaConcepto text-center alert alert-danger hidden"></p>
                </div>

                <div class="form-group col-md-6 @if($errors->has('autorizado_por')) has-error @endif">
                    <label for="autorizado_por-field">Autorizado por</label>
                        {!! Form::select("autorizado_por", $empleados, null, array("class" => "form-control select_seguridad", "id" => "autorizado_por-adeudo")) !!}
                    <p class="errorCajaConcepto text-center alert alert-danger hidden"></p>
                </div>

                <div class="form-group col-md-12 @if($errors->has('justificacion')) has-error @endif">
                    <label for="justificacion-field">Justificacion (0.00)</label><br/>
                    {!! Form::text("justificacion", null, array("class" => "form-control", "id" => "justificacion-adeudo")) !!}
                    <p class="errorCajaConcepto text-center alert alert-danger hidden"></p>
                </div>

                <div class="form-group col-md-6 @if($errors->has('autorizado_el')) has-error @endif">
                    <label for="autorizado_el-field">F. Autorizacion</label><br/>
                    {!! Form::text("autorizado_el", null, array("class" => "fecha form-control", "id" => "autorizado_el-adeudo")) !!}
                    <p class="errorCajaConcepto text-center alert alert-danger hidden"></p>
                </div>
                </div>

                {!! Form::close() !!}
                <div class="row"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success btnEditarAdeudo" id="btnEditarAdeudo" data-dismiss="modal">
                        <span id="" class='glyphicon glyphicon-check'></span> Guardar
                    </button>
                    
                    <button type="button" class="btn btn-warning" data-dismiss="modal">
                        <span class='glyphicon glyphicon-remove'></span> Cerrar
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="formulario_multipagos">
    <form method="post" id="frm_multipagos" action="about:blank" target='_blank'>
        <input type="hidden" name="mp_account" id="mp_account" value="">
        <input type="hidden" name="mp_product" id="mp_product" value="">
        <input type="hidden" name="mp_order" id="mp_order" value="">
        <input type="hidden" name="mp_reference" id="mp_reference" value="">
        <input type="hidden" name="mp_node" id="mp_node" value="">
        <input type="hidden" name="mp_concept" id="mp_concept" value="">
        <input type="hidden" name="mp_amount" id="mp_amount" value="">
        <input type="hidden" name="mp_customername" id="mp_customername" value="">
        <input type="hidden" name="mp_currency" id="mp_currency" value="">
        <input type="hidden" name="mp_signature" id="mp_signature" value="">
        <input type="hidden" name="mp_urlsuccess" id="mp_urlsuccess" value="">
        <input type="hidden" name="mp_urlfailure" id="mp_urlfailure" value="">
        <input type="hidden" name="mp_paymentmethod" id="mp_paymentmethod" value="">
    </form>
</div>


@endif

@endsection
@push('scripts')



<script>
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
        });    
        $('#tooltip').tooltip();
    
    
    $('.fecha').Zebra_DatePicker({
    days:['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'],
            months:['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
            readonly_element: false,
            lang_clear_date: 'Limpiar',
            show_select_today: 'Hoy',
    });
    var fullDate = new Date()

            //convert month to 2 digits
    //var twoDigitMonth = ((fullDate.getMonth().length + 1) === 1)? (fullDate.getMonth() + 1) : '0' + (fullDate.getMonth() + 1);
    var twoDigitMonth = (parseInt(fullDate.getMonth()+1) < 10) ? ('0'+ (fullDate.getMonth()+1)) : (fullDate.getMonth()+1);
    var twoDigitDay = (parseInt(fullDate.getDate()) < 10)?  '0' + (fullDate.getDate()) : (fullDate.getDate());
    //console.log(twoDigitDay);
    var currentDate = fullDate.getFullYear() + "-" + twoDigitMonth + "-" + twoDigitDay;
    $('#fecha-field').val(currentDate);
    
    $('.procesar').on('click', '.procesarAdeudos', function() {
        var cb = [];
            $.each($('.adeudos_tomados:checked'), function() {
            cb.push($(this).val()); 
        });
        //console.log(cb);
        $.ajax({
            type: 'POST',
            url: '{{route("cajas.guardaAdeudoPredefinido")}}',
            data: {
                '_token': $('input[name=_token]').val(),
                'cliente_id': $(this).data('cliente_id'),
                'caja': $(this).data('caja'),
                'adeudos_tomados': cb
            },
            beforeSend : function(){$("#loading3").show(); },
            complete : function(){$("#loading3").hide(); },
            success: function(data) {
                //location.reload();
                $('#form-buscarVenta').submit();
            },
        });
    });
    
    $(document).ready(function(){
        $('#forma_pago_id1-field').change(function(){
            if($(this).val()==1 || $(this).val()==6 || $(this).val()==9){
                $('#fecha-field').prop('disabled',true);
            }else{
                $('#fecha-field').prop('disabled',false);
            }
            
        }); 
        
         $('.monto_editable').hide();
         $('.fecha_editable').hide();
         
         @permission('adeudos.editMonto')
        $('.editable').dblclick(function(){
            @if(!isset($caja->id))
                captura=$(this).children("input");
                captura.show();
            @endif
            
        });
        @endpermission
        @permission('cajas.editFecha')
        
        @permission('cajas.editFecha')
        $('.editable_fecha').dblclick(function(){
            captura=$(this).children("input");
            captura.show();
        });
        @endpermission

        @if(isset($caja) and $caja->forma_pago_id<>1 and $caja->forma_pago_id<>6 and $caja->forma_pago_id<>9)
        $('.editable_fecha').dblclick(function(){
            captura=$(this).children("input");
            captura.show();
        });
        @endif
        @endpermission
        $('.monto_editable').on('keypress', function (e) {
         if(e.which === 13){
             captura=$(this);
           $.ajax({
                type: 'GET',
                        url: '{{route("adeudos.editMonto")}}',
                        data: {
                            'id': captura.attr('data-id'),
                            'monto': captura.val(),
                        },
                        dataType:"json",
                        //beforeSend : function(){$("#loading3").show(); },
                        //complete : function(){$("#loading3").hide(); },
                        success: function(data) {
                            location.reload(); 
                           
                        }
                }); 
            }
        });
        $('.fecha_editable').on('keypress', function (e) {
            
         if(e.which === 13){
             
             captura=$(this);
           $.ajax({
                type: 'GET',
                        url: '{{route("cajas.editFecha")}}',
                        data: {
                            'caja': captura.attr('data-id'),
                            'fecha': captura.val(),
                        },
                        dataType:"json",
                        //beforeSend : function(){$("#loading3").show(); },
                        //complete : function(){$("#loading3").hide(); },
                        success: function(data) {
                            $('#form-buscarVenta').submit(); 
                           
                        }
                }); 
            }
        });
        $('[data-toggle="tooltip"]').tooltip();
    });

    $(document).on('click', '.modal-incidencias', function() {
        $('.modal-title').text('Ver Incidencias');
        $('#modalIncidencias').modal('show');
    });

//crear registro
    $(document).on('click', '.add-modal', function() {
    
    $('.modal-title').text('Agregar Linea');
    //Limpiar valores
    @permission('caja.conceptosSinPlan')
        $('#caja_concepto_id-crear option[value="1"]').prop('disabled',true);
        $('#caja_concepto_id-crear option[value="4"]').prop('disabled',true);
        $('#caja_concepto_id-crear option[value="5"]').prop('disabled',true);
        $('#caja_concepto_id-crear option[value="6"]').prop('disabled',true);
        $('#caja_concepto_id-crear option[value="7"]').prop('disabled',true);
        $('#caja_concepto_id-crear option[value="8"]').prop('disabled',true);
        $('#caja_concepto_id-crear option[value="9"]').prop('disabled',true);
        $('#caja_concepto_id-crear option[value="10"]').prop('disabled',true);
        $('#caja_concepto_id-crear option[value="11"]').prop('disabled',true);
        $('#caja_concepto_id-crear option[value="12"]').prop('disabled',true);
        $('#caja_concepto_id-crear option[value="13"]').prop('disabled',true);
        $('#caja_concepto_id-crear option[value="14"]').prop('disabled',true);
        $('#caja_concepto_id-crear option[value="15"]').prop('disabled',true);
        $('#caja_concepto_id-crear option[value="16"]').prop('disabled',true);
        $('#caja_concepto_id-crear option[value="17"]').prop('disabled',true);
        $('#caja_concepto_id-crear option[value="21"]').prop('disabled',true);
        $('#caja_concepto_id-crear option[value="22"]').prop('disabled',true);
        $('#caja_concepto_id-crear option[value="23"]').prop('disabled',true);
        $('#caja_concepto_id-crear option[value="24"]').prop('disabled',true);
        $('#caja_concepto_id-crear option[value="25"]').prop('disabled',true);
        $('#caja_concepto_id-crear option[value="26"]').prop('disabled',true);
        $('#caja_concepto_id-crear').select2({
        width: 'resolve' // need to override the changed default
        });
    @endpermission
    $('#addModal').modal('show');
    //caja_concepto_id-crear


    });
    
    @if (isset($caja) and isset($cliente))
    $('.modal-footer').on('click', '.add', '#Agregar', function() {
    $.ajax({
    type: 'POST',
            url: '{{route("cajas.guardaAdeudo")}}',
            data: {
            '_token': $('input[name=_token]').val(),
                    'caja': {{$caja->id}},
                    'cliente': {{$cliente->id}},
                    'concepto': $('#caja_concepto_id-crear').val(),
                    'monto_concepto': $('#monto_concepto-crear').val()
            },
            beforeSend : function(){$("#loading3").show(); },
            complete : function(){$("#loading3").hide(); },
            success: function(data) {
            window.location.href = "{{ route('cajas.edit', $caja->id) }}";
            }
    });
    });
    @endif

    @php
        $monto_max_pago=0;
	if(isset($caja)){
        if(optional($caja->pagos)->count()>0){
            $monto_max_pago=$caja->total-$caja->pagos->sum('monto');
        }else{
            $monto_max_pago=$caja->total;
        }
	}

    @endphp
    
    $('#monto-field').keyup(function(){
    if(parseInt($(this).val()) > ({{$monto_max_pago + 100}})){
        $('#msj_validacion').html('Valor no puede ser mayor de '+ {{$monto_max_pago +100}});
        $(this).val('');
    }
    else if(parseInt($(this).val()) < 0)
    {
        $('#msj_validacion').html('Valor no puede ser menor que 0');
        $(this).val('');
    }
    else
    { $('#msj_validacion').html(''); }
    });


    @if(isset($caja))
    $(document).on('click', '.add-pago', function() {
        $('.modal-title').text('Agregar Pago');
        //Limpiar valores
        $('#addPago').modal({backdrop: 'static', keyboard: false});
        //$('#monto-field').val($(this).data('total_caja'));
        $('#monto-field').val({{$monto_max_pago}});
        $('#forma_pago_id-field').val({{$caja->forma_pago_id}}).change();
        $('#fecha_ln-field').val('{{$caja->fecha}}');

        @if($caja->forma_pago_id==1)
           $('#fecha_ln-field').prop('disabled', true);
        @else
           $('#fecha_ln-field').prop('disabled', false);
        @endif
        
        @if(isset($caja) )
            @if($caja->cajaLns->count()<>1 or $indicador==0 or ($caja->forma_pago_id<>3 and $caja->forma_pago_id<>4 and $caja->forma_pago_id<>6))
            
            $('#bnd_referenciado-field').prop('disabled', true);
            @endif
            
        @endif  
        
        $('#addPago').modal('show');
        
        $('#AgregarPago').prop('disabled',true);
        
        
        //Cargar cuentas de efectivo
        //Fin cargar cuentas de efectivo
    });
    @endif

    @if(isset($caja))
    $(document).on('click', '.ver-pago', function() {
    
    $('.modal-title').text('Ver Pago');
    //Limpiar valores
    $('#verPago').modal({backdrop: 'static', keyboard: false});
    //$('#monto-field').val($(this).data('total_caja'));
    $('#monto-field').val({{$monto_max_pago}});
    $('#forma_pago_id-field').val({{$caja->forma_pago_id}}).change();
    $('#fecha_ln-field').val('{{$caja->fecha}}');

    @if(isset($caja) )
        @if($caja->cajaLns->count()<>1 or $indicador==0 or ($caja->forma_pago_id<>3 and $caja->forma_pago_id<>4 and $caja->forma_pago_id<>6))
        
        $('#bnd_referenciado-field').prop('disabled', true);
        @endif
        
    @endif  
    
    $('#addPago').modal('show');
    
    $('#AgregarPago').prop('disabled',true);
    
    
    //Cargar cuentas de efectivo
    //Fin cargar cuentas de efectivo
});
    @endif
    
    
    @if (isset($caja) and isset($cliente))
        //$('.modal-footer1').on('click', 'addPagoB','#AgregarPago', function() {
        $('#AgregarPago').on('click', function() {    
            let referencia_check=0;
            if( $('#bnd_referenciado-field').prop('checked') ) {
                referencia_check=1
            }    
            //console.log(referencia_check);
        if(parseFloat($('#monto-field').val())>{{$monto_max_pago+100}} ){
            alert('Monto de pagos excede monto de caja total');
        }else{
            $.ajax({
                type: 'POST',
                url: '{{url("pagos/store")}}',
                data: {
                    '_token': $('input[name=_token]').val(),
                    'caja_id': {{$caja->id}},
                    'monto': $('#monto-field').val(),
                    'fecha': $('#fecha_ln-field').val(),
                    'forma_pago_id': $('#forma_pago_id-field option:selected').val(),
                    'referencia':$('#referencia-field').val(),
                    'cuenta_efectivo_id': $('#cuenta_efectivo_id-field').val(),
                    'bnd_referenciado':referencia_check
                },
                beforeSend : function(){
                    $("#loading3").show(); 
                    $('#AgregarPago').prop('disabled',true);
                    $('#cerrarAgregarPago').prop('disabled',true);
                },
                complete : function(){$("#loading3").hide(); },
                success: function(data) {
                    //if(referencia_check==0){
                        $('#form-buscarVenta').submit();
                    /*}else{
                        console.log(data.datos)
                        $("#mp_account").val(data.datos.mp_account);
                        $("#mp_product").val(data.datos.mp_product);
                        $("#mp_order").val(data.datos.mp_order);
                        $("#mp_reference").val(data.datos.mp_reference);
                        $("#mp_node").val(data.datos.mp_node);
                        $("#mp_concept").val(data.datos.mp_concept);
                        $("#mp_amount").val(data.datos.mp_amount);
                        $("#mp_customername").val(data.datos.mp_customername);
                        $("#mp_currency").val(data.datos.mp_currency);
                        $("#mp_order").val(data.datos.mp_order);
                        $("#mp_signature").val(data.datos.mp_signature);
                        $("#mp_urlsuccess").val(data.datos.mp_urlsuccess);
                        $("#mp_urlfailure").val(data.datos.mp_urlfailure);
                        $("#mp_paymentmethod").val(data.datos.mp_paymentmethod);
                        
                        $('#frm_multipagos').attr("action", data.datos.url_peticion);
                        $('#frm_multipagos').submit();
                    }*/
                    
                }
            });
            }    
        
        });

        $('.aRepetirPeticion').on('click', function() {    
            let pago=$(this).data('pago');

            $.ajax({
                type: 'GET',
                url: '{{url("pagos/repetirMultipagosSolicitud")}}',
                data: {
                    '_token': $('input[name=_token]').val(),
                    'pago': pago,
                },
                beforeSend : function(){
                    $("#loading3").show(); 
                    
                },
                complete : function(){$("#loading3").hide(); },
                success: function(data) {
                    
                        console.log(data.datos)
                        $("#mp_account").val(data.datos.mp_account);
                        $("#mp_product").val(data.datos.mp_product);
                        $("#mp_order").val(data.datos.mp_order);
                        $("#mp_reference").val(data.datos.mp_reference);
                        $("#mp_node").val(data.datos.mp_node);
                        $("#mp_concept").val(data.datos.mp_concept);
                        $("#mp_amount").val(data.datos.mp_amount);
                        $("#mp_customername").val(data.datos.mp_customername);
                        $("#mp_currency").val(data.datos.mp_currency);
                        $("#mp_order").val(data.datos.mp_order);
                        $("#mp_signature").val(data.datos.mp_signature);
                        $("#mp_urlsuccess").val(data.datos.mp_urlsuccess);
                        $("#mp_urlfailure").val(data.datos.mp_urlfailure);
                        $("#mp_paymentmethod").val(data.datos.mp_paymentmethod);

                        $('#frm_multipagos').attr("action", data.datos.url_peticion);
                        $('#frm_multipagos').submit();
                        $('#divActualizar').modal('show');
                        
                        
                        //$('#form-buscarVenta').submit();
                        
                }
            });
        });    
        
        
    @endif

    $('#forma_pago_id-field').change(function(){
        
        forma_pago=$(this).val();
       @if(isset($caja))
        $.ajax({
        type: 'GET',
                url: '{{route("cuentasEfectivos.getCuentasPlantelFormaPago")}}',
                data: {
                //'_token': $('input[name=_token]').val(),
                        'plantel': {{$caja->plantel_id}},
                        'forma_pago': forma_pago,

                },
                beforeSend : function(){$("#loading3").show(); },
                complete : function(){$("#loading3").hide(); },
                success: function(data) {
                //window.location.href = "{{route('cajas.edit', $caja->id)}}";
                //$example.select2("destroy");
                    $('#cuenta_efectivo_id-field').empty();

                    //$('#especialidad_id-field').empty();
                    //$('#cuentas_efectivo_id-field').append($('<option></option>').text('Seleccionar').val('0'));
                    //alert(data);

                    $.each(data, function(i) {  
                        //alert(data[i].name);
                        $('#cuenta_efectivo_id-field').append("<option "+data[i].selectec+" value=\""+data[i].id+"\">"+data[i].name+"<\/option>");
                        
                    });
                    console.log(forma_pago);
                    if(forma_pago==1){
                        $('#referencia-field').prop('readonly',true);
                    }else{
                        $('#referencia-field').prop('readonly',false);
                    }
                    //$('#cuenta_efectivo_id-field').change();
                }
        });
    
        @endif 
        
    });


    @if (isset($cliente))
    $.ajax({
    type: 'GET',
    url: '{{route("cajas.consultaStBs")}}',
    data: {
    'matricula': '{{ $cliente->matricula }}',
    },
    dataType:"json",
    beforeSend : function(){$("#loadingValidar").show(); },
    complete : function(){$("#loadingValidar").hide(); },
    success: function(data) {
        //console.log(data);
        if(data[0].Activation.IsActive){
            $('#estatusBs').text('BS-Activo');
        }else{
            $('#estatusBs').text('BS-Inactivo');
        }
    }
    });


    function abrirTicket(csc, cliente){
        
        $('#consecutivo-field').val(csc);
        $('#cliente_caja-field').val(cliente);
        //$('#plantel_id-field option:selected').val({{$cliente->plantel_id}});
        $('#form-buscarVenta').submit();
        
        //window.location.assign("/path");
    }
    @endif
    
    $(document).on('click', '.validarReferencia', function() {

        if(!$('#bnd_referenciado-field').prop('checked')){
            $.ajax({
            type: 'GET',
            url: '{{route("pagos.validarReferencia")}}',
            data: {
            '_token': $('input[name=_token]').val(),
                    'referencia': $('#referencia-field').val(),
                    'cuenta_efectivo_id': $('#cuenta_efectivo_id-field option:selected').val()
            },
            dataType:"json",
            beforeSend : function(){$("#loadingValidar").show(); },
            complete : function(){$("#loadingValidar").hide(); },
            success: function(data) {
                $('#resVal').html('')
                if(Object.keys(data).length==0){
                    $('#resVal').html('OK')
                }else{
                    $('#resVal').append('<table class="table table-condensed table-striped">');
                    $('#resVal').append('<tr><th>Plantel</th><th>Consecutivo</th><th>Ver</th></tr>');
                    $.each(data, function(i) {  
                    //alert(data[i].name);
                    //$('#cuenta_efectivo_id-field').append("<option "+data[i].selectec+" value=\""+data[i].id+"\">"+data[i].name+"<\/option>");
                    $('#resVal').append('<tr><td>'+data[i].cve_plantel+'</td><td>'+data[i].consecutivo+'</td><td><a href="'+'{{route("cajas.caja")}}'+"?plantel="+data[i].plantel_id+"&consecutivo="+data[i].consecutivo+'" target=_blank >Ver</a></td></tr>');
                });
                   $('#resVal').append('</table>');
                }
                
                monto=$('#monto-field').val().toString();
                fecha=$('#fecha_ln-field').val().toString();
                forma_pago_id=$('#forma_pago_id-field option:selected').val().valueOf();
                cuenta_efectivo_id=$('#cuenta_efectivo_id-field option:selected').val().valueOf();
                ref0=$('#referencia-field').val().toString();
                if(monto!='' & fecha!='' & forma_pago_id!=0 & ref0!=''){
                    $('#AgregarPago').prop('disabled',false);
                }
                
            }
            });    
        }else{
            monto=$('#monto-field').val().toString();
            fecha=$('#fecha_ln-field').val().toString();
            forma_pago_id=$('#forma_pago_id-field option:selected').val().valueOf();
            cuenta_efectivo_id=$('#cuenta_efectivo_id-field option:selected').val().valueOf();
            ref0=$('#referencia-field').val().toString();
            if(monto!='' & fecha!='' & forma_pago_id!=0 & ref0!=''){
                $('#AgregarPago').prop('disabled',false);
            }
        }

        
    
    
    });
    
    @if(isset($vplantel) and isset($vconsecutivo))
        $('#plantel_id-field option:selected').val({{$vplantel}}).change();    
        $('#consecutivo-field').val({{$vconsecutivo}}).change(); 
        //console.log({{$vconsecutivo}});       
        $('#form-buscarVenta').submit();
    @endif

    $(document).on('dblclick', '.editarAdeudo', function() {
    
    $('.modal-title').text('Editar Adeudo');
    //Limpiar valores
    $('#modalEditAdeudo').modal('show');
    $('#caja_concepto_id-adeudo').val($(this).data('caja_concepto')).change();
    $('#fecha_pago-adeudo').val($(this).data('fecha_pago'));
    $('#monto-adeudo').val($(this).data('monto'));
    
    if($(this).data('bnd_eximir_descuentos_beca')==1){
        $('#bnd_eximir_descuentos_beca-adeudo').prop('checked', true);
    }else{
        $('#bnd_eximir_descuentos_beca-adeudo').prop('checked', false);
    }
    if($(this).data('bnd_eximir_descuentos')==1){
        $('#bnd_eximir_descuentos-adeudo').prop('checked', true);
    }else{
        $('#bnd_eximir_descuentos-adeudo').prop('checked', false);
    }
    if($(this).data('bnd_eximir_descuentos_regla')==1){
        $('#bnd_eximir_descuentos_regla-adeudo').prop('checked', true);
    }else{
        $('#bnd_eximir_descuentos_regla-adeudo').prop('checked', false);
    }

    $('#comentario-adeudo').val($(this).data('comentario'));
    
    
    if($(this).data('caja_concepto')==1 ||
    $(this).data('caja_concepto')==22 || 
    $(this).data('caja_concepto')==23 || 
    $(this).data('caja_concepto')==25){
        $('#descuento_inscripcion').show();
        $('#porcentaje-adeudo').val($(this).data('porcentaje'));
        $('#autorizado_por-adeudo').val($(this).data('autorizado_por')).change();
        $('#justificacion-adeudo').val($(this).data('justificacion'));
        $('#autorizado_el-adeudo').val($(this).data('autorizado_el'));
    }else{
        $('#descuento_inscripcion').hide();
    }

    vadeudo=$(this).data('adeudo');
    });
    
    @if (isset($cliente))
    
    $('.modal-footer').on('click', '#btnEditarAdeudo', function() {
        if(parseFloat($('#porcentaje-adeudo').val())>0.60){
            alert('Descuento maximo permitido 0.60');
        }else{
            vurl='{{url("adeudos/update")}}'+'/'+vadeudo;  
            $vbnd_eximir_descuentos_beca=0;
            $vbnd_eximir_descuentos=0;
            $vbnd_eximir_descuentos_regla=0;
            if( $('#bnd_eximir_descuentos_beca-adeudo').prop('checked') ) {
                $vbnd_eximir_descuentos_beca=1;
            }else{
                $vbnd_eximir_descuentos_beca=0;    
            }
            if( $('#bnd_eximir_descuentos-adeudo').prop('checked') ) {
                $vbnd_eximir_descuentos=1;
            }else{
                $vbnd_eximir_descuentos=0;    
            }
            if( $('#bnd_eximir_descuentos_regla-adeudo').prop('checked') ) {
                $vbnd_eximir_descuentos_regla=1;
            }else{
                $vbnd_eximir_descuentos_regla=0;    
            }  
            $.ajax({
            type: 'POST',
                    url: vurl,
                    data: {
                        '_token': $('input[name=_token]').val(),
                        'caja_concepto_id': $('#caja_concepto_id-adeudo option:selected').val(),
                        'fecha_pago': $('#fecha_pago-adeudo').val(),
                        'monto': $('#monto-adeudo').val(),
                        'bnd_eximir_descuento_beca': $vbnd_eximir_descuentos_beca,
                        'bnd_eximir_descuentos': $vbnd_eximir_descuentos,
                        'bnd_eximir_descuento_regla': $vbnd_eximir_descuentos_regla,
                        'comentario':$('#comentario-adeudo').val(),
                        'porcentaje': $('#porcentaje-adeudo').val(),
                        'autorizado_por': $('#autorizado_por-adeudo option:selected').val(),
                        'justificacion': $('#justificacion-adeudo').val(),
                        'autorizado_el': $('#autorizado_el-adeudo').val(),
                        'adeudo_id':vadeudo
                    },
                    beforeSend : function(){$("#loading3").show(); },
                    complete : function(){$("#loading3").hide(); },
                    success: function(data) {
                        $('#frmBuscarCliente').submit();
                    }
            });        
        }
        
    });

    //$('#btn_conciliar').on('click', '#btnEditarAdeudo', function() {
    $(document).on('click', '#btn_conciliar', function(e) {
            $.ajax({
            type: 'GET',
                    url: "{{route('peticionOpenpays.peticionExistente')}}",
                    data: {
                        'pago_id': $(this).data('pago_id')
                    },
                    beforeSend : function(){$("#loading3").show(); },
                    complete : function(){$("#loading3").hide(); },
                    success: function(data) {
                        //location.reload();
                    }
            });        
        
        
    });

    
    
    @endif

    function crearCaja(){
    //$('#btnCrearVenta').click(function(e){
        //$('input.submitForm').read
        e.preventDefaul();
        alert($('#forma_pago_id1-field option:selected').val());
        if($('#forma_pago_id1-field option:selected').val()==0){
            alert('Seleccionar una Forma de Pago');
        }else{
            $('#btnCrearVenta').prop('disabled', true);
            $('#frmCrearVenta').submit();
        }

        
    }
    

</script>

@endpush
