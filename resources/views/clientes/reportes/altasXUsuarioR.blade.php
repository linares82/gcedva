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
        <h3>Consulta de Altas por Usuario del {{$filtros['fecha_f']}} al {{$filtros['fecha_t']}}</h3>
        <table class="table table-condensed table-striped">
            <thead>
                <th>Plantel</th><th>Colaborador</th><th>Altas</th>
            </thead>
            <tbody>
                <?php 
                $plantel=""; 
                $total_plantel=0;
                $total=0;
                ?>
                @foreach($resultados as $resultado)
                @if($plantel<>$resultado->razon and $total_plantel>0)
                <tr><td colspan="2"><strong>Total del Plantel</strong></td><td><strong>{{$total_plantel}}</strong></td</tr>
                <?php $total_plantel=0; ?>
                @endif
                <tr>
                    <?php $empleado=\App\Empleado::find($resultado->id); ?>
                    <td>{{ $resultado->razon }}</td><td>{{$empleado->nombre." ".$empleado->ape_paterno." ".$empleado->ape_materno}}</td><td>{{$resultado->total_usuario}}</td>
                </tr>
                <?php 
                    $plantel=$resultado->razon;
                    $total_plantel=$total_plantel+$resultado->total_usuario;
                    $total=$total+$resultado->total_usuario;
                ?>
                @endforeach
                <tr><td colspan="2"><strong>Total del Plantel</strong></td><td><strong>{{$total_plantel}}</strong></td</tr>
                <tr><td colspan="2"><strong>Total</strong></td><td><strong>{{$total}}</strong></td</tr>
            </tbody>
        </table>
    </div>
    
  </body>
</html>
