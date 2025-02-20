@extends('plantillas.admin_template')

@include('planEstudios._common')

@section('header')

	<ol class="breadcrumb">
	    <li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li><a href="{{ route('planEstudios.index') }}">@yield('planEstudiosAppTitle')</a></li>
	    <li><a href="{{ route('planEstudios.show', $planEstudio->id) }}">{{ $planEstudio->id }}</a></li>
	    <li class="active">Editar</li>
	</ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-edit"></i> @yield('planEstudiosAppTitle') / Editar {{$planEstudio->id}}</h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">

            {!! Form::model($planEstudio, array('route' => array('planEstudios.update', $planEstudio->id),'method' => 'post')) !!}

    @include('planEstudios._form')

                <div class="row">
                </div>

                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <a class="btn btn-link pull-right" href="{{ route('planEstudios.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>
                </div>
            {!! Form::close() !!}

        </div>
    </div>
    @php
    //dd($planEstudio->periodosEstudio->count());
    @endphp
    @if($planEstudio->periodosEstudio->count()>0)
    <table class="table table-condensed table-striped">
        <thead>
            <tr>
                <th>Periodo</th>
                <th>Materias</th>
                <th class="text-right">OPCIONES</th>
            </tr>
        </thead>

        <tbody>
            @foreach($planEstudio->periodosEstudio as $periodo)
                <tr>
                    <td>{{$periodo->name}}</td>
                    <td>
                    @php
                    $materias=App\Materium::join('materium_periodos as mp','mp.materium_id','materia.id')
                        ->where('mp.periodo_estudio_id',$periodo->id)
                        ->get();
                    @endphp
                    @foreach($materias as $materia)
                    <i class="label label-default">{{$materia->materium_id}}-{{$materia->name}}</i>
                    @endforeach
                    </td>
                    <td>
                        <td class="text-right">
                            @permission('planEstudios.destroy')
                            {!! Form::model($planEstudio, array('route' => array('planEstudios.destroyPeriodo'),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? ¿Esta seguro?')) { return true } else {return false };")) !!}
                            {!! Form::hidden("periodo_estudio_id",$periodo->id, array("class" => "form-control", "id" => "periodo_estudio_id-field")) !!}
                            {!! Form::hidden("plan_estudio_id",$planEstudio->id, array("class" => "form-control", "id" => "plan_estudio_id-field")) !!}
                            
                                <button type="submit" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i> Borrar</button>
                            {!! Form::close() !!}
                            @endpermission
                        </td>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    @endif
@endsection

