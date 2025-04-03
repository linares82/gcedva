@extends('plantillas.admin_template')

@include('roles._common')

@include('roles.notifications')

@section('header')

    <ol class="breadcrumb">
    	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
        <!--
        @if ( $query_params = Request::input('q') )

            <li class="active"><a href="{{ route('salons.index') }}">@yield('salonsAppTitle')</a></li>
            <li class="active">condition(  

            @foreach( $query_params as $key => $value )
                @if (!$loop->first) / @endif {{ $key }} : {{ $value }}
            @endforeach
            )</li>
        @else
            <li class="active">@yield('salonsAppTitle')</li>
        @endif
        -->
        <li class="active">@yield('salonsAppTitle')</li>
    </ol>

    <div class="">
        <h3>
            <i class="glyphicon glyphicon-align-justify"></i> @yield('salonsAppTitle')
            @role('superadmin')
            <a class="btn btn-success pull-right" href="{{ route('rolesF.create') }}"><i class="glyphicon glyphicon-plus"></i> Crear</a>
            @endrole
        </h3>

    </div>

    <div aria-multiselectable="true" role="tablist" id="accordion" class="panel-group">
        <div class="panel panel-default">
            <div id="headingOne" role="tab" class="panel-heading">
                <h4 class="panel-title">
                <a aria-controls="collapseOne" aria-expanded="true" href="#collapseOne" data-parent="#accordion" data-toggle="collapse" role="button">
                    <span aria-hidden="true" class="glyphicon glyphicon-search"></span> Buscar
                </a>
                </h4>
            </div>
            <div aria-labelledby="headingOne" role="tabpanel" class="panel-collapse collapse" id="collapseOne">
                <div class="panel-body">
                    <form class="Salon_search" id="search" action="{{ route('rolesF.index') }}" accept-charset="UTF-8" method="get">
                        <input type="hidden" name="q[s]" value="{{ @(Request::input('q')['s']) ?: '' }}" />
                        <div class="">

                            
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_name_cont">Nombre</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm", type="search" value="{{ @(Request::input('q')['name_cont']) ?: '' }}" name="q[name_cont]" id="q_name_cont" />
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <div class="col-sm-10 col-sm-offset-2">
                                    <input type="submit" name="commit" value="Buscar" class="btn btn-default btn-xs" />
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection


@section('content')

<table class="table table-striped">
    <tr>
        <th>@include('plantillas.getOrderLink', ['column' => 'id', 'title' => 'ID'])</th>
        <th>@include('plantillas.getOrderLink', ['column' => 'name', 'title' => 'NOMBRE'])</th>
        <th>Actions</th>
    </tr>
    @foreach($roles as $model)
        <tr>
            <td>{{ $model->id }}</th>
            <td>{{ $model->name }}</th>
            <td>
                @foreach($model->usuarios as $user)
                            <!--<a class="btn btn-success btn-xs" href="">-->
                                <span class="btn-xs btn-info">{{ $user->name }}</span>
                            <!--</a>    -->
                        @endforeach
            </th>
            <td class="col-xs-3">

                <form action="{{ route('rolesF.destroy', $model->id) }}" method="post">
                    @role('superadmin')
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <a class="btn btn-labeled btn-default" href="{{ route('rolesF.edit', $model->id) }}"><span class="btn-label"><i class="fa fa-pencil"></i></span>Editar</a>
                    
                    <button type="submit" class="btn btn-labeled btn-danger"><span class="btn-label"><i class="fa fa-trash"></i></span>Borrar</button>
                    @endrole
                </form>
            </td>
        </tr>
    @endforeach
</table>
<div class="text-center">
    {!! $roles->appends(Request::except('page'))->render() !!}
</div>
@endsection
