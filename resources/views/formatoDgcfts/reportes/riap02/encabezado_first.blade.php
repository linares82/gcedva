<table width="100%">
                    <tr>
                        <th><img src="{{asset('images/sep.jpg')}}" alt='logo_sep' width="250px;"></img></th>
                        <th align='center'>SUBSECRETARÍA DE EDUCACIÓN MEDIA SUPERIOR <br/>
                            DIRECCIÓN GENERAL DE CENTROS DE FORMACIÓN PARA EL TRABAJO <br/>
                            DIRECCIÓN TÉCNICA <br/>
                            SUBDIRECCIÓN DE VINCULACIÓN Y APOYO ACADÉMICO <br/>
                            REGISTRO DE INSCRIPCIÓN Y ACREDITACIÓN (RIAP-02) <br/>
                        </th>
                    </tr>
                </table>
                <br/>
                <table width="100%">
                    <tr>
                        <td>ENLACE OPERATIVO SCEO:<strong>{{$grado->enlace_nombre}}</strong></td>
                        <td colspan="2">PLANTEL PARTICULAR: <strong>{{$grado->denominacion}}</strong></td>
                        <td>CLAVE CCT: {{$grado->cct}} </td>
                    </tr>
                    <tr>
                        <td colspan="2">ESPECIALIDAD:<strong>{{$formatoDgcft->especialidad}}</strong></td>
                        <td>GRUPO: <strong>{{$formatoDgcft->grupo}}</strong></td>
                        <td>FECHA: {{$emision}} </td>
                    </tr>
                    <tr>
                        <td> FECHA DE INICIO:<strong>{{$formatoDgcft->fec_inicio}}</strong></td>
                        <td>FECHA DE FIN: <strong>{{$formatoDgcft->fec_fin}}</strong></td>
                        <td>DURACION EN HRS.: 
                            @php
                                $suma_horas=0;
                                foreach($materias as $materia){
                                    $suma_horas=$suma_horas + $materia->duracion_horas;
                                }
                            @endphp
                            {{ $suma_horas }}
                        </td>
                        <td>HORARIO.: {{$formatoDgcft->horario}} </td>
                    </tr>
                    
                </table>