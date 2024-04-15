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

    

    @permission('empleados.contratosVencidos')
    <div class="form-group col-md-12 col-sm-12 col-xs-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">
                    Contratos vencidos
                </h3>
            </div>
            <div class="box-body">
                <table class="table table-bordered table-striped dataTable">
                    <thead><th>Plantel</th><th>Empleado Id</th><th>Empleado Nombre</th><th>RFC</th><th>Puesto</th><th>Direccion</th><th>F. Vencimiento</th><th></th>
                    <tbody>
                        @foreach ($contratosVencidos as $contrato)
                            <tr>
                                <td>
                                {{$contrato->razon}}</td>    
                            <td>{{$contrato->id}}</td>
                            <td>{{ $contrato->nombre }} {{ $contrato->ape_paterno }} {{ $contrato->ape_materno }}</td>
                            <td>{{ $contrato->rfc }}</td>
                            <td>
                                
                            {{ $contrato->puesto }}</td>
                            <td>{{ $contrato->direccion }}</td>
                            <td>{{$contrato->fin_contrato}}</td>
                            <td>
                                @permission('empleados.baja')
                                <!--<a href="{{ route('empleados.baja', array('id'=>$contrato->id)) }}" class="btn btn-xs btn-danger">Baja</a>-->
                                <a class="btn btn-xs btn-danger" href="{{ route('historials.create',array('empleado'=>$contrato->id)) }}"> Evento Baja</a>
                                @endpermission
                                @permission('empleados.edit')
                                <a href="{{ route('empleados.edit', $contrato->id) }}" target="_blank" class="btn btn-xs btn-success">Editar</a>
                                @endpermission
                            </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endpermission
     
    @if (Auth::user()->can('autorizacionBaja.aut_servicios_escolares') or 
    Auth::user()->can('autorizacionBaja.aut_caja') or
    Auth::user()->can('autorizacionBaja.aut_servicios_escolares_c') or 
    Auth::user()->can('autorizacionBaja.ver'))
    <div class="form-group col-md-12 col-sm-12 col-xs-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">
                    Autorizaciones Bajas
                </h3>
            </div>
            <div class="box-body">
                <table class="table table-bordered table-striped dataTable">
                    <thead><th>Cliente Id</th><th>Matricula</th><th>Cliente Nombre</th><th>Plantel</th><th>Justificacion</th><th>A. Caja</th><th>A. Director</th><th>A. Caja Corp.</th><th></th></thead>
                    <tbody>
                        @foreach ($bajas as $baja)
                        
                        @if($baja->aut_caja<>2 or $baja->director<>2 or $baja->aut_caja_corp<>2)
                            <tr>
                            <td> <a href="{{route('clientes.edit',$baja->cliente_id)}}" target=_blank>{{$baja->cliente_id}}</a></td>
                            <td>{{ optional($baja->cliente)->matricula }}</td>
                            <td>{{ optional($baja->cliente)->nombre }} {{ optional($baja->cliente)->nombre2 }} {{ optional($baja->cliente)->ape_paterno }} {{ optional($baja->cliente)->ape_materno }}</td>
                            <td>{{ optional(optional($baja->cliente)->plantel)->razon }}</td>
                            <td>{{ $baja->descripcion}}</td>
                            <td>{{optional($baja->autCaja)->name}}</td>
                            <td>{{optional($baja->autDirector)->name}}</td>
                            <td>{{optional($baja->autCajaCorp)->name}}</td>
                            <td>
                                @if (Auth::user()->can('autorizacionBaja.aut_servicios_escolares') or 
                                Auth::user()->can('autorizacionBaja.aut_caja') or
                                Auth::user()->can('autorizacionBaja.aut_servicios_escolares_c'))
                                <a class="btn btn-xs btn-warning" href="{{ route('historiaClientes.index',array('q[cliente_id_lt]'=>optional($baja->cliente)->id)) }}" target='_blank'><i class="glyphicon glyphicon-plus"></i> Ver</a>
                                @endif
                            </td>
                            </tr>
                        @endif
                        
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif

    
    @if (Auth::user()->can('wd-autorizacion-becas') or Auth::user()->can('wd-autorizacion-becas-ver'))
    
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
                                    <th>Cliente Id</th>
                                    <th>Matricula</th>
                                    <th>Cliente Nombre</th>
                                    <th>Plantel</th>
                                    <th>Solicitud</th>
                                    <th>Fecha</th>
                                    <th>A. Caja P.</th>
                                    <th>A. Director P.</th>
                                    
                                    <th>A. Serv. Esc. C.</th>
                                    <th>A. Final</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($becas as $beca)
                                
                                <tr>
                                    <td>
                                        <a href="{{route('clientes.edit',$beca->cliente)}}" target=_blank>{{$beca->cliente}}</a>
                                    </td>
                                    <td>{{ $beca->matricula }}</td>
                                    <td>{{ $beca->cli_nombre }} {{ $beca->cli_nombre2 }} {{ $beca->cli_ape_paterno }} {{ $beca->cli_ape_materno }}</td>
                                    <td>{{ $beca->razon }}</td>
                                    <td>
                                        {{$beca->solicitud}}
                                    </td>
                                    <td>
                                        {{$beca->created_at}}
                                    </td>
                                    <td>{{ $beca->aut_caja_plantel}}</td>
                                    <td>{{$beca->aut_dir_plantel}}</td>
                                    
                                    <td>{{$beca->aut_ser_esc}}</td>
                                    <td>{{$beca->aut_dueno}}</td>
                                    <td>
                                        @if (Auth::user()->can('wd-autorizacion-becas'))
                                    <a class="btn btn-xs bg-purple" target=_blank href="{{ route('autorizacionBecas.findByClienteId', array('cliente_id'=>$beca->cliente)) }}">
                                        <i class="fa fa-eye"></i> S. Becas
                                    </a>
                                        @endif
                                    </td>
                                </tr>
                                
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @endif
    
    <div class="row">
        @permission('avisos.create')
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
                                        @if($a->dias_restantes<=0) <small class="label label-danger">
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
        @endpermission
    </div>
    

    
    
@endsection


