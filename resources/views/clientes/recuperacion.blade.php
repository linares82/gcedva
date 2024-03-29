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
            <a class="btn btn-success" href="{{ route('clientesa.index', array('p'=>1)) }}"><i class="glyphicon glyphicon-plus"></i> Inscritos</a>
            <a class="btn btn-warning" href="{{ route('clientesa.index') }}"><i class="glyphicon glyphicon-plus"></i> Clientes</a>
            @permission('clientes.create')
            
            <a class="btn btn-success pull-right" href="{{ route('clientes.busqueda') }}"><i class="glyphicon glyphicon-plus"></i> Crear</a>
            
            @endpermission
            @permission('clientes.carga')
            <a class="btn btn-warning pull-right" href="{{ route('clientes.carga') }}"><i class="glyphicon glyphicon-plus"></i> Carga Archivo</a>
            <a class="btn btn-primary pull-right" href="{{ route('clientes.descargaClientes') }}"><i class="fa fa-long-arrow-down"></i> Descarga</a>
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
                    <form class="Cliente_search" id="search" action="{{ route('clientes.recuperacion') }}" accept-charset="UTF-8" method="get">
                        <input type="hidden" name="q[s]" value="{{ @(Request::input('q')['s']) ?: '' }}" />
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
                                <label for="q_clientes.id_cont">ID</label>
                                    <input class="form-control input-sm", type="search" value="{{ @(Request::input('q')['clientes.id_lt']) ?: '' }}" name="q[clientes.id_lt]" id="q_clientes.id_lt" />
                            </div>
                            
                            <div class="form-group col-md-4">
                                <label for="q_clientes.nombre_cont">PRIMER NOMBRE</label>
                                
                                    <input class="form-control input-sm", type="search" value="{{ @(Request::input('q')['clientes.nombre_cont']) ?: '' }}" name="q[clientes.nombre_cont]" id="q_clientes.nombre_cont" />
                                
                            </div>
                            <div class="form-group col-md-4">
                                <label for="q_clientes.nombre2_cont">SEGUNDO NOMBRE</label>
                                
                                    <input class="form-control input-sm", type="search" value="{{ @(Request::input('q')['clientes.nombre2_cont']) ?: '' }}" name="q[clientes.nombre2_cont]" id="q_clientes.nombre2_cont" />
                                
                            </div>
                            <div class="form-group col-md-4">
                                <label for="q_clientes.ape_paterno_cont">APELLIDO PATERNO</label>
                                
                                    <input class="form-control input-sm", type="search" value="{{ @(Request::input('q')['clientes.ape_paterno_cont']) ?: '' }}" name="q[clientes.ape_paterno_cont]" id="q_clientes.ape_paterno_cont" />
                                
                            </div>
                            <div class="form-group col-md-4">
                                <label for="q_clientes.ape_materno_cont">APELLIDO MATERNO</label>
                                
                                    <input class="form-control input-sm", type="search" value="{{ @(Request::input('q')['clientes.ape_materno_cont']) ?: '' }}" name="q[clientes.ape_materno_cont]" id="q_clientes.ape_materno_cont" />
                                
                            </div>
                            
                            <div class="form-group col-md-4" style="clear:left;">
                                <label for="q_clientes.st_cliente_id_lt">ESTATUS</label>
                                    {!! Form::select("st_cliente_id", $list1["StCliente"], "{{ @(Request::input('q')['clientes.st_cliente_id_lt']) ?: '' }}", array("class" => "form-control select_seguridad", "name"=>"q[clientes.st_cliente_id_lt]", "id"=>"q_clientes.st_cliente_id_lt", "style"=>"width:100%;" )) !!}
                            </div>
                        
                            
                            
                            <div class="form-group col-md-4" >
                                <label for="q_clientes.plantel_id_lt">PLANTEL</label>
                                
                                    {!! Form::select("clientes.plantel_id", $list1["Plantel"], "{{ @(Request::input('q')['clientes.plantel_id_lt']) ?: '' }}", array("class" => "form-control select_seguridad", "name"=>"q[clientes.plantel_id_lt]", "id"=>"q_clientes.plantel_id_lt", "style"=>"width:100%;", "onchange"=>"cambioOpcion()")) !!}
                                    <div id='loading10' style='display: none'><img src="{{ asset('images/ajax-loader.gif') }}" title="Enviando" /></div> 
                            </div>
                            
                            
                            <div class="form-group col-md-4 fec @if($errors->has('updated_at_mayorq')) has-error @endif">
                            <label for="updated_at-field">Fecha U. Modificación (AAAA-MM-DD)</label>
                            <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['clientes.updated_at_mayorq']) ?: '' }}" name="q[clientes_updated_at_mayorq]" id="q_clientes.updated_at_mayorq" />
                            </div>
                            
                            <div class="form-group" id='ultimo'>
                                <div class="col-sm-10 col-sm-offset-2">
                                    <input type="submit" name="commit" value="Buscar" class="btn btn-default btn-xs" />
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
    <div class="row">
        <div class="col-md-12">
            @if($clientes->count())
                <table class="table table-condensed table-striped tblEnc">
                    <thead>
                        <tr>
                            <th>@include('plantillas.getOrderLink', ['column' => 'cliente_id', 'title' => 'ID'])</th>
                            <th>@include('plantillas.getOrderLink', ['column' => 'clientes.nombre', 'title' => 'PRIMER NOMBRE'])</th>
                            <th>@include('plantillas.getOrderLink', ['column' => 'clientes.nombre2', 'title' => 'SEGUNDO NOMBRE'])</th>
                            <th>@include('plantillas.getOrderLink', ['column' => 'clientes.ape_paterno', 'title' => 'APELLIDO PATERNO'])</th>
                            <th>@include('plantillas.getOrderLink', ['column' => 'clientes.ape_materno', 'title' => 'APELLIDO MATERNO'])</th>
                            <th>@include('plantillas.getOrderLink', ['column' => 'st_seguimiento_id', 'title' => 'ESTATUS SEGUIMIENTO'])</th>
                            <th>@include('plantillas.getOrderLink', ['column' => 'clientes.st_cliente_id', 'title' => 'ESTATUS CLIENTE'])</th>
                            <th>@include('plantillas.getOrderLink', ['column' => 'clientes.plantel_id', 'title' => 'PLANTEL'])</th>
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
                                <td>
                                
                                <span class="label" style="background:{{$cliente->seguimiento->stSeguimiento->color}};">
                                    {{$cliente->seguimiento->stSeguimiento->name}}
                                </span>
                                </td>
                                <td>{{$cliente->stCliente->name}}</td>
                                <td>
                                @if(isset($cliente->plantel))
                                {{$cliente->plantel->razon}}
                                @endif
                                </td>
                                
                                <td>
                                @if(isset($cliente->especialidad))
                                {{$cliente->especialidad->name}}
                                @endif
                                </td>
                                
                                <td class="text-right">
                                    <a class="btn btn-xs bg-maroon" href="{{ route('clientes.formatoInscripcion', array('cliente_id'=>$cliente->id)) }}">
                                        <i class="fa fa-print"></i> F. Insc.
                                    </a>
                                       
                                    @permission('correos.redactar')
                                    @if(isset($cliente->mail))
                                    <a class="btn btn-xs btn-success" href="{{ url('correos/redactar').'/'.$cliente->mail.'/'.$cliente->nombre.'/0' }}"><i class="glyphicon glyphicon-envelope"></i> Correo </a>
                                    @endif
                                    @endpermission
                                    @permission('seguimientos.show')
                                    <a class="btn btn-xs btn-default" href="{{ route('seguimientos.show', $cliente->id) }}"><i class="glyphicon glyphicon-edit"></i> Seguimiento</a>
                                    @endpermission
                                    
                                    @php
                                    $planteles = array();
                				    array_push($planteles, intval(0));
                                    foreach ($empleado->plantels as $plantel) {
                                        array_push($planteles, intval($plantel->id));
                                    }
                                    @endphp

                                    @if(array_search(intval($cliente->plantel_id),$planteles)<>false)
                                    @permission('clientes.edit')
                                    <a class="btn btn-xs btn-warning" href="{{ route('clientes.edit', $cliente->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                                    @endpermission
                                    @endif
                                    
                                    @permission('clientes.destroy')
                                    {!! Form::model($cliente, array('route' => array('clientes.destroy', $cliente->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? ¿Esta seguro?')) { return true } else {return false };")) !!}
                                        <button type="submit" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i> Borrar</button>
                                    {!! Form::close() !!}
                                    @endpermission
                                    @permission('cajas.buscarVenta')
                                    @php
                                        $combinacion=App\CombinacionCliente::where('cliente_id',$cliente->id)->whereNull('deleted_at')->get();
                                        //dd($combinacion->count());
                                        $adeudos=App\Adeudo::where('cliente_id',$cliente->id)->whereNull('deleted_at')->get();
                                        //dd($adeudos->count());
                                    @endphp
                                    @if($adeudos->count()>0 and $combinacion->count()>0)
                                    {!! Form::model($cliente, array('route' => array('cajas.buscarCliente'),'method' => 'post', 'style' => 'display: inline;')) !!}
                                        {!! Form::hidden("cliente_id", null, array("class" => "form-control input-sm", "id" => "cliente_id-field")) !!}
                                        <button type="submit" class="btn btn-xs btn-info"><i class="glyphicon glyphicon-trash"></i> Caja</button>
                                    {!! Form::close() !!}
                                    @endif
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
      $('#search').children().last().children().children('.fec').children('input').inputmask({ mask: "9999-99-99"}); //specifying options
      
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

        function getCmbNivel(){
            var plantel=document.getElementById('q_clientes.plantel_id_lt');
            var especialidad=document.getElementById('q_clientes.especialidad_id_lt');
            var nivel=document.getElementById('q_clientes.nivel_id_lt');
            var a = $('#frm_cliente').serialize();
            $.ajax({
            url: '{{ route("nivels.getCmbNivels") }}',
                    type: 'GET',
                    data: {
                        'plantel_id':plantel.options[plantel.selectedIndex].value,
                        'especialidad_id':especialidad.options[especialidad.selectedIndex].value,
                        //'nivel_id':nivel.options[nivel.selectedIndex].value.success,
                    },
                    dataType: 'json',
                    beforeSend : function(){$("#loading10").show(); },
                    complete : function(){$("#loading10").hide(); },
                    success: function(data){
                        removeOptions(document.getElementById("q_clientes.nivel_id_lt"));
                        var opt = document.createElement('option');
                            opt.value = 0;
                            opt.innerHTML = 'Seleccionar';
                            nivel.appendChild(opt);
                        $.each(data, function(i) {
                            var opt = document.createElement('option');
                            opt.value = data[i].id;
                            opt.innerHTML = data[i].name;
                            nivel.appendChild(opt);
                        });
                    }
            });
        }

        function getCmbGrado(){
            var plantel=document.getElementById('q_clientes.plantel_id_lt');
            var especialidad=document.getElementById('q_clientes.especialidad_id_lt');
            var nivel=document.getElementById('q_clientes.nivel_id_lt');
            var grado=document.getElementById('q_clientes.grado_id_lt');
            var a = $('#frm_cliente').serialize();
            $.ajax({
            url: '{{ route("grados.getCmbGrados") }}',
                type: 'GET',
                data: {
                        'plantel_id':plantel.options[plantel.selectedIndex].value,
                        'especialidad_id':especialidad.options[especialidad.selectedIndex].value,
                        'nivel_id':nivel.options[nivel.selectedIndex].value,
                        'grado_id':grado.options[grado.selectedIndex].value,
                    },
                dataType: 'json',
                beforeSend : function(){$("#loading10").show(); },
                complete : function(){$("#loading10").hide(); },
                success: function(data){
                    removeOptions(document.getElementById("q_clientes.grado_id_lt"));
                    var opt = document.createElement('option');
                            opt.value = 0;
                            opt.innerHTML = 'Seleccionar';
                            grado.appendChild(opt);
                        $.each(data, function(i) {
                            var opt = document.createElement('option');
                            opt.value = data[i].id;
                            opt.innerHTML = data[i].name;
                            grado.appendChild(opt);
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