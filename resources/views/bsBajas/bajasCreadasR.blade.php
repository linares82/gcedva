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
                    <th>No.</th><th>Plantel</th><th>Id Cliente</th><th>Matricula</th><th>Estatus</th><th>F. Baja</th><th>Baja</th><th>F. Reactivar</th><th>Reactivar</th>
                </thead>
                <tbody>
                    @php
                        $i=0;
                    @endphp
                    @foreach ($registros as $r)
                        <tr>
                            <td>{{ ++$i }}</td>
                            <td>{{ $r->razon }}</td><td>{{ $r->id }}</td><td>{{ $r->matricula }}</td><td>{{ $r->estatus }}</td>
                            <td>{{ $r->fecha_baja }} </td><td>@if($r->bnd_baja==1) SI @else NO @endif </td>
			    <td>{{ $r->fecha_reactivar }} </td><td>@if($r->bnd_reactivar==1) SI @else NO @endif</td>
                        </tr>
                    @endforeach
                    
                </tbody>
            </table>
            {!! Form::close() !!}
            
        </div>
    </div>

@endsection

@push('scripts')
<script type="text/javascript">

</script>
@endpush