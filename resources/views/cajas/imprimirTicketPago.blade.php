<html>
<head>
</head>
<body>


<style>
@media print {
   table, th, td
    {
        border-collapse:collapse;
        /*border: 1px solid black;*/
        width:100%;
        /*text-align:right;*/
    }
}
body{
    font-family:"Arial";
    font-size:small;
}
</style>

<div id="printeArea">
<table style="width:100%;height:auto;border:1px solid #ccc;font-size: 0.70em;">
    <tr>
        <td align="center" colspan="2">
            @if(isset($combinacion->especialidad->imagen))
                <img src="{{asset('storage/especialidads/'.$combinacion->especialidad->imagen)}}" 
                    alt='img' style='width: 100px;
                    margin: 4px;'>
            @endif
            
        </td>
    </tr>
    <tr><td colspan="2" align="center" height="30px">{{$cliente->plantel->razon}}</td></tr>
    <tr>
        <td colspan="2" align="center" height="30px">
            {{
                $cliente->plantel->calle." ".
                $cliente->plantel->no_int.", ".
                $cliente->plantel->no_ext.", colonia ".
                $cliente->plantel->colonia.", ".
                $cliente->plantel->municipio.", ".
                $cliente->plantel->estado.", México"
            }}
        </td>
    </tr>
    
    <tr>
        <td colspan="2" height="30px">
            
            @if($combinacion)
            Estudios:{{$combinacion->especialidad->name." / ".
                       $combinacion->nivel->name." / ".
                       $combinacion->grado->name}}
            @endif
        </td>
    </tr>
    
    <tr>
        <td colspan="2" height="30px">
            @if($caja->st_caja_id==1)
                Ticket {{$caja->consecutivo}} pagado el {{$caja->fecha}}
            @elseif($caja->st_caja_id==2)
                Ticket {{$caja->consecutivo}} cancelado el {{$caja->fecha}}
            @else
                Ticket {{$caja->consecutivo}} en espera de su pago
            @endif
        </td>
    </tr>
    
    <tr>
        <td colspan="2" height="30px">
            Atendido por: {{ $empleado->nombre." ".$empleado->ape_paterno." ".$empleado->ape_materno }}
        </td>
    </tr>
    <tr>
        <td colspan="2" height="30px">
            Cliente:{{$cliente->id."-".$cliente->nombre." ".$cliente->nombre2." ".$cliente->ape_paterno." ".$cliente->ape_materno}}
        </td>
    </tr>
    <tr></tr>
    <tr>
        <td>
            Concepto
        </td>
        <td>
            F. Limite Pago
        </td>
        <td align="right"> Monto </td>
    </tr>
    <?php $total=0; ?>
    @foreach($caja->cajaLns as $caja_linea)
    
    <tr>
        <td>
            @if($caja_linea->cajaConcepto->id==1)
                {{$caja_linea->cajaConcepto->name." (".$caja_linea->adeudo->fecha_pago.")"}}
            @else
                {{$caja_linea->cajaConcepto->name}}
            @endif
        </td>
        <td>
            @if (isset($caja_linea->adeudo->fecha_pago))
            {{$caja_linea->adeudo->fecha_pago}}
            @else
            {{$caja_linea->caja->fecha}}
            @endif        </td>

        </td>
        <td align="right"> {{ number_format($caja_linea->subtotal, 2) }} </td>
    </tr>
    
    @endforeach
    <tr>
        <td>
            Subtotal
        </td>
        <td></td>
        <td align="right"> {{ number_format($caja->subtotal, 2) }} </td>
    </tr>
    <tr>
        <td>
            Recargos
        </td>
        <td></td>
        <td align="right"> {{ number_format($caja->recargo, 2) }} </td>
    </tr>
    <tr>
        <td>
            Descuentos
        </td>
        <td></td>
        <td align="right"> {{ number_format($caja->descuento, 2) }} </td>
    </tr>
    <tr>
        <td>
            Total
        </td>
        <td></td>
        <td align="right"> {{ number_format($caja->total, 2) }} </td>
    </tr>
    <tr>
        <tr><td colspan="2">Fecha Impresion: {{$fecha}}</td></tr>
    </tr>
    <tr>
        <td>
            Pago
        </td>
        <td>Fecha Pago:{{$pago->fecha}}</td>
        <td align="right"> {{ $pago->monto }} </td>
    </tr>
    <tr>
        <td>
            Acumulado
        </td>
        <td></td>
        <td align="right"> {{ $acumulado }} </td>
    </tr>
    <tr>
        <td>
            *Pendiente
        </td>
        <td></td>
        <td align="right"> {{ $caja->total-$acumulado }} </td>
    </tr>
    <tr><td>*El saldo pendiente puede incrementar por recargos al exceder la fecha limite de pago</td></tr>
    <tr><td>-</td></tr>
    <tr><td>-</td></tr>
    <tr><td>--------------------------------------------</td></tr>
</table>

</div>

<script type="text/php">
    if (isset($pdf)){
        $font = $fontMetrics->getFont("Arial", "bold");
        $pdf->page_text(700, 590, "Página {PAGE_NUM} de {PAGE_COUNT}", $font, 10, array(0, 0, 0));
    }
</script>




</body>
</html>