<html>
  <head>
      <style>
        h1, h3, h5, th { text-align: center; }
        table, #chart_div { margin: auto; font-family: Segoe UI; box-shadow: 10px 10px 5px #888; border: thin ridge grey; }
        th { background: #0046c3; color: #fff; max-width: 400px; padding: 5px 10px; }
        td { font-size: 11px; padding: 5px 20px; color: #000; }
        tr { background: #b8d1f3; }
        tr:nth-child(even) { background: #dae5f4; }
        tr:nth-child(odd) { background: #b8d1f3; }

        .SaltoDePagina
         {
          page-break-after: always;
          width:700px;
          /*padding:1px;*/
         }
      </style>
    
    
  </head>
  <body>
    <div class="datagrid">
        <h3>Lista de Bienes Resguardados</h3>
        <table class="table table-condensed table-striped SaltoDePagina">
            <thead>
                <th></th><th>Plantel</th><th>Responsable</th><th>No. Inventario</th><th>Articulo</th><th>Ubicacion</th><th>Marca</th><th>Modelo</th><th>No. Serie</th>
                <th>Estatus Uso</th><th>Estatus Uso</th><th>Fecha Alta</th>
            </thead>
            <tbody>
                <?php $consecutivo_linea=1; 
                $responsable=0;
                ?>
                @foreach($registros as $registro)
                @if($responsable<>$registro->empleado and $responsable<>0)
                <td colspan='12'>
                  <table width="40%" border="0" cellpadding="10" cellspacing="0" bordercolor="#FFFFFF" class="Texto1" align="center">
                      <tbody><tr>
                              <td align="center" valign="bottom" height="100"><span style="font-weight: bold"><u></u></span><br>
                                    NOMBRE Y FIRMA DE CONFORMIDAD</td> 
                            <td align="center" valign="bottom" height="100">&nbsp;</td> 
                            <td align="center" valign="bottom" height="100"><span style="font-weight: bold">______________________________________</span><br>
                                    </td> 
                      </tr>
                      </tbody>
                  </table>
                </td>
                </tbody>
                </table>
                    
                <table class="table table-condensed table-striped SaltoDePagina">
                <thead>
                    <th></th><th>Plantel</th><th>Responsable</th><th>No. Inventario</th><th>Articulo</th><th>Ubicacion</th><th>Marca</th><th>Modelo</th><th>No. Serie</th>
                    <th>Estatus Uso</th><th>Estatus Uso</th><th>Fecha Alta</th>
                </thead>
                <tbody>
                @endif
                <tr>
                <td>{{$consecutivo_linea++}}</td><td>{{ $registro->razon }}</td><td>{{$registro->nombre}} {{$registro->ape_paterno}} {{$registro->ape_materno}}</td>
                <td>{{ \App\Mueble::find($registro->id)->getNoInv()}}</td><td>{{$registro->articulo}}</td><td>{{$registro->ubicacion}}</td>
                <td>{{$registro->marca}}</td><td>{{$registro->modelo}}</td><td>{{$registro->no_serie}}</td><td>{{$registro->estatus_uso}}</td>
                <td>{{$registro->estatus}}</td><td>{{$registro->fecha_alta}}</td>
                </tr>
                <?php 
                $responsable=$registro->empleado;
                ?>
                @endforeach
                <td>
                  <td colspan='12'>
                  <table width="40%" border="0" cellpadding="10" cellspacing="0" bordercolor="#FFFFFF" class="Texto1" align="center">
                      <tbody><tr>
                              <td align="center" valign="bottom" height="100"><span style="font-weight: bold"><u></u></span><br>
                                    NOMBRE Y FIRMA DE CONFORMIDAD</td> 
                            <td align="center" valign="bottom" height="100">&nbsp;</td> 
                            <td align="center" valign="bottom" height="100"><span style="font-weight: bold">______________________________________</span><br>
                                    </td> 
                      </tr>
                      </tbody>
                  </table>
                </td>
                </td>
            </tbody>
        </table>
    </div>
    
  </body>
</html>
