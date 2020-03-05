@extends('plantillas.admin_template')

@include('cajaCortes._common')

@section('header')

	<ol class="breadcrumb">
		<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li><a href="{{ route('cajaCortes.index') }}">@yield('cajaCortesAppTitle')</a></li>
	    <li class="active">Crear</li>
	</ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-plus"></i> @yield('cajaCortesAppTitle') / Crear </h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">
            
            @if(isset($pagos) and isset($egresos))
            <div class="row">
               <div class='col-md-6'>
                <div class="box box-info collapsed-box">
                    <div class="box-header">
                        <h4>Pagos</h4>
                        <div class="pull-right box-tools">
                            <button class="btn btn-primary btn-sm pull-right" data-widget="collapse" data-toggle="tooltip" title="" style="margin-right: 5px;" data-original-title="Collapse"><i class="fa fa-minus"></i></button>
                        </div>   
                    </div>
                    <div class="box-body">
                        <table class="table table-condensed table-striped">
                            <thead>
                                <th>Plantel</th><th>Caja</th><th>Monto</th><th>Forma Pago</th><th>Creado Por</th><th>Creado El</th>
                            </thead>
                            <tbody>
                                @php
                                    $suma_pagos=0;
                                @endphp
                                @foreach($pagos as $pago)
                                <tr>
                                <td>{{$pago->plantel}}</td><td>{{$pago->consecutivo}}</td><td>{{number_format($pago->monto,2)}}</td><td>{{$pago->forma_pago}}</td>
                                <td>{{$pago->user}}</td><td>{{$pago->created_at}}</td>
                                </tr>
                                @php
                                    $suma_pagos=$suma_pagos+$pago->monto;
                                @endphp
                                @endforeach
                                
                            </tbody>
                        </table>
                    </div>
                </div>
                
               </div> 
               <div class='col-md-6'>
                <div class="box box-info collapsed-box">
                    <div class="box-header">
                        <h4>Egresos</h4>  
                        <div class="pull-right box-tools">
                            <button class="btn btn-primary btn-sm pull-right" data-widget="collapse" data-toggle="tooltip" title="" style="margin-right: 5px;" data-original-title="Collapse"><i class="fa fa-minus"></i></button>
                        </div>       
                    </div>
                    <div class="box-body">
                        <table class="table table-condensed table-striped">
                            <thead>
                                <th>Plantel</th><th>Egreso</th><th>Monto</th><th>Forma Pago</th><th>Creado Por</th><th>Creado El</th>
                            </thead>
                            <tbody>
                                @php
                                    $suma_egresos=0;
                                @endphp
                                @foreach($egresos as $egreso)
                                <tr>
                                <td>{{$egreso->plantel}}</td><td>{{$egreso->id}}</td><td>{{number_format($egreso->monto,2)}}</td><td>{{$egreso->forma_pago}}</td>
                                <td>{{$egreso->user}}</td><td>{{$egreso->created_at}}</td>
                                </tr>
                                @php
                                    $suma_egresos=$suma_egresos+$egreso->monto;
                                @endphp
                                @endforeach
                                
                            </tbody>
                        </table>
                    </div>
                </div>
                
                
                
                </div> 
            </div>

            <div class="col-md-12">
            
                @if(isset($pagos) and isset($egresos))
                <div class="row">
                   <div class='col-md-6'>
                    <div class="box box-info">
                        <div class="box-header">
                            <h4>Total Pagos: {{number_format($suma_pagos,2)}}</h4>   
                        </div>
                        
                        
                    </div>
                    
                   </div> 
                   <div class='col-md-6'>
                    <div class="box box-info">
                        <div class="box-header">
                            <h4>Total Egresos: {{number_format($suma_egresos,2)}}</h4>      
                        </div>
                        
                    </div>
                    
                    
                    
                    </div> 
            </div>
            @endif
            
            <div class='col-md-12'>
                <div class="box box-info">
                    <div class="box-header">
                        <h4>Ultimo Corte</h4>
                    </div>
                    <div class="box-body">
                        <table class="table table-condensed table-striped">
                            <thead>
                                <th>id</th><th>Monto Calculado</th><th>Monto Real</th><th>Faltante</th><th>Sobrante</th><th>Alta Por</th><th>Creado El</th>
                            </thead>
                            <tbody>
                                @if(isset($vUltimoCorte))
                                <td>{{$vUltimoCorte['id']}}</td><td>{{$vUltimoCorte['monto_calculado']}}</td><td>{{$vUltimoCorte['monto_real']}}</td>
                                <td>{{$vUltimoCorte['faltante']}}</td><td>{{$vUltimoCorte['sobrante']}}</td><td>{{$vUltimoCorte['usu_alta']}}</td><td>{{$vUltimoCorte['created_at']}}</td>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
            
            
            @endif

            {!! Form::open(array('route' => 'cajaCortes.store')) !!}

            @include('cajaCortes._form')

                <div class="row">
                </div>
                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">Crear</button>
                    <a class="btn btn-link pull-right" href="{{ route('cajaCortes.index') }}"><i class="glyphicon glyphicon-backward"></i> Regresar</a>
                </div>
            {!! Form::close() !!}

        </div>
    </div>
@endsection

@push('scripts')
<script type="text/javascript">
    $(document).ready(function() {
        

        $('#monto_real-field').keyup(function(){
            $resta=0;
            if(
                $('#monto_calculado-field').val()>$('#monto_real-field').val() && 
                $('#monto_calculado-field').val()>0 && $('#monto_real-field').val()>0
            ){
                $resta=parseFloat($('#monto_calculado-field').val())-parseFloat($('#monto_real-field').val());
            }else if(
                $('#monto_calculado-field').val()<$('#monto_real-field').val() && 
                $('#monto_calculado-field').val()>0 && $('#monto_real-field').val()>0
            ){
                $resta=parseFloat($('#monto_real-field').val())-parseFloat($('#monto_calculado-field').val());
            }else if( 
                $('#monto_calculado-field').val()<0 && $('#monto_real-field').val()>0
            ){
                $resta=parseFloat($('#monto_real-field').val())+parseFloat($('#monto_calculado-field').val());
                
            }else if( 
                $('#monto_calculado-field').val()>0 && $('#monto_real-field').val()<0
            ){
                $resta=parseFloat($('#monto_calculado-field').val())+parseFloat($('#monto_real-field').val());
            }
            
            if($resta>0){
                $('#sobrante-field').val(parseFloat($resta)  + {{ $vUltimoCorte['sobrante'] }});
            }else if($resta<0){
                $('#faltante-field').val(parseFloat($resta) +{{ $vUltimoCorte['faltante'] }});
            }else{
                $('#sobrante-field').val(0);
                $('#faltante-field').val(0);
            }
        });
    });
</script>
@endpush