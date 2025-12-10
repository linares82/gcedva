@extends('plantillas.admin_login')


@section('content')

    <div class="error-page">
        <h2 class="headline text-red">503</h2>
        <div class="error-content">
            <h3><i class="fa fa-warning text-red">
                </i> Estamos en mantenimiento</h3>
                <p>{{$exception->getMessage()}}</p>
                <p>
                Estamos trabajando...
            </p>
           
        </div>
    </div><!-- /.error-page -->
@endsection
