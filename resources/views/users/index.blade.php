@extends('plantillas.admin_template')

@include('users._common')

@section('header')

    <ol class="breadcrumb">
    	<li><a href="/"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
        <!--
        @if ( $query_params = Request::input('q') )

            <li class="active"><a href="{{ route('apples.index') }}">@yield('applesAppTitle')</a></li>
            <li class="active">condition(  

            @foreach( $query_params as $key => $value )
                @if (!$loop->first) / @endif {{ $key }} : {{ $value }}
            @endforeach
            )</li>
        @else
            <li class="active">@yield('applesAppTitle')</li>
        @endif
        -->
        <li class="active">@yield('applesAppTitle')</li>
    </ol>

    <div class="">
        <h3>
            <i class="glyphicon glyphicon-align-justify"></i> @yield('applesAppTitle')
            
        </h3>

    </div>

    <div class="row" >
        <div class="col-md-12">
            <form method="GET" action="{{ route('users.cUsers') }}" id="search_form" name="search_form" accept-charset="UTF-8" class="">
                {{ csrf_field() }}
                <input name="_method" type="hidden" value="GET">
                <div class="form-group col-md-4 {{ $errors->has('slug') ? 'has-error' : '' }}">
                    <label for="id" class="control-label">Nombre</label>
                    <input class="form-control input-sm" name="name" type="text" id="name" minlength="1" maxlength="255" placeholder="Capturar nombre ...">
                </div>
                                        <div class="form-group col-md-4 {{ $errors->has('slug') ? 'has-error' : '' }}">
                    <label for="name" class="control-label">Email</label>
                    <input class="form-control input-sm" name="email" id="email" type="text" id="slug" minlength="1" maxlength="255" placeholder="Capturar email ...">
                </div>
                <div class="form-group">
                        <input class="btn btn-info" type="submit" value="Buscar">
                </div>
            </form>
        </div>
    </div>

    @role('superadmin')
    <a class="btn btn-success pull-right" href="{{ route('usuariosF.create') }}"><i class="glyphicon glyphicon-plus"></i> Crear</a>
    @endrole

@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
        <div class="table-responsive">
        <table class="table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Roles</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        @foreach($user->roles1 as $rol)
                            <a class="btn btn-success btn-xs" href="{{ route('entrust-gui::roles.edit', $rol->id) }}">
                                {{ $rol->name }}
                            </a>    
                        @endforeach
                    </td>
                    <td>
                    @role('superadmin')
                    <form action="{{ route('usuariosF.destroy', $user->id) }}" method="post">
                    
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <a class="btn btn-labeled btn-default" href="{{ route('usuariosF.edit', $user->id) }}"><span class="btn-label"><i class="fa fa-pencil"></i></span>Editar</a>
                    
                    <button type="submit" class="btn btn-labeled btn-danger"><span class="btn-label"><i class="fa fa-trash"></i></span>Borrar</button>
                    </form>
                    @endrole
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        </div>
        </div>
    </div>
    <div class="panel-footer">
        {!! $users->render() !!}
    </div>

@endsection