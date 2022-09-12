<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Controle de Produtos</title>
    <link rel="stylesheet" href="/resources/css/layout.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark" >
            <div class="container-fluid">
                <a class="navbar-brand" href="#">Nome do usuario</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="/buscar">Buscar</a>
                        </li>
                        <li class="nav-item">
                        <a class="nav-link" href="#">Caixa</a>
                        </li>
                        <li class="nav-item">
                        <a class="nav-link" href="/buscar/adicionar">Cadastrar</a>
                        </li>
                        <li class="nav-item">
                        <a class="nav-link disabled" href="#">Estoque</a>
                        </li>
                        <li class="nav-item">
                        <a class="nav-link disabled" href="#">Vendas</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <div class="container">
        
        <div class="jumbotron">
            <h1>@yield('cabecalho')</h1>
        </div>
        @yield('conteudo')
     </div>
</body>
</html>