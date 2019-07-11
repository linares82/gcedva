<html>
    <head>
        <style>
            @media print {
                table {
                    font-family: arial, sans-serif;
                    border-collapse: collapse;
                    width: 100%;
                    font-size: 14px;
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
/* 
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
        table, #chart_div { margin: auto; font-family: Segoe UI; box-shadow: 10px 10px 5px #888; border: thin ridge gray; }
        th { font-size: 14px; background: #0046c3; color: #fff; max-width: 400px; padding: 2px 5px; }
        td { font-size: 14px; padding: 2px 10px; color: #000; }
        tr { background: #b8d1f3; }
        tr:nth-child(even) { background: #dae5f4; }
        tr:nth-child(odd) { background: #fff; }
      
        </style>

    </head>
    <body>
        <div id="printeArea">
            <h3>Recibo: {{$egreso->id}}      Fecha Impresion: {{date('d-m-Y')}}</h3>
            <table>
                <tbody>
                    <tr>
                        <td><strong>Plantel:</strong>{{ $egreso->plantel->razon }}</td><td><strong>Fecha:</strong>{{ $egreso->fecha }}</td>
                    </tr>
                    <tr>
                        <td><strong>Concepto:</strong>{{ $egreso->egresosConcepto->name }}</td><td><strong>Detalle:</strong>{{ $egreso->detalle }}</td>
                    </tr>            
                    <tr>
                        <td><strong>Forma de Pago:</strong>{{ $egreso->formaPago->name }}</td><td><strong>Monto:</strong>{{ $egreso->monto }}</td>
                    </tr>            
                    <tr>
                        <td colspan='2'><strong>Responsable:</strong>{{ $egreso->empleado->nombre }}  {{ $egreso->empleado->ape_paterno }}  {{ $egreso->empleado->ape_materno }}</td>
                    </tr>            
                </tbody>
            </table>
            <br/>
            <br/>
            <br/>
            <br/>
            <br/>
            <br/>
            <br/>
            <table style="width:25%">
                <tr>
                    <td align='center'>
                        Recibe(Nombre y Firma)
                    </td>
                </tr>
            </table>
            
            
            
        </div>

    </body>
</html>

