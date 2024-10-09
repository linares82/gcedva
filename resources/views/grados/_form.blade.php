                <div class="form-group col-md-4 @if($errors->has('plantel_id')) has-error @endif">
                          <label for="plantel_id-field">Plantel</label>
                          {!! Form::select("plantel_id", $list["Plantel"], null, array("class" => "form-control select_seguridad", "id" => "plantel_id-field")) !!}
                          @if($errors->has("plantel_id"))
                            <span class="help-block">{{ $errors->first("plantel_id") }}</span>
                          @endif
                    </div>
                <div class="form-group col-md-4 @if($errors->has('especialidad_id')) has-error @endif">
                          <label for="especialidad_id-field">Especialidad</label>
                          {!! Form::select("especialidad_id", $list["Especialidad"], null, array("class" => "form-control select_seguridad", "id" => "especialidad_id-field")) !!}
                          <div id='loading2' style='display: none'><img src="{{ asset('images/ajax-loader.gif') }}" title="Enviando" /></div> 
                          @if($errors->has("especialidad_id"))
                            <span class="help-block">{{ $errors->first("especialidad_id") }}</span>
                          @endif
                        </div>
                <div class="form-group col-md-4 @if($errors->has('nivel_id')) has-error @endif">
                       <label for="nivel_id-field">Nivel</label>
                       {!! Form::select("nivel_id", $list["Nivel"], null, array("class" => "form-control select_seguridad", "id" => "nivel_id-field")) !!}
                       <div id='loading3' style='display: none'><img src="{{ asset('images/ajax-loader.gif') }}" title="Enviando" /></div> 
                       @if($errors->has("nivel_id"))
                        <span class="help-block">{{ $errors->first("nivel_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('name')) has-error @endif">
                       <label for="name-field">Grado</label>
                       {!! Form::text("name", null, array("class" => "form-control input-sm", "id" => "name-field")) !!}
                       @if($errors->has("name"))
                        <span class="help-block">{{ $errors->first("name") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('nombre2')) has-error @endif">
                       <label for="nombre2-field">Nombre RVOE</label>
                       {!! Form::text("nombre2", null, array("class" => "form-control input-sm", "id" => "nombre2-field")) !!}
                       @if($errors->has("nombre2"))
                        <span class="help-block">{{ $errors->first("nombre2") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('denominacion')) has-error @endif">
                        <label for="denominacion-field">Denominacion</label>
                        {!! Form::text("denominacion", null, array("class" => "form-control input-sm", "id" => "denominacion-field")) !!}
                        @if($errors->has("denominacion"))
                         <span class="help-block">{{ $errors->first("denominacion") }}</span>
                        @endif
                     </div>
                     <div class="form-group col-md-4 @if($errors->has('rvoe')) has-error @endif">
                        <label for="rvoe-field">RVOE</label>
                        {!! Form::text("rvoe", null, array("class" => "form-control input-sm", "id" => "rvoe-field")) !!}
                        @if($errors->has("rvoe"))
                         <span class="help-block">{{ $errors->first("denominacion") }}</span>
                        @endif
                     </div>
                     <div class="form-group col-md-4 @if($errors->has('fec_rvoe')) has-error @endif">
                        <label for="fec_rvoe-field">Fec. RVOE</label>
                        {!! Form::text("fec_rvoe", null, array("class" => "form-control input-sm fecha", "id" => "fec_rvoe-field")) !!}
                        @if($errors->has("fec_rvoe"))
                         <span class="help-block">{{ $errors->first("fec_rvoe") }}</span>
                        @endif
                     </div>
                     <div class="form-group col-md-4 @if($errors->has('cct')) has-error @endif">
                        <label for="cct-field">CCT</label>
                        {!! Form::text("cct", null, array("class" => "form-control input-sm", "id" => "cct-field")) !!}
                        @if($errors->has("cct"))
                         <span class="help-block">{{ $errors->first("cct") }}</span>
                        @endif
                     </div>
                    <div class="form-group col-md-4 @if($errors->has('precio_online')) has-error @endif">
                       <label for="precio_online-field">Precio Online</label>
                       {!! Form::text("precio_online", null, array("class" => "form-control input-sm", "id" => "precio_online-field")) !!}
                       @if($errors->has("precio_online"))
                        <span class="help-block">{{ $errors->first("precio_online") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('seccion')) has-error @endif">
                        <label for="seccion-field">Seccion</label>
                        {!! Form::text("seccion", null, array("class" => "form-control input-sm", "id" => "seccion-field")) !!}
                        @if($errors->has("seccion"))
                         <span class="help-block">{{ $errors->first("seccion") }}</span>
                        @endif
                     </div>
                     <div class="form-group col-md-4 @if($errors->has('clave_servicio')) has-error @endif">
                        <label for="clave_servicio-field">C. Producto o Servicio(Facturacion)</label>
                        {!! Form::text("clave_servicio", null, array("class" => "form-control input-sm", "id" => "clave_servicio-field")) !!}
                        @if($errors->has("clave_servicio"))
                         <span class="help-block">{{ $errors->first("clave_servicio") }}</span>
                        @endif
                     </div>
                     <div class="form-group col-md-4 @if($errors->has('nivel_educativo_sat_id')) has-error @endif">
                        <label for="nivel_educativo_sat_id-field">Nivel Educativo SAT</label>
                        {!! Form::select("nivel_educativo_sat_id", $list["NivelEducativoSat"], null, array("class" => "form-control select_seguridad", "id" => "nivel_educativo_sat_id-field")) !!}
                        @if($errors->has("nivel_educativo_sat_id"))
                         <span class="help-block">{{ $errors->first("modulo_final_id") }}</span>
                        @endif
                     </div>
                     <div class="form-group col-md-4 @if($errors->has('id_mapa')) has-error @endif">
                        <label for="id_mapa-field">Id Mapa</label>
                        {!! Form::text("id_mapa", null, array("class" => "form-control input-sm", "id" => "id_mapa-field")) !!}
                        @if($errors->has("id_mapa"))
                         <span class="help-block">{{ $errors->first("id_mapa") }}</span>
                        @endif
                     </div>
                    <div class="form-group col-md-4 @if($errors->has('modulo_final_id')) has-error @endif">
                       <label for="modulo_final_id-field">Modulo final</label>
                       {!! Form::select("modulo_final_id", $modulos, null, array("class" => "form-control select_seguridad", "id" => "modulo_final_id-field")) !!}
                       @if($errors->has("modulo_final_id"))
                        <span class="help-block">{{ $errors->first("modulo_final_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-2 @if($errors->has('mexico_bnd')) has-error @endif">
                        <label for="mexico_bnd-field">Mexico(Solo para pagina)</label>
                        {!! Form::checkbox("mexico_bnd", 1, null, [ "id" => "mexico_bnd-field"]) !!}
                        @if($errors->has("mexico_bnd"))
                         <span class="help-block">{{ $errors->first("mexico_bnd") }}</span>
                        @endif
                     </div>
                     
                     
@push('scripts')                    
<script>
  $(document).ready(function() {
    getCmbEspecialidad();
    getCmbNivel();
    $('#plantel_id-field').change(function(){
        getCmbEspecialidad();
    });
    function getCmbEspecialidad(){
        //var $example = $("#especialidad_id-field").select2();
        var a= $('#frm_grados').serialize();
            $.ajax({
                url: '{{ route("especialidads.getCmbEspecialidad") }}',
                type: 'GET',
                data: a,
                dataType: 'json',
                beforeSend : function(){$("#loading2").show();},
                complete : function(){$("#loading2").hide();},
                success: function(data){
                    //$example.select2("destroy");
                    $('#especialidad_id-field').html('');
                    //$('#especialidad_id-field').empty();
                    $('#especialidad_id-field').append($('<option></option>').text('Seleccionar').val('0'));
                    $.each(data, function(i) {
                        //alert(data[i].name);
                        $('#especialidad_id-field').append("<option "+data[i].selectec+" value=\""+data[i].id+"\">"+data[i].name+"<\/option>");
                    });
                    //$example.select2();
                }
            });       
    }
    $('#especialidad_id-field').change(function(){
        getCmbNivel();
    });
    function getCmbNivel(){
        //var $example = $("#especialidad_id-field").select2();
        var a= $('#frm_grados').serialize();
            $.ajax({
                url: '{{ route("nivels.getCmbNivels") }}',
                type: 'GET',
                data: a,
                dataType: 'json',
                beforeSend : function(){$("#loading3").show();},
                complete : function(){$("#loading3").hide();},
                success: function(data){
                    //alert(data);
                    //$example.select2("destroy");
                    $('#nivel_id-field').html('');
                    //$('#especialidad_id-field').empty();
                    $('#nivel_id-field').append($('<option></option>').text('Seleccionar').val('0'));
                    
                    $.each(data, function(i) {
                        //alert(data[i].name);
                        $('#nivel_id-field').append("<option "+data[i].selectec+" value=\""+data[i].id+"\">"+data[i].name+"<\/option>");
                    });
                    //$example.select2();
                }
            });       
    }
  });
</script>
@endpush                    