@extends('plantillas.admin_template')

@section('content')
@include('error')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Register</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('users.updatePerfil', $user->id) }}">
                        {{ csrf_field() }}
                        <div class="form-group col-md-4 @if($errors->has('name')) has-error @endif">
                            <label for="name-field">Nombre Usuario</label>
                            {!! Form::text("name", null, array("class" => "form-control", "id" => "name-field", 'rows'=>'3', 'maxlength'=>'255')) !!}
                            @if($errors->has("name"))
                                <span class="help-block">{{ $errors->first("name") }}</span>
                            @endif
                        </div>
                        

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Register
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
