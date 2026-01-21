<table width="100%" border="0" cellpadding="10" cellspacing="0" bordercolor="#FFFFFF" class="Texto1" align="center">
                    <thead>
                        <th colspan="2" width="50%"> INSCRIPCION </th><th colspan="2" width="50%"> ACREDITACION </th>
                    </thead>
                    <tr>
                        <tr>
                        <td align="center" valign="bottom" width="25%" height="100">
                            <span style="font-weight: bold">
                                <u>
                                {{$formatoDgcft->plantelR->director->nombre}} {{$formatoDgcft->plantelR->director->ape_paterno}} {{$formatoDgcft->plantelR->director->ape_materno}}
                                </u>
                            </span>
                            <br>
                              @if($formatoDgcft->plantelR->director->genero==1)
                              NOMBRE Y FIRMA DEL DIRECTOR
                              @else
                              NOMBRE Y FIRMA DE LA DIRECTORA
                              @endif
                        </td>  
                            <td align="center" valign="bottom" width="25%" height="50" >
                                <table width="100%"><tr><td style="border-bottom: 1px solid black;"></td></tr></table>
                                SELLO
                            </td> 
                            <td align="center" valign="bottom" width="25%" height="100">
                            <span style="font-weight: bold">
                                <u>
                                {{$formatoDgcft->plantelR->director->nombre}} {{$formatoDgcft->plantelR->director->ape_paterno}} {{$formatoDgcft->plantelR->director->ape_materno}}
                                </u>
                            </span>
                            <br>
                              @if($formatoDgcft->plantelR->director->genero==1)
                              NOMBRE Y FIRMA DEL DIRECTOR
                              @else
                              NOMBRE Y FIRMA DE LA DIRECTORA
                              @endif
                        </td>  
                            <td align="center" valign="bottom" width="25%" height="50">
                            <table width="100%"><tr><td style="border-bottom: 1px solid black;"></td></tr></table>
                                SELLO</td> 
                        </tr>
                        <tr>
                            <td align="center" valign="bottom" height="100"><span style="font-weight: bold"><u>{{$grado->enlace_nombre}}</u></span><br>
                                NOMBRE Y FIRMA DEL ENLACE OPERATIVO</td> 
                            <td align="center" valign="bottom" height="">
                            <table width="100%"><tr><td style="border-bottom: 1px solid black;"></td></tr></table>
                                    SELLO</td> 
                            <td align="center" valign="bottom" height="50"><span style="font-weight: bold"><u>{{$grado->enlace_nombre}}</u></span><br>
                                NOMBRE Y FIRMA DEL ENLACE OPERATIVO</td> 
                            <td align="center" valign="bottom" height="">
                            <table width="100%"><tr><td style="border-bottom: 1px solid black;"></td></tr></table>
                                    SELLO</td> 
                        </tr>
                    </tbody>
                </table>
                <br/>
                <table width="45%" border="0" cellpadding="10" cellspacing="0" bordercolor="#FFFFFF" class="Texto1" align="center">
                    <tbody><tr>  
                    </tr>
                    </tbody>
                </table> 