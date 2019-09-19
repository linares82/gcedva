<html>
  <head>
      <style>
        @media print {
        th { background: #0046c3; color: #fff; max-width: 400px; padding: 1px 1px; }
        td { font-family: arial; font-size: 8px; color: #000; text-align:center;}
        table { padding: 1px 1px;width: 100%;}
        #tbl_frontal { background: url({{asset('images/cred_frontal.jpg')}}) no-repeat;
                            background-size:200px 307px;}
        }
        
          
        th { background: #0046c3; color: #fff; max-width: 400px; padding: 1px 1px;}
        td { font-family: arial; font-size: 8px; color: #000; text-align:center;}
        #td_frontal { font-family: arial; font-size: 9px; padding: 15px 15px; color: #fff; text-align:center;}
        /*table { padding: 10px 10px; width: 100%;}*/
        #tbl_frontal { background: url({{asset('images/cred_frontal.jpg')}}) no-repeat;
                            background-size:200px 307px;}
      </style>
    
    
  </head>
  <body>
 
      <table id="tbl_frontal">
      <tbody>
          <tr><td></td></tr><tr><td></td></tr><tr><td></td></tr><tr><td></td></tr><tr><td></td></tr>
          <tr><td></td></tr><tr><td></td></tr><tr><td></td></tr><tr><td></td></tr><tr><td></td></tr>
          <tr><td></td></tr><tr><td></td></tr><tr><td></td></tr><tr><td></td></tr><tr><td></td></tr>
          <tr><td></td></tr><tr><td></td></tr><tr><td></td></tr><tr><td></td></tr><tr><td></td></tr>
          <tr><td></td></tr><tr><td></td></tr><tr><td></td></tr><tr><td></td></tr><tr><td></td></tr>
          <tr>
              <td >	
              <br/>	
                @if(isset($img->archivo))
                    <img src="{{$img->archivo}}" alt="Sin foto" width="60px" height="80px"></img> 
                @endif
            </td>
          </tr>
          <tr>
              <td id="td_frontal">
                {{$inscripcion->matricula}} <br/>
                {{$cliente->nombre}} {{$cliente->nombre2}} {{$cliente->ape_paterno}} {{$cliente->ape_materno}}
              </td>
          </tr>
          <tr>
              <td id="td_frontal"></td>
          </tr>
          <tr><td></td></tr><tr><td></td></tr><tr><td></td></tr><tr><td></td></tr><tr><td></td></tr>
          
          </tbody>
      </table>
      
      <table>
          <tbody>
          <tr><td><h4>{{$cliente->plantel->razon}}</h4></td></tr>
          <tr><td>Acuerdo: <strong></strong>  CCT: <strong>{{$inscripcion->especialidad->ccte}}</strong></td></tr>
          <tr><td><u>Plantel: <strong>{{$cliente->plantel->municipio}}</strong></u></td></tr>
          <tr><td>{{$cliente->plantel->calle}} # {{$cliente->plantel->no_int}}, COL. {{$cliente->plantel->colonia}}, {{$cliente->plantel->municipio}},
                       {{$cliente->plantel->estado}}, C.P. {{$cliente->plantel->cp}} 
          </td></tr>
          <tr><td>
                <br/><br/><br/><br/><br/>
                <u>{{$cliente->plantel->director->nombre}} {{$cliente->plantel->director->ape_paterno}} {{$cliente->plantel->director->ape_materno}}</u>
                <br/>
                DIRECTOR(A)
          </td></tr>
          <tr>
              <td>En Caso de Emergencia llamar: </td>
          </tr>
            @if($cliente->nombre_padre<>"")
            <tr>
                <td>
                    {{$cliente->nombre_padre}}
                </td>
            </tr>
            <tr>
                <td>
                    Tel. Fijo:{{$cliente->tel_padre}}<br/>
                    Cel. :{{$cliente->cel_padre}}
                </td>
            </tr>
            @elseif($cliente->nombre_madre<>"")
            <tr>
                <td>
                    {{$cliente->nombre_madre}}
                </td>
            </tr>
            <tr>
                <td>
                    Tel. Fijo:{{$cliente->tel_madre}}<br/>
                    Cel. :{{$cliente->cel_madre}}
                </td>
            </tr>
            @else
            <tr>
                <td>
                    {{$cliente->nombre_acudiente}}
                </td>
            </tr>
            <tr>
                <td>
                    {{$cliente->nombre_acudiente}}
                </td>
                <td>
                    Tel. Fijo:{{$cliente->tel_acudiente}}<br/>
                    Cel. :{{$cliente->cel_acudiente}}
                </td>
            </tr>  
            @endif
              </td>
          </tr>
          <tr><td>ESTA CREDENCIAL ES ÚNICA E INSTRANSFERIBLE YA QUE ACREDITA AL PORTADOR COMO ALUMNO DE ÉSTA
                       INSTITUCIÓN, EL TITULAR ES RESPONSABLE DEL BUEN USO DE LA MISMA.</td></tr>
          </tbody>
      </table>
  </body>
</html>
