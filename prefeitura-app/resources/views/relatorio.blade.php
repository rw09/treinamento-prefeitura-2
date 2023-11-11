<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <table>
        <thead>
            <tr>
                <td>ID</id>
                <td>Descrição</id>
                <td>Data</id>
            </tr>
        </thead>
        <tbody>
            @foreach($protocolos as $protocolo)
            <tr>
                <td>{{ $protocolo->id }}
                <td>{{ $protocolo->descricao }}
                <td>{{ $protocolo->created_at }}
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>