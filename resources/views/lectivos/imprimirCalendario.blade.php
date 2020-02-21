
<html>
<head>
<style>
div.mes {
  margin: 10px;
  width: 250px;
  position: static;
  float: left;
  height: 250px;
}

div.mes:nth-child(odd) {
  right: 50px;
}



div.mes:nth-child(even) {
  left: 50px;
}

div.mes th,
div.mes td,
div.mes caption {
  font: normal 13px "Helvetica Neue", Helvetica, Arial, sans-serif;
  padding: 6px 4px;
}

.tabla_mes {
  border-spacing: 3px;
  empty-cells: hide;
}

div.mes td {
  text-align: center;
  border: 1px solid #eee;
}

div.mes .tdmio {
  text-align: center;
  border: 3px solid #009900;
}

div.mes th {
  color: #999;
}

div.mes caption.titulo {
  text-align: left;
  font-size: 18px;
  color: #c00;
}
</style>
</head>
<body>
    <h3>Calendario</h3>
<script>
	var mes_text = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];

var dia_text = ["Dom", "Lun", "Mar", "Mie", "Juv", "Vie", "Sab"];

@if($anio==$anio_fin)
estructurar({{ $anio }});
numerar({{ $anio }});
ocultarMesesAnteriores({{ $mes_inicio }}, {{ $anio }});
ocultarMesesPosteriores({{ $mes_fin }}, {{ $anio_fin }});
@else
estructurar({{ $anio }});
numerar({{ $anio }});
ocultarMesesAnteriores({{ $mes_inicio }}, {{ $anio }});

estructurar({{ $anio_fin }});
numerar({{ $anio_fin }});
ocultarMesesPosteriores({{ $mes_fin }}, {{ $anio_fin }});
@endif

function estructurar(year) {
  for (m = 0; m <= 11; m++) {
    //Mes
    let mes = document.createElement("DIV");
    mes.setAttribute('id',"mes"+mes_text[m]+year);
    mes.className = "mes";
    document.body.appendChild(mes);
    //Tabla
    let tabla_mes = document.createElement("TABLE");
    tabla_mes.className = "tabla_mes";
    mes.appendChild(tabla_mes);
    //Título
    let titulo = document.createElement("CAPTION");
    titulo.className = "titulo";
    titulo.innerText = mes_text[m]+" "+year;
    tabla_mes.appendChild(titulo);
    //Cabecera
    let cabecera = document.createElement("THEAD");
    tabla_mes.appendChild(cabecera);
    let fila = document.createElement("TR");
    cabecera.appendChild(fila);
    for (d = 0; d < 7; d++) {
      let dia = document.createElement("TH");
      dia.innerText = dia_text[d];
      fila.appendChild(dia);
    }
    //Cuerpo
    let cuerpo = document.createElement("TBODY");
    tabla_mes.appendChild(cuerpo);
    for (f = 0; f < 6; f++) {
      let fila = document.createElement("TR");
      cuerpo.appendChild(fila);
      for (d = 0; d < 7; d++) {
        let dia = document.createElement("TD");
        dia.innerText = "";
        fila.appendChild(dia);
      }     
    }    
  }
}



function numerar(year) {
  
  for (i = 1; i < 366; i++) {
    let fecha = fechaPorDia(year, i);
	//alert(fecha);
    let mes = fecha.getMonth();
    //alert(mes);
    //let div_mes=document.getElementById("mes"+mes_text[mes]+year).children;
    //console.log(div_mes);
    //let select_tabla = document.getElementsByClassName('tabla_mes')[mes];
    let select_tabla=document.getElementById("mes"+mes_text[mes]+year).children[0];
    let dia = fecha.getDate()
	//alert(dia);
    let dia_semana = fecha.getDay();
	//alert(dia_semana);
    if (dia == 1) {var sem = 0;}
    select_tabla.children[2].children[sem].children[dia_semana].innerText = dia;
    let f=[];
    <?php $i=0; ?>
    @foreach($noHabiles as $nh)
        <?php
        $date = date('Y-m-d', strtotime($nh->fecha));
        $componentes=explode("-",$date);
        ?>
        f[{{$i}}] = new Date({{$componentes[0]}},{{$componentes[1]-1}},{{$componentes[2]}});
        //alert(f);
        if(fecha.getTime()==f[{{$i}}].getTime()){
            
            select_tabla.children[2].children[sem].children[dia_semana].classList.add("tdmio")
	      }
        <?php $i++; ?>
    @endforeach

    <?php $i=0; ?>
    @foreach($noHabilesFin as $nh)
        <?php
        $date = date('Y-m-d', strtotime($nh->fecha));
        $componentes=explode("-",$date);
        ?>
        f[{{$i}}] = new Date({{$componentes[0]}},{{$componentes[1]-1}},{{$componentes[2]}});
        //alert(f);
        if(fecha.getTime()==f[{{$i}}].getTime()){
            
            select_tabla.children[2].children[sem].children[dia_semana].classList.add("tdmio")
	      }
        <?php $i++; ?>
    @endforeach
        
    if (dia_semana == 6) { sem = sem + 1; }
  }
}

function fechaPorDia(anio, dia) {
  var date = new Date(anio, 0);
  return new Date(date.setDate(dia));
}

function ocultarMesesAnteriores(inicial,year){
  for(c=inicial-2; c>=0; c--){
    //console.log("mes"+mes_text[c]);
    var mes = document.getElementById("mes"+mes_text[c]+year);
    mes.style.display="none";
  }
}

function ocultarMesesPosteriores(inicial,year){
  for(c=inicial; c<=11; c++){
    //console.log("mes"+mes_text[c]);
    var mes = document.getElementById("mes"+mes_text[c]+year);
    mes.style.display="none";
  }
}


</script>
<div class="mes">
    <table class="tabla_mes">
        <caption class="titulo">Clave</caption>
        <thead><tr><th></th><th></th></tr></thead>
        <tbody>
            <tr><td class="tdmio">00</td><td >Dia no habil</td></tr>
        </tbody>
    </table>
</div>
</body>
</html>
