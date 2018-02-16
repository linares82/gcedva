@extends('plantillas.admin_template')

@include('lectivos._common')

@section('header')

<ol class="breadcrumb">
	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
    <li><a href="{{ route('lectivos.index') }}">@yield('lectivosAppTitle')</a></li>
    <li class="active">{{ $lectivo->name }}</li>
</ol>

<div class="page-header">
        <h1>@yield('lectivosAppTitle') / Mostrar {{$lectivo->id}}

            {!! Form::model($lectivo, array('route' => array('lectivos.destroy', $lectivo->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? Estas seguro?')) { return true } else {return false };")) !!}
                <div class="btn-group pull-right" role="group" aria-label="...">
                    <a class="btn btn-success btn-group" role="group" target="_blank" href="{{ route('lectivos.imprimirCalendario', $lectivo->id) }}"><i class="glyphicon glyphicon-edit"></i> Imprimir Calendario</a>
                    <a class="btn btn-warning btn-group" role="group" href="{{ route('lectivos.edit', $lectivo->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                    <button type="submit" class="btn btn-danger">Borrar <i class="glyphicon glyphicon-trash"></i></button>
                </div>
            {!! Form::close() !!}

        </h1>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">

            <form action="#">
                <div class="form-group col-sm-4">
                    <label for="nome">ID</label>
                    <p class="form-control-static">{{$lectivo->id}}</p>
                </div>
                <div class="form-group col-sm-4 ">
                     <label for="name">NAME</label>
                     <p class="form-control-static">{{$lectivo->name}}</p>
                </div>
                    <div class="form-group col-sm-4 ">
                     <label for="activo">ACTIVO</label>
                     <p class="form-control-static">{{$lectivo->activo}}</p>
                </div>
                <div class="form-group col-sm-4 ">
                     <label for="inicio">Inicio</label>
                     <p class="form-control-static">{{$lectivo->inicio}}</p>
                </div>
                <div class="form-group col-sm-4 ">
                     <label for="fin">FIN</label>
                     <p class="form-control-static">{{$lectivo->fin}}</p>
                </div>
                <div class="form-group col-sm-4 ">
                     <label for="fin">Asistencias L-V</label>
                     <p class="form-control-static">{{$lectivo->total_asistencias_lv}}</p>
                </div>
                <div class="form-group col-sm-4 ">
                     <label for="fin">Asistencias S</label>
                     <p class="form-control-static">{{$lectivo->total_asistencias_s}}</p>
                </div>
                    <div class="form-group col-sm-4 ">
                     <label for="usu_alta_id">ALTA</label>
                     <p class="form-control-static">{{$lectivo->usu_alta->name}}</p>
                </div>
                    <div class="form-group col-sm-4 ">
                     <label for="usu_mod_id">ULTIMA MODIFICACIÓN</label>
                     <p class="form-control-static">{{$lectivo->usu_mod->name}}</p>
                </div>
            </form>
            <div class="row"></div>
                <div class="row">
                    <div class="col-md-12">

                        {!! Form::open(array('route' => 'diaNoHabils.store', 'method'=>'POST')) !!}

                        <div class="form-group col-md-4 @if($errors->has('fecha')) has-error @endif">
                            <label for="fecha-field">Fecha</label>
                            {!! Form::text("fecha", null, array("class" => "form-control", "id" => "fecha-field")) !!}
                            {!! Form::hidden("lectivo_id", $lectivo->id, array("class" => "form-control", "id" => "lectivo_id-field")) !!}
                            @if($errors->has("fecha"))
                             <span class="help-block">{{ $errors->first("fecha") }}</span>
                            @endif
                         </div>
                        
                        <div class="form-group col-md-4 @if($errors->has('fecha')) has-error @endif">
                            <button type="submit" class="btn btn-primary">Crear dia no habil</button>
                         </div>

                        {!! Form::close() !!}

                    </div>
                </div>
            <div class="row"></div>
            <table class="table table-condensed table-striped">
                <thead>
                    <td>Fecha</td><td></td>
                </thead>
                <tbody>
                    @foreach( $lectivo->diasNoHabiles as $d )
                    <tr>
                    <td> {{$d->fecha}} </td>
                    <td>
                        @permission('diaNoHabils.destroy')
                        <a class="btn btn-xs btn-danger" href="{{ url('diaNoHabils/destroy', $d->id) }}"><i class="glyphicon glyphicon-edit"></i> Borrar</a>
                        @endpermission
                        
                    </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            
            
            <a class="btn btn-link" href="{{ route('lectivos.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>

        </div>
    </div>

@endsection
@push('scripts')
<script type="text/javascript">
    
    $('#fecha-field').Zebra_DatePicker({
        days:['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'],
        months:['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
        readonly_element: false,
        lang_clear_date: 'Limpiar',
        show_select_today: 'Hoy',
      });
     
</script>
@endpush
