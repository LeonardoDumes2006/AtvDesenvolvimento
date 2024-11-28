<?php
require_once("../classes/autoload.php");
require_once("../config/config.inc.php");

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $id = isset($_GET['id']) ? $_GET['id'] : 0;
    $msg = isset($_GET['MSG']) ? $_GET['MSG'] : "";

    $formulario = file_get_contents('templates/form_cadastro_autor.html');

    if($id > 0){
        $autor = Autor::listar(1, $id)[0];
        $formulario = str_replace('{id}', $autor->getId(), $formulario);
        $formulario = str_replace('{nome}', $autor->getNome(), $formulario);
        $formulario = str_replace('{sobrenome}', $autor->getSobrenome(), $formulario);
    }else {
        $formulario  = str_replace('{id}', '0', $formulario);
        $formulario  = str_replace('{nome}', '', $formulario);
        $formulario  = str_replace('{sobrenome}', '', $formulario);
    }
    
    print($formulario);
     include "listaautores.php";
}

else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = isset($_POST['id']) ? $_POST['id'] : 0;
    $nome = isset($_POST['nome']) ? $_POST['nome'] : "";
    $sobrenome = isset($_POST['sobrenome']) ? $_POST['sobrenome'] : "";
    $acao = isset($_POST['acao']) ? $_POST['acao'] : "";

    try {
            $autor = new Autor($id, $nome, $sobrenome); 
       
        $resultado = "";
        switch ($acao) {
            case ("Salvar"):
                $resultado = $autor->incluir();
                break;
            case ("Alterar"):
                $resultado = $autor->alterar();
                break;
            case ("Excluir"):
                $resultado = $autor->excluir();
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