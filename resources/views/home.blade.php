@extends('plantillas.admin_template')

@section('header')
@endsection

@section('content')

    <link rel="stylesheet" src="{{ asset ('/bower_components/AdminLTE/plugins/morris/morris.css') }}" />
<!--    <style type="text/css">
        #target {
			width: 600px;
			height: 400px;
		}
    </style>-->
    
    @permission('Wanalitica')
    <div class="form-group col-md-12 col-sm-12 col-xs-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">
                    Analisis Gráfico global
                </h3>
            </div>
            <div class="box-body">
                Analitica de Vendedores <a href="{{route('seguimientos.analitica_actividadesf')}}" target="_blank">Ver</a><br/>
                Graficas de avance por vendedor, especialidad y plantel <a href="{{route('widgets.metaXespecialidad')}}" target="_blank">Ver</a>
            </div>
        </div>
    </div>
    @endpermission
    
    @if (Auth::user()->can('autorizacionBaja.aut_servicios_escolares') or 
    Auth::user()->can('autorizacionBaja.aut_caja') or
    Auth::user()->can('autorizacionBaja.aut_servicios_escolares_c'))
    <div class="form-group col-md-12 col-sm-12 col-xs-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">
                    Autorizaciones Bajas
                </h3>
            </div>
            <div class="box-body">
                <table class="table table-bordered table-striped dataTable">
                    <thead><th>Cliente</th><th>Justificacion</th><th>A. Servicios Escolares</th><th>A. Caja</th><th>A. Servicios Escolares C.</th><th></th></thead>
                    <tbody>
                        @foreach ($bajas as $baja)
                        @if($baja->id>1011)
                        @if($baja->aut_ser_esc<>2 or $baja->aut_caja<>2 or $baja->aut_ser_esc_corp<>2)
                            <tr>
                            <td> <a href="{{route('clientes.edit',$baja->cliente_id)}}" target=_blank>{{$baja->cliente_id}}</a></td>
                            <td>{{$baja->descripcion}}</td>
                            <td>{{optional($baja->autSerEsc)->name}}</td>
                            <td>{{optional($baja->autCaja)->name}}</td>
                            <td>{{optional($baja->autSerEscCorp)->name}}</td>
                            <td><a class="btn btn-xs btn-warning" href="{{ route('historiaClientes.index',array('q[cliente_id_lt]'=>$baja->cliente->id)) }}" target='_blank'><i class="glyphicon glyphicon-plus"></i> Ver</a></td>
                            </tr>
                        @endif
                        @endif
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif

     <div class="form-group col-md-12">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        Autorizacion de becas
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
                                    <th>Cliente</th>
                                    <th>Solicitud</th>
                                    <th>Fecha</th>
                                    <th>A. Caja P.</th>
                                    <th>A. Director P.</th>
                                    <th>A. Caja C.</th>
                                    <th>A. Serv. Esc. C.</th>
                                    <th>A. Final</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($becas as $beca)
                                @if($beca->id > 561)
                                <tr>
                                    <td>
                                        <a href="{{route('clientes.edit',$beca->cliente)}}" target=_blank>{{$beca->cliente}}</a>
                                    </td>
                                    <td>
                                        {{$beca->solicitud}}
                                    </td>
                                    <td>
                                        {{$beca->created_at}}
                                    </td>
                                    <td>{{$beca->aut_caja_plantel}}</td>
                                    <td>{{$beca->aut_dir_plantel}}</td>
                                    <td>{{$beca->aut_caja_corp}}</td>
                                    <td>{{$beca->aut_ser_esc}}</td>
                                    <td>{{$beca->aut_dueno}}</td>
                                    <td>
                                    <a class="btn btn-xs bg-purple" target=_blank href="{{ route('autorizacionBecas.findByClienteId', array('cliente_id'=>$beca->cliente)) }}">
                                        <i class="fa fa-eye"></i> S. Becas
                                    </a>
                                    </td>
                                </tr>
                                @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    @permission('indicadores_plantels')
    @php
    $empleado=App\Empleado::where('user_id',Auth::user()->id)->first();
    
    @endphp
    @foreach($empleado->plantels as $plantel)
    <div class="row">
        <div class="form-group col-md-12 col-sm-12 col-xs-12">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        Indicadores 
                        Plantel: {!!  
                                DB::table('plantels')->where('id',$plantel->id)->value('razon'); 
                        !!}
                    </h3>
                </div>
                <div class="box-body">
                    <div class="form-group col-md-2 col-sm-2 col-xs-2">
                        <h4>% Asistencia Semana Anterior</h4>
                    <div id="wAsistencias_{{ $plantel->id }}" style="height: 150px;">
                        <div id='loading30{{ $plantel->id }}' style='display: none'><img src="{{ asset('images/ajax-loader.gif') }}" title="Enviando" /></div> 
                    </div>
                    <a href="{{route('inscripcions.widgetPorcentajeAsistenciaDetalle', array('plantel'=>$plantel->id))}}" class="btn btn-xs btn-success" target="_blank">Detalle</a>
                    </div>
                    
                    <div class="form-group col-md-2 col-sm-2 col-xs-2">
                        <h4 id="titulo_concretados{{ $plantel->id }}"> </h4>
                    <div id='loading31{{ $plantel->id }}' style='display: none'><img src="{{ asset('images/ajax-loader.gif') }}" title="Enviando" /></div> 
                    <div id="wConcretados{{ $plantel->id }}" style="height: 150px;">
                    </div>
                    <div id="wConcretados_pie{{ $plantel->id }}">
                    </div>
                    <a href="{{route('home.wConcretadosDetalle', array('plantel'=>$plantel->id))}}" class="btn btn-xs btn-success" target="_blank">Detalle</a>
                    </div>
                    
                    <div class="form-group col-md-2 col-sm-2 col-xs-2">
                        <h4 class="box-title">Porcentaje de pago del mes en curso</h4>
                        @php
    
                        $date=date('Y-m-d');
                        //dd($date);
                        $fecha_f=\Carbon\Carbon::createFromFormat('Y-m-d',$date);
                        $fecha_f->day=01;
                        
                        $fecha_t=\Carbon\Carbon::createFromFormat('Y-m-d',$date);
                        if($fecha_t->month==2){
                            $fecha_t->day=28;
                        }
                        $fecha_t->day=30;
                        //dd($fecha_t->toDateString('Y-m-d'));
                        $planteles=App\Plantel::pluck('razon','id');
                        @endphp
                        
                        <div class="form-group col-md-12 col-sm-12 col-xs-12">
                            <div class="box-body">   
                                <div id="porcentaj_pago{{ $plantel->id }}" style="height: 150px;">
                                        <div id='loading{{ $plantel->id }}' style='display: none'><img src="{{ asset('images/ajax-loader.gif') }}" title="Enviando" /></div>  
                                </div>
                                @permission('adeudos.maestroIndicadorDetalle')     
                                {!! Form::open(['route' => array('adeudos.maestroIndicadorDetalle'),'method' => 'post', 'style' => 'display: inline;']) !!}
                                {!! Form::hidden("fecha_f", $fecha_f->toDateString('Y-m-d'), array("class" => "form-control input-sm", "id" => "fecha_f-field")) !!}
                                {!! Form::hidden("fecha_t", $fecha_t->toDateString('Y-m-d'), array("class" => "form-control input-sm", "id" => "fecha_t-field")) !!}
                                {!! Form::select("plantel_f[]", $planteles, $plantel->id, array("class" => "form-control select_seguridad select_oculto", "id" => "plantel_f-field", 'multiple'=>true)) !!}
                                <label for="detalle_f-field">Con detalle:</label>
                                {!! Form::select("detalle_f", array('1'=>'Si','2'=>'No'), null, array("class" => "form-control select_seguridad", "id" => "detalle_f-field")) !!}
                                    <button type="submit" class="btn btn-xs btn-success"><i class="glyphicon glyphicon-ok"></i> Ver Maestro</button>
                                {!! Form::close() !!} 
                                @endpermission
                            </div>
                        </div>
                    </div>

                    <div class="form-group col-md-2 col-sm-2 col-xs-2">
                        <h4>Promedio General Mes Anterior</h4>
                        <div id="wCalificacion_{{$plantel->id}}" style="height: 150px;">
                            <div id='loading33_{{$plantel->id}}' style='display: none'><img src="{{ asset('images/ajax-loader.gif') }}" title="Enviando" /></div> 
                        </div>
                        <a class="btn btn-xs btn-success" target="_blank" href="{{route('inscripcions.wdCalificacionRDetalle',array('plantel'=>$plantel->id))}}">Detalle</a>   
                    </div>

                    <div class="form-group col-md-2 col-sm-2 col-xs-2">
                        <h4>Bajas Mes Anterior</h4>
                        <div id="wBajas_{{$plantel->id}}" style="height: 150px;">
                            <div id='loading34_{{$plantel->id}}' style='display: none'><img src="{{ asset('images/ajax-loader.gif') }}" title="Enviando" /></div> 
                        </div>
                        <a class="btn btn-xs btn-success" target="_blank" href="{{route('historiaClientes.wdBajasDetalle',array('plantel'=>$plantel->id))}}">Detalle</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
    @endpermission


    @role('CAJA')
    <div class="form-group col-md-2 col-sm-2 col-xs-2">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">
                    Adeudos
                </h3>
            </div>
            <div class="box-body">
                <div id='loading3' style='display: none'><img src="{{ asset('images/ajax-loader.gif') }}" title="Enviando" /></div> 
                <span id='adeudos_cantidad'></span>
            </div>
        </div>
    </div>
    @endrole
    
    @permission('repDireccion')
    
    @permission('wGEstatusTotales')
	<div class="form-group col-md-4 col-sm-4 col-xs-4">
            <div class="box box-primary">
                <div class="box-header with-bord1er">
                    <h3 class="box-title">
                        Estatus Totales
                    </h3>
                </div>
                <div class="box-body">
                    <div id="estatus_totales" style="width: auto; height: auto;">
                    </div>
                    
                </div>
            </div>
        </div>
    @endpermission
    
        <div class="form-group col-md-4 col-sm-4 col-xs-4">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        Concretados Por Periodo Lectivo
                    </h3>
                </div>
                <div class="box-body">
                    <div id="estatus_concretados" style="width: auto; height: auto;">
                    </div>
                    @foreach($lectivoss as $l)
                        <a href="{{route('direccion.grfr', array('lectivo'=>$l->id))}}" class="btn btn-xs btn-primary">Análisis Concretados {{$l->name}}</a>
                    @endforeach
                </div>
            </div>
        </div>
        
        
    @endpermission   
        
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
        @permission('porcentaje_avance')
        <div class="form-group col-md-2 col-sm-2 col-xs-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h4 class="box-title">
                        % Avance hacia la meta: 
                        @if($avance<=75)
                            <div class="bg-red">Sigue esforzandote.</div>
                        @elseif($avance>75 and $avance<=90)
                            <div class="bg-yellow">Estas cada dia más cerca.</div>
                        @elseif($avance>90)
                            <div class="bg-green">Felicidades, aun falta un poco.</div>
                        @endif
                    </h4>
                </div>
                <div class="box-body">
                        <div id="velocimetro" style="height: 180px;"></div>
                </div>
            </div>
        </div>
        @endpermission
        @permission('avances_mes1')
        @if(count($fil)>0)
        <?php $i=0; ?>
        @foreach($fil as $f)
            <div class="form-group col-md-5 col-sm-5 col-xs-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h4 class="box-title" id=''>
                            CONCRETADOS
                        </h4>
                    </div>
                    <div class="box-body">    
                            <div id="barras_chart_{{$i}}" style="height: 238px;">
                            </div>

                    </div>     
                </div>
            </div>
            <?php $i++;?>
        @endforeach
        @endif
        <!--</div>-->
        
        @foreach($a_2 as $a)
        <div class="col-md-3 col-sm-6 col-xs-12">
            <!-- small box -->
            <div class="info-box">
                <span class="info-box-icon bg-green">
                    <h1> {{$a[0]}} </h1>
                </span>
                <div class="info-box-content">
                     CONCRETADOS EN  {{ $a[1] }} <br/>
                    <!--<a href="{{ route('seguimientos.reporteSeguimientosXEmpleado', array('estatus'=>2)) }}" class="small-box-footer">Más Información <i class="fa fa-arrow-circle-right"></i></a>-->
                    <a href="{{ route('clientes.index').'?q[s]=&q[clientes.nombre_cont]=&q[st_seguimiento_id_cont]=2&q[clientes.plantel_id_cont]='.
                                                        DB::table('empleados')->where('user_id', Auth::user()->id)->value('plantel_id').
                                                        '&q[clientes.empleado_id_cont]='.
                                                        DB::table('empleados')->where('user_id', Auth::user()->id)->value('id').
                                                        '&commit=Buscar' }}" 
                    class="small-box-footer">Ver <i class="fa fa-arrow-circle-right"></i></a>
                </div>
                
            </div>
        </div><!-- ./col -->
        @endforeach
        
        @endpermission
    </div>    
    <div class='row'>
        @permission('avances_mes2')
    
        <div class="form-group col-md-6 col-sm-6 col-xs-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h4 class="box-title">
                        Estatus Totales:
                    </h4>
                </div>
                <div class="box-body">
                    <div id="barras_chart2" style="height: 240px;">
                    </div>     
                </div>
            </div>
        </div>
        @endpermission
        
        @permission('cifras')
        <div class="col-md-3 col-sm-6 col-xs-12">
            <!-- small box -->
            <div class="info-box" >
                <span class="info-box-icon bg-aqua">
                    <h1> {{$a_1}} </h1>
                </span>
                <div class="info-box-content" >
                    <h3><span class="info-box-text"> Pendientes totales </span></h3>
                    <!--<a href="{{ route('seguimientos.reporteSeguimientosXEmpleado', array('estatus'=>1)) }}" class="small-box-footer">Más Información <i class="fa fa-arrow-circle-right"></i></a>-->
                    <a href="{{ route('clientes.index').'?q[s]=&q[clientes.nombre_cont]=&q[st_seguimiento_id_cont]=1'.
                                                        '&q[clientes.empleado_id_cont]='.
                                                        DB::table('empleados')->where('user_id', Auth::user()->id)->value('id').
                                                        '&commit=Buscar' }}" 
                    class="small-box-footer">Ver <i class="fa fa-arrow-circle-right"></i></a>
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
                    <h3><span class="info-box-text"> En proceso totales </span></h3>
                    <!--<a href="{{ route('seguimientos.reporteSeguimientosXEmpleado', array('estatus'=>4)) }}" class="small-box-footer">Más Información <i class="fa fa-arrow-circle-right"></i></a>-->
                    <a href="{{ route('clientes.index').'?q[s]=&q[clientes.nombre_cont]=&q[st_seguimiento_id_cont]=4&'.
                                                        '&q[clientes.empleado_id_cont]='.
                                                        DB::table('empleados')->where('user_id', Auth::user()->id)->value('id').
                                                        '&commit=Buscar' }}" 
                    class="small-box-footer">Ver <i class="fa fa-arrow-circle-right"></i></a>
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
                    <h3><span class="info-box-text"> Rechazados totales </span></h3>
                    <!--<a href="{{ route('seguimientos.reporteSeguimientosXEmpleado', array('estatus'=>3)) }}" class="small-box-footer">Más Información <i class="fa fa-arrow-circle-right"></i></a>-->
                    <a href="{{ route('clientes.index').'?q[s]=&q[clientes.nombre_cont]=&q[st_seguimiento_id_lt]=3'.
                                                        //DB::table('empleados')->where('user_id', Auth::user()->id)->value('plantel_id').
                                                        '&q[clientes.empleado_id_lt]='.
                                                        DB::table('empleados')->where('user_id', Auth::user()->id)->value('id').
                                                        '&commit=Buscar' }}" 
                    class="small-box-footer">Ver <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div><!-- ./col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
            <!-- small box -->
            <div class="info-box">
                <span class="info-box-icon bg-yellow">
                    <h1> {{$a_5}} </h1>
                </span>
                <div class="info-box-content">
                    <h3><span class="info-box-text"> En proceso totales </span></h3>
                    <!--<a href="{{ route('seguimientos.reporteSeguimientosXEmpleado', array('estatus'=>4)) }}" class="small-box-footer">Más Información <i class="fa fa-arrow-circle-right"></i></a>-->
                    <a href="{{ route('clientes.index').'?q[s]=&q[clientes.nombre_cont]=&q[st_seguimiento_id_cont]=5&'.
                                                        '&q[clientes.empleado_id_cont]='.
                                                        DB::table('empleados')->where('user_id', Auth::user()->id)->value('id').
                                                        '&commit=Buscar' }}" 
                    class="small-box-footer">Ver <i class="fa fa-arrow-circle-right"></i></a>
                </div>
                
            </div>
        </div><!-- ./col -->
        @endpermission
    </div><!-- /.row -->
    
    
    <div class="row">
        <div class="form-group col-md-6 col-sm-6 col-xs-12">
            <div class="box box-danger">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        Avisos del dia - Clientes
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
        
        <div class="row">
        <div class="form-group col-md-6 col-sm-6 col-xs-12">
            <div class="box box-danger">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        Avisos del dia - Empresas
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
                                @foreach($avisosEmpresas as $a)
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
                                        <a class="btn btn-xs btn-primary" href="{{ route('empresas.seguimiento', $a->empresa_id) }}"><i class="glyphicon glyphicon-edit"></i> Ver Seguimiento</a>
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
                                    <th>De</th>
                                    <th>Asunto</th>
                                    <th><a href="{{route('avisoGrals.index')}}" class="btn btn-xs btn-info">Ver todos</a></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($avisos_generales as $ag)
                                <tr>
                                    <td>
                                        {{ $ag->usu_alta->name }}
                                    </td>
                                    <td>
                                        {{$ag->avisoGral->desc_corta}}
                                    </td>
                                    <td>
                                    <input type="button" class="btn btn-xs btn-success" value="Ver" onclick="DetalleAviso('{{ $ag->aviso_gral_id }}')" />
                                    <a href="{{route('pivotAvisoGralEmpleados.leido', $ag->id)}}" class="btn btn-xs btn-warning">leido</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
       
    </div>
    <div class="row">
        
    </div>
    
    <div class="row">
        @permission('WStPlantelAsesor')
        <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h4 class="box-title">
                        
                    </h4>
                </div>
                <div class="box-body">
                    <div id="chart_div" style="width: auto; height: 300px;"></div>
                    <table class="table table-condensed table-striped">
                            <tbody>
                                <?php $i=0; ?>
                                @foreach($tabla as $ln)
                                <?php $i++; ?>
                                @if($i==1)
                                <tr>
                                    <th>{{$ln[0]}}</th><th>{{$ln[1]}}</th><th>{{$ln[2]}}</th><th>{{$ln[3]}}</th><th>{{$ln[4]}}</th><th>{{$ln[5]}}</th><th>{{$ln[6]}}</th>
                                </tr> 
                                @else
                                <tr>
                                    <td>{{$ln[0]}}</td><td>{{$ln[1]}}</td><td>{{$ln[2]}}</td><td>{{$ln[3]}}</td><td>{{$ln[4]}}</td><td>{{$ln[5]}}</td><td>{{$ln[6]}}</td>
                                </tr>     
                                @endif
                                @endforeach
                            </tbody>
                        </table>
                </div>
            </div>
        </div>
        @endpermission
        @permission('WEstatusXplantel')
        <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h4 class="box-title">
                        Totales de Estatus del Plantel {{$plantel}}
                    </h4>
                </div>
                <div class="box-body">
                    @foreach($estatusPlantel as $ep)
                    @if($ep->estatus=='Pendiente') 
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <div class="info-box bg-aqua">
                          <span class="info-box-icon"><i class="fa fa-bookmark-o"></i></span>
                          <div class="info-box-content">
                            <span class="info-box-text">{{$ep->estatus}}</span>
                            <span class="info-box-number">{{$ep->total}}</span>
                            <div class="progress">
                              <div class="progress-bar" style="width: {{($ep->total*100)/$tsuma}}%"></div>
                            </div>
                            <span class="progress-description">
                              {{round(($ep->total*100)/$tsuma,2)}}% De un total de {{$tsuma}} 
                            </span>
                          </div><!-- /.info-box-content -->
                        </div><!-- /.info-box -->
                    </div><!-- /.col -->
                    @elseif($ep->estatus=='Concretado') 
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <div class="info-box bg-green">
                          <span class="info-box-icon"><i class="fa fa-bookmark-o"></i></span>
                          <div class="info-box-content">
                            <span class="info-box-text">{{$ep->estatus}}</span>
                            <span class="info-box-number">{{$ep->total}}</span>
                            <div class="progress">
                              <div class="progress-bar" style="width: {{($ep->total*100)/$tsuma}}%"></div>
                            </div>
                            <span class="progress-description">
                              {{round(($ep->total*100)/$tsuma,2)}}% De un total de {{$tsuma}} 
                            </span>
                          </div><!-- /.info-box-content -->
                        </div><!-- /.info-box -->
                    </div><!-- /.col -->
                    @elseif($ep->estatus=='Rechazado') 
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <div class="info-box bg-red">
                          <span class="info-box-icon"><i class="fa fa-bookmark-o"></i></span>
                          <div class="info-box-content">
                            <span class="info-box-text">{{$ep->estatus}}</span>
                            <span class="info-box-number">{{$ep->total}}</span>
                            <div class="progress">
                              <div class="progress-bar" style="width: {{($ep->total*100)/$tsuma}}%"></div>
                            </div>
                            <span class="progress-description">
                              {{round(($ep->total*100)/$tsuma,2)}}% De un total de {{$tsuma}} 
                            </span>
                          </div><!-- /.info-box-content -->
                        </div><!-- /.info-box -->
                    </div><!-- /.col -->
                    @elseif($ep->estatus=='En proceso') 
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <div class="info-box bg-yellow">
                          <span class="info-box-icon"><i class="fa fa-bookmark-o"></i></span>
                          <div class="info-box-content">
                            <span class="info-box-text">{{$ep->estatus}}</span>
                            <span class="info-box-number">{{$ep->total}}</span>
                            <div class="progress">
                              <div class="progress-bar" style="width: {{($ep->total*100)/$tsuma}}%"></div>
                            </div>
                            <span class="progress-description">
                              {{round(($ep->total*100)/$tsuma,2)}}% De un total de {{$tsuma}} 
                            </span>
                          </div><!-- /.info-box-content -->
                        </div><!-- /.info-box -->
                    </div><!-- /.col -->
                    @endif
                    @endforeach
            </div>
        </div>
        @endpermission
    </div>
    
    
