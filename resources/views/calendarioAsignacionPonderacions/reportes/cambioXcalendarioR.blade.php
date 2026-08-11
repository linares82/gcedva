<html>
  <head>
      <style>
        h1, h5, th { text-align: center; }
        table, #chart_div { margin: auto; font-family: Segoe UI; box-shadow: 10px 10px 5px #888; border: thin ridge grey; }
        th { background: #0046c3; color: #fff; max-width: 400px; padding: 5px 10px; }
        td { font-size: 11px; padding: 5px 20px; color: #000; }
        tr { background: #b8d1f3; }
        tr:nth-child(even) { background: #dae5f4; }
        tr:nth-child(odd) { background: #b8d1f3; }
      </style>
    
  </head>
  <body>
      <h3>Calificaciones editadas dentro de Calednario de asignacion</h3>
    <div class="datagrid">
        <table class="table table-condensed table-striped">
            <thead>
                <tr>
                    <th></th><th>Plantel</th><th>Cliente</th>
                    <th>Docente</th><th>Materia</th>
                    <th>Ponderacion</th><th>Calificacion Anterior</th>
                    <th>Calificacion Nueva</th>
                    <th>Lectivo</th>
                    <th>Cal. Inicio</th>
                    <th>Cal. Fin</th>
                    <th>F. Modificacion</th>
                    <th>Calendario Creado Por</th>
                </tr> 
            </thead>
            <tbody>
                <?php 
                $i=0; 
                $j=0;
                ?>
                <?php $colaborador="" ?>
                <?php $contador_linea=1; ?>
                @foreach($registros as $registro)
                    
                    <tr>
                        <td>{{$contador_linea++}}</td>
                        <td>{{$registro->razon}}</td>
                        <td>{{$registro->cliente_id}}</td>
                        <td>{{$registro->nombre}} {{$registro->ape_paterno}} {{$registro->ape_materno}}</td>
                        <td>{{$registro->materia}}</td>
                        <td>{{$registro->carga_ponderacion}}</td>
                        <td>{{round($registro->calificacion_parcial_anterior, 2)}}</td>
                        <td>{{round($registro->calificacion_parcial_actual, 2)}}</td>
                        <td>{{$registro->lectivo}}</td>
                        <td>{{$registro->fec_inicio}}</td>
                        <td>{{$registro->fec_fin}}</td>
                        <td>{{$registro->created_at}}</td>
                        <td>{{$registro->usu_alta}}</td>
                    </tr>
                    
                @endforeach
                    
                    
            </tbody>
        </table>
    </div>
    
  </body>
</html>

