<html>
  <head>
      <style>
        @media print {
        th { background: #0046c3; color: #fff; max-width: 400px; padding: 0px 0px; }
	td { font-family: arial; font-size: 5pt; color: #000; text-align:center;width: 100%;}
	table { padding: 2px 2px;width: 100%;}
	#td_frontal { font-family: arial; font-size: 10pt; color: #000; text-align:center;width: 100%;}
        #tbl_frontal { background: url({{asset('images/cred_frontal.jpg')}}) no-repeat;
                            background-size:200px 307px;}
	div.saltopagina{
        display:block;
        page-break-before:always;
   	}

        }
        
          
        th { background: #0046c3; color: #fff; max-width: 400px; padding: 1px 1px;}
        td { font-family: arial; font-size: 7px; color: #000; text-align:center; width: 100%;}
        #td_frontal { font-family: arial; font-size: 9px; padding: 15px 15px; color: #000; text-align:center;}
        /*table { padding: 1px 1px; width: 100%;}*/
        #tbl_frontal { background: url({{asset('storage/especialidads/'.$inscripcion->especialidad->fondo_credencial)}}) no-repeat;
                            background-size:200px 307px;
			    font-size: 2em;}
      </style>
    
    
  </head>
  <body>
 
      <table id="tbl_frontal">
      <tbody>
          <tr><td></td></tr><tr><td></td></tr><tr><td></td></tr><tr><td></td></tr><tr><td></td></tr>
          <tr><td></td></tr><tr><td></td></tr><tr><td></td></tr><tr><td></td></tr><tr><td></td></tr>
          <tr><td></td></tr><tr><td></td></tr><tr><td></td></tr><tr><td></td></tr><tr><td></td></tr>
          <tr><td></td></tr><tr><td></td></tr><tr><td></td></tr><tr><td></td></tr><tr><td></td></tr>
          <tr>
              <td >	
              <br/>	
                @if(isset($cadena_img))
                    <img src="{{asset("imagenes/clientes/".$cliente->id."/".end($cadena_img))}}" alt="Sin foto" width="85px" height="105px"></img> 
                @endif
            </td>
          </tr>
          <tr>
              <td style="font-size:10px;">
                {{$cliente->matricula}} <br/>
                {{$cliente->nombre}} {{$cliente->nombre2}} <br/>
                {{$cliente->ape_paterno}} {{$cliente->ape_materno}}
              </td>
          </tr>
          <tr>
              @php
              $vencimiento=\Carbon\Carbon::createFromFormat('Y-m-d', $inscripcion->fec_inscripcion)->addYear();
              @endphp   
              <td>Vencimiento:{{date("d-m-Y", strtotime($cliente->fec_vencimiento_cred))}}</td>

          </tr>
	  <tr><td></td></tr><tr><td></td></tr><tr><td></td></tr><tr><td></td></tr><tr><td></td></tr>
	<tr><td></td></tr><tr><td></td></tr><tr><td></td></tr><tr><td></td></tr><tr><td></td></tr>
                    
          </tbody>
      </table>
      <div class="saltopagina"></div>

      <table>
          <tbody>
          <tr><td><h4>{{$grado->denominacion}}</h4></td></tr>
          <tr><td>Acuerdo: <strong>{{$grado->rvoe}}</strong>  CCT: <strong>{{$grado->cct}}</strong></td></tr>
          <tr><td>{{$cliente->plantel->calle}} # {{$cliente->plantel->no_int}}, COL. {{$cliente->plantel->colonia}}, {{$cliente->plantel->municipio}},
                       {{$cliente->plantel->estado}}, C.P. {{$cliente->plantel->cp}}, tel {{$cliente->plantel->tel}}  
          </td></tr>

          <tr>
            <td>
            @if($plantel->img_firma<>"")
            <img src="{!! asset('imagenes/planteles/'.$plantel->id.'/'.$plantel->img_firma) !!}" alt="Logo" height="30"> </img> 
            @endif
            </td>
          </tr>
          <tr><td>___________________________________</td></tr>
          <tr>
            <td>
                {{$cliente->plantel->director->nombre}} {{$cliente->plantel->director->ape_paterno}} {{$cliente->plantel->director->ape_materno}}
                <br/>
                DIRECTOR(A)
            </td>
          </tr>
          <tr><td></td></tr><tr><td></td></tr>
          <tr>
              <td>En Caso de Emergencia llamar: </td>
          </tr>
        @if($cliente->nombre_padre<>"")
         <tr>
             <td>
                {{$cliente->nombre_padre}}
            </td>
          </tr>
          <tr width="200px">
             <td width="200px">
                    Tel. Fijo: {{$cliente->tel_padre}}<br/>
                    Cel.: {{$cliente->cel_padre}}
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
                    Tel. Fijo:{{$cliente->tel_acudiente}}<br/>
                    Cel. :{{$cliente->cel_acudiente}}
                </td>
            </tr>  
            @endif
                
          <tr><td>ESTA CREDENCIAL ES ÃšNICA E INTRANSFERIBLE YA QUE ACREDITA AL PORTADOR COMO ALUMNO DE Ã‰STA
                       INSTITUCIÃ“N, EL TITULAR ES RESPONSABLE DEL BUEN USO DE LA MISMA.</td></tr>
	  <tr>
                <td>
                    <img src="data:image/png;base64, 
                                {!! base64_encode(QrCode::format('png')->size(60)->generate('Id:'.$cliente->id.
                                '; Nombre:'.$cliente->nombre.' '.$cliente->nombre2.' '.$cliente->ape_paterno.' '.$cliente->ape_materno.
                                '; Matricula:'.$cliente->matricula.
                                '; Plantel:'.$plantel->razon)) !!} ">
                </td>
            </tr>    
          </tbody>
      </table>
  </body>
</html>
