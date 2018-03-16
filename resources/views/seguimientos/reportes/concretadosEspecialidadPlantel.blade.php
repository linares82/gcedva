@extends('plantillas.admin_template')

@include('seguimientos._common')

@section('header')

	<ol class="breadcrumb">
		<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li><a href="{{ route('seguimientos.index') }}">@yield('seguimientosAppTitle')</a></li>
	    <li class="active">Reporte de Seguimientos</li>
	</ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-plus"></i> @yield('seguimientosAppTitle') / Reporte de Concretados por Especialidad y Plantel </h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">

            {!! Form::open(array('route' => 'seguimientos.concretadosEspecialidadPlantelR', 'id'=>'frm_analitica')) !!}

                <div class="form-group col-md-6 @if($errors->has('plantel_f')) has-error @endif">
                    <label for="plantel_f-field">Plantel de:</label>
                    {!! Form::select("plantel_f", $list["Plantel"], null, array("class" => "form-control select_seguridad", "id" => "plantel_f-field")) !!}
                    @if($errors->has("plantel_f"))
                    <span class="help-block">{{ $errors->first("plantel_f") }}</span>
                    @endif
                </div>
                <div class="row">
                </div>
                <div class="form-group"><strong>Seleccionar Lectivos</strong> </div>
                    <div class="row_lectivos">
                        <div class="col-xs-5">
                            Elegir
                            {!! Form::select("select-lectivo_id", $lectivos, null, array("class" => "form-control select-multiple", "id" => "select-lectivos_from", "name"=>"from[]", 'multiple'=>'multiple')) !!}
                        </div>

                        <div class="col-xs-2">
                            <!--<button type="button" id="right_All_1" class="btn btn-block"><i class="glyphicon glyphicon-forward"></i></button>-->
                            <button type="button" id="right_Selected_1" class="btn btn-success btn-block"><i class="glyphicon glyphicon-chevron-right"></i></button>
                            <button type="button" id="left_Selected_1" class="btn btn-success btn-block"><i class="glyphicon glyphicon-chevron-left"></i></button>
                            <!--<button type="button" id="left_All_1" class="btn btn-block"><i class="glyphicon glyphicon-backward"></i></button>-->
                        </div>

                        <div class="col-xs-5">
                            Seleccionadas
                            {!! Form::select("select-lectivo_id", array(), null, array("class" => "form-control select-multiple", "id" => "select-lectivos_to", "name"=>"to[]", 'multiple'=>'multiple')) !!}
                        </div>
                    </div>
                </div>
            
                <div class="row">
                </div>
                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">Tabla</button>
                </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection
@push('scripts')
  <script type="text/javascript">
    $(document).ready(function() {
    
    @permission('IreporteFiltroXplantel')
        $("#plantel_f-field").prop("disabled", true);
        $("#plantel_t-field").prop("disabled", true);
    @endpermission
        
    });
    
    </script>
@endpush

@push('scripts')
    <link href="{{asset('bower_components/AdminLTE/plugins/jquery.loading.css')}}" rel="stylesheet">
    <script src="{{ asset('bower_components/AdminLTE/plugins/multiselect.js') }}"></script>
    <script src="{{ asset('bower_components/AdminLTE/plugins/jquery.loading.js') }}"></script>
    <script type="text/javascript">
                                $(document).ready(function () {
                                    
                                    $('#select-lectivos_from').multiselect({
                                        right: '#select-lectivos_to',
                                        search: {
                                            left: '<input type="text" name="q" class="form-control" placeholder="Buscar..." />',
                                            right: '<input type="text" name="q" class="form-control" placeholder="Buscar..." />',
                                        },
                                        fireSearch: function (value) {
                                            return value.length > 3;
                                        },
                                        rightAll: '#right_All_1',
                                        rightSelected: '#right_Selected_1',
                                        leftSelected: '#left_Selected_1',
                                        leftAll: '#left_All_1',
                                    });
                                });
</script>

@endpush                                                    