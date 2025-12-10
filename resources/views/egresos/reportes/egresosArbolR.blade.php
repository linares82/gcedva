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
        <h3>Consulta Egresos</h3>

        <table class="table table-condensed table-striped">
            <thead>
                <th></th><th>Plantel</th><th>Fecha</th><th>Concepto</th>
                @foreach($conceptos1 as $concepto1)
                    <th>{{ $concepto1->name }}</th>
                @endforeach
            </thead>
            <tbody>
              @php
                $no_padre=0;
              @endphp
              @foreach($resultado as $padre)
                @if(count($padre['detalle'])>0)    
                        <?php $consecutivo_linea=1; 
                        $total=0;?>
                        @foreach($padre['detalle']  as $egreso)
                        <tr>
                            <td>{{$consecutivo_linea++}}</td><td>{{$egreso->plantel->razon}}</td><td>{{$egreso->fecha}}</td><td>{{$egreso->egresosConcepto->name}}</td>
                            @foreach($conceptos1 as $concepto1)
                                @if($egreso->egresosConcepto->padre==$concepto1->id)
                                  <td align="right">{{number_format($egreso->monto,2)}}</td>
                                @else
                                <td></td>
                                @endif
                            @endforeach 
                        </tr>
                        <?php $total=$egreso->monto+$total?>
                        @endforeach
                        <tr><td colspan="{{ $no_padre+4 }}"></td><td align="right">{{number_format($total,2)}}</strong></td></tr>
                @endif
                @php
                  $no_padre++;
                @endphp
              @endforeach      
            </tbody>
        </table>


        @foreach($resultado as $padre)
          
        <h5>{{ $padre['padre'] }}</h5>
        @if(count($padre['detalle'])>0)    
            <table class="table table-condensed table-striped">
            <thead>
                <th></th><th>Plantel</th><th>Fecha</th><th>Concepto</th><th>Monto</th><!--<th>Detalle</th><th>Forma Pago</th><th>Cuenta Efectivo</th><th>Responsable</th>-->
            </thead>
            <tbody>
                <?php $consecutivo_linea=1; 
                $total=0;?>
                @foreach($padre['detalle']  as $egreso)
                <tr>
                    <td>{{$consecutivo_linea++}}</td><td>{{$egreso->plantel->razon}}</td><td>{{$egreso->fecha}}</td><td>{{$egreso->egresosConcepto->name}}</td><td align="right">{{number_format($egreso->monto,2)}}</td>
                    <!--<td>{{$egreso->detalle}}</td><td>{{$egreso->formaPago->name}}</td><td>{{$egreso->cuentasEfectivo->name}}</td>
                    <td>{{$egreso->empleado->nombre}} {{$egreso->empleado->ape_paterno}} {{$egreso->empleado->ape_materno}}</td>-->
                </tr>
                <?php $total=$egreso->monto+$total?>
                @endforeach
                <tr><td colspan="4"><strong>Total</strong></td><td><strong>{{number_format($total,2)}}</strong></td></tr>
            </tbody>
        </table>
          
        @else
          Sin datos
        @endif
          
          
        @endforeach

        
    </div>
    
  </body>
</html>
