<?php
require_once("../classes/autoload.php");
require_once("../config/config.inc.php");

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $msg = isset($_GET['MSG']) ? $_GET['MSG'] : "";
    $busca = isset($_GET['busca']) ? $_GET['busca'] : "";
    $tipo = isset($_GET['tipo']) ? $_GET['tipo'] : 0;
    $lista = Livro::listar($tipo, $busca);
    $itens = "";
    foreach ($lista as $livro) {
        $item = file_get_contents('templates/itens_livros.html');
        $item = str_replace('{id}', $livro->getId(), $item);
        $item = str_replace('{titulo}', $livro->getTitulo(), $item);
        $item = str_replace('{ano}', $livro->getAno(), $item);
        $item = str_replace('{foto}', $livro->getFoto(), $item);
        $item = str_replace('{categoria}', $livro->getCategoria()->getId(), $item);
        $item = str_replace('{preco}',$livro->getPreco(), $item);
        $itens .= $item;
        
    }
    
    $templatelista = file_get_contents('templates/lista_livro.html');
    $templatelista = str_replace('{itens}', $itens, $templatelista);
    print($templatelista);
}