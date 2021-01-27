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
            <h2>Pagos En Linea</h2>
            <table class="table table-bordered table-striped dataTable">
                <thead>
                    <tr>
                        <th>Plantel</th>
                        <th>Forma Pago</th>
                        <th>Cliente Id</th>
                        <th>Matricula</th>
                        <th>Cliente</th>
                        <th>Consecutivo Caja</th>
                        <th>Concepto</th>
                        <th>Estatus Caja</th>
                        <th>Consecutivo Pago</th>
                        <th>Fecha Pago</th>
                        <th>Monto</th> 
                    </tr>
                </thead>
                <tbody>
                    @foreach($registros as $registro)
                    <tr>
                        <td>{{$registro->razon}}</td>
                        <td>{{$registro->forma_pago}}</td>
                        <td>{{$registro->cliente_id}}</td>
                        <td>{{$registro->matricula}}</td>
                        <td>{{$registro->ape_paterno}} {{$registro->ape_materno}} {{$registro->nombre}} {{$registro->nombre2}}</td>
                        <td>{{$registro->consecutivo}}</td>
                        <td>{{$registro->concepto}}</td>
                        <td>{{$registro->stcaj}}</td>
                        <td>{{$registro->csc_simplificado}}</td>
                        <td>{{$registro->fecha_pago}}</td>
                        <td>{{number_format($registro->monto,2)}}</td>
                    </tr>
                    @endforeach
                    
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