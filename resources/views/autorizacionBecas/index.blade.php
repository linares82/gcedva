@extends('plantillas.admin_template')

@include('autorizacionBecas._common')

@section('header')

    <ol class="breadcrumb">
    	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
        <!--
        @if ( $query_params = Request::input('q') )

            <li class="active"><a href="{{ route('autorizacionBecas.index') }}">@yield('autorizacionBecasAppTitle')</a></li>
            <li class="active">condition(  

            @foreach( $query_params as $key => $value )
                @if (!$loop->first) / @endif {{ $key }} : {{ $value }}
            @endforeach
            )</li>
        @else
            <li class="active">@yield('autorizacionBecasAppTitle')</li>
        @endif
        -->
        <li class="active">@yield('autorizacionBecasAppTitle')</li>
    </ol>

    <div class="">
        <h3>
            <i class="glyphicon glyphicon-align-justify"></i> @yield('autorizacionBecasAppTitle')
            @permission('autorizacionBecas.create')
            <a class="btn btn-success pull-right" href="{{ route('autorizacionBecas.create') }}"><i class="glyphicon glyphicon-plus"></i> Crear</a>
            @endpermission
        </h3>

    </div>

    <div aria-multiselectable="true" role="tablist" id="accordion" class="panel-group">
        <div class="panel panel-default">
            <div id="headingOne" role="tab" class="panel-heading">
                <h4 class="panel-title">
                <a aria-controls="collapseOne" aria-expanded="true" href="#collapseOne" data-parent="#accordion" data-toggle="collapse" role="button">
                    <span aria-hidden="true" class="glyphicon glyphicon-search"></span> Buscar
                </a>
                </h4>
            </div>
            <div aria-labelledby="headingOne" role="tabpanel" class="panel-collapse collapse" id="collapseOne">
                <div class="panel-body">
                    <form class="AutorizacionBeca_search" id="search" action="{{ route('autorizacionBecas.index') }}" accept-charset="UTF-8" method="get">
                        <input type="hidden" name="q[s]" value="{{ @(Request::input('q')['s']) ?: '' }}" />
                        <div class="form-horizontal">

                            <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_solicitud_gt">SOLICITUD</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['solicitud_gt']) ?: '' }}" name="q[solicitud_gt]" id="q_solicitud_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['solicitud_lt']) ?: '' }}" name="q[solicitud_lt]" id="q_solicitud_lt" />
                                </div>
                            </div>
                            -->
                            
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_clientes.nombre_gt">CLIENTE_NOMBRE</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['clientes.nombre_gt']) ?: '' }}" name="q[clientes.nombre_gt]" id="q_clientes.nombre_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['clientes.nombre_lt']) ?: '' }}" name="q[clientes.nombre_lt]" id="q_clientes.nombre_lt" />
                                </div>
                            </div>
                            -->
                            
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_clientes.plantel_id">PLANTEL</label>
                                <div class=" col-sm-9">
                                    {!! Form::select("plantel_id", $plantels, "{{ @(Request::input('q')['clientes.plantel_id_lt']) ?: '' }}", array("class" => "form-control select_seguridad", "name"=>"q[clientes.plantel_id_lt]", "id"=>"q_clientes.plantel_id_lt", "style"=>"width:100%;" )) !!}
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_clientes.nombre_cont">NOMBRE</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['clientes.nombre_cont']) ?: '' }}" name="q[clientes.nombre_cont]" id="q_clientes.nombre_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_monto_inscripcion_gt">MONTO_INSCRIPCION</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['monto_inscripcion_gt']) ?: '' }}" name="q[monto_inscripcion_gt]" id="q_monto_inscripcion_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['monto_inscripcion_lt']) ?: '' }}" name="q[monto_inscripcion_lt]" id="q_monto_inscripcion_lt" />
                                </div>
                            </div>
                            -->
                            
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_st_becas.name_gt">ST_BECA_NAME</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['st_becas.name_gt']) ?: '' }}" name="q[st_becas.name_gt]" id="q_st_becas.name_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['st_becas.name_lt']) ?: '' }}" name="q[st_becas.name_lt]" id="q_st_becas.name_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_autorizacion_becas.st_beca_id_cont">ESTATUS</label>
                                <div class=" col-sm-9">
                                    {!! Form::select("st_clientes.nombre", $estatus, "{{ @(Request::input('q')['autorizacion_becas.st_beca_id_lt']) ?: '' }}", array("class" => "form-control select_seguridad", "name"=>"q[autorizacion_becas.st_beca_id_lt]", "id"=>"q_autorizacion_becas.st_beca_id_lt", "style"=>"width:100%;" )) !!}
                                </div>
                            </div>
                                      
                            <div class="form-group">
                                <div class="col-sm-10 col-sm-offset-2">
                                    <input type="submit" name="commit" value="Buscar" class="btn btn-default btn-xs" />
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            @if($autorizacionBecas->count())
                <table class="table table-condensed table-striped">
                    <thead>
                        <tr>
                            <th>@include('plantillas.getOrderLink', ['column' => 'id', 'title' => 'ID'])</th>
                            <th>PLANTEL</th>
                            <th>@include('plantillas.getOrderlink', ['column' => 'solicitud', 'title' => 'SOLICITUD'])</th>
                        <th>@include('plantillas.getOrderlink', ['column' => 'clientes.nombre', 'title' => 'CLIENTE'])</th>
                        <th>@include('plantillas.getOrderlink', ['column' => 'monto_mensualidad', 'title' => 'PORCENTAJE BECA'])</th>
                        <th>@include('plantillas.getOrderlink', ['column' => 'st_becas.name', 'title' => 'ESTATUS'])</th>
                        <th>@include('plantillas.getOrderlink', ['column' => 'usu_mod_id', 'title' => 'ALTA'])</th>
                        <th>@include('plantillas.getOrderlink', ['column' => 'usu_mod_id', 'title' => 'ULTIMA EDICIÓN'])</th>
                            <th class="text-right">OPCIONES</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($autorizacionBecas as $autorizacionBeca)
                            <tr>
                                <td><a href="{{ route('autorizacionBecas.show', $autorizacionBeca->id) }}">{{$autorizacionBeca->id}}</a></td>
                                <td>{{$autorizacionBeca->cliente->plantel->razon}}</td>
                                <td>{{$autorizacionBeca->solicitud}}</td>
                                <td>{{$autorizacionBeca->cliente->nombre." ".$autorizacionBeca->cliente->nombre2." ".$autorizacionBeca->cliente->ape_paterno." ".$autorizacionBeca->cliente->ape_materno}}</td>
                                <td>{{$autorizacionBeca->monto_mensualidad}}</td>
                                <td>{{$autorizacionBeca->stBeca->name}}</td>
                                <td>{{$autorizacionBeca->usu_alta->name}}</td>
                                <td>{{$autorizacionBeca->usu_mod->name}}</td>
                                <td class="text-right">
                                    @permission('autorizacionBecas.edit')
                                    <a class="btn btn-xs btn-warning" href="{{ route('autorizacionBecas.edit', $autorizacionBeca->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                                    @endpermission
                                    @permission('autorizacionBecas.respuesta_inhabilitado')
                                    <button type="button" class="btn btn-primary btn-xs" id='create_comentario' 
                                            data-toggle="modal" data-autorizacion_beca_id="{{ $autorizacionBeca->id }}"
                                                                data-monto_inscripcion="{{ $autorizacionBeca->monto_inscripcion }}"
                                                                data-monto_mensualidad="{{ $autorizacionBeca->monto_mensualidad }}"
                                                                data-st_beca_id="2">
                                        Respuesta
                                    </button>
                                    @endpermission
                                    @permission('autorizacionBecas.enProceso_inhabilitado')
                                    <button type="button" class="btn btn-primary btn-xs" id='create_comentario' 
                                            data-toggle="modal" data-autorizacion_beca_id="{{ $autorizacionBeca->id }}"
                                                                data-monto_inscripcion="{{ $autorizacionBeca->monto_inscripcion }}"
                                                                data-monto_mensualidad="{{ $autorizacionBeca->monto_mensualidad }}"
                                                                data-st_beca_id="3">
                                        En Proceso
                                    </button>
                                    @endpermission
                                    @permission('autorizacionBecas.autorizacion_inhabilitado')
                                    <button type="button" class="btn btn-primary btn-xs" id='create_comentario' 
                                            data-toggle="modal" data-autorizacion_beca_id="{{ $autorizacionBeca->id }}"
                                                                data-monto_inscripcion="{{ $autorizacionBeca->monto_inscripcion }}"
                                                                data-monto_mensualidad="{{ $autorizacionBeca->monto_mensualidad }}"
                                                                data-st_beca_id="4">
                                        Autorizacion
                                    </button>
                                    @endpermission
                                    @permission('autorizacionBecas.baja_inhabilitado')
                                    <button type="button" class="btn btn-primary btn-xs" id='create_comentario' 
                                            data-toggle="modal" data-autorizacion_beca_id="{{ $autorizacionBeca->id }}"
                                                                data-monto_inscripcion="{{ $autorizacionBeca->monto_inscripcion }}"
                                                                data-monto_mensualidad="{{ $autorizacionBeca->monto_mensualidad }}"
                                                                data-st_beca_id="5">
                                        Baja
                                    </button>
                                    @endpermission
                                    @permission('autorizacionBecas.destroy_inhabilitado')
                                    {!! Form::model($autorizacionBeca, array('route' => array('autorizacionBecas.destroy', $autorizacionBeca->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? ¿Esta seguro?')) { return true } else {return false };")) !!}
                                        <button type="submit" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i> Borrar</button>
                                    {!! Form::close() !!}
                                    @endpermission
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {!! $autorizacionBecas->appends(Request::except('page'))->render() !!}
            @else
                <h3 class="text-center alert alert-info">Vacio!</h3>
            @endif

        </div>
    </div>

<!-- Ventana crear comentario y modificar estatus -->
    <div id="createComentarioModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">×</button>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body">
                    <form class="" role="form">
                        <div class="row_reglas_relacionadas">
                            <div >
                                {!! Form::hidden("autorizacion_beca_id", null, array("class" => "form-control", "id" => "autorizacion_beca_id-crear")) !!}
                                <meta name="csrf-token" content="{{ csrf_token() }}">
                                <input type="hidden" name="_token" id="_token"  value="<?= csrf_token(); ?>"> 
                             </div>
                            <div class="form-group col-sm-12 @if($errors->has('fec_fin')) has-error @endif">
                                <label for="inicial_bnd-field">Comentario</label>
                                {!! Form::text("comentario", null, array("class" => "form-control", "id" => "comentario-crear")) !!}
                            </div>
                            <div class="form-group col-sm-6 @if($errors->has('fec_fin')) has-error @endif">
                                <label for="inicial_bnd-field">Monto Inscripcion</label>
                                {!! Form::text("monto_inscripcion", null, array("class" => "form-control", "id" => "monto_inscripcion-crear")) !!}
                            </div>
                            <div class="form-group col-sm-6 @if($errors->has('fec_fin')) has-error @endif">
                                <label for="inicial_bnd-field">Monto mensualidad</label>
                                {!! Form::text("monto_mensualidad", null, array("class" => "form-control", "id" => "monto_mensualidad-crear")) !!}
                            </div>
                            
                            <div >
                            
                                {!! Form::hidden("st_beca_id", null, array("class" => "form-control", "id" => "st_beca_id-crear")) !!}
                            </div>
                            <div class="row"></div>
                        </div> 
                    </form>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id="comentario-crear" data-dismiss="modal">
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
@push('scripts')
  <script type="text/javascript">
    $(document).ready(function() {
        
        //Crear comentario
        $(document).on('click', '#create_comentario', function() {
            $('#autorizacion_beca_id-crear').val($(this).data('autorizacion_beca_id'));
            $('#monto_inscripcion-crear').val($(this).data('monto_inscripcion'));
            console.log($(this).data('monto_inscripcion'));
            $('#monto_mensualidad-crear').val($(this).data('monto_mensualidad'));
            $('#st_beca_id-crear').val($(this).data('st_beca_id')).change();

            if($(this).data('st_beca_id')==2){
                $('.modal-title').text('Comentario / Respuesta');
            }else if($(this).data('st_beca_id')==3){
                $('.modal-title').text('Comentario / En Proceso');
            }else if($(this).data('st_beca_id')==4){
                $('.modal-title').text('Comentario / Autorizar');
            }else if($(this).data('st_beca_id')==5){
                $('.modal-title').text('Comentario / Baja');
            }

            $('#createComentarioModal').modal('show');
        });
       
        //Crear comentario
        $('.modal-footer').on('click', '#comentario-crear', function() {
        var ruta='{{url("autorizacionBecaComentarios/store")}}';
        
        
        //alert(bnd);
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        
        $.ajax({
            type: 'POST',
            url: ruta,
            data: {
                '_token': $('input[name=_token]').val(),
                'autorizacion_beca_id': $('#autorizacion_beca_id-crear').val(),
                'comentario': $('#comentario-crear').val(),
                'monto_inscripcion': $('#monto_inscripcion-crear').val(),
                'monto_mensualidad': $('#monto_mensualidad-crear').val(),
                'st_beca_id': $('#st_beca_id-crear').val(),
            },
            beforeSend : function(){$("#loading3").show(); },
            complete : function(){$("#loading3").hide(); },
            success: function(data) {
                location.reload();
                }   
        });
    });
    });
  </script>
@endpush  
    