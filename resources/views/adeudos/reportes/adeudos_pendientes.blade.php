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

<table>
    <tr>
            <td align="center"  >
                <h3>
                    Adeudos Pendientes {{$plantel->razon}}
                </h3>
            </td>
        </tr>
</table>

<div class="datagrid">
    <table>
        <thead>
        <th><strong>Estudios</strong></th>    
        <th><strong>Cliente</strong></th>
        <th><strong>Fecha planeada de pago</strong></th>
        <th><strong>Monto</strong></th>
        </thead>
        <tbody>
            <?php
            $total = 0;
            $totalCliente = 0;
            $cliente_id = 0;
            $aux = 0;
            ?>
            @foreach($adeudos as $adeudo)

            @if($cliente_id<>$adeudo->cliente)
            @if($aux>0)
            <tr class="alt"><td></td><td></td><td><strong>Total Cliente</strong></td><td><strong>{{$totalCliente}}</strong></td></tr>
            @endif
            <?php
            $aux++;
            ?>
            <tr>
                <td>{{$adeudo->especialidad." / ".$adeudo->nivel." / ".$adeudo->grado}}</td>
                <td>{{$adeudo->cliente." - ".$adeudo->nombre." ".$adeudo->nombre2." ".$adeudo->ape_paterno." ".$adeudo->ape_materno}}</td>
                <td>{{$adeudo->fecha_pago}}</td>
                <td>{{$adeudo->monto}}</td>
            </tr>
            <?php
            $totalCliente = $adeudo->monto;
            ?>
            @else
            <tr>
                <td>{{$adeudo->especialidad." / ".$adeudo->nivel." / ".$adeudo->grado}}</td>
                <td>{{$adeudo->cliente." - ".$adeudo->nombre." ".$adeudo->nombre2." ".$adeudo->ape_paterno." ".$adeudo->ape_materno}}</td>
                <td>{{$adeudo->fecha_pago}}</td>
                <td>{{$adeudo->monto}}</td>
            </tr>
            <?php
            $totalCliente = $totalCliente + $adeudo->monto;
            $total = $total + $adeudo->monto;
            ?>    
            @endif
            <?php
            $cliente_id = $adeudo->cliente;
            ?>
            @endforeach
            <tr class="alt"><td></td><td></td><td><strong>Total Cliente</strong></td><td><strong>{{$totalCliente}}</strong></td></tr>
            <tr class="alt"><td></td><td></td><td><strong>Total General</strong></td><td><strong>{{$total}}</strong></td></tr>
        </tbody>
    </table>
</div>

