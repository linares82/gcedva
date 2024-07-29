@extends('plantillas.admin_template')

@include('seguimientos._common')

@section('header')

<ol class="breadcrumb">
    <li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
    <li>Levantamiento Inventario</li>
    <li class="active">Levantamiento Inventario</li>
</ol>

<div class="page-header">
    <h3><i class="glyphicon glyphicon-plus"></i> Inventario / F. Levantamiento Faltantes </h3>
</div>
@endsection

@section('content')
@include('error')

<div class="row">
    <div class="col-md-12">

        {!! Form::open(array('route' => 'inventarioLevantamientos.inicioLevantamientoLista', 'id'=>'frmPlanteles')) !!}

        <div class="form-group col-md-6 @if($errors->has('plantel_f')) has-error @endif">
            <label for="plantel_f-field">Plantel:</label>
            {!! Form::select("plantel_f[]", $planteles, null, array("class" => "form-control select_seguridad", "id" => "plantel_f-field",'multiple'=>true)) !!}
            @if($errors->has("plantel_f"))
            <span class="help-block">{{ $errors->first("plantel_f") }}</span>
            @endif
        </div>

        <div class="form-group col-md-6 @if($errors->has('area')) has-error @endif">
            <label for="area-field">Area(varias opciones, separadas por comas ","):</label>
            {!! Form::text("area", null, array("class" => "form-control input-sm", "id" => "area-field")) !!}
            @if($errors->has("area"))
            <span class="help-block">{{ $errors->first("area") }}</span>
            @endif
        </div>
        <!--
        <div class="form-group col-md-6 @if($errors->has('existe_si')) has-error @endif" style="clear:left;">
            <label for="existe_si-field">Existe si</label>
            {!! Form::select("existe_si[]", $catExiste, null, array("class" => "form-control select_seguridad", "id" => "existe_si-field", "multiple"=>true)) !!}
            @if($errors->has("existe_si"))
            <span class="help-block">{{ $errors->first("existe_si") }}</span>
            @endif
        </div>

        <div class="form-group col-md-6 @if($errors->has('estado_bueno')) has-error @endif">
            <label for="estado_bueno-field">Estado bueno</label>
            {!! Form::select("estado_bueno[]", $catEstado, null, array("class" => "form-control select_seguridad", "id" => "estado_bueno-field", "multiple"=>true)) !!}
            @if($errors->has("estado_bueno"))
            <span class="help-block">{{ $errors->first("estado_bueno") }}</span>
            @endif
        </div>
        -->
        <div class="form-group col-md-6 @if($errors->has('fecha_f')) has-error @endif" style="clear:left;">
            <label for="fecha_f-field">Fecha de:</label>
            {!! Form::text("fecha_f", null, array("class" => "form-control input-sm fecha", "id" => "fecha_f-field")) !!}
            @if($errors->has("fecha_f"))
            <span class="help-block">{{ $errors->first("fecha_f") }}</span>
            @endif
        </div>
        <div class="form-group col-md-6 @if($errors->has('fecha_t')) has-error @endif">
            <label for="fecha_t-field">Fecha a:</label>
            {!! Form::text("fecha_t", null, array("class" => "form-control input-sm fecha", "id" => "fecha_t-field")) !!}
            @if($errors->has("fecha_t"))
            <span class="help-block">{{ $errors->first("fecha_t") }}</span>
            @endif
        </div>


        <div class="row">
        </div>
        <div class="well well-sm">
            <button type="" id="submitPlanteles" class="btn btn-primary">Tabla</button>
        </div>
        {!! Form::close() !!}
    </div>
    <div class="row"></div>
    <div class="row">
        <div class="col-md-12">
            @if(isset($resultado))
            <table class="table table-condensed table-striped">
                <thead>
                    <th>Plantel</th>
                    <th>Fecha</th>
                    <th>Area</th>
                    <th>Estado</th>
                    <th>Existe</th>
                    <th></th>
                </thead>
                <tbody>
                    @foreach($resultado as $r)
                    <tr>
                        <td>{{$r->plantel}}</td>
                        <td>{{$r->fecha}}</td>
                        <td>{{$r->area}}</td>
                        <td>{{$r->estado_bueno}}</td>
                        <td>{{$r->existe_si}}</td>
                        <td>
                            <a href="{{route('inventarioLevantamientos.inicioLevantamientoCsv', 
                                array('plantel'=>$r->plantel_id,'fecha'=>$r->fecha, 'area'=>$r->area, 
                                'estado_bueno'=>$r->estado_bueno, 'existe_si'=>$r->existe_si))}}" target="_blank">
                                Csv
                            </a>
                            |
                            <a href="{{route('inventarioLevantamientos.inicioLevantamientoFormato', 
                                array('plantel'=>$r->plantel_id,'fecha'=>$r->fecha, 'area'=>$r->area,
                                'estado_bueno'=>$r->estado_bueno, 'existe_si'=>$r->existe_si))}}" target="_blank">
                                Formato
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            @endif
        </div>
    </div>



</div>
@endsection
@push('scripts')
<script type="text/javascript">
    $(document).ready(function() {

        $('#fecha_t-field').Zebra_DatePicker({
            days: ['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'],
            months: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
            readonly_element: false,
            lang_clear_date: 'Limpiar',
            show_select_today: 'Hoy',
        });

        $('#submitPlanteles').click(function(e) {
            //e.preventDefault();
            //getFechas();
        });
    });

    function getFechas() {
        //var $example = $("#especialidad_id-field").select2();
        datos = $('#frmPlanteles').serialize();
        console.log(datos);
        $.ajax({
            url: '{{ route("inventarioLevantamientos.inicioLevantamientoLista") }}',
            type: 'GET',
            data: datos,
            dataType: 'json',
            beforeSend: function() {
                $("#loading10").show();
            },
            complete: function() {
                $("#loading10").hide();
            },
            success: function(data) {
                console.log(data);

                /*$.each(data, function (i) {
                    $('#especialidad_f-field').append("<option " + data[i].selectec + " value=\"" + data[i].id + "\">" + data[i].name + "<\/option>");
                });
                */
            }
        });
    }
</script>
@endpush