@endsection
@push('scripts')
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      $(document).ready(function(){
         $.ajax({
            type: 'GET',
            cache: true,
            url: '{{route("cajas.adeudosXplantelWidget")}}',
            beforeSend : function(){$("#loading3").show(); },
            complete : function(){$("#loading3").hide(); },
            success: function(data) {
                href="{{ route('cajas.adeudosXplantel')}}";
                $('#adeudos_cantidad').html('<a class="btn btn-sm btn-warning" target="_blank" href="'+href+'">'+data+' Adeudos<a>');
            }
            });
        //porcentajePago(); 
        
        $(".select_oculto").select2().next().hide();
        
      });  

      function porcentajePago(){
        @php
        $empleado=App\Empleado::where('user_id',Auth::user()->id)->first();
        $date=date('Y-m-d');
        $fecha_f=\Carbon\Carbon::createFromFormat('Y-m-d',$date);
        $fecha_f->day=01;
        $fecha_t=\Carbon\Carbon::createFromFormat('Y-m-d',$date);
        if($fecha_t->month==2){
            $fecha_t->day=28;
        }
        $fecha_t->day=30;
        @endphp
        
        $.ajax({
            type: 'POST',
            url: '{{route("adeudos.maestroIndicador")}}',
            cache: true,
            data: {
                'plantel': {{$empleado->plantel_id}},
                'fecha_f': {{$fecha_f->toDateString('Y-m-d')}},
                'fecha_t': {{$fecha_t->toDateString('Y-m-d')}}                
            },
            beforeSend : function(){$("#loading3").show(); },
            complete : function(){$("#loading3").hide(); },
            success: function(data) {
                //location.reload();
            },
        });
      }
        
        
      google.charts.load('current', {'packages':['corechart','bar']});
      @permission('WStPlantelAsesor')
      google.charts.setOnLoadCallback(drawVisualization);
      @endpermission
      @permission('wGEstatusTotales')
      google.charts.setOnLoadCallback(drawgrfDir1);
      @endpermission
      google.charts.setOnLoadCallback(drawgrfDir2);
      //google.charts.setOnLoadCallback(drawgrfDir3);

      @permission('WStPlantelAsesor')  
    function drawVisualization() {
        // Some raw data (not necessarily accurate)
        var data = google.visualization.arrayToDataTable(<?php echo $datos_grafica; ?>);

        var options = {
          title : 'Concretado por periodo y Totales de estatus por Empleado del plantel {{$plantel}}',
          vAxis: {title: 'Cantidad de Clientes por Estatus'},
          hAxis: {title: 'Empleado'},
          seriesType: 'bars'
        };

        var chart = new google.visualization.ComboChart(document.getElementById('chart_div'));
        chart.draw(data, options);
    }
    @endpermission
    
    @permission('wGEstatusTotales')
    function drawgrfDir1() {
        // Some raw data (not necessarily accurate)
        var dataA = google.visualization.arrayToDataTable(<?php echo $grfDir1; ?>);

        var optionsA = {
          title : '',
          vAxis: {title: 'Cantidad Clientes Por Estatus'},
          hAxis: {title: 'Estatus'},
          seriesType: 'bars',
          series: {
                0:{color: 'red'},
          }
        };
        
        var chartA = new google.visualization.ComboChart(document.getElementById('estatus_totales'));
        chartA.draw(dataA, optionsA);
    }
    @endpermission
    
    function drawgrfDir2() {
        // Some raw data (not necessarily accurate)
        var dataA = google.visualization.arrayToDataTable(<?php echo $grfDir2; ?>);

        var optionsA = {
          title : '',
          vAxis: {title: 'Cantidad Clientes Por Estatus'},
          hAxis: {title: 'Estatus'},
          seriesType: 'bars',
          series: {
                0:{color: 'orange'},
          }
        };
        
        var chartA = new google.visualization.ComboChart(document.getElementById('estatus_concretados'));
        chartA.draw(dataA, optionsA);
    }
    
    /*function drawgrfDir3() {
        // Some raw data (not necessarily accurate)
        var dataA = google.visualization.arrayToDataTable();

        var optionsA = {
          title : '',
          vAxis: {title: 'Cantidad Clientes Por Estatus'},
          hAxis: {title: 'Estatus'},
          seriesType: 'bars',
          series: {
                0:{color: 'purple'},
          }
        };
        
        var chartA = new google.visualization.ComboChart(document.getElementById('grfDir3'));
        chartA.draw(dataA, optionsA);
    }
    */
    </script>
    <script type="text/javascript" src="{{ asset ('/bower_components/AdminLTE/plugins/morris/morris.js') }}"></script>
    <script type="text/javascript" src="{{ asset ('/bower_components/AdminLTE/plugins/morris/raphael-min.js') }}"></script>
    
    <script type="text/javascript">    
        google.charts.load('current', {'packages':['gauge','corechart', 'bar']});
        google.charts.setOnLoadCallback(drawChart);
        @permission('widget_maestroIndicador')
        google.charts.setOnLoadCallback(drawChart_maestroIndicador);
        @endpermission
        @permission('avances_mes2')
        google.charts.setOnLoadCallback(drawVisualization2);
        @endpermission
        google.charts.setOnLoadCallback(drawChart_wAsistencias);
        google.charts.setOnLoadCallback(drawChart_wConcretados);
        google.charts.setOnLoadCallback(drawChart_wCalificacion);
        google.charts.setOnLoadCallback(drawChart_wBajas);

        @permission('indicadores_plantels')
        @foreach($plantels as $plantel)
        google.charts.setOnLoadCallback(drawChart_wAsistencias_{{ $plantel->id }});
        google.charts.setOnLoadCallback(drawChart_wConcretados{{ $plantel->id }});
        google.charts.setOnLoadCallback(drawChart_maestroIndicador{{ $plantel->id }});
        google.charts.setOnLoadCallback(drawChart_wCalificacion_{{ $plantel->id }});
        google.charts.setOnLoadCallback(drawChart_wBajas_{{ $plantel->id }});
        
        @endforeach
        @endpermission

        

        <?php $i=0; ?>
        @if(count($fil)>0)
            @foreach($fil as $f)
                var datos_{{$i}}=<?php echo json_encode($fil[$i]); ?>; 
                
                google.charts.setOnLoadCallback(drawVisualization_{{$i}});
                
                function drawVisualization_{{$i}}() {
                // Some raw data (not necessarily accurate)
                    var data = google.visualization.arrayToDataTable(datos_{{$i}});

                    var options = {
                    title : 'Comparativo Concretados - Meta ',
                    vAxis: {title: 'Cantidad'},
                    hAxis: {title: 'Estatus'},
                    seriesType: 'bars',
                    //series: {0: {type: 'line'}}
                    
                    //colors: ['#5a81f1', '#2dca1d']
                    };

                    var chart = new google.visualization.ColumnChart(document.getElementById('barras_chart_{{$i}}'));
                    //var chart = new google.charts.Bar(document.getElementById('barras_chart'));

                    chart.draw(data, options);
                }
                <?php $i++; ?>
            @endforeach
        @endif
        
        
        @permission('avances_mes2')
        var datos2=<?php echo $datos2; ?>; 

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
        @endpermission
        

        //Gaugace Chart
        function drawChart() {
            var data = google.visualization.arrayToDataTable([
            ['Label', 'Value'],
            ['Concretados', {{ $avance[0] }}],
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
        @permission('widget_maestroIndicador')
        function drawChart_maestroIndicador() {
            $.ajax({
                type: 'GET',
                url: '{{route("adeudos.maestroIndicador")}}',
                cache: true,
                data: {
                    'plantel': {{$empleado->plantel_id}},
                    'fecha_f': "{{ $fecha_f->toDateString('Y-m-d') }}",
                    'fecha_t': "{{ $fecha_t->toDateString('Y-m-d') }}"                
                },
                beforeSend : function(){$("#loading32").show();  },
                complete : function(){$("#loading32").hide();},
                success: function(data) {
                    
                    var linea=JSON.parse(data);
                    //console.log(data);
                    //$('#porcentaje_pago').html(linea.porcentaje_pagado.toFixed(2));
                    var data = google.visualization.arrayToDataTable([
                    ['Label', 'Value'],
                    ['Pagado', linea],
                    ]);

                    var options = {
                    //width: 400, height: 250,
                    greenFrom:90, greenTo: 100,
                    yellowFrom:75, yellowTo: 90,
                    redFrom: 0, redTo: 75,
                    minorTicks: 5
                    };

                    var chart = new google.visualization.Gauge(document.getElementById('porcentaje_pago2'));

                    chart.draw(data, options);
                },
            });
            //console.log(res);
            function drawChart_wConcretados() {
            $.ajax({
                type: 'GET',
                url: '{{route("home.wConcretados")}}',
                //cache: true,
                data: {
                    'plantel': {{ $empleado->plantel_id }},
                },
                beforeSend : function(){$("#loading32").show();  },
                complete : function(){$("#loading32").hide(); },
                success: function(data) {
                    
                    var linea=JSON.parse(data);
                    
                    var data = google.visualization.arrayToDataTable([
                    ['Label', 'Value'],
                    ['Concretados', linea[0].p_avance],
                    ]);

                    var options = {
                    greenFrom:90, greenTo: 100,
                    yellowFrom:75, yellowTo: 90,
                    redFrom: 0, redTo: 75,
                    minorTicks: 5
                    };

                    var chart = new google.visualization.Gauge(document.getElementById('wConcretados'));

                    chart.draw(data, options);
                    $('#wConcretados_pie').html('Meta del Plantel:'+linea[0].meta_total+'<br/>Inscritos:'+linea[0].avance);
                    var tinicio=linea[0].inicio;
                    var tfin=linea[0].fin;
                    $('#titulo_concretados').html('Concretados del '+ tinicio.replace(/^(\d{4})-(\d{2})-(\d{2})$/g,'$3/$2/$1') +' al '+tfin.replace(/^(\d{4})-(\d{2})-(\d{2})$/g,'$3/$2/$1'));
                },
            });
            //console.log(res);
        }//End Guagace Chart
    

        }//End Guagace Chart
        @endpermission

        @permission('indicadores_plantels')
        @foreach($plantels as $plantel)
        
        function drawChart_wAsistencias_{{ $plantel->id }}() {
            $.ajax({
                type: 'GET',
                url: '{{route("inscripcions.widgetPorcentajeAsistencia")}}',
                //cache: true,
                data: {
                    'plantel': {{ $plantel->id }},
                },
                beforeSend : function(){$("#loading30{{ $plantel->id }}").show();  },
                complete : function(){$("#loading30{{ $plantel->id }}").hide(); },
                success: function(data) {
                    
                    var linea=JSON.parse(data);
                    
                    var data = google.visualization.arrayToDataTable([
                    ['Label', 'Value'],
                    ['Asistencia', linea],
                    ]);

                    var options = {
                    greenFrom:90, greenTo: 100,
                    yellowFrom:75, yellowTo: 90,
                    redFrom: 0, redTo: 75,
                    minorTicks: 5
                    };

                    var chart = new google.visualization.Gauge(document.getElementById("wAsistencias_{{ $plantel->id }}"));

                    chart.draw(data, options);
                    
                },
            });
            //console.log(res);
        }//End Guagace Chart

        
        function drawChart_wConcretados{{ $plantel->id }}() {
            $.ajax({
                type: 'GET',
                url: '{{route("home.wConcretados")}}',
                //cache: true,
                data: {
                    'plantel': {{ $plantel->id }},
                },
                beforeSend : function(){$("#loading31{{ $plantel->id }}").show();  },
                complete : function(){$("#loading31{{ $plantel->id }}").hide(); },
                success: function(data) {
                    
                    var linea=JSON.parse(data);
                    
                    var data = google.visualization.arrayToDataTable([
                    ['Label', 'Value'],
                    ['Concretados', linea[0].p_avance],
                    ]);

                    var options = {
                    greenFrom:90, greenTo: 100,
                    yellowFrom:75, yellowTo: 90,
                    redFrom: 0, redTo: 75,
                    minorTicks: 5
                    };

                    var chart = new google.visualization.Gauge(document.getElementById('wConcretados{{ $plantel->id }}'));

                    chart.draw(data, options);
                    $('#wConcretados_pie{{ $plantel->id }}').html('Meta del Plantel:'+linea[0].meta_total+'<br/>Inscritos:'+linea[0].avance);
                    var tinicio=linea[0].inicio;
                    var tfin=linea[0].fin;
                    $('#titulo_concretados{{ $plantel->id }}').html('Concretados del '+ tinicio.replace(/^(\d{4})-(\d{2})-(\d{2})$/g,'$3/$2/$1') +' al '+tfin.replace(/^(\d{4})-(\d{2})-(\d{2})$/g,'$3/$2/$1'));
                },
            });
            //console.log(res);
        }//End Guagace Chart
        
        
        function drawChart_maestroIndicador{{ $plantel->id }}() {
        $.ajax({
            type: 'GET',
            url: '{{ route("adeudos.maestroIndicador") }}',
            cache: true,
            data: {
                'plantel': {{ $plantel->id}},
                'fecha_f': "{{ $fecha_f->toDateString('Y-m-d') }}",
                'fecha_t': "{{ $fecha_t->toDateString('Y-m-d') }}"                
            },
            beforeSend : function(){$("#loading{{ $plantel->id }}").show();  },
            complete : function(){$("#loading{{ $plantel->id }}").hide();},
            success: function(data) {
                
                var linea=JSON.parse(data);
                //console.log(data);
                //$('#porcentaje_pago').html(linea.porcentaje_pagado.toFixed(2));
                var data = google.visualization.arrayToDataTable([
                ['Label', 'Value'],
                ['Pagado', linea],
                ]);

                var options = {
                //width: 400, height: 250,
                greenFrom:90, greenTo: 100,
                yellowFrom:75, yellowTo: 90,
                redFrom: 0, redTo: 75,
                minorTicks: 5
                };

                var chart = new google.visualization.Gauge(document.getElementById('porcentaj_pago{{ $plantel->id }}'));

                chart.draw(data, options);
            },
        });
        //console.log(res);
        }//End Guagace Chart
        
        function drawChart_wCalificacion_{{ $plantel->id }}() {
            $.ajax({
                type: 'GET',
                url: '{{route("inscripcions.wdCalificacionR")}}',
                //cache: true,
                data: {
                    'plantel': {{ $plantel->id }},
                },
                beforeSend : function(){$("#loading33_{{ $plantel->id }}").show();  },
                complete : function(){$("#loading33_{{ $plantel->id }}").hide(); },
                success: function(data) {
                    
                    //var linea=JSON.parse(data);
                //alert(data.promedio);
                    var data = google.visualization.arrayToDataTable([
                    ['Label', 'Value'],
                    ['Promedio', data.promedio],
                    ]);

                    var options = {
                    greenFrom:90, greenTo: 100,
                    yellowFrom:75, yellowTo: 90,
                    redFrom: 0, redTo: 75,
                    minorTicks: 5
                    };

                    var chart = new google.visualization.Gauge(document.getElementById("wCalificacion_{{ $plantel->id }}"));

                    chart.draw(data, options);
                    
                },
            });
            //console.log(res);
        }//End Guagace Chart

        function drawChart_wBajas_{{ $plantel->id }}() {
            var f = new Date();
            var dt = new Date();
            dt.setDate( dt.getDate() - 30 );
            $.ajax({
                type: 'GET',
                url: '{{route("historiaClientes.wdBajas")}}',
                //cache: true,
                data: {
                    'plantel': {{ $plantel->id }}
                },
                beforeSend : function(){$("#loading34_{{ $plantel->id }}").show();  },
                complete : function(){$("#loading34_{{ $plantel->id }}").hide(); },
                success: function(data) {
                    
                    //var linea=JSON.parse(data);
                    
                    var data = google.visualization.arrayToDataTable([
                    ['Label', 'Value'],
                    ['P. Bajas', data.porcentaje_bajas],
                    ]);

                    var options = {
                    redFrom:15, redTo: 100,
                    yellowFrom:2, yellowTo: 15,
                    greenFrom: 0, greenTo: 2,
                    minorTicks: 5
                    };

                    var chart = new google.visualization.Gauge(document.getElementById('wBajas_{{ $plantel->id }}'));

                    chart.draw(data, options);
                    
                },
            });
            //console.log(res);
        }//End Guagace Chart

        @endforeach
        @endpermission
        
        function drawChart_wAsistencias() {
            $.ajax({
                type: 'GET',
                url: '{{route("inscripcions.widgetPorcentajeAsistencia")}}',
                //cache: true,
                data: {
                    'plantel': {{ $empleado->plantel_id }},
                },
                beforeSend : function(){$("#loading31").show();  },
                complete : function(){$("#loading31").hide(); },
                success: function(data) {
                    
                    var linea=JSON.parse(data);
                    
                    var data = google.visualization.arrayToDataTable([
                    ['Label', 'Value'],
                    ['Asistencia', linea],
                    ]);

                    var options = {
                    greenFrom:90, greenTo: 100,
                    yellowFrom:75, yellowTo: 90,
                    redFrom: 0, redTo: 75,
                    minorTicks: 5
                    };

                    var chart = new google.visualization.Gauge(document.getElementById('wAsistencias'));

                    chart.draw(data, options);
                    
                },
            });
            //console.log(res);
        }//End Guagace Chart

        function drawChart_wConcretados() {
            $.ajax({
                type: 'GET',
                url: '{{route("home.wConcretados")}}',
                //cache: true,
                data: {
                    'plantel': {{ $empleado->plantel_id }},
                },
                beforeSend : function(){$("#loading32").show();  },
                complete : function(){$("#loading32").hide(); },
                success: function(data) {
                    
                    var linea=JSON.parse(data);
                    
                    var data = google.visualization.arrayToDataTable([
                    ['Label', 'Value'],
                    ['Concretados', linea[0].p_avance],
                    ]);

                    var options = {
                    greenFrom:90, greenTo: 100,
                    yellowFrom:75, yellowTo: 90,
                    redFrom: 0, redTo: 75,
                    minorTicks: 5
                    };

                    var chart = new google.visualization.Gauge(document.getElementById('wConcretados'));

                    chart.draw(data, options);
                    $('#wConcretados_pie').html('Meta del Plantel:'+linea[0].meta_total+'<br/>Inscritos:'+linea[0].avance);
                    var tinicio=linea[0].inicio;
                    var tfin=linea[0].fin;
                    $('#titulo_concretados').html('Concretados del '+ tinicio.replace(/^(\d{4})-(\d{2})-(\d{2})$/g,'$3/$2/$1') +' al '+tfin.replace(/^(\d{4})-(\d{2})-(\d{2})$/g,'$3/$2/$1'));
                },
            });
            //console.log(res);
        }//End Guagace Chart

        function drawChart_wCalificacion() {
            var f = new Date();
            var dt = new Date();
            dt.setDate( dt.getDate() - 30 );
            $.ajax({
                type: 'GET',
                url: '{{route("inscripcions.wdCalificacionR")}}',
                //cache: true,
                data: {
                    'plantel': {{ $empleado->plantel_id }},
                    'st_cliente':4,
                    'fecha_t':f.getFullYear() + "-" + (f.getMonth() +1) + "-" + f.getDate(),
                    'fecha_f': dt.getFullYear() + "-" + (dt.getMonth() +1) + "-" + dt.getDate()
                },
                beforeSend : function(){$("#loading33").show();  },
                complete : function(){$("#loading33").hide(); },
                success: function(data) {
                    
                    //var linea=JSON.parse(data);
                    
                    var data = google.visualization.arrayToDataTable([
                    ['Label', 'Value'],
                    ['Promedio', data.promedio],
                    ]);

                    var options = {
                    greenFrom:90, greenTo: 100,
                    yellowFrom:75, yellowTo: 90,
                    redFrom: 0, redTo: 75,
                    minorTicks: 5
                    };

                    var chart = new google.visualization.Gauge(document.getElementById('wCalificacion'));

                    chart.draw(data, options);
                    
                },
            });
            //console.log(res);
        }//End Guagace Chart

        function drawChart_wBajas() {
            var f = new Date();
            var dt = new Date();
            dt.setDate( dt.getDate() - 30 );
            $.ajax({
                type: 'GET',
                url: '{{route("historiaClientes.wdBajas")}}',
                //cache: true,
                data: {
                    'plantel': {{ $empleado->plantel_id }}
                },
                beforeSend : function(){$("#loading34").show();  },
                complete : function(){$("#loading34").hide(); },
                success: function(data) {
                    
                    //var linea=JSON.parse(data);
                    
                    var data = google.visualization.arrayToDataTable([
                    ['Label', 'Value'],
                    ['P. Bajas', data.porcentaje_bajas],
                    ]);

                    var options = {
                    redFrom:15, redTo: 100,
                    yellowFrom:2, yellowTo: 15,
                    greenFrom: 0, greenTo: 2,
                    minorTicks: 5
                    };

                    var chart = new google.visualization.Gauge(document.getElementById('wBajas'));

                    chart.draw(data, options);
                    
                },
            });
            //console.log(res);
        }//End Guagace Chart

        //Gaugace Chart
        /*
        function drawChart_velocimetro() {
            var data = google.visualization.arrayToDataTable([
            ['Label', 'Value'],
            ['Concretados', 0],
            ]);

            var options = {
            greenFrom:90, greenTo: 100,
            yellowFrom:75, yellowTo: 90,
            redFrom: 0, redTo: 75,
            minorTicks: 5
            };

            var chart = new google.visualization.Gauge(document.getElementById('velocimetro_'));

            chart.draw(data, options);

        }*/ //End Guagace Chart
        

        var popup;
        function DetalleAviso(id) {
            popup = window.open("{{url('avisoGrals/showModal')}}"+"?id="+id, "Popup", "width=800,height=350");
            popup.focus();
            return false
        }
        
        function analisisEstatus(){
            
        }
    </script>
@endpush
