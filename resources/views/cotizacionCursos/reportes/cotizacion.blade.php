<html>
  <head>
      <style>
          table { font-family: Arial; font-size: 13px;}
/*        h1, h3, h5, th { text-align: center; }
        table, #chart_div { margin: auto; font-family: Segoe UI; box-shadow: 10px 10px 5px #888; border: thin ridge grey; }
        th { background: #0046c3; color: #fff; max-width: 400px; padding: 5px 10px; }
        td { font-size: 11px; padding: 5px 20px; color: #000; }
        tr { background: #b8d1f3; }
        tr:nth-child(even) { background: #dae5f4; }
        tr:nth-child(odd) { background: #b8d1f3; }*/
      </style>
    
    
  </head>
  <body>
    
        <table width="100%">
            <tr>
            <td> <img src="{{ asset('/imagenes/planteles/'.$plantel->id."/".$plantel->logo) }}" alt="Sin logo" height="80px" ></td>
            <td></td>
            <td> {{$plantel->razon}} <br/> Fecha: {{$cotizacion->fecha}} <br/> Cotizacion no. {{$plantel->cve_plantel.$cotizacion->no_coti}} </td>
        
            </tr>
            <tr>
            <td>
                <label for="empresa_id-field">Empresa:{{$cotizacion->empresa->razon_social}}</label><br/>
                <label for="empresa_id-field">Tel. Fijo:{{$cotizacion->empresa->tel_fijo}}</label><br/>
                <label for="empresa_id-field">Email:{{$cotizacion->empresa->correo1}}</label><br/>
            </td>
            <td>
                <label for="empresa_id-field">Contacto:{{$cotizacion->empresa->nombre_contacto}}</label><br/>
                <label for="empresa_id-field">Tel. Celular:{{$cotizacion->empresa->tel_cel}}</label><br/>
            </td>
            <td colspan="2">
                <label for="empresa_id-field">Dirección:Calle {{$cotizacion->empresa->calle}}
                                                     {{$cotizacion->empresa->no_ex}},
                                                     No. Int. {{$cotizacion->empresa->no_int}}, 
                                                     Colonia {{$cotizacion->empresa->colonia}}, 
                                                     Municipio {{$cotizacion->empresa->municipio->name}}, 
                                                     Estado {{$cotizacion->empresa->estado->name}},
                                                     CP {{$cotizacion->empresa->cp}}</label>
            </td>
                
            </tr>
        </table>
        <?php 
            $lineas = count($cotizacion->cotizacionLns); 
            $i=0;
        ?>
        @foreach($cotizacion->cotizacionLns as $linea)
        <table border="1" cellspacing="0">
            <tr style="color: #ffffff;background: #0B0B3B;">
                <td >No.</td>
                <td width="100px">Curso</td>
                <td width="500px">Detalle</td>
                <td>Precios</td>
                <td>Duracion</td>
            </tr>
            
                <tr style="color: #000;background:#f9f9f9;">
                    <td>{{$linea->consecutivo}}</td>
                    <td>{{$linea->cursosEmpresa->name}}</td>
                    <td><?php echo $linea->cursosEmpresa->detalle; ?> </td>
                    <td>
                        Precio por persona presencial: {{number_format($linea->cursosEmpresa->precio_persona, 2, '.', '')}}
                        Precio por persona en Linea: {{number_format($linea->cursosEmpresa->precio_en_linea, 2, '.', '')}}
                        Precio demo: {{number_format($linea->cursosEmpresa->precio_demo, 2, '.', '')}}
                    </td>
                    <td>{{$linea->cursosEmpresa->duracion}} hrs.</td>
                </tr>
                
            
        </table>
        <?php $i++; ?>
        @if($i++ < $lineas)
            <div style="page-break-after:always;"></div>
        @endif
        
        @endforeach        
        Observaciones: <?php echo $cotizacion->observaciones; ?>
    
    <script type="text/php">
            
    </script>
  </body>
</html>
