@extends('plantillas.admin_template')

@include('seguimientos._common')

@section('header')

	<ol class="breadcrumb">
		<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li><a href="{{ route('seguimientos.index') }}">Articulos</a></li>
	    <li class="active">Existencias</li>
	</ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-plus"></i>Articulos / Existencias </h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">

            {!! Form::open(array('route' => 'articulos.existenciasActualesR', 'id'=>'frm_reporte')) !!}

                <div class="form-group col-md-6 @if($errors->has('plantel_f')) has-error @endif">
                    <label for="plantel_f-field">Plantel de:</label>
                    {!! Form::select("plantel_f", $plantels, null, array("class" => "form-control select_seguridad", "id" => "plantel_f-field")) !!}
                    @if($errors->has("plantel_f"))
                    <span class="help-block">{{ $errors->first("plantel_f") }}</span>
                    @endif
                </div>
                
                <div class="form-group col-md-4 @if($errors->has('ubicacion_art_id')) has-error @endif">
                    <label for="ubicacion_art_id-field">Ubicacion</label>
                    {!! Form::select("ubicacion_art_id[]", array(), null, array("class" => "form-control select_seguridad", "id" => "ubicacion_art_id-field",'multiple'=>true)) !!}
                    @if($errors->has("ubicacion_art_id"))
                     <span class="help-block">{{ $errors->first("ubicacion_art_id") }}</span>
                    @endif
                 </div>

                <div class="form-group col-md-6 @if($errors->has('articulo_t')) has-error @endif">
                    <label for="articulo_t-field">Articulo de:</label>
                    {!! Form::select("articulo_t[]", $articulos, null, array("class" => "form-control select_seguridad", "id" => "articulo_t-field", 'multiple'=>true)) !!}
                    @if($errors->has("articulo_t"))
                    <span class="help-block">{{ $errors->first("articulo_t") }}</span>
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
      getUbicaciones();
      $('#plantel_f-field').change(function(){
         getUbicaciones();
         
      });
    
    });
    function getUbicaciones(){
      $.ajax({
                url: '{{ route("ubicacionArts.getUbicacionesXPlantel") }}',
                type: 'GET',
                data: {
                   'plantel':$('#plantel_f-field option:selected').val(),
                   'ubicacion':$('#ubicacion_art_id-field option:selected').val()
                },
                dataType: 'json',
                beforeSend : function(){$("#loading1").show();},
                complete : function(){$("#loading1").hide();},
                success: function(data){
                   console.log(data);
                      $('#ubicacion_art_id-field').html('');
                      
                      $('#ubicacion_art_id-field').append($('<option></option>').text('Seleccionar').val('0'));
                      
                      $.each(data, function(i) {
                          $('#ubicacion_art_id-field').append("<option "+data[i].selectec+" value=\""+data[i].id+"\">"+data[i].name+"<\/option>");
                      });
                      
                }
            });
   }
    
    </script>
@endpush