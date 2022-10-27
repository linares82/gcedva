<html>
  <head>
      <style>
        h1, h3, h4, h5, th { text-align: center; font-family: Segoe UI;}
        table, #chart_div { margin: auto; font-family: Segoe UI; box-shadow: 10px 10px 5px #888; border: thin ridge grey; }
        th { background: #0046c3; color: #fff; max-width: 400px; padding: 5px 10px; }
        td { font-size: 11px; padding: 5px 20px; color: #000; }
        tr { background: #b8d1f3; }
        tr:nth-child(even) { background: #dae5f4; }
        tr:nth-child(odd) { background: #b8d1f3; }
      </style>
    
    
  </head>
  <body>
    <div class="datagrid">
        <h2>Prospectos</h2>
        <h3>General</h3>
        <table>
            <thead>
                    <th>F. Alta</th><th>Plantel</th><th>Usuario Alta</th><th>Estatus</th><th>Cantidad</th>
            </thead>
            <tbody>
            @foreach ($resumen as $registro)
            <tr>
                <td>{{ $registro->fecha }}</td><td>{{ $registro->razon }}</td><td>{{ $registro->usuario_alta }}</td>
                <td>{{ $registro->estatus }} </td><td>{{ $registro->total }} </td> 
                
            </tr>
            @endforeach
        
            </tbody>
        </table>
        <h3>Detalle</h3>
        <table>
            <thead>
                    <th>F. Alta</th><th>Nombre(s)</th><th>A. Paterno</th><th>A. Materno</th>
                    <th>Teléfono</th><th>Celular</th><th>Mail</th><th>Plantel</th><th>Especialidad</th>
                    <th>Nivel</th><th>Medio</th><th>Usuario Alta</th><th>Usuario U. Modificación</th>
                    <th>Estatus</th><th>Cliente Id</th><th>Inscripcion</th>
            </thead>
            <tbody>
            @foreach ($registros as $registro)
            <tr>
                <td>{{ $registro->created_at->toDateString() }}</td><td>{{ $registro->nombre }} {{ $registro->nombre2 }}</td>
                <td>{{ $registro->ape_paterno }} </td> <td>{{ $registro->ape_materno }}</td>
                <td>{{ $registro->tel_fijo }}</td><td>{{ $registro->tel_cel }}</td><td>{{ $registro->mail }}</td>
                <td>{{ $registro->plantel->razon }}</td><td>{{ $registro->especialidad->name }}</td>
                <td>{{ $registro->nivel->name }}</td>
                <td>{{ $registro->medio->name }}</td><td>{{ $registro->usu_alta->name }}</td><td>{{ $registro->usu_mod->name }}</td>
                <td>{{ $registro->stProspecto->name }}</td><td>{{ $registro->cliente_id }}</td>
                @permission('prospectos.inscripcion_campo')
                <td>
                  @if($registro->bnd_inscripcion==1)
                  SI
                  @else
                  NO
                  @endif
                </td>
                @endpermission
            </tr>
            @endforeach
        
            </tbody>
        </table>
    </div>
    
  </body>
</html>
