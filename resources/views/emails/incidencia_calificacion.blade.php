<html>

<head>
</head>

<body>
    <p>
        Buen dia, le informamos a traves del presente que su incidencia para cambio de calificacion con datos:
    </p>
    
    <p>
        Alumno: {{$incidenciaCalificacion->cliente_id}} <br>
        Materia: {{$incidenciaCalificacion->materium->name}} <br>
        Nueva Calificacion: {{$incidenciaCalificacion->calificacion_nueva}} <br>
        Estatus:
        @if($incidenciaCalificacion->bnd_autorizada==1)
        Aprobada
        @elseif($incidenciaCalificacion->bnd_rechazada==1)
        Rechazada
        @endif
    </p>

    
    Fue atendida.
    <br>
    Notificacion del sistema
</body>

</html>