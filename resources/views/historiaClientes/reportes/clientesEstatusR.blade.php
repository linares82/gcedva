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
        <h3>Consulta de eventos del {{$datos['fecha_f']}} al {{$datos['fecha_t']}}</h3>
        <table class="table table-condensed table-striped">
            <thead>
              <th>No.</th>
              <th>Evento</th><th>Plantel</th><th>Seccion</th><th>Grado</th><th>F. Aplicacion</th><th>Alumno</th>
              <th>Fecha</th><th>Estatus Cliente</th><th>Direccion</th><th>Tel. Fijo</th><th>Tel. Cel.</th>
              <th>D. Baja</th>
              <th>U. Pago</th><th>Reactivacion/F. Ultima</th>
            </thead>
            <tbody>
                <?php 
                $cont=0; 
                $grado="";
                $grado_contador=0;
                $plantel="";
                $plantel_contador=0;
                ?>
                @foreach($registros as $registro)
                <tr>
                    
                    @if($grado<>$registro->grado and $grado<>"")
                    <tr><td colspan="4"><strong>Total Grado </strong></td><td><strong>{{$grado_contador}}</strong></td></tr>
                    @php
                        $grado_contador=0;
                    @endphp
                    @endif

                    @if($plantel<>$registro->razon and $plantel<>"")
                    <tr><td colspan="4"><strong>Total Plantel</strong></td><td><strong>{{$plantel_contador}}</strong></td></tr>
                      @php
                          $plantel_contador=0;
                      @endphp
                    @endif
                    <td>{{ ++$cont }}</td>
                    <td>{{$registro->evento}}</td>
                    <td>{{ $registro->razon }}</td><td>{{ $registro->seccion }}</td><td>{{ $registro->grado }}</td>
                    <td>{{ $registro->fec_autorizacion }}</td>
                    <td>{{$registro->cliente."-".$registro->nombre." ".$registro->ape_paterno." ".$registro->ape_materno}}</td>
                    <td>{{$registro->fecha}}</td><td>{{$registro->estatus}}</td>
                    <td>{{ $registro->calle }} {{ $registro->no_interior}}, Colonia {{ $registro->colonia }}, {{ $registro->municipio }},
                       {{ $registro->estado }}, CP {{ $registro->cp }}</td>
                    <td>{{ $registro->tel_fijo }}</td>
                    <td>{{$registro->tel_cel}}</td><td>{{$registro->descripcion}}</td>
                    @php
                    $uAdeudo=\App\Adeudo::where('cliente_id',$registro->cliente)->where('pagado_bnd', 1)->orderBy('id','desc')->first();
                    @endphp
                    
                    <td>
                      @if(!is_null($uAdeudo))
                      {{$uAdeudo->cajaConcepto->name}}
                      @endif
                    </td>
                    <td>{{ $registro->reactivado }} / {{ $registro->fec_reactivado }}</td>
                    @php
                        $grado=$registro->grado;
                        $grado_contador++;
                        $plantel=$registro->razon;
                        $plantel_contador++;
                    @endphp
                </tr>
                
                @endforeach
                <tr><td colspan="4"><strong>Total Grado </strong></td><td><strong>{{$grado_contador}}</strong></td></tr>
                <tr><td colspan="4"><strong>Total Plantel</strong></td><td><strong>{{$plantel_contador}}</strong></td></tr>
                <tr><td colspan="4"><strong>Total</strong></td><td><strong>{{$cont}}</strong></td></tr>
            </tbody>
        </table>
    </div>
    
  </body>
</html>
