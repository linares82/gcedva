<html>
    <head>
        <style>
            @media print {
                table {
                    font-family: arial, sans-serif;
                    border-collapse: collapse;
                    width: 100%;
                    font-size: 9px;
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
                font-size: 9px;
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
                    <?php $grupo0=""; ?>
                    @foreach($registros as $r)
                    @if($grupo0<>$r->grupo)
                        <div style="page-break-after:always;"></div>
                        <tr>
                            <td colspan="3">
                                {{"Plantel: ".$r->plantel }} <br/>
                                {{"Grupo: ".$r->grupo}}<br/>
                                {{"Periodo Lectivo: ".$r->lectivo}}<br/>
                                {{"Profesor: ".$r->maestro}}<br/>
                                {{"Grado: ".$r->grado}}<br/>
                            </td>
                        </tr>
                        <tr>
                        <td><strong>Nombre(s)</strong></td>
                        <td><strong>A. Paterno</strong></td>
                        <td><strong>A. Materno</strong></td>
                        </tr>
                    <tbody>
                    @else
                        <tr>
                            <td>{{$r->nombre." ".$r->nombre2}}</td><td>{{$r->ape_paterno}}</td><td>{{$r->ape_materno}}</td>
                        </tr>
                    @endif
                    <?php $grupo0=$r->grupo; ?>
                    @endforeach
                </tbody>
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

