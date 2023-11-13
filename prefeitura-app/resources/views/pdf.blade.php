<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
            margin-left: 5px;
        }

        .info h2 {
            margin-left: -5px;
            margin-bottom: 5px;
        }

        #descricao {
            margin-top: 10px;
            padding: 5px 10px 30px 10px;
            border: 1px solid gray; 
        }

        .acompanhamento {
            padding: 10px 10px 30px 10px;
            border: 1px solid gray;
            margin-bottom: 10px;
        }

        .acompanhamento p:last-child {
            margin-top: 5px;
        }
    </style>
</head>
<body>
    <div id="header">
        <h2>Prefeitura Municipal de São Leopoldo</h2>
        <p>{{ date('d/m/Y H:i:s') }}
        <h1>Relatório Protocolo nº {{ $protocolo->id }}</h1>
    </div>
    <hr width="70%">
    <div class="info">
        <h2>Dados:</h2>   
        <p><b>Data de Cadastro:</b> {{ date( 'd/m/Y H:i:s' , strtotime($protocolo->created_at)) }}</p>
        <p><b>Departamento:</b> {{ $protocolo->departamento->nome }}</p>
        <p><b>Contribuinte:</b> {{ $protocolo->contribuinte->nome }}</p>

        <div id="descricao">        
            <p><b>Descrição:</b></p>
            <p>{{ $protocolo->descricao }}</p>
        </div>
    </div>
   <hr width="90%">
    <div class="info">
        <h2>Acompanhamentos:</h2>
        <ul>
            @if(count($acompanhamentos) > 0)
                @foreach($acompanhamentos as $acompanhamento)
                <div class="acompanhamento">
                    <p><b>Data:</b> {{ date( 'd/m/Y H:i:s' , strtotime($acompanhamento->created_at)) }}</p>    
                    <p><b>Usuário: </b>{{ $acompanhamento->user->name }}</p>
                    <p>{{ $acompanhamento->observacao }}</p>
                    
                </div>
                @endforeach
            @else
                <p>Protocolo ainda não possui acompanhamentos</p>
            @endif
        </ul>
    </div>
</body>
</html>