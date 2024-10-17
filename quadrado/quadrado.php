<?php
require_once("../classes/autoload.php");
require_once("../config/config.inc.php");

$id = isset($_GET['id']) ? $_GET['id'] : 0;
$msg = isset($_GET['MSG']) ? $_GET['MSG'] : "";
if ($id > 0) {
    $quadrado = Quadrado::listar(1, $id)[0];
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = isset($_POST['id']) ? $_POST['id'] : 0;
    $lado = isset($_POST['lado']) ? $_POST['lado'] : 0;
    $cor = isset($_POST['cor']) ? $_POST['cor'] : "";
    $unidade = isset($_POST['unidade']) ? $_POST['unidade'] : "";
    $arquivo = isset($_FILES['img']) ? $_FILES['img'] : "";
    $acao = isset($_POST['acao']) ? $_POST['acao'] : 0;
    $destino = "../".IMG."/".$arquivo['name'];

    try {
        $uni = Unidade::listar(1, $unidade)[0];
        $quadrado = new Quadrado($id, $lado, $cor, $uni,$destino);
            $resultado = "";
            switch ($acao) {
                case ("Salvar"):
                    $resultado = $quadrado->incluir();
                    break;
                case ("Alterar"):
                    $resultado = $quadrado->alterar();
                    break;
                case ("Excluir"):
                    $resultado = $quadrado->excluir();
                    break;
            }

            if ($resultado)
                header('Location: index.php');
            else
                echo "erro ao inserir dados!";

        $_SESSION['IMG'] = "Dados Inseridos com sucesso!!";
        move_uploaded_file($arquivo['tmp_name'],$destino);
        
    } catch (Exception $e) {
        header('Location:index.php?MSG=ERROR:' . $e->getMessage());
    }
} else if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $busca = isset($_GET['busca']) ? $_GET['busca'] : "";
    $tipo = isset($_GET['tipo']) ? $_GET['tipo'] : 0;
    $lista = Quadrado::listar($tipo, $busca);
}
