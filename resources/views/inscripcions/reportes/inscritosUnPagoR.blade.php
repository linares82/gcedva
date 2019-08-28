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
      <h3>Inscritos por Asesor del {{$data['fecha_f']}} al {{$data['fecha_t']}}</h3>
    <div class="datagrid">
        <table class="table table-condensed table-striped">
            <thead>
                <tr>
                    <th></th><th>Asesor</th><th>Cliente</th><th>Especialidad</th><th>Fecha</th><th>Becado</th><th>Medio</th>
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
                    @if($colaborador<>$registro->colaborador and $i<>0)
                    <tr>
                        <td><strong>Suma Asesor</strong></td><td colspan="6"><strong>{{$i}}<strong></td>
                    </tr>
                    <?php 
                    $j=$i+$j;
                    $i=0;
                    ?>
                    @endif
                    
                    <tr>
                        <td>{{$contador_linea++}}</td>
                        <td>{{$registro->colaborador}}</td>
                        <td>{{$registro->id}} - {{$registro->cliente}}</td>
                        <td>{{$registro->especialidad}}</td>
                        <td>{{$registro->fecha}}</td>
                        <td>
                            @if($registro->beca_bnd==1)
                                SI
                            @else
                                NO
                            @endif
                        </td>
                        <td>{{$registro->medio}}</td>
                    </tr>
                    
                    <?php 
                    $colaborador=$registro->colaborador; 
                    $i++;
                    ?>
                @endforeach
                    <?php 
                    $j=$i+$j;
                    ?>
                    <tr>
                        <td><strong>Suma Asesor</strong></td><td colspan="6"><strong>{{$i}}<strong></td>
                    </tr>
                    <tr>
                        <td><strong>Total</strong></td><td colspan="6"><strong>{{$j}}<strong></td>
                    </tr>
            </tbody>
        </table>
    </div>
    
  </body>
</html>

