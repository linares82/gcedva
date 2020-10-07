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
                    <thead><th>Cliente Id</th><th>Cliente Nombre</th><th>Plantel</th><th>Justificacion</th><th>A. Caja</th><th>A. Director</th><th>A. Caja Corp.</th><th></th></thead>
                    <tbody>
                        @foreach ($bajas as $baja)
                        
                        @if($baja->aut_caja<>2 or $baja->director<>2 or $baja->aut_caja_corp<>2)
                            <tr>
                            <td> <a href="{{route('clientes.edit',$baja->cliente_id)}}" target=_blank>{{$baja->cliente_id}}</a></td>
                            <td>{{ $baja->cliente->nombre }} {{ $baja->cliente->nombre2 }} {{ $baja->cliente->ape_paterno }} {{ $baja->cliente->ape_materno }}</td>
                            <td>{{ $baja->cliente->plantel->razon }}</td>
                            <td>{{$baja->descripcion}}</td>
                            <td>{{optional($baja->autCaja)->name}}</td>
                            <td>{{optional($baja->autDirector)->name}}</td>
                            <td>{{optional($baja->autCajaCorp)->name}}</td>
                            <td><a class="btn btn-xs btn-warning" href="{{ route('historiaClientes.index',array('q[cliente_id_lt]'=>$baja->cliente->id)) }}" target='_blank'><i class="glyphicon glyphicon-plus"></i> Ver</a></td>
                            </tr>
                        @endif
                        
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif

    @permission('wd-autorizacion-becas')
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
                                    <td>{{ $beca->cli_nombre }} {{ $beca->cli_nombre2 }} {{ $beca->cli_ape_paterno }} {{ $beca->cli_ape_materno }}</td>
                                    <td>{{ $beca->razon }}</td>
                                    <td>
                                        {{$beca->solicitud}}
                                    </td>
                                    <td>
                                        {{$beca->created_at}}
                                    </td>
                                    <td>{{$beca->aut_caja_plantel}}</td>
                                    <td>{{$beca->aut_dir_plantel}}</td>
                                    
                                    <td>{{$beca->aut_ser_esc}}</td>
                                    <td>{{$beca->aut_dueno}}</td>
                                    <td>
                                    <a class="btn btn-xs bg-purple" target=_blank href="{{ route('autorizacionBecas.findByClienteId', array('cliente_id'=>$beca->cliente)) }}">
                                        <i class="fa fa-eye"></i> S. Becas
                                    </a>
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

    

    
    
@endsection


