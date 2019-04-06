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
        <table border="1" cellspacing="0">
            <tr  style="color: #ffffff;background: #0B0B3B;">
                <td >No.</td>
                <td width="350px">Curso</td>
                <td width="150px">Tipo Precio</td>
                <td>Precio</td>
                <td>Cantidad</td>
                <td>Total</td>
            </tr>
            @foreach($cotizacion->cotizacionLns as $linea)
                <tr style="color: #000;background:#f9f9f9;">
                    <td>{{$linea->consecutivo}}</td>
                    <td>{{$linea->cursosEmpresa->name}}</td>
                    <td>{{$linea->tipoPrecioCoti->name}} </td>
                    <td>
                        {{number_format($linea->precio, 2, '.', '')}}
                    </td>
                    <td>{{$linea->cantidad}} </td>
                    <td>{{number_format($linea->cantidad*$linea->precio, 2, '.', '')}} </td>
                </tr>
            @endforeach                
                <tr style="color: #000;background:#f9f9f9;" align="right">
                    <td colspan="5"><strong>Subtotal</strong></td>
                    <td>{{number_format($cotizacion->subtotal, 2, '.', '')}} </td>
                </tr>
                <tr style="color: #000;background:#f9f9f9;" align="right">
                    <td colspan="5"><strong>Descuento</strong></td>
                    <td>{{number_format($cotizacion->descuento, 2, '.', '')}} </td>
                </tr>
                <tr style="color: #000;background:#f9f9f9;" align="right">
                    <td colspan="5"><strong>IVA</strong></td>
                    <td>{{number_format($cotizacion->iva, 2, '.', '')}} </td>
                </tr>
                <tr style="color: #000;background:#f9f9f9;" align="right">
                    <td colspan="5"><strong>Total</strong></td>
                    <td>{{number_format($cotizacion->total, 2, '.', '')}} </td>
                </tr>
        </table>

        Observaciones: <?php echo $cotizacion->observaciones; ?>
        Clausulas: <?php echo $plantel->clausulas_cotizacion; ?>
    
    <script type="text/php">
            
    </script>
  </body>
</html>
