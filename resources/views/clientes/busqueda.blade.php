@extends('plantillas.admin_template')

@include('clientes._common')

@section('header')

    <ol class="breadcrumb">
    	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
        <!--
        @if ( $query_params = Request::input('q') )

            <li class="active"><a href="{{ route('clientes.index') }}">@yield('clientesAppTitle')</a></li>
            <li class="active">condition(  

            @foreach( $query_params as $key => $value )
                @if (!$loop->first) / @endif {{ $key }} : {{ $value }}
            @endforeach
            )</li>
        @else
            <li class="active">@yield('clientesAppTitle')</li>
        @endif
        -->
        <li class="active">@yield('clientesAppTitle')</li>
    </ol>

    <div class="">
        <h3>
            <i class="glyphicon glyphicon-align-justify"></i> @yield('clientesAppTitle')
            
            
        </h3>

    </div>

    <div >
        <div class="panel panel-default">
            <div id="headingOne" role="tab" class="panel-heading">
                <h4 class="panel-title">
                <a aria-controls="collapseOne" aria-expanded="true" href="#collapseOne" data-parent="#accordion" data-toggle="collapse" role="button">
                    <span aria-hidden="true" class="glyphicon glyphicon-search"></span> Buscar
                </a>
                </h4>
            </div>
            <div aria-labelledby="headingOne" role="tabpanel" class="" id="collapseOne">
                <div class="panel-body">
                    <form class="Cliente_search" action="{{ route('clientes.busqueda') }}" accept-charset="UTF-8" method="get">
                        
                        <div class="row">
                            <div class="col-md-12">

                            <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_cve_cliente_gt">CVE_CLIENTE</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm", type="search" value="{{ @(Request::input('q')['cve_cliente_gt']) ?: '' }}" name="q[cve_cliente_gt]" id="q_cve_cliente_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm", type="search" value="{{ @(Request::input('q')['cve_cliente_lt']) ?: '' }}" name="q[cve_cliente_lt]" id="q_cve_cliente_lt" />
                                </div>
                            </div>
                            -->
                            
                    

                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_nombre_gt">NOMBRE</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm", type="search" value="{{ @(Request::input('q')['nombre_gt']) ?: '' }}" name="q[nombre_gt]" id="q_nombre_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm", type="search" value="{{ @(Request::input('q')['nombre_lt']) ?: '' }}" name="q[nombre_lt]" id="q_nombre_lt" />
                                </div>
                            </div>
                            -->
                            
                            
                            <div class="form-group col-md-4">
                                <label for="q_clientes.nombre_cont">PRIMER NOMBRE</label>
                                
                                    <input class="form-control input-sm", value="{{ @(Request::input('nombre')) ?: '' }}" name="nombre" id="nombre" />
                                
                            </div>
                            <div class="form-group col-md-4">
                                <label for="q_clientes.nombre2_cont">SEGUNDO NOMBRE</label>
                                
                                    <input class="form-control input-sm",  value="{{ @(Request::input('nombre2')) ?: '' }}" name="nombre2" id="nombre2" />
                                
                            </div>
                            <div class="form-group col-md-4">
                                <label for="q_clientes.ape_paterno_cont">APELLIDO PATERNO</label>
                                
                                    <input class="form-control input-sm", value="{{ @(Request::input('ape_paterno')) ?: '' }}" name="ape_paterno" id="ape_paterno" />
                                
                            </div>
                            <div class="form-group col-md-4">
                                <label for="q_clientes.ape_materno_cont">APELLIDO MATERNO</label>
                                
                                    <input class="form-control input-sm", value="{{ @(Request::input('ape_materno')) ?: '' }}" name="ape_materno" id="ape_materno" />
                                
                            </div>
                            <div class="form-group col-md-4">
                                <label for="q_clientes.tel_fijo_cont">Telefono Fijo</label>
                                
                                    <input class="form-control input-sm", value="{{ @(Request::input('tel_fijo')) ?: '' }}" name="tel_fijo" id="tel_fijo" />
                                
                            </div>
                            <div class="form-group col-md-4">
                                <label for="q_clientes.mail_cont">E-mail</label>
                                
                                    <input class="form-control input-sm", value="{{ @(Request::input('mail')) ?: '' }}" name="mail" id="mail" />
                                
                            </div>
                            <div class="form-group col-md-4">
                                <label for="q_clientes.curp_cont">CURP</label>
                                
                                    <input class="form-control input-sm", value="{{ @(Request::input('curp')) ?: '' }}" name="curp" id="curp" />
                                
                            </div>
                            <div class="form-group col-md-4">
                                <label for="q_clientes.calle_cont">CALLE</label>
                                
                                    <input class="form-control input-sm", value="{{ @(Request::input('calle')) ?: '' }}" name="calle" id="calle" />
                                
                            </div>
                            <!--<div class="form-group col-md-4">
                                <label for="q_clientes.matricula_cont">MATRICULA</label>
                                    <input class="form-control input-sm", type="search" value="{{ @(Request::input('q')['clientes.matricula_cont']) ?: '' }}" name="q[clientes.matricula_cont]" id="q_clientes.matricula_cont" />
                            </div>-->
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_fec_registro_gt">FEC_REGISTRO</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm", type="search" value="{{ @(Request::input('q')['fec_registro_gt']) ?: '' }}" name="q[fec_registro_gt]" id="q_fec_registro_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm", type="search" value="{{ @(Request::input('q')['fec_registro_lt']) ?: '' }}" name="q[fec_registro_lt]" id="q_fec_registro_lt" />
                                </div>
                            </div>
                            -->
                            
                            
                            <div class="form-group" id='ultimo'>
                                <div class="col-sm-10 col-sm-offset-2">
                                    <input type="submit" name="commit" value="Buscar" class="btn btn-default btn-sm" />
                                </div>
                            </div>
                        </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div>
        @if(session('message'))
            <div class="alert alert-danger">
                {!! session('message') !!}
            </div>
        @endif
        
    </div>
