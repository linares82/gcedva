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
        <h3>Lista de Clientes</h3>
        <table class="table table-condensed table-striped">
            <thead>
                <th>No.</th><th>Id</th>
                <th>Nombre(s)</th><th>Apellido Paterno</th><th>Apellido Materno</th><th>Matricula</th><th>Género</th><th>Fecha Nacimiento</th>
                <th>Correo Electronico</th><th>Tel. Fijo</th><th>Tel. Celular</th><th>CURP</th><th>Nombre Padre o Tutor</th><th>Tel.</th><th>Dirección</th>
            </thead>
            <tbody>
                @php
                    $i=1;
                @endphp
                @foreach($registros as $resultado)
                <tr>
                <td>{{$i++}}</td><td>{{$resultado->id}}</td>
                    <td>{{ $resultado->nombre }} {{ $resultado->nombre2 }}</td><td>{{$resultado->ape_paterno}}</td><td>{{$resultado->ape_materno}}</td>
                    <td>{{$resultado->matricula}}</td><td>{{$resultado->genero}}</td><td>{{$resultado->fec_nacimiento}}</td>
                    <td>{{$resultado->mail}}</td><td>{{$resultado->tel_fijo}}</td><td>{{$resultado->tel_cel}}</td><td>{{$resultado->curp}}</td>
                    @if($resultados->nombre_padre)
                    <td>{{$resultado->nombre_padre}}</td><td>{{$resultado->tel_padre}}</td><td>{{$resultado->dir_padre}}</td>
                    @elseif($resultados->nombre_madre)
                    <td>{{$resultado->nombre_madre}}</td><td>{{$resultado->tel_madre}}</td><td>{{$resultado->dir_madre}}</td>
                    @elseif($resultados->nombre_acudiente)
                    <td>{{$resultado->nombre_acudiente}}</td><td>{{$resultado->tel_acudiente}}</td><td>{{$resultado->dir_acudiente}}</td>
                    @else
                    <td></td><td></td><td></td>
                    @endif
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
  </body>
</html>
