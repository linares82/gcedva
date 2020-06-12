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

                    <div class="input-group form-group col-md-12 @if($errors->has('cliente_id')) has-error @endif">
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
                        
                        <div class="input-group-btn">
                            <button type="submit" class="btn btn-warning" data-toggle="tooltip" title="Crear Venta" id="btnCrearVenta">
                                <i class='glyphicon glyphicon-plus-sign'></i>
                            </button>
                        </div>
                        
                        {!! Form::select("forma_pago_id", $list["FormaPago"], null, array("class" => "form-control", "id" => "forma_pago_id1-field")) !!}
                        {!! Form::text("fecha", null, array("class" => "form-control fecha", "id" => "fecha-field", 'placeholder'=>'Fecha de Venta', 'style'=>"100%")) !!}
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
                    <div class="form-group col-md-4">
                        <div class='text-center'>
                        @permission('cajas.eliminarRecargo')
                            <a href="{{route('cajas.eliminarRecargo', array('caja_id'=>$caja->id))}}" class="btn btn-info btn-sm "><i class=""></i> Eliminar Recargo</a>
                        @endpermission
                        </div>
                    </div>
                    @endif
                    @if(isset($caja))
                    <div class="form-group col-md-4">
                        <div class='text-center'>
                            @permission('cajas.cancelar')
                            @if($caja->st_caja_id<>1 and $caja->st_caja_id<>2)
                            {!! Form::open(array('route' => 'cajas.cancelar','onsubmit'=> "if(confirm('¿Cancelar Caja? ¿Esta seguro?')) { return true } else {return false };")) !!}
                            {!! Form::hidden("caja", $caja->id, array("class" => "form-control", "id" => "caja_id-field")) !!}
                            <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-close"></i> Cancelar Venta</button>
                            {!! Form::close() !!}
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
                    <div class="form-group col-md-4">
                        <div class='text-center'>
                            <a href="#" class="add-modal btn btn-success btn-sm"><i class="glyphicon glyphicon-plus-sign"></i>Agregar Linea</a> 
                        </div>
                    </div>
                    
                    <div class="form-group col-md-4">
                        <div class='text-center'>
                            <a href="#" class="add-pago btn btn-success btn-sm" data-total_caja={{ $caja->total }}><i class="glyphicon glyphicon-plus-sign" ></i>Agregar Pago</a> 
                        </div>
                    </div>
                    
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
                            @foreach($caja->cajaLns as $linea)
                            <tr>
                                <td> {{$linea->cajaConcepto->name}} </td><td>{{ $linea->subtotal }}</td><td>{{ $linea->descuento }}</td>
                                <td>
                                    @if(isset($caja) and $caja->st_caja_id==0)
                                    @permission('cajaLns.destroy')
                                    {!! Form::model($linea, array('route' => array('cajaLns.destroy', $linea->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('Â¿Borrar? Â¿Esta seguro?')) { return true } else {return false };")) !!}
                                    <button type="submit" class="btn btn-xs btn-danger" data-toggle="tooltip" title="Eliminar"><i class="glyphicon glyphicon-trash"></i></button>
                                    {!! Form::close() !!}
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
                        
                        <a href="{{route('pagos.imprimirTodos', array('caja'=>$caja->id))}}" data-toggle="tooltip" title="Imprimir" class="btn btn-info btn-xs " target="_blank"><i class="fa fa-print"></i>Imprimir Todo</a>
                        
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
                                <th>Monto</th>
                                <th>Fecha</th>
                                <th>Forma Pago</th>
                                <th>Ref.</th>
                                <th>C. Efectivo</th>
                                <th></th>
                            </tr>
                            {{ csrf_field() }}
                        </thead>
                        <tbody>
                            <?php $suma_pagos=0; ?>
                            @foreach($caja->pagos as $pago)
                            @if(is_null($pago->deleted_at))
                            <tr>
                                <td> {{$pago->consecutivo}} </td>
                                <td>{{ $pago->monto }}</td>
                                <td>{{ $pago->fecha }}</td>
                                <td>{{ $pago->formaPago->name }}</td><td>{{ $pago->referencia }}</td>
                                <td>@if($pago->cuenta_efectivo_id<>0)
                                    {{ App\CuentasEfectivo::where('id', $pago->cuenta_efectivo_id)->value('name')}}
                                    @endif
                                </td>
                                <td>
                                    @permission('cajas.eliminarPago')
                                    {!! Form::model($pago, array('route' => array('pagos.destroy', $pago->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('Â¿Borrar? Â¿Esta seguro?')) { return true } else {return false };")) !!}
                                        <button type="submit" class="btn btn-xs btn-danger" data-toggle="tooltip" title="Eliminar"><i class="glyphicon glyphicon-trash"></i> </button>
                                    {!! Form::close() !!}
                                    @endpermission
                                    <a href="{{route('pagos.imprimir', array('pago'=>$pago->id))}}" data-toggle="tooltip" title="Imprimir" class="btn btn-info btn-xs " target="_blank"><i class="fa fa-print"></i></a>
                                </td>
                                
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
                                            @if(isset($caja))
                                            <button class="procesarAdeudos btn btn-primary btn-xs" data-cliente_id="{{ $caja->cliente_id }}"
                                                                                                   data-caja="{{ $caja->id }}">
                                            <i class="glyphicon glyphicon-plus-sign"></i></button>    
                                            @endif
                                        </div>
                                        
                                    </th>
                                    <th>Concepto</th><th>Monto</th> <th>Desc.</th> <th>Pagado</th><th>Borrar</th><th>Fecha</th><th>Ticket</th><th>Pagado</th><th>dias</th> 
                                </tr>
                            </thead>
                            <tbody>
                        <?php $regla_pago_seriado=0; ?>
                        @foreach($combinacion->adeudos as $adeudo)
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
                                {!! Form::open(array('route' => 'cajas.guardaAdeudoPredefinido','method' => 'post')) !!}
                                <input class="form-control" id="adeudo-field" name="adeudo" value="{{$adeudo->id}}" type="hidden">
                                <input class="form-control" id="cliente_id-field" name="cliente_id" value="{{$adeudo->cliente_id}}" type="hidden">
                                <input class="form-control" id="caja-field" name="caja" value="{{$caja->id}}" type="hidden">
<!--                                <button type="submit" class="btn btn-xs btn-info" data-toggle="tooltip" title="Agregar"><i class="glyphicon glyphicon-plus-sign"></i></button>-->
                                {!! Form::close() !!}
                                
                                @permission('cajas.inscripcion')
                                @if($adeudo->cajaConcepto->id==1 or $adeudo->cajaConcepto->id==23)
                                    <input type="checkbox" class="adeudos_tomados" value="{{$adeudo->id}}" />
                                @endif
                                @endpermission
                                @permission('cajas.no_inscripcion')
                                
                                <input type="checkbox" class="adeudos_tomados" value="{{$adeudo->id}}" />
                                
                                @endpermission
                                @endif
                                @endif
                                @php
                                $adeudo->load('descuento');
                                @endphp
                            <td 
                                @if($adeudo->pagado_bnd==0)
                                class='editarAdeudo' 
                                @endif
                                data-adeudo='{{$adeudo->id}}' 
                                data-caja_concepto='{{$adeudo->caja_concepto_id}}' 
                                data-fecha_pago='{{$adeudo->fecha_pago}}' 
                                data-monto='{{$adeudo->monto}}'
                                
                                data-porcentaje='{{optional($adeudo->descuento)->porcentaje}}'
                                data-justificacion='{{optional($adeudo->descuento)->justificacion}}'
                                data-autorizado_por='{{optional($adeudo->descuento)->autorizado_por}}'
                                data-autorizado_el='{{optional($adeudo->descuento)->autorizado_el}}'
                                
                                >{{$adeudo->cajaConcepto->name}}</td>
                            <td class='editable'>
                                {{$adeudo->monto}}
                                <input class='monto_editable form-control' value='{{$adeudo->monto}}' data-id="{{$adeudo->id}}"></input>
                            </td>
                            <td>{{optional($adeudo->descuento)->porcentaje}}</td>
                            <td>
                                <?php
                                
                                $linea_caja= \App\CajaLn::where('adeudo_id',$adeudo->id)->whereNull('deleted_at')->first();    
                                ?>
                                @if(!is_null($linea_caja))
                                {{$linea_caja->total}}
                                @endif
                            </td>
                            <td>
                                @permission('adeudos.destroy')
                                    {!! Form::model($adeudo, array('route' => array('adeudos.destroy', $adeudo->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('Â¿Borrar? Â¿Esta seguro?')) { return true } else {return false };")) !!}
                                        <button type="submit" class="btn btn-xs btn-danger" data-toggle="tooltip" title="Borrar Adeudo"><i class="glyphicon glyphicon-trash"></i> </button>
                                    {!! Form::close() !!}
                                @endpermission
                            </td>
                            <td>{{$adeudo->fecha_pago}}</td>
                            
                            <td class="bg-gray">
                                @if($adeudo->caja->consecutivo==0)
                                {{$adeudo->caja->consecutivo}}
                                @else
                                <a href="#" onclick="abrirTicket({{$adeudo->caja->consecutivo}});" data-toggle="tooltip" title="Ir">{{$adeudo->caja->consecutivo}}</a>
                                @endif
                            </td>
                            @if($adeudo->pagado_bnd==1) 
                                <td> 
                            @else 
                                <td class="bg-yellow"> 
                                <?php $regla_pago_seriado=1;?>
                            @endif
                                @if($adeudo->pagado_bnd==1) SI @else NO @endif</td>
                            <td>{{$dia}}</td>
	
                        </tr>
        		<?php
                        
                        foreach($combinacion->adeudos as $adeudo){
                            //if($adeudo->caja_concepto_id==$ln->caja_concepto_id){
                                $valores->push($adeudo->caja_concepto_id);
                                $vfechas->push(optional($adeudo->caja)->fecha);
                            //}
                        }
                        ?>                
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
                                    //dd($vfechas);
                                @endphp
                                @foreach($cajas as $ln)
                                    @if(isset($valores))
                                    @if(!is_int($valores->search($ln->concepto_id)) or !is_int($vfechas->search($ln->fecha)))
                                    <tr>
                                        
                                    <td> {{$ln->concepto}}</td> <td>{{$ln->fecha}}</td> <td>{{$ln->total}}</td><td>{{$ln->caja}}</td><td>{{$ln->estatus}}</td>
                                    </tr>
                                    @endif
                                    @endif
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
                    {!! Form::select("caja_concepto_id", $list1["CajaConcepto"], null, array("class" => "form-control select_seguridad", "id" => "caja_concepto_id-crear")) !!}
                    <p class="errorCajaConcepto text-center alert alert-danger hidden"></p>
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
                @permission('cajas.no_incripcion')
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
@endif

@endsection
@push('scripts')



<script>
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
        });    

    
    
    $('.fecha').Zebra_DatePicker({
    days:['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'],
            months:['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
            readonly_element: false,
            lang_clear_date: 'Limpiar',
            show_select_today: 'Hoy',
    });
    var fullDate = new Date()

            //convert month to 2 digits
            var twoDigitMonth = ((fullDate.getMonth().length + 1) === 1)? (fullDate.getMonth() + 1) : '0' + (fullDate.getMonth() + 1);
    var twoDigitDay = ((fullDate.getDate().length) === 1)? (fullDate.getDate()) : '0' + (fullDate.getDate());
    //console.log(twoDigitDay);
    var currentDate = fullDate.getFullYear() + "/" + twoDigitMonth + "/" + twoDigitDay;
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
            if($(this).val()==1 || $(this).val()==6){
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
        
        @if($caja->forma_pago_id<>1 and $caja->forma_pago_id<>6)
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
//crear registro
    $(document).on('click', '.add-modal', function() {
    
    $('.modal-title').text('Agregar Linea');
    //Limpiar valores
    $('#addModal').modal('show');
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
                    'concepto': $('#caja_concepto_id-crear').val()
            },
            beforeSend : function(){$("#loading3").show(); },
            complete : function(){$("#loading3").hide(); },
            success: function(data) {
            window.location.href = "{{route('cajas.edit', $caja->id)}}";
            }
    });
    });
    @endif

    @php
        $monto_max_pago=0;
        if(optional($caja->pagos)->count()>0){
            $monto_max_pago=$caja->total-$caja->pagos->sum(monto);
        }else{
            $monto_max_pago=$caja->total;
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


    $(document).on('click', '.add-pago', function() {
    
    $('.modal-title').text('Agregar Pago');
    //Limpiar valores
    $('#addPago').modal({backdrop: 'static', keyboard: false});
    //$('#monto-field').val($(this).data('total_caja'));
    $('#monto-field').val({{$monto_max_pago}});
    $('#forma_pago_id-field').val({{$caja->forma_pago_id}}).change();
    $('#fecha_ln-field').val('{{$caja->fecha}}');
    $('#addPago').modal('show');
    
    $('#AgregarPago').prop('disabled',true);
    
    //Cargar cuentas de efectivo
    //Fin cargar cuentas de efectivo
    });
    
    
    
    @if (isset($caja) and isset($cliente))
        //$('.modal-footer1').on('click', 'addPagoB','#AgregarPago', function() {
        $('#AgregarPago').on('click', function() {    
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
                },
                beforeSend : function(){
                    $("#loading3").show(); 
                    $('#AgregarPago').prop('disabled',true);
                    $('#cerrarAgregarPago').prop('disabled',true);
                },
                complete : function(){$("#loading3").hide(); },
                success: function(data) {
                    //location.reload(); 
                    $('#form-buscarVenta').submit();
                }
            });
            }    
        
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
    function abrirTicket(csc){
        
        $('#consecutivo-field').val(csc);
        $('#plantel_id-field option:selected').val({{$cliente->plantel_id}});
        $('#form-buscarVenta').submit();
    }
    @endif
    
    $(document).on('click', '.validarReferencia', function() {
    
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
    
    if($(this).data('caja_concepto')==1 || $(this).data('caja_concepto')==23){
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
            $.ajax({
            type: 'POST',
                    url: vurl,
                    data: {
                        '_token': $('input[name=_token]').val(),
                        'caja_concepto_id': $('#caja_concepto_id-adeudo option:selected').val(),
                        'fecha_pago': $('#fecha_pago-adeudo').val(),
                        'monto': $('#monto-adeudo').val(),
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
