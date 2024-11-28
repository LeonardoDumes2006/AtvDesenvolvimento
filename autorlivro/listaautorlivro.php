<?php
require_once("../classes/autoload.php");
require_once("../config/config.inc.php");

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $msg = isset($_GET['MSG']) ? $_GET['MSG'] : "";
    $busca = isset($_GET['busca']) ? $_GET['busca'] : "";
    $tipo = isset($_GET['tipo']) ? $_GET['tipo'] : 0;
    $lista = Autorlivro::listar($tipo, $busca);

    $itens = "";
    foreach ($lista as $autorlivro) {
        $item = file_get_contents('templates/itens_autorlivros.html');
        $item = str_replace('{id}', $autorlivro->getId(), $item);
        $item = str_replace('{autor}', $autorlivro->getAutor()->getNome(), $item);
        $item = str_replace('{livro}', $autorlivro->getLivro()->getTitulo(), $item);
        $itens .= $item;
    }
    
    $templatelista = file_get_contents('templates/lista_autorlivro.html');
    $templatelista = str_replace('{itens}', $itens, $templatelista);
    print($templatelista);
}