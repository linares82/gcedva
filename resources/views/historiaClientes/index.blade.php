@extends('plantillas.admin_template')

@include('historiaClientes._common')

@section('header')

    <ol class="breadcrumb">
    	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
        <!--
        @if ( $query_params = Request::input('q') )

            <li class="active"><a href="{{ route('historiaClientes.index') }}">@yield('historiaClientesAppTitle')</a></li>
            <li class="active">condition(  

            @foreach( $query_params as $key => $value )
                @if (!$loop->first) / @endif {{ $key }} : {{ $value }}
            @endforeach
            )</li>
        @else
            <li class="active">@yield('historiaClientesAppTitle')</li>
        @endif
        -->
        <li class="active">@yield('historiaClientesAppTitle')</li>
    </ol>

    <div class="">
        <h3>
            <i class="glyphicon glyphicon-align-justify"></i> @yield('historiaClientesAppTitle')
            @permission('historiaClientes.create')
            <!--<a class="btn btn-success pull-right" href="{{ route('historiaClientes.create') }}"><i class="glyphicon glyphicon-plus"></i> Crear</a>-->
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
                    <form class="HistoriaCliente_search" id="search" action="{{ route('historiaClientes.index') }}" accept-charset="UTF-8" method="get">
                        <input type="hidden" name="q[s]" value="{{ @(Request::input('q')['s']) ?: '' }}" />
                        <div class="form-horizontal">

                            <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_evento_clientes.name_gt">EVENTO_CLIENTE_NAME</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['evento_clientes.name_gt']) ?: '' }}" name="q[evento_clientes.name_gt]" id="q_evento_clientes.name_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['evento_clientes.name_lt']) ?: '' }}" name="q[evento_clientes.name_lt]" id="q_evento_clientes.name_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_evento_clientes.name_cont">EVENTO_CLIENTE_NAME</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['evento_clientes.name_cont']) ?: '' }}" name="q[evento_clientes.name_cont]" id="q_evento_clientes.name_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_descripcion_gt">DESCRIPCION</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['descripcion_gt']) ?: '' }}" name="q[descripcion_gt]" id="q_descripcion_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['descripcion_lt']) ?: '' }}" name="q[descripcion_lt]" id="q_descripcion_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_descripcion_cont">DESCRIPCION</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['descripcion_cont']) ?: '' }}" name="q[descripcion_cont]" id="q_descripcion_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_fecha_gt">FECHA</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['fecha_gt']) ?: '' }}" name="q[fecha_gt]" id="q_fecha_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['fecha_lt']) ?: '' }}" name="q[fecha_lt]" id="q_fecha_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_fecha_cont">FECHA</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['fecha_cont']) ?: '' }}" name="q[fecha_cont]" id="q_fecha_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_archivo_gt">ARCHIVO</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['archivo_gt']) ?: '' }}" name="q[archivo_gt]" id="q_archivo_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['archivo_lt']) ?: '' }}" name="q[archivo_lt]" id="q_archivo_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_archivo_cont">ARCHIVO</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['archivo_cont']) ?: '' }}" name="q[archivo_cont]" id="q_archivo_cont" />
                                </div>
                            </div>
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
                                <label class="col-sm-2 control-label" for="q_clientes.nombre_cont">CLIENTE_NOMBRE</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['clientes.nombre_cont']) ?: '' }}" name="q[clientes.nombre_cont]" id="q_clientes.nombre_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_usu_alta_id_gt">USU_ALTA_ID</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['usu_alta_id_gt']) ?: '' }}" name="q[usu_alta_id_gt]" id="q_usu_alta_id_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['usu_alta_id_lt']) ?: '' }}" name="q[usu_alta_id_lt]" id="q_usu_alta_id_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_usu_alta_id_cont">USU_ALTA_ID</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['usu_alta_id_cont']) ?: '' }}" name="q[usu_alta_id_cont]" id="q_usu_alta_id_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_usu_mod_id_gt">USU_MOD_ID</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['usu_mod_id_gt']) ?: '' }}" name="q[usu_mod_id_gt]" id="q_usu_mod_id_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['usu_mod_id_lt']) ?: '' }}" name="q[usu_mod_id_lt]" id="q_usu_mod_id_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_usu_mod_id_cont">USU_MOD_ID</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['usu_mod_id_cont']) ?: '' }}" name="q[usu_mod_id_cont]" id="q_usu_mod_id_cont" />
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
            @if($historiaClientes->count())
                <table class="table table-condensed table-striped tblEnc">
                    <thead>
                        <tr>
                            <th>@include('plantillas.getOrderLink', ['column' => 'id', 'title' => 'ID'])</th>
                            <th>@include('plantillas.getOrderlink', ['column' => 'evento_clientes.name', 'title' => 'EVENTO'])</th>
                        <th>@include('plantillas.getOrderlink', ['column' => 'fecha', 'title' => 'FECHA'])</th>
                        <th>@include('plantillas.getOrderlink', ['column' => 'fec_vigencia', 'title' => 'FECHA VIGENCIA'])</th>
                        <th>@include('plantillas.getOrderlink', ['column' => 'archivo', 'title' => 'ARCHIVO'])</th>
                        <th>@include('plantillas.getOrderlink', ['column' => 'clientes.nombre', 'title' => 'CLIENTE'])</th>
                        <th>@include('plantillas.getOrderlink', ['column' => 'clientes.fec_reactivado', 'title' => 'F. REACT.'])</th>
                        <th>ESTATUS</th>
                        <th>AUTORIZACIONES</th>
                        <th>CAJA</th>
                        <th>DIRECTOR</th>
                        <th>CAJA CORP.</th>
                            <th class="text-right">OPCIONES</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($historiaClientes as $historiaCliente)
                            <tr>
                                <td><a href="{{ route('historiaClientes.show', $historiaCliente->id) }}">{{$historiaCliente->id}}</a></td>
                                <td>{{$historiaCliente->eventoCliente->name}}</td>
                                <td>{{$historiaCliente->fecha}}</td>
                                <td>{{$historiaCliente->fec_vigencia}}</td>
                                <td><a href='{!! asset("/imagenes/historia_clientes/".$historiaCliente->id."/".$historiaCliente->archivo) !!}' target='_blank'>Ver</a></td>
                                <td>
                                    <a href="{{ route('clientes.edit',$historiaCliente->cliente_id) }}" target="_blank">
                                        {{$historiaCliente->cliente->nombre}} {{$historiaCliente->cliente->nombre2}} {{$historiaCliente->cliente->ape_paterno}} {{$historiaCliente->cliente->ape_materno}}
                                    </a>
                                    
                                </td>
                                <td>({{ $historiaCliente->reactivado }}) {{$historiaCliente->fec_reactivado}}</td>
                                <td>{{$historiaCliente->stHistoriaCliente->name}}</td>
                                
                                <td>
                                    @if($historiaCliente->evento_cliente_id==2)
                                    <button class="btn btn-success btnVerLineas pull-right btn-xs" lang="mesaj" data-check="{{$historiaCliente->id}}" data-href="formation_json_parents" style="margin-left:10px;" >
                                        <span class="fa fa-eye" aria-hidden="true"></span> Ver
                                    </button>
                                    <div id='loading' style='display: none'><img src="{{ asset('images/ajax-loader.gif') }}" title="Enviando" /></div> 
                                    @endif
                                    
                                    
                                </td>
                                <td>
                                    <!--{{optional($historiaCliente->autSerEsc)->name}}
                                    @@if($historiaCliente->evento_cliente_id==2)
                                    @@permission('autorizacionBaja.aut_servicios_escolares')
                                            <button type="button" class="btn btn-primary btn-xs btn_create_comentario" 
                                                    data-toggle="modal" data-historia_cliente_id="{{ $historiaCliente->id }}"
                                                                                data-autorizacion='aut_ser_esc'>
                                                Autorización
                                            </button>
                                    @@endpermission
                                    @@endif-->
                                    {{optional($historiaCliente->autCaja)->name}}
                                    @if($historiaCliente->evento_cliente_id==2)
                                    @permission('autorizacionBaja.aut_caja')
                                    @if($historiaCliente->aut_caja<>2)
                                            <button type="button" class="btn btn-primary btn-xs btn_create_comentario" 
                                                    data-toggle="modal" data-historia_cliente_id="{{ $historiaCliente->id }}"
                                                                                data-autorizacion='aut_caja'>
                                                Autorización
                                            </button>
                                    @endif
                                    @endpermission
                                    @endif
                                </td>
                                <td>
                                    {{optional($historiaCliente->autDirector)->name}}
                                    @if($historiaCliente->aut_caja==2 and $historiaCliente->evento_cliente_id==2)
                                    @permission('autorizacionBaja.aut_director')
                                    @if($historiaCliente->aut_director<>2)
                                            <button type="button" class="btn btn-primary btn-xs btn_create_comentario" 
                                                    data-toggle="modal" data-historia_cliente_id="{{ $historiaCliente->id }}"
                                                                                data-autorizacion='aut_director'>
                                                Autorización
                                            </button>
                                    @endif
                                    @endpermission
                                    @endif
                                </td>
                                <td>
                                    {{optional($historiaCliente->autCajaCorp)->name}}
                                    @if($historiaCliente->aut_caja==2 and $historiaCliente->aut_director==2 and $historiaCliente->evento_cliente_id==2)
                                    @permission('autorizacionBaja.aut_caja_corp')
                                    @if($historiaCliente->aut_caja_corp<>2)
                                            <button type="button" class="btn btn-primary btn-xs btn_create_comentario"  
                                                    data-toggle="modal" data-historia_cliente_id="{{ $historiaCliente->id }}"
                                                                                data-autorizacion='aut_caja_corp'>
                                                Autorización
                                            </button>
                                    @endif
                                    @endpermission
                                    @endif
                                </td>
                                            <td class="text-right">
                                                @permission('historiaClientes.edit')
                                                @if($historiaCliente->st_historia_cliente_id<>2)
                                                <a class="btn btn-xs btn-warning" href="{{ route('historiaClientes.edit', $historiaCliente->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                                                @endif
                                                @endpermission
                                                @permission('historiaClientes.reactivar')
                                                    <a class="btn btn-xs btn-warning" href="{{ route('historiaClientes.reactivar', array('id'=>$historiaCliente)) }}"><i class="glyphicon glyphicon-edit"></i> Reactivar</a>
                                                @endpermission
                                                @permission('historiaClientes.destroy')
                                                {!! Form::model($historiaCliente, array('route' => array('historiaClientes.destroy', $historiaCliente->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? ¿Esta seguro?')) { return true } else {return false };")) !!}
                                                    <button type="submit" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i> Borrar</button>
                                                {!! Form::close() !!}
                                                @endpermission
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {!! $historiaClientes->appends(Request::except('page'))->render() !!}
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
                    <h4 class="modal-title">Autorizacion / Comentario</h4>
                </div>
                <div class="modal-body">
                    <form class="" role="form">
                        <div class="row_reglas_relacionadas">
                            <div >
                                {!! Form::hidden("historia_cliente_id", null, array("class" => "form-control", "id" => "historia_cliente_id-crear")) !!}
                                {!! Form::hidden("autorizacion", null, array("class" => "form-control", "id" => "autorizacion-crear")) !!}
                                <input type="hidden" name="_token" id="_token"  value="<?= csrf_token(); ?>"> 
                             </div>
                             <div class="form-group col-md-4 @if($errors->has('st_historia_cliente_id')) has-error @endif">
                                <label for="st_historia_cliente_id-field">Estatus</label>
                                {!! Form::select("st_historia_cliente_id", $stHistoriaClientes, null, array("class" => "form-control select_seguridad", "id" => "st_historia_cliente_id-crear")) !!}
                                @if($errors->has("st_historia_cliente_id"))
                                <span class="help-block">{{ $errors->first("st_historia_cliente_id") }}</span>
                                @endif
                            </div>
                             <div class="form-group col-sm-12 @if($errors->has('fec_fin')) has-error @endif">
                                <label for="inicial_bnd-field">Comentario</label>
                                {!! Form::text("comentario", null, array("class" => "form-control", "id" => "comentario-crear")) !!}
                            </div>
                            
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
        $(document).on('click', '.btn_create_comentario', function() {
            $('#historia_cliente_id-crear').val($(this).data('historia_cliente_id'));
            $('#autorizacion-crear').val($(this).data('autorizacion'));
            $('#st_beca_id-crear').val($(this).data('st_beca_id')).change();

            $('#createComentarioModal').modal('show');
        });

        //Crear comentario
        $('.modal-footer').on('click', '#comentario-crear', function() {
        var ruta='{{url("registroHistoriaClientes/store")}}';
        
        //alert(bnd);
        $.ajax({
            type: 'POST',
            url: ruta,
            data: {
                '_token': $('input[name=_token]').val(),
                'historia_cliente_id': $('#historia_cliente_id-crear').val(),
                'autorizacion': $('#autorizacion-crear').val(),
                'st_historia_cliente_id': $('#st_historia_cliente_id-crear option:selected').val(),
                'comentario': $('#comentario-crear').val(),
                
            },
            beforeSend : function(){$("#loading3").show(); },
            complete : function(){$("#loading3").hide(); },
            success: function(data) {
                      location.reload();
                }   
        });
    });
    

var $table = $('.tblEnc');
    $table.find('.btnVerLineas').on('click', function(e) {

// click button

    //e.preventDefault();
    var $btn = $(e.target), $tablosatir = $btn.closest('tr'), $tablosonrakisatir = $tablosatir.next('tr.expand-child');
    if ($btn.attr("lang") === "mesaj") {
///////////// mesajlar butonuna tıklandığında olan olaylar.

    if ($tablosonrakisatir.css("display") === 'none') {
    // if panel close !
    $tablosonrakisatir.slideDown(100);
    } else {
    // if panel open !
    $tablosonrakisatir.slideUp(100);
    }

    //$("#kullanicihebir").html($tablosatir.find("tr").length);	


    if ($tablosonrakisatir.length) {
    // sonraki satır yok ise 	



    } else
    {

    // sonraki satır var ise
    	
    $.ajax({
    url: "{{route('registroHistoriaClientes.findByHistoriaClienteId')}}",
            dataType: "json",
            data: "check=" + $(this).data('check'),
            beforeSend : function(){$("#loading").show(); },
            complete : function(){$("#loading").hide(); },
            success: function (anaVeri) {

            var yenitablosatir = '<tr class="expand-child" id="collapse' + $btn.data('id') + '">' +
                    '<td colspan="12">' +
                    '<table class="table table-condensed altTablo table-hover" width=100% >' +
                    '<thead>' +
                    '<tr>' +
                    '<th>Consecutivo</th>' +
                    '<th>Comentario</th>' +
                    '<th>Estatus</th>' +
                    '<th>Creado el</th>' +
                    '<th>Creado por</th>' +
                    '<th></th>' +
                    '</tr>' +
                    '</thead>' +
                    '<tbody>';
            //if (anaVeri.kullanici) {
            if (anaVeri) {
            //$.each(anaVeri.kullanici, function(i, kullaniciTomar) {

            var j = 1;
            $.each(anaVeri, function(i) {
            var btnEditarLn = "";
            @permission('registroHistoriaClientes.edit')
                    btnEditarLn = '<button type="button" class="btn btn-xs btn-primary btnEditLinea" data-linea=' + anaVeri[i].id + '>' +
                    '<i class="glyphicon glyphicon-pencil"></i> Editar' +
                    '</button>'
            @endpermission
                    var btnEliminarLn = "";
            @permission('registroHistoriaClientes.destroy')
                    btnEliminarLn = '<button type="submit" class="btn btn-danger btn-xs" title="Eliminar" onclick="return confirm(&quot; Eliminar &quot;)">' +
                    '<span class="glyphicon glyphicon-trash" aria-hidden="true"></span>Eliminar' +
                    '</button>';
            @endpermission
                    yenitablosatir += '<tr>' +
                    //kullaniciTomar.Surname      
                    '<td>' + anaVeri[i].id + '</td>' +
                    '<td>' + anaVeri[i].comentario + '</td>' +
                    '<td>' + anaVeri[i].estatus + '</td>' +
                    '<td>' + anaVeri[i].created_at + '</td>' +
                    '<td>' + anaVeri[i].user + '</td>' +
                    '<td>' +
                    '<form method="POST" action="' + '{!! url('check_ls / check_l / ') !!}' + '/' + anaVeri[i].id + '" accept-charset="UTF-8">' +
                    '<input name="_method" value="DELETE" type="hidden">' +
                    '{{ csrf_field() }}' +
                    //btnEditarLn +
                    //btnEliminarLn +
                    '</td>' +
                    '</tr>';
            j++;
            });
            }
            yenitablosatir += '</tbody></table></td></tr>';
            // set next row
            $tablosonrakisatir = $(yenitablosatir).insertAfter($tablosatir);
            $(".btnEditLinea").click(function(){
            //window.location = '{{url("/ln_impactos/edit/")}}'+'/'+$(this).data('linea');
            window.open('{{url("/check_ls/edit/")}}' + '/' + $(this).data('linea'), '_blank');
            });
            }
    });
    
    }



    } // if click mesaj buton!



    if ($btn.attr("lang") === "yorum") {
    //////// yorum butonuna tıklandığında olan olaylar. (if clicked command buton)
    $table.find('.btnVerLineas').trigger('click');
    }

    }); // on click .btnVerLineas end
    });
    </script>
@endpush  
    