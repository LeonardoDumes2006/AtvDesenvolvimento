<?php
require_once("../classes/Quadrado.class.php");
require_once("../classes/Unidade.class.php");
require_once("../classes/Database.class.php");

$id = isset($_GET['id']) ? $_GET['id'] : 0;
$msg = isset($_GET['MSG']) ? $_GET['MSG'] : "";
if ($id > 0) {
    $quadrado = Quadrado::listar(1, $id)[0];
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = isset($_POST['id']) ? $_POST['id'] : 0;
    $altura = isset($_POST['altura']) ? $_POST['altura'] : 0;
    $cor = isset($_POST['cor']) ? $_POST['cor'] : "";
    $unidade = isset($_POST['unidade']) ? $_POST['unidade'] : "";
    $acao = isset($_POST['acao']) ? $_POST['acao'] : 0;

    try {
        $uni = Unidade::listar(1, $unidade)[0];
        $quadrado = new Quadrado($id, $altura, $cor, $uni);
        $resultado = "";
        switch ($acao) {
            case ("Salvar"):
                $resultado = $quadrado->incluir();
                break;
            case ("alterar"):
                $resultado = $quadrado->alterar();
                break;
            case ("excluir"):
                $resultado = $quadrado->excluir();
                break;
        }

        if ($resultado)
            header('Location: index.php');
        else
            echo "erro ao inserir dados!";
        
    } catch (Exception $e) {
        header('Location:index.php?MSG=ERROR:' . $e->getMessage());
    }
} else if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $busca = isset($_GET['busca']) ? $_GET['busca'] : "";
    $tipo = isset($_GET['tipo']) ? $_GET['tipo'] : 0;
    $lista = Quadrado::listar($tipo, $busca);
}
