<?php
require_once("../classes/autoload.php");
require_once("../config/config.inc.php");

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $id = isset($_GET['id']) ? $_GET['id'] : 0;
    $msg = isset($_GET['MSG']) ? $_GET['MSG'] : "";

    $formulario = file_get_contents('templates/form_cadastro_usuario.html');

    $usuarios = Usuario::listar();
    $categoriaOptions = '';
    $usuarioselected = '';

    if($id > 0){
        $usuario = Cliente::listar(1, $id)[0];
        $formulario = str_replace('{id}', $usuario->getId(), $formulario);
        $formulario = str_replace('{nome}', $usuario->getNome(), $formulario);
        $formulario = str_replace('{email}', $usuario->getEmail(), $formulario);
        $formulario = str_replace('{senha}', $usuario->getsenha(), $formulario);

        if ($usuario->getPermissao() == 1) {
            $formulario = str_replace('{selected_0}', 'selected', $formulario);
            $formulario = str_replace('{selected_1}', '', $formulario);
        } else {
            $formulario = str_replace('{selected_0}', '', $formulario);
            $formulario = str_replace('{selected_1}', 'selected', $formulario);
        }

        $formulario = str_replace('{permissao}', $usuario->getPermissao(), $formulario);
        $formulario = str_replace('{cpf}', $usuario->getCpf(), $formulario);
    }else {
        $formulario  = str_replace('{id}', '0', $formulario);
        $formulario  = str_replace('{nome}', '', $formulario);
        $formulario  = str_replace('{email}', '', $formulario);
        $formulario  = str_replace('{senha}', '', $formulario);
        $formulario  = str_replace('{permissao}', '', $formulario);
        $formulario  = str_replace('{cpf}', '', $formulario);
    }
    
    print($formulario);
     include "listausuarios.php";
}

else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = isset($_POST['id']) ? $_POST['id'] : 0;
    $nome = isset($_POST['nome']) ? $_POST['nome'] : "";
    $email = isset($_POST['email']) ? $_POST['email'] : "";
    $senha = isset($_POST['senha']) ? $_POST['senha'] : "";
    $permissao = isset($_POST['permissao']) ? $_POST['permissao'] : 0;
    $cpf = isset($_POST['cpf']) ? $_POST['cpf'] : "";
    $acao = isset($_POST['acao']) ? $_POST['acao'] : "";

    try {
        if($permissao == 1){
            $user = new Cliente($id, $nome, $email, $senha, $permissao, $cpf); 
        } 
        else 
        $user = new Usuario($id, $nome, $email, $senha, $permissao);
     
       
        $resultado = "";
        switch ($acao) {
            case ("Salvar"):
                $resultado = $user->incluir();
                break;
            case ("Alterar"):
                $resultado = $user->alterar();
                break;
            case ("Excluir"):
                $resultado = $user->excluir();
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