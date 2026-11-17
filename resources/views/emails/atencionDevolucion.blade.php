
<!DOCTYPE html>
<html>
<style>
  text {
	font-family: sans-serif;
  }
  .button {
    display: inline-block;
    padding: 5px 10px;
    background-color: #007bff;
    color: white;
    text-decoration: none;
    border-radius: 5px;
    font-family: sans-serif;
  }
  .button:hover {
    background-color: #0056b3;
  }
</style>
<head>
    <title>Aviso del sistema SIAM</title>
</head>
<body>
    <h3>Devolucion con id: {{ $devolucion }}</h3>
    <p>La devolucion acaba de tomar el estatus de {{ $estatus }} por lo que requiere su atencion.</p>
    
   	<a class="button" href="{{ route('devolucionesCajas.show', $devolucion) }}" target="_blank">Ver Devolucion</a>
	
</body>
</html>