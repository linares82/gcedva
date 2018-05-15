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
            <?php
                                $r=DB::table('plantels as p')
                                    ->where('p.tpo_plantel_id', '=', 1)
                                    ->select('id','logo')
                                    ->first();
                                
                            ?>

                            @if(isset($r->id))
                            <img src="{!! asset('/imagenes/planteles').'/'.$r->id.'/'.$r->logo
                                 !!}" alt='img' style='width: 100px;
                                                        margin: 4px;'>
                            @endif
        </td>
    </tr>
    <tr><td colspan="2" align="center" height="30px">{{$cliente->plantel->razon}}</td></tr>
    
    <tr>
        <td colspan="2" height="30px">
            Estudios:{{$combinacion->especialidad->name." / ".
                       $combinacion->nivel->name." / ".
                       $combinacion->grado->name}}
        </td>
    </tr>
    
    <tr>
        <td colspan="2" height="30px">
            @if($caja->st_caja_id==1)
                Ticket {{$caja->id}} pagado el {{$caja->fecha}}
            @elseif($caja->st_caja_id==2)
                Ticket {{$caja->id}} cancelado el {{$caja->fecha}}
            @else
                Ticket {{$caja->id}} en espera de su pago
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
        <td align="right"> {{ number_format($caja_linea->subtotal, 2) }} </td>
    </tr>
    
    @endforeach
    <tr>
        <td>
            Subtotal
        </td>
        <td align="right"> {{ number_format($caja->subtotal, 2) }} </td>
    </tr>
    <tr>
        <td>
            Recargos
        </td>
        <td align="right"> {{ number_format($caja->recargo, 2) }} </td>
    </tr>
    <tr>
        <td>
            Descuentos
        </td>
        <td align="right"> {{ number_format($caja->descuento, 2) }} </td>
    </tr>
    <tr>
        <td>
            Total
        </td>
        <td align="right"> {{ number_format($caja->total, 2) }} </td>
    </tr>
    
    <tr><td>--</td></tr>
    <tr><td>--</td></tr>
    <tr><td>--</td></tr>
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