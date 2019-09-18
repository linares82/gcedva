<html>
  <head>
      <style>
        @media print {
        th { background: #0046c3; color: #fff; max-width: 400px; padding: 3px 5px; }
        td { font-family: arial; font-size: 9px; padding: 15px 15px; color: #000; text-align:center;}
        table { padding: 50px 50px;}
        }
        
          
        th { background: #0046c3; color: #fff; max-width: 400px; padding: 3px 5px;}
        td { font-family: arial; font-size: 9px; padding: 2px 10px; color: #000; text-align:center;}
        table { padding: 10px 10px; width: 100%;}
      </style>
    
    
  </head>
  <body>
      <br/><br/><br/><br/><br/>
      
  <td>
      <table>
          <tr>
              <td >		
                @if(isset($img->archivo))
                    <img src="{{$img->archivo}}" alt="Sin foto" width="100px"></img> 
                @endif
            </td>
          </tr>
          <tr>
              <td >{{$inscripcion->matricula}}</td>
          </tr>
          <tr>
              <td >{{$cliente->nombre}} {{$cliente->nombre2}} {{$cliente->ape_paterno}} {{$cliente->ape_materno}}</td>
          </tr>
      </table>
      <br/><br/><br/><br/><br/>
      <br/><br/><br/><br/><br/>
      <br/><br/><br/><br/><br/>
      <br/><br/><br/><br/>
      <table>
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
          
      </table>
  </td>
  </body>
</html>
