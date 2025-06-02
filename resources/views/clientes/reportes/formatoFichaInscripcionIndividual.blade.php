<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ficha Inscripción</title>
    <style>
        h1, h2, H3, h4, h5, h6 th { text-align: center;font-family: Segoe UI; }
        /*table { margin: auto; font-family: Segoe UI; box-shadow: 10px 10px 5px #888; border: thin ridge grey; }*/
        table { font-family: Segoe UI; border: no-border; width: 100%}
        /*th { background: #0046c3; color: #fff; max-width: 400px; padding: 5px 10px; }*/
        td { 
            font-size: 10px; padding: 2px 0px; color: #000;}
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
        .descripcion_clausulas { 
            
            vertical-align:baseline; 
            font-size: 7px; 
            color: #000; 
            text-align: justify;
        }
        .tr_pequenia{height: 5px;}
        /*tr { background: #b8d1f3; }
        tr:nth-child(even) { background: #dae5f4; }
        tr:nth-child(odd) { background: #b8d1f3; }*/
        .tablediv{
            align-content: left;
            margin: auto;
        }
        .materias th { font-size: 10px; background:rgb(218, 2, 2); color: #fff; border-style: solid; border: thin ridge grey; }
        .materias td { 
            font-size: 10px; color: #000; border-style: solid; border: thin ridge grey;}
        .materias { margin: auto; font-family: Segoe UI; border: thin ridge grey; border-collapse: collapse; }
        @media all {
            div.saltopagina{
                display: none;
            }
        }
        
        @media print{
            div.saltopagina{
                display:block;
                page-break-before:always;
            }
        }
      </style>
</head>
<body style="padding:20px;font-family: Segoe UI;"">
    <div class="tablediv">
        <table>
            <tr>
                <TD width="75%"></TD><TD class="descripcion_pequenia" align="rigth">1/4</TD>
            </tr>    
        </table>
    </div>
    <table style="width: 100%;">
        <tr>
            <td style="width: 50%;" align="left"><img src="{{asset('storage/grados/'.$grado->imagen)}}" alt="Logo" height="42" width="100" ></td>
            <td style="width: 50%;" align="rigth">{{ $grado->denominacion }}</td>
        </tr>
        <tr>
            <td colspan="2" alignment="left">
                <p class="descripcion_pequenia">INSTRUCCIONES:Leer detenidamente. Llenar con letra de molde y legible, cada uno de los espaciospara completar. Usar Tinta de Color negro. Pegar fotografía de tamaño infantil. Colocar ombre y firma del alumno y del padre o tutor.<p>  
            </td>
        </tr>
    </table>
    <table style="width: 100%;">
        <tr>
            <td style="width:85%;"> 1. DATOS GENERALES DEL ALUMNO</td>
            <td style="width:15%;">FICHA DE INSCRIPCIÓN CICLO {{$lectivo->ciclo_escolar}}</td>
        </tr>
        <tr>
            <td>
                <div class="tablediv">
                    <table >
                        <tr >
                            <TD width="150px">NOMBRE COMPLETO:</TD><TD class="td_contenido">{{ $cliente->ape_paterno }} {{ $cliente->ape_materno }} {{ $cliente->nombre }} {{ $cliente->nombre2 }}</TD>
                        </tr>
                        <tr>
                            <TD></TD><TD class="descripcion_pequenia">APELLIDO PATERNO, APELLIDO MATERNO, NOMBRE(S)</TD>
                        </tr>
                    </table>
                </div>
                <div class="tablediv">
                    <table>
                        <tr>
                            <td width="20px">MATRÍCULA:</td><TD class="td_contenido">{{ $cliente->matricula }}</TD><td width="20px">LICENCIATURA</td><td class="td_contenido">{{$grado->nombre2}}</td>
                        </tr>
                    </table>
                </div>
                <div class="tablediv">
                    <table>
                        <tr>
                            <td width="280px">MARQUE CON UNA “X” EL GRADO AL QUE SE VA A INSCRIBIR:</td>
                            <TD class="td_contenido">
                                <span style="padding:5px;">1 O</span>  
                                <span style="padding:5px;">2 O </span> 
                                <span style="padding:5px;">3 O </span> 
                                <span style="padding:5px;">4 O </span> 
                                <span style="padding:5px;">5 O </span> 
                                <span style="padding:5px;">6 O </span> 
                                <span style="padding:5px;">7 O </span> 
                                <span style="padding:5px;">8 O </span> 
                                <span style="padding:5px;">9 O </span>

                                </TD>
                        </tr>
                    </table>
                </div>
                <div class="tablediv">
                    <table>
                        <tr>
                            <td width="150px">DOMICILIO COMPLETO</td><td class="td_contenido">{{ $cliente->calle }}</td><td class="td_contenido">{{ $cliente->no_exterior }}</td><td class="td_contenido">{{ $cliente->colonia }}</td>
                        </tr>
                        <tr>
                            <td></td><td class="descripcion_pequenia">CALLE</td><td class="descripcion_pequenia">No.</td><td class="descripcion_pequenia">COLONIA</td>
                        </tr>
                    </table>
                </div>
                <div class="tablediv">
                    <table>
                        <tr>
                            <td class="td_contenido">{{ $cliente->municipio->name }}</td><td class="td_contenido">{{ $cliente->estado->name }}</td><td class="td_contenido">-</td>
                        </tr>
                        <tr>
                            <td class="descripcion_pequenia">MUNICIPIO</td><td class="descripcion_pequenia">ESTADO</td><td class="descripcion_pequenia">CIUDAD</td>
                        </tr>
                    </table>
                </div>
                <div class="tablediv">
                    <table>
                        <tr>
                            <td width="20px">Edad:</td><td class="td_contenido">{{ $cliente->edad }}</td><TD width="170px">Fecha de Nacimiento:</TD><TD class="td_contenido">{{ date_format(date_create($cliente->fec_nacimiento),"d-m-Y") }} </TD>
                        </tr>
                        <tr>
                            <td></td><td class="descripcion_pequenia"></td><td></td><td class="descripcion_pequenia">DIA MES AÑO</td>
                        </tr>
                    </table>
                </div>
                <div class="tablediv">
                    <table>
                        <tr>
                            <TD width="100px">TEL. CASA:</TD><TD class="td_contenido">{{ $cliente->tel_fijo }} </TD> <TD width="100px">TEL. CELULAR:</TD><TD class="td_contenido">{{ $cliente->tel_cel }} </TD>
                        </tr>
                    </table>
                </div>
                <div class="tablediv">
                    <table>
                        <tr>
                            <TD width="200px">CORREO ELECTRÓNICO:</TD><TD class="td_contenido">{{ $cliente->mail }} </TD>
                        </tr>
                    </table>
                </div>
                
            </td>
            <td style="vertical-align:top;">
                <table>    
                    <tr>
                        <td style="width:50px; border: 1px solid; text-align:center; padding:15px"> <br><br>Foto <br><br><br> </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td>
                <div class="tablediv">
                    <table>
                        <tr>
                            <TD width="150px">2. DATOS DEL PADRE O TUTOR</TD>
                        </tr>
                    </table>
                </div>
                @if(!is_null($cliente->nombre_padre))
                <div class="tablediv">
                    <table>
                        <tr>
                            <TD width="150px">NOMBRE COMPLETO:</TD><TD class="td_contenido">{{ $cliente->nombre_padre }}</TD>
                        </tr>
                        <tr>
                            <TD></TD><TD class="descripcion_pequenia">APELLIDO PATERNO, APELLIDO MATERNO, NOMBRE(S)</TD>
                        </tr>
                    </table>
                </div>
                <div class="tablediv">
                    <table>
                        <tr>
                            <TD width="150px">DOMICILIO COMPLETO:</TD><TD class="td_contenido">{{ $cliente->dir_padre }}</TD>
                        </tr>
                        <tr>
                            <TD></TD><TD class="descripcion_pequenia">CALLE      NO.       COLONIA      MUNICIPIO      ESTADO       C.P.</TD>
                        </tr>
                    </table>
                </div>
                <div class="tablediv">
                    <table>
                        <tr>
                            <TD width="150px"></TD><TD class="td_contenido"><br></TD>
                        </tr>
                        <tr>
                            <TD></TD><TD class="descripcion_pequenia"></TD>
                        </tr>
                    </table>
                </div>
                <div class="tablediv">
                    <table>
                        <tr>
                            <TD width="150px">PARENTESCO:</TD><TD class="td_contenido">Padre</TD><TD width="150px">OCUPACIÓN:</TD><TD class="td_contenido"></TD>
                        </tr>    
                    </table>
                </div>
                <div class="tablediv">
                    <table>
                        <tr>
                            <TD width="150px">TEL. CASA:</TD><TD class="td_contenido">{{ $cliente->tel_padre }}</TD><TD width="150px">TEL. CELULAR:</TD><TD class="td_contenido">{{$cliente->cel_padre}}</TD>
                        </tr>    
                    </table>
                </div>
                <div class="tablediv">
                    <table>
                        <tr>
                            <TD width="150px">CORREO ELECTRONICO:</TD><TD class="td_contenido">{{ $cliente->mail_padre }}</TD>
                        </tr>    
                    </table>
                </div>
                @elseif(!is_null($cliente->nombre_madre))
                <div class="tablediv">
                    <table>
                        <tr>
                            <TD width="150px">NOMBRE COMPLETO:</TD><TD class="td_contenido">{{ $cliente->nombre_madre }}</TD>
                        </tr>
                        <tr>
                            <TD></TD><TD class="descripcion_pequenia">APELLIDO PATERNO, APELLIDO MATERNO, NOMBRE(S)</TD>
                        </tr>
                    </table>
                </div>
                <div class="tablediv">
                    <table>
                        <tr>
                            <TD width="150px">DOMICILIO COMPLETO:</TD><TD class="td_contenido">{{ $cliente->dir_madre }}</TD>
                        </tr>
                        <tr>
                            <TD></TD><TD class="descripcion_pequenia">CALLE      NO.       COLONIA      MUNICIPIO      ESTADO       C.P.</TD>
                        </tr>
                    </table>
                </div>
                <div class="tablediv">
                    <table>
                        <tr>
                            <TD width="150px"></TD><TD class="td_contenido"><br></TD>
                        </tr>
                        <tr>
                            <TD></TD><TD class="descripcion_pequenia"></TD>
                        </tr>
                    </table>
                </div>
                <div class="tablediv">
                    <table>
                        <tr>
                            <TD width="150px">PARENTESCO:</TD><TD class="td_contenido">Madre</TD><TD width="150px">OCUPACIÓN:</TD><TD class="td_contenido"></TD>
                        </tr>    
                    </table>
                </div>
                <div class="tablediv">
                    <table>
                        <tr>
                            <TD width="150px">TEL. CASA:</TD><TD class="td_contenido">{{ $cliente->tel_madre }}</TD><TD width="150px">TEL. CELULAR:</TD><TD class="td_contenido">{{$cliente->cel_madre}}</TD>
                        </tr>    
                    </table>
                </div>
                <div class="tablediv">
                    <table>
                        <tr>
                            <TD width="150px">CORREO ELECTRONICO:</TD><TD class="td_contenido">{{ $cliente->mail_madre }}</TD>
                        </tr>    
                    </table>
                </div>
                @elseif(!is_null($cliente->nombre_acudiente))
                <div class="tablediv">
                    <table>
                        <tr>
                            <TD width="150px">NOMBRE COMPLETO:</TD><TD class="td_contenido">{{ $cliente->nombre_acudiente }}</TD>
                        </tr>
                        <tr>
                            <TD></TD><TD class="descripcion_pequenia">APELLIDO PATERNO, APELLIDO MATERNO, NOMBRE(S)</TD>
                        </tr>
                    </table>
                </div>
                <div class="tablediv">
                    <table>
                        <tr>
                            <TD width="150px">DOMICILIO COMPLETO:</TD><TD class="td_contenido">{{ $cliente->dir_acudiente }}</TD>
                        </tr>
                        <tr>
                            <TD></TD><TD class="descripcion_pequenia">CALLE      NO.       COLONIA      MUNICIPIO      ESTADO       C.P.</TD>
                        </tr>
                    </table>
                </div>
                <div class="tablediv">
                    <table>
                        <tr>
                            <TD width="150px"></TD><TD class="td_contenido"><br></TD>
                        </tr>
                        <tr>
                            <TD></TD><TD class="descripcion_pequenia"></TD>
                        </tr>
                    </table>
                </div>
                <div class="tablediv">
                    <table>
                        <tr>
                            <TD width="150px">PARENTESCO:</TD><TD class="td_contenido"></TD><TD width="150px">OCUPACIÓN:</TD><TD class="td_contenido"></TD>
                        </tr>    
                    </table>
                </div>
                <div class="tablediv">
                    <table>
                        <tr>
                            <TD width="150px">TEL. CASA:</TD><TD class="td_contenido">{{ $cliente->tel_acudiente }}</TD><TD width="150px">TEL. CELULAR:</TD><TD class="td_contenido">{{$cliente->cel_acudiente}}</TD>
                        </tr>    
                    </table>
                </div>
                <div class="tablediv">
                    <table>
                        <tr>
                            <TD width="150px">CORREO ELECTRONICO:</TD><TD class="td_contenido">{{ $cliente->mail_acudiente }}</TD>
                        </tr>    
                    </table>
                </div>
                @else
                <div class="tablediv">
                    <table>
                        <tr>
                            <TD width="150px">NOMBRE COMPLETO:</TD><TD class="td_contenido"></TD>
                        </tr>
                        <tr>
                            <TD></TD><TD class="descripcion_pequenia">APELLIDO PATERNO, APELLIDO MATERNO, NOMBRE(S)</TD>
                        </tr>
                    </table>
                </div>
                <div class="tablediv">
                    <table>
                        <tr>
                            <TD width="150px">DOMICILIO COMPLETO:</TD><TD class="td_contenido"></TD>
                        </tr>
                        <tr>
                            <TD></TD><TD class="descripcion_pequenia">CALLE      NO.       COLONIA      MUNICIPIO      ESTADO       C.P.</TD>
                        </tr>
                    </table>
                </div>
                <div class="tablediv">
                    <table>
                        <tr>
                            <TD width="150px"></TD><TD class="td_contenido"><br></TD>
                        </tr>
                        <tr>
                            <TD></TD><TD class="descripcion_pequenia"></TD>
                        </tr>
                    </table>
                </div>
                <div class="tablediv">
                    <table>
                        <tr>
                            <TD width="150px">PARENTESCO:</TD><TD class="td_contenido"></TD><TD width="150px">OCUPACIÓN:</TD><TD class="td_contenido"></TD>
                        </tr>    
                    </table>
                </div>
                <div class="tablediv">
                    <table>
                        <tr>
                            <TD width="150px">TEL. CASA:</TD><TD class="td_contenido"></TD><TD width="150px">TEL. CELULAR:</TD><TD class="td_contenido"></TD>
                        </tr>    
                    </table>
                </div>
                <div class="tablediv">
                    <table>
                        <tr>
                            <TD width="150px">CORREO ELECTRONICO:</TD><TD class="td_contenido"></TD>
                        </tr>    
                    </table>
                </div>
                @endif
            </td>
            <td style="vertical-align:bottom;">
                <table>    
                    <tr>
                        <td> SELLO <BR> INSTITUCIONAL </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <div class="tablediv">
        <table>
            <tr>
                <TD width="150px">3. TIRA DE MATERIAS</TD>
            </tr>    
        </table>
    </div>
    <table class="materias" style="width:100%">
        <thead>
            <th>CLAVE</th><th>MATERIAS</th><th colspan="4">POR CURSAR</th>
        </thead>
        <tbody>
            @foreach($materias as $materia)
            <tr>
                <td>{{$materia->codigo}}</td><td>{{$materia->materia}}</td><td>SI</td><td style="width:20px"></td><td>NO</td><td style="width:20px"></td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="tablediv">
        <table>
            <tr>
                <TD class="descripcion_pequenia">
                    <p>
                        El {{ $grado->denominacion }} con domicilio en {{ $plantel->calle }} {{ $plantel->no_ext }} {{ $plantel->colonia }} {{ $plantel->municipio }} {{ $plantel->estado }}, 
                        propietario del utilizará sus datos personales aqui recabados para fines académicos, de seguimiento y promoción de eventos exclusivos del {{ $grado->denominacion }}
                        asi como para dar seguimiento al proceso de admisión, inscripción, reinscripción y acreditación.
                    </p>
                    <p>Para mayor información a cerca del tratamiento y de de los derechos que puede ejercer, puede acceder al Aviso de privacidad.</p>
                    <p>Acepto y autorizo que el {{$grado->denominacion}} utiulice la información aqui proporcionada para los fines anteriormente señalados.</p>
                </TD>
            </tr>
        </table>
    </div>
    <div class="tablediv">
        <table>
            <tr>
                <TD width="150px">NOMBRE Y FIRMA:</TD><TD class="td_contenido"></TD>
            </tr>    
        </table>
    </div>
    <div class="tablediv">
        <table>
            <tr>
                <TD width="75%"></TD><TD class="descripcion_pequenia" align="rigth">{{$plantel->calle}} {{$plantel->calle}} {{$plantel->colonia}} <br> {{$plantel->municipio}} {{$plantel->estado}} <br> Teléfono: {{$plantel->tel}}</TD>
            </tr>    
        </table>
    </div>
    
    <div class="saltopagina"></div>
    
    <div class="tablediv">
        <table>
            <tr>
                <TD width="75%"></TD><TD class="descripcion_pequenia" align="rigth">2/4</TD>
            </tr>    
        </table>
    </div>
    <table style="width: 100%;">
        <tr>
            <td style="width: 50%;" align="left"><img src="{{asset('storage/grados/'.$grado->imagen)}}" alt="Logo" height="42" width="100" ></td>
            <td style="width: 50%;" align="rigth">{{ $grado->denominacion }}</td>
        </tr>
        <tr>
            <td style="width:50%;" ></td>
            <td style="width:50%;" align="rigth">
                @php
                $fecha= \Carbon\Carbon::createFromFormat('Y-m-d', Date('Y-m-d'));
                $mes = App\Mese::find($fecha->month);
                @endphp
                <p class="descripcion_pequenia"> {{ $plantel->municipio }} a {{$fecha->day}} de {{$mes->name}} de {{$fecha->year}}<p>  
            </td>
        </tr>
    </table>
    <div class="tablediv">
        <table>
            <tr>
                <TD width="150px">4. INVERSIÓN</TD>
            </tr>
        </table>
    </div>
    <div class="tablediv">
        <table style="width:50%">
            <tr>
                @php
                    $inscripcion_concepto=$combinacion->adeudos->whereIn('caja_concepto_id',array(1,4,23))->first();
                @endphp
                <TD width="150px">INSCRIPCIÓN:</TD><TD class="td_contenido">$ {{number_format($inscripcion_concepto->monto)}}</TD>
            </tr>
        </table>
    </div>
    <div class="tablediv">
        <table style="width:50%">
            <tr>
                @php
                    $primer_mensualidad=\App\Adeudo::select('adeudos.*')
                    ->where('adeudos.combinacion_cliente_id', $combinacion->id)
                    ->join('caja_conceptos as cc', 'cc.id', 'adeudos.caja_concepto_id')
                    ->where('bnd_mensualidad',1)
                    ->first();
                @endphp
                <TD width="150px">MENSUALIDAD:</TD><TD class="td_contenido">$ {{number_format($primer_mensualidad->monto, 2)}}</TD>
            </tr>
        </table>
    </div>
    <div class="tablediv">
        <table style="width:100%">
            <tr>
                <TD>
                    @php
                        //dd($plantel);
                    @endphp
                    <p class="descripcion_clausulas">
                        Yo <u> {{ $cliente->ape_paterno }} {{ $cliente->ape_materno }} {{ $cliente->nombre }} {{ $cliente->nombre2 }} </u> 
                        solicito mi Trámite de Inscripción para continuar formando parte de la comunidad educativa del <u>{{ $grado->denominacion }}</u>, 
                        dispuesto a cumplir los requisitos necesarios y en su caso, a seguir las disposiciones tomadas para la transparencia 
                        del proceso de selección y autorización para la inscripción al {{ substr($inscripcion->grupo->name, 0, (strlen($inscripcion->grupo->name)-1)) }}            
                        semestre, del ciclo <u>{{$lectivo->ciclo_escolar}}</u>, turno <u>{{ $inscripcion->grupo->jornada->name }}</u>, <u>{{ $grado->nombre2 }}</u>.

                    </u>
                </TD>
            </tr>
        </table>
    </div>
    <div class="tablediv">
        <table>
            <tr>
                <TD width="150px">Comprometiendome a:</TD>
            </tr>
        </table>
    </div>
    <div class="tablediv">
        <table>
            <tr>
                <TD class="descripcion_clausulas">
                    <ol type="A">
                        <li>
                            Sujetarme a lo establecido por el reglamento interno del {{ $grado->denominacion }}, del cual entregué responsiva al inscribirme en esta institución.
                        </li>
                        <li>Aceptar las disposiciones que marca la Secretaría de Educación Pública y la DGAIR.</li>
                        <li>Pagar la colegiatura puntualmente, durante el periodo del día 28 del mes anterior y hasta el día 10 del mes corriente, de no ser así, se me cobrarán recargos moratorios del 10% adicionales (Acorde al artículo 94° Reglamento General del {{ $grado->denominacion }}) que deberé cubrir al mismo tiempo que la colegiatura.</li>
                        <li>Todo integrante de la comunidad estudiantil que se atrase en una colegiatura causará que su nombre no aparezca en listas y se computarán como inasistencias para efecto del examen final (Acorde al artículo 109° Reglamento General del {{ $grado->denominacion }}).</li>
                        <li>Efectuar el pago referenciado o canjear el Boucher bancario original en la caja de la Institución (Acorde al artículo 75° inciso XXII y 99°, Reglamento General del {{ $grado->denominacion }}), siempre y cuando no rebase el día 10 de cada mes para que no te afecte la ausencia del comprobante o ticket en tu control de asistencia.</li>
                        <li>Cubrir el costo del concepto de inscripción al <u>{{ substr($inscripcion->grupo->name, 0, (strlen($inscripcion->grupo->name)-1)) }}</u> semestre de la licenciatura que es de <u>$ {{number_format($inscripcion_concepto->monto)}}</u> pesos moneda nacional.</li>
                        <li>Cada semestre se realizará un gasto correspondiente a la reinscripción, esto durante los cuatro años que dure la carrera.</li>
                        <li>Para poder reinscribirme deberé de cubrir el requisito de no adeudar más de dos materias que obligatoriamente deberán de corresponder exclusivamente al semestre anterior.
                            En caso de que alguna de las materias adeudadas sea seriada sólo se podrá inscribir a las materias que tenga derecho (Acorde al artículo 84°, Reglamento General del {{ $grado->denominacion }}).
                        </li>
                        <li>Tomar en cuenta que para acreditar alguna materia en extraordinario sólo cuento con dos oportunidades: una al final de semestre correspondiente y la otra al término del siguiente. De no acreditarlo en éstas, la materia pasará a ser de recursamiento.</li>
                        <li>Cuando el alumno adeude cuatro o más materias sólo podrá ser reinscrito a éstas (Acorde al artículo 85°, Reglamento General del {{ $grado->denominacion }}) por lo que se volverá un alumno de recursamiento.</li>
                        <li>Cubrir el concepto de cursos especiales requeridos, proceso indispensable para tu titulación.</li>
                        <li>Adquirir los manuales de trabajo correspondientes a los programas especiales con el proveedor externo autorizado por la Institución, los cuales son instrumentos de trabajo y sin ellos no se me permitirá la entrada a clase. Los manuales cambian cada módulo y se deben de presentar a más tardar una semana posterior al inicio del curso.</li>
                        <li>Avisar la separación temporal o definitiva de la Institución, así como pagar la colegiatura del mes corriente y presentar el recibo, de lo contrario las colegiaturas se seguirán acumulando, hasta presentar la baja por escrito a la institución. (Acorde al artículo 110°, Reglamento General del {{ $grado->denominacion }}).</li>
                        <li>Portar diariamente su credencial en un lugar visible como gafete de identificación (Acorde al artículo 75° inciso VI, Reglamento General del {{ $grado->denominacion }}) y entregar el ticket o comprobante de asistencia correspondiente al mes en curso para su asistencia diaria. Ambos documentos serán presentados al ingreso a cualquiera de las unidades del {{ $grado->denominacion }}.</li>
                        <li>Para poder acreditar las materias de cada semestre es indispensable contar con el 80% de asistencia en cada una de ellas, de no ser así, sólo tendrán derecho a exámenes extraordinarios siempre y cuando cuenten con un mínimo del 60% de asistencia, de lo contrario será materia(s) para recursamiento; generando un atraso académico (Acorde al artículo 31° y 37° inciso IV, Reglamento General del {{ $grado->denominacion }}).</li>
                        <li>Sólo se podrán justificar faltas si se presentan recetas médicas de instituciones gubernamentales a más tardar tres días hábiles después de la falta, permitiendo con ello que el docente reciba los trabajos, tareas y/o actividades generadas durante su ausencia, dejando a consideración de cada docente el efecto de la misma.
                            La justificación de las faltas no implica la anulación de la inasistencia por lo que todas las faltas serán computadas para efectos de derecho a examen final o extraordinario.
                        </li>
                        <li>Tres retardos se consideran como una falta (Acorde al artículo 121°, Reglamento General del {{ $grado->denominacion }}).</li>
                        <li>El tiempo máximo de tolerancia para asistir a la primera hora de clases es de 10 minutos (Acorde al artículo 122°, Reglamento General del {{ $grado->denominacion }}). Cualquier situación particular que afecte el retraso en acceso a clases deberá tratarse directamente en coordinación y/o dirección.</li>
                        <li>Realizar 600 horas de Prácticas Profesionales en un lugar en el que desempeñes adecuadamente el conocimiento adquirido, acorde al perfil profesional de la Licenciatura, habiendo cubierto el 50% de créditos. (Acorde al artículo 158°, Reglamento General del {{ $grado->denominacion }}).</li>
                        <li>Realizar 480 horas de Servicio Social en un tiempo no menor a 6 meses, teniendo como requisito el 70% de créditos, dentro de una dependencia gubernamental (Acorde al artículo 137°, Reglamento General del {{ $grado->denominacion }}).</li>
                        <li>Al término de la carrera, deberé pagar la Revisión de estudios y proceso de certificación (Acorde al artículo 101°, Reglamento General del {{ $grado->denominacion }}).</li>
                        <li>La Institución tendrá la obligación de entregar un recibo oficial de todos los pagos que se realicen en caja al momento mismo de efectuarlo.</li>
                        <li>La Institución no se hará responsable de ningún pago efectuado fuera de caja (Acorde al artículo 97°, Reglamento General del {{ $grado->denominacion }}) a terceras personas distintas a la cajera, aunque sea personal que labore en la Institución o dé recibos que no sean los oficiales del cual se enseña muestra.</li>
                        <li>La Institución por ningún motivo aceptará parcialidades de ningún pago.</li>
                        <li>El incremento de la colegiatura mensual será anual de un 10%, con base en el periodo de ingreso (Acorde al artículo 104°, Reglamento General del {{ $grado->denominacion }}).</li>
                        <li>La institución no se hace responsable por la pérdida o extravío de ningún Boucher por el concepto de algún pago (Acorde al artículo 95° y 96°, Reglamento General del {{ $grado->denominacion }}).</li>
                        <li>Acuso de recibo el Reglamento Institucional, por lo que manifiesto haberlo leído y tener conocimiento de su contenido, mismo que acepto estar de acuerdo con las disposiciones en él establecidas. BB. De acuerdo con la especialidad o curso en el que me encuentro inscrito recibiré los diplomas correspondientes al o los RVOE(s) de la especialidad o cursos correspondientes.</li>
                        <li>En caso de ser acreedor a algún tipo de descuento o beca me comprometo a cumplir con los requisitos en tiempo y forma establecidos en convocatoria, reglamento y/o convenio institucional. DD. El Reembolso de los conceptos pagados para inscripción únicamente aplica al 100% por causas imputables a la institución.</li>
                        <li>Cuando sea por causas o decisiones imputables al alumno, padre o tutor, y si no han iniciado las clases, solo se reembolsará el 70% de lo pagado por conceptos de inscripción, tramites, servicios escolares o colegiaturas.</li>
                        <li>Una vez iniciadas las clases NO aplica reembolso alguno.</li>
                        <li>En caso de entregar documentación que no sea auténtica o que presente alteración o enmendadura de alguna clase, o bien, no cumple con los requisitos para servir como antecedente académico válido para los estudios que deseo realizar, la institución no se compromete ni se obliga por ninguna acción, incidente, causa o sanción administrativa, civil o penal que pudiera iniciar o imponer la autoridad competente, asimismo, no se hace responsable de los daños o perjuicios que esto ocasione, lo cual aplica durante o al término la licenciatura.</li>
                        <li>Para el caso de pagos realizados por concepto de uniformes, manuales, kits, congresos, certificaciones y otros servicios educativos, la institución no adquiere responsabilidad alguna, al tratarse de proveedores externos.</li>
                        <li>Todos los pagos realizados para procesos escolares y académicos, así como para actividades extraescolares, únicamente serán válidos con la ficha de depósito en original.</li>
                        <li>Para los procesos de emisión de certificados parciales o totales, tramites de títulos y cedulas profesionales, la institución se deslinda de los tiempos de respuesta que las autoridades educativas correspondientes empleen para la realización de estos procesos, sin ser responsable de los daños o perjuicios que se puedan ocasionar al alumno por la entrega tardía del documento.</li>
                        <li>La institución no se responsabiliza ni hará válido cualquier pago realizado en otra instancia que no sea la autorizada para recibir pagos (caja del plantel, institución bancaria o número de cuenta autorizados).</li>
                    </ol>
                </TD>
            </tr>
        </table>
    </div>
    <div class="tablediv">
        <table>
            <tr>
                <TD >DECLARO QUE LA INFORMACIÓN QUE SE ME HA PROPORCIONADO ES CLARA, COMPLETA Y ESTOY DE ACUERDO CON LO AQUÍ REFERIDO.</TD>
            </tr>
        </table>
    </div>
    <br><br><br>
    <div class="tablediv">
        <table>
            <tr>
                <TD ></TD><td class="td_contenido" width="150px"></td><td></td><td width="150px" class="td_contenido"></td><td></td>
            </tr>
            <tr>
                <TD></TD><TD>Nombre y firma del padre o tutor</TD><TD></TD><TD>Nombre y firma del alumno</TD><td></td>
            </tr>
        </table>
    </div>
    <div class="tablediv">
        <table>
            <tr>
                <TD width="75%"></TD><TD class="descripcion_pequenia" align="rigth">{{$plantel->calle}} {{$plantel->calle}} {{$plantel->colonia}} <br> {{$plantel->municipio}} {{$plantel->estado}} <br> Teléfono: {{$plantel->tel}}</TD>
            </tr>    
        </table>
    </div>
    
    <div class="saltopagina"></div>
    <div class="tablediv">
        <table>
            <tr>
                <TD width="75%"></TD><TD class="descripcion_pequenia" align="rigth">3/4</TD>
            </tr>    
        </table>
    </div>
    <table style="width: 100%;">
        <tr>
            <td style="width: 50%;" align="left"><img src="{{asset('storage/grados/'.$grado->imagen)}}" alt="Logo" height="42" width="100" ></td>
            <td style="width: 50%;" align="rigth">{{ $grado->denominacion }}</td>
        </tr>
        <tr>
            <td style="width:50%;" >FICHA DE IDENTIFICACIÓN INSTITUCIONAL</td>
            <td style="width:50%;" align="rigth">
                @php
                $fecha= \Carbon\Carbon::createFromFormat('Y-m-d', Date('Y-m-d'));
                $mes = App\Mese::find($fecha->month);
                @endphp
                <p class="descripcion_pequenia"> {{ $plantel->municipio }} a {{$fecha->day}} de {{$mes->name}} de {{$fecha->year}}<p>  
            </td>
        </tr>
    </table>
    
    <table style="width:100%; border: 1px solid; ">
        <tbody>
            <tr>
                <th colspan="2" style="font-size: 10px; background:hsl(0, 0.90%, 58.40%); color: #000; border-style: solid; border: thin ridge grey;">GENERALES</th>
            </tr>
            <tr>
                <td>
                    <div class="tablediv">
                        <table>
                            <tr >
                                <TD width="100px">Alumno:</TD><TD class="td_contenido">{{ $cliente->ape_paterno }} {{ $cliente->ape_materno }} {{ $cliente->nombre }} {{ $cliente->nombre2 }}</TD>
                            </tr>
                        </table>
                    </div>
                    <div class="tablediv">
                        <table >
                            <tr>
                                <TD width="110px">Fecha de nacimiento:</TD><TD class="td_contenido">{{ $cliente->fec_nacimiento }}</TD>
                                <TD width="150px">Turno:</TD><TD class="td_contenido">{{ $inscripcion->grupo->jornada->name }}</TD>
                            </tr>
                        </table>
                    </div>
                    <div class="tablediv">
                        <table>
                            <tr>
                                <TD width="100px">Licenciatura:</TD><TD class="td_contenido">{{ $grado->nombre2 }}</TD>
                                
                            </tr>
                        </table>
                    </div>
                    <div class="tablediv">
                        <table>
                            <tr>
                                <TD width="100px">Cuatrimestre:</TD><TD class="td_contenido">{{ substr($inscripcion->grupo->name, 0, (strlen($inscripcion->grupo->name)-1)) }}</TD>
                                <TD width="150px">Matricula:</TD><TD class="td_contenido">{{ $cliente->matricula }}</TD>
                            </tr>
                        </table>
                    </div>
                    <div class="tablediv">
                        <table>
                            <tr>
                                <td width="100px">Domicilio</td><td class="td_contenido">{{ $cliente->calle }} {{ $cliente->no_exterior }} {{ $cliente->colonia }} {{ $cliente->municipio->name }} {{ $cliente->estado->name }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="tablediv">
                        <table>
                            <tr>
                                <TD width="100px">Tel. Casa:</TD><TD class="td_contenido">{{ $cliente->tel_fijo }}</TD>
                                <TD width="75px">Celular:</TD><TD class="td_contenido">{{ $cliente->tel_cel }}</TD>
                                <TD width="75px">E-mail:</TD><TD class="td_contenido">{{ $cliente->mail }}</TD>
                            </tr>
                        </table>
                    </div>
                    @if(!is_null($cliente->nombre_padre))
                <div class="tablediv">
                    <table>
                        <tr>
                            <TD width="150px">Padre o titular:</TD><TD class="td_contenido">{{ $cliente->nombre_padre }}</TD>
                        </tr>
                    </table>
                </div>
                <div class="tablediv">
                    <table>
                        <tr>
                            <TD width="150px">DOMICILIO:</TD><TD class="td_contenido">{{ $cliente->dir_padre }}</TD>
                        </tr>
                        
                    </table>
                </div>
                
                <div class="tablediv">
                    <table>
                        <tr>
                            <TD width="150px">TEL. CASA:</TD><TD class="td_contenido">{{ $cliente->tel_padre }}</TD>
                            <TD width="150px">TEL. CELULAR:</TD><TD class="td_contenido">{{$cliente->cel_padre}}</TD>
                            <TD width="150px">CORREO ELECTRONICO:</TD><TD class="td_contenido">{{ $cliente->mail_padre }}</TD>
                        </tr>    
                    </table>
                </div>
                
                @elseif(!is_null($cliente->nombre_madre))
                <div class="tablediv">
                    <table>
                        <tr>
                            <TD width="150px">Padre o titular:</TD><TD class="td_contenido">{{ $cliente->nombre_madre }}</TD>
                        </tr>
                    </table>
                </div>
                <div class="tablediv">
                    <table>
                        <tr>
                            <TD width="150px">DOMICILIO:</TD><TD class="td_contenido">{{ $cliente->dir_madre }}</TD>
                        </tr>
                    </table>
                </div>
                <div class="tablediv">
                    <table>
                        <tr>
                            <TD width="150px">TEL. CASA:</TD><TD class="td_contenido">{{ $cliente->tel_madre }}</TD>
                            <TD width="150px">TEL. CELULAR:</TD><TD class="td_contenido">{{$cliente->cel_madre}}</TD>
                            <TD width="150px">CORREO ELECTRONICO:</TD><TD class="td_contenido">{{ $cliente->mail_madre }}</TD>
                        </tr>    
                    </table>
                </div>
                
                @elseif(!is_null($cliente->nombre_acudiente))
                <div class="tablediv">
                    <table>
                        <tr>
                            <TD width="150px">Padre o titular:</TD><TD class="td_contenido">{{ $cliente->nombre_acudiente }}</TD>
                        </tr>
                    </table>
                </div>
                <div class="tablediv">
                    <table>
                        <tr>
                            <TD width="150px">DOMICILIO:</TD><TD class="td_contenido">{{ $cliente->dir_acudiente }}</TD>
                        </tr>
                    </table>
                </div>
                
                <div class="tablediv">
                    <table>
                        <tr>
                            <TD width="150px">TEL. CASA:</TD><TD class="td_contenido">{{ $cliente->tel_acudiente }}</TD>
                            <TD width="150px">TEL. CELULAR:</TD><TD class="td_contenido">{{$cliente->cel_acudiente}}</TD>
                            <TD width="150px">CORREO ELECTRONICO:</TD><TD class="td_contenido">{{ $cliente->mail_acudiente }}</TD>
                        </tr>    
                    </table>
                </div>
                @else
                <div class="tablediv">
                    <table>
                        <tr>
                            <TD width="150px">Padre o titular:</TD><TD class="td_contenido"></TD>
                        </tr>
                        
                    </table>
                </div>
                <div class="tablediv">
                    <table>
                        <tr>
                            <TD width="150px">DOMICILIO:</TD><TD class="td_contenido"></TD>
                        </tr>
                        
                    </table>
                </div>
                
                <div class="tablediv">
                    <table>
                        <tr>
                            <TD width="150px">TEL. CASA:</TD><TD class="td_contenido"></TD>
                            <TD width="150px">TEL. CELULAR:</TD><TD class="td_contenido"></TD>
                            <TD width="150px">CORREO ELECTRONICO:</TD><TD class="td_contenido"></TD>
                        </tr>    
                    </table>
                </div>
                @endif
                </td>
                <td style="vertical-align:top;">
                    <table>    
                        <tr>
                            <td style="width:50px; border: 1px solid; text-align:center; padding:15px"> <br><br> <br><br><br> </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <th colspan="2" style="font-size: 10px; background:hsl(0, 0.90%, 58.40%); color: #000; border-style: solid; border: thin ridge grey;">ESTADO FISICO</th>
            </tr>
            <tr>
                <td colspan="2">
                    <div class="tablediv">
                        <table>
                            <tr>
                                <TD width="150px">Enfermedades que padece:</TD><TD class="td_contenido"></TD>
                            </tr>
                        </table>
                    </div>
                    <div class="tablediv">
                        <table>
                            <tr>
                                <TD width="150px">Medicamentos que se administra:</TD><TD class="td_contenido"></TD>
                            </tr>
                        </table>
                    </div>
                    <div class="tablediv">
                        <table>
                            <tr>
                                <TD width="175px">Acción sugerida en caso de dolor de cabeza:</TD><TD class="td_contenido"></TD>
                            </tr>
                        </table>
                    </div>
                    <div class="tablediv">
                        <table>
                            <tr>
                                <TD width="175px">Accion sugerica en caso de malestra estomacal:</TD><TD class="td_contenido"></TD>
                            </tr>
                        </table>
                    </div>
                    <div class="tablediv">
                        <table>
                            <tr>
                                <TD>En caso de emergencia y en ausencia de los padres, favor de avisar a (3 opciones):</TD>
                            </tr>
                        </table>
                    </div>
                    <div class="tablediv">
                        <table>
                            <tr>
                                <TD style="width:10%;">Nombre:</TD><TD class="td_contenido" style="width:23%;"> </TD>
                                <TD style="width:10%;">Parentesco:</TD><TD class="td_contenido" style="width:23%;"> </TD>
                                <TD style="width:10%;">Teléfono:</TD><TD class="td_contenido" style="width:23%;"> </TD>
                            </tr>
                        </table>
                    </div>
                    <div class="tablediv">
                        <table>
                            <tr>
                                <TD style="width:10%;">Nombre:</TD><TD class="td_contenido" style="width:23%;"> </TD>
                                <TD style="width:10%;">Parentesco:</TD><TD class="td_contenido" style="width:23%;"> </TD>
                                <TD style="width:10%;">Teléfono:</TD><TD class="td_contenido" style="width:23%;"> </TD>
                            </tr>
                        </table>
                    </div>
                    <div class="tablediv">
                        <table>
                            <tr>
                                <TD style="width:10%;">Nombre:</TD><TD class="td_contenido" style="width:23%;"> </TD>
                                <TD style="width:10%;">Parentesco:</TD><TD class="td_contenido" style="width:23%;"> </TD>
                                <TD style="width:10%;">Teléfono:</TD><TD class="td_contenido" style="width:23%;"> </TD>
                            </tr>
                        </table>
                    </div>
                </td>   
            </tr>
            <tr>
                <th colspan="2" style="font-size: 10px; background:hsl(0, 0.90%, 58.40%); color: #000; border-style: solid; border: thin ridge grey;">PERSONALIDAD</th>
            </tr>
            <tr>
                <td colspan="2">
                    <div class="tablediv">
                        <table>
                            <tr>
                                <TD width="150px">Caracter:</TD><TD class="td_contenido"></TD>
                            </tr>
                        </table>
                    </div>
                    <div class="tablediv">
                        <table>
                            <tr>
                                <TD width="150px">Temperamento:</TD><TD class="td_contenido"></TD>
                            </tr>
                        </table>
                    </div>
                    <div class="tablediv">
                        <table>
                            <tr>
                                <Th width="150px" align="left" style="border: 1px solid;">EVOLUCIÓN ESCOLAR Y RENDIMIENTO ACADEMICO:</Th>
                            </tr>
                        </table>
                    </div>
                    <div class="tablediv">
                        <table>
                            <tr>
                                <TD width="150px">No. de materias aprobadas:</TD><TD class="td_contenido"></TD>
                                <TD width="150px">No. de materias no aprobadas:</TD><TD class="td_contenido"></TD>
                            </tr>
                        </table>
                    </div>
                    <div class="tablediv">
                        <table>
                            <tr>
                                <TD width="150px">Enlistar las materias pendientes de acreditar:</TD>
                            </tr>
                        </table>
                    </div>
                    <table>
                        <thead style="font-size: 10px; background:hsl(0, 0.90%, 58.40%); color: #000; border-style: solid; border: thin ridge grey;">
                            <th>Cuatrimestre</th><th>Materia</th><th>Docente</th><th>Calificación Extraordinaria</th>
                        </thead>
                        <tbody class="materias">
                            <tr>
                                <td><br></td><td></td><td></td><td></td>
                            </tr>
                        </tbody>
                    </table>
                </td>
                
            </tr>
        </tbody>
    </table>
    <div class="tablediv">
        <table>
            <tr>
                <TD width="75%"></TD><TD class="descripcion_pequenia" align="rigth">{{$plantel->calle}} {{$plantel->calle}} {{$plantel->colonia}} <br> {{$plantel->municipio}} {{$plantel->estado}} <br> Teléfono: {{$plantel->tel}}</TD>
            </tr>    
        </table>
    </div>


    <div class="saltopagina"></div>
    <div class="tablediv">
        <table>
            <tr>
                <TD width="75%"></TD><TD class="descripcion_pequenia" align="rigth">4/4</TD>
            </tr>    
        </table>
    </div>

    <table style="width: 100%;">
        <tr>
            <td style="width: 50%;" align="left"><img src="{{asset('storage/grados/'.$grado->imagen)}}" alt="Logo" height="42" width="100" ></td>
            <td style="width: 50%;" align="rigth"></td>
        </tr>
        
    </table>
    <div class="tablediv">
        <table style="width:100%">
            <tr>
                <td>
                    <p>Se hace de su conocimiento que en cumplimiento con la 
                        <strong>Ley Federal de Protección de Datos Personales en Poseción de los Particulares 
                            y con el fin de asegurar la protección y privacidad de los datos personales, asi 
                            como regular el acceso, rectificación, cancelación y opocision del manejo de los 
                            mismos</strong> (Fundamento jurídico: Art. 15 Constitucional Art. 1 y 2 ) En El 
                            {{ $grado->denominacion }}, establece lo siguiente:
                    </p>
                    <p>
                        Aviso de privacidad:
                    </p>
                    <p>
                        En {{ $grado->denominacion }}, ubicado en domicilio en 
                        {{$plantel->calle}} {{$plantel->calle}} {{$plantel->colonia}} <br> {{$plantel->municipio}} {{$plantel->estado}}, 
                        propietario del www.grupocedva.com, le informa que utilizará sus datos personales sensibles para fines 
                        académicos, de seguimiento, administrativos y de promoción exclusivos, así como para dar seguimineto a su proceso de admisión,
                        inscripción, reinscripión y acreditación. 
                    </p>
                    <p>
                        El ejercicio de los derechos de acceso, rectificación, cancelación, opocisión, limitación de uso o la 
                        revocación del consentimiento, podrá solicitarse por escrito en la Dirección de su plantel o al corrreo 
                        electrónico privacidad@grupocedva.com
                    </p>
                    <p>
                        La Política de Privacidad y los cambios en el presente aviso se publican en la página http://www.grupocedva.com/privacidad. 
                    </p>
                    <p>
                        Al proporcionar sus datos personales significa que ha leído, entendido y aceptado los términos antes expuestos.
                    </p>
                    <p>
                        Así mismo notifico que la (s) personas que pueden recibir información y/o documentos referentes a mi persona son:
                    </p>
                    <div class="tablediv">
                        <table>
                            <tr>
                                <TD width="5%">1.</TD><TD class="td_contenido" style="width:55%"></TD>
                                <TD width="100px">Parentesco</TD><TD class="td_contenido" style="width:30%"></TD>
                            </tr>
                        </table>
                    </div>
                    <div class="tablediv">
                        <table>
                            <tr>
                                <TD width="5%">2.</TD><TD class="td_contenido" style="width:55%"></TD>
                                <TD width="10%">Parentesco</TD><TD class="td_contenido" style="width:30%"></TD>
                            </tr>
                        </table>
                    </div>
                </td>
            </tr>
        </table>
    </div>

    
</body>
</html>