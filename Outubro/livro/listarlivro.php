<?php
require_once('../classes/autoload.php');
require_once('../config/config.inc.php');

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $busca = isset($_GET['busca']) ? $_GET['busca'] : "";
    $tipo = isset($_GET['tipo']) ? $_GET['tipo'] : 0;
    $lista = Livro::listar($tipo, $busca);

    $msg = isset($_GET['MSG']) ? $_GET['MSG'] : "";
    $itens = "";
    foreach ($lista as $livro) {
        $item = file_get_contents('templates/itens_livro.html');
        $item = str_replace('{id}', $livro->getId(), $item);
        $item = str_replace('{titulo}', $livro->getTitulo(), $item);
        $item = str_replace('{pub}', $livro->getPub(), $item);
        $item = str_replace('{capa}', $livro->getCape(), $item);
        $item = str_replace('{categoria}', $livro->getCategoria()->getDescricao(), $item);
        $item = str_replace('{preco}', $livro->getPreco(), $item);
        $itens .= $item;
    }
    $templateLista = file_get_contents('templates/lista_livro.html');
    $templateLista = str_replace('{itens}', $itens, $templateLista);
    print($templateLista);
}
