@extends('plantillas.admin_template')

@include('muebles._common')

@section('header')
<link rel="stylesheet" type="text/css" href="{{asset('transfer/icon_font/css/icon_font.css')}}" />
<link rel="stylesheet" type="text/css" href="{{asset('transfer/css/jquery.transfer.css')}}" />


<ol class="breadcrumb">
    <li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
    <li><a href="{{ route('muebles.index') }}">@yield('mueblesAppTitle')</a></li>
    <li class="active">Crear</li>
</ol>

<div class="page-header">
    <h3><i class="glyphicon glyphicon-plus"></i> @yield('mueblesAppTitle') / Trasferencia de Muebles </h3>
</div>
@endsection

@section('content')
@include('error')

<div class="row">
    <div class="col-md-12">

        {!! Form::open(array('route' => 'muebles.resguardosR', 'id'=>'frm_reporte')) !!}
        <div class="form-group col-md-6 @if($errors->has('responsable_destino')) has-error @endif">
            <label for="responsable_destino">Responsable Destino</label>
            {!! Form::select("responsable_destino", $responsables, null, array("class" => "form-control select_seguridad", "id" => "responsable_destino")) !!}
        </div>
        <div class="form-group col-md-6 @if($errors->has('responsable_origen')) has-error @endif">
            <label for="responsable_origen">Responsable Origen</label>
            {!! Form::select("responsable_origen", $responsables, null, array("class" => "form-control select_seguridad", "id" => "responsable_origen")) !!}
        </div>

        

        <div class="col-md-6">
            <div id="transfer1" class="transfer-demo"></div>
        </div>


        <div class="row">
        </div>
        
        {!! Form::close() !!}

    </div>
</div>
@endsection

@push('scripts')
<script type="text/javascript" src="{{asset('transfer/js/jquery.transfer.js')}}"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#responsable_origen').change(function() {
            if($('#responsable_destino option:selected').val()==0){
                alert('Defina un responsable destino');
            }else{
                $.ajax({
                url: '{{ route("muebles.consultaBienesXResponsable") }}',
                type: 'GET',
                data: {
                    'responsable_origen': $('#responsable_origen option:selected').val(),
                },
                dataType: 'json',
                beforeSend: function() {
                    $("#loading1").show();
                },
                complete: function() {
                    $("#loading1").hide();
                },
                success: function(data) {
                    console.log(data);
                    var settings1 = {
                        "dataArray": data,
                        "itemName": "articulo",
                        "valueName": "id",
                        "callable": function(items) {
                            console.dir(items)
                            $.ajax({
                                url: '{{ route("muebles.transferenciaMueblesR") }}',
                                type: 'GET',
                                data: {
                                    'responsable_destino': $('#responsable_destino option:selected').val(),
                                    'muebles':items,
                                },
                                dataType: 'json',
                                success: function(data) {
                                    $('#responsable_origen').val($('#responsable_destino option:selected').val()).trigger('change');
                                }
                            });

                        }
                    };
                    $("#transfer1").html("");
                    $("#transfer1").transfer(settings1);
                }
            });
            }
           

        });
    });
</script>
@endpush