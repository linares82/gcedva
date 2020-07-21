<html>
  <head>
      <style>
        h1, h5, h3, th { text-align: center; }
        table, #chart_div { margin: auto; font-family: Segoe UI; box-shadow: 10px 10px 5px #888; border: thin ridge grey; }
        th { background: #0046c3; color: #fff; max-width: 400px; padding: 5px 10px; }
        td { font-size: 11px; padding: 5px 20px; color: #000; }
        tr { background: #b8d1f3; }
        tr:nth-child(even) { background: #dae5f4; }
        tr:nth-child(odd) { background: #b8d1f3; }
      </style>
    
  </head>
  <body>
      <h3>Inscritos</h3>
    <div class="datagrid">
        <table class="table table-condensed table-striped">
            <thead>
                <tr>
                    <th></th><th>Plantel</th><th>Grado</th><th>Grupo</th>
                    <th>Total</th>
                </tr> 
            </thead>
            <tbody>
                <?php 
                $total=0; 
                ?>
                
                @foreach($registros as $registro)
                    
                    <tr>
                        <td>{{++$contador_linea}}</td>
                        <td>{{$registro->razon}} </td>
                        <td>{{$registro->grado}}</td>
                        <td>{{$registro->grupo}}</td>
                        <td>{{ $registro->total  }}</td>   
                    </tr>
                    
                    <?php 
                    $total=$registro->total+$total;
                    ?>
                @endforeach
                    <tr><td colspan="4"></td><td>{{ $total }}</td></tr>
            </tbody>
        </table>
        
    </div>
    
  </body>
</html>

