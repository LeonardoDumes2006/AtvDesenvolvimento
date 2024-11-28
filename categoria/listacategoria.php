<?php
require_once("../classes/autoload.php");
require_once("../config/config.inc.php");

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $msg = isset($_GET['MSG']) ? $_GET['MSG'] : "";
    $busca = isset($_GET['busca']) ? $_GET['busca'] : "";
    $tipo = isset($_GET['tipo']) ? $_GET['tipo'] : 0;
    $lista = Categoria::listar($tipo, $busca);
    $itens = "";
    foreach ($lista as $livro) {
        $item = file_get_contents('templates/itens_categorias.html');
        $item = str_replace('{id}', $livro->getId(), $item);
        $item = str_replace('{categoria}', $livro->getCategoria(), $item);
        $itens .= $item;
        
    }
    
    $templatelista = file_get_contents('templates/lista_categoria.html');
    $templatelista = str_replace('{itens}', $itens, $templatelista);
    print($templatelista);
}