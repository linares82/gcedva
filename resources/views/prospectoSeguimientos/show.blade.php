@extends('plantillas.admin_template')

@include('prospectoSeguimientos._common')

@section('header')

<ol class="breadcrumb">
    <li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
    <li><a href="{{ route('prospectos.index') }}">@yield('prospectoSeguimientosAppTitle')</a></li>

</ol>

<div class="page-header">
    <h1>@yield('prospectoSeguimientosAppTitle') / Mostrar {{$prospectoSeguimiento->prospecto->id}}

        {!! Form::model($prospectoSeguimiento, array('route' => array('prospectoSeguimientos.destroy', $prospectoSeguimiento->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? Estas seguro?')) { return true } else {return false };")) !!}
        <div class="btn-group pull-right" role="group" aria-label="...">
            @permission('prospectoSeguimiento.edit')
            <a class="btn btn-warning btn-group" role="group" href="{{ route('prospectoSeguimientos.edit', $prospectoSeguimiento->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
            @endpermission
            @permission('prospectoSeguimiento.destroy')
            <button type="submit" class="btn btn-danger">Borrar <i class="glyphicon glyphicon-trash"></i>
                < /button>
                    @endpermission
        </div>
        {!! Form::close() !!}

    </h1>
</div>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="form-group col-md-7 ">
            <div class="box box-default">
                <div class="box-body">
                    <p><label for="prospecto_id">PROSPECTO</label></p>
                    <label for="prospecto_id">Nombre:</label>
                    {{$prospectoSeguimiento->prospecto->nombre}}
                    {{$prospectoSeguimiento->prospecto->nombre2}}
                    {{$prospectoSeguimiento->prospecto->ape_paterno}}
                    {{$prospectoSeguimiento->prospecto->ape_materno}}
                    <label for="prospecto_id">Estatus: </label>
                    {{$prospectoSeguimiento->prospectoStSeg->name}}
                    <label for="prospecto_id">Tel.: </label>
                    {{$prospectoSeguimiento->prospecto->tel_fijo}}
                    <label for="prospecto_id">Cel.: </label>
                    {{$prospectoSeguimiento->prospecto->tel_cel}}
                    <label for="prospecto_id">Mail: </label>
                    {{$prospectoSeguimiento->prospecto->mail}}
                    <label for="prospecto_id">Especialidad: </label>
                    {{$prospectoSeguimiento->prospecto->especialidad->name}}
                    <label for="prospecto_id">Alta: </label>
                    {{$prospectoSeguimiento->prospecto->created_at}} / {{$prospectoSeguimiento->prospecto->usu_alta->name}}
                    <label for="prospecto_id">U. Modificacion: </label>
                    {{$prospectoSeguimiento->usu_mod->name}}
                    {!!Form::model($prospectoSeguimiento, array('route' => array('prospectoSeguimientos.update', $prospectoSeguimiento->id),'method' => 'post','class'=>'form-inline')) !!}
                    <div class="form-group col-md-6 @if($errors->has('prospecto_st_seg_id')) has-error @endif">
                        <label for="st_seguimiento_id-field">Estatus del seguimiento</label>
                        {!! Form::select("prospecto_st_seg_id", $prospectoStSeg,null, array("class" => "form-control select_seguridad", "id" => "prospecto_st_seg_id-field")) !!}
                        @if($errors->has("prospecto_st_seg_id"))
                        <span class="help-block">{{ $errors->first("prospecto_st_seg_id") }}</span>
                        @endif
                    </div>
                    <div class="well well-sm">
                        <button type="submit" class="btn btn-xs btn-primary">Actualizar</button>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
            <div class="box box-success">
                <div class="box-body">
                    <div class="table-responsive">
                        @permission('prospectoTareas.create')
                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#favoritesModal">
                            Agregar Tarea
                        </button>
                        @endpermission
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
                                @foreach($prospectoAsignacionTareas as $tarea)
                                <tr>
                                    <td>{{$tarea->prospectoTarea->name}}</td>
                                    <td>{{$tarea->prospectoAsunto->name}}</td>
                                    <td>{{$tarea->detalle}}</td>
                                    <td>{{$tarea->prospectoStTarea->name}}</td>
                                    <td>{{$tarea->created_at}}</td>
                                    <td>
                                        @permission('prospectoAsignacionTareas.destroy')
                                        {!! Form::model($tarea, array('route' => array('prospectoAsignacionTareas.destroy', $tarea->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? ¿Esta seguro?')) { return true } else {return false };")) !!}
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

        <div class="form-group col-md-5">
            <div class="box box-warning">
                <div class="box-body">
                    <div class="table-responsive">
                        @permission('prospectoAvisos.create')
                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#favoritesModal1">
                            Agregar Aviso
                        </button>
                        @endpermission
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
                                @foreach($prospectoAvisos as $a)
                                <tr>
                                    <td>
                                        @if($a->dias_restantes<=0) <small class="label label-danger">
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

                                        @if($a->activo==1)
                                        <a class="btn btn-xs btn-primary" href="{{ route('prospectoAvisos.inactivo', array('id'=>$a->id, 'prospecto'=>$prospectoSeguimiento->prospecto_id)) }}"><i class="glyphicon glyphicon-trash"></i> Cerrar</a>
                                        @else
                                        Cerrado
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
        </div>

        <a class="btn btn-link" href="{{ route('prospectos.index') }}"><i class="glyphicon glyphicon-backward"></i> Regresar</a>
        <a class="btn btn-link" href="{{ route('prospectos.create') }}"><i class="glyphicon glyphicon-backward"></i> Crear Nuevo Prospecto</a>

        @if(isset($actividades))

    <div class="row">
        <div class="col-md-12">
            <ul class="timeline">
                @foreach($actividades as $a)

                <li class="time-label">
                    <span class="bg-red">
                        {{$a->fecha }}
                    </span>
                </li>
                <li>
                    @if($a->tarea=='Seguimiento')
                    <i class="fa  fa-check-square-o bg-blue"></i>
                    @elseif($a->tarea=='Aviso')
                    <i class="fa fa-envelope bg-green"></i>
                    @else
                    <i class="fa fa-tasks bg-orange"></i>
                    @endif


                    <div class="timeline-item">
                        <span class="time"><i class="fa fa-clock-o"></i> {{$a->hora }}</span>
                        <h3 class="timeline-header"><strong>Actividad:</strong> {{$a->tarea }}</h3>
                        <div class="timeline-body">
                            <b>{{$a->asunto}}</b> : {{$a->detalle }}
                        </div>
                    </div>
                </li>
                @endforeach

                <!-- END timeline item -->
                <li>
                    <i class="fa fa-clock-o bg-gray"></i>
                </li>
            </ul>
            <!--        Termina time line-->
        </div>
    </div>

    @endif

    </div>
</div>

<!-- Ventana para crear Tarea -->
<div class="modal fade" id="favoritesModal" tabindex="-1" role="dialog" aria-labelledby="favoritesModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="favoritesModalLabel">Agregar Tarea</h4>
            </div>
            <div class="modal-body">
                {!! Form::open(array('route' => 'prospectoAsignacionTareas.store')) !!}
                <div class="form-group col-md-6 @if($errors->has('tarea_id')) has-error @endif">
                    <label for="tarea_id-field">Tarea</label>
                    {!! Form::select("prospecto_tarea_id", $tareas, null, array("class" => "form-control select_seguridad", "id" => "tarea_id-field", 'style'=>'width:100%')) !!}
                    {!! Form::hidden("prospecto_id", $prospectoSeguimiento->prospecto_id, array("class" => "form-control input-sm", "id" => "prospecto_id-field")) !!}
                    {!! Form::hidden("empleado_id", $prospectoSeguimiento->prospecto->empleado_id, array("class" => "form-control input-sm", "id" => "empleado_id-field")) !!}
                    @if($errors->has("tarea_id"))
                    <span class="help-block">{{ $errors->first("tarea_id") }}</span>
                    @endif
                </div>
                <div class="form-group col-md-6 @if($errors->has('asunto_id')) has-error @endif">
                    <label for="asunto_id-field">Asunto</label>
                    {!! Form::select("prospecto_asunto_id", $asuntos, null, array("class" => "form-control select_seguridad", "id" => "prospecto_asunto_id-field", 'style'=>'width:100%')) !!}
                    @if($errors->has("prospecto_asunto_id"))
                    <span class="help-block">{{ $errors->first("prospecto_asunto_id") }}</span>
                    @endif
                </div>
                <div class="form-group col-md-6 @if($errors->has('prospecto_st_tarea_id')) has-error @endif">
                    <label for="prospecto_st_tarea_id-field">Estatus</label>
                    {!! Form::select("prospecto_st_tarea_id", $estatusTareas, null, array("class" => "form-control select_seguridad", "id" => "prospecto_st_tarea_id-field", 'style'=>'width:100%')) !!}
                    @if($errors->has("prospecto_st_tarea_id"))
                    <span class="help-block">{{ $errors->first("prospecto_st_tarea_id") }}</span>
                    @endif
                </div>
                <div class="form-group col-md-12 @if($errors->has('detalle')) has-error @endif">
                    <label for="detalle-field">Detalle</label>
                    {!! Form::textArea("detalle", null, array("class" => "form-control input-sm", "id" => "detalle-field", 'rows'=>'3')) !!}
                    {!! Form::hidden("obs", null, array("class" => "form-control input-sm", "id" => "obs-field", 'value'=>"default")) !!}
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
<div class="modal fade" id="favoritesModal1" tabindex="-1" role="dialog" aria-labelledby="favoritesModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="favoritesModalLabel">Agregar Aviso</h4>
            </div>
            <div class="modal-body">
                {!! Form::open(array('route' => 'prospectoAvisos.store')) !!}
                <div class="form-group col-md-6 @if($errors->has('asunto_id')) has-error @endif">
                    {!! Form::hidden("prospecto_seguimiento_id", $prospectoSeguimiento->id, array("class" => "form-control input-sm", "id" => "prospecto_seguimiento_id-field")) !!}
                    {!! Form::hidden("prospecto_id", $prospectoSeguimiento->prospecto_id, array("class" => "form-control input-sm", "id" => "prospecto_id-field")) !!}
                    <label for="asunto_id-field">Asunto</label>
                    {!! Form::select("prospecto_asunto_id", $asuntos, null, array("class" => "form-control select_seguridad", "id" => "prospecto_asunto_id-field", 'style'=>'width:100%')) !!}
                    @if($errors->has("prospecto_asunto_id"))
                    <span class="help-block">{{ $errors->first("prospecto_asunto_id") }}</span>
                    @endif
                </div>
                <div class="form-group col-md-6 @if($errors->has('fecha')) has-error @endif">
                    <label for="fecha-field">Fecha</label>
                    {!! Form::text("fecha", null, array("class" => "form-control input-sm fecha", "id" => "fecha-field")) !!}
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


        $("#btn_sms").click(function(event) {
            enviaSms();
        });

        $('#sms_predefinido-field').change(function() {

            $.ajax({
                url: '{{ route("smsPredefinidos.getDetalleSms") }}',
                type: 'GET',
                data: "sms=" + $('#sms_predefinido-field option:selected').val(),
                dataType: 'json',
                beforeSend: function() {
                    $("#loading1").show();
                },
                complete: function() {
                    $("#loading1").hide();
                },
                success: function(sms) {
                    $('#cve_cliente-field').val(sms);
                }
            });
        });

    });

    function enviaSms() {
        $.ajax({
            url: '{{ route("clientes.enviaSmsSeguimiento") }}',
            type: 'GET',
            data: "tel_cel={{$prospectoSeguimiento->prospecto->tel_cel}}&cve_cliente=" + $('#cve_cliente-field').val() + "",
            dataType: 'json',
            beforeSend: function() {
                $("#loading1").show();
            },
            complete: function() {
                $("#loading1").hide();
            },
            default: function(parametros) {
                if (parametros == true) {
                    $('#msj').html('Sms enviado');
                } else {
                    $('#msj').html('Envio de sms fallo');
                }
            }
        });
    }
</script>
@endpush