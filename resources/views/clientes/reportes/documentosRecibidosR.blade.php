<html>
    <head>
        <style>
            @media print {
                table {
                    font-family: arial, sans-serif;
                    border-collapse: collapse;
                    width: 100%;
                    font-size: 10px;
                }

                td, th {
                    border: 1px solid #dddddd;
                    text-align: center;
                    padding: 10px;
                }

                tr:nth-child(even) { background: #dae5f4; }
                tr:nth-child(odd) { background: #fff; }
            }
/* 
            table {
                font-family: arial, sans-serif;
                border-collapse: collapse;
                width: 100%;
                font-size: 8px;
            }

            td th {
                border: 1px solid #dddddd;
                text-align: left;
                padding: 8px;
            }
            
            .altura {
                height: 100px;
            }
            
            .girar_texto {
                
                text-align: center;
                padding: 8px;
                transform: rotate(270deg);
                height: auto;
                
            }
            
            .centrar_texto {
                text-align: center;
                padding: 8px;
            }
            tr:nth-child(even) {
                background-color: #dddddd;
            }*/
        .SaltoDePagina
         {
          page-break-after: always;
          width:1200px;
          padding:10px;

         }
         
        .verticalText {
            writing-mode: vertical-lr;
            transform: rotate(90deg);
        } 
         
         body{
             font-family: arial, sans-serif;
         }
        h1, h3, h5, th { text-align: center; }
       
        th { font-size: 10px; max-width: 400px; padding: 2px 5px; border: 1px solid #dddddd;}
        td { font-size: 10px; padding: 2px 10px; color: #000; border: 1px solid #dddddd;}
        tr { background: #b8d1f3; border: 1px solid #dddddd;}
        tr:nth-child(even) { background: #dae5f4; }
        tr:nth-child(odd) { background: #fff; }
      
        </style>

    </head>
    <body>
        
        <div id="printeArea" class='SaltoDePagina'>
                <h3>Lista de Documentos recibidos</h3>
                {!! Form::open(array('route' => 'clientes.docRecibidosManual')) !!}
            <table>
                <tr>
                    <th>No.</th><th>Plantel</th><th><strong>Id</strong></th><th>S. cliente</th>
                    <th>S. Seguimiento</th>
                    <th><strong>Cliente</strong></th>
                    <th colspan="2">Doc. Recibidos
                        <label>*<input type="checkbox" id="seleccionar_todo">Seleccionar Todo</label>
                    </th>
                    <th>T. Recibido</th><th><strong>D. Recibidos</strong></th>
                </tr>
                @php
                    $i=1;
                @endphp
                
                @foreach($documentos_recibidos as $documento_recibido)
                    <tr>
                    <td>{{$i++}}</td><td>{{$documento_recibido['plantel']}}</td>
                    <td><a href="{{ route('clientes.edit',$documento_recibido['cliente']) }}" target="_blank"> {{$documento_recibido['cliente']}} </a> </td>
                    <td>{{$documento_recibido['estatus_cliente']}}</td><td>{{$documento_recibido['estatus_seguimiento']}}</td>
                    <td>{{$documento_recibido['nombre']}}</td><td>@if($documento_recibido['doc_recibidos']==1) SI @else NO @endif </td>
                    <td>
                        {{ Form::checkbox('clientes[]', $documento_recibido['cliente'], false, array('class'=>'marcarRecibido')) }}
                    </td>
                    <td>{{$documento_recibido['total_documentos']}}</td>
                    <td>
                        @if($documento_recibido['total_documentos']<>0)
                        <table>
                            <thead>
                                <th>Documento</th><th>Obligatorio</th>
                            </thead>
                            <tbody>
                                @foreach($documento_recibido['documentos'] as $doc_detalle)
                                <tr>            
                                    <td>{{ $doc_detalle['name'] }}</td>
                                    <td>
                                        @if($doc_detalle['doc_obligatorio']==1)
                                        SI
                                        @else
                                        NO
                                        @endif
                                        
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @endif
                    </td>
                    </tr>
                @endforeach

                
            </table>
            <div class="well well-sm">
                <button type="submit" class="btn btn-primary">Procesar</button>
            </div>
            {!! Form::close() !!}
            
            
        </div>
        <!-- jQuery 2.1.4 -->
        <script src="{{ asset ('/bower_components/AdminLTE/plugins/jQuery/jQuery-2.1.4.min.js') }}"></script>
        <script type="text/javascript">
            $('#seleccionar_todo').change(function(){
            if( $(this).is(':checked') ) {
                
            	$(".marcarRecibido").click();
            }else{
                
            	$(".marcarRecibido").removeAttr("checked","false");
            }
        });
        </script>

    </body>
</html>

