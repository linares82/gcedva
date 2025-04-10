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
                    text-align: center;
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
          width:1200px;
          padding:10px;

         }
         
        .verticalText {
            writing-mode: vertical-lr;
            transform: rotate(90deg);
        } 
         
         body{
             font-family: arial, sans-serif;
         }
        h1, h3, h5, th { text-align: center; }
       
        th { font-size: 10px; max-width: 400px; padding: 2px 5px; border: 1px solid #dddddd;}
        td { font-size: 10px; padding: 2px 10px; color: #000; border: 1px solid #dddddd;}
        tr { background: #b8d1f3; border: 1px solid #dddddd;}
        tr:nth-child(even) { background: #dae5f4; }
        tr:nth-child(odd) { background: #fff; }
      
        </style>

    </head>
    <body>
        
        <div id="printeArea" class='SaltoDePagina'>
                <h3>Listado Empleados</h3>
            
            <table>
                <head>
                    <th>Plantel</th><th>Clave Empleado</th><th>Id</th>
                    <th>Nombre</th><th>Puesto</th>
                    <th>Domicilio</th><th>RFC</th><th>CURP</th>
                    <th>F. Nacimiento</th><th>Estado Nacimiento</th><th>Pais Nacimiento</th>
                    <th>Extranjero</th><th>Nivel Estudio</th><th>Profesion</th>
                    <th>Cédula</th><th>Tel. fijo</th><th>Tel. Celular</th><th>Cel. Empresa</th>
                    <th>Contacto Emergencia</th><th>Tel. Emergencia</th><th>Parentesco</th>
                    <th>Mail</th><th>Mail Empresarial</th><th>Estatus</th><th>F. Ingreso</th>
                    <th>Tipo Contrato 1</th><th>Plantel Contrato 1</th><th>F. Fin Contrato 1</th>
                    <th>Tipo Contrato 2</th><th>Plantel Contrato 2</th><th>F. Fin Contrato 2</th>
                    <th>Es recontratable?</th><th>Justificación</th>
                    <th>Usuario</th><th>Proporciona Pensión Alimenticia</th><th>Es Jefe</th>
                    <th>Jefe</th>
                    <th>PROFORDEMS</th><th>Género</th>
                    <th>EVENTO(BAJA)</th><th>F. EVENTO(BAJA)</th>
                </head>
                <body>
                    @foreach($empleados as $e)
                    <tr>
                    <td>{{$e->razon}}</td><td>{{$e->cve_empleado}}</td><td>{{$e->id}}</td>
                    <td>{{$e->nombre}} {{$e->ape_paterno}} {{$e->ape_materno}}</td><td>{{$e->puesto}}</td>
                    <td>{{ $e->direccion }}</td><td>{{ $e->rfc }}</td><td>{{ $e->curp }}</td>
                    <td>{{ $e->fec_nacimiento }}</td><td>{{$e->estado_nacimiento}}</td><td>{{$e->pais_nacimiento}}</td>
                    <td>{{$e->extranjero_bnd==1 ? 'Si' : 'No'}}</td><td>{{$e->nivel_estudio}}</td><td>{{$e->profesion}}</td>
                    <td>{{$e->cedula}}</td><td>{{$e->tel_fijo}}</td><td>{{ $e->tel_cel }}</td><td>{{$e->cel_empresa}}</td>
                    <td>{{ $e->contacto_emergencia }}</td><td>{{ $e->tel_emergencia }}</td><td>{{ $e->parentesco }}</td>
                    <td>{{$e->mail}}</td><td>{{ $e->mail_empresa }}</td><td>{{ $e->estatus }}</td><td>{{ $e->fec_ingreso }}</td>
                    <td>{{ $e->tipo_contrato }}</td><td>{{ $e->pla_contrato1 }}</td><td>{{ $e->fin_contrato }}</td>
                    <td>{{ $e->tipo_contrato2 }}</td><td>{{ $e->pla_contrato2 }}</td><td>{{ $e->fec_fin_contrato2 }}</td>
                    <td>{{$e->bnd_recontratable ? 'Si' : 'No'}}</td><td>{{$e->just_recontratable}}</td>
                    <td>{{$e->user}}</td><td>{{$e->alimenticia_bnd ? 'Si' : 'No'}}</td><td>{{$e->jefe_bnd ? 'Si' : 'No'}}</td>
                    <td>{{$e->nombre_jefe}}{{$e->ape_paterno_jefe}}{{$e->ape_materno_jefe}}</td>
                    <td>{{$e->profordems}}</td><td>{{$e->genero==1 ? 'Hombre' : 'Mujer'}}</td>
                    <td>{{optional($e->historials->last())->descripcion}}</td><td>{{optional($e->historials->last())->fecha}}</td>
                    </tr>
                @endforeach    
                </body>
                
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

