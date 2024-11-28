<?php
require_once("../classes/autoload.php");
require_once("../config/config.inc.php");

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $msg = isset($_GET['MSG']) ? $_GET['MSG'] : "";
    $busca = isset($_GET['busca']) ? $_GET['busca'] : "";
    $tipo = isset($_GET['tipo']) ? $_GET['tipo'] : 0;
    $lista = Cliente::listar($tipo, $busca);
    $itens = "";
    foreach ($lista as $usuario) {
        $item = file_get_contents('templates/itens_usuarios.html');
        $item = str_replace('{id}', $usuario->getId(), $item);
        $item = str_replace('{nome}', $usuario->getNome(), $item);
        $item = str_replace('{email}', $usuario->getEmail(), $item);
        $item = str_replace('{senha}', $usuario->getSenha(), $item);
        $item = str_replace('{permissao}', $usuario->getPermissao(), $item);
        $item = str_replace('{cpf}',$usuario->getCpf(), $item);
        $itens .= $item;
        
    }
    
    $templatelista = file_get_contents('templates/lista_usuario.html');
    $templatelista = str_replace('{itens}', $itens, $templatelista);
    print($templatelista);
}