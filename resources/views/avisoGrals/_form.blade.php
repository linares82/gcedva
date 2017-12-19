<link rel="stylesheet" type="text/css" href="asset('bower_components/AdminLTE/plugins/lou-multi-select/css/css/multi-select.css')">
                    <div class="form-group col-md-8">
<!--                    
                        <div class="form-group col-md-6 @if($errors->has('inicio')) has-error @endif">
                            <label for="inicio-field">Inicio Vigencia</label>
                            {!! Form::text("inicio", null, array("class" => "form-control", "id" => "inicio-field")) !!}
                            @if($errors->has("inicio"))
                                <span class="help-block">{{ $errors->first("inicio") }}</span>
                            @endif
                        </div>
                        <div class="form-group col-md-6 @if($errors->has('fin')) has-error @endif">
                            <label for="fin-field">Fin Vigencia</label>
                            {!! Form::text("fin", null, array("class" => "form-control", "id" => "fin-field")) !!}
                            @if($errors->has("fin"))
                                <span class="help-block">{{ $errors->first("fin") }}</span>
                            @endif
                        </div>
-->
                        <div class="form-group col-md-6 @if($errors->has('plantel_id')) has-error @endif">
                            <label for="plantel_id-field">Plantel</label>
                            {!! Form::select("plantel_id", $list["Plantel"], null, array("class" => "form-control select_seguridad", "id" => "plantel_id-field")) !!}
                            @if($errors->has("plantel_id"))
                                <span class="help-block">{{ $errors->first("st_cliente_id") }}</span>
                            @endif
                        </div>
                        <div class="form-group col-md-6 @if($errors->has('puesto_id')) has-error @endif">
                            <label for="puesto_id-field">Puesto</label>
                            {!! Form::select("puesto_id", $list["Puesto"], null, array("class" => "form-control select_seguridad", "id" => "puesto_id-field")) !!}
                            @if($errors->has("puesto_id"))
                                <span class="help-block">{{ $errors->first("puesto_id") }}</span>
                            @endif
                        </div>
                            
                        <div class="form-group col-md-12 @if($errors->has('empleado_id')) has-error @endif">
                                <label for="empleado_id-field">Empleado</label>
                                <a href='#' id='select-all'>Seleccionar todos</a>
                                <div id="select_empleado">
                                    {!! Form::select("empleado_id", $list1['Empleado'], null, array("class" => "form-control", "id" => "empleado_id-field", "name"=>"empleado_id-field[]", 'multiple'=>'multiple')) !!} 
                                </div>
                                <div id='loading3' style='display: none'><img src="{{ asset('images/ajax-loader.gif') }}" title="Enviando" /></div>
                                @if($errors->has("empleado_id"))
                                    <span class="help-block">{{ $errors->first("empleado_id") }}</span>
                                @endif
                        </div>
                        @if(isset($avisoGral->pivotAvisoGralEmpleado))

                            <div class="form-group col-md-12">
                                <table class="table table-condensed table-striped">
                                    <tr>
                                        <th>Destinatario</th><th>Plantel</th><th>Puesto</th>
                                        <th><a href="{{route('pivotAvisoGralEmpleados.enviar', $avisoGral->id)}}" class="btn btn-xs btn-info">Enviar</a></th>
                                        <th>Leido</th>
                                        <th></th>
                                    </tr>
                                    @foreach($avisoGral->pivotAvisoGralEmpleado as $e)
                                        <tr>
                                            <td>{!! $e->empleado->nombre." ".$e->empleado->ape_paterno." ".$e->empleado->ape_materno !!}</td>
                                            <td>{!! $e->empleado->plantel->razon !!}</td>
                                            <td>{!! $e->empleado->puesto->name !!}</td>
                                            <td>
                                                {!! Form::checkbox("enviado", 
                                                                    $e->enviado, 
                                                                    $e->enviado,
                                                                    array('disabled'=>'disabled')) !!}
                                            </td>
                                            <td>{!! Form::checkbox("enviado", 
                                                                    $e->leido, 
                                                                    $e->leido,
                                                                    array('disabled'=>'disabled')) !!}
                                            </td>
                                            <td><a href="{{route('pivotAvisoGralEmpleados.destroy', $e->id)}}" class="btn btn-xs btn-danger">Eliminar</a></td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                        @endif
                    </div>
                    
                    <div class="form-group col-md-4">
                        <div class="form-group col-md-12 @if($errors->has('desc_corta')) has-error @endif">
                            <label for="desc_corta-field">Asunto</label>
                            {!! Form::text("desc_corta", null, array("class" => "form-control", "id" => "desc_corta-field", 'rows'=>'3', 'maxlength'=>'255')) !!}
                            @if($errors->has("desc_corta"))
                                <span class="help-block">{{ $errors->first("desc_corta") }}</span>
                            @endif
                        </div>
                        <div class="form-group col-md-12 @if($errors->has('aviso')) has-error @endif">
                            <label for="aviso-field">Aviso </label>
                            {!! Form::textArea("aviso", null, array("class" => "form-control", "id" => "aviso-field", 'rows'=>'10')) !!}
                            @if($errors->has("aviso"))
                                <span class="help-block">{{ $errors->first("aviso") }}</span>
                            @endif
                        </div>
                    </div>
                    

                    
                    
