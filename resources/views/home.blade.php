@extends('plantillas.admin_template')

@section('header')
@endsection

@section('content')

    <link rel="stylesheet" src="{{ asset ('/bower_components/AdminLTE/plugins/morris/morris.css') }}" />
    <style type="text/css">
        #target {
			width: 600px;
			height: 400px;
		}
    </style>
    <div class="row">
        
    </div>
    <div class="row">
        <div class="form-group col-md-6 col-sm-6 col-xs-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        Grafica de Estatus del Mes
                    </h3>
                </div>
                <div class="box-body">
                    <div class="table">
                        <div id="myfirstchart" style="height: 150px;"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12">
            <!-- small box -->
            <div class="info-box">
                <span class="info-box-icon bg-aqua">
                    <h1> {{$a_1}} </h1>
                </span>
                <div class="info-box-content">
                    <h3><span class="info-box-text"> En proceso en el mes </span></h3>
                    <!--<a href="{{ route('seguimientos.reporteSeguimientosXEmpleado', array('estatus'=>1)) }}" class="small-box-footer">Más Información <i class="fa fa-arrow-circle-right"></i></a>-->
                    <a href="{{ route('clientes.index').'?q[s]=&q[clientes.nombre_cont]=&q[clientes.nombre2_cont]=&q[clientes.ape_paterno_cont]=&q[clientes.ape_materno_cont]=&q[st_seguimiento_id_cont]=1&q[clientes.plantel_id_cont]='.
                                                        DB::table('empleados')->where('user_id', Auth::user()->id)->value('plantel_id').
                                                        '&q[clientes.empleado_id_cont]='.
                                                        DB::table('empleados')->where('user_id', Auth::user()->id)->value('id').
                                                        '&commit=Buscar' }}" 
                    class="small-box-footer">Más Información <i class="fa fa-arrow-circle-right"></i></a>
                </div>    
            </div>
            
        </div><!-- ./col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
            <!-- small box -->
            <div class="info-box">
                <span class="info-box-icon bg-green">
                    <h1> {{$a_2}} </h1>
                </span>
                <div class="info-box-content">
                    <h3><span class="info-box-text"> Concretados en el mes </span></h3>
                    <!--<a href="{{ route('seguimientos.reporteSeguimientosXEmpleado', array('estatus'=>2)) }}" class="small-box-footer">Más Información <i class="fa fa-arrow-circle-right"></i></a>-->
                    <a href="{{ route('clientes.index').'?q[s]=&q[clientes.nombre_cont]=&q[clientes.nombre2_cont]=&q[clientes.ape_paterno_cont]=&q[clientes.ape_materno_cont]=&q[st_seguimiento_id_cont]=2&q[clientes.plantel_id_cont]='.
                                                        DB::table('empleados')->where('user_id', Auth::user()->id)->value('plantel_id').
                                                        '&q[clientes.empleado_id_cont]='.
                                                        DB::table('empleados')->where('user_id', Auth::user()->id)->value('id').
                                                        '&commit=Buscar' }}" 
                    class="small-box-footer">Más Información <i class="fa fa-arrow-circle-right"></i></a>
                </div>
                
            </div>
        </div><!-- ./col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
            <!-- small box -->
            <div class="info-box">
                <span class="info-box-icon bg-yellow">
                    <h1> {{$a_4}} </h1>
                </span>
                <div class="info-box-content">
                    <h3><span class="info-box-text"> Pendientes en el mes </span></h3>
                    <!--<a href="{{ route('seguimientos.reporteSeguimientosXEmpleado', array('estatus'=>4)) }}" class="small-box-footer">Más Información <i class="fa fa-arrow-circle-right"></i></a>-->
                    <a href="{{ route('clientes.index').'?q[s]=&q[clientes.nombre_cont]=&q[clientes.nombre2_cont]=&q[clientes.ape_paterno_cont]=&q[clientes.ape_materno_cont]=&q[st_seguimiento_id_cont]=4&q[clientes.plantel_id_cont]='.
                                                        DB::table('empleados')->where('user_id', Auth::user()->id)->value('plantel_id').
                                                        '&q[clientes.empleado_id_cont]='.
                                                        DB::table('empleados')->where('user_id', Auth::user()->id)->value('id').
                                                        '&commit=Buscar' }}" 
                    class="small-box-footer">Más Información <i class="fa fa-arrow-circle-right"></i></a>
                </div>
                
            </div>
        </div><!-- ./col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
            <!-- small box -->
            <div class="info-box">
                <span class="info-box-icon bg-red">
                    <h1> {{$a_3}} </h1>
                </span>
                <div class="info-box-content">
                    <h3><span class="info-box-text"> Rechazados en el mes </span></h3>
                    <!--<a href="{{ route('seguimientos.reporteSeguimientosXEmpleado', array('estatus'=>3)) }}" class="small-box-footer">Más Información <i class="fa fa-arrow-circle-right"></i></a>-->
                    <a href="{{ route('clientes.index').'?q[s]=&q[clientes.nombre_cont]=&q[clientes.nombre2_cont]=&q[clientes.ape_paterno_cont]=&q[clientes.ape_materno_cont]=&q[st_seguimiento_id_cont]=3&q[clientes.plantel_id_cont]='.
                                                        DB::table('empleados')->where('user_id', Auth::user()->id)->value('plantel_id').
                                                        '&q[clientes.empleado_id_cont]='.
                                                        DB::table('empleados')->where('user_id', Auth::user()->id)->value('id').
                                                        '&commit=Buscar' }}" 
                    class="small-box-footer">Más Información <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div><!-- ./col -->
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
                                @foreach($avisos as $a)
                                <tr>
                                    <td>
                                    @if($a->dias_restantes<=0)
                                        <small class="label label-danger">
                                    @elseif($a->dias_restantes==1)
                                        <small class="label label-warning"> 
                                    @elseif($a->dias_restantes>=2)
                                        <small class="label label-success"> 
                                    @endif
                                        {{$a->fecha}}
                                    </small>
                                    </td>
                                    <td>{{$a->name}}</td>
                                    <td>{{$a->detalle}}</td>
                                    <td>
                                        <a class="btn btn-xs btn-primary" href="{{ route('seguimientos.show', $a->cliente_id) }}"><i class="glyphicon glyphicon-edit"></i> Ver Seguimiento</a>
                                    </td>
                                </tr>
                                @endforeach
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
                                    <th>Desc. Corta</th>
                                    <th>Aviso</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($avisos_generales as $ag)
                                <tr>
                                    <td>
                                        {{$ag->desc_corta}}
                                    </td>
                                    <td>{{$ag->aviso}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@push('scripts')
    <script type="text/javascript" src="{{ asset ('/bower_components/AdminLTE/plugins/morris/morris.js') }}"></script>
    <script type="text/javascript" src="{{ asset ('/bower_components/AdminLTE/plugins/morris/raphael-min.js') }}"></script>
    <script type="text/javascript">    
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
            url: "{{route('grfEstatusXEmpleado')}}", // This is the URL to the API
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
        
    </script>
@endpush