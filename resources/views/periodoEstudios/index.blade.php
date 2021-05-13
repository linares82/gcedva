@extends('plantillas.admin_template')

@include('periodoEstudios._common')

@section('header')

    <ol class="breadcrumb">
    	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
        <!--
        @if ( $query_params = Request::input('q') )

            <li class="active"><a href="{{ route('periodoEstudios.index') }}">@yield('periodoEstudiosAppTitle')</a></li>
            <li class="active">condition(  

            @foreach( $query_params as $key => $value )
                @if (!$loop->first) / @endif {{ $key }} : {{ $value }}
            @endforeach
            )</li>
        @else
            <li class="active">@yield('periodoEstudiosAppTitle')</li>
        @endif
        -->
        <li class="active">@yield('periodoEstudiosAppTitle')</li>
    </ol>

    <div class="">
        <h3>
            <i class="glyphicon glyphicon-align-justify"></i> @yield('periodoEstudiosAppTitle')
            @permission('periodoEstudios.create')
            <a class="btn btn-success pull-right" href="{{ route('periodoEstudios.create') }}"><i class="glyphicon glyphicon-plus"></i> Crear</a>
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
                    <form class="PeriodoEstudio_search" id="search" action="{{ route('periodoEstudios.index') }}" accept-charset="UTF-8" method="get">
                        <input type="hidden" name="q[s]" value="{{ @(Request::input('q')['s']) ?: '' }}" />
                        <div class="contenido_frm">

                            <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_name_gt">NAME</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm", type="search" value="{{ @(Request::input('q')['name_gt']) ?: '' }}" name="q[name_gt]" id="q_name_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm", type="search" value="{{ @(Request::input('q')['name_lt']) ?: '' }}" name="q[name_lt]" id="q_name_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group plantel col-md-4" >
                                <label for="q_periodo_estudios.plantel_id_lt">PLANTEL</label>
                                    {!! Form::select("periodo_estudios.plantel_id", $list["Plantel"], "{{ @(Request::input('q')['clientes.plantel_id_lt']) ?: '' }}", array("class" => "form-control select_seguridad", "name"=>"q[periodo_estudios.plantel_id_lt]", "id"=>"q_periodo_estudios.plantel_id_lt", "style"=>"width:100%;", "onchange"=>"cambioOpcion()")) !!}
                                    <div id='loading10' style='display: none'><img src="{{ asset('images/ajax-loader.gif') }}" title="Enviando" /></div> 
                            </div>
                            
                            <div class="form-group especialidad col-md-4" >
                                <label for="q_periodo_estudios.especialidad_id_lt">ESPECIALIDAD</label> 
                                    {!! Form::select("periodo_estudios.especialidad_id", $list["Especialidad"], "{{ @(Request::input('q')['periodo_estudios.especialidad_id_lt']) ?: '' }}", array("class" => "form-control select_seguridad", "name"=>"q[periodo_estudios.especialidad_id_lt]", "id"=>"q_periodo_estudios.especialidad_id_lt", "style"=>"width:100%;")) !!}
                            </div>
                            <div class="form-group nivel col-md-4" >
                                <label for="q_periodo_estudios.nivel_id_lt">NIVEL</label> 
                                    {!! Form::select("periodo_estudios.nivel_id", $list["Nivel"], "{{ @(Request::input('q')['periodo_estudios.nivel_id_lt']) ?: '' }}", array("class" => "form-control select_seguridad", "name"=>"q[periodo_estudios.nivel_id_lt]", "id"=>"q_periodo_estudios.nivel_id_lt", "style"=>"width:100%;")) !!}
                            </div>
                            <div class="form-group grado col-md-4" >
                                <label for="q_periodo_estudios.grado_id_lt">GRADO</label> 
                                    {!! Form::select("periodo_estudios.grado_id", $list["Especialidad"], "{{ @(Request::input('q')['periodo_estudios.grado_id_lt']) ?: '' }}", array("class" => "form-control select_seguridad", "name"=>"q[periodo_estudios.grado_id_lt]", "id"=>"q_periodo_estudios.grado_id_lt", "style"=>"width:100%;")) !!}
                            </div>
                            <div class="form-group col-md-4">
                                <label for="q_periodo_estudios.plan_estudio_id_lt">Plan Estudios</label>
                                    {!! Form::select("plan_estudio_id", $list["PlanEstudio"], "{{ @(Request::input('q')['periodo_estudios.plan_estudio_id_lt']) ?: '' }}", array("class" => "form-control select_seguridad", "name"=>"q[periodo_estudios.plan_estudio_id_lt]", "id"=>"q_periodo_estudios.plan_estudio_id_id_lt", "style"=>"width:100%;" )) !!}
                            </div>
                            <div class="form-group col-md-4">
                                <label class="col-sm-2 control-label" for="q_name_cont">PERIODO</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm", type="search" value="{{ @(Request::input('q')['name_cont']) ?: '' }}" name="q[name_cont]" id="q_name_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_grados.name_gt">GRADO_NAME</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm", type="search" value="{{ @(Request::input('q')['grados.name_gt']) ?: '' }}" name="q[grados.name_gt]" id="q_grados.name_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm", type="search" value="{{ @(Request::input('q')['grados.name_lt']) ?: '' }}" name="q[grados.name_lt]" id="q_grados.name_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group col-md-4">
                                <label class="col-sm-2 control-label" for="q_grados.name_cont">GRADO</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm", type="search" value="{{ @(Request::input('q')['grados.name_cont']) ?: '' }}" name="q[grados.name_cont]" id="q_grados.name_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_usu_alta_id_gt">USU_ALTA_ID</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm", type="search" value="{{ @(Request::input('q')['usu_alta_id_gt']) ?: '' }}" name="q[usu_alta_id_gt]" id="q_usu_alta_id_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm", type="search" value="{{ @(Request::input('q')['usu_alta_id_lt']) ?: '' }}" name="q[usu_alta_id_lt]" id="q_usu_alta_id_lt" />
                                </div>
                            </div>
                            -->
                            
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
            @if($periodoEstudios->count())
                <table class="table table-condensed table-striped">
                    <thead>
                        <tr>
                            <th>@include('plantillas.getOrderLink', ['column' => 'id', 'title' => 'ID'])</th>
                            <th>@include('plantillas.getOrderlink', ['column' => 'plantel_id', 'title' => 'PLANTEL'])</th>
                            <th>@include('plantillas.getOrderlink', ['column' => 'especialidad_id', 'title' => 'ESPECIALIDAD'])</th>
                            <th>@include('plantillas.getOrderlink', ['column' => 'nivel_id', 'title' => 'NIVEL'])</th>
                            <th>@include('plantillas.getOrderlink', ['column' => 'grado_id', 'title' => 'GRADO'])</th>
                            <th>@include('plantillas.getOrderlink', ['column' => 'name', 'title' => 'PERIODO'])</th>
                            <th>Periodo Estudio</th>
                            <th>Orden</th>
                            <th class="text-right">OPCIONES</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($periodoEstudios as $periodoEstudio)
                            <tr>
                                <td><a href="{{ route('periodoEstudios.show', $periodoEstudio->id) }}">{{$periodoEstudio->id}}</a></td>
                                <td>{{$periodoEstudio->plantel->razon}}</td>
                                <td>{{$periodoEstudio->especialidad->name}}</td>
                                <td>{{$periodoEstudio->nivel->name}}</td>
                                <td>{{$periodoEstudio->grado->name}}</td>
                                <td>{{$periodoEstudio->name}}</td>
                                <td>{{optional($periodoEstudio->planEstudio)->name}}</td>
                                <td>{{$periodoEstudio->orden}}</td>
                                <td class="text-right">
                                    @permission('periodoEstudios.edit')
                                    <a class="btn btn-xs btn-primary" href="{{ route('periodoEstudios.duplicate', $periodoEstudio->id) }}"><i class="glyphicon glyphicon-duplicate"></i> Duplicar</a>
                                    @endpermission
                                    @permission('periodoEstudios.edit')
                                    <a class="btn btn-xs btn-warning" href="{{ route('periodoEstudios.edit', $periodoEstudio->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                                    @endpermission
                                    @permission('periodoEstudios.destroy')
                                    {!! Form::model($periodoEstudio, array('route' => array('periodoEstudios.destroy', $periodoEstudio->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? ¿Esta seguro?')) { return true } else {return false };")) !!}
                                        <button type="submit" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i> Borrar</button>
                                    {!! Form::close() !!}
                                    @endpermission
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {!! $periodoEstudios->appends(Request::except('page'))->render() !!}
            @else
                <h3 class="text-center alert alert-info">Vacio!</h3>
            @endif

        </div>
    </div>

@endsection

@push('scripts')
<script type="text/javascript">
    function cambioOpcion(){
        //getCmbEspecialidad();
    }

    $("select").change(function(){
        if($(this).attr("id")=="q_periodo_estudios.plantel_id_lt"){
            getCmbEspecialidad($(this));
        }
        if($(this).attr("id")=="q_periodo_estudios.especialidad_id_lt"){
            getCmbNivel($(this));
        }

        if($(this).attr("id")=="q_periodo_estudios.nivel_id_lt"){
            getCmbGrado($(this));
        }
    });
    
    
    function removeOptions(selectbox)
        {
            var i;
            for(i = selectbox.options.length - 1 ; i >= 0 ; i--)
            {
                selectbox.remove(i);
            }
        }

    function getCmbEspecialidad(obj){
        //esp=obj.closest('.contenido_frm').children('.especialidad').children('#q_periodo_estudios.especialidad_id_lt');
        //console.log(esp);
        var plantel=document.getElementById('q_periodo_estudios.plantel_id_lt');
        var especialidad=document.getElementById('q_periodo_estudios.especialidad_id_lt');
        
        $.ajax({
        url: '{{ route("especialidads.getCmbEspecialidad") }}',
                type: 'GET',
                data: "plantel_id=" + plantel.options[plantel.selectedIndex].value + "&especialidad_id=" + especialidad.options[especialidad.selectedIndex].value + "",
                dataType: 'json',
                beforeSend : function(){$("#loading10").show(); },
                complete : function(){$("#loading10").hide(); },
                success: function(data){
                    removeOptions(document.getElementById("q_periodo_estudios.especialidad_id_lt"));
                    
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
        var plantel=document.getElementById('q_periodo_estudios.plantel_id_lt');
        var especialidad=document.getElementById('q_periodo_estudios.especialidad_id_lt');
        var nivel=document.getElementById('q_periodo_estudios.nivel_id_lt');
              $.ajax({
                  url: '{{ route("nivels.getCmbNivels") }}',
                  type: 'GET',
                  data: "plantel_id=" + plantel.options[plantel.selectedIndex].value + 
                  "&especialidad_id=" + especialidad.options[especialidad.selectedIndex].value + 
                  "&nivel_id=" + nivel.options[nivel.selectedIndex].value + "",
                  dataType: 'json',
                  beforeSend : function(){$("#loading11").show();},
                  complete : function(){$("#loading11").hide();},
                  success: function(data){
                    removeOptions(document.getElementById("q_periodo_estudios.nivel_id_lt"));
                      
                    $.each(data, function(i) {
                //$('#q_clientes.especialidad_id_lt-field').append("<option " + data[i].selectec + " value=\"" + data[i].id + "\">" + data[i].name + "<\/option>");
                    var opt = document.createElement('option');
                    opt.value = data[i].id;
                    opt.innerHTML = data[i].name;
                    nivel.appendChild(opt);
                });
                  }
              });       
      }

      function getCmbGrado(){
        var plantel=document.getElementById('q_periodo_estudios.plantel_id_lt');
        var especialidad=document.getElementById('q_periodo_estudios.especialidad_id_lt');
        var nivel=document.getElementById('q_periodo_estudios.nivel_id_lt');
        var grado=document.getElementById('q_periodo_estudios.grado_id_lt');
              $.ajax({
                  url: '{{ route("grados.getCmbGrados") }}',
                  type: 'GET',
                  data: "plantel_id=" + plantel.options[plantel.selectedIndex].value + 
                  "&especialidad_id=" + especialidad.options[especialidad.selectedIndex].value + 
                  "&nivel_id=" + nivel.options[nivel.selectedIndex].value + 
                  "&grado_id=" + grado.options[grado.selectedIndex].value +"",
                  dataType: 'json',
                  beforeSend : function(){$("#loading12").show();},
                  complete : function(){$("#loading12").hide();},
                  success: function(data){
                    removeOptions(document.getElementById("q_periodo_estudios.grado_id_lt"));
                      
                      $.each(data, function(i) {
                  //$('#q_clientes.especialidad_id_lt-field').append("<option " + data[i].selectec + " value=\"" + data[i].id + "\">" + data[i].name + "<\/option>");
                      var opt = document.createElement('option');
                      opt.value = data[i].id;
                      opt.innerHTML = data[i].name;
                      grado.appendChild(opt);
                  });
                  }
              });       
      }

</script>
@endpush