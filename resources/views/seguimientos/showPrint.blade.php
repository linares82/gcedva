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

<table style="width:100%;height:auto;border:1px solid #ccc;font-size: 1em;">
    <tr>
        <td style="width:33%;text-align:left" align="left">
            <img src="" alt="Logo" height=80>
        </td>
        <td style="width:33%;text-align:center" align="center">
            <h3> Reporte de Seguimientos de Cliente </h3>
        </td>
        <td style="width:33%;text-align:right" align="right">
            Fecha de Elaboración: {{$fecha}}
        </td>
    </tr>
</table>

<table id="dg2" style="width:100%;height:auto;border-collapse:collapse;font-size: 1em;">
    <tr>
        <td style="width:33%;text-align:center;border:1px solid #ccc;" align="center" colspan=4>
            Datos del cliente
        </td>
        
    </tr>
    <tr>
        <td style="width:33%;text-align:left;border:1px solid #ccc;" align="left" bgcolor="#c1b7b5">
            Nombre Completo:
        </td>
        <td style="width:33%;text-align:center;border:1px solid #ccc;" align="center">
            {{$seguimiento->cliente->nombre." ".$seguimiento->cliente->nombre2." ".$seguimiento->cliente->ape_paterno." ".$seguimiento->cliente->ape_materno}}
        </td>
        <td style="width:33%;text-align:right;border:1px solid #ccc;" align="right" bgcolor="#c1b7b5">
            Tel. Fijo:
        </td>
        <td style="width:33%;text-align:right;border:1px solid #ccc;" align="right">
            {{$seguimiento->cliente->tel_fijo}}
        </td>
    </tr>
    <tr>
        <td style="width:33%;text-align:left;border:1px solid #ccc;" align="left" bgcolor="#c1b7b5">
            Tel. Celular:
        </td>
        <td style="width:33%;text-align:center;border:1px solid #ccc;" align="center">
            {{$seguimiento->cliente->tel_cel}}
        </td>
        <td style="width:33%;text-align:right;border:1px solid #ccc;" align="right" bgcolor="#c1b7b5">
            E-mail:
        </td>
        <td style="width:33%;text-align:right;border:1px solid #ccc;" align="right">
            {{$seguimiento->cliente->mail}}
        </td>
    </tr>
    <tr>
        <td style="width:33%;text-align:left;border:1px solid #ccc;" align="left" bgcolor="#c1b7b5">
            Dirección:
        </td>
        <td style="width:33%;text-align:center;border:1px solid #ccc;" align="center">
            {{$seguimiento->cliente->calle." ".$seguimiento->cliente->no_ext." ".$seguimiento->cliente->colonia." ".$seguimiento->cliente->municipio->name}}        
        </td>
        <td style="width:33%;text-align:right;border:1px solid #ccc;" bgcolor="#c1b7b5" align="right">
            Empleado:
        </td>
        <td style="width:33%;text-align:right;border:1px solid #ccc;" align="right">
            {{$seguimiento->cliente->empleado->nombre." ".$seguimiento->cliente->empleado->ape_paterno." ".$seguimiento->cliente->empleado->ape_materno}}         
        </td>
    </tr>
</table>

<p><strong >TAREAS:</strong></p>
<table id="dg" style="width:100%;height:auto;border-collapse:collapse;font-size: 1em;">
    <thead>
        <tr>
            <th style="border:1px solid #ccc;" bgcolor="#c1b7b5">Tarea</th>
            <th style="border:1px solid #ccc;" bgcolor="#c1b7b5">Asunto</th>
            <th style="border:1px solid #ccc;" bgcolor="#c1b7b5">Detalle</th>
            <th style="border:1px solid #ccc;" bgcolor="#c1b7b5">Estatus</th>
            <th style="border:1px solid #ccc;" bgcolor="#c1b7b5">Fecha</th>
        </tr>
    </thead>
    <tbody>
        @foreach($asignacionTareas as $at)
        <tr>
            <td style="border:1px solid #ccc;">{{$at->tarea->name}}</td>
            <td style="border:1px solid #ccc;">{{$at->asunto->name}}</td>
            <td style="border:1px solid #ccc;">{{$at->detalle}}</td>
            <td style="border:1px solid #ccc;">{{$at->stTarea->name}}</td>
            <td style="border:1px solid #ccc;">{{$at->created_at}}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<p><strong >AVISOS:</strong></p>

<table id="dg1" style="width:100%;height:auto;border-collapse: collapse;font-size: 1em;">
    <thead>
        <tr>
            <th style="border:1px solid #ccc;" bgcolor="#c1b7b5">Fecha</th>
            <th style="border:1px solid #ccc;" bgcolor="#c1b7b5">Asunto</th>
            <th style="border:1px solid #ccc;" bgcolor="#c1b7b5">Detalle</th>
        </tr>
    </thead>
    <tbody>
        @foreach($avisos as $a)
        <tr>
            <td style="border:1px solid #ccc;">
            @if($a->dias_restantes<=0)
                <small class="strong strong-danger">
            @elseif($a->dias_restantes==1)
                <small class="strong strong-warning"> 
            @elseif($a->dias_restantes>=2)
                <small class="strong strong-success"> 
            @endif
                {{$a->fecha}}
            </small>
            </td>
            <td style="border:1px solid #ccc;">{{$a->name}}</td>
            <td style="border:1px solid #ccc;">{{$a->detalle}}</td>
            
        </tr>
        @endforeach
    </tbody>
</table>
<script type="text/php">
    if (isset($pdf)){
        $font = $fontMetrics->getFont("Arial", "bold");
        $pdf->page_text(700, 590, "Página {PAGE_NUM} de {PAGE_COUNT}", $font, 10, array(0, 0, 0));
    }
</script>
</body>
</html>