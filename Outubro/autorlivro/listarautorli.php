<?php
require_once('../classes/autoload.php');
require_once('../config/config.inc.php');

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $busca = isset($_GET['busca']) ? $_GET['busca'] : "";
    $tipo = isset($_GET['tipo']) ? $_GET['tipo'] : 0;
    // $lista = Usuario::listar($tipo, $busca);
    $lista = AutorLivro::listar($tipo, $busca);
    $msg = isset($_GET['MSG']) ? $_GET['MSG'] : "";
    $itens = "";
    foreach ($lista as $usuario) {
        $item = file_get_contents('templates/itens_autorli.html');
        $item = str_replace('{id}', $usuario->getId(), $item);
        $item = str_replace('{autor}', $usuario->getAutor()->getNome()." ".$usuario->getAutor()->getLast(), $item);
        $item = str_replace('{livro}', $usuario->getLivro()->getTitulo(), $item);
        $itens .= $item;
    }
    $templateLista = file_get_contents('templates/lista_autorli.html');
    $templateLista = str_replace('{itens}', $itens, $templateLista);
    print($templateLista);
}
