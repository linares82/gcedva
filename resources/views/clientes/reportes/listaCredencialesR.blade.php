<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="es">
    <head>
      <style>
        @media print {
        th { background: #0046c3; color: #fff; max-width: 400px; padding: 0px 0px; }
        td { font-family: arial; font-size: 7px; color: #000; text-align:center;width: 100%;}
        /*table { padding: 5px 5px 5px 5px; width: 100%;}*/
        #td_frontal { font-family: arial; font-size: 7px; padding: 1px 1px; color: #000; text-align:center;}
        #tbl_frontal { 
            background: url({{asset('storage/especialidads/'.$especialidad->fondo_credencial)}}) no-repeat;
            background-size:200px 307px;
            margin: 7px 7px 7px 7px;
        }
        }
        
        body {
            display: block;
            margin: 0px;
        }  
        th { background: #0046c3; color: #fff; max-width: 400px; padding: 1px 1px;}
        td { font-family: arial; font-size: 7px; color: #000; text-align:center; width: 100%;}
        #td_frontal { font-family: arial; font-size: 9px; padding: 15px 15px; color: #000; text-align:center;}
        /*table { padding: 5px 5px 5px 5px; width: 100%;}*/
        #tbl_frontal { 
            background: url({{asset('storage/especialidads/'.$especialidad->fondo_credencial)}}) no-repeat;
            background-size:200px 307px;
            margin: 7px 7px 7px 7px;
        }
        .page-break {
            page-break-after: always;
        }
      </style>
    
    
  </head>
  <body>
 @foreach($registros as $r)
      <div id="tbl_frontal">
      <table >
      <tbody>
          <tr><td></td></tr><tr><td></td></tr><tr><td></td></tr><tr><td></td></tr><tr><td></td></tr>
          <tr><td></td></tr><tr><td></td></tr><tr><td></td></tr><tr><td></td></tr><tr><td></td></tr>
          <tr><td></td></tr><tr><td></td></tr><tr><td></td></tr><tr><td></td></tr><tr><td></td></tr>
          <tr><td></td></tr><tr><td></td></tr><tr><td></td></tr><tr><td></td></tr><tr><td></td></tr>
          <tr><td></td></tr><tr><td></td></tr><tr><td></td></tr><tr><td></td></tr><tr><td></td></tr>
          <tr>
              <td >	
              <br/>	
              @php
                $cadena_img = "";
                
              $img = \App\PivotDocCliente::where('cliente_id', $r->cliente)->where('doc_alumno_id', 11)->first();
                if (count($img) == 0) {
                    $cadena_img = explode('/', asset('images/sin_foto.png'));
                    
                } else {
                    $cadena_img = explode('/', $img->archivo);
                    
                }
              @endphp
                @if(end($cadena_img)<>"sin_foto.png")
                    <img src="{{asset("imagenes/clientes/".$r->cliente."/".end($cadena_img))}}" alt="Sin foto" width="60px" height="80px"></img> 
                @else
                <img src="{{asset("images/".end($cadena_img))}}" alt="Sin foto" width="60px" height="80px"></img> 
                @endif
            </td>
          </tr>
          <tr>
              <td id="td_frontal">
                {{$r->matricula}} <br/>
                {{$r->nombre}} {{$r->nombre2}} {{$r->ape_paterno}} {{$r->ape_materno}}
              </td>
          </tr>
          <tr>
              @php
              
              $vencimiento=\Carbon\Carbon::createFromFormat('Y-m-d', $datos['fec_vencimiento']);
              @endphp   
              <td id="td_frontal">Vencimiento:{{$vencimiento->toDateString('d-m-Y')}}</td>
          </tr>
          <tr><td></td></tr><tr><td></td></tr>
          
          </tbody>
      </table>
    </div>
      <div class="page-break"></div>
      <table>
          <tbody>
          <tr><td><h4>{{$r->razon}}</h4></td></tr>
          <tr><td>Acuerdo: <strong>{{$r->rvoe}}</strong>  CCT: <strong>{{$r->ccte}}</strong></td></tr>
          <tr><td>{{$r->calle}} # {{$r->no_int}}, COL. {{$r->colonia}}, {{$r->municipio}},
                       {{$r->estado}}, C.P. {{$r->cp}} 
          </td></tr>
          <tr>
            <td>
            @if($r->img_firma<>"")
            <img src="{!! asset('imagenes/planteles/'.$r->plantel.'/'.$r->img_firma) !!}" alt="Logo" height="30"> </img> 
            @endif
            </td>
          </tr>
          <tr>
            <td>
                <u>{{$r->dnombre}} {{$r->dape_paterno}} {{$r->dape_materno}}</u>
                <br/>
                DIRECTOR(A)
            </td>
          </tr>
          <tr>
              <td>En Caso de Emergencia llamar: </td>
          </tr>
        @if($r->nombre_padre<>"")
         <tr>
             <td>
                {{$r->nombre_padre}}
            </td>
          </tr>
          <tr width="200px">
             <td width="200px">
                    Tel. Fijo: {{$r->tel_padre}}<br/>
                    Cel.: {{$r->cel_padre}}
             </td>
         </tr>
         @elseif($r->nombre_madre<>"")
            <tr>
                <td>
                    {{$r->nombre_madre}}
                </td>
            </tr>
            <tr>
                <td>
                    Tel. Fijo:{{$r->tel_madre}}<br/>
                    Cel. :{{$r->cel_madre}}
                </td>
            </tr>
            @else
            <tr>
                <td>
                    {{$r->nombre_acudiente}}
                </td>
            </tr>
            <tr>
                <td>
                    Tel. Fijo:{{$r->tel_acudiente}}<br/>
                    Cel. :{{$r->cel_acudiente}}
                </td>
            </tr>  
            @endif
            <tr>
                <td>
                    <img src="data:image/png;base64, 
                        {!! base64_encode(QrCode::format('png')->size(80)->generate('Id:'.$r->cliente.
                                                                                '; Nombre:'.$r->nombre.' '.$r->nombre2.' '.$r->ape_paterno.' '.$r->ape_materno.
                                                                                '; Matricula:'.$r->matricula.
                                                                                '; Plantel:'.$r->razon)) !!} ">
                </td>
            </tr>    
          <tr><td>ESTA CREDENCIAL ES ÚNICA E INTRANSFERIBLE YA QUE ACREDITA AL PORTADOR COMO ALUMNO DE ÉSTA
                       INSTITUCIÓN, EL TITULAR ES RESPONSABLE DEL BUEN USO DE LA MISMA.</td></tr>
          </tbody>
      </table>
      <div class="page-break"></div>
      @endforeach
  </body>
</html>
