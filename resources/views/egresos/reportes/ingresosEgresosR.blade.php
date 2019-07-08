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
        <h3>Consulta Ingresos y Egresos</h3>
        <table class="table table-condensed table-striped">
            <thead>
                <th>Cuenta Efectivo</th><th>Plantel</th><th>Egreso</th><th>Concepto</th><th>Caja</th><th>Transferencia</th><th>Fecha</th><th>Monto Egreso</th><th>Monto Ingreso</th>
            </thead>
            <tbody>
                <?php 
                $cuenta=0; 
                $total_cuenta=0;
                $total=0;
                $total_egreso=0;
                $total_ingreso=0;
                $total_cuenta_egreso=0;
                $total_cuenta_ingreso=0;
                ?>
                @foreach($registros as $registro)
                @if($cuenta<>$registro->id and ($total_cuenta_egreso>0 or $total_cuenta_ingreso>0))
                <?php 
                    $cuenta_efectivo= App\CuentasEfectivo::find($cuenta);
                ?>
                @if($cuenta_efectivo->saldo_inicial>0)
                    <tr><td colspan='7'>Saldo Inicial - {{$cuenta_efectivo->fecha_saldo_inicial}}</td><td>0</td><td>{{$cuenta_efectivo->saldo_inicial}}</td></tr>
                @else
                    <tr><td colspan='7'>Saldo Inicial - {{$cuenta_efectivo->fecha_saldo_inicial}}</td><td>{{$cuenta_efectivo->saldo_inicial}}</td><td>0</td></tr>
                @endif
                @if($cuenta_efectivo->saldo_actualizado>0)
                    <tr><td colspan='7'>Saldo Actualizado</td><td>0</td><td>{{$cuenta_efectivo->saldo_actualizado}}</td></tr>
                @else
                    <tr><td colspan='7'>Saldo Actualizado</td><td>{{$cuenta_efectivo->saldo_actualizado}}</td><td>0</td></tr>
                @endif
                <tr><td colspan="7"><strong>Total del Cuenta</strong></td><td><strong>{{$total_cuenta_egreso}}</strong></td><td>{{$total_cuenta_ingreso}}</td></tr>
                
                <?php $total_cuenta_egreso=0; 
                      $total_cuenta_ingreso=0
                ?>
                @endif
                <tr>
                    @if($registro->egreso_id==0 and $registro->pago_id==0 and $registro->concepto=='Transferencia:ingreso')
                        <td>{{ $registro->cuenta }}</td><td>{{$registro->razon}}</td><td>{{$registro->egreso_id}}</td><td>{{$registro->concepto}}</td><td>{{$registro->consecutivo_caja}}</td>
                        <td>{{$registro->transference_id}}</td><td>{{$registro->fecha}}</td><td>0</td><td>{{$registro->monto}}</td>
                        <?php 
                        $total_ingreso=$total_ingreso+$registro->monto;
                        $total_cuenta_ingreso=$total_cuenta_ingreso+$registro->monto;
                        ?>
                    @elseif($registro->egreso_id==0 and $registro->pago_id==0 and $registro->concepto=='Transferencia:egreso')
                        <td>{{ $registro->cuenta }}</td><td>{{$registro->razon}}</td><td>{{$registro->egreso_id}}</td><td>{{$registro->concepto}}</td><td>{{$registro->consecutivo_caja}}</td>
                        <td>{{$registro->transference_id}}</td><td>{{$registro->fecha}}</td><td>{{$registro->monto}}</td><td>0</td>
                        <?php 
                        $total_egreso=$total_egreso+$registro->monto;
                        $total_cuenta_egreso=$total_cuenta_egreso+$registro->monto;
                        ?>
                    @elseif($registro->egreso_id==0)
                        <td>{{ $registro->cuenta }}</td><td>{{$registro->razon}}</td><td>{{$registro->egreso_id}}</td><td>{{$registro->concepto}}</td><td>{{$registro->consecutivo_caja}}</td>
                        <td>{{$registro->transference_id}}</td><td>{{$registro->fecha}}</td><td>0</td><td>{{$registro->monto}}</td>
                        <?php 
                        $total_ingreso=$total_ingreso+$registro->monto;
                        $total_cuenta_ingreso=$total_cuenta_ingreso+$registro->monto;
                        ?>
                    @else
                        <td>{{ $registro->cuenta }}</td><td>{{$registro->razon}}</td><td>{{$registro->egreso_id}}</td><td>{{$registro->concepto}}</td><td>{{$registro->consecutivo_caja}}</td>
                        <td>{{$registro->transference_id}}</td><td>{{$registro->fecha}}</td><td>{{$registro->monto}}</td><td>0</td>
                        <?php 
                        $total_egreso=$total_egreso+$registro->monto;
                        $total_cuenta_egreso=$total_cuenta_egreso+$registro->monto;
                        ?>
                    @endif
                    
                </tr>
                <?php 
                    $cuenta=$registro->id;    
                    $total=$total+$registro->monto;
                ?>
                @endforeach
                <?php 
                    $cuenta_efectivo= App\CuentasEfectivo::find($cuenta);
                ?>
                @if($cuenta_efectivo->saldo_inicial>0)
                    <tr><td colspan='7'>Saldo Inicial - {{$cuenta_efectivo->fecha_saldo_inicial}}</td><td>0</td><td>{{$cuenta_efectivo->saldo_inicial}}</td></tr>
                @else
                    <tr><td colspan='7'>Saldo Inicial - {{$cuenta_efectivo->fecha_saldo_inicial}}</td><td>{{$cuenta_efectivo->saldo_inicial}}</td><td>0</td></tr>
                @endif
                @if($cuenta_efectivo->saldo_actualizado>0)
                    <tr><td colspan='7'>Saldo Actualizado</td><td>0</td><td>{{$cuenta_efectivo->saldo_actualizado}}</td></tr>
                @else
                    <tr><td colspan='7'>Saldo Actualizado</td><td>{{$cuenta_efectivo->saldo_actualizado}}</td><td>0</td></tr>
                @endif
                <tr><td colspan="7"><strong>Total del Cuenta</strong></td><td><strong>{{$total_cuenta_egreso}}</strong></td><td>{{$total_cuenta_ingreso}}</td></tr>
                
                <tr><td colspan="7"><strong>Total</strong></td><td><strong>{{$total_egreso}}</strong></td><td>{{$total_ingreso}}</td></tr>
            </tbody>
        </table>
    </div>
    
  </body>
</html>
