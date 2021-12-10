@extends('plantillas.admin_template')

@include('bsBajas._common')

@section('header')

<ol class="breadcrumb">
	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
    
    <li class="active"></li>
</ol>

<div class="page-header">
        <h1>@yield('bsBajasAppTitle') / Mostrar 


        </h1>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            {!! Form::open(array('route' => 'bsBajas.bajasBs')) !!}
            <table class="table table-condensed table-striped">
                <thead>
                    <th>No.</th><th>Plantel</th><th>Especialidad</th><th>Nivel</th><th>Grado</th>
                    <th>Id Cliente</th><th>Matricula</th><th>Cliente</th><th>Estatus S.</th><th>Estatus Bs.</th>
                    <th>Adeudos</th>
                    <th>
			<input type="submit" class="btn btn-primary" value="Baja BrightSpace"><br/>
			<label>*<input type="checkbox" checked id="seleccionar_todo">Seleccionar Todo</label>
		    </th>
                </thead>
                <tbody>
                    @php
                        $i=0;
                    @endphp
                    @foreach ($registros2 as $r)
                        @php
                            $cliente=App\Cliente::find($r['cliente_id']);
                            //Log::info($r['combinacion_cliente_id']);
                            $combinacionCliente=App\CombinacionCliente::find($r['combinacion_cliente_id']);
                        @endphp
                        <tr>
                            <td>{{ ++$i }}</td>
                            <td>{{ $cliente->plantel->razon }}</td><td>{{ $combinacionCliente->especialidad->name }}</td><td>{{ $combinacionCliente->nivel->name }}</td>
                            <td>{{ $combinacionCliente->grado->name }}</td>
                            <td>{{ $cliente->id }}</td><td>{{ $cliente->matricula }}</td>
                            <td>{{ $cliente->ape_paterno }} {{ $cliente->ape_materno }} {{ $cliente->nombre }} {{ $cliente->nombre2 }}</td>
                            <td>{{ $cliente->stCliente->name }}</td>
			    <td>
			    @if($r['estatusBs']=="N/A")
				{{ $r['estatusBs'] }}
			    @elseif(!$r['estatusBs'])
				I
			    @else
				A
			    @endif
			    </td>
                            <td>
                                <a href="#" class="btn btn-warning btn-xs linkAdeudos" data-cliente="{{ $cliente->id }}">
                                    {{ $r['adeudos_cantidad'] }}
                                </a>
                            </td>
                            <td>
                                {{ Form::checkbox('bajasBs[]', $cliente->id, false, array('class'=>'bajasBs')) }}
                                <!--<input type="checkbox" checked class="bajasBs" value="{{$cliente->id}}" />-->
                            </td>
                            @php
                            //$bsBajas=App\BsBaja::where('cliente_id',$r->cliente_id)->where('bnd_reactivar','<>',1)->get();    
                            @endphp
                            
                        </tr>
                    @endforeach
                    
                </tbody>
            </table>
            {!! Form::close() !!}
            
        </div>
    </div>
    {!! Form::open(['url'=>'cajas.buscarCliente','method' => 'post','target'=>"_blank", 'id'=>'frmAdeudos']) !!}
        {!! Form::hidden("cliente_id", null, array("class" => "form-control input-sm", "id" => "cliente_id-field")) !!}
    {!! Form::close() !!}

@endsection

@push('scripts')
<script type="text/javascript">

    $('.linkAdeudos').click(function(e){
        e.preventDefault();
        $('#cliente_id-field').val($(this).data('cliente'));
        $('#frmAdeudos').submit();    
    });

    $('#seleccionar_todo').change(function(){
            if( $(this).is(':checked') ) {
            	$(".bajasBs").click();
            }else{
            	$(".bajasBs").removeAttr("checked","false");
            }
        });

</script>
@endpush