@extends('plantillas.admin_template')

@include('cotizacionCursos._common')

@section('header')

    <ol class="breadcrumb">
    	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
        <!--
        @if ( $query_params = Request::input('q') )

            <li class="active"><a href="{{ route('cotizacionCursos.index') }}">@yield('cotizacionCursosAppTitle')</a></li>
            <li class="active">condition(  

            @foreach( $query_params as $key => $value )
                @if (!$loop->first) / @endif {{ $key }} : {{ $value }}
            @endforeach
            )</li>
        @else
            <li class="active">@yield('cotizacionCursosAppTitle')</li>
        @endif
        -->
        <li class="active">@yield('cotizacionCursosAppTitle')</li>
    </ol>

    <div class="">
        <h3>
            <i class="glyphicon glyphicon-align-justify"></i> @yield('cotizacionCursosAppTitle')
            @permission('cotizacionCursos.create')
            
            <a class="btn btn-success pull-right" href="{{ route('cotizacionCursos.create', ['empresa'=>$empresa]) }}"><i class="glyphicon glyphicon-plus"></i> Crear</a>
            
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
                    <form class="CotizacionCurso_search" id="search" action="{{ route('cotizacionCursos.index') }}" accept-charset="UTF-8" method="get">
                        <input type="hidden" name="q[s]" value="{{ @(Request::input('q')['s']) ?: '' }}" />
                        <div class="form-horizontal">

                            <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_no_coti_gt">NO_COTI</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['no_coti_gt']) ?: '' }}" name="q[no_coti_gt]" id="q_no_coti_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['no_coti_lt']) ?: '' }}" name="q[no_coti_lt]" id="q_no_coti_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_no_coti_cont">NO_COTI</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['no_coti_cont']) ?: '' }}" name="q[no_coti_cont]" id="q_no_coti_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_empresa_id_gt">EMPRESA_ID</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['empresa_id_gt']) ?: '' }}" name="q[empresa_id_gt]" id="q_empresa_id_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['empresa_id_lt']) ?: '' }}" name="q[empresa_id_lt]" id="q_empresa_id_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_empresa_id_cont">EMPRESA_ID</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['empresa_id_cont']) ?: '' }}" name="q[empresa_id_cont]" id="q_empresa_id_cont" />
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
                                <label class="col-sm-2 control-label" for="q_descuento_gt">DESCUENTO</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['descuento_gt']) ?: '' }}" name="q[descuento_gt]" id="q_descuento_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['descuento_lt']) ?: '' }}" name="q[descuento_lt]" id="q_descuento_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_descuento_cont">DESCUENTO</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['descuento_cont']) ?: '' }}" name="q[descuento_cont]" id="q_descuento_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_forma_pago_gt">FORMA_PAGO</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['forma_pago_gt']) ?: '' }}" name="q[forma_pago_gt]" id="q_forma_pago_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['forma_pago_lt']) ?: '' }}" name="q[forma_pago_lt]" id="q_forma_pago_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_forma_pago_cont">FORMA_PAGO</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['forma_pago_cont']) ?: '' }}" name="q[forma_pago_cont]" id="q_forma_pago_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_subtotal_gt">SUBTOTAL</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['subtotal_gt']) ?: '' }}" name="q[subtotal_gt]" id="q_subtotal_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['subtotal_lt']) ?: '' }}" name="q[subtotal_lt]" id="q_subtotal_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_subtotal_cont">SUBTOTAL</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['subtotal_cont']) ?: '' }}" name="q[subtotal_cont]" id="q_subtotal_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_descuento_gt">DESCUENTO</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['descuento_gt']) ?: '' }}" name="q[descuento_gt]" id="q_descuento_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['descuento_lt']) ?: '' }}" name="q[descuento_lt]" id="q_descuento_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_descuento_cont">DESCUENTO</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['descuento_cont']) ?: '' }}" name="q[descuento_cont]" id="q_descuento_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_iva_gt">IVA</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['iva_gt']) ?: '' }}" name="q[iva_gt]" id="q_iva_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['iva_lt']) ?: '' }}" name="q[iva_lt]" id="q_iva_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_iva_cont">IVA</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['iva_cont']) ?: '' }}" name="q[iva_cont]" id="q_iva_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_total_gt">TOTAL</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['total_gt']) ?: '' }}" name="q[total_gt]" id="q_total_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['total_lt']) ?: '' }}" name="q[total_lt]" id="q_total_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_total_cont">TOTAL</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['total_cont']) ?: '' }}" name="q[total_cont]" id="q_total_cont" />
                                </div>
                            </div>
                                                    <!--
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_observaciones_gt">OBSERVACIONES</label>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['observaciones_gt']) ?: '' }}" name="q[observaciones_gt]" id="q_observaciones_gt" />
                                </div>
                                <div class=" col-sm-1 text-center"> - </div>
                                <div class=" col-sm-4">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['observaciones_lt']) ?: '' }}" name="q[observaciones_lt]" id="q_observaciones_lt" />
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="q_observaciones_cont">OBSERVACIONES</label>
                                <div class=" col-sm-9">
                                    <input class="form-control input-sm" type="search" value="{{ @(Request::input('q')['observaciones_cont']) ?: '' }}" name="q[observaciones_cont]" id="q_observaciones_cont" />
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
            @if($cotizacionCursos->count())
                <table class="table table-condensed table-striped tblEnc">
                    <thead>
                        <tr>
                            
                            <th>NO</th>
                            <th>EMPRESA</th>
                            <th>FECHA</th>
                            <th>SUBTOTAL</th>
                            <th>DESCUENTO</th>
                            <th>IVA</th>
                            <th>TOTAL</th>
                            <th>FACTURAS</th>
                            <th>ALTA</th>
                            <th>LINEAS</th>
                            <th>ESTATUS</th>
                            
                            <th class="text-right">OPCIONES</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($cotizacionCursos as $cotizacionCurso)
                            <tr>
                                
                                <td>{{$cotizacionCurso->empresa->plantel->cve_plantel.$cotizacionCurso->no_coti}}</td>
                                <td>{{$cotizacionCurso->empresa->razon_social}}</td>
                                <td>{{$cotizacionCurso->fecha}}</td>
                                <td>{{$cotizacionCurso->subtotal}}</td>
                                <td>{{$cotizacionCurso->descuento}}</td>
                                <td>{{$cotizacionCurso->iva}}</td>
                                <td>{{$cotizacionCurso->total}}</td>
                                <td>
                                    <button type="button" class="btn btn-info btn-xs" id='create_factura' 
                                            data-toggle="modal" data-cotizacion_curso_id="{{ $cotizacionCurso->id }}"
                                                                data-st_curso_empresa_id="3">
                                        Crear
                                    </button>
                                    <button class="btn btn-success btnVerFacturas pull-right btn-xs" lang="mesaj" data-cotizacion_curso="{{$cotizacionCurso->id}}" data-href="formation_json_parents" style="margin-left:10px;" >
                                        <span class="fa fa-eye" aria-hidden="true"></span> Ver
                                    </button>
                                </td>
                                <td>{{$cotizacionCurso->usu_alta->name}}</td>
                                <td>
                                    <button type="button" class="btn btn-info btn-xs" id='create_linea' 
                                            data-toggle="modal" data-cotizacion_curso_id="{{ $cotizacionCurso->id }}"
                                                                data-st_curso_empresa_id="3">
                                        Crear
                                    </button>
                                    <button class="btn btn-success btnVerLineas pull-right btn-xs" lang="mesaj" data-cotizacion_curso="{{$cotizacionCurso->id}}" data-href="formation_json_parents" style="margin-left:10px;" >
                                        <span class="fa fa-eye" aria-hidden="true"></span> Ver
                                    </button>
                                    <div class='loading3' style='display: none'><img src="{{ asset('images/ajax-loader.gif') }}" title="Enviando" /></div> 
                                </td>
                                <td>{{$cotizacionCurso->stCursoEmpresa->name}}</td>
                                
                                <td class="text-right">
                                    @if(isset($cotizacionCurso->empresa->correo1))
                                    <a class="btn btn-xs btn-success" href="{{ url('correos/redactar').'/'.$cotizacionCurso->empresa->correo1.'/'.$cotizacionCurso->empresa->nombre_contacto.'/1' }}"><i class="glyphicon glyphicon-envelope"></i> Correo </a>
                                    @endif
