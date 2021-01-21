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
      <h3>Llamadas por Colaborador</h3>
    <div class="datagrid">
        <table class="table table-condensed table-striped">
            <thead>
                <tr>
                    <th></th><th>Plantel</th><th>Id Cliente</th><th>Cliente</th><th>Asunto</th><th>Detalle</th><th>Fecha</th><th>Hora</th><th>Usuario Alta</th>
                </tr> 
            </thead>
            <tbody>
                @php
                    $cuenta_llamadas=0;
                    $i=0;
                    $usu_alta="";
                @endphp
                @foreach($registros as $registro)
                    @if($usu_alta<>"" and $usu_alta<>$registro->usuario_alta)
                    <tr>
                        <td colspan="7"></td>
                        <td><strong>Total</strong></td>
                        <td><strong>{{ $cuenta_llamadas }}</strong></td>
                        @php
                            $cuenta_llamadas="";
                        @endphp
                    </tr>
                    @endif
                    <tr>
                        <td>{{ ++$i }}</td>
                        <td>{{$registro->razon}}</td>
                        <td>{{$registro->cliente_id}}</td>
                        <td>{{$registro->nombre}} {{$registro->nombre2}} {{$registro->ape_paterno}} {{$registro->ape_materno}}</td>
                        <td>{{$registro->asunto}}</td>
                        <td>{{$registro->detalle}}</td>
                        <td>{{$registro->fecha}}</td>
                        <td>{{$registro->hora}}</td>
                        <td>{{$registro->usuario_alta}}</td>
                        @php
                            $usu_alta=$registro->usuario_alta;
                            $cuenta_llamadas++;
                        @endphp
                    </tr>
                    
                @endforeach
                <tr>
                    <td colspan="7"></td>
                    <td><strong>Total</strong></td>
                    <td><strong>{{ $cuenta_llamadas }}</strong></td>
                    @php
                        $cuenta_llamadas="";
                    @endphp
                </tr> 
            </tbody>
        </table>
    </div>
    
  </body>
</html>

