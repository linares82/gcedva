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
            <h3>Totales por Concepto<br/>{{$plantel->razon}} <br/> {{$datos['fecha_f']." a ".$datos['fecha_t']}}</h3>
            <table class="table table-bordered table-striped dataTable">
                <thead>
                    <tr>
                        <th>Concepto</th>
                        <th>Monto</th>
                        
                    </tr>
                </thead>
                <tbody>
                    <?php $suma=0; ?>
                    @foreach($registros_pagados as $registro_pagado)
                    <tr>
                        <td>{{$registro_pagado->concepto}}</td>
                        <td>{{number_format($registro_pagado->total,2)}}</td>
                    </tr>
                    <?php $suma=$suma+$registro_pagado->total; ?>
                    @endforeach
                    <tr>
                        <td>Parciales</td>
                        <td>{{number_format($registros_parciales,2)}}</td>
                        <?php $suma=$suma+$registros_parciales; ?>
                    </tr>
                    <tr>
                        <td><strong>Total</strong></td>
                        <td><strong>{{number_format($suma,2)}}</strong></td>
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