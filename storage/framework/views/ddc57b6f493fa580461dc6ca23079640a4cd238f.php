<?php $__env->startSection('header'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

    <link rel="stylesheet" src="<?php echo e(asset ('/bower_components/AdminLTE/plugins/morris/morris.css')); ?>" />
    <style type="text/css">
        #target {
			width: 600px;
			height: 400px;
		}
    </style>
    <div class="row">
    
    </div>
        
    <div class="row">
        <?php if (\Entrust::can('WgaugesXplantel')) : ?>
        <?php $__currentLoopData = $gauge; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $grf): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="form-group col-lg-3 col-md-3 col-sm-4 col-xs-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h4 class="box-title">
                        <?php echo e($grf['razon']."-".$grf['especialidad']."-".$grf['empleado']); ?>: 
                    </h4>
                </div>
                <div class="box-body">
                        <div id="velocimetro_<?php echo e($grf['id']); ?>" ></div>
                        Meta del plantel: <?php echo e($grf['meta']); ?>

                        <br/>
                        Inscritos: <?php echo e($grf['avance']); ?>

                        <div class="box-footer clearfix">
                            <a href="<?php echo e(route('seguimientos.analiticaGraficaEmpleado', array('plantel'=>$grf['plantel_id'],'especialidad'=>$grf['especialidad_id'],'empleado'=>$grf['empleado_id']))); ?>" target="_blank" class="btn btn-foursquare btn-sm pull-left">Analitica</a>
                            <a href="<?php echo e(route('seguimientos.seguimientosGraficaGrfr', array('plantel'=>$grf['plantel_id'],'especialidad'=>$grf['especialidad_id'],'empleado'=>$grf['empleado_id']))); ?>" target="_blank" class="btn btn-bitbucket btn-sm"Analitica>G. T. Seguimientos</a>
                            <!--<a href="<?php echo e(route('seguimientos.analitica_actividadesf')); ?>" target="_blank" class="btn btn-dropbox btn-sm pull-right">Mensaje</a>-->
                        </div>
                            
                </div>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endif; // Entrust::can ?>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>
    <script type="text/javascript" src="<?php echo e(asset ('/bower_components/AdminLTE/plugins/morris/morris.js')); ?>"></script>
    <script type="text/javascript" src="<?php echo e(asset ('/bower_components/AdminLTE/plugins/morris/raphael-min.js')); ?>"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">    
        google.charts.load('current', {'packages':['gauge','corechart', 'bar']});
        <?php $__currentLoopData = $gauge; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $grf): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            google.charts.setOnLoadCallback(drawChart_velocimetro<?php echo e($grf['id']); ?>);
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        //Gaugace Chart
        <?php $__currentLoopData = $gauge; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $grf): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        function drawChart_velocimetro<?php echo e($grf['id']); ?>() {
            var data = google.visualization.arrayToDataTable([
            ['Label', 'Value'],
            ['Concretados', <?php echo e($grf['p_avance']); ?>],
            ]);

            var options = {
            //width: 400, height: 250,
            greenFrom:90, greenTo: 100,
            yellowFrom:75, yellowTo: 90,
            redFrom: 0, redTo: 75,
            minorTicks: 5
            };

            var chart = new google.visualization.Gauge(document.getElementById('velocimetro_<?php echo e($grf["id"]); ?>'));

            chart.draw(data, options);

        }//End Guagace Chart
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('plantillas.admin_template', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>