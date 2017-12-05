<html>
<head>
</head>
<body>
    {!! $plantilla !!}
    @if(!is_null($img1))
    <img src="{{ $message->embed($storage_path('app') . "/plantillas_correos/" . $img1) }}">
    @endif
</body>
</html>