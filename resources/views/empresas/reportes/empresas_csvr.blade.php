<html>
    <head>
        <style>
            @media print {
                table {
                    font-family: arial, sans-serif;
                    border-collapse: collapse;
                    width: 100%;
                    font-size: 11px;
                }

                td, th {
                    border: 1px solid #dddddd;
                    text-align: left;
                    padding: 8px;
                }

                tr:nth-child(even) {
                    background-color: #dddddd;
                }
            }
 
            table {
                font-family: arial, sans-serif;
                border-collapse: collapse;
                width: 100%;
                font-size: 11px;
            }

            td, th {
                border: 1px solid #dddddd;
                text-align: left;
                padding: 8px;
            }

            tr:nth-child(even) {
                background-color: #dddddd;
            }
        </style>

    </head>
    <body>
        <div id="printeArea">
            <table>
                <thead>
                <td><strong>Grupo</strong></td>
                <td><strong>Lectivo</strong></td>
                <td><strong>Maestro</strong></td>
                <td><strong>Grado</strong></td>
                <td><strong>Nombre(s)</strong></td>
                <td><strong>A. Paterno</strong></td>
                <td><strong>A. Materno</strong></td>
                </thead>
                <tbody>

                    @foreach($registros as $r)

                    <tr>
                        <td>{{$r->grupo}}</td><td>{{$r->lectivo}}</td><td>{{$r->maestro}}</td><td>{{$r->grado}}</td><td>{{$r->nombre." ".$r->nombre2}}</td><td>{{$r->ape_paterno}}</td><td>{{$r->ape_materno}}</td>
                    </tr>     

                    @endforeach
                </tbody>
            </table>
        </div>

        <script type="text/php">
            if (isset($pdf))
            {
            $font = Font_Metrics::get_font("Arial", "bold");
            $pdf->page_text(670, 580, "Pagina {PAGE_NUM} de {PAGE_COUNT}", $font, 9, array(0, 0, 0));
            }
        </script>

    </body>
</html>

