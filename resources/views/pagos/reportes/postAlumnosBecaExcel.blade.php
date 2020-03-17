<html>
  <head>
      
  </head>
  <body>
      <h3>Pagos del Plantel {{$plantel->razon}} el dia {{$data['fecha_f']}}</h3>
    <div class="datagrid">
      @php
          //dd($resumen);
      @endphp
      @if(isset($registros) and count($registros)>0)
      <h4>Resumen</h4>
      <table class="table table-condensed table-striped">
        <thead>
            
            <th>Especialidad</th><th>Cantidad Alumnos</th><th>Suma Descuentos</th>
            
        </thead>
        <tbody>
          @php
          $total_descuentos=0;
          $total_cantidad=0;
          @endphp
          @foreach($resumen as $linea)
          <tr>
            <td> {{ $linea['especialidad'] }} </td><td> {{ $linea['cantidad'] }} </td><td> {{ $linea['suma_descuentos'] }} </td>
          </tr>
          @php
           $total_descuentos=$total_descuentos+$linea['suma_descuentos'];
           $total_cantidad=$total_cantidad+$linea['cantidad'];   
          @endphp
          @endforeach
          <tr>
            <td> <strong>Totales</strong>  </td><td> <strong>{{ $total_cantidad }}</strong> </td><td> <strong>{{ $total_descuentos }}</strong>  </td>
          </tr>
        </tbody>
      </table>
        <br/>
        <h4>Detalle</h4>
        <table class="table table-condensed table-striped">
            <thead>
                <tr>
                    <th>Especialidad</th><th>Nivel</th><th>Grado</th><th>Cliente</th><th>Estatus Cliente</th><th>Estatus Seguimiento</th><th>Becado</th><th>Justificacion</th><th>monto inscripcion</th><th>monto mensualidad</th><th></th>
                </tr> 
            </thead>
            <tbody>
                <?php 
                $i=0; 
                $j=0;
                $total_monto=0;
                $suma_total=0
                ?>
                <?php $colaborador="" ?>
                @foreach($registros as $registro)
                    
                    <tr>
                        <td>{{ $registro['especialidad'] }}</td>
                        <td>{{ $registro['nivel'] }}</td>
                        <td>{{ $registro['grado'] }}</td>
                        <td>{{$registro['cliente']}} - {{$registro['cliente_nombre']}}</td>
                        <td>{{$registro['estatus_cliente']}}</td><td>{{$registro['estatus_seguimiento']}}</td>
                        <td>
                            @if($registro['beca_bnd']==1)
                                SI
                            @else
                                NO
                            @endif
                        </td>
                        <td>{{$registro['justificaion']}}</td>
                        <td>{{$registro['monto_inscripcion']}}</td>
                        <td>{{$registro['monto_mensualidad']}}</td>
                        <td>
                            <?php $cajas=App\Caja::select('cajas.consecutivo','cc.name as concepto','ln.subtotal','ln.descuento','ln.recargo','ln.total','a.fecha_pago')
                                                ->where('cajas.cliente_id',$registro['cliente'])
                                                 ->join('caja_lns as ln','ln.caja_id','=','cajas.id')
                                                 ->join('caja_conceptos as cc','cc.id','=','ln.caja_concepto_id')
                                                 ->join('adeudos as a', 'a.id','=','ln.adeudo_id')
                                                 ->where('a.fecha_pago','>=',$data['fecha_f'])
                                                 ->where('a.fecha_pago','<=',$data['fecha_t'])
                                                 ->where('ln.promo_plan_ln_id',0)
                                                 ->where('ln.descuento','>',0)
                                                 ->get();
                                    ?>
                            @if(count($cajas)>0)
                            <table>
                                <thead>
                                    <tr><th>Caja</th><th>Fecha Planeada</th><th>Concepto</th><th>Subtotal</th><th>Descuento</th><th>Recargo</th><th>Total</th></tr>
                                </thead>
                                <tbody>
                                    @foreach($cajas as $ln)
                                    <tr>
                                        <td>{{$ln->consecutivo}}</td><td>{{$ln->fecha_pago}}</td><td>{{$ln->concepto}}</td><td>{{$ln->subtotal}}</td><td>{{$ln->descuento}}</td>
                                        <td>{{$ln->recargo}}</td><td>{{$ln->total}}</td>
                                    </tr>
                                        
                                    @endforeach
                                    
                                        
                                    
                                </tbody>
                            </table>
                            @endif
                            
                        </td>
                    </tr>
                    
                    
                    
                @endforeach
                    
<!--                    <tr>
                        <td><strong>Total</strong></td><td colspan="5"><strong><strong></td><td colspan="2"><strong>{{number_format(0)}}</strong></td>
                    </tr>-->
            </tbody>
        </table>
        @endif
        
    </div>
