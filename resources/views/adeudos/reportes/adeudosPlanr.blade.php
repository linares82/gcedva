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
        border: solid 1px #FE9A2E;
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

<table width='100%'>
    <tr>
            <td align="center"  >
                <h3>
                    Adeudos Pendientes
                </h3>
            </td>
        </tr>
</table>

<div class="datagrid">
    <table width='100%'>
        <thead>
        <th><strong>Plantel</strong></th>    
        <th><strong>Plan</strong></th>    
        <th><strong>Cliente</strong></th>
        <th><strong>Caja</strong></th>
        <th><strong>Estatus</strong></th>
        <th><strong>Conceptos / Monto </strong></th>
        <th><strong>Pagos</strong></th>
        </thead>
        <tbody>
            <?php
            $sumatoria=0;
            ?>
            @foreach($cajas as $caja)
            <?php
            $caja2=\App\Caja::find($caja->caja);    
            $marcador=0;
            foreach($caja2->cajaLns as $linea){
                if($linea->caja_concepto_id>=$datos['concepto_f'] and $linea->caja_concepto_id<=$datos['concepto_f']){
                    $marcador=1;
                }
            }
            ?>
            @if($marcador==1)
            <tr>
                <td>{{$caja->razon}}</td>
                <td>{{$caja->plan}}</td>
                <td>{{$caja->cliente." - ".$caja->nombre." ".$caja->nombre2." ".$caja->ape_paterno." ".$caja->ape_materno}}</td>
                <td> {{$caja->consecutivo}}</td>
                <td> {{$caja->estatus}}
                </td>
                
                <td>
                    @php $indicador=0; @endphp
                    @foreach($caja2->cajaLns as $linea)
                        @if($linea->caja_concepto_id>=$datos['concepto_f'] and $linea->caja_concepto_id<=$datos['concepto_t'] and $linea->adeudo->combinacionCliente->planPago->id==$caja->plan_id)
                            {{$linea->cajaConcepto->name}} / {{$linea->total}}<br/>
                            @php $indicador=1; @endphp
                        @endif
                    @endforeach
                </td>
                <td>
                    <?php 
                    $suma_pagos=0;
                    ?>
                    @foreach($caja2->pagos as $pago)
                        <?php 
                        $suma_pagos=$suma_pagos+$pago->monto; 
                        $sumatoria=$suma_pagos+$sumatoria;        
                        ?>
                        @if($indicador==1)
                        {{$pago->fecha}} - {{$pago->monto}}
                        @endif
                    @endforeach
                    
                </td>
            </tr>
            @endif
            @endforeach
            <tr>
                <td colspan='4'></td>
                <td>Total</td>
                <td>{{$sumatoria}}</td>
            </tr>
            
        </tbody>
    </table>
    
</div>

