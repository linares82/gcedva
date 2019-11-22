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
            <a class="btn btn-success pull-right" href="{{ route('autorizacionBecas.create',array('id'=>$cliente)) }}"><i class="glyphicon glyphicon-plus"></i> Crear</a>
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
        </div>
    </div>

@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            @if($autorizacionBecas->count())
                <table class="table table-condensed table-striped tblEnc">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>PLANTEL</th>
                            <th>SOLICITUD</th>
                        <th>CLIENTE</th>
                        <th>MONTO INSCRIPCION</th>
                        <th>MONTO MENSUALIDAD</th>
                        <th>ESTATUS</th>
                        <th>A. CAJA P.</th>
                        <th>A. DIR. P.</th>
                        <th>A. CAJA C.</th>
                        <th>A. SERV. ESC. C.</th>
                        <th>A. FINAL</th>
                            <th class="text-right">OPCIONES</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($autorizacionBecas as $autorizacionBeca)
                            <tr>
                                <td>{{$autorizacionBeca->id}}</td>
                                <td>{{$autorizacionBeca->cliente->plantel->razon}}</td>
                                <td>{{$autorizacionBeca->solicitud}}</td>
                                <td>{{$autorizacionBeca->cliente->nombre." ".$autorizacionBeca->cliente->nombre2." ".$autorizacionBeca->cliente->ape_paterno." ".$autorizacionBeca->cliente->ape_materno}}</td>
                                <td>{{$autorizacionBeca->monto_inscripcion}}</td>
                                <td>{{$autorizacionBeca->monto_mensualidad}}</td>
                                <td>{{$autorizacionBeca->stBeca->name}}</td>
                                <td>{{ optional($autorizacionBeca->autCajaPlantel)->name }}
                                        @permission('autorizacionBecas.aut_caja_plantel')
                                    <button type="button" class="btn btn-primary btn-xs create_comentario"  
                                            data-toggle="modal" data-autorizacion_beca_id="{{ $autorizacionBeca->id }}"
                                                                data-monto_inscripcion="{{ $autorizacionBeca->monto_inscripcion }}"
                                                                data-monto_mensualidad="{{ $autorizacionBeca->monto_mensualidad }}"
                                                                data-autorizacion="aut_caja_plantel">
                                        Autorizacion
                                    </button>
                                    @endpermission
                                </td>
                                <td>{{ optional($autorizacionBeca->autDirPlantel)->name }}
                                    @if($autorizacionBeca->aut_caja_plantel==4)
                                    @permission('autorizacionBecas.aut_dir_plantel')
                                    <button type="button" class="btn btn-primary btn-xs create_comentario"  
                                            data-toggle="modal" data-autorizacion_beca_id="{{ $autorizacionBeca->id }}"
                                                                data-monto_inscripcion="{{ $autorizacionBeca->monto_inscripcion }}"
                                                                data-monto_mensualidad="{{ $autorizacionBeca->monto_mensualidad }}"
                                                                data-autorizacion="aut_dir_plantel">
                                        Autorizacion
                                    </button>
                                    @endpermission
                                    @endif
                                </td>
                                <td>{{ optional($autorizacionBeca->autCajaCorp)->name }}
                                    @if($autorizacionBeca->aut_caja_plantel==4 and $autorizacionBeca->aut_dir_plantel==4)
                                    @permission('autorizacionBecas.aut_caja_corp')
                                    <button type="button" class="btn btn-primary btn-xs create_comentario"  
                                            data-toggle="modal" data-autorizacion_beca_id="{{ $autorizacionBeca->id }}"
                                                                data-monto_inscripcion="{{ $autorizacionBeca->monto_inscripcion }}"
                                                                data-monto_mensualidad="{{ $autorizacionBeca->monto_mensualidad }}"
                                                                data-autorizacion="aut_caja_corp">
                                        Autorizacion
                                    </button>
                                    @endpermission
                                    @endif
                                </td>
                                <td>{{ optional($autorizacionBeca->autSerEsc)->name }}
                                    @if($autorizacionBeca->aut_caja_plantel==4 and $autorizacionBeca->aut_dir_plantel==4
                                    and $autorizacionBeca->aut_caja_corp==4)
                                    @permission('autorizacionBecas.aut_ser_esc')
                                    <button type="button" class="btn btn-primary btn-xs create_comentario"  
                                            data-toggle="modal" data-autorizacion_beca_id="{{ $autorizacionBeca->id }}"
                                                                data-monto_inscripcion="{{ $autorizacionBeca->monto_inscripcion }}"
                                                                data-monto_mensualidad="{{ $autorizacionBeca->monto_mensualidad }}"
                                                                data-autorizacion="aut_ser_esc">
                                        Autorizacion
                                    </button>
                                    @endpermission
                                    @endif
                                </td>
                                <td>{{ optional($autorizacionBeca->autDueno)->name }}
                                    @if($autorizacionBeca->aut_caja_plantel==4 and $autorizacionBeca->aut_dir_plantel==4
                                    and $autorizacionBeca->aut_caja_corp==4 and $autorizacionBeca->aut_ser_esc==4) 
                                    @permission('autorizacionBecas.aut_dueno')
                                    <button type="button" class="btn btn-primary btn-xs create_comentario"  
                                            data-toggle="modal" data-autorizacion_beca_id="{{ $autorizacionBeca->id }}"
                                                                data-monto_inscripcion="{{ $autorizacionBeca->monto_inscripcion }}"
                                                                data-monto_mensualidad="{{ $autorizacionBeca->monto_mensualidad }}"
                                                                data-autorizacion="aut_dueno">
                                        Autorizacion
                                    </button>
                                    @endpermission
                                    @endif
                                </td>
                                <td class="text-right">
                                    <button class="btn btn-success btnVerLineas pull-right btn-xs" lang="mesaj" data-check="{{$autorizacionBeca->id}}" data-href="formation_json_parents" style="margin-left:10px;" >
                                        <span class="fa fa-eye" aria-hidden="true"></span> Ver comentarios
                                    </button>
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
                                {!! Form::hidden("autorizacion", null, array("class" => "form-control", "id" => "autorizacion-crear")) !!}
                                <input type="hidden" name="_token" id="_token"  value="<?= csrf_token(); ?>"> 
                             </div>
                             <div class="form-group col-sm-12 @if($errors->has('st_beca_id')) has-error @endif">
                                <label for="st_beca_id-field">Estatus</label>
                                {!! Form::select("st_beca_id", $stBecas, null, array("class" => "form-control select_seguridad", "id" => "st_beca_id-crear")) !!}
                                @if($errors->has("st_beca_id"))
                                <span class="help-block">{{ $errors->first("st_beca_id") }}</span>
                                @endif
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
<a class="btn btn-link" href="{{ route('clientes.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar a Clientes</a>
@endsection
@push('scripts')
  <script type="text/javascript">
    $(document).ready(function() {
        
        //Crear comentario
        $(document).on('click', '.create_comentario', function() {
            $('#autorizacion_beca_id-crear').val($(this).data('autorizacion_beca_id'));
            $('#monto_inscripcion-crear').val($(this).data('monto_inscripcion'));
            
            $('#monto_mensualidad-crear').val($(this).data('monto_mensualidad'));
            $('#autorizacion-crear').val($(this).data('autorizacion'));

            $('.modal-title').text('Autorizacion');

            $('#createComentarioModal').modal('show');
        });
       
        //Crear comentario
        $('.modal-footer').on('click', '#comentario-crear', function() {
        var ruta='{{url("autorizacionBecaComentarios/store")}}';
        
        
        //alert(bnd);
        $.ajax({
            type: 'POST',
            url: ruta,
            data: {
                '_token': $('input[name=_token]').val(),
                'autorizacion_beca_id': $('#autorizacion_beca_id-crear').val(),
                'comentario': $('#comentario-crear').val(),
                'monto_inscripcion': $('#monto_inscripcion-crear').val(),
                'monto_mensualidad': $('#monto_mensualidad-crear').val(),
                'st_beca_id': $('#st_beca_id-crear option:selected').val(),
                'autorizacion': $('#autorizacion-crear').val(),
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
    url: "{{route('autorizacionBecaComentarios.findByAutorizacionBecaId')}}",
            dataType: "json",
            data: "check=" + $(this).data('check'),
            success: function (anaVeri) {

            var yenitablosatir = '<tr class="expand-child" id="collapse' + $btn.data('id') + '">' +
                    '<td colspan="12">' +
                    '<table class="table table-condensed altTablo table-hover" width=100% >' +
                    '<thead>' +
                    '<tr>' +
                    '<th>Consecutivo</th>' +
                    '<th>Comentario</th>' +
                    '<th>Monto Inscripción</th>' +
                    '<th>Monto Mensualidad</th>' +
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
            @permission('ln_impactos.ln_impacto.edit')
                    btnEditarLn = '<button type="button" class="btn btn-xs btn-primary btnEditLinea" data-linea=' + anaVeri[i].id + '>' +
                    '<i class="glyphicon glyphicon-pencil"></i> Editar' +
                    '</button>'
            @endpermission
                    var btnEliminarLn = "";
            @permission('ln_impactos.ln_impacto.destroy')
                    btnEliminarLn = '<button type="submit" class="btn btn-danger btn-xs" title="Eliminar" onclick="return confirm(&quot; Eliminar &quot;)">' +
                    '<span class="glyphicon glyphicon-trash" aria-hidden="true"></span>Eliminar' +
                    '</button>';
            @endpermission
                    yenitablosatir += '<tr>' +
                    //kullaniciTomar.Surname      
                    '<td>' + anaVeri[i].id + '</td>' +
                    '<td>' + anaVeri[i].comentario + '</td>' +
                    '<td>' + anaVeri[i].monto_inscripcion + '</td>' +
                    '<td>' + anaVeri[i].monto_mensualidad + '</td>' +
                    '<td>' + anaVeri[i].estatus + '</td>' +
                    '<td>' + anaVeri[i].created_at + '</td>' +
                    '<td>' + anaVeri[i].user + '</td>' +
                    '<td>' +
                    '<form method="POST" action="' + '{!! url('check_ls / check_l / ') !!}' + '/' + anaVeri[i].id + '" accept-charset="UTF-8">' +
                    '<input name="_method" value="DELETE" type="hidden">' +
                    '{{ csrf_field() }}' +
                    btnEditarLn +
                    btnEliminarLn +
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
    