<!--                                    <a class="btn btn-xs btn-info" href="{{ route('cotizacionCursos.verCotizacion', array('cotizacion'=>$cotizacionCurso->id,'vista'=>1)) }}" target="_blank"><i class="fa fa-eye"></i> Ver </a>-->
                                    <a class="btn btn-xs btn-info" href="{{ route('cotizacionCursos.verCotizacionPdf', array('cotizacion'=>$cotizacionCurso->id,'vista'=>1)) }}"><i class="fa fa-file-pdf-o"></i> Ver </a>
<!--                                    <a class="btn btn-xs bg-navy" href="{{ route('cotizacionCursos.verCotizacion', array('cotizacion'=>$cotizacionCurso->id,'vista'=>2)) }}" target="_blank"><i class="fa fa-eye"></i> Ver </a>-->
                                    <a class="btn btn-xs bg-navy" href="{{ route('cotizacionCursos.verCotizacionPdf', array('cotizacion'=>$cotizacionCurso->id,'vista'=>2)) }}"><i class="fa fa-file-pdf-o"></i> Ver </a>
                                    @permission('cotizacionCursos.edit')
                                    <a class="btn btn-xs btn-primary" href="{{ route('cotizacionCursos.duplicate', $cotizacionCurso->id) }}"><i class="glyphicon glyphicon-duplicate"></i> Duplicate</a>
                                    @endpermission
                                    @permission('cotizacionCursos.edit')
                                    <a class="btn btn-xs btn-warning" href="{{ route('cotizacionCursos.edit', $cotizacionCurso->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                                    @endpermission
                                    @permission('cotizacionCursos.destroy')
                                    {!! Form::model($cotizacionCurso, array('route' => array('cotizacionCursos.cancelar', $cotizacionCurso->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Cancelar? ¿Esta seguro?')) { return true } else {return false };")) !!}
                                        <button type="submit" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i> Cancelar</button>
                                    {!! Form::close() !!}
                                    @endpermission
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {!! $cotizacionCursos->appends(Request::except('page'))->render() !!}
            @else
                <h3 class="text-center alert alert-info">Vacio!</h3>
            @endif

        </div>
    </div>
<!-- Ventana crear Linea -->
    <div id="createLinea" class="modal fade" role="dialog">
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
                                {!! Form::hidden("cotizacion_curso_id", null, array("class" => "form-control", "id" => "cotizacion_curso_id-crear")) !!}
                                {!! Form::hidden("st_curso_empresa_id", null, array("class" => "form-control", "id" => "st_curso_empresa_id-crear")) !!}
                             </div>
                            <div class="form-group col-md-12 @if($errors->has('cursos_empresa_id')) has-error @endif">
                                <label for="cursos_empresa_id-field">Curso</label>
                                {!! Form::select("cursos_empresa_id", $list["CursosEmpresa"], null, array("class" => "form-control select_seguridad", "id" => "cursos_empresa_id-crear")) !!}
                                @if($errors->has("cursos_empresa_id"))
                                <span class="help-block">{{ $errors->first("cursos_empresa_id") }}</span>
                                @endif
                            </div>
                            <div class="form-group col-md-12 @if($errors->has('empleado_id')) has-error @endif">
                                <label for="empleado_id-field">capacitador</label>
                                {!! Form::select("empleado_id", $list["Empleado"], null, array("class" => "form-control select_seguridad", "id" => "empleado_id-crear")) !!}
                                @if($errors->has("empleado_id"))
                                <span class="help-block">{{ $errors->first("empleado_id") }}</span>
                                @endif
                            </div>
                            <div class="form-group col-md-12 @if($errors->has('tipo_precio_coti_id')) has-error @endif">
                                <label for="tipo_precio_coti_id-field">Tipo Precio</label>
                                {!! Form::select("tipo_precio_coti_id", $list["TipoPrecioCoti"], null, array("class" => "form-control select_seguridad", "id" => "tipo_precio_coti_id-crear")) !!}
                                @if($errors->has("tipo_precio_coti_id"))
                                <span class="help-block">{{ $errors->first("tipo_precio_coti_id") }}</span>
                                @endif
                            </div>
                            <div class="form-group col-sm-6 @if($errors->has('cantidad')) has-error @endif">
                                <label for="cantidad-field">Cantidad</label>
                                {!! Form::text("cantidad", null, array("class" => "form-control", "id" => "cantidad-crear")) !!}
                            </div>
                            <div class="form-group col-sm-6 @if($errors->has('descuento')) has-error @endif">
                                <label for="descuento-field">Descuento</label><div class="label_descuento"></div>
                                {!! Form::text("descuento", null, array("class" => "form-control", "id" => "descuento-crear")) !!}
                            </div>
                            
                            <div class="row"></div>
                        </div> 
                    </form>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id="linea-crear" data-dismiss="modal">
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
<!-- Ventana Editar Linea -->
    <div id="editarLinea" class="modal fade" role="dialog">
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
                                {!! Form::hidden("cotizacion_curso_id", null, array("class" => "form-control", "id" => "cotizacion_curso_id-editar")) !!}
                                
                             </div>
                            <div class="form-group col-md-12 @if($errors->has('st_curso_empresa_id')) has-error @endif">
                                <label for="st_curso_empresa_id-field">Estatus</label>
                                {!! Form::select("st_curso_empresa_id", $list["StCursoEmpresa"], null, array("class" => "form-control select_seguridad", "id" => "st_curso_empresa_id-editar")) !!}
                                @if($errors->has("st_curso_empresa_id"))
                                <span class="help-block">{{ $errors->first("st_curso_empresa_id") }}</span>
                                @endif
                            </div>
                            <div class="form-group col-md-12 @if($errors->has('cursos_empresa_id')) has-error @endif">
                                <label for="cursos_empresa_id-field">Curso</label>
                                <div id='curso'></div>
                                @if($errors->has("cursos_empresa_id"))
                                <span class="help-block">{{ $errors->first("cursos_empresa_id") }}</span>
                                @endif
                            </div>
                            <div class="form-group col-md-12 @if($errors->has('empleado_id')) has-error @endif">
                                <label for="empleado_id-field">capacitador</label>
                                {!! Form::select("empleado_id", $list["Empleado"], null, array("class" => "form-control select_seguridad", "id" => "empleado_id-editar")) !!}
                                @if($errors->has("empleado_id"))
                                <span class="help-block">{{ $errors->first("empleado_id") }}</span>
                                @endif
                            </div>
                            <div class="form-group col-md-12 @if($errors->has('tipo_precio_coti_id')) has-error @endif">
                                <label for="tipo_precio_coti_id-field">Tipo Precio</label>
                                {!! Form::select("tipo_precio_coti_id", $list["TipoPrecioCoti"], null, array("class" => "form-control select_seguridad", "id" => "tipo_precio_coti_id-editar")) !!}
                                @if($errors->has("tipo_precio_coti_id"))
                                <span class="help-block">{{ $errors->first("tipo_precio_coti_id") }}</span>
                                @endif
                            </div>
                            <div class="form-group col-sm-6 @if($errors->has('cantidad')) has-error @endif">
                                <label for="cantidad-field">Cantidad</label>
                                {!! Form::text("cantidad", null, array("class" => "form-control", "id" => "cantidad-editar")) !!}
                            </div>
                            <div class="form-group col-sm-6 @if($errors->has('descuento')) has-error @endif">
                                <label for="descuento-field">Descuento</label><div class="label_descuento"></div>
                                {!! Form::text("descuento", null, array("class" => "form-control", "id" => "descuento-editar")) !!}
                            </div>
                            
                            
                            <div class="row"></div>
                        </div> 
                    </form>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id="linea-editar" data-dismiss="modal">
                            <span class='glyphicon glyphicon-check'></span> Guardar
                        </button>
                        <button type="button" class="btn btn-warning" data-dismiss="modal">
                            <span class='glyphicon glyphicon-remove'></span> Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>  

<!-- Ventana crear Factura -->
    <div id="createFactura" class="modal fade" role="dialog">
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
                                {!! Form::hidden("cotizacion_curso_id", null, array("class" => "form-control", "id" => "cotizacion_curso_id-crear")) !!}
                             </div>
                            <div class="form-group col-sm-6 @if($errors->has('no_factura')) has-error @endif">
                                <label for="no_factura-field">No. Factura</label>
                                {!! Form::text("no_factura", null, array("class" => "form-control", "id" => "no_factura-crear")) !!}
                            </div>
                            <div class="form-group col-sm-6 @if($errors->has('fecha')) has-error @endif">
                                <label for="fecha-field">Fecha</label>
                                {!! Form::text("fecha", null, array("class" => "form-control", "id" => "fecha-crear")) !!}
                            </div>
                            <div class="form-group col-sm-6 @if($errors->has('monto')) has-error @endif">
                                <label for="monto-field">Monto</label>
                                {!! Form::text("monto", null, array("class" => "form-control", "id" => "monto-crear")) !!}
                            </div>
                            <div class="form-group col-sm-6 @if($errors->has('forma_pago_id')) has-error @endif">
                                <label for="forma_pago_id-field">Forma Pago</label>
                                {!! Form::select("forma_pago_id", $list2["FormaPago"], null, array("class" => "form-control select_seguridad", "id" => "forma_pago_id-crear")) !!}
                                @if($errors->has("forma_pago_id"))
                                <span class="help-block">{{ $errors->first("forma_pago_id") }}</span>
                                @endif
                            </div>
                            
                            <div class="row"></div>
                        </div> 
                    </form>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id="factura-crear" data-dismiss="modal">
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
<!-- Ventana Editar Factura -->
    <div id="editarFactura" class="modal fade" role="dialog">
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
                                {!! Form::hidden("cotizacion_curso_id", null, array("class" => "form-control", "id" => "cotizacion_curso_id-editar")) !!}
                             </div>
                            <div class="form-group col-sm-6 @if($errors->has('no_factura')) has-error @endif">
                                <label for="no_factura-field">No. Factura</label>
                                {!! Form::text("no_factura", null, array("class" => "form-control", "id" => "no_factura-editar")) !!}
                            </div>
                            <div class="form-group col-sm-6 @if($errors->has('fecha')) has-error @endif">
                                <label for="fecha-field">Fecha</label>
                                {!! Form::text("fecha", null, array("class" => "form-control", "id" => "fecha-editar")) !!}
                            </div>
                            <div class="form-group col-sm-6 @if($errors->has('monto')) has-error @endif">
                                <label for="monto-field">Monto</label>
                                {!! Form::text("monto", null, array("class" => "form-control", "id" => "monto-editar")) !!}
                            </div>
                            <div class="form-group col-sm-6 @if($errors->has('forma_pago_id')) has-error @endif">
                                <label for="forma_pago_id-field">Forma Pago</label>
                                {!! Form::select("forma_pago_id", $list2["FormaPago"], null, array("class" => "form-control select_seguridad", "id" => "forma_pago_id-editar")) !!}
                                @if($errors->has("forma_pago_id"))
                                <span class="help-block">{{ $errors->first("forma_pago_id") }}</span>
                                @endif
                            </div>
                            <div class="row"></div>
                        </div> 
                    </form>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id="factura-editar" data-dismiss="modal">
                            <span class='glyphicon glyphicon-check'></span> Guardar
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
        
        $('#cursos_empresa_id-crear').change(function(){
            opcion=$('#cursos_empresa_id-crear option:selected').val();
            //console.log(opcion);
            descuentoMaximo(opcion);
        });
        
        function descuentoMaximo(option){
            $.ajax({
            type: 'GET',
            url: "{{url('/cursosEmpresas/getDescuentoMax/')}}"+'/'+option,
            beforeSend : function(){$("#loading3").show(); },
            complete : function(){$("#loading3").hide(); },
            success: function(data) {
                    //location.reload();
                    console.log(data);
                    
                    $('.label_descuento').text("(Maximo% "+data+")");
                }   
        });
        }
        
        //Muestra Ventana Crear Linea
        $(document).on('click', '#create_linea', function() {
            $('#cotizacion_curso_id-crear').val($(this).data('cotizacion_curso_id'));
            $('#st_curso_empresa_id-crear').val($(this).data('st_curso_empresa_id'));
            
            $('.modal-title').text('Linea de Cotización');
            

            $('#createLinea').modal('show');
        });
       
        //Crear Linea
    $('.modal-footer').on('click', '#linea-crear', function() {
        var ruta='{{url("cotizacionLns/store")}}';
        
        //alert(bnd);
        //Crea el registro de la linea
        $.ajax({
            type: 'POST',
            url: ruta,
            data: {
                '_token': $('input[name=_token]').val(),
                'cotizacion_curso_id': $('#cotizacion_curso_id-crear').val(),
                'empleado_id': $('#empleado_id-crear').val(),
                'st_curso_empresa_id': $('#st_curso_empresa_id-crear').val(),
                'cursos_empresa_id': $('#cursos_empresa_id-crear option:selected').val(),
                'tipo_precio_coti_id': $('#tipo_precio_coti_id-crear option:selected').val(),
                'cantidad': $('#cantidad-crear').val(),
                'descuento': $('#descuento-crear').val()
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
    url: "{{route('cotizacionLns.getByCotizacionCursoId')}}",
            dataType: "json",
            data: "cotizacion_curso=" + $(this).data('cotizacion_curso'),
            beforeSend : function(){$(".loading3").show(); },
            complete : function(){$(".loading3").hide(); },
            success: function (anaVeri) {

            var yenitablosatir = '<tr class="expand-child" id="collapse' + $btn.data('id') + '">' +
                    '<td colspan="12">' +
                    '<table class="table table-condensed altTablo table-hover" width=100% >' +
                    '<thead>' +
                    '<tr>' +
                    '<th>Consecutivo</th>' +
                    '<th>Estatus</th>' +
                    '<th>Curso</th>' +
                    '<th>Capacitador</th>' +
                    '<th>Tipo Precio</th>' +
                    '<th>Cantidad</th>' +
                    '<th>Precio</th>' +
                    '<th>Descuento</th>' +
                    '<th>Total</th>' +
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
            @permission('cotizacionLns.edit')
                    btnEditarLn = '<button type="button" class="btn btn-xs btn-primary btnEditLinea" data-id=' + anaVeri[i].id +
                                                                                                   ' data-cotizacion_curso_id=' + anaVeri[i].cotizacion_curso_id +
                                                                                                   ' data-st_curso_empresa_id=' + anaVeri[i].st_curso_empresa_id +
                                                                                                   ' data-cursos_empresa_id=' + anaVeri[i].cursos_empresa_id +
                                                                                                   ' data-empleado_id=' + anaVeri[i].empleado_id +
                                                                                                   ' data-curso="' + anaVeri[i].curso + '"'+
                                                                                                   ' data-tipo_precio_coti_id=' + anaVeri[i].tipo_precio_coti_id +
                                                                                                   ' data-cantidad=' + anaVeri[i].cantidad +
                                                                                                   ' data-descuento=' + anaVeri[i].descuento +
                                                                                                   '>' +
                    '<i class="glyphicon glyphicon-pencil"></i> Editar' +
                    '</button>'
            @endpermission
                    var btnEliminarLn = "";
            @permission('cotizacionLns.destroy')
                    btnEliminarLn = '<button type="submit" class="btn btn-danger btn-xs" title="Eliminar" onclick="return confirm(&quot; Eliminar &quot;)">' +
                    '<span class="glyphicon glyphicon-trash" aria-hidden="true"></span>Eliminar' +
                    '</button>';
            @endpermission
                    yenitablosatir += '<tr>' +
                    //kullaniciTomar.Surname      
                    '<td>' + anaVeri[i].consecutivo + '</td>' +
                    '<td>' + anaVeri[i].estatus + '</td>' +
                    '<td>' + anaVeri[i].curso + '</td>' +
                    '<td>' + anaVeri[i].empleado + '</td>' +
                    '<td>' + anaVeri[i].tipo_precio + '</td>' +
                    '<td>' + anaVeri[i].cantidad + '</td>' +
                    '<td>' + anaVeri[i].precio + '</td>' +
                    '<td>' + anaVeri[i].descuento + '</td>' +
                    '<td>' + anaVeri[i].total + '</td>' +
                    '<td>' +
                    '<form method="POST" action="' + '{!! url('cotizacionLns/destroy') !!}' + '/' + anaVeri[i].id + '" accept-charset="UTF-8">' +
                    '<input name="_method" value="DELETE" type="hidden">' +
                    '{{ csrf_field() }}' +
                    btnEliminarLn +
                    '</form>'+
                    btnEditarLn +
                    '</td>' +
                    '</tr>';
            j++;
            });
            }
            yenitablosatir += '</tbody></table></td></tr>';
            // set next row
            $tablosonrakisatir = $(yenitablosatir).insertAfter($tablosatir);
            //$(".btnEditLinea").click(function(){
            $(document).on('click', '.btnEditLinea', function() {
                //window.open('{{url("/cotizacionLns/edit/")}}' + '/' + $(this).data('linea'), '_blank');
                id=$(this).data('id');
                $('#cotizacion_curso_id-editar').val($(this).data('cotizacion_curso_id'));
                $('#st_curso_empresa_id-editar').val($(this).data('st_curso_empresa_id'));
                $('#empleado_id-editar').val($(this).data('empleado_id'));
                $('#empleado_id-editar').change();
                //$('#cursos_empresa_id-editar').val($(this).data('cursos_empresa_id'));
                //$('#cursos_empresa_id-editar').change();
                $('#curso').html($(this).data('curso'));
                $('#tipo_precio_coti_id-editar').val($(this).data('tipo_precio_coti_id'));
                $('#tipo_precio_coti_id-editar').change();
                $('#cantidad-editar').val($(this).data('cantidad'));
                $('#descuento-editar').val($(this).data('descuento'));
                $('#st_curso_empresa_id-editar').val($(this).data('st_curso_empresa_id'));
                $('#st_curso_empresa_id-editar').change();

                $('.modal-title').text('Linea de Cotización');
                
                $('#editarLinea').modal('show');
                descuentoMaximo($(this).data('cursos_empresa_id'));
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

    //Actualizar Linea
        $('.modal-footer').on('click', '#linea-editar', function() {
        var ruta='{{url("cotizacionLns/update")}}'+'/'+ id;
        
        
        //alert(bnd);
        //Crea el registro de la linea
        $.ajax({
            type: 'POST',
            url: ruta,
            data: {
                '_token': $('input[name=_token]').val(),
                'cotizacion_curso_id':$('#cotizacion_curso-editar').val(),
                'st_curso_empresa_id': $('#st_curso_empresa_id-editar option:selected').val(),
                'empleado_id': $('#empleado_id-editar option:selected').val(),
                'tipo_precio_coti_id': $('#tipo_precio_coti_id-editar option:selected').val(),
                'cantidad': $('#cantidad-editar').val(),
                'descuento': $('#descuento-editar').val(),
            },
            beforeSend : function(){$(".loading3").show(); },
            complete : function(){$(".loading3").hide(); },
            success: function(data) {
                    location.reload();
                }   
        });
    });
    
    
    //***********************************Muestra Ventana Crear Factura
        $(document).on('click', '#create_factura', function() {
            $('#cotizacion_curso_id-crear').val($(this).data('cotizacion_curso_id'));
            $('.modal-title').text('Crear Factura');
            
            $('#createFactura').modal('show');
        });
       
    //Crear factura
    $('.modal-footer').on('click', '#factura-crear', function() {
        var ruta='{{url("facturaCotizacions/store")}}';
        
        //alert(bnd);
        //Crea el registro de la factura
        $.ajax({
            type: 'POST',
            url: ruta,
            data: {
                '_token': $('input[name=_token]').val(),
                'cotizacion_curso_id': $('#cotizacion_curso_id-crear').val(),
                'no_factura': $('#no_factura-crear').val(),
                'fecha': $('#fecha-crear').val(),
                'monto': $('#monto-crear').val(),
                'forma_pago_id': $('#forma_pago_id-crear option:selected').val(),
            },
            beforeSend : function(){$("#loading3").show(); },
            complete : function(){$("#loading3").hide(); },
            success: function(data) {
                    location.reload();
                }   
        });
    });
    
    var $table = $('.tblEnc');
    $table.find('.btnVerFacturas').on('click', function(e) {

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
    url: "{{route('facturaCotizacions.getByCotizacionCursoId')}}",
            dataType: "json",
            data: "cotizacion_curso=" + $(this).data('cotizacion_curso'),
            beforeSend : function(){$(".loading3").show(); },
            complete : function(){$(".loading3").hide(); },
            success: function (anaVeri) {

            var yenitablosatir = '<tr class="expand-child" id="collapse' + $btn.data('id') + '">' +
                    '<td colspan="12">' +
                    '<table class="table table-condensed altTablo table-hover" width=100% >' +
                    '<thead>' +
                    '<tr>' +
                    '<th>No. Factura</th>' +
                    '<th>Fecha</th>' +
                    '<th>Monto</th>' +
                    '<th>Forma Pago</th>' +
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
            @permission('facturaCotizacions.edit')
                    btnEditarLn = '<button type="button" class="btn btn-xs btn-primary btnEditFactura" data-id=' + anaVeri[i].id +
                                                                                                   ' data-cotizacion_curso_id=' + anaVeri[i].cotizacion_curso_id +
                                                                                                   ' data-no_factura=' + anaVeri[i].no_factura +
                                                                                                   ' data-fecha=' + anaVeri[i].fecha +
                                                                                                   ' data-monto="' + anaVeri[i].monto + '"'+
                                                                                                   ' data-forma_pago_id=' + anaVeri[i].forma_pago_id +
                                                                                                   '>' +
                    '<i class="glyphicon glyphicon-pencil"></i> Editar' +
                    '</button>'
            @endpermission
                    var btnEliminarLn = "";
            @permission('facturaCotizacions.destroy')
                    btnEliminarLn = '<button type="submit" class="btn btn-danger btn-xs" title="Eliminar" onclick="return confirm(&quot; Eliminar &quot;)">' +
                    '<span class="glyphicon glyphicon-trash" aria-hidden="true"></span>Eliminar' +
                    '</button>';
            @endpermission
                    yenitablosatir += '<tr>' +
                    //kullaniciTomar.Surname      
                    '<td>' + anaVeri[i].no_factura + '</td>' +
                    '<td>' + anaVeri[i].fecha + '</td>' +
                    '<td>' + anaVeri[i].monto + '</td>' +
                    '<td>' + anaVeri[i].forma_pago + '</td>' +
                    '<td>' +
                    '<form method="POST" action="' + '{!! url('facturaCotizacions/destroy') !!}' + '/' + anaVeri[i].id + '" accept-charset="UTF-8">' +
                    '<input name="_method" value="DELETE" type="hidden">' +
                    '{{ csrf_field() }}' +
                    btnEliminarLn +
                    '</form>'+
                    btnEditarLn +
                    '</td>' +
                    '</tr>';
            j++;
            });
            }
            yenitablosatir += '</tbody></table></td></tr>';
            // set next row
            $tablosonrakisatir = $(yenitablosatir).insertAfter($tablosatir);
            //$(".btnEditLinea").click(function(){
            $(document).on('click', '.btnEditFactura', function() {
                //window.open('{{url("/cotizacionLns/edit/")}}' + '/' + $(this).data('linea'), '_blank');
                id=$(this).data('id');
                $('#cotizacion_curso_id-editar').val($(this).data('cotizacion_curso_id'));
                $('#no_factura-editar').val($(this).data('no_factura'));
                $('#fecha-editar').val($(this).data('fecha'));
                $('#monto-editar').val($(this).data('monto'));
                $('#forma_pago_id-editar').val($(this).data('forma_pago_id'));
                $('#forma_pago_id-editar').change();

                $('.modal-title').text('Editar Factura');
                
                $('#editarFactura').modal('show');
                
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

    //Actualizar Linea
        $('.modal-footer').on('click', '#factura-editar', function() {
        var ruta='{{url("facturaCotizacions/update")}}'+'/'+ id;
        
        
        //alert(bnd);
        //Crea el registro de la linea
        $.ajax({
            type: 'POST',
            url: ruta,
            data: {
                '_token': $('input[name=_token]').val(),
                'no_factura': $('#no_factura-editar').val(),
                'fecha': $('#fecha-editar').val(),
                'monto': $('#monto-editar').val(),
                'forma_pago_id': $('#forma_pago_id-editar option:selected').val(),
                
            },
            beforeSend : function(){$(".loading3").show(); },
            complete : function(){$(".loading3").hide(); },
            success: function(data) {
                    location.reload();
                }   
        });
    });
    
    
    });
    $('#fecha-crear').Zebra_DatePicker({
        days:['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'],
        months:['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
        readonly_element: false,
        lang_clear_date: 'Limpiar',
        show_select_today: 'Hoy',
      });
    $('#fecha-editar').Zebra_DatePicker({
        days:['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'],
        months:['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
        readonly_element: false,
        lang_clear_date: 'Limpiar',
        show_select_today: 'Hoy',
      });
  </script>
@endpush  
    