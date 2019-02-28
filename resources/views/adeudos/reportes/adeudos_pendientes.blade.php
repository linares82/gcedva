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
        <th><strong>Estudios</strong></th>    
        <th><strong>Cliente</strong></th>
        <th><strong>Adeudo Acumulado</strong></th>
        <th><strong>Pago Acumulado</strong></th>
        </thead>
        <tbody>
            <?php
            $deuda_total = 0;
            $pago_total=0;
            $totalCliente = 0;
            $cliente_id = 0;
            $aux = 0;
            ?>
            @foreach($adeudos as $adeudo)

            <tr>
                <td>{{$adeudo->especialidad." / ".$adeudo->nivel." / ".$adeudo->grado}}</td>
                <td>{{$adeudo->cliente." - ".$adeudo->nombre." ".$adeudo->nombre2." ".$adeudo->ape_paterno." ".$adeudo->ape_materno}}</td>
                <td>{{number_format($adeudo->deuda,2)}}</td>
                <?php 
                $fecha=date('Y/m/d');
                $pago=\App\Caja::select(DB::raw('sum(p.monto) as pago'))
                               ->where('cliente_id',$adeudo->cliente) 
                               ->join('pagos as p','p.caja_id','=','cajas.id')
                               ->whereDate('p.fecha', '<=', $fecha)
                               ->where('cajas.st_caja_id','<>','2')
                               ->value('pago');
                ?>
                <td>{{number_format($pago,2)}}</td>
            </tr>
            <?php 
            $deuda_total=$deuda_total+$adeudo->deuda;
            $pago_total=$pago_total+$pago;
            $diferencia=$pago_total-$deuda_total;
            ?>
            @endforeach
            <tr class="alt"><td></td><td><strong>Total </strong></td><td><strong>{{number_format($deuda_total,2)}}</strong></td><td><strong>{{number_format($pago_total,2)}}</strong></td></tr>
            <tr class="alt"><td></td><td><strong>Diferencia </strong></td>
                            @if($diferencia<0)
                            <td><strong>{{number_format($diferencia,2)}}</strong></td>
                            <td><strong></strong></td>    
                            @else
                            <td><strong></strong></td>
                            <td><strong>{{number_format($diferencia,2)}}</strong></td>
                            @endif
                            
            </tr>
            
        </tbody>
    </table>
    
</div>

