<style>
    @media print {
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            text-align: left;
            padding: 8px;
            font: normal 12px Arial, Helvetica, sans-serif; 
            border: solid 1px #FE9A2E;
        }

        tr:nth-child(even){background-color: #f2f2f2}

        th {
            background-color: #FE9A2E;
            color: white;
            font-weight: bold;
        }
     }
    
    table {
        border-collapse: collapse;
        width: 100%;
    }

    th, td {
        text-align: center;
        padding: 8px;
        font: normal 12px Arial, Helvetica, sans-serif; 
        border: solid 1px #FE9A2E;
    }

    tr:nth-child(even){background-color: #f2f2f2}

    th {
        background-color: #FE9A2E;
        color: white;
    }
        
    body {
        font: normal 10px Arial, Helvetica, sans-serif; 
    }
</style>

<table width='100%'>
    <tr>
            <td align="center"  >
                <h3>
                    Adeudos
                </h3>
            </td>
        </tr>
</table>

<div class="datagrid">
    @if(isset($cliente))
    <?php $valores= collect(); $vfechas=collect();?>
    <div class="col-md-5" id="adeudos-lista">
        
                <h3>    
                        Adeudos-{{$cliente->nombre." ".$cliente->nombre2." ".$cliente->ape_paterno." ".$cliente->ape_materno}} - {{$cliente->stCliente->name}}
                        @if($cliente->beca_bnd==1)
                        - Becado
                        @endif
                </h3>
                
                <table class='table table-striped table-condensed' >
                    <tbody>
                        @php
                            $suma_pagos_reales=0;
                            $suma_adeudos=0;
                        @endphp
                        @foreach($combinaciones as $combinacion)
                        @if($combinacion->especialidad_id<>0 and $combinacion->nivel_id<>0 and $combinacion->grado_id<>0 and $combinacion->turno_id<>0)
                        <tr>
                            <td colspan='6'><strong>Grado:</strong>{{$combinacion->grado->name}}</td>
                            <td colspan='6'><strong>Beca:</strong>@if($combinacion->bnd_beca==1) SI @else NO @endif</td>
                        </tr>
                        <tr>
                        <table id='conceptos_predefinidos' class='table table-striped table-condensed'>
                            <thead>
                                <tr>
                                    
                                    <th>Concepto</th><th>Monto<th>Pagado</></th><th>Fecha</th><th>Ticket</th><th>Pagado</th><th>dias</th> 
                                </tr>
                            </thead>
                            <tbody>
                        <?php $regla_pago_seriado=0; ?>
                        @foreach($combinacion->adeudos as $adeudo)
                        <?php
                        $dias = date_diff(date_create(), date_create($adeudo->fecha_pago));
                        //dd($dias);
                        $dia = $dias->format('%R%a') * -1;
                        
                        ?>
                        <tr class="
                            @if($dia>15)
                            bg-red
                            @elseif($dia<=15)
                            bg-green
                            @endif
                            ">
                            
                            
                            <td class='editarAdeudo' data-adeudo='{{$adeudo->id}}' 
                                                     data-caja_concepto='{{$adeudo->caja_concepto_id}}' 
                                                     data-fecha_pago='{{$adeudo->fecha_pago}}' 
                                                     data-monto='{{$adeudo->monto}}'
                                                     >{{$adeudo->cajaConcepto->name}}</td>
                            <td class='editable'>
                                {{$adeudo->monto}}
                                
                            </td>
                            <td>
                                <?php
                                
                                $linea_caja= \App\CajaLn::where('adeudo_id',$adeudo->id)->whereNull('deleted_at')->first();    
                                ?>
                                @if(count($linea_caja)>0)
                                {{$linea_caja->total}}
                                @php
                                    $suma_pagos_reales=$suma_pagos_reales+$linea_caja->total;
                                @endphp
                                @else
                                @php
                                    $suma_adeudos=$suma_adeudos+$adeudo->monto;
                                @endphp    
                                @endif
                            </td>
                            
                            <td>{{$adeudo->fecha_pago}}</td>
                            
                            <td class="bg-gray">
                                @if($adeudo->caja->consecutivo==0)
                                {{$adeudo->caja->consecutivo}}
                                @else
                                {{$adeudo->caja->consecutivo}}
                                @endif
                            </td>
                            @if($adeudo->pagado_bnd==1) 
                                <td> 
                            @else 
                                <td class="bg-yellow"> 
                                <?php $regla_pago_seriado=1;?>
                            @endif
                                @if($adeudo->pagado_bnd==1) SI @else NO @endif</td>
                            <td>{{$dia}}</td>
	
                        </tr>
        		<?php
                foreach($combinacion->adeudos as $adeudo){
                        $valores->push($adeudo->caja_concepto_id);
                        $vfechas->push(optional($adeudo->caja)->fecha);
                }
                ?>                
                        @endforeach
                        @endif
                        
                        @endforeach
                        </tr>
                        </tbody>
                        </table>
    <br>                    
                        <table id='conceptos_predefinidos' class='table table-striped table-condensed'>
                            <thead>
                                <tr>
                                    <th>Concepto</th><th>Fecha</th><th>Monto</th><th>Caja</th><th>Estatus</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    //dd($vfechas);
                                    $marcador=0;
                                @endphp
                                @foreach($cajas as $ln)
                                    @if(isset($valores))
                                    @if(!is_int($valores->search($ln->concepto_id)) or !is_int($vfechas->search($ln->fecha)))
                                    @php
                                        $marcador=1;
                                    @endphp

                                    <tr>    
                                    <td> {{$ln->concepto}}</td> <td>{{$ln->fecha}}</td> <td>{{$ln->total}}</td><td>{{$ln->caja}}</td><td>{{$ln->estatus}}</td>
                                    @php
                                        $suma_pagos_reales=$suma_pagos_reales+$ln->total;
                                    @endphp
                                    </tr>
                                    
                                    @endif

                                    @endif
                                @endforeach
                                @if($marcador==0)
                                <tr>    
                                    <td colspan="5"> Sin registros  </td>
                                </tr>
                                @endif
                                
                            </tbody>
                        </table>
                    </tbody>
                </table>
<br>
                <table>
                    <thead>
                    <th>Suma Pagos</th><td>{{$suma_pagos_reales}}</td><th>Suma Adeudos</th><td>{{$suma_adeudos}}</td>
                    </thead>
                </table>
        </div>
    </div>
    @endif
    
</div>

