<html>
<head>
</head>
<body>
    {!! $plantilla !!}
    @if(!is_null($img1))
    <img src="{{ $message->embed($img1) }}">
    @endif
</body>
</html>