<html>
<head>
</head>
<body>


<style>
@media print {
   table, th, td
    {
        border-collapse:collapse;
        border: 1px solid black;
        width:100%;
        text-align:right;
    }
}
body{
    font-family:"sans-serif";
}
</style>

<div id="printeArea">
<table style="width:100%;height:auto;border:1px solid #ccc;font-size: 0.75em;">
    <tr>
        <td >
            Cliente:{{$cliente->id."-".$cliente->nombre.$cliente->nombre2.$cliente->ape_paterno.$cliente->ape_materno}}
        </td>
    </tr>
    <?php $total=0; ?>
    @foreach($cliente->adeudos as $adeudo)
    @if($adeudo->inicial_bnd==1)
    <tr>
        <td>
            {{$adeudo->cajaConcepto->name}}
        </td>
        <td>{{$adeudo->monto}} </td>
    </tr>
    <?php $total=$total+$adeudo->monto; ?>
    @endif
    @endforeach
    <tr>
        <td>
            Total
        </td>
        <td>{{ $total }} </td>
    </tr>
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