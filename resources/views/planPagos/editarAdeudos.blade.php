@extends('plantillas.admin_template')

@include('planPagos._common')

@section('header')



<ol class="breadcrumb">
	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
    <li><a href="{{ route('planPagos.index') }}">@yield('planPagosAppTitle')</a></li>
    <li class="active">{{ $planPago->name }}</li>
</ol>

<div class="page-header">
        <h1>@yield('planPagosAppTitle') / Mostrar {{$planPago->id}}

            {!! Form::model($planPago, array('route' => array('planPagos.destroy', $planPago->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? Estas seguro?')) { return true } else {return false };")) !!}
                <div class="btn-group pull-right" role="group" aria-label="...">
                    @permission('planPago.edit')
                    <a class="btn btn-warning btn-group" role="group" href="{{ route('planPagos.edit', $planPago->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                    @endpermission
                    @permission('planPago.destroy')
                    <button type="submit" class="btn btn-danger">Borrar <i class="glyphicon glyphicon-trash"></i><
                    /button>
                    @endpermission
                </div>
            {!! Form::close() !!}

        </h1>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">

            

                
            
        </div>
    </div>

@endsection
@push('scripts')
<script>
    
</script>
@endpush
