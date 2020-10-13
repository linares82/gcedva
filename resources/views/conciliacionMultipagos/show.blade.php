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

            {!! Form::model($conciliacionMultipago, array('route' => array('conciliacionMultipagos.destroy', $conciliacionMultipago->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? Estas seguro?')) { return true } else {return false };")) !!}
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
                    <p class="form-control-static">{{$conciliacionMultipago->cuentaP->name}}</p>
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
                             $consecutivo=$detalle->peticionMultipago->pago->caja->consecutivo;
                             $plantel_id=$detalle->peticionMultipago->pago->caja->plantel->id;
                             $plantel_razon=$detalle->peticionMultipago->pago->caja->plantel->razon;
                            @endphp
                            <tr>
                                <td>
                                    <a href="{{ route('cajas.caja', array('plantel'=>$plantel_id, 'consecutivo'=>$consecutivo)) }}" target="_blank">
                                        {{ $consecutivo }}
                                    </a>                                    
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