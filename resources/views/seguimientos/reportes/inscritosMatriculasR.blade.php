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
                    <th>No.</th><th>Cliente Id</th>
                    <th>Plantel</th><th>Carrera</th><th>Nombre(s)</th><th>Apellido Paterno</th><th>Apellido Materno</th><th>Matricula</th><th>Concepto</th>
                </tr> 
            </thead>
            <tbody>
                <?php 
                $i=0; 
                $grado="";
                $contador=0;
                ?>
                <?php $colaborador="" ?>
                @foreach($registros as $registro)    
                @if($grado<>"" and $grado<>$registro->grado)
                    <tr>
                        <td colspan="2"><strong> Cantidad Registros </strong> </td><td><strong>{{ $contador }}</strong> </td><td colspan="5"></td>
                    </tr>
                    @php
                        $contador=0;
                    @endphp
                @endif
                    <tr>
                        <td>{{ ++$i }}</td>
                        <td>{{$registro->id}}</td>
                        <td>{{$registro->plantel}}</td>
                        <td>{{$registro->grado}}</td>
                        <td>{{$registro->nombre}} {{$registro->nombre2}}</td>
                        <td>{{$registro->ape_paterno}}</td>
                        <td>{{$registro->ape_materno}}</td>
                        <td>{{$registro->matricula}}</td>
                        <td>{{$registro->concepto}}</td>
                        @php
                            $grado=$registro->grado;
                            $contador++;
                        @endphp
                    </tr>
                @endforeach
                <tr>
                    <td colspan="2"><strong> Cantidad Registros </strong> </td><td><strong>{{ $contador }}</strong> </td><td colspan="5"></td>
                </tr>
            </tbody>
        </table>
    </div>
    
  </body>
</html>

