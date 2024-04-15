<div class="form-group col-md-4 @if($errors->has('plantel_id')) has-error @endif">
    <label for="plantel_id-field">Plantel</label>
    {!! Form::hidden("id", null, array("class" => "form-control input-sm", "id" => "id-field")) !!}
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
<div class="form-group col-md-4 @if($errors->has('grado_id')) has-error @endif">
    <label for="grado_id-field">Grado</label>
    {!! Form::select("grado_id", $list["Grado"], null, array("class" => "form-control select_seguridad", "id" => "grado_id-field")) !!}
    @if($errors->has("grado_id"))
    <span class="help-block">{{ $errors->first("grado_id") }}</span>
    @endif
</div>
<div class="form-group col-md-4 @if($errors->has('name')) has-error @endif">
    <label for="name-field">Turno</label>
    {!! Form::text("name", null, array("class" => "form-control input-sm", "id" => "name-field")) !!}
    @if($errors->has("name"))
    <span class="help-block">{{ $errors->first("name") }}</span>
    @endif
</div>
<div class="form-group col-md-4 @if($errors->has('plan_pago_id')) has-error @endif">
    <label for="plan_pago_id-field">Plan Pagos</label>
    {!! Form::select("plan_pago_id[]", $planes, isset($turno) ? $turno->planes : array(), array("class" => "form-control select_seguridad plan_pago", "id" => "plan_pago_id-field", "style"=>"width:75%;", 'multiple'=>true)) !!}
    @if($errors->has("plan_pago_id"))
    <span class="help-block">{{ $errors->first("plan_pago_id") }}</span>
    @endif
</div>
@push('scripts')                    
<script>
  $(document).ready(function() {
    getCmbPlanPagos();
    getCmbEspecialidad();
    getCmbNivel();
    getCmbGrado();

    $('#plantel_id-field').change(function(){
        getCmbEspecialidad();
        getCmbPlanPagos();
    });
    function getCmbEspecialidad(){
        //var $example = $("#especialidad_id-field").select2();
        var a= $('#frm_turnos').serialize();
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

    function getCmbPlanPagos(){
        //var $example = $("#especialidad_id-field").select2();
        var a= $('#frm_turnos').serialize();
            $.ajax({
                url: '{{ route("planPagos.getCmbPlanPagos") }}',
                type: 'GET',
                data: a,
                dataType: 'json',
                beforeSend : function(){$("#loading2").show();},
                complete : function(){$("#loading2").hide();},
                success: function(data){
                    //$example.select2("destroy");
                    $('#plan_pago_id-field').html('');
                    //$('#especialidad_id-field').empty();
                    $('#plan_pago_id-field').append($('<option></option>').text('Seleccionar').val('0'));
                    $.each(data, function(i) {
                        //alert(data[i].name);
                        $('#plan_pago_id-field').append("<option "+data[i].selectec+" value=\""+data[i].id+"\">"+data[i].name+"<\/option>");
                    });
                    //$('#plan_pago_id-field').select2();
                }
            });       
    }

    $('#especialidad_id-field').change(function(){
        getCmbNivel();
    });
    function getCmbNivel(){
        //var $example = $("#especialidad_id-field").select2();
        var a= $('#frm_turnos').serialize();
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
    $('#nivel_id-field').change(function () {
            getCmbGrado();
        });
        function getCmbGrado() {
            //var $example = $("#especialidad_id-field").select2();
            var a = $('#frm_turnos').serialize();
            $.ajax({
                url: '{{ route("grados.getCmbGrados") }}',
                type: 'GET',
                data: "plantel_id=" + $('#plantel_id-field option:selected').val() + "&especialidad_id=" + $('#especialidad_id-field option:selected').val() + "&nivel_id=" + $('#nivel_id-field option:selected').val() + "&grado_id=" + $('#grado_id-field option:selected').val() + "",
                dataType: 'json',
                beforeSend: function () {
                    $("#loading12").show();
                },
                complete: function () {
                    $("#loading12").hide();
                },
                success: function (data) {
                    //alert(data);
                    //$example.select2("destroy");
                    $('#grado_id-field').html('');
                    //$('#especialidad_id-field').empty();
                    $('#grado_id-field').append($('<option></option>').text('Seleccionar').val('0'));
                    $.each(data, function (i) {
                        //alert(data[i].name);
                        $('#grado_id-field').append("<option " + data[i].selectec + " value=\"" + data[i].id + "\">" + data[i].name + "<\/option>");
                    });
                    //$example.select2();
                }
            });
        }
  });
</script>
@endpush                    