@push('scripts')
  <script type="text/javascript" src="{{ asset ('/bower_components/AdminLTE/plugins/lou-multi-select/js/jquery.multi-select.js') }}"></script>
  <script type="text/javascript">
    $('#select-all').click(function(){
        $('select#empleado_id-field').multiSelect('select_all');
        return false;
    });
    $(document).ready(function() {
        
        $("#plantel_id-field").change(function(event) {
            $('select#empleado_id-field').val(0).trigger('change');
        });
        
        var contenido_empleado=$('#select_empleado').html();
        
        $("#puesto_id-field").change(function(event) {
            //var id = $("select#tpo_bitacora_id option:selected").val(); 
            var a= $('#frm_avisos').serialize();
            $.ajax({
                url: '{{  route("empleados.getEmpleadosXplantelXpuesto") }}',
                type: 'GET',
                data: a, 
                dataType: 'json',
                beforeSend : function(){$("#loading3").show();},
                complete : function(){$("#loading3").hide();},
                success: function(e){
                    $('#select_empleado').empty();
                    $('#select_empleado').html(contenido_empleado);
                    $('select#empleado_id-field').html('');
                    //$('select#empleado_id-field').append($('<option></option>').text('Seleccionar opción').val(''));
                    $.each(e, function(i) {
                        @if(isset($puesto))
                            $('#empleado_id-field').val({{$empleado}});
                            if(e[i].id=={{$empleado}}){
                                $('select#empleado_id-field').append("<option selected value=\""+e[i].id+"\">"+e[i].nombre+"<\/option>");
                            }
                        @else
                            $('select#empleado_id-field').append("<option value=\""+e[i].id+"\">"+e[i].nombre+"<\/option>");
                        @endif
                    });
                    $('#empleado_id-field').multiSelect();
                    
                   /*$('select#empleado_id-field').empty();
                   $('select#empleado_id-field').html('');
                   $('select#empleado_id-field').append($('<option></option>').text('Seleccionar opción').val(''));
                   $.each(e, function(i) {
                        @if(isset($puesto))
                            $('#empleado_id-field').val({{$empleado}});
                            if(e[i].id=={{$empleado}}){
                                $('select#empleado_id-field').append("<option selected value=\""+e[i].id+"\">"+e[i].nombre+"<\/option>");
                            }
                        @else
                            $('select#empleado_id-field').append("<option value=\""+e[i].id+"\">"+e[i].nombre+"<\/option>");
                        @endif
                        
                    });
                   $('select#empleado_id-field').multiSelect();
                   */
                }
            });
        }); 
    
        @if(isset($puesto))
            //$('#plantel_id-field').select2({{$plantel}});
            $('#plantel_id-field').val({{$plantel}}).trigger('change');
            $('#puesto_id-field').val({{$puesto}}).trigger('change');
            //$('#empleado_id-field').val({{$empleado}});    
        @endif
    
    $('#inicio-field').Zebra_DatePicker({
        days:['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'],
        months:['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
        readonly_element: false,
        lang_clear_date: 'Limpiar',
        show_select_today: 'Hoy',
      });
      $('#fin-field').Zebra_DatePicker({
        days:['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'],
        months:['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
        readonly_element: false,
        lang_clear_date: 'Limpiar',
        show_select_today: 'Hoy',
      });

      
    });
    </script>
@endpush