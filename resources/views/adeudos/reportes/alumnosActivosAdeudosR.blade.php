<html>

<head>
    <link href="{{asset('bower_components\AdminLTE\plugins\webdatarocks\webdatarocks.min.css')}}" rel="stylesheet" />

    <style>
        @media print {
            table {
                border-collapse: collapse;
                width: 100%;
            }

            th,
            td {
                text-align: left;
                padding: 8px;
                font: normal 12px Arial, Helvetica, sans-serif;
                border: solid 1px #FE9A2E;
            }

            tr:nth-child(even) {
                background-color: #f2f2f2
            }

            th {
                background-color: #FE9A2E;
                color: white;
                font-weight: bold;
            }
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th,
        td {
            text-align: center;
            padding: 8px;
            font: normal 12px Arial, Helvetica, sans-serif;
            border: solid 1px #FE9A2E;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2
        }

        th {
            background-color: #FE9A2E;
            color: white;
        }

        body {
            font: normal 10px Arial, Helvetica, sans-serif;
        }

        .jefe {
            text-align: center;
            padding: 8px;
            font: normal 12px Arial, Helvetica, sans-serif;
            border: solid 1px #15B90D;
        }

        .th-jefe {
            background-color: #15B90D;
            color: white;
        }
    </style>

</head>

<body>

    <table border="0" width="100%">
        <td border="0" align="center">
            <h3>
                Pagos y Adeudos
            </h3>
        </td>
    </table>

    <div class="datagrid">
        <table border="1" width="100%">
            <thead>
                <th><strong>No.</strong></th>
                <th><strong>Plantel</strong></th>
                <th><strong>Ciclo</strong></th>
                <th><strong>Id</strong></th>
                <th><strong>Matricula</strong></th>
                <th><strong>Seccion</strong></th>
                <th><strong>Grupo</strong></th>
                <th><strong>Nombre</strong></th>
                <th><strong>Cuota</strong></th>
                <th><strong>Estatus </strong></th>
                <th><strong>Concepto</strong></th>
                <th><strong>Pagado</strong></th>
                <th><strong>Pago</strong></th>
                <th><strong>Adeudo</strong></th>
            </thead>
            <tbody>
                @php
                $i=0;
                $suma_pagos=0;
                $suma_adeudos=0;
                $suma_planeada=0;
                $suma_concepto_pagos=0;
                $suma_concepto_adeudos=0;
                $suma_concepto_planeada=0;
                $concepto="";
                $cliente="";
                @endphp
                @foreach($registros as $registro)
 
                    @if($concepto<>$registro->concepto and $concepto<>"")
                        <tr>
                            <td colspan="8">Totales {{$concepto}}</td>
                            <td>{{number_format($suma_concepto_planeada, 2) }}</td>
                            <td colspan="3"></td>
                            <td>{{number_format($suma_concepto_pagos, 2)}}</td>
                            <td>{{number_format($suma_concepto_adeudos, 2)}}</td>
                        </tr>
                        @php
                        $suma_concepto_pagos=0;
                        $suma_concepto_adeudos=0;
                        $suma_concepto_planeada=0;
                        @endphp
                        <thead>
                            <th><strong>No.</strong></th>
                            <th><strong>Plantel</strong></th>
                            <th><strong>Ciclo</strong></th>
                            <th><strong>Id</strong></th>
                            <th><strong>Matricula</strong></th>
                            <th><strong>Seccion</strong></th>
                            <th><strong>Grupo</strong></th>
                            <th><strong>Nombre</strong></th>
                            <th><strong>Cuota</strong></th>
                            <th><strong>Estatus </strong></th>
                            <th><strong>Concepto</strong></th>
                            <th><strong>Pagado</strong></th>
                            <th><strong>Pago</strong></th>
                            <th><strong>Adeudo</strong></th>
                        </thead>
                    @endif
			
                    @if( $cliente<>$registro->cliente_id)
                        <tr>
                            <td>{{++$i}}</td>
                            <td>{{$registro->razon}}</td>
                            <td>{{$registro->periodo_escolar}} - {{$registro->ciclo_escolar}}</td>
                            <td>{{$registro->cliente_id}}</td>
                            <td>{{$registro->matricula}}</td>
                            <td>{{$registro->seccion}}</td>
                            <td>{{$registro->grupo}}</td>
                            <td>{{$registro->ape_paterno}} {{$registro->ape_materno}} {{$registro->nombre}} {{$registro->nombre2}}</td>
                            <td>{{number_format($registro->monto,2)}}</td>
                            <td>{{$registro->st_cliente}}</td>
                            <td>{{$registro->concepto}}</td>
                            @php
                            $pago=App\Pago::where('caja_id',$registro->caja_id)->sum('monto');
                            @endphp
                            <td>{{$registro->pagado_bnd}}</td>
                            <td>{{$registro->pagado_bnd=='SI' ? number_format($pago,2) : ''}}</td>
                            <td>{{$registro->pagado_bnd<>'SI' ? number_format($registro->monto,2) : ''}}</td>
                        </tr>
                        @php
                        $concepto=$registro->concepto;
                        if($registro->pagado_bnd=='SI'){
                        $suma_pagos=$suma_pagos+$pago;
                        }else{
                        $suma_adeudos=$suma_adeudos+$registro->monto;
                        }
                        $suma_planeada=$suma_planeada+$registro->monto;
                        if($registro->pagado_bnd=='SI'){
                        $suma_concepto_pagos=$suma_concepto_pagos+$pago;
                        }else{
                        $suma_concepto_adeudos=$suma_concepto_adeudos+$registro->monto;
                        }
                        $suma_concepto_planeada=$suma_concepto_planeada+$registro->monto;
                        $cliente=$registro->cliente_id;
                        @endphp
                    @endif
                @endforeach
                        <tr>
                            <td colspan="8">Totales {{$concepto}}</td>
                            <td>{{number_format($suma_concepto_planeada, 2) }}</td>
                            <td colspan="3"></td>
                            <td>{{number_format($suma_concepto_pagos, 2)}}</td>
                            <td>{{number_format($suma_concepto_adeudos, 2)}}</td>
                        </tr>
                        <tr>
                            <td colspan="8">Totales</td>
                            <td>{{number_format($suma_planeada, 2) }}</td>
                            <td colspan="3"></td>
                            <td>{{number_format($suma_pagos, 2)}}</td>
                            <td>{{number_format($suma_adeudos, 2)}}</td>
                        </tr>
            </tbody>
        </table>

    </div>



    <h3>Cuenta de Estatus</h3>
    <div id="dinamica_conteo_estatus"></div>
    <h3>Cuenta de Montos Planeados</h3>
    <div id="dinamica_suma_montos_planeados"></div>

    <script src="{{asset('bower_components\AdminLTE\plugins\webdatarocks\webdatarocks.toolbar.min.js')}}"></script>
    <script src="{{asset('bower_components\AdminLTE\plugins\webdatarocks\webdatarocks.js')}}"></script>
    <script type="text/javascript">
        function customizeToolbar(toolbar) {
            var tabs = toolbar.getTabs(); // get all tabs from the toolbar
            toolbar.getTabs = function() {
                //delete tabs[0]; // delete the first tab
                // tabs[1];
                //delete tabs[2];
                return tabs;
            }
        }

        var pivot = new WebDataRocks({
            container: "#dinamica_conteo_estatus",
            beforetoolbarcreated: customizeToolbar,
            toolbar: true,
            report: {
                dataSource: {
                    data: <?php echo $registros; ?>,
                },
                "slice": {
                    "rows": [{
                            "uniqueName": "razon"
                        },
                        {
                            "uniqueName": "concepto"
                        },
                        {
                            "uniqueName": "pagado_bnd"
                        }
                    ],
                    "columns": [{
                            "uniqueName": "Measures"
                        },
                        {
                            "uniqueName": "st_cliente"
                        }
                    ],
                    "measures": [{
                        "uniqueName": "st_cliente",
                        "aggregation": "count",
                        "availableAggregations": [
                            "count",
                            "distinctcount"
                        ]
                    }],
                    "expands": {
                        "rows": [{
                                "tuple": [
                                    "razon.ECATEPEC GASTRONOMIA BACHILLERATO Y TÃ‰CNICOS 75"
                                ]
                            },
                            {
                                "tuple": [
                                    "razon.ECATEPEC GASTRONOMIA BACHILLERATO Y TÃ‰CNICOS 75",
                                    "concepto.MENSUALIDAD NOVIEMBRE"
                                ]
                            }
                        ]
                    }
                }
            },
            global: {
                // replace this path with the path to your own translated file
                localization: {
                    "fieldsList": {
                        "flatHierarchyBox": "Seleccionar y organizar columnas",
                        "hierarchyBox": "Seleccionar dimensiones",
                        "filterBox": "Filtros del Informe",
                        "rowBox": "Coloque y Organize Filas",
                        "columnBox": "Coloque y Organize Columnas",
                        "measureBox": "Coloque y Organize Valores",
                        "values": "Valores",
                        "allFields": "Todos los campos",
                        "rows": "Filas",
                        "columns": "Columnas",
                        "filters": "Filtros",
                        "dropField": "Campo de caída aquí",
                        "addCalculatedMeasure": "Agregar medida calculada",
                        "expandAll": "+ Abre todos",
                        "collapseAll": "- Contraer Todo",
                        "formulasGroupName": "Valores calculados",
                        "title": "Campos",
                        "subtitle": "Arrastrar y soltar campos para organizar"
                    },
                    "filter": {
                        "ascSort": "Az",
                        "descSort": "zA",
                        "topX": "Top10",
                        "clearTopX": "Clear Top10",
                        "top": "Superior",
                        "bottom": "Fondo",
                        "measuresPrompt": "Seleccione la medida",
                        "search": "Búsqueda",
                        "selectAll": "Seleccionar todo",
                        "selectAllResults": "Seleccione todos los resultados",
                        "amountSelected": "{0} de {1} selecionados",
                        "amountFound": "{0} de {1} encontrado se seleccionan",
                        "multipleItems": "Artículos múltiples",
                        "all": "Todo",
                        "sort": "Sort:",
                        "addGroup": "Añadir grupo",
                        "groupName": "Grupo 1",
                        "ungroup": "Desagrupar"
                    },
                    "drillThrough": {
                        "title": "Detalles",
                        "row": "Fila: {0}",
                        "column": "Columna: {0}",
                        "value": "{0}: {1}"
                    },
                    "calculatedView": {
                        "title": "Valor calculado",
                        "measureBox": "Arrastre medidas a la formula",
                        "measureName": "Nombre de Medida",
                        "formula": "Fórmula",
                        "formulaPrompt": "Eliminar valores y editar fórmula aquí",
                        "calculateIndividualValues": "Calcular los valores individuales",
                        "removeValue": "Retirar",
                        "removeValueTitle": "Retirar {0}?",
                        "removeValueMessage": "Seguro que desea eliminar este valor calculado?",
                        "header": "Añadir valor calculado",
                        "allValues": "Todos los valores"
                    },
                    "grid": {
                        "total": "Total",
                        "totals": "Totales",
                        "grandTotal": "Total",
                        "blankMember": "(blanco)",
                        "dateInvalidCaption": "Invalid date",
                        "reportInformation": "Report Information"
                    },
                    "charts": {
                        "showLegend": "mostrar leyenda",
                        "hideLegend": "esconder leyenda",
                        "selectMeasures": "Select measures",
                        "rowNumber": "Row number",
                        "bigDataSetWarning": "Data set is too big to be displayed on the chart. Data set will be cut off to the amount fitting into the chart.",
                        "flatTypesLimitation": "Bar stack and bar line charts are not available for flat table.",
                        "noDataTitle": "No data to display."
                    },
                    "tooltips": {
                        "row": "Fila:",
                        "column": "Columna:",
                        "headerResize": "Arrastrar para redimensionar",
                        "headerFit": "Doble click para ajustar",
                        "filterIcon": "Click para filtrar",
                        "filtered": "Filtrado",
                        "expandIcon": "Click para expandir",
                        "collapseIcon": "Click para plegarse",
                        "drillDown": "Click to drill down",
                        "drillUp": "Click to drill up",
                        "sortIcon": "Click para ordenacion descendente",
                        "sortedDescIcon": "Ordenar ascendente",
                        "sortedAscIcon": "Ordenar descendente",
                        "close": "Click para cerrar"
                    },
                    "aggregations": {
                        "average": {
                            "caption": "Media",
                            "totalCaption": "Media de {0}",
                            "grandTotalCaption": "Total Media de {0}"
                        },
                        "count": {
                            "caption": "Conteo",
                            "totalCaption": "Conteo de {0}",
                            "grandTotalCaption": "Total conteo de {0}"
                        },
                        "difference": {
                            "caption": "La diferencia",
                            "totalCaption": "La diferencia de {0}",
                            "grandTotalCaption": "Total La diferencia de {0}"
                        },
                        "distinctCount": {
                            "caption": "Distinto conteo",
                            "totalCaption": "Distinto conteo de {0}",
                            "grandTotalCaption": "Distinto conteo de {0}"
                        },
                        "index": {
                            "caption": "Índice",
                            "totalCaption": "Índice de {0}",
                            "grandTotalCaption": "Índice de {0}"
                        },
                        "max": {
                            "caption": "Máximo",
                            "totalCaption": "Maximo de {0}",
                            "grandTotalCaption": "Total máximo de {0}"
                        },
                        "min": {
                            "caption": "Mínimo",
                            "totalCaption": "Minimo de {0}",
                            "grandTotalCaption": "Total mínimo de {0}"
                        },
                        "none": {
                            "caption": "No Calculation"
                        },
                        "percent": {
                            "caption": "Porcentaje",
                            "totalCaption": "Porcentaje de {0}",
                            "grandTotalCaption": "Total Porcentaje de {0}"
                        },
                        "percentDifference": {
                            "caption": "Porcentaje de diferencia",
                            "totalCaption": "Porcentaje de diferencia {0}",
                            "grandTotalCaption": "Total porcentaje de diferencia {0}"
                        },
                        "percentOfColumn": {
                            "caption": "Porcentaje de columna",
                            "totalCaption": "Porcentaje de columna {0}",
                            "grandTotalCaption": "Total Porcentaje de columna {0}"
                        },
                        "percentOfRow": {
                            "caption": "% of Row",
                            "totalCaption": "% of Row of {0}",
                            "grandTotalCaption": "Total % of Row of {0}"
                        },
                        "product": {
                            "caption": "Producto",
                            "totalCaption": "Producto de {0}",
                            "grandTotalCaption": "Total producto de {0}"
                        },
                        "sum": {
                            "caption": "Suma",
                            "totalCaption": "Suma de {0}",
                            "grandTotalCaption": "Total Suma de {0}"
                        }
                    },
                    "messages": {
                        "error": "Error!",
                        "warning": "Precaución",
                        "limitation": "Limitation!",
                        "browse": "Explorar",
                        "confirmation": "Confirmación",
                        "reportFileType": "Flexmonster report file",
                        "loading": "Cargando...",
                        "loadingConfiguration": "Cargando configuración...",
                        "loadingData": "Cargando datos...",
                        "uploading": "Actualizando el servidor...",
                        "waiting": "{0} seg",
                        "progress": "{0}К of {1}К",
                        "progressUnknown": "leído {0}К",
                        "analyzing": "Analizando datos...",
                        "analyzingProgress": "{0} registros de {1} ({2}%)",
                        "analyzingRecords": "{0}% records",
                        "saving": "Saving...",
                        "loadingDimensions": "Cargando dimensiones...",
                        "loadingHierarchies": "Cargando jerarquias...",
                        "loadingMeasures": "Cargando medidas...",
                        "loadingKPIs": "Loading KPIs...",
                        "loadingMembers": "Cargando grupos...",
                        "loadingProperties": "Loading properties...",
                        "loadingLevels": "Cargando niveles...",
                        "fullscreen": "Desea abrirlo en pantalla completa?",
                        "exportComplete": "La exportación de datos ha sido creada, por favor pulse el boton \"Guardar\" para guardar los datos.",
                        "generatingPDF": "Generando PDF",
                        "pleaseWait": "Por favor, espere.",
                        "pagesWereGenerated": "páginas se generaron.",
                        "exportProgress": "Exportación en progreso...",
                        "exportError": "Failed to export. An unexpected error occurred.",
                        "cantSaveFile": "Error: No se puede guardar el fichero.",
                        "cantSaveToClipboard": "Error: No puedo escribir en el portapapeles.",
                        "saveReportToFile": "Informe está listo para ser guardados en un archivo, haga clic en \"Guardar\" para guardar el informe.",
                        "saveDataToFile": "Data is ready to be saved to file, please click \"Save\" button to save the file.",
                        "loadReportFromFile": "Seleccione el fichero de informe para ser cargado",
                        "inputNewName": "Entrada de un nuevo nombre",
                        "inputReportName": "Por favor, introducir el nombre de informe",
                        "invalidDataSource": "Invalid datasource or catalog. Please check. <br/><br/><u><a href='https://www.flexmonster.com/doc/typical-errors/#invalid-datasource' target='_blank'>Read more info about this error</a></u>",
                        "dataStreamError": "Stream error occurred while loading '{0}'<br/><br/><u><a href='https://www.flexmonster.com/doc/typical-errors/#stream-error' target='_blank'>Read more info about this error</a></u>",
                        "unableToOpenFile": "Unable to open file {0}.<br/><br/>It seems that this file doesn't exist or 'Access-Control-Allow-Origin' header is absent in the resource requested.<br/><br/><u><a href='https://www.flexmonster.com/doc/typical-errors/#unable-to-open-file' target='_blank'>Read more info about this error</a></u>",
                        "unableTwoFileBrowsingSessions": "Browse file dialog is already opened.",
                        "wrongFormulaFormat": "Wrong formula format. Please check.",
                        "inappropriateFileFormat": "The data file is of inappropriate format.",
                        "invalidJSONdata": "JSON data is invalid.",
                        "excelCsvChartsExportError": "Export to Microsoft Excel or CSV is not available for charts.",
                        "excelPdfExportLimitation": "Export to Microsoft Excel or PDF is not available in the current edition.",
                        "excelExportLimitation": "Export is not available in the current edition.",
                        "noDataAvailable": "Data source is empty. Please check the CSV file.",
                        "csvHeaderParsingError": "CSV header parsing error.",
                        "dataWasUpdated": "Data source has been updated on the server. Refresh the report?",
                        "cantConnectToAccelerator": "Cannot connect to data source. Please check if Flexmonster Accelerator is running.",
                        "ocsvIncompatible": "Unable to read data source. It seems that OCSV file was compressed with a newer version. Please update the component to version {0} or newer.",
                        "unknownError": "Unknown error occurred.",
                        "invalidReportFormat": "Invalid report format or access to file is denied.",
                        "tooManyColumnsInClassicMode": "Too many columns for classic form. Switched layout to compact form.",
                        "loadingSkin": "Cargando estilo... {0}%",
                        "selectFile": "Seleccione el fichero .CSV para cargar"
                    },
                    "kpis": {
                        "kpis": "KPIs",
                        "value": "Value",
                        "goal": "Goal",
                        "trend": "Trend",
                        "status": "Status"
                    },
                    "buttons": {
                        "ok": "OK",
                        "apply": "Aplicar",
                        "cancel": "Cancelar",
                        "save": "Guardar",
                        "clear": "Claro",
                        "select": "Explorar...",
                        "yes": "Yes",
                        "no": "No"
                    },
                    "contextMenu": {
                        "drillThrough": "Drill through",
                        "openFilter": "Open filter",
                        "collapse": "Collapse",
                        "expand": "Expand",
                        "sortRowDesc": "Sort row desc",
                        "sortRowAsc": "Sort row asc",
                        "clearSorting": "Clear sorting",
                        "sortColumnDesc": "Sort column desc",
                        "sortColumnAsc": "Sort column asc"
                    },
                    "date": {
                        "year": "Año",
                        "quarter": "Trimestre",
                        "month": "Mes",
                        "day": "Día"
                    },
                    "quarters": {
                        "q1": "Q1",
                        "q2": "Q2",
                        "q3": "Q3",
                        "q4": "Q4"
                    },
                    "months": {
                        "january": "Ene",
                        "february": "Feb",
                        "march": "Mar",
                        "april": "Abr",
                        "may": "May",
                        "june": "Jun",
                        "july": "Jul",
                        "august": "Ago",
                        "september": "Sep",
                        "october": "Oct",
                        "november": "Nov",
                        "december": "Dic"
                    },
                    "monthsShort": {
                        "january": "Jan",
                        "february": "Feb",
                        "march": "Mar",
                        "april": "Apr",
                        "may": "May",
                        "june": "Jun",
                        "july": "Jul",
                        "august": "Aug",
                        "september": "Sep",
                        "october": "Oct",
                        "november": "Nov",
                        "december": "Dec"
                    },
                    "weekdays": {
                        "first": "Sunday",
                        "second": "Monday",
                        "third": "Tuesday",
                        "fourth": "Wednesday",
                        "fifth": "Thursday",
                        "sixth": "Friday",
                        "seventh": "Saturday"
                    },
                    "weekdaysShort": {
                        "first": "Sun",
                        "second": "Mon",
                        "third": "Tue",
                        "fourth": "Wed",
                        "fifth": "Thu",
                        "sixth": "Fri",
                        "seventh": "Sat"
                    },
                    "toolbar": {
                        "connect": "Conectar",
                        "connect_local_csv": "CSV local",
                        "connect_local_ocsv": "OCSV local",
                        "connect_local_json": "JSON local",
                        "connect_remote_csv": "CSV remoto",
                        "connect_remote_csv_mobile": "CSV",
                        "connect_remote_json": "JSON remoto",
                        "connect_remote_json_mobile": "JSON",
                        "connect_olap": "OLAP (XMLA)",
                        "connect_olap_mobile": "OLAP",
                        "open": "Abierto",
                        "local_report": "Informe local",
                        "remote_report": "Informe remoto",
                        "remote_report_mobile": "Informe",
                        "save": "Salvar",
                        "load_json": "Informe JSON",
                        "grid": "Tabla",
                        "grid_flat": "Plana",
                        "grid_classic": "Clásico",
                        "grid_compact": "Compacto",
                        "charts": "Gráficos",
                        "charts_bar": "Columna",
                        "charts_bar_horizontal": "Barras",
                        "charts_line": "Linea",
                        "charts_scatter": "Dispersión",
                        "charts_pie": "Circular",
                        "charts_bar_stack": "Pila de barras",
                        "charts_bar_line": "Líneas de barras",
                        "charts_multiple": "Valores múltiples",
                        "charts_multiple_disabled": "Los valores múltiples no se aplican a ",
                        "format": "Formato",
                        "format_cells": "Formato de celdas",
                        "format_cells_mobile": "Formato",
                        "conditional_formatting": "Formato condicional",
                        "conditional_formatting_mobile": "Condicional",
                        "options": "Opciones",
                        "fullscreen": "Pantalla completa",
                        "export": "Exportar",
                        "export_print": "Imprimir",
                        "export_html": "HTML",
                        "export_csv": "CSV",
                        "export_excel": "Excel",
                        "export_image": "Image",
                        "export_pdf": "PDF",
                        "fields": "Campos",
                        "ok": "OK",
                        "apply": "Aplicar",
                        "done": "Hecho",
                        "cancel": "Cancelar",
                        "value": "Valor",
                        "delete": "Borrar",
                        "if": "Si",
                        "then": "Entonces",
                        "open_remote_csv": "Abrir CSV remoto",
                        "open_remote_json": "Abrir JSON remoto",
                        "csv": "CSV",
                        "olap_connection_tool": "Herramienta de conexión OLAP",
                        "select_data_source": "Seleccionar fuente de datos",
                        "select_catalog": "Seleccionar catálogo",
                        "select_cube": "Seleccionar cubo",
                        "proxy_url": "URL de proxy",
                        "data_source_info": "Información de fuentes de datos",
                        "catalog": "Catalogar",
                        "cube": "Cubo",
                        "credentials": "cartas credenciales",
                        "username": "Nombre de usuario",
                        "password": "Contraseña",
                        "open_remote_report": "Abrir informe remoto",
                        "choose_value": "Elegir valor",
                        "text_align": "Texto alineado",
                        "align_left": "izquierda",
                        "align_right": "derecho",
                        "none": "Ninguna",
                        "space": "(Espacio)",
                        "thousand_separator": "Mil separadores",
                        "decimal_separator": "Separador decimal",
                        "decimal_places": "Lugares decimales",
                        "currency_symbol": "Símbolo de moneda",
                        "currency_align": "La moneda se alinea",
                        "null_value": "Valor nulo",
                        "is_percent": "Formato como porcentaje",
                        "true_value": "cierto",
                        "false_value": "falso",
                        "conditional": "Condicional",
                        "add_condition": "Añadir condición",
                        "less_than": "Menos que",
                        "less_than_or_equal": "Menos que o igual a",
                        "greater_than": "Mas grande que",
                        "greater_than_or_equal": "Mayor qué o igual a",
                        "equal_to": "Igual a",
                        "not_equal_to": "No igual a",
                        "between": "Entre",
                        "is_empty": "Vacío",
                        "all_values": "Todos los valores",
                        "and": "y",
                        "and_symbole": "&",
                        "cp_text": "Texto",
                        "cp_highlight": "Realce",
                        "layout_options": "Opciones de diseño",
                        "layout": "Diseño",
                        "compact_view": "Forma compacta",
                        "classic_view": "Forma clásica",
                        "flat_view": "Forma plana",
                        "grand_totals": "Totales generales",
                        "grand_totals_off": "No mostrar los totales generales",
                        "grand_totals_on": "Mostrar totales generales",
                        "grand_totals_on_rows": "Mostrar solo para filas",
                        "grand_totals_on_columns": "Mostrar solo para columnas",
                        "subtotals": "Subtotales",
                        "subtotals_off": "No mostrar subtotales",
                        "subtotals_on": "Mostrar subtotales",
                        "subtotals_on_rows": "Mostrar solo filas subtotales",
                        "subtotals_on_columns": "Mostrar solo columnas subtotales",
                        "choose_page_orientation": "Elegir la orientación de la página",
                        "landscape": "Paisaje",
                        "portrait": "Retrato",
                        "off_for_rows_and_columns": "Desactivado para filas y columnas",
                        "on_for_rows_and_columns": "Activado para filas y columnas",
                        "on_for_rows": "Sólo para filas",
                        "on_for_columns": "Sólo para columnas",
                        "do_not_show_subtotals": "No mostrar subtotales",
                        "show_all_subtotals": "Mostrar todos los subtotales"
                    }
                }
            }
        });

        var pivot = new WebDataRocks({
            container: "#dinamica_suma_montos_planeados",
            beforetoolbarcreated: customizeToolbar,
            toolbar: true,
            report: {
                dataSource: {
                    data: <?php echo $registros; ?>,
                },
                "slice": {
                    "rows": [{
                            "uniqueName": "razon"
                        },
                        {
                            "uniqueName": "concepto"
                        },
                        {
                            "uniqueName": "pagado_bnd"
                        }
                    ],
                    "columns": [{
                            "uniqueName": "Measures"
                        },
                        {
                            "uniqueName": "st_cliente"
                        }
                    ],
                    "measures": [{
                        "uniqueName": "monto",
                        "aggregation": "sum"
                    }],
                    "expands": {
                        "rows": [{
                                "tuple": [
                                    "razon.ECATEPEC GASTRONOMIA BACHILLERATO Y TÃ‰CNICOS 75"
                                ]
                            },
                            {
                                "tuple": [
                                    "razon.ECATEPEC GASTRONOMIA BACHILLERATO Y TÃ‰CNICOS 75",
                                    "concepto.MENSUALIDAD NOVIEMBRE"
                                ]
                            }
                        ]
                    }
                }
            },
            global: {
                // replace this path with the path to your own translated file
                localization: {
                    "fieldsList": {
                        "flatHierarchyBox": "Seleccionar y organizar columnas",
                        "hierarchyBox": "Seleccionar dimensiones",
                        "filterBox": "Filtros del Informe",
                        "rowBox": "Coloque y Organize Filas",
                        "columnBox": "Coloque y Organize Columnas",
                        "measureBox": "Coloque y Organize Valores",
                        "values": "Valores",
                        "allFields": "Todos los campos",
                        "rows": "Filas",
                        "columns": "Columnas",
                        "filters": "Filtros",
                        "dropField": "Campo de caída aquí",
                        "addCalculatedMeasure": "Agregar medida calculada",
                        "expandAll": "+ Abre todos",
                        "collapseAll": "- Contraer Todo",
                        "formulasGroupName": "Valores calculados",
                        "title": "Campos",
                        "subtitle": "Arrastrar y soltar campos para organizar"
                    },
                    "filter": {
                        "ascSort": "Az",
                        "descSort": "zA",
                        "topX": "Top10",
                        "clearTopX": "Clear Top10",
                        "top": "Superior",
                        "bottom": "Fondo",
                        "measuresPrompt": "Seleccione la medida",
                        "search": "Búsqueda",
                        "selectAll": "Seleccionar todo",
                        "selectAllResults": "Seleccione todos los resultados",
                        "amountSelected": "{0} de {1} selecionados",
                        "amountFound": "{0} de {1} encontrado se seleccionan",
                        "multipleItems": "Artículos múltiples",
                        "all": "Todo",
                        "sort": "Sort:",
                        "addGroup": "Añadir grupo",
                        "groupName": "Grupo 1",
                        "ungroup": "Desagrupar"
                    },
                    "drillThrough": {
                        "title": "Detalles",
                        "row": "Fila: {0}",
                        "column": "Columna: {0}",
                        "value": "{0}: {1}"
                    },
                    "calculatedView": {
                        "title": "Valor calculado",
                        "measureBox": "Arrastre medidas a la formula",
                        "measureName": "Nombre de Medida",
                        "formula": "Fórmula",
                        "formulaPrompt": "Eliminar valores y editar fórmula aquí",
                        "calculateIndividualValues": "Calcular los valores individuales",
                        "removeValue": "Retirar",
                        "removeValueTitle": "Retirar {0}?",
                        "removeValueMessage": "Seguro que desea eliminar este valor calculado?",
                        "header": "Añadir valor calculado",
                        "allValues": "Todos los valores"
                    },
                    "grid": {
                        "total": "Total",
                        "totals": "Totales",
                        "grandTotal": "Total",
                        "blankMember": "(blanco)",
                        "dateInvalidCaption": "Invalid date",
                        "reportInformation": "Report Information"
                    },
                    "charts": {
                        "showLegend": "mostrar leyenda",
                        "hideLegend": "esconder leyenda",
                        "selectMeasures": "Select measures",
                        "rowNumber": "Row number",
                        "bigDataSetWarning": "Data set is too big to be displayed on the chart. Data set will be cut off to the amount fitting into the chart.",
                        "flatTypesLimitation": "Bar stack and bar line charts are not available for flat table.",
                        "noDataTitle": "No data to display."
                    },
                    "tooltips": {
                        "row": "Fila:",
                        "column": "Columna:",
                        "headerResize": "Arrastrar para redimensionar",
                        "headerFit": "Doble click para ajustar",
                        "filterIcon": "Click para filtrar",
                        "filtered": "Filtrado",
                        "expandIcon": "Click para expandir",
                        "collapseIcon": "Click para plegarse",
                        "drillDown": "Click to drill down",
                        "drillUp": "Click to drill up",
                        "sortIcon": "Click para ordenacion descendente",
                        "sortedDescIcon": "Ordenar ascendente",
                        "sortedAscIcon": "Ordenar descendente",
                        "close": "Click para cerrar"
                    },
                    "aggregations": {
                        "average": {
                            "caption": "Media",
                            "totalCaption": "Media de {0}",
                            "grandTotalCaption": "Total Media de {0}"
                        },
                        "count": {
                            "caption": "Conteo",
                            "totalCaption": "Conteo de {0}",
                            "grandTotalCaption": "Total conteo de {0}"
                        },
                        "difference": {
                            "caption": "La diferencia",
                            "totalCaption": "La diferencia de {0}",
                            "grandTotalCaption": "Total La diferencia de {0}"
                        },
                        "distinctCount": {
                            "caption": "Distinto conteo",
                            "totalCaption": "Distinto conteo de {0}",
                            "grandTotalCaption": "Distinto conteo de {0}"
                        },
                        "index": {
                            "caption": "Índice",
                            "totalCaption": "Índice de {0}",
                            "grandTotalCaption": "Índice de {0}"
                        },
                        "max": {
                            "caption": "Máximo",
                            "totalCaption": "Maximo de {0}",
                            "grandTotalCaption": "Total máximo de {0}"
                        },
                        "min": {
                            "caption": "Mínimo",
                            "totalCaption": "Minimo de {0}",
                            "grandTotalCaption": "Total mínimo de {0}"
                        },
                        "none": {
                            "caption": "No Calculation"
                        },
                        "percent": {
                            "caption": "Porcentaje",
                            "totalCaption": "Porcentaje de {0}",
                            "grandTotalCaption": "Total Porcentaje de {0}"
                        },
                        "percentDifference": {
                            "caption": "Porcentaje de diferencia",
                            "totalCaption": "Porcentaje de diferencia {0}",
                            "grandTotalCaption": "Total porcentaje de diferencia {0}"
                        },
                        "percentOfColumn": {
                            "caption": "Porcentaje de columna",
                            "totalCaption": "Porcentaje de columna {0}",
                            "grandTotalCaption": "Total Porcentaje de columna {0}"
                        },
                        "percentOfRow": {
                            "caption": "% of Row",
                            "totalCaption": "% of Row of {0}",
                            "grandTotalCaption": "Total % of Row of {0}"
                        },
                        "product": {
                            "caption": "Producto",
                            "totalCaption": "Producto de {0}",
                            "grandTotalCaption": "Total producto de {0}"
                        },
                        "sum": {
                            "caption": "Suma",
                            "totalCaption": "Suma de {0}",
                            "grandTotalCaption": "Total Suma de {0}"
                        }
                    },
                    "messages": {
                        "error": "Error!",
                        "warning": "Precaución",
                        "limitation": "Limitation!",
                        "browse": "Explorar",
                        "confirmation": "Confirmación",
                        "reportFileType": "Flexmonster report file",
                        "loading": "Cargando...",
                        "loadingConfiguration": "Cargando configuración...",
                        "loadingData": "Cargando datos...",
                        "uploading": "Actualizando el servidor...",
                        "waiting": "{0} seg",
                        "progress": "{0}К of {1}К",
                        "progressUnknown": "leído {0}К",
                        "analyzing": "Analizando datos...",
                        "analyzingProgress": "{0} registros de {1} ({2}%)",
                        "analyzingRecords": "{0}% records",
                        "saving": "Saving...",
                        "loadingDimensions": "Cargando dimensiones...",
                        "loadingHierarchies": "Cargando jerarquias...",
                        "loadingMeasures": "Cargando medidas...",
                        "loadingKPIs": "Loading KPIs...",
                        "loadingMembers": "Cargando grupos...",
                        "loadingProperties": "Loading properties...",
                        "loadingLevels": "Cargando niveles...",
                        "fullscreen": "Desea abrirlo en pantalla completa?",
                        "exportComplete": "La exportación de datos ha sido creada, por favor pulse el boton \"Guardar\" para guardar los datos.",
                        "generatingPDF": "Generando PDF",
                        "pleaseWait": "Por favor, espere.",
                        "pagesWereGenerated": "páginas se generaron.",
                        "exportProgress": "Exportación en progreso...",
                        "exportError": "Failed to export. An unexpected error occurred.",
                        "cantSaveFile": "Error: No se puede guardar el fichero.",
                        "cantSaveToClipboard": "Error: No puedo escribir en el portapapeles.",
                        "saveReportToFile": "Informe está listo para ser guardados en un archivo, haga clic en \"Guardar\" para guardar el informe.",
                        "saveDataToFile": "Data is ready to be saved to file, please click \"Save\" button to save the file.",
                        "loadReportFromFile": "Seleccione el fichero de informe para ser cargado",
                        "inputNewName": "Entrada de un nuevo nombre",
                        "inputReportName": "Por favor, introducir el nombre de informe",
                        "invalidDataSource": "Invalid datasource or catalog. Please check. <br/><br/><u><a href='https://www.flexmonster.com/doc/typical-errors/#invalid-datasource' target='_blank'>Read more info about this error</a></u>",
                        "dataStreamError": "Stream error occurred while loading '{0}'<br/><br/><u><a href='https://www.flexmonster.com/doc/typical-errors/#stream-error' target='_blank'>Read more info about this error</a></u>",
                        "unableToOpenFile": "Unable to open file {0}.<br/><br/>It seems that this file doesn't exist or 'Access-Control-Allow-Origin' header is absent in the resource requested.<br/><br/><u><a href='https://www.flexmonster.com/doc/typical-errors/#unable-to-open-file' target='_blank'>Read more info about this error</a></u>",
                        "unableTwoFileBrowsingSessions": "Browse file dialog is already opened.",
                        "wrongFormulaFormat": "Wrong formula format. Please check.",
                        "inappropriateFileFormat": "The data file is of inappropriate format.",
                        "invalidJSONdata": "JSON data is invalid.",
                        "excelCsvChartsExportError": "Export to Microsoft Excel or CSV is not available for charts.",
                        "excelPdfExportLimitation": "Export to Microsoft Excel or PDF is not available in the current edition.",
                        "excelExportLimitation": "Export is not available in the current edition.",
                        "noDataAvailable": "Data source is empty. Please check the CSV file.",
                        "csvHeaderParsingError": "CSV header parsing error.",
                        "dataWasUpdated": "Data source has been updated on the server. Refresh the report?",
                        "cantConnectToAccelerator": "Cannot connect to data source. Please check if Flexmonster Accelerator is running.",
                        "ocsvIncompatible": "Unable to read data source. It seems that OCSV file was compressed with a newer version. Please update the component to version {0} or newer.",
                        "unknownError": "Unknown error occurred.",
                        "invalidReportFormat": "Invalid report format or access to file is denied.",
                        "tooManyColumnsInClassicMode": "Too many columns for classic form. Switched layout to compact form.",
                        "loadingSkin": "Cargando estilo... {0}%",
                        "selectFile": "Seleccione el fichero .CSV para cargar"
                    },
                    "kpis": {
                        "kpis": "KPIs",
                        "value": "Value",
                        "goal": "Goal",
                        "trend": "Trend",
                        "status": "Status"
                    },
                    "buttons": {
                        "ok": "OK",
                        "apply": "Aplicar",
                        "cancel": "Cancelar",
                        "save": "Guardar",
                        "clear": "Claro",
                        "select": "Explorar...",
                        "yes": "Yes",
                        "no": "No"
                    },
                    "contextMenu": {
                        "drillThrough": "Drill through",
                        "openFilter": "Open filter",
                        "collapse": "Collapse",
                        "expand": "Expand",
                        "sortRowDesc": "Sort row desc",
                        "sortRowAsc": "Sort row asc",
                        "clearSorting": "Clear sorting",
                        "sortColumnDesc": "Sort column desc",
                        "sortColumnAsc": "Sort column asc"
                    },
                    "date": {
                        "year": "Año",
                        "quarter": "Trimestre",
                        "month": "Mes",
                        "day": "Día"
                    },
                    "quarters": {
                        "q1": "Q1",
                        "q2": "Q2",
                        "q3": "Q3",
                        "q4": "Q4"
                    },
                    "months": {
                        "january": "Ene",
                        "february": "Feb",
                        "march": "Mar",
                        "april": "Abr",
                        "may": "May",
                        "june": "Jun",
                        "july": "Jul",
                        "august": "Ago",
                        "september": "Sep",
                        "october": "Oct",
                        "november": "Nov",
                        "december": "Dic"
                    },
                    "monthsShort": {
                        "january": "Jan",
                        "february": "Feb",
                        "march": "Mar",
                        "april": "Apr",
                        "may": "May",
                        "june": "Jun",
                        "july": "Jul",
                        "august": "Aug",
                        "september": "Sep",
                        "october": "Oct",
                        "november": "Nov",
                        "december": "Dec"
                    },
                    "weekdays": {
                        "first": "Sunday",
                        "second": "Monday",
                        "third": "Tuesday",
                        "fourth": "Wednesday",
                        "fifth": "Thursday",
                        "sixth": "Friday",
                        "seventh": "Saturday"
                    },
                    "weekdaysShort": {
                        "first": "Sun",
                        "second": "Mon",
                        "third": "Tue",
                        "fourth": "Wed",
                        "fifth": "Thu",
                        "sixth": "Fri",
                        "seventh": "Sat"
                    },
                    "toolbar": {
                        "connect": "Conectar",
                        "connect_local_csv": "CSV local",
                        "connect_local_ocsv": "OCSV local",
                        "connect_local_json": "JSON local",
                        "connect_remote_csv": "CSV remoto",
                        "connect_remote_csv_mobile": "CSV",
                        "connect_remote_json": "JSON remoto",
                        "connect_remote_json_mobile": "JSON",
                        "connect_olap": "OLAP (XMLA)",
                        "connect_olap_mobile": "OLAP",
                        "open": "Abierto",
                        "local_report": "Informe local",
                        "remote_report": "Informe remoto",
                        "remote_report_mobile": "Informe",
                        "save": "Salvar",
                        "load_json": "Informe JSON",
                        "grid": "Tabla",
                        "grid_flat": "Plana",
                        "grid_classic": "Clásico",
                        "grid_compact": "Compacto",
                        "charts": "Gráficos",
                        "charts_bar": "Columna",
                        "charts_bar_horizontal": "Barras",
                        "charts_line": "Linea",
                        "charts_scatter": "Dispersión",
                        "charts_pie": "Circular",
                        "charts_bar_stack": "Pila de barras",
                        "charts_bar_line": "Líneas de barras",
                        "charts_multiple": "Valores múltiples",
                        "charts_multiple_disabled": "Los valores múltiples no se aplican a ",
                        "format": "Formato",
                        "format_cells": "Formato de celdas",
                        "format_cells_mobile": "Formato",
                        "conditional_formatting": "Formato condicional",
                        "conditional_formatting_mobile": "Condicional",
                        "options": "Opciones",
                        "fullscreen": "Pantalla completa",
                        "export": "Exportar",
                        "export_print": "Imprimir",
                        "export_html": "HTML",
                        "export_csv": "CSV",
                        "export_excel": "Excel",
                        "export_image": "Image",
                        "export_pdf": "PDF",
                        "fields": "Campos",
                        "ok": "OK",
                        "apply": "Aplicar",
                        "done": "Hecho",
                        "cancel": "Cancelar",
                        "value": "Valor",
                        "delete": "Borrar",
                        "if": "Si",
                        "then": "Entonces",
                        "open_remote_csv": "Abrir CSV remoto",
                        "open_remote_json": "Abrir JSON remoto",
                        "csv": "CSV",
                        "olap_connection_tool": "Herramienta de conexión OLAP",
                        "select_data_source": "Seleccionar fuente de datos",
                        "select_catalog": "Seleccionar catálogo",
                        "select_cube": "Seleccionar cubo",
                        "proxy_url": "URL de proxy",
                        "data_source_info": "Información de fuentes de datos",
                        "catalog": "Catalogar",
                        "cube": "Cubo",
                        "credentials": "cartas credenciales",
                        "username": "Nombre de usuario",
                        "password": "Contraseña",
                        "open_remote_report": "Abrir informe remoto",
                        "choose_value": "Elegir valor",
                        "text_align": "Texto alineado",
                        "align_left": "izquierda",
                        "align_right": "derecho",
                        "none": "Ninguna",
                        "space": "(Espacio)",
                        "thousand_separator": "Mil separadores",
                        "decimal_separator": "Separador decimal",
                        "decimal_places": "Lugares decimales",
                        "currency_symbol": "Símbolo de moneda",
                        "currency_align": "La moneda se alinea",
                        "null_value": "Valor nulo",
                        "is_percent": "Formato como porcentaje",
                        "true_value": "cierto",
                        "false_value": "falso",
                        "conditional": "Condicional",
                        "add_condition": "Añadir condición",
                        "less_than": "Menos que",
                        "less_than_or_equal": "Menos que o igual a",
                        "greater_than": "Mas grande que",
                        "greater_than_or_equal": "Mayor qué o igual a",
                        "equal_to": "Igual a",
                        "not_equal_to": "No igual a",
                        "between": "Entre",
                        "is_empty": "Vacío",
                        "all_values": "Todos los valores",
                        "and": "y",
                        "and_symbole": "&",
                        "cp_text": "Texto",
                        "cp_highlight": "Realce",
                        "layout_options": "Opciones de diseño",
                        "layout": "Diseño",
                        "compact_view": "Forma compacta",
                        "classic_view": "Forma clásica",
                        "flat_view": "Forma plana",
                        "grand_totals": "Totales generales",
                        "grand_totals_off": "No mostrar los totales generales",
                        "grand_totals_on": "Mostrar totales generales",
                        "grand_totals_on_rows": "Mostrar solo para filas",
                        "grand_totals_on_columns": "Mostrar solo para columnas",
                        "subtotals": "Subtotales",
                        "subtotals_off": "No mostrar subtotales",
                        "subtotals_on": "Mostrar subtotales",
                        "subtotals_on_rows": "Mostrar solo filas subtotales",
                        "subtotals_on_columns": "Mostrar solo columnas subtotales",
                        "choose_page_orientation": "Elegir la orientación de la página",
                        "landscape": "Paisaje",
                        "portrait": "Retrato",
                        "off_for_rows_and_columns": "Desactivado para filas y columnas",
                        "on_for_rows_and_columns": "Activado para filas y columnas",
                        "on_for_rows": "Sólo para filas",
                        "on_for_columns": "Sólo para columnas",
                        "do_not_show_subtotals": "No mostrar subtotales",
                        "show_all_subtotals": "Mostrar todos los subtotales"
                    }
                }
            }
        });
    </script>
</body>

</html>