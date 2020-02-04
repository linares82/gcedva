@extends('plantillas.admin_template')

@include('seguimientos._common')

@section('header')

<ol class="breadcrumb">
    <li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
    <li><a href="{{ route('seguimientos.index') }}">@yield('seguimientosAppTitle')</a></li>
    <li class="active">Reporte de Seguimientos</li>
</ol>

<div class="page-header">
    <h3><i class="glyphicon glyphicon-plus"></i> @yield('seguimientosAppTitle') / Lista de Credenciales </h3>
</div>
@endsection

@section('content')
@include('error')

<div class="row">
    <div class="col-md-12">

        {!! Form::open(array('route' => 'clientes.listaCredencialesR', 'id'=>'frm_analitica')) !!}

        <div class="form-group col-md-6 @if($errors->has('plantel_f')) has-error @endif">
            <label for="plantel_f-field">Plantel de:</label>
            {!! Form::select("plantel_f", $list["Plantel"], null, array("class" => "form-control select_seguridad", "id" => "plantel_f-field")) !!}
            @if($errors->has("plantel_f"))
            <span class="help-block">{{ $errors->first("plantel_f") }}</span>
            @endif
        </div>

        <div class="form-group col-md-3 @if($errors->has('especialidad')) has-error @endif">
            <label for="especialidad-field">Especialidad</label>
            {!! Form::select("especialidad_id", $list["Especialidad"], null, array("class" => "form-control select_seguridad", "id" => "especialidad_id-field")) !!}
            <div id='loading10' style='display: none'><img src="{{ asset('images/ajax-loader.gif') }}" title="Enviando" /></div> 
            @if($errors->has("especialidad"))
            <span class="help-block">{{ $errors->first("especialidad") }}</span>
            @endif
        </div>

        <div class="form-group col-md-3 @if($errors->has('lectivo')) has-error @endif">
            <label for="lectivo-field">Lectivo</label>
            {!! Form::select("lectivo", $lectivos, null, array("class" => "form-control select_seguridad", "id" => "lectivo-field")) !!}
            <div id='loading10' style='display: none'><img src="{{ asset('images/ajax-loader.gif') }}" title="Enviando" /></div> 
            @if($errors->has("lectivo"))
            <span class="help-block">{{ $errors->first("especialidad") }}</span>
            @endif
        </div>

        <div class="form-group col-md-6 @if($errors->has('estatus_f')) has-error @endif">
            <label for="estatus_f-field">Estatus de:</label>
            {!! Form::select("estatus_f", $list["StCliente"], null, array("class" => "form-control select_seguridad", "id" => "estatus_f-field")) !!}
            @if($errors->has("estatus_f"))
            <span class="help-block">{{ $errors->first("estatus_f") }}</span>
            @endif
        </div>

        <div class="form-group col-md-4 @if($errors->has('fec_vencimiento')) has-error @endif">
            <label for="fec_vencimiento-field">Fecha Vencimiento</label>
            {!! Form::text("fec_vencimiento", null, array("class" => "form-control input-sm", "id" => "fec_vencimiento-field")) !!}
            @if($errors->has("fec_vencimiento"))
            <span class="help-block">{{ $errors->first("fec_vencimiento") }}</span>
            @endif
        </div>
        
        <div class="row">
        </div>
        <div class="well well-sm">
            <button type="submit" class="btn btn-primary">Ver</button>
        </div>
        {!! Form::close() !!}
    </div>
</div>
@endsection

@push('scripts')

<script>
$(document).ready(function() {
    $('#fec_vencimiento-field').Zebra_DatePicker({
                        days:['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'],
                                months:['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
                                readonly_element: false,
                                lang_clear_date: 'Limpiar',
                                show_select_today: 'Hoy',
                        });

    $('#plantel_f-field').change(function(){
    getCmbEspecialidad();
    });
});



    function getCmbEspecialidad(){
        //var $example = $("#especialidad_id-field").select2();
        var a = $('#frm_cliente').serialize();
        $.ajax({
        url: '{{ route("especialidads.getCmbEspecialidad") }}',
                type: 'GET',
                data: "plantel_id=" + $('#plantel_f-field option:selected').val() + "&especialidad_id=" + $('#especialidad_id-field option:selected').val() + "",
                dataType: 'json',
                beforeSend : function(){$("#loading10").show(); },
                complete : function(){$("#loading10").hide(); },
                success: function(data){
                //$example.select2("destroy");
                $('#especialidad_id-field').empty();
                $('#especialidad_id-field').append($('<option></option>').text('Seleccionar').val('0'));
                $.each(data, function(i) {
                //alert(data[i].name);
                $('#especialidad_id-field').append("<option " + data[i].selectec + " value=\"" + data[i].id + "\">" + data[i].name + "<\/option>");
                });
                //$example.select2();
                }
        });
        }
        
        </script>
@endpush