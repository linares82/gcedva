@extends('plantillas.admin_template')

@include('sepFundamentoLegalServicioSocials._common')

@section('header')

<ol class="breadcrumb">
	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
    <li><a href="{{ route('sepFundamentoLegalServicioSocials.index') }}">@yield('sepFundamentoLegalServicioSocialsAppTitle')</a></li>
    <li class="active">{{ $sepFundamentoLegalServicioSocial->name }}</li>
</ol>

<div class="page-header">
        <h1>@yield('sepFundamentoLegalServicioSocialsAppTitle') / Mostrar {{$sepFundamentoLegalServicioSocial->id}}

            {!! Form::model($sepFundamentoLegalServicioSocial, array('route' => array('sepFundamentoLegalServicioSocials.destroy', $sepFundamentoLegalServicioSocial->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? Estas seguro?')) { return true } else {return false };")) !!}
                <div class="btn-group pull-right" role="group" aria-label="...">
                    @permission('sepFundamentoLegalServicioSocial.edit')
                    <a class="btn btn-warning btn-group" role="group" href="{{ route('sepFundamentoLegalServicioSocials.edit', $sepFundamentoLegalServicioSocial->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                    @endpermission
                    @permission('sepFundamentoLegalServicioSocial.destroy')
                    <button type="submit" class="btn btn-danger">Borrar <i class="glyphicon glyphicon-trash"></i><
                    /button>
                    @endpermission
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
                    <p class="form-control-static">{{$sepFundamentoLegalServicioSocial->id}}</p>
                </div>
                <div class="form-group">
                     <label for="id_fundamento_legal_servicio_social">ID_FUNDAMENTO_LEGAL_SERVICIO_SOCIAL</label>
                     <p class="form-control-static">{{$sepFundamentoLegalServicioSocial->id_fundamento_legal_servicio_social}}</p>
                </div>
                    <div class="form-group">
                     <label for="fundamento_legal_servicio_social">FUNDAMENTO_LEGAL_SERVICIO_SOCIAL</label>
                     <p class="form-control-static">{{$sepFundamentoLegalServicioSocial->fundamento_legal_servicio_social}}</p>
                </div>
            </form>

            <div class="row">
                </div>

            <a class="btn btn-link" href="{{ route('sepFundamentoLegalServicioSocials.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>

        </div>
    </div>

@endsection