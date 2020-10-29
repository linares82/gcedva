@extends('plantillas.admin_template')

@include('seguimientos._common')

@section('header')

	<ol class="breadcrumb">
		<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li><a href="{{ route('clientes.index') }}">@yield('clientesAppTitle')</a></li>
	    <li class="active">Altas por Usuario</li>
	</ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-plus"></i> @yield('seguimientosAppTitle') / Clientes - Cantidades de estatus por municipio en un periodo </h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">

            {!! Form::open(array('route' => 'clientes.concretadosR', 'id'=>'frm_reporte')) !!}

<!--                <div class="form-group col-md-6 @if($errors->has('estatus_f')) has-error @endif">
                    <label for="estatus_f-field">Estatus de:</label>
                    {!! Form::select("estatus_f", $list["StCliente"], null, array("class" => "form-control select_seguridad", "id" => "estatus_f-field", 'readonly'=>'readonly')) !!}
                    @if($errors->has("estatus_f"))
                    <span class="help-block">{{ $errors->first("estatus_f") }}</span>
                    @endif
                </div>
            
                <div class="form-group col-md-6 @if($errors->has('estatus_t')) has-error @endif">
                    <label for="estatus_t-field">Estatus a:</label>
                    {!! Form::select("estatus_t", $list["StCliente"], null, array("class" => "form-control select_seguridad", "id" => "estatus_t-field", 'readonly'=>'readonly')) !!}
                    @if($errors->has("estatus_t"))
                    <span class="help-block">{{ $errors->first("estatus_t") }}</span>
                    @endif
                </div>-->
            
                <div class="form-group col-md-6 @if($errors->has('plantel_f')) has-error @endif">
                    <label for="plantel_f-field">Plantel de:</label>
                    {!! Form::select("plantel_f[]", $planteles, null, array("class" => "form-control select_seguridad", "id" => "plantel_f-field",'multiple'=>true)) !!}
                    <div id='loading10' style='display: none'><img src="{{ asset('images/ajax-loader.gif') }}" title="Enviando" /></div> 
                    @if($errors->has("plantel_f"))
                    <span class="help-block">{{ $errors->first("plantel_f") }}</span>
                    @endif
                </div>
            
                <div class="form-group col-md-6 @if($errors->has('inicio_matricula')) has-error @endif">
                    <label for="inicio_matricula-field">Inicio Matricula (4 digitos):</label>
                    {!! Form::text("inicio_matricula", null, array("class" => "form-control input-sm", "id" => "inicio_matricula-field")) !!}
                    @if($errors->has("inicio_matricula"))
                    <span class="help-block">{{ $errors->first("inicio_matricula") }}</span>
                    @endif
                </div>
               
                
                
                
                
                <div class="row">
                </div>
                <div class="well well-sm">
                    <button id="submit_tbl" type="submit" class="btn btn-primary">Tabla</button>
                </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection
@push('scripts')
  <script type="text/javascript">
    $(document).ready(function() {
    $('#fecha_f-field').Zebra_DatePicker({
        days:['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'],
        months:['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
        readonly_element: false,
        lang_clear_date: 'Limpiar',
        show_select_today: 'Hoy',
      });
      $('#fecha_t-field').Zebra_DatePicker({
        days:['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'],
        months:['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
        readonly_element: false,
        lang_clear_date: 'Limpiar',
        show_select_today: 'Hoy',
      });

      $('#plantel_f-field').change(function(){
        getCmbEspecialidad();
      });

      function getCmbEspecialidad(){
        $.ajax({
        url: '{{ route("especialidads.getCmbEspecialidad") }}',
                type: 'GET',
                data: "plantel_id=" + $('#plantel_f-field option:selected').val() + "&especialidad_id=" + $('#especialidad_f-field option:selected').val() + "",
                dataType: 'json',
                beforeSend : function(){$("#loading10").show(); },
                complete : function(){$("#loading10").hide(); },
                success: function(data){
                $('#especialidad_f-field').empty();
                $('#especialidad_f-field').append($('<option></option>').text('Seleccionar').val('0'));
                $.each(data, function(i) {
                $('#especialidad_f-field').append("<option " + data[i].selectec + " value=\"" + data[i].id + "\">" + data[i].name + "<\/option>");
                });
                
                }
        });
        }
        
    });
    
    </script>
@endpush