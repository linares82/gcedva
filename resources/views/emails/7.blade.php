<html>
<head>
</head>
<body>
    {!! $p->plantilla !!}
    @if(!is_null($p->img))
    <img src="{{ $message->embed($storage_path('app') . "/plantillas_correos/" . $p->img1) }}">
    @endif
</body>
</html>