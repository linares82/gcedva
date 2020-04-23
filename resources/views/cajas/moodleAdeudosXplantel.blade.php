@extends('plantillas.admin_template')

@include('cajas._common')

@section('header')

<div class="page-header">
        <h1>@yield('cajasAppTitle') / Adeudos Plantel {{$plantel->razon}}

        </h1>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            @if(isset($registros) and count($registros)>0)
        <table class="table table-condensed table-striped">
            <thead>
                <tr>
                    <th>Plantel</th><th>Especialidad</th><th>Grupo</th><th>Cliente</th><th>St Cliente</th><th>St Seguimiento</th><th>Concepto</th><th>Fecha Pago</th><th>Pagado</th><th>St Caja</th><th>Fecha Pago</th><th>Monto</th>
                </tr> 
            </thead>
            <tbody>
                <?php 
                $i=0; 
                $j=0;
                $total_monto=0;
                $suma_total=0;
                $grupo="";        
                ?>
                <?php $colaborador="" ?>
                @foreach($registros as $registro)
                    @if($grupo<>$registro['grupo'] and $i<>0)
                    <tr>
                        <td><strong>Suma Grupo</strong></td><td colspan="10"><strong>{{$i}}<strong></td><td style="align:right;"><strong>{{number_format($total_monto,2)}}</strong></td>
                    </tr>
                    <?php 
                    $j=$i+$j;
                    $i=0;
                    $total_monto=0;
                    ?>
                    @endif
                    <tr>
                        <td>{{$registro['razon']}}</td>
                        <td>{{$registro['especialidad']}}</td>
                        <td>{{$registro['grupo']}}</td>
                        <td><a href='{{route('seguimientos.show',$registro['seguimiento'])}}' target='_blank'> {{$registro['cliente']}} </a></td>
                        <td>{{$registro['st_cliente']}}</td>
                        <td>{{$registro['st_seguimiento']}}</td>
                        <td>{{$registro['concepto']}}</td>
                        
                        <td>{{$registro['fecha_pago']}}</td>
                        <td>
                            @if($registro['bnd_pagado']==1)
                                SI
                            @else
                                NO
                            @endif
                        </td>
                        <td>{{$registro['estatus_caja']}}</td>
                        <td>{{$registro['fecha_pago']}}</td>
                        <td style="align:right;">{{number_format($registro['total'],2)}}</td>
                        
                    </tr>
                    
                    <?php 
                    $grupo=$registro['grupo']; 
                    $i++;
                    $total_monto=$total_monto+$registro['total'];
                    $suma_total=$suma_total+$registro['total'];
                    ?>
                @endforeach
                    <?php 
                    $j=$i+$j;
                    ?>
                    <tr>
                        <td><strong>Suma Cliente</strong></td><td colspan="10"><strong>{{$i}}<strong></td><td style="align:right;"><strong>{{number_format($total_monto,2)}}</strong></td>
                    </tr>
                    <tr>
                        <td><strong>Total</strong></td><td colspan="10"><strong>{{$j}}<strong></td><td style="align:right;"><strong>{{number_format($suma_total,2)}}</strong></td>
                    </tr>
            </tbody>
        </table>
        @endif
        </div>
    </div>

@endsection