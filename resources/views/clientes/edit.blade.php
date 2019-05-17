@extends('plantillas.admin_template')

@include('clientes._common')

@section('header')

	<ol class="breadcrumb">
	    <li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li><a href="{{ route('clientes.index') }}">@yield('clientesAppTitle')</a></li>
	    <li><a href="{{ route('clientes.show', $cliente->id) }}">{{ $cliente->id }}</a></li>
	    <li class="active">Editar</li>
	</ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-edit"></i> @yield('clientesAppTitle') / Editar {{$cliente->id}}</h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">

            {!! Form::model($cliente, array('route' => array('clientes.update', $cliente->id),'method' => 'post', 'id'=>'frm_cliente')) !!}

@include('clientes._form')

                <div class="row">
                </div>

                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary submitForm">Guardar</button>
                    <a class="btn btn-md btn-warning" href="{{ route('seguimientos.show', $cliente->id) }}"><i class="glyphicon glyphicon-new-window"></i> Seguimiento </a>
                    <a class="btn btn-link pull-right" href="{{ route('clientes.index') }}"><i class="glyphicon glyphicon-backward"></i>  Clientes</a>
                    <a class="btn btn-link pull-right" href="{{ route('clientes.index', array('p'=>1)) }}"><i class="glyphicon glyphicon-backward"></i> Inscritos</a>
                </div>
                
            {!! Form::close() !!}

        </div>
    </div>
    
    <!--
 Crear Inscripcion
