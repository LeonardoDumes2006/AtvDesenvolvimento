<?php
require_once("../classes/autoload.php");
require_once("../config/config.inc.php");

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $id = isset($_GET['id']) ? $_GET['id'] : 0;
    $msg = isset($_GET['MSG']) ? $_GET['MSG'] : "";

    $formulario = file_get_contents('templates/form_cadastro_categoria.html');

    if($id > 0){
        $categoria = Categoria::listar(1, $id)[0];
        $formulario = str_replace('{id}', $categoria->getId(), $formulario);
        $formulario = str_replace('{categoria}', $categoria->getCategoria(), $formulario);
    }else {
        $formulario  = str_replace('{id}', '0', $formulario);
        $formulario  = str_replace('{categoria}', '', $formulario);
    }
    
    print($formulario);
     include "listacategoria.php";
}

else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = isset($_POST['id']) ? $_POST['id'] : 0;
    $categoria = isset($_POST['categoria']) ? $_POST['categoria'] : "";
    $acao = isset($_POST['acao']) ? $_POST['acao'] : "";

    try {

        $categoria = new Categoria($id, $categoria);
     
       
        $resultado = "";
        switch ($acao) {
            case ("Salvar"):
                $resultado = $categoria->incluir();
                break;
            case ("Alterar"):
                $resultado = $categoria->alterar();
                break;
            case ("Excluir"):
                $resultado = $categoria->excluir();
                break;
        }

        if ($resultado)
            header('Location: index.php');
        else
            echo "erro ao inserir dados!";

    } catch (Exception $e) {
        header('Location:index.php?MSG=ERROR:' . $e->getMessage());
    }
} 