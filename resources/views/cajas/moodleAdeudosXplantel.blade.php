@php header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
@endphp
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
        @if(isset($message))
        <div class="alert alert-warning">
            {{ $message }}
        </div>
        @endif
        <div class="col-md-12">
            @if(isset($registros) and count($registros)>0)
        <table class="table table-condensed table-striped">
            <thead>
                <tr>
                    <th>Moodle</th><th>Plantel</th><th>Especialidad</th><th>Grupo</th><th>Cliente</th><th>St Cliente</th><th>St Seguimiento</th><th>Concepto</th><th>Fecha Pago</th><th>Pagado</th><th>St Caja</th><th>Fecha Pago</th><th>Monto</th>
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
                    
                    <tr>
                        <td>
                            @php
                            $bajas=\App\MoodleBaja::where('cliente_id',$registro['cliente_id'])
                            ->where('bnd_baja',1)
                            ->where('bnd_alta',0)
                            ->first();
                            @endphp
                            @permission('moodleBajas.procesarUno')
                            @if(is_null($bajas))
                            <a href="{{ route('moodleBajas.procesarUno',array('cliente'=>$registro['cliente_id'])) }}" data-cliente={{ $registro['cliente_id'] }} class="btn btn-xs btn-success btn-baja">S. Baja</a>
                            <button  data-cliente={{ $registro['cliente_id'] }} class="btn btn-xs btn-success btn-baja">BS. Baja</button>
                            @else
                            <a href="{{ route('moodleBajas.procesarUnoAlta',array('id'=>$bajas->id)) }}" data-baja={{ $bajas->id }} class="btn btn-xs btn-info btn-alta">S. Alta</a>
                            @endif
                            @endpermission

                            
                        </td>
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
                        <td><strong>Total</strong></td><td colspan="10"><strong>{{$j}}<strong></td><td style="align:right;"><strong>{{number_format($suma_total,2)}}</strong></td>
                    </tr>
            </tbody>
        </table>
        @endif
        </div>
    </div>

@endsection

@push('scripts')
<script src="{{ asset('bower_components\AdminLTE\plugins\JavaScript-MD5-2.14.0\js\md5.min.js') }}"></script>
<script type="text/javascript">

    
$('.btn-baja').click(function(e){
    e.preventDefault();
    var d = new Date();
    var n = d.getDate('Ymd');
    //alert(n);
    var salt="SbSkhl0XvctpPUscgLNg";

    $.ajax({
        type: 'GET',
                url: '{{ route('moodleBajas.procesarUno') }}',
                cache:true,
                data: {
                    'method':'changeUserStatus' ,
                    'key': md5(n+salt),
                    'username':"",
                    'active':false
                },
                dataType:"json",
                //jsonp: 'jsonp-callback',
                //beforeSend : function(){$("#loading3").show(); },
                //complete : function(){$("#loading3").hide(); },
                success: function(data) {
                    console.log('exito');
                    ele=data.split('{');
                    ele2=data.split(',')[0];
                    ele3=ele2.split(':');
                    console.log(ele3[1]);
                },
                error: function(data){
                    console.log('error');
                    ele=data.split('{');
                    ele2=data.split(',')[0];
                    console.log(ele2);
                }
        }); 
    
});

</script>
    
@endpush