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
            <h2>Comparativo de pagos 2 meses</h2>
            <table class="table table-bordered table-striped dataTable">
                <tbody>
                    @foreach($registros as $registro)
                    @if($loop->first)
                    <tr>
                        <th>{{$registro[0]}}</th>
                        <th>Pagos {{$registro[1]}}</th>
                        <th>Pagos {{$registro[2]}}</th>
                        <th>{{$registro[3]}}</th>
                        <th>{{$registro[4]}}</th>
                    </tr>
                    @else
                    <tr>
                        <td>{{$registro['plantel']}}</td>
                        <td>{{$registro['mesAnteriorTotal']}}</td>
                        <td>{{$registro['mesActualTotal']}}</td>
                        <td>{{$registro['recuperacion']}}</td>
                        <td>{{$registro['diferencia']}}</td>
                    </tr>
                    @endif
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