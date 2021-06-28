<!-- Projeto realizado em dupla por Rafael Andrade Escarabelo SC301150X e Ricardo Peres Teixeira SC3011488 -->
<?php
$jogo = [];

include("./P2_Jogos_Processamento.php");
obterCampos();

if($operacao == "ALTERAR"){
    atualizar();
} elseif ($operacao == "CANCELAR") {
    header("Location: P2_Jogos_Principal.php");
}

$jogo = findById();

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
        <h1>Edite o jogo #<?php echo $jogo[0]['id']; ?>!</h1>
        <hr>
    </section>
    <section class="container">
        <form method="POST" action="">
            <div class="mb-3">
                <label class="form-label" for="titulo">Titulo:</label>
                <input class="form-control" id="titulo" type="text" name="titulo" value="<?php echo $jogo[0]['titulo']; ?>">
                <?php
                    if (!empty($_SESSION['tituloVazio'])) {
                        echo "<br><p class='alert alert-danger' role='alert'>" . $_SESSION['tituloVazio'] . "</p>";
                        unset($_SESSION['tituloVazio']);
                    }
                ?>
            </div>
            <div class="mb-3">
                <label class="form-label" for="produtora">Produtora:</label>
                <input class="form-control" id="produtora" type="text" name="produtora" value="<?php echo $jogo[0]['produtora']; ?>">
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
                    <input class="form-control" id="preco" type="number" min="0" max="400" name="preco" step=".5" value="<?php echo $jogo[0]['preço_lançamento']; ?>">
                    <span class="input-group-text" id="basic-addon3">.00</span>
                </div>               
            </div>
            <div class="mb-3">
                <label class="form-label" for="date">Data de lançamento:</label>
                <input class="form-control" id="date" type="date" name="date" value="<?php echo $jogo[0]['data_lançamento']; ?>">
                <?php
                    if (!empty($_SESSION['dataVazio'])) {
                        echo "<br><p class='alert alert-danger' role='alert'>" . $_SESSION['dataVazio'] . "</p>";
                    }
                ?>
            </div>
            <div class="mb-3">
                <label for="categ" class="form-label">Categoria:</label>
                <select name="categ" id="categ" class="form-select">
                    <option value="RPG" <?= ($jogo[0]['categoria'] == 'RPG')? 'selected' : ''; ?>>RPG</option>
                    <option value="FPS" <?= ($jogo[0]['categoria'] == 'FPS')? 'selected' : ''; ?>>FPS</option>
                    <option value="MOBA" <?= ($jogo[0]['categoria'] == 'MOBA')? 'selected' : ''; ?>>MOBA</option>
                    <option value="Simulador" <?= ($jogo[0]['categoria'] == 'Simulador')? 'selected' : ''; ?>>Simulador</option>
                    <option value="Plataforma" <?= ($jogo[0]['categoria'] == 'Plataforma')? 'selected' : ''; ?>>Plataforma</option>
                </select>
                <?php
                    if (!empty($_SESSION['categoriaVazio'])) {
                        echo "<br><p class='alert alert-danger' role='alert'>" . $_SESSION['categoriaVazio'] . "</p>";
                    }
                ?>
            </div>
            <div class="mb-3">
                <label class="form-label" for="sinopse">Sinopse:</label>
                <textarea class="form-control" id="sinopse" name="sinopse" rows="6"><?php echo $jogo[0]['sinopse']; ?></textarea>
                <?php
                    if (!empty($_SESSION['sinopseVazio'])) {
                        echo "<br><p class='alert alert-danger' role='alert'>" . $_SESSION['sinopseVazio'] . "</p>";
                    }
                ?>
            </div>
            <div class="mb-3">
                <input class="btn btn-danger btn-lg" value="Cancelar" name="btnOperacao" type="submit"> &nbsp; &nbsp;
                <input type="submit" name="btnOperacao" value="Alterar" class="btn btn-success btn-lg" id="submitbtn"> &nbsp; &nbsp;
            </div>
        </form>
    </section>
    
</body>
</html>