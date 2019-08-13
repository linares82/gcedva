<html>
    <head>
        <style>
            @media print {
                table {
                    font-family: arial, sans-serif;
                    border-collapse: collapse;
                    width: 100%;
                    font-size: 10px;
                }

                td, th {
                    border: 1px solid #dddddd;
                    text-align: left;
                    padding: 10px;
                }

                tr:nth-child(even) { background: #dae5f4; }
                tr:nth-child(odd) { background: #fff; }
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
        .SaltoDePagina
         {
          page-break-after: always;
          width:700px;
          padding:10px;

         }
              h1, h3, h5, th { text-align: center; }
        table, #chart_div { margin: auto; font-family: Segoe UI; border: thin ridge gray; }*/
        th { font-size: 10px; background: #0046c3; color: #fff; max-width: 400px; padding: 2px 5px; }
        td { font-size: 10px; padding: 2px 10px; color: #000; }
        tr { background: #b8d1f3; }
        tr:nth-child(even) { background: #dae5f4; }
        tr:nth-child(odd) { background: #fff; }
      
        </style>

    </head>
    <body>
        @foreach($registros as $registro)
        <div id="printeArea" class='SaltoDePagina'>
            <table width="95%">
                <tr>
                    <th><img src="{{asset('images/sep.jpg')}}" alt='logo_sep' width="250px;"></img></th>
                    <th align='center'>SUBSECRETARÍA DE EDUCACIÓN MEDIA SUPERIOR  <br/>
                            DIRECCIÓN GENERAL DE CENTROS DE FORMACIÓN PARA EL TRABAJO<br/>
                            INFORME DE CALIFICACIONES<br/>
                            (ICP-08)</th>
                </tr>
            </table>
            <br/>
            <table width="95%">
                <tr>
                    <td> EL PLANTEL PARTICULAR:{{$plantel->razon}}</td><td>CLAVE CCT: {{$registro->ccte}}</td>
                </tr>
                <tr>
                    <td> HACE CONSTAR QUE EL ALUMNO:{{$registro->nombre_cliente}}</td><td>CON NÚMERO DE CONTROL:</td>
                </tr>
                <tr>
                    <td colspan='2'>  Y CLAVE CURP {{$registro->curp}} OBTUVO LAS SIGUIENTES  CALIFICACIONES EN LA ESPECIALIDAD DE: {{$registro->grado}}</td>
                </tr>
            </table>
            <br/>
            <table width="95%">
                <tr>
                    <th>MATERIA/MÓDULO/NIVEL/CURSO</th><th>CALIFICACIÓN NUMÉRICA</th>
                </tr>
                <?php  
                $param=\App\Param::where('llave','calificacion_aprobatoria')->first();
                $materias= \App\Hacademica::where('cliente_id',$registro->cliente)
                        ->join('calificacions as c','c.hacademica_id','=','hacademicas.id')
                        ->whereNull('hacademicas.deleted_at')
                        ->where('st_materium_id',1)
                        ->where('c.calificacion','>=',$param->valor)
                        ->get();
                //dd($materias);
                ?>
                
                @foreach($materias as $materia)
                <tr>
                    <td>{{$materia->materia->name}}</td><td>{{$materia->calificacion}}</td>
                </tr>
                @endforeach
            </table>
            <br/>
            <table width="95%">
                <tr>
                    <td>
                        LA ESCALA DE CALIFICACIÓN ES DEL 5 AL 10 SIENDO 6 LA MÍNIMA PARA SER PROMOVIDO,  CONFORME AL ACUERDO NÚMERO 17
                    </td>
                </tr>
                <tr>
                    <td>
                        SE EXTIENDE EL PRESENTE CON                                                  ACREDITADOS.
                    </td>
                </tr>
                <tr>
                    <td>
                        <?php  
                        $monthNum=Date('m');
                        $mes=\App\Mese::find($monthNum);
                        ?>
                        {{$plantel->municipio}}, {{$plantel->estado}} A {{ Date('d')}} DE {{ $mes->name }} DE {{ Date('Y')}}
                    </td>
                </tr>
            </table>
            <br/>
            <table width="95%" border="0" cellpadding="10" cellspacing="0" bordercolor="#FFFFFF" class="Texto1" align="center">
                <tbody><tr>
                      <th align="center" valign="bottom" height="100"><span style="font-weight: bold">______________________________________</span><br>
                              NOMBRE Y FIRMA DEL DIRECTOR</th> 
                      <th align="center" valign="bottom" height="100">&nbsp;</th> 
                      <th align="center" valign="bottom" height="100"><span style="font-weight: bold">______________________________________</span><br>
                              SELLO</th> 
                </tr>
                </tbody>
            </table>    
        </div>
        @endforeach
        <script type="text/php">
            /*if (isset($pdf))
            {
            $font = Font_Metrics::get_font("Arial", "bold");
            $pdf->page_text(670, 580, "Pagina {PAGE_NUM} de {PAGE_COUNT}", $font, 9, array(0, 0, 0));
            }*/
        </script>

    </body>
</html>

