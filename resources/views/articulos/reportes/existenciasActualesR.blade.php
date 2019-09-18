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
      </style>
    
    
  </head>
  <body>
    <div class="datagrid">
        <h3>Consulta de Existencias</h3>
        <table class="table table-condensed table-striped">
            <thead>
                <th>Plantel</th><th>Articulo</th><th>Categoria</th><th>Existencias</th>
            </thead>
            <tbody>
                <?php 
                $plantel=""; 
                $total_plantel=0;
                $total=0;
                ?>
                @foreach($registros as $registro)
                
                <tr>
                    <td>{{ $registro->plantel }}</td><td>{{$registro->articulo}}</td><td>{{$registro->categoria}}</td><td>{{$registro->existencia}}</td>
                </tr>
                
                @endforeach
                
            </tbody>
        </table>
    </div>
    
  </body>
</html>
