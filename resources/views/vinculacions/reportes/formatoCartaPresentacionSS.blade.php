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
            font-size: 14px; padding: 2px 0px; color: #000;}
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
<body style="padding:8%;font-family: Segoe UI;">
    <br><br>
    <table>
        <tr>
            <td style="width: 20%;">
                
            </td>
            <td align="center">
                
            </td>
            <td style="width: 20%;">
                <!--<img src="{{asset('storage/especialidads/'.$combinacion->especialidad->imagen)}}" alt="Logo" height="42" width="42" > </td>-->
            </td>
        </tr>
    </table>
    
    <div class="tablediv">
        <table>
            <tr>
                <td width="30%"></td><td width="30%"></td><td class="" align="right">Fecha: {{ $vinculacion->fec_carta_ss }}</td>
            </tr>
            <tr>
                <td width="30%"></td><td width="30%"></td><td class="" align="right">ASUNTO: CARTA DE PRESENTACION</td>
            </tr>
            <tr>
                <td width="30%"></td><td width="30%"></td><td class="" align="right">SERVICIO SOCIAL</td>
            </tr>
        </table>
    </div>
    <br>
    <br>
    <div class="tablediv">
        <table>
            <tr>
                <TD>{{ $vinculacion->nombre_contacto }}</TD>
            </tr>
            <tr>
                <TD>{{ $vinculacion->puesto }}</TD>
            </tr>
            <tr>
                <TD>PRESENTE</TD>
            </tr>
        </table>
    </div>
    <div class="tablediv">
        <table>
            <tr>
                <td width="20px">
                    <p align="justify">Por este medio me permito presentar al C. {{ $cliente->nombre }} {{ $cliente->nombre2 }} {{ $cliente->ape_paterno }} 
                    {{ $cliente->ape_materno }} alumno de la carrera de {{ $combinacion->grado->name }}, con número de control: {{ $cliente->matricula }} 
                    quien desea realizar sus Servicio Social en el área de {{ $vinculacion->area }} que usted dignamente 
                    representa, hasta cubrir un total de 480 Hrs, en
                      un periodo no mayor a 6 meses. Su numero de poliza es: {{ $vinculacion->no_poliza }} de la compañía de seguros {{ $vinculacion->aseguradora }}.
                    </p> 
                    <p align="justify">
                        Agradeciendo sus atenciones prestadas a la presente, quedo de a sus órdenes.
                    </p>
                </td>
            </tr>
            
        </table>
    </div>
    <br><br>
    <div class="tablediv">
        <table>
            <tr>
                <td width=30% height=40px></td><td height=40px align="center">Atentamente:</td><td height=40px width=30%></td>
            </tr>
            <tr>
                <td colspan=3 height=100px></td>
            </tr>
            <tr>
                <td width=30%></td><td class="td_contenido">{{ $vinculacion->empleado->nombre }} {{ $vinculacion->empleado->ape_paterno }} {{ $vinculacion->empleado->ape_materno }}</td><td width=30%></td>
            </tr>
            <tr>
                <td width=30%></td><td align="center"> {{ $vinculacion->empleado->puesto->name }} </td><td width=30%></td>
            </tr>
            <tr>
                <td width=30%></td><td align="center"> Tél. {{ $vinculacion->empleado->tel_fijo }} </td><td width=30%></td>
            </tr>
            <tr>
                <td width=30%></td><td align="center"> Email {{ $vinculacion->empleado->mail_empresa }} </td><td width=30%></td>
            </tr>
        </table>
    </div>
    <br><br>
    
    
</body>
</html>