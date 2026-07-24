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
      <h3>Inidencias</h3>
    <div class="datagrid">
        <table class="table table-condensed table-striped">
            <thead>
                <tr>
                    <th></th><th>Plantel</th><th>Cliente</th><th>Materia</th><th>Calificacion Nueva</th><th>Lectivo</th>
                    <th>Autorizada</th><th>Fecha</th><th>Justificacion</th>
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
                        <td>{{$registro->cliente_id}} - {{$registro->nombre}} {{$registro->nombre2}} {{$registro->ape_paterno}} {{$registro->ape_materno}}</td>
                        <td>{{$registro->materia}}</td>
                        <td>{{$registro->calificacion_nueva}}</td>
                        <td>{{$registro->lectivo}}</td>
                        <td>
                            @if($registro->bnd_autorizada==1)
                            SI
                            @else
                            NO
                            @endif
                        </td>
                        
                        <td>{{$registro->fecha_ar}}</td>
                        <td>{{$registro->justificacion}}</td>
                    </tr>
                    
                    
                @endforeach
                    
                    
            </tbody>
        </table>
    </div>
    
  </body>
</html>

