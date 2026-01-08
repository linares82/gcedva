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
    <h1>Historia de cambios matricula</h1>
    <table>
      <thead><th>fecha</th><th>Campo</th><th>Responsable</th><th>Valor Anterior</th><th>Valor Nuevo</th></thead>
      <tbody>
        @foreach($cliente->revisionHistory as $history)
        
        @if($history->fieldName()=="matricula")
        <tr>
        <td>{{$history->created_at}}</td><td>{{$history->fieldName()}}</td><td>{{optional($history->userResponsible())->name}}</td><td>{{ $history->oldValue() }}</td><td>{{ $history->newValue() }}</td>  
        </tr>
        @endif



        @permission('clientes.historia')
        <tr>
        <td>{{$history->created_at}}</td><td>{{$history->fieldName()}}</td><td>{{optional($history->userResponsible())->name}}</td><td>{{ $history->oldValue() }}</td><td>{{ $history->newValue() }}</td>  
        </tr>
        @endpermission
        @endforeach
      </tbody>
    </table>
    
    <h1>Historia de cambios CURP</h1>
    <table>
      <thead><th>fecha</th><th>CURP anterior</th><th>CURP Nueva</th><th>Creado por</th></thead>
      <tbody>
        @foreach($cliente->hCurp as $curp)
            
            <tr>
            <td>{{$curp->created_at}}</td><td>{{$curp->curp_anterior}}</td><td>{{$curp->curp_nueva}}</td><td>{{ $curp->usu_alta->name }}</td>
            </tr>
            

            
        @endforeach
      </tbody>
  </body>
</html>
