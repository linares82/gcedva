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
        <?php if (\Entrust::can('Wanalitica')) : ?>
	<div class="form-group col-md-12 col-sm-12 col-xs-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        Analisis Gráfico global
                    </h3>
                </div>
                <div class="box-body">
                    Analitica de Vendedores <a href="<?php echo e(route('seguimientos.analitica_actividadesf')); ?>" target="_blank">Ver</a><br/>
                    Graficas de avance por vendedor, especialidad y plantel <a href="<?php echo e(route('widgets.metaXespecialidad')); ?>" target="_blank">Ver</a>
                </div>
            </div>
        </div>
        <?php endif; // Entrust::can ?>
    <div class="row">
        <div class="form-group col-md-6 col-sm-6 col-xs-12" style='display: none'>
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        Grafica de Estatus del Mes
                    </h3>
                </div>
                <div class="box-body">
                    
                        <div id="myfirstchart"></div>
                    
                </div>
            </div>
        </div>
        <?php if (\Entrust::can('porcentaje_avance')) : ?>
        <div class="form-group col-md-2 col-sm-2 col-xs-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h4 class="box-title">
                        % Avance hacia la meta: 
                        <?php if($avance<=75): ?>
                            <div class="bg-red">Sigue esforzandote.</div>
                        <?php elseif($avance>75 and $avance<=90): ?>
                            <div class="bg-yellow">Estas cada dia más cerca.</div>
                        <?php elseif($avance>90): ?>
                            <div class="bg-green">Felicidades, aun falta un poco.</div>
                        <?php endif; ?>
                    </h4>
                </div>
                <div class="box-body">
                        <div id="velocimetro" style="height: 180px;"></div>
                </div>
            </div>
        </div>
        <?php endif; // Entrust::can ?>
        <?php if (\Entrust::can('avances_mes1')) : ?>
        <div class="form-group col-md-5 col-sm-5 col-xs-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h4 class="box-title">
                        Avances del mes:
                    </h4>
                </div>
                <div class="box-body">
                    <div id="barras_chart" style="height: 240px;">
                    </div>     
                </div>
            </div>
        </div>
        <?php endif; // Entrust::can ?>
        <?php if (\Entrust::can('avances_mes2')) : ?>
        <div class="form-group col-md-5 col-sm-5 col-xs-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h4 class="box-title">
                        Avances del mes:
                    </h4>
                </div>
                <div class="box-body">
                    <div id="barras_chart2" style="height: 240px;">
                    </div>     
                </div>
            </div>
        </div>
        <?php endif; // Entrust::can ?>
        
        <?php if (\Entrust::can('cifras')) : ?>
        <div class="col-md-3 col-sm-6 col-xs-12">
            <!-- small box -->
            <div class="info-box" >
                <span class="info-box-icon bg-aqua">
                    <h1> <?php echo e($a_1); ?> </h1>
                </span>
                <div class="info-box-content" >
                    <h3><span class="info-box-text"> Pendientes en el mes </span></h3>
                    <!--<a href="<?php echo e(route('seguimientos.reporteSeguimientosXEmpleado', array('estatus'=>1))); ?>" class="small-box-footer">Más Información <i class="fa fa-arrow-circle-right"></i></a>-->
                    <a href="<?php echo e(route('clientes.index').'?q[s]=&q[clientes.nombre_cont]=&q[st_seguimiento_id_cont]=1&q[clientes.plantel_id_cont]='.
                                                        DB::table('empleados')->where('user_id', Auth::user()->id)->value('plantel_id').
                                                        '&q[clientes.empleado_id_cont]='.
                                                        DB::table('empleados')->where('user_id', Auth::user()->id)->value('id').
                                                        '&commit=Buscar'); ?>" 
                    class="small-box-footer">Ver <i class="fa fa-arrow-circle-right"></i></a>
                </div>    
            </div>
            
        </div><!-- ./col -->
        
        <div class="col-md-3 col-sm-6 col-xs-12">
            <!-- small box -->
            <div class="info-box">
                <span class="info-box-icon bg-green">
                    <h1> <?php echo e($a_2); ?> </h1>
                </span>
                <div class="info-box-content">
                    <h3><span class="info-box-text"> Concretados en el mes </span></h3>
                    <!--<a href="<?php echo e(route('seguimientos.reporteSeguimientosXEmpleado', array('estatus'=>2))); ?>" class="small-box-footer">Más Información <i class="fa fa-arrow-circle-right"></i></a>-->
                    <a href="<?php echo e(route('clientes.index').'?q[s]=&q[clientes.nombre_cont]=&q[st_seguimiento_id_cont]=2&q[clientes.plantel_id_cont]='.
                                                        DB::table('empleados')->where('user_id', Auth::user()->id)->value('plantel_id').
                                                        '&q[clientes.empleado_id_cont]='.
                                                        DB::table('empleados')->where('user_id', Auth::user()->id)->value('id').
                                                        '&commit=Buscar'); ?>" 
                    class="small-box-footer">Ver <i class="fa fa-arrow-circle-right"></i></a>
                </div>
                
            </div>
        </div><!-- ./col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
            <!-- small box -->
            <div class="info-box">
                <span class="info-box-icon bg-yellow">
                    <h1> <?php echo e($a_4); ?> </h1>
                </span>
                <div class="info-box-content">
                    <h3><span class="info-box-text"> En proceso en el mes </span></h3>
                    <!--<a href="<?php echo e(route('seguimientos.reporteSeguimientosXEmpleado', array('estatus'=>4))); ?>" class="small-box-footer">Más Información <i class="fa fa-arrow-circle-right"></i></a>-->
                    <a href="<?php echo e(route('clientes.index').'?q[s]=&q[clientes.nombre_cont]=&q[st_seguimiento_id_cont]=4&q[clientes.plantel_id_cont]='.
                                                        DB::table('empleados')->where('user_id', Auth::user()->id)->value('plantel_id').
                                                        '&q[clientes.empleado_id_cont]='.
                                                        DB::table('empleados')->where('user_id', Auth::user()->id)->value('id').
                                                        '&commit=Buscar'); ?>" 
                    class="small-box-footer">Ver <i class="fa fa-arrow-circle-right"></i></a>
                </div>
                
            </div>
        </div><!-- ./col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
            <!-- small box -->
            <div class="info-box">
                <span class="info-box-icon bg-red">
                    <h1> <?php echo e($a_3); ?> </h1>
                </span>
                <div class="info-box-content">
                    <h3><span class="info-box-text"> Rechazados en el mes </span></h3>
                    <!--<a href="<?php echo e(route('seguimientos.reporteSeguimientosXEmpleado', array('estatus'=>3))); ?>" class="small-box-footer">Más Información <i class="fa fa-arrow-circle-right"></i></a>-->
                    <a href="<?php echo e(route('clientes.index').'?q[s]=&q[clientes.nombre_cont]=&q[st_seguimiento_id_cont]=3&q[clientes.plantel_id_cont]='.
                                                        DB::table('empleados')->where('user_id', Auth::user()->id)->value('plantel_id').
                                                        '&q[clientes.empleado_id_cont]='.
                                                        DB::table('empleados')->where('user_id', Auth::user()->id)->value('id').
                                                        '&commit=Buscar'); ?>" 
                    class="small-box-footer">Ver <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div><!-- ./col -->
        <?php endif; // Entrust::can ?>
    </div><!-- /.row -->
        
    <div class="row">
        <div class="form-group col-md-6">
            <div class="box box-danger">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        Avisos del dia
                    </h3>
                </div>
                <div class="box-body">
                    <div class="table">
                        <table class="table table-bordered table-striped dataTable">
                            <thead>
                                <tr>
                                    <th>Fecha</th>
                                    <th>Asunto</th>
                                    <th>Detalle</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $avisos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $a): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td>
                                    <?php if($a->dias_restantes<=0): ?>
                                        <small class="label label-danger">
                                    <?php elseif($a->dias_restantes==1): ?>
                                        <small class="label label-warning"> 
                                    <?php elseif($a->dias_restantes>=2): ?>
                                        <small class="label label-success"> 
                                    <?php endif; ?>
                                        <?php echo e($a->fecha); ?>

                                    </small>
                                    </td>
                                    <td><?php echo e($a->name); ?></td>
                                    <td><?php echo e($a->detalle); ?></td>
                                    <td>
                                        <a class="btn btn-xs btn-primary" href="<?php echo e(route('seguimientos.show', $a->cliente_id)); ?>"><i class="glyphicon glyphicon-edit"></i> Ver Seguimiento</a>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group col-md-6">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        Avisos Generales
                    </h3>
                    <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div>
                </div>
                <div class="box-body" >
                    <div class="table">
                        <table class="table table-bordered table-striped dataTable">
                            <thead>
                                <tr>
                                    <th>De</th>
                                    <th>Asunto</th>
                                    <th><a href="<?php echo e(route('avisoGrals.index')); ?>" class="btn btn-xs btn-info">Ver todos</a></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $avisos_generales; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td>
                                        <?php echo e($ag->usu_alta->name); ?>

                                    </td>
                                    <td>
                                        <?php echo e($ag->avisoGral->desc_corta); ?>

                                    </td>
                                    <td>
                                    <input type="button" class="btn btn-xs btn-success" value="Ver" onclick="DetalleAviso('<?php echo e($ag->aviso_gral_id); ?>')" />
                                    <a href="<?php echo e(route('pivotAvisoGralEmpleados.leido', $ag->id)); ?>" class="btn btn-xs btn-warning">leido</a>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <?php if (\Entrust::can('WgaugesXplantel')) : ?>
        <?php $__currentLoopData = $gauge; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $grf): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="form-group col-lg-3 col-md-3 col-sm-4 col-xs-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h4 class="box-title">
                        <?php echo e($grf['razon']); ?>: 
                    </h4>
                </div>
                <div class="box-body">
                        <div id="velocimetro_<?php echo e($grf['id']); ?>" ></div>
                        Meta del plantel: <?php echo e($grf['meta_total']); ?>

                        <br/>
                        Inscritos: <?php echo e($grf['avance']); ?>

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
        google.charts.setOnLoadCallback(drawChart);
        google.charts.setOnLoadCallback(drawVisualization);
        google.charts.setOnLoadCallback(drawVisualization2);
        <?php $__currentLoopData = $gauge; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $grf): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            google.charts.setOnLoadCallback(drawChart_velocimetro<?php echo e($grf['id']); ?>);
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        var datos=<?php echo $datos; ?>; 
        console.log(datos);

        var datos2=<?php echo $datos2; ?>; 

        function drawVisualization() {
                // Some raw data (not necessarily accurate)
            var data = google.visualization.arrayToDataTable(datos);
            
            var options = {
            title : 'Comparativo Concretados - Meta',
            vAxis: {title: 'Cantidad'},
            hAxis: {title: 'Estatus'},
            seriesType: 'bars',
            //series: {0: {type: 'line'}}

            //colors: ['#5a81f1', '#2dca1d']
            };

            var chart = new google.visualization.ColumnChart(document.getElementById('barras_chart'));
            //var chart = new google.charts.Bar(document.getElementById('barras_chart'));

            chart.draw(data, options);
        }

        function drawVisualization2() {
                // Some raw data (not necessarily accurate)
            var data = google.visualization.arrayToDataTable(datos2);
            
            var options = {
            title : 'Estatus de seguimientos en el mes',
            vAxis: {title: 'Cantidad'},
            hAxis: {title: 'Estatus'},
            seriesType: 'bars',
            //series: {0: {type: 'line'}}

            colors: ['#FF8000']
            };

            var chart = new google.visualization.ColumnChart(document.getElementById('barras_chart2'));
            //var chart = new google.charts.Bar(document.getElementById('barras_chart'));

            chart.draw(data, options);
        }
        

        //Gaugace Chart
        function drawChart() {
            var data = google.visualization.arrayToDataTable([
            ['Label', 'Value'],
            ['Concretados', <?php echo e($avance); ?>],
            ]);

            var options = {
            //width: 400, height: 250,
            greenFrom:90, greenTo: 100,
            yellowFrom:75, yellowTo: 90,
            redFrom: 0, redTo: 75,
            minorTicks: 5
            };

            var chart = new google.visualization.Gauge(document.getElementById('velocimetro'));

            chart.draw(data, options);

        }//End Guagace Chart

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

        /*
        $(function() {
         var chart = new Morris.Bar({
                // ID of the element in which to draw the chart.
                element: 'myfirstchart',
                // Chart data records -- each entry in this array corresponds to a point on
                // the chart.
                data: [0, 0],
                // The name of the data record attribute that contains x-values.
                xkey: 'Estatus',
                // A list of names of data record attributes that contain y-values.
                ykeys: ['Valor'],
                // Labels for the ykeys -- will be displayed when you hover over the
                // chart.
                labels: ['Valor']
                });
        // Fire off an AJAX request to load the data
        $.ajax({
            type: "GET",
            dataType: 'json',
            url: "<?php echo e(route('grfEstatusXEmpleado')); ?>", // This is the URL to the API
            //data: { days: 7 } // Passing a parameter to the API to specify number of days
            })
            .done(function( data ) {
            // When the response to the AJAX request comes back render the chart with new data
                //alert(data);
                chart.setData(data);
            })
            .fail(function() {
            // If there is no communication between the server, show an error
                alert( "error occured" );
            });
        });
        */
        var popup;
        function DetalleAviso(id) {
            popup = window.open("<?php echo e(url('avisoGrals/showModal')); ?>"+"?id="+id, "Popup", "width=800,height=350");
            popup.focus();
            return false
        }
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('plantillas.admin_template', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>