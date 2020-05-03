@extends('plantillas.admin_template')

@include('adeudos._common')

@section('header')

	<ol class="breadcrumb">
		<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li class="active">Crear</li>
	</ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-plus"></i> @yield('adeudosAppTitle') / Crear </h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">

            {!! Form::open(array('route' => 'cajas.moodleAdeudosXplantel')) !!}

            <div class="form-group col-md-4 @if($errors->has('plantel_id')) has-error @endif">
                <label for="plantel_id-field">Plantel</label>
                {!! Form::select("plantel_id", $plantels, null, array("class" => "form-control select_seguridad", "id" => "plantel_id-field")) !!}
                @if($errors->has("plantel_id"))
                <span class="help-block">{{ $errors->first("plantel_id") }}</span>
                @endif
            </div>

                <div class="row">
                </div>
                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">Crear</button>
                </div>
            {!! Form::close() !!}

        </div>
    </div>
@endsection