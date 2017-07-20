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
        <td style="width:33%;text-align:left" align="left">
            <img src="" alt="Logo" height=80>
        </td>
        <td style="width:33%;text-align:center" align="center">
            <h3> Reporte de Seguimientos por Empleado para Planteles </h3>
        </td>
        <td style="width:33%;text-align:rigth" align="rigth">
            Fecha de Elaboración: {{$fecha}}
        </td>
    </tr>
</table>

<table id="dg" style="width:100%;height:auto;border-collapse: collapse;font-size: 0.75em;">
    <thead>
        <tr>
            <th data-options="field:'cia_id'" style="border:1px solid #ccc;">
                No.
            </th>
            <th data-options="field:'residuo'" style="border:1px solid #ccc;">
                Plantel
            </th>
            <th data-options="field:'residuo'" style="border:1px solid #ccc;">
                Empleado
            </th>
            <th data-options="field:'residuo'" style="border:1px solid #ccc;">
                Cliente
            </th>
            <th data-options="field:'unidad'" style="border:1px solid #ccc;">
                Direccion
            </th>
            <th data-options="field:'fecha'" style="border:1px solid #ccc;">
                Tel. Fijo
            </th>
            <th data-options="field:'lugar_generacion'" style="border:1px solid #ccc;">
                Tel. Celular
            </th>
            <th data-options="field:'cantidad'" style="border:1px solid #ccc;">
                Correo electronico
            </th>
            <th data-options="field:'peligroso'" style="border:1px solid #ccc;">
                Estatus Cliente
            </th>
            <th data-options="field:'nombre'" style="border:1px solid #ccc;">
                Estatus Seguimiento
            </th>
        </tr>
    </thead>
    <tbody>
        <?php $i=1; ?>
        @foreach($seguimientos as $s)
        <tr>
            <td style="border:1px solid #ccc;">
                {{ $i }}
                <?php $i++; ?>
            </td>
            <td style="border:1px solid #ccc;">
                {{$s->cliente->plantel->razon}}
            </td>
            <td style="border:1px solid #ccc;">
                {{$s->cliente->empleado->nombre." ".$s->cliente->empleado->ape_paterno." ".$s->cliente->empleado->ape_materno}}
            </td>
            <td style="border:1px solid #ccc;">
                {{ $s->cliente->nombre." ".$s->cliente->nombre2." ".$s->cliente->ape_paterno." ".$s->cliente->ape_materno }}
            </td>
            <td style="border:1px solid #ccc;">
                {{ $s->cliente->calle." ".$s->cliente->no_interior." ".$s->cliente->no_exterior." ".$s->cliente->colonia." ".$s->cliente->municipio->name." ".$s->cliente->estado->name }}
            </td>
            <td style="border:1px solid #ccc;">
                {{ $s->cliente->tel_fijo }}
            </td>
            <td style="border:1px solid #ccc;">
                {{ $s->cliente->tel_cel }}
            </td>
            <td style="border:1px solid #ccc;">
                {{ $s->cliente->mail }}
            </td>
            <td style="border:1px solid #ccc;">
                {{ $s->cliente->stCliente->name }}
            </td>
            <td style="border:1px solid #ccc;">     
                {{ $s->estatus->name }}
            </td>
        </tr>
        @endforeach
    </tbody>
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