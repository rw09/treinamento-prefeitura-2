<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        * {
            margin: 0px;
            padding: 0px;
            box-sizing: border-box;
        }

        h1 {
            background-color: red;
            text-align: center;
            padding: 5px;
        }
    </style>
    <title>Document</title>
</head>
<body>
    <h1>Relatório</h1>
    <table>
        <thead>
            <tr>
                <td>Protocolo Número</td>
                <td>Data</td>
                <td>Contribuinte</td>
                <td>Descrição</td>
            </tr>
        </thead>
        <tbody>
            @foreach($protocolos as $protocolo)
            <tr>
                <td>{{ $protocolo->id }}</td>
                <td>{{ date('d/m/Y',  strtotime($protocolo->created_at)) }}</td>
                <td>{{ $protocolo->contribuinte->nome }}</td>
                <td>{{ $protocolo->descricao }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>