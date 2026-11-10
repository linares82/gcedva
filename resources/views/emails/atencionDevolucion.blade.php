
<!DOCTYPE html>
<html>
<head>
    <title>Aviso del sistema SIAM</title>
</head>
<body>
    <h3>Devolucion con id: {{ $devolucion }}</h3>
    <p>La devolucion acaba de tomar el estatus de {{ $estatus }} por lo que requiere su atencion.</p>
    
	<button type="button" class="btn btn-primary" onclick="window.location='{{ route('devolucionesCajas.show', $devolucion) }}'">Ver Devolucion</button>
   	
</body>
</html>