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
                    <th>No.</th><th>Plantel</th><th>Id Cliente</th><th>Matricula</th><th>Cliente</th><th>Estatus</th><th>Adeudos</th>
                    <th>
			<input type="submit" class="btn btn-primary" value="Baja BrightSpace"><br/>
			<label>*<input type="checkbox" checked id="seleccionar_todo">Seleccionar Todo</label>
		    </th>
                </thead>
                <tbody>
                    @php
                        $i=0;
                    @endphp
                    @foreach ($registros as $r)
                        <tr>
                            <td>{{ ++$i }}</td>
                            <td>{{ $r->cliente->plantel->razon }}</td><td>{{ $r->cliente_id }}</td><td>{{ $r->cliente->matricula }}</td>
                            <td>{{ $r->cliente->ape_paterno }} {{ $r->cliente->ape_materno }} {{ $r->cliente->nombre }} {{ $r->cliente->nombre2 }}</td>
                            <td>{{ $r->cliente->stCliente->name }}</td>
                            <td>
                                <a href="#" class="btn btn-warning btn-xs linkAdeudos" data-cliente="{{ $r->cliente->id }}">
                                    {{ $r->adeudos_cantidad }}
                                </a>
                            </td>
                            <td>
                                {{ Form::checkbox('bajasBs[]', $r->cliente->id, true, array('class'=>'bajasBs')) }}
                                <!--<input type="checkbox" checked class="bajasBs" value="{{$r->cliente->id}}" />-->
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