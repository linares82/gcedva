@extends('plantillas.admin_template')

@include('hadeudos._common')

@section('header')

    <ol class="breadcrumb">
    	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
        <!--
        @if ( $query_params = Request::input('q') )

            
            <li class="active">condition(  

            @foreach( $query_params as $key => $value )
                @if (!$loop->first) / @endif {{ $key }} : {{ $value }}
            @endforeach
            )</li>
        @else
            <li class="active">@yield('hadeudosAppTitle')</li>
        @endif
        -->
        <li class="active">@yield('hadeudosAppTitle')</li>
    </ol>

    <div class="">
        <h3>
            <i class="glyphicon glyphicon-align-justify"></i> @yield('hadeudosAppTitle')
            @permission('hadeudos.create')
            <a class="btn btn-success pull-right" href="{{ route('hadeudos.create') }}"><i class="glyphicon glyphicon-plus"></i> Crear</a>
            @endpermission
        </h3>

    </div>

   

@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            @if($hadeudos->count())
                <table class="table table-condensed table-striped">
                    <thead>
                        <tr>
                            <th>Campo</th>                
                            <th>Valor Anterior</th>                
                            <th>Valor Nuevo</th>
                            <th>Usuario</th>                                
                            
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($hadeudos as $hadeudo)
                            <tr>
            
                                
                                <td>{{$hadeudo->campo}}</td>
                                <td>{{$hadeudo->valor_anterior}}</td>
                                <td>{{$hadeudo->valor_nuevo}}</td>
                                <td>{{$hadeudo->usu_alta->name}}</td>
                                <td class="text-right">
                                    
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            
            @else
                <h3 class="text-center alert alert-info">Vacio!</h3>
            @endif

        </div>
    </div>

@endsection