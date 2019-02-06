@extends('plantillas.admin_template')

@include('empresas._common')

@section('header')

<ol class="breadcrumb">
	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
    <li><a href="{{ route('empresas.index') }}">@yield('empresasAppTitle')</a></li>
    <li class="active">{{ $empresa->name }}</li>
</ol>

<div class="page-header">
        <h1>@yield('empresasAppTitle') / Seguimiento {{$empresa->id}}

            {!! Form::model($empresa, array('route' => array('empresas.destroy', $empresa->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? Estas seguro?')) { return true } else {return false };")) !!}
                <div class="btn-group pull-right" role="group" aria-label="...">
                    @permission('empresa.edit')
                    <a class="btn btn-warning btn-group" role="group" href="{{ route('empresas.edit', $empresa->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                    @endpermission
                    @permission('empresa.destroy')
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
                <div class="form-group col-sm-2">
                    <label for="nome">ID</label>
                    <p class="form-control-static">{{$empresa->id}}</p>
                </div>
                <div class="form-group col-sm-2">
                     <label for="razon_social">RAZON SOCIAL</label>
                     <p class="form-control-static">{{$empresa->razon_social}}</p>
                </div>
                    <div class="form-group col-sm-2">
                     <label for="nombre_contacto">CONTACTO</label>
                     <p class="form-control-static">{{$empresa->nombre_contacto}}</p>
                </div>
                    <div class="form-group col-sm-2">
                     <label for="tel_fijo">TEL. FIJO</label>
                     <p class="form-control-static">{{$empresa->tel_fijo}}</p>
                </div>
                    <div class="form-group col-sm-2">
                     <label for="tel_cel">TEL. CEL.</label>
                     <p class="form-control-static">{{$empresa->tel_cel}}</p>
                </div>
                    <div class="form-group col-sm-2">
                     <label for="correo1">CORREO 1</label>
                     <p class="form-control-static">{{$empresa->correo1}}</p>
                </div>
                    <div class="form-group col-sm-2">
                     <label for="correo2">CORREO 2</label>
                     <p class="form-control-static">{{$empresa->correo2}}</p>
                </div>
            </form>

            <div class="row">
                </div>

            <a class="btn btn-link" href="{{ route('empresas.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>

        </div>
    </div>
    <div class="row">
        <div class="form-group col-md-6">    
            <div class="box box-success">
                    <div class="box-body">
                        <div class="table-responsive">
                            <button 
                            type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#favoritesModal">
                                Agregar Tarea
                            </button>
                        
                            <table class="table table-bordered table-striped dataTable">
                                <thead>
                                    <tr>
                                        <th>Tarea</th>
                                        <th>Asunto</th>
                                        <th>Detalle</th>
                                        <th>Estatus</th>
                                        <th>Fecha</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($asignacionTareas as $at)
                                    <tr>
                                        <td>{{$at->tarea->name}}</td>
                                        <td>{{$at->asunto->name}}</td>
                                        <td>{{$at->detalle}}</td>
                                        <td>{{$at->stTarea->name}}</td>
                                        <td>{{$at->created_at}}</td>
                                        <td>
                                        @permission('asignacionTareas.destroy')   
                                        {!! Form::model($at, array('route' => array('asignacionTareas.destroyModal', $at->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? ¿Esta seguro?')) { return true } else {return false };")) !!}
                                            <button type="submit" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i> Borrar</button>
                                        {!! Form::close() !!}
                                        @endpermission
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                   </div>
                </div>
            </div>
            
            
            <div class="form-group col-md-6">
                <div class="box box-warning">
                    <div class="box-body">
                        <div class="table-responsive">
                            <button 
                            type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#favoritesModal1">
                                Agregar Aviso
                            </button>
                        
                            <table class="table table-bordered table-striped dataTable">
                                <thead>
                                    <tr>
                                        <th>Fecha</th>
                                        <th>Asunto</th>
                                        <th>Detalle</th>
                                        <th>Cerrar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($avisos as $a)
                                    <tr>
                                        <td>
                                        @if($a->dias_restantes<=0)
                                            <small class="label label-danger">
                                        @elseif($a->dias_restantes==1)
                                            <small class="label label-warning"> 
                                        @elseif($a->dias_restantes>=2)
                                            <small class="label label-success"> 
                                        @endif
                                            {{$a->fecha}}
                                        </small>
                                        </td>
                                        <td>{{$a->name}}</td>
                                        <td>{{$a->detalle}}</td>
                                        <td>
                                            <a class="btn btn-xs btn-primary" href="{{ route('avisos.inactivo', array('id'=>$a->id, 'cliente'=>$empresa->id)) }}"><i class="glyphicon glyphicon-trash"></i> Cerrar</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                   </div>
                </div>
            </div>
    </div>
    <!-- Ventana para crear Tarea -->
            <div class="modal fade" id="favoritesModal" 
                 tabindex="-1" role="dialog" 
                 aria-labelledby="favoritesModalLabel">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" 
                      data-dismiss="modal" 
                      aria-label="Close">
                      <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" 
                    id="favoritesModalLabel">Agregar Tarea</h4>
                  </div>
                  <div class="modal-body">
                    {!! Form::open(array('route' => 'tareasEmpresas.storeModal')) !!}
                    <div class="form-group col-md-6 @if($errors->has('tarea_id')) has-error @endif">
                       <label for="tarea_id-field">Tarea</label>
                       {!! Form::select("tarea_id", $tareas, null, array("class" => "form-control select_seguridad", "id" => "tarea_id-field", 'style'=>'width:100%')) !!}
                       {!! Form::hidden("empresa_id", $empresa->id, array("class" => "form-control input-sm", "id" => "empresa_id-field")) !!}
                       {!! Form::hidden("empleado_id", $empresa->empleado_id, array("class" => "form-control input-sm", "id" => "empleado_id-field")) !!}
                       @if($errors->has("tarea_id"))
                        <span class="help-block">{{ $errors->first("tarea_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-6 @if($errors->has('asunto_id')) has-error @endif">
                       <label for="asunto_id-field">Asunto</label>
                       {!! Form::select("asunto_id", $asuntos, null, array("class" => "form-control select_seguridad", "id" => "asunto_id-field", 'style'=>'width:100%')) !!}
                       @if($errors->has("asunto_id"))
                        <span class="help-block">{{ $errors->first("asunto_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-6 @if($errors->has('st_tarea_id')) has-error @endif">
                       <label for="st_tarea_id-field">Estatus</label>
                       {!! Form::select("st_tarea_id", $estatusTareas, null, array("class" => "form-control select_seguridad", "id" => "st_tarea_id-field", 'style'=>'width:100%')) !!}
                       @if($errors->has("st_tarea_id"))
                        <span class="help-block">{{ $errors->first("st_tarea_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-12 @if($errors->has('detalle')) has-error @endif">
                       <label for="detalle-field">Detalle</label>
                       {!! Form::textArea("detalle", null, array("class" => "form-control input-sm", "id" => "detalle-field", 'rows'=>'3')) !!}
                       {!! Form::hidden("observaciones", null, array("class" => "form-control input-sm", "id" => "observaciones-field", 'value'=>"default")) !!}
                       @if($errors->has("detalle"))
                        <span class="help-block">{{ $errors->first("detalle") }}</span>
                       @endif
                    </div>
                    <div class="row">
                    </div>
                    <div class="well well-sm">
                        <button type="submit" class="btn btn-primary">Crear</button>
                    </div>
                    {!! Form::close() !!}
                  </div>
                  <div class="modal-footer">
                    
                  </div>
                </div>
              </div>
            </div>
            
            
<!-- Ventana para crear Aviso -->
            <div class="modal fade" id="favoritesModal1" 
                 tabindex="-1" role="dialog" 
                 aria-labelledby="favoritesModalLabel">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" 
                      data-dismiss="modal" 
                      aria-label="Close">
                      <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" 
                    id="favoritesModalLabel">Agregar Aviso</h4>
                  </div>
                  <div class="modal-body">
                    {!! Form::open(array('route' => 'avisosEmpresas.store')) !!}
                        <div class="form-group col-md-6 @if($errors->has('asunto_id')) has-error @endif">
                            {!! Form::hidden("empresa_id", $empresa->id, array("class" => "form-control input-sm", "id" => "empresa_id-field")) !!}
                            {!! Form::hidden("cliente_id", $empresa->cliente_id, array("class" => "form-control input-sm", "id" => "cliente_id-field")) !!}
                            <label for="asunto_id-field">Asunto</label>
                            {!! Form::select("asunto_id", $asuntos, null, array("class" => "form-control select_seguridad", "id" => "asunto_id-field", 'style'=>'width:100%')) !!}
                            @if($errors->has("asunto_id"))
                                <span class="help-block">{{ $errors->first("asunto_id") }}</span>
                            @endif
                        </div>
                        <div class="form-group col-md-6 @if($errors->has('fecha')) has-error @endif">
                            <label for="fecha-field">Fecha</label>
                            {!! Form::text("fecha", null, array("class" => "form-control input-sm", "id" => "fecha-field")) !!}
                            @if($errors->has("fecha"))
                                <span class="help-block">{{ $errors->first("fecha") }}</span>
                            @endif
                        </div>
                        <div class="form-group col-md-12 @if($errors->has('detalle')) has-error @endif">
                            <label for="detalle-field">Detalle</label>
                            {!! Form::textArea("detalle", null, array("class" => "form-control input-sm", "id" => "detalle-field", 'rows'=>3)) !!}
                            @if($errors->has("detalle"))
                                <span class="help-block">{{ $errors->first("detalle") }}</span>
                            @endif
                        </div>
                        
                        <div class="row">
                        </div>
                        <div class="well well-sm">
                            <button type="submit" class="btn btn-primary">Crear</button>
                        </div>
                    {!! Form::close() !!}
                    <div class="modal-footer">
                    
                    </div>
                  
                  </div>
                </div>
              </div>
            </div>
@endsection

@push('scripts')
  <script type="text/javascript">
    $(document).ready(function() {
    $('#fecha-field').Zebra_DatePicker({
        days:['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'],
        months:['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
        readonly_element: false,
        lang_clear_date: 'Limpiar',
        show_select_today: 'Hoy',
      });
      
    
    });
    
    
   
    </script>
@endpush