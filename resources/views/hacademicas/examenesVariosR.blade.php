@extends('plantillas.admin_template')

@include('hacademicas._common')

@section('header')

	<ol class="breadcrumb">
		<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li><a href="{{ route('hacademicas.index') }}">@yield('hacademicasAppTitle')</a></li>
	    <li class="active">Examenes</li>
	</ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-plus"></i> @yield('hacademicasAppTitle') / Examenes </h3>
    </div>

    <style>
      table tr:hover {
        background-color: #A9D0F5;
        cursor: pointer;
    }
    </style>
@endsection

@section('content')
    @include('error')
    
    <div class="row">
        <div class="col-md-12">
            <div class="form-group col-md-4 @if($errors->has('examen_id')) has-error @endif" >
                <label for="examen_id-field">Examen</label>
                {!! Form::select("examen_id", $tpo_examen, null, array("class" => "form-control select_seguridad", "id" => "examen_id-field")) !!}
                @if($errors->has("examen_id"))
                 <span class="help-block">{{ $errors->first("Examen_id") }}</span>
                @endif
             </div>

             <div class="form-group col-md-4 @if($errors->has('lectivo_id')) has-error @endif" >
                <label for="bnd_lectivo_diferente-field">Lectivo Diferente?
                    {!! Form::checkbox("bnd_lectivo_diferente", 1, null, [ "id" => "bnd_lectivo_diferente-field", 'class'=>'minimal', "onchange"=>"javascript:showContent()"]) !!}
                </label>
                <div id="lectivos" style="visibility: none;">
                    {!! Form::select("lectivo_id", $lectivos, null, array("class" => "form-control select_seguridad", "id" => "lectivo_id-field")) !!}
                </div>
                
                @if($errors->has("examen_id"))
                 <span class="help-block">{{ $errors->first("Examen_id") }}</span>
                @endif
             </div>
            <table class="table table-condensed table-striped">
                <thead>
                    <th>Consecutivo</th>
                    <th>Alumno</th>
                    <th>Plantel</th><th>Grado</th><th>Grupo</th><th>Lectivo</th>
                    <th>Materia</th>
                    <th>Exa. F/E</th>
                    <th>Calificacion</th>
                </thead>
                <tbody>
                    @php
                        $i=1;
                        
                    @endphp
                    @foreach($alumnos as $a)
                    @php
                        $extras=\App\Calificacion::where('hacademica_id',$a->id)->where('tpo_examen_id','2')->count();
                        $finales=\App\Calificacion::where('hacademica_id',$a->id)->where('tpo_examen_id','3')->count();

                    @endphp
                    <tr>
                        <td>{{ $i++ }}</td>
                        <td> <a href="{{ route('clientes.edit',$a->cliente_id) }}" target="_blank">{{ $a->cliente->id }} {{ $a->cliente->nombre }} {{ $a->cliente->nombre2 }} {{ $a->cliente->ape_paterno }} {{ $a->cliente->ape_materno }}</a> </td>
                        <td>{{ $a->plantel->razon }}</td><td>{{ $a->grado->name }}</td>
                        <td>{{ $a->grupo->name }}</td><td>{{ $a->lectivo->name }}</td><td>{{ $a->materia->name }}</td>
                        <td><div id="evaluaciones_actuales">{{ $finales }} / {{ $extras }}</div></td>
                        <td>{{ $a->calificacion }}</td>
                        <td><button type="button" class="btn btn-success btn-xs btn-crear-evaluacion" data-hacademica_id={{ $a->id}} >Generar Evaluación</button></td>
                    </tr>
                    @endforeach
                </tbody>
            </Table>
            
            
            
        </div>
    </div>
    
@endsection
@push('scripts')
<script type="text/javascript">
    
    $(document).ready(function() {
        $("#lectivo_id-field").prop("disabled", true);
        
        $(".btn-crear-evaluacion").click(function(){
            if ($('#bnd_lectivo_diferente-field').is(":checked")){
                bnd_lectivo=1;
            }else{
                bnd_lectivo=0;
            }
            $.ajax({
                  url: '{{ route("hacademicas.crearEvaluacion") }}',
                  type: 'GET',
                  data: {
                      'hacademica':$(this).data('hacademica_id'),
                      'tpo_examen':$('#examen_id-field option:selected').val(),
                      'bnd_lectivo':bnd_lectivo,
                      'lectivo': $('#lectivo_id-field option:selected').val(),
                  },
                  dataType: 'json',
                  beforeSend : function(){$(".btn-crear-evaluacion").prop("disabled", true);},
                  complete : function(){$(".btn-crear-evaluacion").prop("disabled", false);},
                  success: function(data){
                    location.reload();  
                  }
              });
        });
    

    });

    function showContent() {
        
        check = document.getElementById("bnd_lectivo_diferente-field");
        
        if (check.checked) {
            $("#lectivo_id-field").prop("disabled", false);
            
        }
        else {
            $("#lectivo_id-field").prop("disabled", true);
            
        }
    }    

        
</script>
@endpush