<html>
    <head>
        <style>
/*            @media print {
                table {
                    font-family: arial, sans-serif;
                    border-collapse: collapse;
                    width: 100%;
                    font-size: 9px;
                }

                td, th {
                    border: 1px solid #dddddd;
                    text-align: left;
                    padding: 10px;
                }

                tr:nth-child(even) {
                    background-color: #dddddd;
                }
            }
 
            table {
                font-family: arial, sans-serif;
                border-collapse: collapse;
                width: 100%;
                font-size: 8px;
            }

            td th {
                border: 1px solid #dddddd;
                text-align: left;
                padding: 8px;
            }
            
            .altura {
                height: 100px;
            }
            
            .girar_texto {
                
                text-align: center;
                padding: 8px;
                transform: rotate(270deg);
                height: auto;
                
            }
            
            .centrar_texto {
                text-align: center;
                padding: 8px;
            }
            tr:nth-child(even) {
                background-color: #dddddd;
            }*/
      
        h1, h3, h5, th { text-align: center; }
        table, #chart_div { margin: auto; font-family: Segoe UI; border: thin ridge grey; }
        .tbl1 th { background: #0046c3; color: #fff; max-width: 400px; padding: 5px 10px; font-size: 11px;}
        .tbl1 td { font-size: 10px; padding: 5px 20px; color: #000; }
        .tbl1 tr { background: #b8d1f3; }
        .tbl1 tr:nth-child(even) { background: #dae5f4; }
        .tbl1 tr:nth-child(odd) { background: #b8d1f3; }
      
        table.blueTable {
            width: 60%;
            text-align: center;
            border-collapse: collapse;
          }
          table.blueTable .td1{
            height: 100px;
          }
          table.blueTable .tdw{
            width: 33%;
          }
          table.blueTable td, table.blueTable th {
            border: 1px solid #AAAAAA;
          }
          
          table.blueTable thead th {
            font-weight: bold;
            text-align: center;
          }
        
        </style>

    </head>
    <body>
        
        <div id="printeAreaLista">
            @foreach($registros as $registro)
            <table width="100%">
                <tr>
                    <td> <img src="{{ asset('/imagenes/planteles/'.$registro->p_id."/".$registro->logo) }}" alt="Sin logo" height="80px" ></img></td>
                    <td>{{$registro->plantel}}<br/>Informe de Calificaciones</td>
                    <td></td>
                </tr>
            </table>
            <table width="100%">
                <tr>
                    <td> Matricula: {{$registro->matricula}} </td>
                    <td> Nombre: {{$registro->nombre." ".$registro->nombre2." ".$registro->ape_paterno." ".$registro->materno}}</td>
                    <td> Fecha: </td>
                </tr>
                <tr>
                    <td> Plantel: {{$registro->plantel}}</td>
                </tr>
                <tr>
                    <td> Grado: {{$registro->grado}}</td>
                </tr>
            </table>
            
            @endforeach
            <br/>
            <br/>
            <br/>
            <table class='blueTable'>
                <tr class='td1'><td></td><td></td><td></td><td></td><td></td></tr>
                <tr><td class='tdw'></td><td></td><td class='tdw'>Sello del Plantel</td><td></td><td></td></tr>
                <tr><td>Instructor Titular</td><td></td><td></td><td></td><td class='tdw'>Firma de Director</td></tr>
            </table>
        </div>
        
        <script type="text/php">
            /*if (isset($pdf))
            {
            $font = Font_Metrics::get_font("Arial", "bold");
            $pdf->page_text(670, 580, "Pagina {PAGE_NUM} de {PAGE_COUNT}", $font, 9, array(0, 0, 0));
            }*/
        </script>

    </body>
</html>

