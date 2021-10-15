<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
        <style>
            
            body {
                font-family: Arial, Helvetica, sans-serif; 
                font-size: 14px; 
                padding: 5px 20px; 
                color: #000; 
                }
            table {
                font-family: Arial, Helvetica, sans-serif; 
                font-size: 14px;
                color: #000; 
                }
            p{
                text-align: justify;
            } 
          </style>
    </head>
    @php
            $inicio=Carbon\Carbon::createFromFormat('Y-m-d', $inscripcion->lectivo->inicio);
            $fin=Carbon\Carbon::createFromFormat('Y-m-d', $inscripcion->lectivo->fin);   
            if(!is_null($inscripcion->especialidad->vencimiento_rvoe)){
                $vencimiento=Carbon\Carbon::createFromFormat('Y-m-d', $inscripcion->especialidad->vencimiento_rvoe);   
            }
            
            
            
    @endphp
    <body style="margin:10px;padding:5px;">
        <table width="100%">
            <tr>
                <td> 
                    <img src="{{asset('storage/especialidads/'.$inscripcion->especialidad->imagen)}}" alt="Logo" height="25%" width="25%" > 
                </td>
                <td align="right"> 
                    Fecha Emisión:{{ Date('d-m-Y') }}
                    <img src="{{asset('imagenes/clientes/'.$cliente->id."/".$foto)}}" alt="Foto" height="25%" width="25%" > </td>
                </td>
            </tr>
            <tr>
                <td align="center">{{ $cliente->plantel->razon }}</td>
            </tr>
            @if($inscripcion->especialidad->rvoe<>"")
            <tr>
                <td align="center">ACUERDOS  DE  DGCFT  No. {{ optional($inscripcion->especialidad)->rvoe }} DE FECHA {{ optional($vencimiento)->format('d-m-Y') }} </td>
            </tr>
            @endif
            <TR>
                <td align="center">CCT: {{ $inscripcion->especialidad->ccte }}</td>
            </TR>
        </table>
        
        <br/><br/><br/>
        A QUIEN CORRESPONDA <br>
        P R E S E N T E    
        <br/><br/><br/>
        <p >
            Por medio de la Presente se informa que el C. {{ $cliente->nombre }} {{ $cliente->nombre2 }} 
            {{ $cliente->ape_paterno }} {{ $cliente->ape_materno }}, es alumno {{ $cliente->stCliente->name }} de la 
            Especialidad en {{ $inscripcion->grado->name }}, 
            misma que tiene duracion de {{ $inscripcion->especialidad->duracion }}, dividida en {{ $inscripcion->especialidad->modulos }} 
            de los cuales cursa el {{ $inscripcion->periodo_estudio->name }} en el horario {{ $inscripcion->turno->name }}, 
            cabe hacer mencion que el modulo inicio el dia {{ $inicio->format('d-m-Y') }} y finalizara el dia {{ $fin->format('d-m-Y') }}.
        </p>
        </p>
            Se extiende la presente a peticion para los fines  del interesado (a)  convengan. 
        </p>

        <div align="center">
            A T E N T A M E N T E. <br>
            <img src="data:image/png;base64, 
                                {!! base64_encode(QrCode::format('png')->size(100)->generate('Cliente:'.$cliente->id.', RVOE:'.$inscripcion->especialidad->rvoe.', CCT:'.$inscripcion->especialidad->ccte.', Plantel:'.$cliente->plantel->razon.', Token:'.$token->token)) !!} ">    
            <br>
            {{ $cliente->plantel->razon }}
        </div>

          
      </div>
      
    </body>
  </html>
  