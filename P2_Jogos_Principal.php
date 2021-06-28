<!-- Projeto realizado em dupla por Rafael Andrade Escarabelo SC301150X e Ricardo Peres Teixeira SC3011488 -->
<?php
include("./P2_Jogos_Processamento.php");
obterCampos();

if($operacao == "INSERIR"){
    insert();
}

$jogos = findAll();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Principal</title>
    <script src="https://kit.fontawesome.com/7928671f8b.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/7928671f8b.js" crossorigin="anonymous"></script>
    <style>
        .alert {
            text-align: center;
            margin-bottom: 10px;
            padding-top: 25px;
        }

        #submitbtn {
            float: right;
        }

        table {
            text-align: center;
            align-items: center;
        }

    </style>
    <script>
        if ( window.history.replaceState ) {
            window.history.replaceState( null, null, window.location.href );
        }
    </script>
</head>
<body>
    <section class="alert alert-primary" role="alert">
        <h1>Cadastre um novo jogo!</h1>
        <hr>
    </section>
    <section class="container">
        <form method="POST" action="">
            <div class="mb-3">
                <label class="form-label" for="titulo">Titulo:</label>
                <input class="form-control" id="titulo" type="text" name="titulo" placeholder="Jogo...">
                <?php
                    if (!empty($_SESSION['tituloVazio'])) {
                        echo "<br><p class='alert alert-danger' role='alert'>" . $_SESSION['tituloVazio'] . "</p>";
                        unset($_SESSION['tituloVazio']);
                    }
                ?>
            </div>
            <div class="mb-3">
                <label class="form-label" for="produtora">Produtora:</label>
                <input class="form-control" id="produtora" type="text" name="produtora" placeholder="Feito por...">
                <?php
                    if (!empty($_SESSION['produtoraVazio'])) {
                        echo "<br><p class='alert alert-danger' role='alert'>" . $_SESSION['produtoraVazio'] . "</p>";
                    }
                ?>
            </div>
            <div class="mb-3">
                <label class="form-label" for="preco">Preço de lançamento:</label>
                <div class="input-group">
                    <span class="input-group-text" id="basic-addon1">R$</span>
                    <input class="form-control" id="preco" type="number" min="0" max="400" name="preco" step=".5">
                    <span class="input-group-text" id="basic-addon3">.00</span>
                </div>               
            </div>
            <div class="mb-3">
                <label class="form-label" for="date">Data de lançamento:</label>
                <input class="form-control" id="date" type="date" name="date">
                <?php
                    if (!empty($_SESSION['dataVazio'])) {
                        echo "<br><p class='alert alert-danger' role='alert'>" . $_SESSION['dataVazio'] . "</p>";
                    }
                ?>
            </div>
            <div class="mb-3">
                <label for="categ" class="form-label">Categoria:</label>
                <select name="categ" id="categ" class="form-select">
                    <option value="RPG">RPG</option>
                    <option value="FPS">FPS</option>
                    <option value="MOBA">MOBA</option>
                    <option value="Simulador">Simulador</option>
                    <option value="Plataforma">Plataforma</option>
                </select>
                <?php
                    if (!empty($_SESSION['categoriaVazio'])) {
                        echo "<br><p class='alert alert-danger' role='alert'>" . $_SESSION['categoriaVazio'] . "</p>";
                    }
                ?>
            </div>
            <div class="mb-3">
                <label class="form-label" for="sinopse">Sinopse:</label>
                <textarea class="form-control" id="sinopse" name="sinopse" placeholder="Sinopse do jogo..." rows="6"></textarea>
                <?php
                    if (!empty($_SESSION['sinopseVazio'])) {
                        echo "<br><p class='alert alert-danger' role='alert'>" . $_SESSION['sinopseVazio'] . "</p>";
                    }
                ?>
            </div>
            <div class="mb-3">
                <button class="btn btn-danger btn-lg" type="reset">Reset</button>
                <input type="submit" name="btnOperacao" value="Inserir" class="btn btn-success btn-lg" id="submitbtn"> &nbsp; &nbsp;
            </div>
        </form>
        <hr>

        <table class="table table-dark table-hover align-middle">
            <thead>
                <tr>
                <th scope="col">ID</th>
                <th scope="col">Título</th>
                <th scope="col">Produtora</th>
                <th scope="col">Preço</th>
                <th scope="col">Data de lançamento</th>
                <th scope="col">Categoria</th>
                <th scope="col">Sinopse</th>
                <th scope="col"></th>

                </tr>
            </thead>
            <tbody>
            <?php
                foreach ($jogos as $jogo) {
                    $id = $jogo['id'];
                    $titulo = $jogo['titulo'];
                    $preco_lancamento = $jogo['preço_lançamento'];
                    $produtora = $jogo['produtora'];
                    $data_lancamento = $jogo['data_lançamento'];
                    $categoria = $jogo['categoria'];
                    $sinopse = $jogo['sinopse'];
                   echo "
                    <tr>
                    <th scope='row'>$id</th>
                    <td>$titulo</td>
                    <td>$produtora</td>
                    <td>$preco_lancamento</td>
                    <td>$data_lancamento</td>
                    <td>$categoria</td>
                    <td>$sinopse</td>
                    <td>
                        <a href='P2_Jogos_Alterar.php?gameId=$id' class='btn btn-warning'>
                            <i class='fas fa-edit'></i>
                        </a>
                        <a href='P2_Jogos_Excluir.php?gameId=$id' class='btn btn-danger'>
                            <i class='fas fa-trash-alt'></i>
                        </a>
                    </td>
                    </tr>
                   ";
                }
            ?>
                
            </tbody>
        </table>
    </section>
    
</body>
</html>