-->
    <div id="crearInscripcionModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">×</button>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body">
                    <form role="form">
                        <div class="row_reglas_relacionadas">
                            
                            <div class="row"></div>
                                <div class="form-group col-md-6 @if($errors->has('cliente_id')) has-error @endif">
                                    <label for="cliente_id-field">Id Alumno</label> 
                                    {!! Form::text("cliente_id", null, array("class" => "form-control input-sm", "id" => "cliente_id-crear")) !!}
                                    {!! Form::hidden("combinacion_cliente_id", null, array("class" => "form-control input-sm", "id" => "combinacion_cliente_id-crear")) !!}
                                    @if($errors->has("cliente_id"))
                                     <span class="help-block">{{ $errors->first("cliente_id") }}</span>
                                    @endif
                                 </div>
                                 <div class="form-group col-md-6 @if($errors->has('cliente_id')) has-error @endif">
                                    <label for="cliente_id-field">Nombre Alumno</label> 
                                    
                                    {!! Form::text("cliente", null, array("class" => "form-control input-sm", "id" => "cliente-crear")) !!}
                                    @if($errors->has("cliente_id"))
                                     <span class="help-block">{{ $errors->first("cliente_id") }}</span>
                                    @endif
                                 </div>
                            <div class="row"></div>
                    <div class="form-group col-md-6 @if($errors->has('plantel_id')) has-error @endif">
                    <label for="plantel_id-crear">Plantel</label>
                    {!! Form::select("plantel_id", $list3["Plantel"], null, array("class" => "form-control select_seguridad", "id" => "plantel_id-crear", 'readonly'=>'readonly')) !!}
                    @if($errors->has("plantel_id"))
                        <span class="help-block">{{ $errors->first("plantel_id") }}</span>
                    @endif
                    </div>
                    <div class="form-group col-md-6 @if($errors->has('especialidad')) has-error @endif">
                    <label for="especialidad-crear">Especialidad</label>
                    {!! Form::select("especialidad_id", $list3["Especialidad"], null, array("class" => "form-control select_seguridad", "id" => "especialidad_id-crear")) !!}
                    <div id='loading10' style='display: none'><img src="{{ asset('images/ajax-loader.gif') }}" title="Enviando" /></div> 
                    @if($errors->has("especialidad"))
                        <span class="help-block">{{ $errors->first("especialidad") }}</span>
                    @endif
                    </div>
                    <div class="form-group col-md-6 @if($errors->has('nivel_id')) has-error @endif">
                    <label for="nivel_id-crear">Nivel</label>
                    {!! Form::select("nivel_id", $list3["Nivel"], null, array("class" => "form-control select_seguridad", "id" => "nivel_id-crear")) !!}
                    <div id='loading11' style='display: none'><img src="{{ asset('images/ajax-loader.gif') }}" title="Enviando" /></div> 
                    @if($errors->has("nivel_id"))
                        <span class="help-block">{{ $errors->first("nivel_id") }}</span>
                    @endif
                    </div>
                    <div class="form-group col-md-6 @if($errors->has('grado_id')) has-error @endif">
                    <label for="grado_id-crear">Grado</label>
                    {!! Form::select("grado_id", $list3["Grado"], null, array("class" => "form-control select_seguridad", "id" => "grado_id-crear")) !!}
                    <div id='loading12' style='display: none'><img src="{{ asset('images/ajax-loader.gif') }}" title="Enviando" /></div> 
                    @if($errors->has("grado_id"))
                        <span class="help-block">{{ $errors->first("grado_id") }}</span>
                    @endif
                    </div>
                    <div class="form-group col-md-6 @if($errors->has('lectivo_id')) has-error @endif">
                       <label for="lectivo_id-crear">Periodo Lectivo</label>
                       {!! Form::select("lectivo_id", $list3["Lectivo"], null, array("class" => "form-control select_seguridad", "id" => "lectivo_id-crear")) !!}
                       @if($errors->has("lectivo_id"))
                        <span class="help-block">{{ $errors->first("lectivo_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-6 @if($errors->has('grupo_id')) has-error @endif">
                       <label for="grupo_id-crear" id="lbl_disponibles">Grupo </label>
                       {!! Form::select("grupo_id", $list3["Grupo"], null, array("class" => "form-control select_seguridad", "id" => "grupo_id-crear")) !!}
                       <div class='loading3' style='display: none'><img src="{{ asset('images/ajax-loader.gif') }}" title="Enviando" /></div> 
                       @if($errors->has("grupo_id"))
                        <span class="help-block">{{ $errors->first("grupo_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-6 @if($errors->has('disponibles')) has-error @endif">
                       <label for="disponibles-crear">Disponibles</label>
                       {!! Form::text("disponibles", null, array("class" => "form-control input-sm", "id" => "disponibles-crear")) !!}
                    </div>
                    <div class="form-group col-md-6 @if($errors->has('periodo_estudio_id')) has-error @endif">
                       <label for="periodo_estudio_id-crear" id="lbl_disponibles">Perido Estudio </label>
                       {!! Form::select("periodo_estudio_id", $list3["PeriodoEstudio"], null, array("class" => "form-control select_seguridad", "id" => "periodo_estudio_id-crear")) !!}
                       @if($errors->has("periodo_estudio_id"))
                        <span class="help-block">{{ $errors->first("periodo_estudio_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-6 @if($errors->has('turno_id')) has-error @endif">
                       <label for="turno_id-crear" id="lbl_disponibles">Turno </label>
                       {!! Form::select("turno_id", $list3["Turno"], null, array("class" => "form-control select_seguridad", "id" => "turno_id-crear")) !!}
                       @if($errors->has("turno_id"))
                        <span class="help-block">{{ $errors->first("periodo_estudio_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-6 @if($errors->has('fec_inscripcion')) has-error @endif">
                       <label for="fec_inscripcion-crear">F. Inscripcion</label>
                       {!! Form::text("fec_inscripcion", null, array("class" => "form-control input-sm", "id" => "fec_inscripcion-crear")) !!}
                       @if($errors->has("fec_inscripcion"))
                        <span class="help-block">{{ $errors->first("fec_inscripcion") }}</span>
                       @endif
                    </div>
                    
                    <div class="form-group col-md-6 @if($errors->has('matricula')) has-error @endif">
                       <label for="matricula-crear">Matricula</label>
                       {!! Form::text("matricula", null, array("class" => "form-control input-sm", "id" => "matricula-crear")) !!}
                       @if($errors->has("matricula"))
                        <span class="help-block">{{ $errors->first("matricula") }}</span>
                       @endif
                    </div>
                            <div class="row"></div>
                        </div> 
                    </form>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id="inscripcion-crear" data-dismiss="modal">
                            <span class='glyphicon glyphicon-check'></span> Crear
                        </button>
                        <button type="button" class="btn btn-warning" data-dismiss="modal">
                            <span class='glyphicon glyphicon-remove'></span> Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

<!--
 Editar Inscripcion
-->
    <div id="editarInscripcionModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">×</button>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body">
                    <form role="form">
                        <div class="row_reglas_relacionadas">
                            
                            <div class="row"></div>
                                <div class="form-group col-md-6 @if($errors->has('cliente_id')) has-error @endif">
                                    <label for="cliente_id-field">Id Alumno</label> 
                                    {!! Form::text("cliente_id", null, array("class" => "form-control input-sm", "id" => "cliente_id-editar")) !!}
                                    
                                    @if($errors->has("cliente_id"))
                                     <span class="help-block">{{ $errors->first("cliente_id") }}</span>
                                    @endif
                                 </div>
                                 <div class="form-group col-md-6 @if($errors->has('cliente_id')) has-error @endif">
                                    <label for="cliente_id-field">Nombre Alumno</label> 
                                    
                                    {!! Form::text("cliente", null, array("class" => "form-control input-sm", "id" => "cliente-editar")) !!}
                                    @if($errors->has("cliente_id"))
                                     <span class="help-block">{{ $errors->first("cliente_id") }}</span>
                                    @endif
                                 </div>
                            <div class="row"></div>
                    <div class="form-group col-md-6 @if($errors->has('plantel_id')) has-error @endif">
                    <label for="plantel_id-field">Plantel</label>
                    {!! Form::select("plantel_id", $list3["Plantel"], null, array("class" => "form-control select_seguridad", "id" => "plantel_id-editar", 'readonly'=>'readonly')) !!}
                    @if($errors->has("plantel_id"))
                        <span class="help-block">{{ $errors->first("plantel_id") }}</span>
                    @endif
                    </div>
                    <div class="form-group col-md-6 @if($errors->has('especialidad')) has-error @endif">
                    <label for="especialidad-field">Especialidad</label>
                    {!! Form::select("especialidad_id", $list3["Especialidad"], null, array("class" => "form-control select_seguridad", "id" => "especialidad_id-editar")) !!}
                    <div id='loading10' style='display: none'><img src="{{ asset('images/ajax-loader.gif') }}" title="Enviando" /></div> 
                    @if($errors->has("especialidad"))
                        <span class="help-block">{{ $errors->first("especialidad") }}</span>
                    @endif
                    </div>
                    <div class="form-group col-md-6 @if($errors->has('nivel_id')) has-error @endif">
                    <label for="nivel_id-field">Nivel</label>
                    {!! Form::select("nivel_id", $list3["Nivel"], null, array("class" => "form-control select_seguridad", "id" => "nivel_id-editar")) !!}
                    <div id='loading11' style='display: none'><img src="{{ asset('images/ajax-loader.gif') }}" title="Enviando" /></div> 
                    @if($errors->has("nivel_id"))
                        <span class="help-block">{{ $errors->first("nivel_id") }}</span>
                    @endif
                    </div>
                    <div class="form-group col-md-6 @if($errors->has('grado_id')) has-error @endif">
                    <label for="grado_id-field">Grado</label>
                    {!! Form::select("grado_id", $list3["Grado"], null, array("class" => "form-control select_seguridad", "id" => "grado_id-editar")) !!}
                    <div id='loading12' style='display: none'><img src="{{ asset('images/ajax-loader.gif') }}" title="Enviando" /></div> 
                    @if($errors->has("grado_id"))
                        <span class="help-block">{{ $errors->first("grado_id") }}</span>
                    @endif
                    </div>
                    <div class="form-group col-md-6 @if($errors->has('lectivo_id')) has-error @endif">
                       <label for="lectivo_id-field">Periodo Lectivo</label>
                       {!! Form::select("lectivo_id", $list3["Lectivo"], null, array("class" => "form-control select_seguridad", "id" => "lectivo_id-editar")) !!}
                       @if($errors->has("lectivo_id"))
                        <span class="help-block">{{ $errors->first("lectivo_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-6 @if($errors->has('grupo_id')) has-error @endif">
                       <label for="grupo_id-field" id="lbl_disponibles">Grupo </label>
                       {!! Form::select("grupo_id", $list3["Grupo"], null, array("class" => "form-control select_seguridad", "id" => "grupo_id-editar")) !!}
                       <div class='loading3' style='display: none'><img src="{{ asset('images/ajax-loader.gif') }}" title="Enviando" /></div> 
                       @if($errors->has("grupo_id"))
                        <span class="help-block">{{ $errors->first("grupo_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-6 @if($errors->has('disponibles')) has-error @endif">
                       <label for="disponibles-field">Disponibles</label>
                       {!! Form::text("disponibles", null, array("class" => "form-control input-sm", "id" => "disponibles-editar")) !!}
                    </div>
                    <div class="form-group col-md-6 @if($errors->has('periodo_estudio_id')) has-error @endif">
                       <label for="periodo_estudio_id-field" id="lbl_disponibles">Perido Estudio </label>
                       {!! Form::select("periodo_estudio_id", $list3["PeriodoEstudio"], null, array("class" => "form-control select_seguridad", "id" => "periodo_estudio_id-editar")) !!}
                       @if($errors->has("periodo_estudio_id"))
                        <span class="help-block">{{ $errors->first("periodo_estudio_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-6 @if($errors->has('turno_id')) has-error @endif" style="clear:left;">
                       <label for="turno_id-field" id="lbl_disponibles">Turno </label>
                       {!! Form::select("turno_id", $list3["Turno"], null, array("class" => "form-control select_seguridad", "id" => "turno_id-editar")) !!}
                       @if($errors->has("turno_id"))
                        <span class="help-block">{{ $errors->first("periodo_estudio_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-6 @if($errors->has('fec_inscripcion')) has-error @endif">
                       <label for="fec_inscripcion-field">F. Inscripcion</label>
                       {!! Form::text("fec_inscripcion", null, array("class" => "form-control input-sm", "id" => "fec_inscripcion-editar")) !!}
                       @if($errors->has("fec_inscripcion"))
                        <span class="help-block">{{ $errors->first("fec_inscripcion") }}</span>
                       @endif
                    </div>
                    
                    <div class="form-group col-md-6 @if($errors->has('matricula')) has-error @endif">
                       <label for="matricula-field">Matricula</label>
                       {!! Form::text("matricula", null, array("class" => "form-control input-sm", "id" => "matricula-editar")) !!}
                       @if($errors->has("matricula"))
                        <span class="help-block">{{ $errors->first("matricula") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-6 @if($errors->has('st_inscripcion_id')) has-error @endif">
                    <label for="st_inscripcion_id-field">Estatus</label>
                    {!! Form::select("st_inscripcion_id", $list3["StInscripcion"], null, array("class" => "form-control select_seguridad", "id" => "st_inscripcion_id-editar", 'readonly'=>'readonly')) !!}
                    @if($errors->has("st_inscripcion_id"))
                        <span class="help-block">{{ $errors->first("st_inscripcion_id") }}</span>
                    @endif
                    </div>
                            <div class="row"></div>
                        </div> 
                    </form>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id="inscripcion-editar" data-dismiss="modal">
                            <span class='glyphicon glyphicon-check'></span> Crear
                        </button>
                        <button type="button" class="btn btn-warning" data-dismiss="modal">
                            <span class='glyphicon glyphicon-remove'></span> Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection