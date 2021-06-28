<?php
date_default_timezone_set('America/Sao_Paulo');

// --> Dados base
$gameId = null;
$operacao = null;
$title = null;
$producer = null;
$preco = null;
$categoria = null;
$data_lancamento = null;
$sinopse = null;

// --> Abrindo sessão
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

limparSessao();


// --> Função de conexão com o banco
function connect(){
    $servidor = "localhost";
    $banco = "gamesapp";
    $usuario = "root";
    $senha = "";
    $con = null;

    try{

        $con = new PDO("mysql:host=$servidor;dbname=$banco;charset=utf8", $usuario, $senha);

        return $con; 
        
    }
    catch(PDOException $ex){
        echo "<h2 class='alert alert-danger' role='alert'>Erro: " .  $ex->getMessage() . "</h2>";
        echo "<p><a href='P2_Jogos_Principal.php'>Clique aqui para voltar</a></p>";
        die();
    }
}

// --> Recuperando campos
function obterCampos(){
    try{

        global $operacao;
        global $gameId;
        global $title;
        global $producer;
        global $preco;
        global $categoria;
        global $data_lancamento;
        global $sinopse;

        // Operação
        if(isset($_REQUEST["btnOperacao"])){
            $operacao = $_REQUEST["btnOperacao"];
            $operacao = strtoupper($operacao);
        }
        else{
            $operacao = "VAZIO";
        }

        // Id
        if(isset($_REQUEST["gameId"])){
            if(!empty($_REQUEST["gameId"])){
                $gameId = $_REQUEST["gameId"];
                $_SESSION['gameId'] = $gameId;
            }
        }

        // Titulo
        if(isset($_REQUEST["titulo"])){
            if(!empty($_REQUEST["titulo"])){
                $title = $_REQUEST["titulo"];
                $_SESSION['titulo'] = $title;
            }
        }

        // Sinopse
        if(isset($_REQUEST["sinopse"])){
            if(!empty($_REQUEST["sinopse"])){
                $sinopse = $_REQUEST["sinopse"];
                $_SESSION['sinopse'] = $sinopse;
            }
        }

        // Preço
        if(isset($_REQUEST["preco"])){
            if(!empty($_REQUEST["preco"])){
                $preco = $_REQUEST["preco"];
                $_SESSION['preco'] = $preco;
            }
        }

        // Categoria
        if(isset($_REQUEST["categ"])){
            if(!empty($_REQUEST["categ"])){
                $categoria = $_REQUEST["categ"];
                $_SESSION['categ'] = $categoria;
            }
        }

        // Data de lançamento
        if(isset($_REQUEST["date"])){
            if(!empty($_REQUEST["date"])){
                $data_lancamento = $_REQUEST["date"];
                $_SESSION['date'] = $data_lancamento;
            }
        }

        // Produtora
        if(isset($_REQUEST["produtora"])){
            if(!empty($_REQUEST["produtora"])){
                $producer = $_REQUEST["produtora"];
                $_SESSION['produtora'] = $producer;
            }
        }

    }
    catch(Error $ex){
        echo "<h2 style='color: red;'>Erro: " .  $ex->getMessage() . "</h2>";
        echo "<p><a href='P2_Jogos_Principal.php'>Clique aqui para voltar</a></p>";
        die();
    }

}

// --> Validando campos
function validarCampos(){
    try {
        global $title;
        global $producer;
        global $categoria;
        global $data_lancamento;
        global $sinopse;

        $validar = 1;

        if (empty($title)) {
            $_SESSION['tituloVazio'] = "Por favor, informe o título do jogo";
            $validar = 0;
        }

        if (empty($producer)) {
            $_SESSION['produtoraVazio'] = "Por favor, informe a produtora do jogo";
            $validar = 0;
        }
        if (empty($categoria)) {
            $_SESSION['categoriaVazio'] = "Por favor, informe a categoria do jogo";
            $validar = 0;
        }
        if (empty($data_lancamento)) {
            $_SESSION['dataVazio'] = "Por favor, informe a data de lançamento do jogo";
            $validar = 0;
        }
        if (empty($sinopse)) {
            $_SESSION['sinopseVazio'] = "Por favor, informe a sinopse do jogo";
            $validar = 0;
        }

        return $validar;
    }
    catch(Error $ex){
        echo "<h2 style='color: red;'>Erro: " .  $ex->getMessage() . "</h2>";
        echo "<p><a href='P2_Jogos_Principal.php'>Clique aqui para voltar</a></p>";
        die();
    }
}

// --> Limpando dados da sessão
function limparSessao(){
    try {
        unset($_SESSION['titulo']);
        unset($_SESSION['sinopse']);
        unset($_SESSION['preco']);
        unset($_SESSION['categ']);
        unset($_SESSION['date']);
        unset($_SESSION['produtora']);
        unset($_SESSION['tituloVazio']);
        unset($_SESSION['produtoraVazio']);
        unset($_SESSION['categoriaVazio']);
        unset($_SESSION['dataVazio']);
        unset($_SESSION['sinopseVazio']);
    } catch (Error $ex) {
        echo "<h2 style='color: red;'>Erro: " .  $ex->getMessage() . "</h2>";
        echo "<p><a href='P2_Jogos_Principal.php'>Clique aqui para voltar</a></p>";
        die();
    }
}

function insert(){
    try {
        global $title;
        global $producer;
        global $preco;
        global $categoria;
        global $data_lancamento;
        global $sinopse;

        if (!validarCampos()) {
            return;
        }

        $connection = connect();

        $dataCriacao = date('Y-m-d H:i:s');

        $cmdSQL = $connection->prepare("INSERT INTO jogos (titulo, produtora, preço_lançamento, data_lançamento, sinopse, categoria, data_criacao) 
                                        VALUES (:title, :producer, :preco, :data_lancamento, :sinopse, :categoria, :dataCriacao)");

        $cmdSQL->bindParam("title", $title);
        $cmdSQL->bindParam("producer", $producer);
        $cmdSQL->bindParam("preco", $preco);
        $cmdSQL->bindParam("data_lancamento", $data_lancamento);
        $cmdSQL->bindParam("sinopse", $sinopse);
        $cmdSQL->bindParam("categoria", $categoria);
        $cmdSQL->bindParam("dataCriacao", $dataCriacao);

        if ($cmdSQL->execute()) {
            limparSessao();
        } else {
            echo "<h2 style='color: red;'>Erro: " .  var_dump($cmdSQL->errorInfo()) . "</h2>";
            echo "<p><a href='P2_Jogos_Principal.php'>Clique aqui para voltar</a></p>";
            die();
        }
    } catch (Error $ex) {
        echo "<h2 style='color: red;'>Erro: " .  $ex->getMessage() . "</h2>";
        echo "<p><a href='P2_Jogos_Principal.php'>Clique aqui para voltar</a></p>";
        die();
    } finally {
        $connection = null;
    }
}

function findAll(){
    try {
        $con = connect();

        $sql = $con->prepare("SELECT * FROM jogos");

        if ($sql->execute()) {
            $jogos = $sql->fetchAll();
            if (count($jogos)) {
                return $jogos;
            } else {
                return [];
            }
        }
        
    } catch (PDOException $ex) {
        echo "<h2 style='color: red;'>Erro: " .  $ex->getMessage() . "</h2>";
        echo "<p><a href='P2_Jogos_Principal.php'>Clique aqui para voltar</a></p>";
        die();
    } finally {
        $con = null;
    }
}

function findById(){
    try {
        global $gameId;

        $con = connect();
        
        $sql = $con->prepare("SELECT * FROM jogos WHERE id = :gameId");

        $sql->bindParam(":gameId", $gameId);

        if ($sql->execute()) {
            $jogo = $sql->fetchAll();
            if (count($jogo)) {
                return $jogo;
            } else return [];
        } else {
            echo "<h2 style='color: red;'>Erro: " .  var_dump($sql->errorInfo()) . "</h2>";
            echo "<p><a href='P2_Jogos_Principal.php'>Clique aqui para voltar</a></p>";
            die();
        }

        
    } catch (PDOException $ex) {
        echo "<h2 style='color: red;'>Erro: " .  $ex->getMessage() . "</h2>";
        echo "<p><a href='P2_Jogos_Principal.php'>Clique aqui para voltar</a></p>";
        die();
    } finally {
        $con = null;
    }
}

function atualizar(){
    try {
        global $gameId;
        global $title;
        global $producer;
        global $preco;
        global $categoria;
        global $data_lancamento;
        global $sinopse;

        if (!validarCampos()) {
            return;
        }

        $con = connect();
        $dataCriacao = date('Y-m-d H:i:s');

        $sql = $con->prepare("UPDATE jogos SET titulo = :title, produtora = :producer, preço_lançamento = :preco, 
        data_lançamento = :data_lancamento, sinopse = :sinopse, categoria = :categoria, data_criacao = :dataCriacao WHERE id = :gameId");

        $sql->bindParam(":gameId", $gameId);
        $sql->bindParam("title", $title);
        $sql->bindParam("producer", $producer);
        $sql->bindParam("preco", $preco);
        $sql->bindParam("data_lancamento", $data_lancamento);
        $sql->bindParam("sinopse", $sinopse);
        $sql->bindParam("categoria", $categoria);
        $sql->bindParam("dataCriacao", $dataCriacao);
        	
        if ($sql->execute()) {
            header("Location: P2_Jogos_Principal.php");
        } else {
            echo "<h2 style='color: red;'>Erro: " .  var_dump($sql->errorInfo()) . "</h2>";
            echo "<p><a href='P2_Jogos_Principal.php'>Clique aqui para voltar</a></p>";
            die();
        }

    } catch (PDOException $ex) {
        echo "<h2 style='color: red;'>Erro: " .  $ex->getMessage() . "</h2>";
        echo "<p><a href='P2_Jogos_Principal.php'>Clique aqui para voltar</a></p>";
        die();
    } finally {
        $con = null;
    }
}

function excluir(){
    try {
        global $gameId;

        $con = connect();

        $sql = $con->prepare("DELETE FROM jogos WHERE id = :gameId");

        $sql->bindParam(":gameId", $gameId);

        if ($sql->execute()) {
            header("Location: P2_Jogos_Principal.php");
        } else {
            echo "<h2 style='color: red;'>Erro: " .  var_dump($sql->errorInfo()) . "</h2>";
            echo "<p><a href='P2_Jogos_Principal.php'>Clique aqui para voltar</a></p>";
            die();
        }
    } catch (PDOException $ex) {
        echo "<h2 style='color: red;'>Erro: " .  $ex->getMessage() . "</h2>";
        echo "<p><a href='P2_Jogos_Principal.php'>Clique aqui para voltar</a></p>";
        die();
    } finally {
        $con = null;
    }
}