@extends('plantillas.admin_template')

@include('clientes._common')

@section('header')

	<ol class="breadcrumb">
	    <li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li><a href="{{ route('clientes.index') }}">@yield('clientesAppTitle')</a></li>
	    <li class="active">Reasignar</li>
	</ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-edit"></i> @yield('clientesAppTitle') / Reasignar </h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">

            {!! Form::open(array('route' => 'clientes.reasignar', 'id'=>'frm_reasignar')) !!}

            <div class="box box-default box-solid">
                <div class="box-header">
                    <h3 class="box-title">Datos Actuales</h3>
                    <div class="box-tools">
                        
                        <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div>
                </div>
                <div class="box-body">
                    <div class="form-group col-md-4 @if($errors->has('plantel_id')) has-error @endif">
                    <label for="plantel_id-field">Plantel</label>
                    {!! Form::select("plantel_id", $list["Plantel"], null, array("class" => "form-control select_seguridad", "id" => "plantel_id-field")) !!}
                    @if($errors->has("plantel_id"))
                        <span class="help-block">{{ $errors->first("plantel_id") }}</span>
                    @endif
                    </div>

                    <div class="form-group col-md-3 @if($errors->has('empleado_id')) has-error @endif">
                    <label for="empleado_id-field">Empleado</label>
                    {!! Form::select("empleado_id", $list["Empleado"], null, array("class" => "form-control select_seguridad", "id" => "empleado_id-field")) !!}
                    <div id='loading3' style='display: none'><img src="{{ asset('images/ajax-loader.gif') }}" title="Enviando" /></div> 
                    @if($errors->has("empleado_id"))
                        <span class="help-block">{{ $errors->first("empleado_id") }}</span>
                    @endif
                    </div>

                    <div class="form-group col-md-2 @if($errors->has('st_seguimiento_id')) has-error @endif">
                    <label for="st_cliente_id-field">Estatus Seguimiento</label>
                    {!! Form::select("st_seguimiento_id", $list2["StSeguimiento"], null, array("class" => "form-control select_seguridad", "id" => "st_seguimiento_id-field", 'style'=>'width:100%;')) !!}
                    @if($errors->has("st_seguimiento_id"))
                        <span class="help-block">{{ $errors->first("st_seguimiento_id") }}</span>
                    @endif
                    </div>
                    <div class="form-group col-md-2 @if($errors->has('matricula')) has-error @endif">
                    <label for="cantidad-field">R. Existentes</label>
                    {!! Form::text("cantidad", null, array("class" => "form-control input-sm", "id" => "cantidad-field", 'readonly'=>true)) !!}
                    @if($errors->has("cantidad"))
                        <span class="help-block">{{ $errors->first("cantidad") }}</span>
                    @endif
                    </div>
                    <div class="form-group col-md-1 @if($errors->has('cantidad_afectar')) has-error @endif">
                        <label for="cantidad_afectar-field">Afectar a</label>
                        {!! Form::text("cantidad_afectar", null, array("class" => "form-control input-sm", "id" => "cantidad_afectar-field")) !!}
                        @if($errors->has("cantidad_afectar"))
                            <span class="help-block">{{ $errors->first("cantidad_afectar") }}</span>
                        @endif
                        </div>
                </div>
            </div>
            <div class="box box-default box-solid">
                <div class="box-header">
                    <h3 class="box-title">Cambiar A:</h3>
                    <div class="box-tools">
                        <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div>
                </div>
                <div class="box-body">
                    <div class="form-group col-md-4 @if($errors->has('plantel_id2')) has-error @endif">
                    <label for="plantel_id2-field">Plantel</label>
                    {!! Form::select("plantel_id2", $list["Plantel"], null, array("class" => "form-control select_seguridad", "id" => "plantel_id2-field")) !!}
                    @if($errors->has("plantel_id2"))
                        <span class="help-block">{{ $errors->first("plantel_id2") }}</span>
                    @endif
                    </div>

                    <div class="form-group col-md-4 @if($errors->has('empleado_id2')) has-error @endif">
                    <label for="empleado_id2-field">Empleado</label>
                    {!! Form::select("empleado_id2", $list["Empleado"], null, array("class" => "form-control select_seguridad", "id" => "empleado_id2-field")) !!}
                    <div id='loading3' style='display: none'><img src="{{ asset('images/ajax-loader.gif') }}" title="Enviando" /></div> 
                    @if($errors->has("empleado_id2"))
                        <span class="help-block">{{ $errors->first("empleado_id2") }}</span>
                    @endif
                    </div>
                </div>
            </div>

                <div class="row">
                </div>

                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">Reasignar</button>
                    <a class="btn btn-link pull-right" href="{{ route('clientes.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>
                </div>
                
            {!! Form::close() !!}

        </div>
    </div>
