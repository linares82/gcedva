@extends('plantillas.admin_template')

@include('sepGrupos._common')

@section('header')

	<ol class="breadcrumb">
	    <li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li><a href="{{ route('sepGrupos.index') }}">@yield('sepGruposAppTitle')</a></li>
	    <li><a href="{{ route('sepGrupos.show', $sepGrupo->id) }}">{{ $sepGrupo->id }}</a></li>
	    <li class="active">Editar</li>
	</ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-edit"></i> @yield('sepGruposAppTitle') / Editar {{$sepGrupo->id}}</h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">

            {!! Form::model($sepGrupo, array('route' => array('sepGrupos.update', $sepGrupo->id),'method' => 'post')) !!}

@include('sepGrupos._form')

                <div class="row">
                </div>

                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <a class="btn btn-link pull-right" href="{{ route('sepGrupos.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>
                </div>
            {!! Form::close() !!}
            <div class="col-md-12">
        <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Materias</h3>
        </div>
        </div>
            <div class="row">
        <div class="col-md-12">
            @php
                //dd($sepGrupo->sepMateriasRels);
            @endphp
            @if($sepGrupo->sepMateriasRels->count())
                <table class="table table-condensed table-striped">
                    <thead>
                        <tr>
                            <th>Grado</th>
                            <th>Materia</th>
                            <th>Duración</th>
                            <th>Acuerdo</th>
                            <th>Equivalenca</th>
                            <th class="text-right">OPCIONES</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($sepGrupo->sepMateriasRels as $materia)
                        @php
                            $materia_sep=App\SepMaterium::with('materias')->find($materia->sep_materia_id);
                        @endphp
                            <tr>
                                <td>{{$materia->grado}}</td>
                                <td>{{$materia_sep->name}}</td>
                                <td>{{$materia->duracion_horas}}</td>
                                <td>{{$materia->acuerdo}}</td>
                                <td>
                                @foreach($materia_sep->materias as $materia_equivalente)
                                    <i class="label label-default">{{$materia_equivalente->id}}-{{$materia_equivalente->name}}</i>
                                @endforeach   
                                </td>
                                <td class="text-right">
                                    @permission('sepGrupoSepMaterias.destroy')
                                    {!! Form::model($sepGrupo, array('route' => array('sepGrupoSepMaterias.destroy', $materia->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? ¿Esta seguro?')) { return true } else {return false };")) !!}
                                        <button type="submit" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i> Borrar</button>
                                    {!! Form::close() !!}
                                    @endpermission
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

        </div>
    </div>
@endsection