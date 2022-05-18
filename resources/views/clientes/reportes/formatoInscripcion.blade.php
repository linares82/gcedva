<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Formato Inscripción</title>
    <style>
        h1, h2, H3, h4, h5, h6 th { text-align: center;font-family: Segoe UI; }
        /*table { margin: auto; font-family: Segoe UI; box-shadow: 10px 10px 5px #888; border: thin ridge grey; }*/
        table { font-family: Segoe UI; border: no-border; width: 100%}
        /*th { background: #0046c3; color: #fff; max-width: 400px; padding: 5px 10px; }*/
        td { 
            font-size: 12px; padding: 2px 0px; color: #000;}
        .td_contenido{
            text-align: center;
            border-bottom: 1px solid;
        }
        .descripcion_pequenia { 
            height: 5px;
            vertical-align:baseline; 
            font-size: 6px; 
            color: #000; 
            text-align: center;
        }
        .tr_pequenia{height: 5px;}
        /*tr { background: #b8d1f3; }
        tr:nth-child(even) { background: #dae5f4; }
        tr:nth-child(odd) { background: #b8d1f3; }*/
        .tablediv{
            align-content: left;
            margin: auto;
        }
      </style>
</head>
<body style="padding:20px;font-family: Segoe UI;">
    <table>
        <tr>
            <td style="width: 20%;">
                <!--<img src="{{ asset('/imagenes/planteles/'.$cliente->plantel_id."/".$cliente->plantel->logo) }}" alt="Sin logo" height="80px" ></img>-->
                <img src="{{asset('storage/especialidads/'.$combinacion->especialidad->imagen)}}" alt="Logo" height="42" width="42" > </td>
            </td>
            <td align="center">
                {{ $cliente->plantel->razon }} <br>
                <strong>SOLICITUD DE INSCRIPCIÓN</strong> <br>
                <p>{{ $combinacion->grado->name }} <br> Registro de Incorporación: {{ $combinacion->grado->rvoe }} </p>
            </td>
            <td style="width: 20%;">
                <table>
                    <th>
                        <td style="width:50px; border: 1px solid; text-align:center; padding:15px"> Foto <br> del <br> Alumno</td>
                    </th>
                </table>
            </td>
        </tr>
    </table>
    <h4>DATOS GENERALES DEL ALUMNO</h4>
    <HR></HR>
    <div class="tablediv">
        <table>
            <tr>
                <td width="20px">Matrícula:</td><TD class="td_contenido">{{ $cliente->matricula }}</TD><td width="20px">Horario</td><td class="td_contenido">{{$combinacion->turno->name}}</td>
            </tr>
        </table>
    </div>
    <div class="tablediv">
        <table>
            <tr>
                <TD width="20px">Nombre:</TD><TD class="td_contenido">{{ $cliente->ape_paterno }} {{ $cliente->ape_materno }} {{ $cliente->nombre }} {{ $cliente->nombre2 }}</TD><td class="td_contenido">{{ $cliente->curp }}</td>
            </tr>
            <tr>
                <TD></TD><TD class="descripcion_pequenia">Apellido Paterno, Apellido Materno, Nombre(s) (Segun Acta de Nacimiento)</TD><td class="descripcion_pequenia">CURP</td>
            </tr>
        </table>
    </div>
    <div class="tablediv">
        <table>
            <tr>
                <td width="20px">Domicilio</td><td class="td_contenido">{{ $cliente->calle }}</td><td class="td_contenido">{{ $cliente->no_exterior }}</td><td class="td_contenido">{{ $cliente->cp }}</td>
            </tr>
            <tr>
                <td></td><td class="descripcion_pequenia">Calle</td><td class="descripcion_pequenia">No.</td><td class="descripcion_pequenia">C.P.</td>
            </tr>
        </table>
    </div>
    <div class="tablediv">
        <table>
            <tr>
                <td class="td_contenido">{{ $cliente->colonia }}</td><td class="td_contenido">{{ $cliente->municipio->name }}</td><td class="td_contenido">-</td>
            </tr>
            <tr>
                <td class="descripcion_pequenia">Colonia</td><td class="descripcion_pequenia">Municipio</td><td class="descripcion_pequenia">Ciudad</td>
            </tr>
        </table>
    </div>
    <div class="tablediv">
        <table>
            <tr>
                <TD width="20px">Teléfono:</TD><TD class="td_contenido">{{ $cliente->tel_fijo }} </TD><td width="20px">Edad:</td><td class="td_contenido">{{ $cliente->edad }}</td><td width="20px">Estatura</td><td class="td_contenido">{{ $cliente->estatura }}</td>
            </tr>
        </table>
    </div>
    <div class="tablediv">
        <table>
            <tr>
                <TD width="20px">Email:</TD><TD class="td_contenido">{{ $cliente->mail }} </TD><td width="70px">Tel. Casa:</td><td class="td_contenido">{{ $cliente->tel_fijo }}</td>
            </tr>
        </table>
    </div>
    <div class="tablediv">
        <table>
            <tr>
                <TD width="170px">Fecha de Nacimiento:</TD><TD class="td_contenido">{{ date_format(date_create($cliente->fec_nacimiento),"d-m-Y") }} </TD><td width="120px">Estado Civil:</td><td class="td_contenido">{{ optional($cliente->estadoCivil)->name }}</td><td width="40px">Sexo:</td><td class="td_contenido">{{ ($cliente->genero==1? 'Masculino': 'Femenino') }}</td>
            </tr>
        </table>
    </div>
    <div class="tablediv">
        <table>
            <tr>
                <TD width="30%"><strong>Estudios Cursados</strong></TD><TD width="30%"><strong>Documentación que entregó</strong>  </TD><td width="30%"><strong>Quien cubre la colegiatura</strong> </td>
            </tr>
            <tr>
                <TD width="30%">{{ optional($cliente->escolaridad)->name }}</TD><TD width="30%">No requiere documentos </TD><td width="30%">{{ optional($cliente->pagador)->name }} </td>
            </tr>
        </table>
    </div>
    <div class="tablediv">
        <table>
            <tr>
                <TD width="220px">Nombre del Plantel Anterior:</TD><TD class="td_contenido">{{ $cliente->escuela_procedencia }} </TD>
            </tr>
        </table>
    </div>            
    <h4>DATOS DEL PADRE O TUTOR</h4>
    <HR></HR>            
    @if($cliente->pagador_id==1)
    <div class="tablediv">
        <table>
            <tr>
                <TD width="20px">Nombre:</TD><TD class="td_contenido">{{ $cliente->nombre_padre }} </TD>
            </tr>
            <tr>
                <td></td><td class="descripcion_pequenia">Apellido Paterno, Apellido Materno, Nombre</td>
            </tr>
        </table>
    </div> 
    <div class="tablediv">
        <table>
            <tr>
                <TD width="20px">Domicilio:</TD><TD class="td_contenido">{{ $cliente->dir_padre }} </TD>
            </tr>
            <tr>
                <td></td><td class="descripcion_pequenia">Calle, No., CP, Col., Municipio, Ciudad</td>
            </tr>
        </table>
    </div>      
    <div class="tablediv">
        <table>
            <tr>
                <TD width="20px">Ocupacion:</TD><TD class="td_contenido"> - </TD><TD width="220px">Tel. Oficina:</TD><TD class="td_contenido"> {{ $cliente->tel_ofi_padre }} </TD>
            </tr>
        </table>
    </div>      
    @elseif($cliente->pagador_id==2)
    <div class="tablediv">
        <table>
            <tr>
                <TD width="20px">Nombre:</TD><TD class="td_contenido">{{ $cliente->nombre_madre }} </TD>
            </tr>
            <tr>
                <td></td><td class="descripcion_pequenia">Apellido Paterno, Apellido Materno, Nombre</td>
            </tr>
        </table>
    </div> 
    <div class="tablediv">
        <table>
            <tr>
                <TD width="20px">Domicilio:</TD><TD class="td_contenido">{{ $cliente->dir_madre }} </TD>
            </tr>
            <tr>
                <td></td><td class="descripcion_pequenia">Calle, No., CP, Col., Municipio, Ciudad</td>
            </tr>
        </table>
    </div>      
    <div class="tablediv">
        <table>
            <tr>
                <TD width="20px">Ocupacion:</TD><TD class="td_contenido"> - </TD><TD width="220px">Tel. Oficina:</TD><TD class="td_contenido"> {{ $cliente->tel_ofi_madre }} </TD>
            </tr>
        </table>
    </div>      
    @else
    <div class="tablediv">
        <table>
            <tr>
                <TD width="20px">Nombre:</TD><TD class="td_contenido">{{ $cliente->nombre_acudiente }} </TD>
            </tr>
            <tr>
                <td></td><td class="descripcion_pequenia">Apellido Paterno, Apellido Materno, Nombre</td>
            </tr>
        </table>
    </div> 
    <div class="tablediv">
        <table>
            <tr>
                <TD width="20px">Domicilio:</TD><TD class="td_contenido">{{ $cliente->dir_acudiente }} </TD>
            </tr>
            <tr>
                <td></td><td class="descripcion_pequenia">Calle, No., CP, Col., Municipio, Ciudad</td>
            </tr>
        </table>
    </div>      
    <div class="tablediv">
        <table>
            <tr>
                <TD width="20px">Ocupacion:</TD><TD class="td_contenido"> - </TD><TD width="220px">Tel. Oficina:</TD><TD class="td_contenido"> {{ $cliente->tel_ofi_acudiente }} </TD>
            </tr>
        </table>
    </div>      
    @endif
    <div class="tablediv">
        <table>
            <tr>
                <TD width="220px">¿Como se entero de la escuela?</TD><TD class="td_contenido"> {{ $cliente->medio->name }} </TD>
            </tr>
        </table>
    </div> 
    <div class="tablediv" style="font-size: 12px;">
        <p>
            Hago constar que todos los datos contenidos en esta solicitud están completos y son verdaderos, que no
        omito ninguna información solicitada y que los documentos que presento son auténticos, y de no ser así,
        libero a la escuela de toda responsabilidad, asumiendo completamente la misma, para asuntos legales o
        jurídicos que se pudieran presentar.
        </p>
    </div>  
    <br><br><br>
    <div class="tablediv">
        <table>
            <tr>
                <TD class="td_contenido" style="width:40%;">Firma del Alumno</TD><td></td><TD class="td_contenido" style="width:40%;"> Firma del Padre o Tutor </TD>
            </tr>
        </table>
        <table>
            <tr>
            </tr>
                <TD style="width:40%;"></TD><td></td><TD style="width:40%;"> {{$cliente->plantel->municipio}}, {{$cliente->plantel->estado}}; a {{Date('d')}} de {{ App\Mese::where('id', Date('m'))->value('name') }} de {{Date('Y')}}</TD>
        </table>
    </div>
    <HR></HR>                
    <div class="tablediv">
        <table>
            <thead>
                <th>Documento</th><th>Obligatorio</th><th>Entregado</th>    
            </thead>    
            <tbody>
                @foreach($lista_mostrar as $documento)
                <tr>
                    <td>{{ $documento['documento'] }}</td>
                    <td>
                        
                        {{ $documento['obligatorio'] }}
                        
                    </td>
                    <td>
                        @if(!isset($documento['archivo']))
                            NO
                        @else
                            @if(is_null($documento['archivo']))
                            NO 
                            @else
                            SI
                            @endif
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>    
    </div>   
    <HR></HR>  
    <div class="tablediv" style="font-size: 12px;">
        <ul>
            <li>La información de pago está calculada a pagos seriados mes a mes, en caso de optar por uno diferente solicitarlo.</li>
            <li>Debe cubrirse al inscribirse concepto de inscripción, trámites y la mensualidad maximo el dia 10 de cada mes. </li>
            <li>Una vez iniciado clases, no es posible efectuar reembolsos, salvo por causas imputables a la institución.</li>
            <li>Los descuentos ofrecidos por por los diferentes conceptos no son acumulables.</li>
            <li>Los conceptos de mensuaildad de pago se realizarán en depósito bancario o en efectivo segun se indique.</li>
            <li>Las cuotas tienen un incremento anual.</li>
            <li>Las bajas y cambios de carrera se deben solicitar por escrito.</li>
            <li>Cualquier pago realizado fuera de la caja del plantel, no sera responsabilidad de la institución.</li>
        </ul>
    </div>
</body>
</html>