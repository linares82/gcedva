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
                    Adeudos Pendientes {{$plantel->razon}}
                </h3>
            </td>
        </tr>
</table>

<div class="datagrid">
    <table width='100%'>
        <thead>
        <th><strong>Plan</strong></th>    
        <th><strong>Cliente</strong></th>
        <th><strong>Caja</strong></th>
        <th><strong>Estatus</strong></th>
        <th><strong>Conceptos</strong></th>
        <th><strong>Pagos</strong></th>
        </thead>
        <tbody>
            <?php
            $sumatoria=0;
            ?>
            @foreach($cajas as $caja)

            <tr>
                <td>{{$caja->plan}}</td>
                <td>{{$caja->cliente." - ".$caja->nombre." ".$caja->nombre2." ".$caja->ape_paterno." ".$caja->ape_materno}}</td>
                <td> {{$caja->consecutivo}}</td>
                <td> {{$caja->estatus}}
                </td>
                <?php
                $caja=\App\Caja::find($caja->caja);    
                ?>
                <td>
                    @foreach($caja->cajaLns as $linea)
                        {{$linea->cajaConcepto->name}}<br/>
                    @endforeach
                </td>
                <td>
                    <?php 
                    $suma_pagos=0;
                    ?>
                    @foreach($caja->pagos as $pago)
                        <?php 
                        $suma_pagos=$suma_pagos+$pago->monto; 
                        $sumatoria=$suma_pagos+$sumatoria;        
                        ?>
                    @endforeach
                    {{$suma_pagos}}
                </td>
            </tr>
            
            @endforeach
            <tr>
                <td colspan='4'></td>
                <td>Total</td>
                <td>{{$sumatoria}}</td>
            </tr>
            
        </tbody>
    </table>
    
</div>

