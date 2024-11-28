<?php
require_once('../classes/autoload.php');
require_once('../config/config.inc.php');

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $id = isset($_GET['id']) ? $_GET['id'] : 0;
    $msg = isset($_GET['MSG']) ? $_GET['MSG'] : "";
    $formulario = file_get_contents('templates/form_cadastro_categoria.html');
    if ($id > 0) {
        $categoria = Categoria::listar(1, $id)[0];
        $formulario = str_replace('{id}', $categoria->getId(), $formulario);
        $formulario = str_replace('{descricao}', $categoria->getDescricao(), $formulario);
    } else {
        $formulario = str_replace('{id}', 0, $formulario);
        $formulario = str_replace('{descricao}', '', $formulario);
    }
    print($formulario);
    include "listarcategoria.php";
} else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = isset($_POST['id']) ? $_POST['id'] : 0;
    $descricao = isset($_POST['descricao']) ? $_POST['descricao'] : "";

    $acao = isset($_POST['acao']) ? $_POST['acao'] : 0;

    try {
        $categoria = new Categoria($id, $descricao);
        $resultado = "";
        if ($acao == 'salvar') {
            if ($id > 0) {
                $resultado = $categoria->alterar();
            } else {
                $resultado = $categoria->incluir();
            }
        } elseif ($acao == 'excluir') {
            $resultado = $categoria->excluir();
        }
        var_dump($categoria);
        if ($resultado)
            header('Location: index.php');
        else
            echo "erro ao inserir dados!";
    } catch (Exception $e) {

        echo $e;
    }
}
