<style>
    @media print {
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            text-align: left;
            padding: 8px;
            font: normal 12px Arial, Helvetica, sans-serif; 
            border: solid 1px #FE9A2E;
        }

        tr:nth-child(even){background-color: #f2f2f2}

        th {
            background-color: #FE9A2E;
            color: white;
            font-weight: bold;
        }
     }
    
    table {
        border-collapse: collapse;
        width: 100%;
    }

    th, td {
        text-align: center;
        padding: 8px;
        font: normal 12px Arial, Helvetica, sans-serif; 
        border: solid 1px #FE9A2E;
    }

    tr:nth-child(even){background-color: #f2f2f2}

    th {
        background-color: #FE9A2E;
        color: white;
    }
        
    body {
        font: normal 10px Arial, Helvetica, sans-serif; 
    }

</style>




            <td align="center"  >
                <h3>
                    Pagos y Adeudos
                </h3>
            </td>


<div class="datagrid">
    <table border="1" width="100%" >
        <thead >
        <th><strong>Id Adeudo</strong></th><th><strong>Plantel</strong></th><th><strong>Id Cliente</strong></th><th><strong>Cliente</strong></th>
        <th><strong>Plan</strong></th><th><strong>Monto Planeado</strong></th><th><strong>Fecha Reporte</strong></th><th><strong>Fecha Sin Recargos</strong></th>
        <th><strong>Fecha 5% Recargos</strong></th><th><strong>Fecha 10% Recargos</strong></th><th><strong>Concepto </strong></th>
        <th><strong>consecutivo Caja</strong></th><th><strong>Estatus Caja</strong></th><th><strong>Fecha Caja</strong></th><th><strong>Descuento</strong></th>
        <th><strong>Recargo</strong></th><th><strong>Adeudo</strong></th><th><strong>Pago</strong></th>
        </thead>
        <tbody>
            <?php 
            $cont=0; 
            $total_adeudos=0;
            $total_pagos=0;
            $total_descuentos=0;
            $total_recargos=0;
            ?>
            @foreach($registros as $registro)
            @if($cont==8)
            <tr>
                <th><strong>Id Adeudo</strong></th><th><strong>Plantel</strong></th><th><strong>Id Cliente</strong></th><th><strong>Cliente</strong></th>
                <th><strong>Plan</strong></th><th><strong>Monto Planeado</strong></th><th><strong>Fecha Reporte</strong></th><th><strong>Fecha Sin Recargos</strong></th>
                <th><strong>Fecha 5% Recargos</strong></th><th><strong>Fecha 10% Recargos</strong></th><th><strong>Concepto </strong></th>
                <th><strong>consecutivo Caja</strong></th><th><strong>Estatus Caja</strong></th><th><strong>Fecha Caja</strong></th><th><strong>Descuento</strong></th>
                <th><strong>Recargo</strong></th><th><strong>Adeudo</strong></th><th><strong>Pago</strong></th>
            </tr>
            <?php $cont=0; ?>
            @endif
            <tr>
                <td>{{$registro['id']}}</td>
                <td>{{$registro['razon']}}</td>
                <td>{{$registro['cliente']}}</td>
                <td>{{$registro['nombre_cliente']}}</td>
                <td> {{$registro['plan_pago']}}</td>
                <td> {{$registro['monto_planeado']}}</td>
                <td>{{$fecha_reporte}}</td>
                <td>{{$registro['fecha_pago_planeada']}}</td>
                <?php $reglas_relacionadas=DB::table('plan_pago_ln_regla_recargo as ln')
                        ->join('regla_recargos as r','r.id','=','ln.regla_recargo_id')
                        ->where('ln.plan_pago_ln_id',$registro['plan_pago_ln'])
                        ->get();
                        ?>
                @if(count($reglas_relacionadas)>0)
                @foreach($reglas_relacionadas as $regla)
                <td>{{\Carbon\Carbon::createFromFormat('Y-m-d', $registro['fecha_pago_planeada'])->addDays($regla->dia_inicio)->toDateString()}}</td>
                @endforeach
                @else
                <td></td><td></td>
                @endif
                <td>{{$registro['concepto']}}</td>
                <td>@if(isset($registro['consecutivo']))
                    {{$registro['consecutivo']}}
                    @endif
                </td>
                <td>@if(isset($registro['st_caja']))
                    {{$registro['st_caja']}}
                    @endif
                </td>
                <td>@if($registro['caja_id']>0)
                    {{$registro['fecha_caja']}}
                    @endif
                </td>
                <td>{{$registro['monto_descuento']}}</td>
                <td>{{$registro['monto_recargo']}}</td>
                <td>{{$registro['adeudo']}}</td>
                <td>{{$registro['pago']}}</td>
            </tr>
            <?php 
            $cont++;
            $total_pagos=$total_pagos+$registro['pago'];
            $total_adeudos=$total_adeudos+$registro['adeudo'];
            $total_descuentos=$total_descuentos+$registro['monto_descuento'];
            $total_recargos=$total_recargos+$registro['monto_recargo'];
            ?>
            @endforeach
            <tr>
                <td colspan='13'></td>
                <td>Total</td>
                <td>{{$total_descuentos}}</td>
                <td>{{$total_recargos}}</td>
                <td>{{$total_adeudos}}</td>
                <td>{{$total_pagos}}</td>
            </tr>
            
        </tbody>
    </table>
    
</div>


 <script   
   src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js">
    </script>
    <script>

    function scrolify(tblAsJQueryObject, height){
        var oTbl = tblAsJQueryObject;

        // for very large tables you can remove the four lines below
        // and wrap the table with <div> in the mark-up and assign
        // height and overflow property  
        var oTblDiv = $("<div/>");
        oTblDiv.css('height', height);
        oTblDiv.css('overflow','scroll');               
        oTbl.wrap(oTblDiv);

        // save original width
        oTbl.attr("data-item-original-width", oTbl.width());
        oTbl.find('thead tr td').each(function(){
            $(this).attr("data-item-original-width",$(this).width());
        }); 
        oTbl.find('tbody tr:eq(0) td').each(function(){
            $(this).attr("data-item-original-width",$(this).width());
        });                 


        // clone the original table
        var newTbl = oTbl.clone();

        // remove table header from original table
        oTbl.find('thead tr').remove();                 
        // remove table body from new table
        newTbl.find('tbody tr').remove();   

        oTbl.parent().parent().prepend(newTbl);
        newTbl.wrap("<div/>");

        // replace ORIGINAL COLUMN width                
        newTbl.width(newTbl.attr('data-item-original-width'));
        newTbl.find('thead tr td').each(function(){
            $(this).width($(this).attr("data-item-original-width"));
        });     
        oTbl.width(oTbl.attr('data-item-original-width'));      
        oTbl.find('tbody tr:eq(0) td').each(function(){
            $(this).width($(this).attr("data-item-original-width"));
        });                 
    }

    $(document).ready(function(){
        scrolify($('#tblNeedsScrolling'), 500); // 160 is height
    });


    </script>            
            
