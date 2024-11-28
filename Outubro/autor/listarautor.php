<?php
require_once('../classes/autoload.php');
require_once('../config/config.inc.php');

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $busca = isset($_GET['busca']) ? $_GET['busca'] : "";
    $tipo = isset($_GET['tipo']) ? $_GET['tipo'] : 0;
    // $lista = Usuario::listar($tipo, $busca);
    $lista = Autor::listar($tipo, $busca);
    $msg = isset($_GET['MSG']) ? $_GET['MSG'] : "";
    $itens = "";
    foreach ($lista as $usuario) {
        $item = file_get_contents('templates/itens_autor.html');
        $item = str_replace('{id}', $usuario->getId(), $item);
        $item = str_replace('{nome}', $usuario->getNome(), $item);
        $item = str_replace('{lsname}', $usuario->getLast(), $item);
        $itens .= $item;
    }
    $templateLista = file_get_contents('templates/lista_autor.html');
    $templateLista = str_replace('{itens}', $itens, $templateLista);
    print($templateLista);
}
