@extends('plantillas.admin_template')

@include('conciliacionMultipagos._common')

@section('header')

<ol class="breadcrumb">
	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
    <li><a href="{{ route('conciliacionMultipagos.index') }}">@yield('conciliacionMultipagosAppTitle')</a></li>
    <li class="active">{{ $conciliacionMultipago->name }}</li>
</ol>

<div class="page-header">
        <h1>@yield('conciliacionMultipagosAppTitle') / Mostrar {{$conciliacionMultipago->id}}

            {!! Form::model($conciliacionMultipago, array('route' => array('conciliacionMultipagos.destroy', $conciliacionMultipago->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('Â¿Borrar? Estas seguro?')) { return true } else {return false };")) !!}
                <div class="btn-group pull-right" role="group" aria-label="...">
                    @permission('conciliacionMultipago.edit')
                    <a class="btn btn-warning btn-group" role="group" href="{{ route('conciliacionMultipagos.edit', $conciliacionMultipago->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                    @endpermission
                    @permission('conciliacionMultipago.destroy')
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
                <div class="form-group col-sm-3">
                    <label for="nome">ID</label>
                    <p class="form-control-static">{{$conciliacionMultipago->id}}</p>
                </div>
                <div class="form-group col-sm-3">
                     <label for="fecha_carga">FECHA CARGA</label>
                     <p class="form-control-static">{{$conciliacionMultipago->fecha_carga}}</p>
                </div>
                    <div class="form-group col-sm-6">
                     <label for="archivo">ARCHIVO</label>
                     <p class="form-control-static">{{$conciliacionMultipago->archivo}}</p>
                </div>
                    <div class="form-group col-sm-3">
                     <label for="registros">REGISTROS</label>
                     <p class="form-control-static">{{$conciliacionMultipago->registros}}</p>
                </div>
                    <div class="form-group col-sm-3">
                     <label for="contador_ejecucion">CONTADOR EJECUCION</label>
                     <p class="form-control-static">{{$conciliacionMultipago->contador_ejecucion}}</p>
                </div>
                <div class="form-group col-sm-3">
                    <label for="contador_ejecucion">Cuenta</label>
                    <p class="form-control-static">{{optional($conciliacionMultipago->cuentaP)->name}}</p>
               </div>
               <div class="form-group col-sm-3">
                    <label for="fec_inicio">F. Inicio</label>
                    <p class="form-control-static">{{$conciliacionMultipago->fec_inicio}}</p>
                </div>
                <div class="form-group col-sm-3">
                    <label for="fec_fin">F. Fin</label>
                    <p class="form-control-static">{{$conciliacionMultipago->fec_fin}}</p>
                </div>
                    <div class="form-group col-sm-3">
                     <label for="usu_alta_id">ALTA</label>
                     <p class="form-control-static">{{$conciliacionMultipago->usu_alta->name}}</p>
                </div>
                    <div class="form-group col-sm-3">
                     <label for="usu_mod_id">U. MODIFICACION</label>
                     <p class="form-control-static">{{$conciliacionMultipago->usu_mod->name}}</p>
                </div>
            </form>
            <div class="row"></div>

            <div class="box">
                <div class="box-body">
                <div class="table-responsive">
                    <h3>Inconsistencias</h3>
                    <table class="table table-bordered table-striped dataTable" id="dtHorizontalExample">
                        <thead>
                            <th>Referencia</th> <th>Orden</th><th>Conciliacion Importe</th><th>Peticion Monto</th><th>Caja</th>
                        </thead>
                        <tbody>
                            @foreach($registrosMontoDiferente as $r)
                            <tr>
                                <td>{{ $r['referencia'] }}</td>
                                <td>{{ $r['orden'] }}</td>
                                <td>
                                    <span class="label label-success">
                                    {{ $r['conciliacion_importe'] }}
                                    </span>
                                </td>
                                <td>
                                    <span class="label label-danger">
                                    {{ $r['peticion_monto'] }}
                                    </span>    
                                </td>
                                <td>
                                    <a href="{{ route('cajas.caja', array('plantel'=>$r['caja_plantel'], 'consecutivo'=>$r['caja_consecutivo'])) }}" target="_blank">
                                        {{ $r['caja_consecutivo'] }}
                                    </a>                                    
                                </td>
                                <td>{{ $r['msj'] }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
    
                </div>
                </div>
    
            </div>


            <div class="box">
                <div class="box-body">
                <div class="table-responsive">
                    <h3>Conciliacion</h3>
                    <table class="table table-bordered table-striped dataTable" id="dtHorizontalExample">
                        <thead>
                            <th>Caja afectada</th><th>Plantel Afectado</th>
                            <th>Fecha Pago</th><th>Razón Social</th><th>Unidad Negocio</th><th>Categoria Cobranza</th>
                            <th>Tipo Pago</th><th>Referencia</th><th>No. Orden</th><th>No. Aprobación</th>
                            <th>Id. Venta</th><th>Referencia Medio Pago</th><th>Importe</th><th>Comisión</th>
                            <th>Iva Comisión</th><th>Fecha Dispersión</th><th>Periodo Financiamiento</th>
                            <th>Moneda</th><th>Banco Emisor</th><th>Nombre Pagador</th><th>MAil</th><th>Tel.</th>
                            
                        </thead>
                        <tbody>
                            @foreach($conciliacionMultipago->conciliacionMultiDetalles as $detalle)
                            @php
                             $peticionMultipago=App\PeticionMultipago::where('peticion_multipagos.id',$detalle->peticion_multipago_id)
                             ->join('pagos as p','p.id','=','peticion_multipagos.pago_id')
                             ->join('cajas as c','c.id','=','p.caja_id')
                             ->whereNull('p.deleted_at')
                             ->whereNull('c.deleted_at')
                             ->first();
                             if(!is_null($peticionMultipago)){
                                $consecutivo=$detalle->peticionMultipago->pago->caja->consecutivo;
                                $plantel_id=$detalle->peticionMultipago->pago->caja->plantel->id;
                                $plantel_razon=$detalle->peticionMultipago->pago->caja->plantel->razon;
                             }else{
                                $consecutivo="";
                                $plantel_id="";
                                $plantel_razon="";
                             }
                             
                            @endphp
                            <tr>
                                <td>
                                    @if($consecutivo<>"")
                                    <a class="label label-success" href="{{ route('cajas.caja', array('plantel'=>$plantel_id, 'consecutivo'=>$consecutivo)) }}" target="_blank">
                                        {{ $consecutivo }}
                                    </a>                  
                                    @endif                  
                                </td>
                                <td>{{ $plantel_razon }}</td>
                                <td>{{ $detalle->fecha_pago }}</td><td>{{ $detalle->razon_social }}</td><td>{{ $detalle->mp_node }}</td>
                                <td>{{ $detalle->mp_concept }}</td><td>{{ $detalle->mp_paymentmethod }}</td><td>{{ $detalle->mp_reference }}</td>
                                <td>{{ $detalle->mp_order }}</td><td>{{ $detalle->no_aprobacion }}</td><td>{{ $detalle->identificador_venta }}</td>
                                <td>{{ $detalle->ref_medio_pago }}</td><td>{{ $detalle->importe }}</td><td>{{ $detalle->comision }}</td>
                                <td>{{ $detalle->iva_comision }}</td><td>{{ $detalle->fecha_dispersion }}</td><td>{{ $detalle->periodo_financiamiento }}</td>
                                <td>{{ $detalle->moneda }}</td><td>{{ $detalle->banco_emisor }}</td><td>{{ $detalle->mp_customername }}</td>
                                <td>{{ $detalle->mail }}</td><td>{{ $detalle->tel_customername }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
    
                </div>
                </div>
    
            </div>
            

            <a class="btn btn-link" href="{{ route('conciliacionMultipagos.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>

        </div>
    </div>

@endsection

@push('scripts')
<script type="text/javascript">
</script>
@endpush