@endsection
@push('scripts')
<script type="text/javascript">
    $(document).ready(function() {
        
        //Asigna el plantel segun el empleado
      /*$('#empleado_id-field').change(function(){
        $("#loading3").show();
        $.get("{{ url('getPlantel')}}",
          { empleado: $(this).val() },
          function(data) {
            $('#plantel_id-field').val(data).change();
            $("#loading3").hide();
          }
        );  
      });

      $('#empleado_id2-field').change(function(){
        $("#loading3").show();
        $.get("{{ url('getPlantel')}}",
          { empleado: $(this).val() },
          function(data) {
            $('#plantel_id2-field').val(data).change();
            $("#loading3").hide();
          }
        );  
      });
*/
      $('#st_seguimiento_id-field').change(function(){
          getCuenta();
      });
      function getCuenta(){
        var a= $('#frm_reasignar').serialize();
        $.ajax({
                url: '{{ route("clientes.getCuenta") }}',
                type: 'GET',
                data: a,
                dataType: 'json',
                beforeSend : function(){$("#loading13").show();},
                complete : function(){$("#loading13").hide();},
                success: function(data){
                    $('#cantidad-field').val('');
                    $('#cantidad-field').val(data);
                }
            });
      }
      $('#plantel_id-field').change(function(){
        getCmbEmpleados();
      });
      
      $('#plantel_id2-field').change(function(){
        getCmbEmpleados2();
      });
      
      function getCmbEmpleados(){
          //$('#empleado_id_field option:selected').val($('#empleado_id_campo option:selected').val()).change();
          var a= $('#frm_reasignar').serialize();
              $.ajax({
                  url: '{{ route("empleados.getEmpleadosXplantel") }}',
                  type: 'GET',
                  data: a,
                  dataType: 'json',
                  beforeSend : function(){$("#loading3").show();},
                  complete : function(){$("#loading3").hide();},
                  success: function(data){
                      $('#empleado_id-field').html('');
                      $('#empleado_id-field').append($('<option></option>').text('Seleccionar Opción').val('0'));
                      $.each(data, function(i) {
                          $('#empleado_id-field').append("<option "+data[i].selectec+" value=\""+data[i].id+"\">"+data[i].nombre+"<\/option>");
                      });
                  }
              });       
      }
      
      function getCmbEmpleados2(){
          //$('#empleado_id_field option:selected').val($('#empleado_id_campo option:selected').val()).change();
          var a= $('#frm_reasignar').serialize();
              $.ajax({
                  url: '{{ route("empleados.getEmpleadosXplantel") }}',
                  type: 'GET',
                  data: {"plantel_id":$("#plantel_id2-field option:selected").val()},
                  dataType: 'json',
                  beforeSend : function(){$("#loading3").show();},
                  complete : function(){$("#loading3").hide();},
                  success: function(data){
                      $('#empleado_id2-field').html('');
                      $('#empleado_id2-field').append($('<option></option>').text('Seleccionar Opción').val('0'));
                      $.each(data, function(i) {
                          $('#empleado_id2-field').append("<option "+data[i].selectec+" value=\""+data[i].id+"\">"+data[i].nombre+"<\/option>");
                      });
                  }
              });       
      }
      
      
    });
   
  </script>
@endpush