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
    
    .titulo {
        text-align: center;
        
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
            <h2 class="titulo">Caja General</h2>
            <h3 class="titulo">De {{$datos['fecha_f']}} a {{$datos['fecha_t']}}</h3>
            <table class="table table-bordered table-striped dataTable">
                <thead>
                    <tr>
                        <th>Plantel</th>
                        <th>Consecutivo Caja</th>
                        <th>Matricula</th>
                        <th>Cliente</th>
                        <th>Fecha Pago</th>
                        <th>Cajero</th>
                        <th>Concepto</th>
                        <th>Forma Pago</th>
                        <th>Monto</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($registros as $r)
                    <tr>
                        <td>{{$r->razon}}</td>
                        <td>{{$r->consecutivo}}</td>
                        <td>{{$r->matricula}}</td>
                        <td>{{$r->cliente}}</td>
                        <td>{{$r->fecha}}</td>
                        <td>{{$r->usuario}}</td>
                        <td>{{$r->concepto}}</td>
                        <td>{{$r->forma_pago}}</td>
                        <td>{{$r->total}}</td>
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