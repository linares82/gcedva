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
        @permission('WgaugesXplantel')
        @foreach($gauge as $grf)
        <div class="form-group col-lg-3 col-md-3 col-sm-4 col-xs-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h4 class="box-title">
                        {{$grf['razon']."-".$grf['especialidad']."-".$grf['empleado']}}: 
                    </h4>
                </div>
                <div class="box-body">
                        <div id="velocimetro_{{$grf['id']}}" ></div>
                        Meta del plantel: {{$grf['meta']}}
                        <br/>
                        Inscritos: {{$grf['avance']}}
                        <div class="box-footer clearfix">
                            <a href="{{route('seguimientos.analiticaGraficaEmpleado', array('plantel'=>$grf['plantel_id'],'especialidad'=>$grf['especialidad_id'],'empleado'=>$grf['empleado_id'])) }}" target="_blank" class="btn btn-foursquare btn-sm pull-left">Analitica</a>
                            <a href="{{route('seguimientos.seguimientosGraficaGrfr', array('plantel'=>$grf['plantel_id'],'especialidad'=>$grf['especialidad_id'],'empleado'=>$grf['empleado_id'])) }}" target="_blank" class="btn btn-bitbucket btn-sm"Analitica>G. T. Seguimientos</a>
                            <!--<a href="{{route('seguimientos.analitica_actividadesf')}}" target="_blank" class="btn btn-dropbox btn-sm pull-right">Mensaje</a>-->
                        </div>
                            
                </div>
            </div>
        </div>
        @endforeach
        @endpermission
    </div>
@endsection
@push('scripts')
    <script type="text/javascript" src="{{ asset ('/bower_components/AdminLTE/plugins/morris/morris.js') }}"></script>
    <script type="text/javascript" src="{{ asset ('/bower_components/AdminLTE/plugins/morris/raphael-min.js') }}"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">    
        google.charts.load('current', {'packages':['gauge','corechart', 'bar']});
        @foreach($gauge as $grf)
            google.charts.setOnLoadCallback(drawChart_velocimetro{{$grf['id']}});
        @endforeach

        //Gaugace Chart
        @foreach($gauge as $grf)
        function drawChart_velocimetro{{$grf['id']}}() {
            var data = google.visualization.arrayToDataTable([
            ['Label', 'Value'],
            ['Concretados', {{ $grf['p_avance'] }}],
            ]);

            var options = {
            //width: 400, height: 250,
            greenFrom:90, greenTo: 100,
            yellowFrom:75, yellowTo: 90,
            redFrom: 0, redTo: 75,
            minorTicks: 5
            };

            var chart = new google.visualization.Gauge(document.getElementById('velocimetro_{{$grf["id"]}}'));

            chart.draw(data, options);

        }//End Guagace Chart
        @endforeach

    </script>
@endpush
