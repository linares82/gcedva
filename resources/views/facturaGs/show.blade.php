@extends('plantillas.admin_template')

@include('facturaGs._common')

@section('header')

<ol class="breadcrumb">
	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
    <li><a href="{{ route('facturaGs.index') }}">@yield('facturaGsAppTitle')</a></li>
    <li class="active">{{ $facturaG->name }}</li>
</ol>

<div class="page-header">
        <h1>@yield('facturaGsAppTitle') / Mostrar {{$facturaG->id}}

            {!! Form::model($facturaG, array('route' => array('facturaGs.destroy', $facturaG->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? Estas seguro?')) { return true } else {return false };")) !!}
                <div class="btn-group pull-right" role="group" aria-label="...">
                    @permission('facturaG.edit')
                    <a class="btn btn-warning btn-group" role="group" href="{{ route('facturaGs.edit', $facturaG->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                    @endpermission
                    @permission('facturaG.destroy')
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
                <div class="form-group col-sm-3">
                    <label for="nome">ID</label>
                    <p class="form-control-static">{{$facturaG->id}}</p>
                </div>
                <div class="form-group col-sm-3">
                     <label for="cuenta_efectivo_id">CUENTA</label>
                     <p class="form-control-static">{{$facturaG->cuentasEfectivo->no_cuenta}}</p>
                </div>
                    <div class="form-group col-sm-3">
                     <label for="serie_string">SERIE</label>
                     <p class="form-control-static">{{$facturaG->serie_string}}</p>
                </div>
                    <div class="form-group col-sm-3">
                     <label for="folio">FOLIO</label>
                     <p class="form-control-static">{{$facturaG->folio}}</p>
                </div>
                    <div class="form-group col-sm-3">
                     <label for="fecha">FECHA</label>
                     <p class="form-control-static">{{$facturaG->fecha}}</p>
                </div>
                    <div class="form-group col-sm-3">
                     <label for="tipo_comprobante">TIPO COMPROBANTE</label>
                     <p class="form-control-static">{{$facturaG->tipo_comprobante}}</p>
                </div>
                    <div class="form-group col-sm-3">
                     <label for="lugar_expedicion">LUGAR EXPEDICION</label>
                     <p class="form-control-static">{{$facturaG->lugar_expedicion}}</p>
                </div>
                    <div class="form-group col-sm-3">
                     <label for="exportacion">EXPORTACION</label>
                     <p class="form-control-static">{{$facturaG->exportacion}}</p>
                </div>
                    <div class="form-group col-sm-3">
                     <label for="periodicidad">PERIODICIDAD</label>
                     <p class="form-control-static">{{$facturaG->periodicidad}}</p>
                </div>
                    <div class="form-group col-sm-3">
                     <label for="meses">MESES</label>
                     <p class="form-control-static">{{$facturaG->meses}}</p>
                </div>
                    <div class="form-group col-sm-3">
                     <label for="anio">AÑO</label>
                     <p class="form-control-static">{{$facturaG->anio}}</p>
                </div>
                    <div class="form-group col-sm-3">
                     <label for="emisor_rfc">EMISOR RFC</label>
                     <p class="form-control-static">{{$facturaG->emisor_rfc}}</p>
                </div>
                    <div class="form-group col-sm-3">
                     <label for="emisor_nombre">EMISOR NOMBRE</label>
                     <p class="form-control-static">{{$facturaG->emisor_nombre}}</p>
                </div>
                    <div class="form-group col-sm-3">
                     <label for="emisor_regimen_fiscal">EMISOR REGIMEN FISCAL</label>
                     <p class="form-control-static">{{$facturaG->emisor_regimen_fiscal}}</p>
                </div>
                    <div class="form-group col-sm-3">
                     <label for="usu_alta_id">ALTA</label>
                     <p class="form-control-static">{{$facturaG->usu_alta->name}}</p>
                </div>
                    <div class="form-group col-sm-3">
                     <label for="usu_mod_id">U. MODIFICACION</label>
                     <p class="form-control-static">{{$facturaG->usu_mod->name}}</p>
                </div>
            </form>

            <div class="row">
                </div>

            <a class="btn btn-link" href="{{ route('facturaGs.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>
            @permission('facturaGLineas.create')
            <a class="btn btn-success btn-md pull-right" href="{{ route('facturaGLineas.create', array('factura_g'=>$facturaG->id)) }}"><i class="glyphicon glyphicon-plus"></i> Crear </a>
            @endpermission
            
        </div>
        <div class="col-md-12">
        <table class="table table-condensed table-striped">
            <thead>
                <th>Csc.</th><th>F. Operación</th><th>Concepto</th><th>Referencia</th><th>R. Ampliada</th>
                <th>Cargo</th><th>Abono</th><th>Saldo</th><th>No. Id.</th><th>Origen</th><th>Incluir</th>
            </thead>
            <tbody>
                @php
                    $i=0;
                    $suma=0;
                @endphp
                @foreach($facturaG->facturaGLineas as $linea)
                <tr>
                    <td>{{ ++$i }}</td>
                    <td>{{ $linea->fecha_operacion }}</td><td>{{ $linea->concepto }}</td><td>{{ $linea->referencia }}</td><td>{{ $linea->referencia_ampliada }}</td>
                    <td>{{ $linea->cargo }}</td><td>{{ $linea->abono }}</td><td>{{ $linea->saldo }}</td>
                    <td>
                        
                        @if($linea->bnd_incluido==1)

                        <div class='editable'>
                            @if(!is_null($linea->folio))
                            {{ $linea->folio }}
                            @else
                            Asignar
                            @endif
                            
                            <input class='noIdentificacion_editable form-control' value='{{$linea->folio}}' data-id="{{$linea->id}}"></input>
                        </div>
                        
                            
                        @endif
                    </td>
                    <td>{{ $linea->origen }}</td>
                    <td>
                        @if($linea->origen<>"Manual" and $linea->abono<>0)
                            <input class="bnd_incluir" data-id_linea={{ $linea->id }} type="checkbox" 
                            @if($linea->bnd_incluido==1)
                            checked
                            @endif
                            value="1">
                        @endif    
                        @if($linea->bnd_incluido==1)
                        <label>Si</label>
                        @else
                        <label>No</label>
                        @endif
                            
                            <div class='loading' style='display: none'><img src="{{ asset('images/ajax-loader.gif') }}" title="Enviando" /></div>    
                            
                            @if($linea->origen=="Manual")
                            @permission('facturaGLineas.destroy')
                                {!! Form::model($linea, array('route' => array('facturaGLineas.destroy', $linea->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? ¿Esta seguro?')) { return true } else {return false };")) !!}
                                    <button type="submit" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i> </button>
                                {!! Form::close() !!}
                            @endpermission
                            @endif
                    </td>
                </tr>
                   @php
                        if($linea->bnd_incluido==1){
                            $suma=$suma+$linea->abono;
                        }
                        
                    @endphp
                @endforeach
                <tr>
                    <td colspan="6" align="right">Suma Total</td>
                    <td align="right">{{ number_format($suma,2) }}</td>
                    <td colspan="2">
                        <a href="{{ route('facturaGs.total', array('id'=>$facturaG->id)) }}" class="btn btn-xs btn-warning btn-block" >Guardar y Recalcular</a>
                    </td>
                </tr>
                <tr>
                    <td colspan="5"></td>
                    <td>
                        @permission('facturaGs.solicitarFactura')
                        <a href="{{ route('facturaGs.solicitarFactura', array('id'=>$facturaG->id)) }}"  class="btn btn-xs btn-default btn-block" >Descargar Factura PDF</a>
                        @endpermission
                    </td>

                    <td colspan="1">
                        @permission('facturaGs.descargarFactura')
                        <a href="{{ route('facturaGs.descargarFactura', array('id'=>$facturaG->id)) }}"  class="btn btn-xs btn-info btn-block" >Descargar XML</a>
                        @endpermission
                    </td>
                    <td colspan="1">
                        @permission('facturaGs.generarFactura')
                        <a href="{{ route('facturaGs.generarFactura', array('id'=>$facturaG->id)) }}"  class="btn btn-xs btn-success btn-block" >Generar Factura</a>
                        @endpermission
                    </td>
                </tr>
            </tbody>
        </table>
        </div>
    </div>
    @push('scripts')
    <script type="text/javascript">
    $('.noIdentificacion_editable').hide();
    $('.editable').dblclick(function(){
    //console.log('qui fl');
    captura=$(this).children("input");
    //console.log(captura);
    captura.show();
    });

    $('.noIdentificacion_editable').on('keypress', function (e) {
         if(e.which === 13){
             captura=$(this);
           $.ajax({
                type: 'GET',
                        url: '{{route("facturaGLineas.editFolio")}}',
                        data: {
                            'id': captura.attr('data-id'),
                            'noIdentificacion': captura.val(),
                        },
                        dataType:"json",
                        beforeSend : function(){$(".loading").show(); },
                        complete : function(){$(".loading").hide(); },
                        success: function(data) {
                            location.reload(); 
                           
                        }
                }); 
            }
        });

    $(document).on("click", ".bnd_incluir", function (e) {
        
        linea=$(this).data('id_linea');
        let valor=0;
        if($(this).is(':checked')){
            valor=1;
            
        }
        
        $.ajax({
            url: "{{ route('facturaGLineas.bndIncluir') }}",
            type: 'GET',
            data: {'id':linea,
                  'valor':valor},
            cache: false,
            beforeSend: function () {  
                $(".loading").show();
                 
            },
            complete:function(){
                $(".loading").hide(); 
            },
            success: function (data) {
                
            },
            //si ha ocurrido un error
            error: function (data) {
    
    
            }
        });

        
    })
    
    </script>
    @endpush
@endsection