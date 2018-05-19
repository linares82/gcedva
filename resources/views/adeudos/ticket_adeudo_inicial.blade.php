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
    <tr><td colspan="2" align="center" height="30px">{{$cliente->plantel->razon}}</td></tr>
    <tr><td colspan="2" align="center" height="30px">Banco y cuenta {{$plantel->rvoe}}</td></tr>
    <tr><td colspan="2" align="center" height="30px">Cuenta CLABE {{$plantel->cct}}</td></tr>
    <tr>
        <td colspan="2" height="30px">
            Estudios:{{$combinacion->especialidad->name." / ".
                       $combinacion->nivel->name." / ".
                       $combinacion->grado->name}}
        </td>
    </tr>
    
    <tr>
        <td colspan="2" height="30px">
            Adeudos Iniciales
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
    @foreach($adeudos as $adeudo)
    @if($adeudo->inicial_bnd==1)
    <tr>
        <td>
            @if($adeudo->cajaConcepto->id==1)
                {{$adeudo->cajaConcepto->name."(".$adeudo->fecha_pago.")"}}
            @else
                {{$adeudo->cajaConcepto->name}}
            @endif
        </td>
        <td align="right"> {{ number_format($adeudo->monto, 2) }} </td>
    </tr>
    <?php $total=$total+$adeudo->monto; ?>
    @endif
    @endforeach
    <tr>
        <td>
            Total
        </td>
        <td align="right"> {{ number_format($total, 2) }} </td>
    </tr>
    <tr><td colspan="2" height="30px">Cajero: {{ $empleado->nombre." ".$empleado->ape_paterno." ".$empleado->ape_materno }}</td></tr>
    <tr><td colspan="2">Fecha Impresion: {{$fecha}}</td></tr>
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