@endsection

@section('content')
    <div class="row">@permission('clientes.create')
            @if(!is_null($clientes))
            <a class="btn btn-success pull-right" href="{{ route('clientes.create') }}"><i class="glyphicon glyphicon-plus"></i> Crear</a>
            @endif
            @endpermission
            </div>
    <div class="row">
        <div class="col-md-12">
            @if(!is_null($clientes) and $clientes->count())
                <table class="table table-condensed table-striped tblEnc">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>PRIMER NOMBRE</th>
                            <th>SEGUNDO NOMBRE</th>
                            <th>APELLIDO PATERNO</th>
                            <th>APELLIDO MATERNO</th>
                            <th>TEL.</th>
                            <th>MAIL</th>
                            <th>CURP</th>
                            <th>CALLE</th>
                            <th>PLANTEL</th>
                            <th>EMPLEADO</th>
                            
                            
                            <th class="text-right">OPCIONES</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($clientes as $cliente)
                            <tr>
                                <td><a href="{{ route('clientes.edit', $cliente->id) }}">{{$cliente->id}}</a></td>
                                <td>{{$cliente->nombre}}</td>
                                <td>{{$cliente->nombre2}}</td>
                                <td>{{$cliente->ape_paterno}}</td>
                                <td>{{$cliente->ape_materno}}</td>
                                <td>{{$cliente->tel_cel}}</td>
                                <td>{{$cliente->mail}}</td>
                                <td>
                                {{$cliente->curp}}
                                
                                </td>
                                <td>{{$cliente->calle}} {{$cliente->no}} {{$cliente->colonia}}</td>
                                <td>{{$cliente->plantel->razon}}</td>
                                <td>{{$cliente->empleado->nombre}} {{$cliente->empleado->ape_paterno}} {{$cliente->empleado->ape_materno}}</td>
                                <td class="text-right">
                                    
                                    @permission('clientes.edit')
                                    <a class="btn btn-xs btn-warning" href="{{ route('clientes.edit', $cliente->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                                    @endpermission
                                    
                                    
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {!! $clientes->appends(Request::except('page'))->render() !!}
                
            @else
                <h3 class="text-center alert alert-info">Vacio!</h3>
            @endif

        </div>
    </div>

@endsection

