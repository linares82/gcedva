<html>

<head>
    <style>
        @media print {
            thead {
                display: table-header-group;
                /* Para repetir el encabezado de tabla en cada página */
            }

            table {
                font-family: arial, sans-serif;
                border-collapse: collapse;
                width: 100%;
                font-size: 10px;
            }

            td,
            th {
                border: 1px solid #dddddd;
                text-align: center;
                padding: 10px;
            }

            tr:nth-child(even) {
                background: #dae5f4;
            }

            tr:nth-child(odd) {
                background: #fff;
            }

            tr {
                font-size: 8px;
                padding: 0px 0px;
                border: 1px solid #dddddd;
            }

            .SaltoDePagina {
            page-break-after: always;
        }

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
        .SaltoDePagina {
            page-break-after: always;
        }
        table {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
            font-size: 10px;
        }

        .verticalText {
            writing-mode: vertical-lr;
            transform: rotate(90deg);
        }

        body {
            font-family: arial, sans-serif;
        }

        h1,
        h3,
        h5,
        th {
            text-align: center;
        }

        th {
            font-size: 10px;
            max-width: 400px;
            padding: 2px 5px;
            border: 1px solid #dddddd;
        }

        td {
            font-size: 10px;
            padding: 2px 10px;
            color: #000;
            border: 1px solid #dddddd;
        }

        tr {
            background: #b8d1f3;
            border: 1px solid #dddddd;
        }

        tr:nth-child(even) {
            background: #dae5f4;
        }

        tr:nth-child(odd) {
            background: #fff;
        }
    </style>

</head>

<body>
    @php
        $emisiones = explode(',', $formatoDgcft->fechas_emision);
        //dd($emisiones);
    @endphp
    @foreach ($emisiones as $emision)
        @php
            $iteracion_emision = $loop->index;
            $consecutivo_control = $formatoDgcft->control_inicio;
        @endphp
        @if ($loop->first)
            <div id="printeArea" class='SaltoDePagina'>
                @include('formatoDgcfts.reportes.riap02.encabezado_first')
                @include('formatoDgcfts.reportes.riap02.encabezado_tabla')
                    @php 
                    $i = 1;
                    $contador_registros=0;
                    $registros_por_hoja=25;
                    $total_registros_actuales=count($formatoDgcft->formatoDgcftDetalles->where('bnd_satisfactorio',1));
                    //dd($total_registros_actuales);
                    //dd($formatoDgcft->formatoDgcftDetalles->toArray());
                    @endphp
                    @foreach ($formatoDgcft->formatoDgcftDetalles->where('bnd_satisfactorio',1) as $registro)
                        @if ($registro->bnd_satisfactorio == 1)
                            <tr>
                                <td>{{ $i++ }}</td>
                                <td>
                                    {{ $formatoDgcft->control_parte_fija }}{{ $registro->control }}
                                </td>
                                <td>{{ $registro->nombre }}</td>
                                <td>
                                    {{ $registro->edad }}
                                </td>
                                <td>{{ $registro->fec_sexo }}</td>
                                <td>{{ $registro->escolaridad }}</td>
                                <td>{{ $registro->beca }}</td>
                                @foreach ($materias as $materia)
                                    <td>
                                        -
                                    </td>
                                @endforeach
                                <td>-</td>
                                <td>-</td>
                            </tr>
                            @php
                                $contador_registros++;
                            @endphp
                        @endif
                        @if($total_registros_actuales<$registros_por_hoja)
                            @if($contador_registros==$total_registros_actuales)
                                @while($contador_registros<$registros_por_hoja)
                                    <tr height="25px">
                                    <td>{{ $i++ }}</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td><td></td><td></td>
                                    @foreach($materias as $materia)
                                        <td>
                                        </td>
                                    @endforeach
                                    <td></td>
                                    <td></td>
                                </tr>
                                @php
                                    $contador_registros++;
                                @endphp
                                @endwhile
                            @endif
                        @endif
                        @if($contador_registros==$registros_por_hoja and $total_registros_actuales>$registros_por_hoja)
                            @include('formatoDgcfts.reportes.riap02.pie_tabla')
                            @include('formatoDgcfts.reportes.riap02.pie_first')                
                            <div class='SaltoDePagina'></div>
                            @include('formatoDgcfts.reportes.riap02.encabezado_first')
                            @include('formatoDgcfts.reportes.riap02.encabezado_tabla')
                            @php
                                $contador_registros=0;    
                            @endphp
                        @endif
                        
                    @endforeach
                    
                @include('formatoDgcfts.reportes.riap02.pie_tabla')
                @include('formatoDgcfts.reportes.riap02.pie_first')

            </div>
        @else
            <div id="printeArea" class='SaltoDePagina'>
                @include('formatoDgcfts.reportes.riap02.encabezado')
                @include('formatoDgcfts.reportes.riap02.encabezado_tabla')
                    @php 
                    $i = 1;
                    $contador_registros=0;
                    $registros_por_hoja=25;
                    $total_registros_actuales=count($formatoDgcft->formatoDgcftDetalles->where('bnd_satisfactorio',1));
                    //dd($total_registros_actuales);
                    @endphp            
                
                    @foreach ($formatoDgcft->formatoDgcftDetalles->where('bnd_satisfactorio',1) as $registro)
                        @if ($registro->bnd_satisfactorio == 1)
                            <tr>
                                <td>{{ $i++ }}</td>
                                <td>
                                    {{ $formatoDgcft->control_parte_fija }}{{ $registro->control }}
                                </td>
                                <td>{{ $registro->nombre }}</td>
                                <td>
                                    {{ $registro->edad }}
                                </td>
                                <td>{{ $registro->fec_sexo }}</td>
                                <td>{{ $registro->escolaridad }}</td>
                                <td>{{ $registro->beca }}</td>

                                @foreach ($materias as $materia)
                                    @if ($loop->iteration == $iteracion_emision)
                                        <?php
                                        $calificacion = App\FormatoDgcftMatCalif::where('sep_materia_id', trim($materia->sep_materia_id))
                                            ->where('formato_dgcft_detalle_id', $registro->id)
                                            ->first();
                                        ?>
                                        <td>
                                            @php

                                            @endphp
                                            @if (!is_null($calificacion))
                                                {{ round($calificacion->calificacion) }}
                                            @endif
                                        </td>
                                    @else
                                        <td>-</td>
                                    @endif
                                @endforeach
                                @foreach ($materias as $materia)
                                    @if ($loop->iteration == $iteracion_emision)
                                        <?php
                                        $calificacion = App\FormatoDgcftMatCalif::where('sep_materia_id', trim($materia->sep_materia_id))
                                            ->where('formato_dgcft_detalle_id', $registro->id)
                                            ->first();
                                        ?>
                                        <td>
                                            @if (!is_null($calificacion))
                                                {{ round($calificacion->calificacion) }}
                                            @endif
                                        </td>
                                    @endif
                                @endforeach
                                @foreach ($materias as $materia)
                                    @if ($loop->iteration == $iteracion_emision)
                                        <?php
                                        $calificacion = App\FormatoDgcftMatCalif::where('sep_materia_id', trim($materia->sep_materia_id))
                                            ->where('formato_dgcft_detalle_id', $registro->id)
                                            ->first();
                                        ?>
                                        <td>
                                            @if (!is_null($calificacion))
                                                {{ round($calificacion->calificacion) }}
                                            @endif
                                        </td>
                                    @endif
                                @endforeach
                            </tr>
                            @php
                                $contador_registros++;
                            @endphp
                        @endif
                        @if($total_registros_actuales<$registros_por_hoja)
                            @if($contador_registros==$total_registros_actuales)
                                @while($contador_registros<$registros_por_hoja)
                                    <tr height="25px">
                                    <td>{{ $i++ }}</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td><td></td><td></td>
                                    @foreach($materias as $materia)
                                        <td>
                                        </td>
                                    @endforeach
                                    <td></td>
                                    <td></td>
                                </tr>
                                @php
                                    $contador_registros++;
                                @endphp
                                @endwhile
                            @endif
                        @endif
                        @if($contador_registros==$registros_por_hoja and $total_registros_actuales>$registros_por_hoja)
                            @include('formatoDgcfts.reportes.riap02.pie_tabla')
                            @include('formatoDgcfts.reportes.riap02.pie_first')                
                            <div class='SaltoDePagina'></div>
                            @include('formatoDgcfts.reportes.riap02.encabezado_first')
                            @include('formatoDgcfts.reportes.riap02.encabezado_tabla')
                            @php
                                $contador_registros=0;    
                            @endphp
                        @endif    
                    @endforeach
                @include('formatoDgcfts.reportes.riap02.pie_tabla')
                @include('formatoDgcfts.reportes.riap02.pie')

            </div>
        @endif


    @endforeach

    <script type="text/php">
            /*if (isset($pdf))
            {
            $font = Font_Metrics::get_font("Arial", "bold");
            $pdf->page_text(670, 580, "Pagina {PAGE_NUM} de {PAGE_COUNT}", $font, 9, array(0, 0, 0));
            }*/
        </script>

</body>

</html>
