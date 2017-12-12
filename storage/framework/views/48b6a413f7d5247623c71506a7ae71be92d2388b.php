<div class="form-group col-md-4 <?php if($errors->has('lectivo_id')): ?> has-error <?php endif; ?>">
    <label for="lectivo_id-field">Lectivo</label>
    <?php echo Form::select("lectivo_id", $list["Lectivo"], null, array("class" => "form-control select_seguridad", "id" => "lectivo_id-field")); ?>

    <?php if($errors->has("lectivo_id")): ?>
    <span class="help-block"><?php echo e($errors->first("lectivo_id")); ?></span>
    <?php endif; ?>
</div>
<div class="form-group col-md-4 <?php if($errors->has('ponderacion_id')): ?> has-error <?php endif; ?>">
    <label for="ponderacion_id-field">Ponderacion</label>
    <?php echo Form::select("ponderacion_id", $list["Ponderacion"], null, array("class" => "form-control select_seguridad", "id" => "ponderacion_id-field")); ?>

    <?php if($errors->has("ponderacion_id")): ?>
    <span class="help-block"><?php echo e($errors->first("ponderacion_id")); ?></span>
    <?php endif; ?>
</div>
<div class="form-group col-md-4 <?php if($errors->has('carga_ponderacion_id')): ?> has-error <?php endif; ?>">
    <label for="carga_ponderacion_id-field">Carga Ponderacion</label>
    <?php echo Form::select("carga_ponderacion_id", $list["CargaPonderacion"], null, array("class" => "form-control select_seguridad", "id" => "carga_ponderacion_id-field")); ?>

    <div id='loading10' style='display: none'><img src="<?php echo e(asset('images/ajax-loader.gif')); ?>" title="Enviando" /></div> 
    <?php if($errors->has("carga_ponderacion_id")): ?>
    <span class="help-block"><?php echo e($errors->first("carga_ponderacion_id")); ?></span>
    <?php endif; ?>
</div>
<div class="form-group col-md-4 <?php if($errors->has('v_inicio')): ?> has-error <?php endif; ?>">
    <label for="v_inicio-field">Inicio</label>
    <?php echo Form::text("v_inicio", null, array("class" => "form-control", "id" => "v_inicio-field")); ?>

    <?php if($errors->has("v_inicio")): ?>
    <span class="help-block"><?php echo e($errors->first("v_inicio")); ?></span>
    <?php endif; ?>
</div>
<div class="form-group col-md-4 <?php if($errors->has('v_fin')): ?> has-error <?php endif; ?>">
    <label for="v_fin-field">Fin</label>
    <?php echo Form::text("v_fin", null, array("class" => "form-control", "id" => "v_fin-field")); ?>

    <?php if($errors->has("v_fin")): ?>
    <span class="help-block"><?php echo e($errors->first("v_fin")); ?></span>
    <?php endif; ?>
</div>

<?php $__env->startPush('scripts'); ?>
<script type="text/javascript">
    $(document).ready(function() {
        $('#v_inicio-field').Zebra_DatePicker({
            days: ['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'],
            months: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
            readonly_element: false,
            lang_clear_date: 'Limpiar',
            show_select_today: 'Hoy',
        });
        $('#v_fin-field').Zebra_DatePicker({
            days: ['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'],
            months: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
            readonly_element: false,
            lang_clear_date: 'Limpiar',
            show_select_today: 'Hoy',
        });
        
        getCmbEspecialidad();
        
        $('#ponderacion_id-field').change(function(){
            getCmbEspecialidad();
        });
    });
    
    

    function getCmbEspecialidad() {
        //var $example = $("#especialidad_id-field").select2();
        var a = $('#frm_cliente').serialize();
        $.ajax({
            url: '<?php echo e(route("cargaPonderacions.getCmbCarga")); ?>',
            type: 'GET',
            data: "ponderacion_id=" + $('#ponderacion_id-field option:selected').val() + "&carga_ponderacion_id=" + $('#carga_ponderacion_id-field option:selected').val() + "",
            dataType: 'json',
            beforeSend: function () {
                $("#loading10").show();
            },
            complete: function () {
                $("#loading10").hide();
            },
            success: function (data) {
                //$example.select2("destroy");
                $('#carga_ponderacion_id-field').empty();
                $('#carga_ponderacion_id-field').append($('<option></option>').text('Seleccionar').val('0'));
                $.each(data, function (i) {
                    //alert(data[i].name);
                    $('#carga_ponderacion_id-field').append("<option " + data[i].selectec + " value=\"" + data[i].id + "\">" + data[i].name + "<\/option>");
                });
                //$example.select2();
            }
        });
    }

</script>
<?php $__env->stopPush(); ?>
