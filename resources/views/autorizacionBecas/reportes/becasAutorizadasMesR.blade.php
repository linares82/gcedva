<html>
<head>
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
</head>
<body>



    <div class="row">
        <div class="col-md-12">
            <h2 class="titulo">Becas</h2>
            <h3>Total Autorizaciones: {{ $registros->count() }}</h3>
            <table class="table table-bordered table-striped dataTable">
                <thead>
                    <tr>
                    <th>No.</th>
                        <th>Plantel</th>
                        <th>Especialidad</th>
                        <th>Nivel</th>
                        <th>Grado</th>
                        <th>Matricula</th>
                        <th>Id</th>
                        <th>Alumno</th>
                        <th>Genero</th>
                        <th>Solicitud</th>
                        <th>%</th>
                        <th>Concepto</th>
                        <th>Pagado</th>
                        <th>F. Pago</th>
                        <th>Total</th>
                        <th>Descuento</th>
                        <th>Recargo</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                    $i=0;
                    @endphp
        
                    @foreach($resultados as $r)
                    <tr>
                        <td>{{ ++$i }}</td>
                        <td>{{$r['plantel']}}</td>
                        <td>{{$r['especialidad']}}</td>
                        <td>{{$r['nivel']}}</td>
                        <td>{{$r['grado']}}</td>
                        <td>{{$r['matricula']}}</td>
                        <td>{{$r['id']}}</td>
                        <td>{{$r['ape_paterno']}} {{$r['ape_materno']}} {{$r['nombre']}} {{$r['nombre2']}}</td>
                        <td>
                            @if($r['genero']==1)    
                            Hombre
                            @elseif (is_null($r['genero']))

                            @else
                                Mujer
                            @endif
                        
                        </td>
                        <td>{{ $r['solicitud'] }}</td>
                        <td>{{$r['porcentaje']}}</td>
                        <td>{{$r['concepto']}}</td>
                        <td>
                            @if($r['bnd_pagado'])
                            Si
                            @else
                            No
                            @endif


                        </td>
                        <td>{{$r['fecha_pago']}}</td>
                        <td>{{$r['subtotal']}}</td>
                        <td>{{$r['descuento']}}</td>
                        <td>{{$r['recargo']}}</td>
                        <td>{{$r['total']}}</td>
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