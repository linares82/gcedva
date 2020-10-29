@extends('plantillas.admin_template')

@include('facturaGenerals._common')

@section('header')

<ol class="breadcrumb">
	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
    <li><a href="{{ route('facturaGenerals.index') }}">@yield('facturaGeneralsAppTitle')</a></li>
    <li class="active">{{ $facturaGeneral->name }}</li>
</ol>

<div class="page-header">
        <h1>@yield('facturaGeneralsAppTitle') / Mostrar {{$facturaGeneral->id}}

            {!! Form::model($facturaGeneral, array('route' => array('facturaGenerals.destroy', $facturaGeneral->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? Estas seguro?')) { return true } else {return false };")) !!}
                <div class="btn-group pull-right" role="group" aria-label="...">
                    @permission('facturaGeneral.edit')
                    <a class="btn btn-warning btn-group" role="group" href="{{ route('facturaGenerals.edit', $facturaGeneral->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                    @endpermission
                    @permission('facturaGeneral.destroy')
                    <button type="submit" class="btn btn-danger">Borrar <i class="glyphicon glyphicon-trash"></i><
                    /button>
                    @endpermission
                </div>
            {!! Form::close() !!}

        </h1>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">

            <form action="#">
                <div class="form-group col-sm-4">
                    <label for="nome">ID</label>
                    <p class="form-control-static">{{$facturaGeneral->id}}</p>
                </div>
                <div class="form-group col-sm-4">
                     <label for="plantel_razon">PLANTEL</label>
                     <p class="form-control-static">{{$facturaGeneral->plantel->razon}}</p>
                </div>
                    <div class="form-group col-sm-4">
                     <label for="fec_inicio">F. INICIO</label>
                     <p class="form-control-static">{{$facturaGeneral->fec_inicio}}</p>
                </div>
                    <div class="form-group col-sm-4">
                     <label for="fec_fin">F. FIN</label>
                     <p class="form-control-static">{{$facturaGeneral->fec_fin}}</p>
                </div>
                    <div class="form-group col-sm-4">
                     <label for="uuid">UUID</label>
                     <p class="form-control-static">{{$facturaGeneral->uuid}}</p>
                </div>
            </form>

            <div class="row">
                </div>

            <a class="btn btn-link" href="{{ route('facturaGenerals.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>
            <a class="btn btn-success" href="{{ route('facturaGenerals.recargarLineas', $facturaGeneral->id) }}">  Recargar Lineas</a>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <table class="table table-condensed table-striped">
                <thead>
                    <th>No.</th><th>Cliente Id</th><th>Cliente</th><th>Fecha Pago</th><th>Caja</th><th>Concepto(s)</th><th>Monto Pago</th><th>UUID</th><th>Incluir</th>
                </thead>
                <tbody>
                    @foreach($lineas as $registro)
                    <tr>
                        <td>{{ ++$i }}</td>
                        <td>{{ $registro->cliente->id }}</td><td>{{ $registro->cliente->nombre }} {{ $registro->cliente->nombre2 }} {{ $registro->cliente->ape_paterno }} {{ $registro->cliente->materno }}</td>
                        <td>{{ $registro->pago->fecha }}</td><td>{{ $registro->caja->consecutivo }}</td>
                        <td>@foreach($registro->caja->cajaLns as $linea)
                            {{ $linea->cajaConcepto->name }} 
                            @endforeach
                        </td>
                        <td align="right">{{ number_format($registro->monto) }}</td><td>{{ $registro->pago->uuid }}</td>
                        <td>
                               
                            <label><input class="bnd_incluir" data-id_linea={{ $registro->id }} type="checkbox" 
                            @if($registro->bnd_incluido==1)
                            checked
                            @endif
                            value="1">Si</label>
                            <div class='loading' style='display: none'><img src="{{ asset('images/ajax-loader.gif') }}" title="Enviando" /></div>    
                        </td>
                    </tr>
                    @php
                        if($registro->bnd_incluido==1){
                            $suma=$suma+$registro->monto;
                        }
                        

                    @endphp
                    @endforeach
                    <tr>
                        <td colspan="6" align="right">Suma Total</td>
                        <td align="right">{{ number_format($suma,2) }}</td>
                        <td colspan="2">
                            <a href="{{ route('facturaGenerals.total', array('id'=>$facturaGeneral->id)) }}" class="btn btn-xs btn-warning btn-block" >Guardar y Recalcular</a>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="6"></td>
                        <td colspan="2">
                            <a href="{{ route('facturaGenerals.generarFactura', array('id'=>$facturaGeneral->id)) }}"  class="btn btn-xs btn-success btn-block" >Generar Factura</a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection

@push('scripts')
<script type="text/javascript">
$(document).on("click", ".bnd_incluir", function (e) {
    linea=$(this).data('id_linea');
    let valor=0;
    if($(this).is(':checked')){
        valor=1;
        
    }
    
    $.ajax({
        url: "{{ route('facturaGeneralLineas.bndIncluir') }}",
        type: 'GET',
        data: {'id':linea,
              'valor':valor},
        cache: false,
        beforeSend: function () {  
            $(".loading").show();
             
        },
        complete:function(){
            $(".loading").hide(); 
        },
        success: function (data) {
            
        },
        //si ha ocurrido un error
        error: function (data) {


        }
    });
})

</script>
@endpush