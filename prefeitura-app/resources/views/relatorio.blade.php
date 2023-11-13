<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatório</title>
    <style>
        * {
            margin: 0px;
            padding: 0px;
            box-sizing: border-box;
            font-family: "Gill Sans", sans-serif;
        }

        hr {

            border-top: 1px solid #F8F7F7;
            margin: auto;
        }

        #header {
            text-align: center;
            padding: 5px;
            margin-bottom: 10px;
        }

        #header p {
            position: absolute;
            right: 5;
            bottom: 5;
            font-size: 0.65rem;
        }

        #header h2:first-child {
            margin-top: 5px;
            margin-bottom: 20px;
            font-size: 1rem;
            font-weight: normal;
        }

        .info {
            padding: 30px;
        }

        .info > p {
            margin-left: 10px;
        }

        .info h2 {
            margin-left: -5px;
            margin-bottom: 5px;
        }

        .protocolo {
            padding: 10px 10px 30px 10px;
            border: 1px solid gray;
            margin-bottom: 10px;
        }

        .protocolo p:last-child {
            margin-top: 5px;
        }

    </style>
</head>
<body>
    <div id="header">
        <h2>Prefeitura Municipal de São Leopoldo</h2>
        <p>{{ date('d/m/Y H:i:s') }}
        <h1>Relatório de Protocolos</h1>
    </div>
    <hr width="70%">
    
    <div class="info">
        <h2>Protocolos:</h2>
        <ul>
            @if(count($protocolos) > 0)
                @foreach($protocolos as $protocolo)
                <div class="protocolo">
                    <p><b>Número: </b>{{ $protocolo->id }}</p>
                    <p><b>Data:</b> {{ date( 'd/m/Y H:i:s' , strtotime($protocolo->created_at)) }}</p>    
                    <p><b>Contribuinte: </b>{{ $protocolo->contribuinte->nome }}</p>
                    <p><b>Departamento: </b>{{ $protocolo->departamento->nome }}</p>
                    <p>{{ $protocolo->descricao }}</p>
                    
                </div>
                @endforeach
            @else
                <p>Sem Protocolos</p>
            @endif
        </ul>
    </div>
</body>
</html>