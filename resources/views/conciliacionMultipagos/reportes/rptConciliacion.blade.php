<style>
    @media print {
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            text-align: left;
            padding: 8px;
            font: normal 12px Arial, Helvetica, sans-serif; 
            border: solid 1px #FE9A2E;
        }

        tr:nth-child(even){background-color: #f2f2f2}

        th {
            background-color: #FE9A2E;
            color: white;
            font-weight: bold;
        }
     }
    
    table {
        border-collapse: collapse;
        width: 100%;
    }

    th, td {
        text-align: center;
        padding: 8px;
        font: normal 12px Arial, Helvetica, sans-serif; 
        
    }

    .th_caja {
        text-align: center;
        padding: 8px;
        font: normal 12px Arial, Helvetica, sans-serif; 
        border: solid 1px #FE9A2E;
    }

    .th_pago {
        text-align: center;
        padding: 8px;
        font: normal 12px Arial, Helvetica, sans-serif; 
        border: solid 1px #19750A;
    }

    .th_peticion {
        text-align: center;
        padding: 8px;
        font: normal 12px Arial, Helvetica, sans-serif; 
        border: solid 1px #0F2D93;
    }

    .th_conciliacion {
        text-align: center;
        padding: 8px;
        font: normal 12px Arial, Helvetica, sans-serif; 
        border: solid 1px #D110AE;
    }

    tr:nth-child(even){background-color: #f2f2f2}

    th {
        background-color: #FE9A2E;
        color: white;
    }
        
    body {
        font: normal 10px Arial, Helvetica, sans-serif; 
    }
</style>

<h2>
    Pagos Existentes en Conciliacion
</h2>

<div class="datagrid">
    <table width='100%'>
        <thead>
        <th class="th_caja"><strong>Plantel</strong></th>    
        <th class="th_caja"><strong>Caja Consecutivo</strong></th>    
        <th class="th_caja"><strong>Caja Monto</strong></th>
        <th class="th_caja"><strong>Caja Fecha</strong></th>
        <th class="th_pago"><strong>Pago Fecha</strong></th>
        <th class="th_pago"><strong>Pago Consecutivo</strong></th>
        <th class="th_pago"><strong>Pago monto</strong></th>
        <th class="th_peticion"><strong>Peticion Fecha</strong></th>
        <th class="th_peticion"><strong>Peticion Node</strong></th>
        <th class="th_peticion"><strong>Peticion Order</strong></th>
        <th class="th_peticion"><strong>Peticion Referencia</strong></th>
        <th class="th_peticion"><strong>Peticion Monto</strong></th>
        <th class="th_peticion"><strong>Peticion Metodo Pago</strong></th>
        <th class="th_conciliacion"><strong>Conciliacion No. Aprobacion</strong></th>
        <th class="th_conciliacion"><strong>Conciliacion Importe</strong></th>
        <th class="th_conciliacion"><strong>Conciliacion Comision</strong></th>
        <th class="th_conciliacion"><strong>Conciliacion Iva Comision</strong></th>
        <th class="th_conciliacion"><strong>Conciliacion Fecha Dispersion</strong></th>
        <th class="th_caja"><strong>Respuesta Codigo</strong></th>
        <th class="th_caja"><strong>Respuesta Mensaje</strong></th>
        </thead>
        <tbody>
            @foreach($registrosConciliados as $registro)
            <tr>
                <td class="th_caja">{{$registro['plantel']}}</td>
                <td class="th_caja">{{$registro['caja_consecutivo']}}</td>
                <td class="th_caja">{{$registro['caja_monto']}}</td>
                <td class="th_caja">{{$registro['caja_fecha']}}</td>
                <td class="th_pago">{{$registro['pago_consecutivo']}}</td>
                <td class="th_pago">{{$registro['pago_fecha']}}</td>
                <td class="th_pago">{{$registro['pago_monto']}}</td>
                <td class="th_peticion">{{$registro['peticion_fecha']}}</td>
                <td class="th_peticion">{{$registro['peticion_mp_node']}}</td>
                <td class="th_peticion">{{$registro['peticion_mp_order']}}</td>
                <td class="th_peticion">{{$registro['peticion_mp_reference']}}</td>
                <td class="th_peticion">{{$registro['peticion_mp_amount']}}</td>
                <td class="th_peticion">{{$registro['peticion_mp_paymentmethod']}}</td>
                <td class="th_conciliacion">{{$registro['conciliacion_no_aprobacion']}}</td>
                <td class="th_conciliacion">{{$registro['conciliacion_importe']}}</td>
                <td class="th_conciliacion">{{$registro['conciliacion_comision']}}</td>
                <td class="th_conciliacion">{{$registro['conciliacion_iva_comision']}}</td>
                <td class="th_conciliacion">{{$registro['conciliacion_fecha_dispersion']}}</td>
                <td class="th_caja">{{$registro['respuesta_mp_response']}}</td>
                <td class="th_caja">{{$registro['respuesta_mp_responsemsg']}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <br/>
    <h2>
        Registros en Conciliacion no Existentes en Sistema
    </h2>
    <table width='100%'>
        <thead>
            
            <th>Fecha Pago</th><th>Razón Social</th><th>Unidad Negocio</th><th>Categoria Cobranza</th>
            <th>Tipo Pago</th><th>Referencia</th><th>No. Orden</th><th>No. Aprobación</th>
            <th>Id. Venta</th><th>Referencia Medio Pago</th><th>Importe</th><th>Comisión</th>
            <th>Iva Comisión</th><th>Fecha Dispersión</th><th>Periodo Financiamiento</th>
            <th>Moneda</th><th>Banco Emisor</th><th>Nombre Pagador</th><th>MAil</th><th>Tel.</th>
        </thead>
        <tbody>
            @foreach($lineasConciliacionExtra as $extra)
            <tr>
                <td>{{ $extra->fecha_pago }}</td><td>{{ $extra->razon_social }}</td><td>{{ $extra->mp_node }}</td>
                <td>{{ $extra->mp_concept }}</td><td>{{ $extra->mp_paymentmethod }}</td><td>{{ $extra->mp_reference }}</td>
                <td>{{ $extra->mp_order }}</td><td>{{ $extra->no_aprobacion }}</td><td>{{ $extra->identificador_venta }}</td>
                <td>{{ $extra->ref_medio_pago }}</td><td>{{ $extra->importe }}</td><td>{{ $extra->comision }}</td>
                <td>{{ $extra->iva_comision }}</td><td>{{ $extra->fecha_dispersion }}</td><td>{{ $extra->periodo_financiamiento }}</td>
                <td>{{ $extra->moneda }}</td><td>{{ $extra->banco_emisor }}</td><td>{{ $extra->mp_customername }}</td>
                <td>{{ $extra->mail }}</td><td>{{ $extra->tel_customername }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>    
</div>

