<html>
<head>
</head>
<body>
<style>
@media print {
/*   table, th, td
    {
        border-collapse:collapse;
        border: 1px solid black;
        width:100%;
        text-align:right;
    }
}
body{
    font-family:"sans-serif";
}*/
</style>

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
            border: solid 1px #2E64FE;
        }

        tr:nth-child(even){background-color: #f2f2f2}

        th {
            background-color: #2E64FE;
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
        border: solid 1px #2E64FE;
    }

    tr:nth-child(even){background-color: #f2f2f2}

    th {
        background-color: #2E64FE;
        color: white;
    }
        
    body {
        font: normal 10px Arial, Helvetica, sans-serif; 
    }
</style>

    <div class="row">
        <div class="col-md-12">
            <h2>Pagos y Facturas</h2>
            <table class="table table-bordered table-striped dataTable">
                <thead>
                    <tr>
                        <th>Plantel</th>
                        <th>Forma Pago</th>
                        <th>Cliente Id</th>
                        <th>Consecutivo Caja</th>
                        <th>Fecha Pago</th>
                        <th>Monto</th>
                        <th>UUID</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                    $suma=0;
                    $forma_pago="";
                    $uuid="";
                    @endphp
                    @foreach($registros as $registro)
                    @if((is_null($registro->uuid)<>$uuid or $registro->forma_pago<>$forma_pago) and $loop->index>0)
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>Total Facturado/No facturado</td>
                        <td>{{number_format($suma_grupo_factura,2)}}</td>
                        <td></td>
                    </tr>
                    @php
                        $suma_grupo_factura=0;
                    @endphp
                    @endif
                    @if($registro->forma_pago<>$forma_pago and $loop->index>0)
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>Total por forma de pago</td>
                        <td>{{number_format($suma,2)}}</td>
                        <td></td>
                    </tr>
                    @php
                        $suma=0;
                    @endphp
                    @endif
                    
                    <tr>
                        <td>{{$registro->razon}}</td>
                        <td>{{$registro->forma_pago}}</td>
                        <td>{{$registro->cliente_id}}</td>
                        <td>{{$registro->consecutivo}}</td>
                        <td>{{$registro->fecha_pago}}</td>
                        <td>{{number_format($registro->monto,2)}}</td>
                        <td>{{$registro->uuid}}</td>
                    </tr>
                    @php 
                    $suma=$suma+$registro->monto; 
                    $forma_pago=$registro->forma_pago;
                    $suma_grupo_factura=$suma_grupo_factura+$registro->monto; 
                    if(is_null($registro->uuid))
                    $uuid=true;
                    else
                    $uuid=false;
                    //dd($uuid);
                    @endphp
                    @endforeach
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>Total Facturado/No facturado</td>
                        <td>{{number_format($suma_grupo_factura,2)}}</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>Total por Forma de pago</td>
                        <td>{{number_format($suma,2)}}</td>
                        <td></td>
                    </tr>
                    
                </tbody>
            </table>
            
        </div>
    </div>
<script type="text/php">
    if (isset($pdf)){
        $font = $fontMetrics->getFont("Arial", "bold");
        $pdf->page_text(700, 590, "Página {PAGE_NUM} de {PAGE_COUNT}", $font, 10, array(0, 0, 0));
    }
</script>
</body>
</html>