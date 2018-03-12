<html>
<head>
</head>
<body>
    {!! $plantilla !!}
    <p><strong>Confirma tu correo: <a title="Confirmacion de Correo" href="{{ route('clientes.confirmaCorreo', ['id' =>$id]) }}" target="_blank" rel="noopener noreferrer">Dale click</a></strong></p>
    @if(!is_null($img1))
    <img src="{{ $message->embed($img1) }}">
    @endif
</body>
</html>