@push('scripts')
<script src="{{ asset ('/bower_components/AdminLTE/plugins/input-mask/jquery.inputmask.js') }}"></script>
<script src="{{ asset ('/bower_components/AdminLTE/plugins/input-mask/jquery.inputmask.extensions.js') }}"></script>
<script src="{{ asset ('/bower_components/AdminLTE/plugins/input-mask/jquery.inputmask.phone.extensions.js') }}"></script>
  <script>
  
 
        // assuming the controls you want to attach the plugin to
          // have the "datepicker" class set
          //Campo de fecha
          
          /*$('#search').children().last().children().children('.fec').children('input').Zebra_DatePicker({
          //$('#q_fec_registro_mayorq').Zebra_DatePicker({
            days:['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'],
            months:['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
            readonly_element: false,
            lang_clear_date: 'Limpiar',
            show_select_today: 'Hoy',
          });  
       */
      $('#search').children().last().children().children('.fec').children('input').inputmask({ mask: "9999-99-99 99:99:99"}); //specifying options
      
        function cambioOpcion(){
            getCmbEspecialidad();
        }
       
        function removeOptions(selectbox)
        {
            var i;
            for(i = selectbox.options.length - 1 ; i >= 0 ; i--)
            {
                selectbox.remove(i);
            }
        }
        
        function getCmbEspecialidad(){
                var plantel=document.getElementById('q_clientes.plantel_id_lt');
                var especialidad=document.getElementById('q_clientes.especialidad_id_lt');
                
                $.ajax({
                url: '{{ route("especialidads.getCmbEspecialidad") }}',
                        type: 'GET',
                        data: "plantel_id=" + plantel.options[plantel.selectedIndex].value + "&especialidad_id=" + especialidad.options[especialidad.selectedIndex].value + "",
                        dataType: 'json',
                        beforeSend : function(){$("#loading10").show(); },
                        complete : function(){$("#loading10").hide(); },
                        success: function(data){
                        removeOptions(document.getElementById("q_clientes.especialidad_id_lt"));
                        $.each(data, function(i) {
                        //$('#q_clientes.especialidad_id_lt-field').append("<option " + data[i].selectec + " value=\"" + data[i].id + "\">" + data[i].name + "<\/option>");
                            var opt = document.createElement('option');
                            opt.value = data[i].id;
                            opt.innerHTML = data[i].name;
                            especialidad.appendChild(opt);
                        });
                        
                        }
                });
                }
/*
    $(document).ready(function() {
        var $table = $('.tblEnc');
        $table.find('.btnVerLineas').on('click', function(e) {
            //console.log("hola");
    // click button

        //e.preventDefault();
        var $btn = $(e.target), $tablosatir = $btn.closest('tr'), $tablosonrakisatir = $tablosatir.next('tr.expand-child');
        if ($btn.attr("lang") === "mesaj") {
    ///////////// mesajlar butonuna tıklandığında olan olaylar.

        if ($tablosonrakisatir.css("display") === 'none') {
        // if panel close !
        $tablosonrakisatir.slideDown(100);
        //console.log("abre");
        } else {
        // if panel open !
        //console.log("cierra");
        $tablosonrakisatir.slideUp(100);
        }

        //$("#kullanicihebir").html($tablosatir.find("tr").length);	


        if ($tablosonrakisatir.length) {
        // sonraki satır yok ise 	



        } else
        {

        // sonraki satır var ise	
        $.ajax({
        url: "{{route('autorizacionBecas.findByCliente')}}",
                dataType: "json",
                type: 'get',
                data: "check=" + $(this).data('check'),
                success: function (anaVeri) {

                var yenitablosatir = '<tr class="expand-child" id="collapse' + $btn.data('id') + '">' +
                        '<td colspan="12">' +
                        '<table class="table table-condensed altTablo table-hover" width=100% >' +
                        '<thead>' +
                        '<tr>' +
                        '<th>Id</th>' +
                        '<th>Solicitud</th>' +
                        '<th>Monto Inscripcion</th>' +
                        '<th>Monto Mensualidad</th>' +
                        '<th>Estatus</th>' +
                        '<th>Creada</th>' +
                        '<th>Comentarios</th>' +
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
                        '<td>' + anaVeri[i].solicitud + '</td>' +
                        '<td>' + anaVeri[i].monto_inscripcion + '</td>' +
                        '<td>' + anaVeri[i].monto_mensualidad + '</td>' +
                        '<td>' + anaVeri[i].estatus + '</td>' +
                        '<td>' + anaVeri[i].created_at + '</td>' +
                        '<td>' +  + '</td>' +
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
*/
  </script>
@endpush