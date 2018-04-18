@extends('plantillas.admin_template')

@include('cajas._common')

@section('header')

	<ol class="breadcrumb">
	    <li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li><a href="#">Caja</a></li>
	</ol>

    
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-body">
                  {!! Form::open(array('route' => 'cajas.buscarVenta')) !!}
                        
                        <div class="input-group form-group col-md-3 @if($errors->has('cliente_id')) has-error @endif">
                            <div class="input-group-btn">
                                <button type="submit" class="btn btn-info" data-toggle="tooltip" title="Buscar Venta"><i class='fa fa-search'></i></button>
                            </div>
                            @if(isset($caja))
                                {!! Form::text("caja_id", ($caja)?$caja->id:"", array("class" => "form-control ", 'placeholder'=>'No. de Venta',"id" => "caja_id-field")) !!}
                            @else
                                {!! Form::text("caja_id", null, array("class" => "form-control ", 'placeholder'=>'No. de Venta', "id" => "caja_id-field")) !!}
                            @endif
                            
                            @if($errors->has("cliente_id"))
                             <span class="help-block">{{ $errors->first("caja_id") }}</span>
                            @endif
                         </div>
                        
                        @if(isset($message))
                            <div class="alert alert-danger alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                {{$message}}
                            </div>
                        @endif
                        
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
        <div class="col-md-7">
            <div class="box box-info">
                <div class="box-body">
                  {!! Form::open(array('route' => 'cajas.buscarCliente')) !!}
                        
                        <div class="input-group form-group col-md-3 @if($errors->has('cliente_id')) has-error @endif">
                            <div class="input-group-btn">
                                <button type="submit" class="btn btn-info" data-toggle="tooltip" title="Buscar Cliente"><i class='fa fa-search'></i></button>
                            </div>
                            @if(isset($cliente))
                                {!! Form::text("cliente_id", ($cliente)?$cliente->id:"", array("class" => "form-control ", 'placeholder'=>'No. de Cliente',"id" => "cliente_id-field")) !!}
                            @else
                                {!! Form::text("cliente_id", null, array("class" => "form-control ", 'placeholder'=>'No. de Cliente', "id" => "cliente_id-field")) !!}
                            @endif
                            
                            @if($errors->has("cliente_id"))
                             <span class="help-block">{{ $errors->first("cliente_id") }}</span>
                            @endif
                         </div>
                        
                        @if(isset($message))
                            <div class="alert alert-danger alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                {{$message}}
                            </div>
                        @endif
                        
                    {!! Form::close() !!}
                    
                    
                    @if(isset($cliente))
                    
                    {!! Form::open(array('route' => 'cajas.store')) !!}
                    
                            
                        <div class="input-group form-group col-md-3 @if($errors->has('cliente_id')) has-error @endif">
                            <div class="input-group-btn">
                                <button type="submit" class="btn btn-warning" data-toggle="tooltip" title="Crear Venta"><i class='glyphicon glyphicon-plus-sign'></i></button>
                            </div>
                            {!! Form::text("fecha", null, array("class" => "form-control", "id" => "fecha-field", 'placeholder'=>'Fecha de Venta')) !!}
                        </div>
                        {!! Form::hidden("cliente_id", $cliente->id, array("class" => "form-control", "id" => "cliente_id-field")) !!}
                            
                    
                    {!! Form::close() !!}
                    @if(isset($caja) and $caja->st_caja_id==0)
                    <div class="form-group col-md-2">
                        <div class='text-center'>
                            
                            {!! Form::open(array('route' => 'cajas.pagar')) !!}
                                
                                {!! Form::hidden("caja", $caja->id, array("class" => "form-control", "id" => "caja_id-field")) !!}
                                <button type="submit" class="btn btn-success btn-sm "><i class="fa fa-money"></i> Pagar Venta</button>
                            {!! Form::close() !!}
                            
                        </div>
                    </div>
                    @endif
                    @if(isset($caja))
                    <div class="form-group col-md-2">
                        <div class='text-center'>
                            
                            {!! Form::open(array('route' => 'cajas.cancelar')) !!}
                                {!! Form::hidden("caja", $caja->id, array("class" => "form-control", "id" => "caja_id-field")) !!}
                                <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-close"></i> Cancelar Venta</button>
                            {!! Form::close() !!}
                            
                        </div>
                    </div>
                    @endif
                    @endif
                    @if(isset($caja))
                    <div class="form-group col-md-2">
                        <div class='text-center'>
                            <a href="#" class="add-modal btn btn-success btn-sm"><i class="glyphicon glyphicon-plus-sign"></i>Agregar Linea</a> 
                        </div>
                    </div>
                    @endif
                </div><!-- /.box-body -->
            </div>
            <div class="box box-success">
                <div class="box-body no-padding">
                    <div class="box-header with-border">
                        @if(isset($caja))
                        <h5 class="box-title"><lable><strong>No. Ticket:</strong>{{$caja->id}}</lable>
                        <lable><strong>Fecha:</strong>{{$caja->fecha}}</lable>
                        <lable><strong>Estatus:</strong>{{$caja->stCaja->name}}</lable>
                        </h5>
                        <div class="box-tools pull-right">
                          <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                        </div><!-- /.box-tools -->
                        @endif
                    </div>
                    <div class="row col-md-12" id='loading3' style='display: none'>
                        <h3>Actualizando... Por Favor Espere.</h3>
                        <div class="progress progress-striped active page-progress-bar">
                            <div class="progress-bar" style="width: 100%;"></div>
                        </div>
                    </div>
                    @if(isset($caja))
                    
                    <table class="table table-striped table-bordered table-hover" id="postTable" >
                        <thead>
                            <tr>
                                <th>Concepto</th>
                                <th>Monto</th>
                                <th></th>
                            </tr>
                            {{ csrf_field() }}
                        </thead>
                        <tbody>
                            @foreach($caja->cajaLns as $linea)
                            <tr>
                                <td> {{$linea->cajaConcepto->name}} </td><td>{{ $linea->subtotal }}</td>
                                <td>
                                    @if(isset($caja) and $caja->st_caja_id==0)
                                    @permission('cajaLns.destroy')
                                    {!! Form::model($linea, array('route' => array('cajaLns.destroy', $linea->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? ¿Esta seguro?')) { return true } else {return false };")) !!}
                                        <button type="submit" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i> Borrar</button>
                                    {!! Form::close() !!}
                                    @endpermission
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                            <tr>
                                <td> Subtotal </td><td>{{ $caja->subtotal }}</td>
                            </tr>
                            <tr>
                                <td> Recargos </td><td>{{ $caja->recargo }}</td>
                            </tr>
                            <tr>
                                <td> Descuentos </td><td>{{ $caja->descuento }}</td>
                            </tr>
                            <tr>
                                <td> Total </td><td>{{ $caja->total }}</td>
                            </tr>
                        </tbody>
                    </table>
                    @endif
                </div><!-- /.box-body -->
            </div>
            
        </div>
        @if(isset($cliente))
        <div class="col-md-5">
            <div class="box box-danger">
                <div class="box-header">
                  <h3 class="box-title">Adeudos-{{$cliente->nombre." ".$cliente->nombre2." ".$cliente->ape_paterno." ".$cliente->ape_materno}}</h3>
                </div>
                <div class="box-body no-padding">
                    
                    <table class='table table-striped table-condensed'>
                        
                        <tbody>
                            @foreach($combinaciones as $combinacion)
                            <tr>
                                <td colspan='6'><strong>Grado:</strong>{{$combinacion->grado->name}}</td>
                            </tr>
                            <tr>
                                <td></td><td>Concepto</td><td>Monto</td><td>Fecha</td><td>Inicial</td><td>Ticket Pago</td> 
                            </tr>
                                @foreach($combinacion->adeudos as $adeudo)
                                    
                                    <tr>
                                        <td>
                                            @if($adeudo->pagado_bnd==0)
                                            @if(isset($caja) and $caja->st_caja_id==0)
                                            {!! Form::open(array('route' => 'cajas.guardaAdeudoPredefinido','method' => 'post')) !!}
                                                <input class="form-control" id="combinacion-field" name="combinacion" value="{{$combinacion->id}}" type="hidden">
                                                <input class="form-control" id="adeudo-field" name="adeudo" value="{{$adeudo->id}}" type="hidden">
                                                <input class="form-control" id="inicial_bnd-field" name="inicial_bnd" value="{{$adeudo->inicial_bnd}}" type="hidden">
                                                <input class="form-control" id="cliente_id-field" name="cliente_id" value="{{$adeudo->cliente_id}}" type="hidden">
                                                <input class="form-control" id="fecha_pago-field" name="fecha_pago" value="{{$adeudo->fecha_pago}}" type="hidden">
                                                <input class="form-control" id="caja-field" name="caja" value="{{$caja->id}}" type="hidden">
                                                <button type="submit" class="btn btn-xs btn-info"><i class="glyphicon glyphicon-plus-sign"></i> Agregar</button>
                                            {!! Form::close() !!}
                                            @endif
                                            @endif
                                        <td>{{$adeudo->cajaConcepto->name}}</td>
                                        <td>{{$adeudo->monto}}</td>
                                        <td>{{$adeudo->fecha_pago}}</td>
                                        <td>@if($adeudo->inicial_bnd==1) SI @else NO @endif</td>
                                        <td>{{$adeudo->caja_id}}</td>
                                    </tr>
                                    
                                @endforeach
                            @endforeach
                            
                        </tbody>
                    </table>
                </div><!-- /.box-body -->
              </div>
        </div>
        @endif
    </div>
    
    <!--
    Pantallas modales
    Agregar nuevo registro
    -->
    @if(isset($caja))
    <div id="addModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">×</button>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body">
                    {!! Form::open(array('route' => 'cajaLns.store')) !!}
                         <div class="form-group col-md-12 @if($errors->has('caja_concepto_id')) has-error @endif">
                            <label for="caja_concepto_id-field">Caja Concepto</label><br/>
                            {!! Form::select("caja_concepto_id", $list1["CajaConcepto"], null, array("class" => "form-control select_seguridad", "id" => "caja_concepto_id-crear")) !!}
                            <p class="errorCajaConcepto text-center alert alert-danger hidden"></p>
                         </div>
                         
                    {!! Form::close() !!}
                    <div class="row"></div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success add" id="Agregar" data-dismiss="modal">
                            <span id="" class='glyphicon glyphicon-check'></span> Crear
                        </button>
                        <button type="button" class="btn btn-warning" data-dismiss="modal">
                            <span class='glyphicon glyphicon-remove'></span> Cerrar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
    
@endsection
@push('scripts')
<script>
    $('#fecha-field').Zebra_DatePicker({
    days:['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'],
            months:['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
            readonly_element: false,
            lang_clear_date: 'Limpiar',
            show_select_today: 'Hoy',
    });
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();   
});

//crear registro
    $(document).on('click', '.add-modal', function() {
        $('.modal-title').text('Agregar Linea');
        //Limpiar valores
        $('#addModal').modal('show');
    });
    
    @if(isset($caja) and isset($cliente))
    $('.modal-footer').on('click', '.add', '#Agregar', function() {
        $.ajax({
            type: 'POST',
            url: '{{route("cajas.guardaAdeudo")}}',
            data: {
                '_token': $('input[name=_token]').val(),
                'caja': {{$caja->id}},
                'cliente': {{$cliente->id}},
                'concepto': $('#caja_concepto_id-crear').val()
            },
            beforeSend : function(){$("#loading3").show(); },
            complete : function(){$("#loading3").hide(); },
            success: function(data) {
                window.location.href = "{{route('cajas.edit', $caja->id)}}";
            }    
        });
    });
    @endif
</script>
@endpush
