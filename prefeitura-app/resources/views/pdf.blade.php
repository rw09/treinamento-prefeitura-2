<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>{{ $protocolo->id }}</h1>
    <h1>{{ $protocolo->descricao }}</h1>
    <h1>{{ $protocolo->created_at }}</h1>
    
    <h2>Acompanhamentos:</h2>
    <ul>
        @if($acompanhamentos)
            @foreach($acompanhamentos as $acompanhamento)
            <li>{{ $acompanhamento->observacao }}</li>
            @endforeach
        @endif
    </ul>
</body>
</html>