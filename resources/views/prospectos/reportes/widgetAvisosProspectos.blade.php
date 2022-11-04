@extends('plantillas.admin_template')

@include('seguimientos._common')

@section('header')

	<ol class="breadcrumb">
		<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li><a href="{{ route('seguimientos.index') }}">@yield('prospectosAppTitle')</a></li>
	    <li class="active">Avisos Prospectos</li>
	</ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-plus"></i> @yield('prospectosAppTitle') / Avisos Prospectos </h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
    <div class="form-group col-md-6 col-sm-6 col-xs-12">
            <div class="box box-danger">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        Avisos del dia - Prospectos
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
                                        <a class="btn btn-xs btn-primary" href="{{ route('prospectoSeguimientos.show', $a->prospecto_id) }}"><i class="glyphicon glyphicon-edit"></i> Ver Seguimiento</a>
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
@endsection
@push('scripts')
  <script type="text/javascript">
    $(document).ready(function() {
        
    });
    
    </script>
@endpush