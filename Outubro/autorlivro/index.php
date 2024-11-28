<?php
require_once('../classes/autoload.php');
require_once('../config/config.inc.php');

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $id = isset($_GET['id']) ? $_GET['id'] : 0;
    $msg = isset($_GET['MSG']) ? $_GET['MSG'] : "";
    $formulario = file_get_contents('templates/form_cadastro_autorli.html');
    $livro = Livro::listar();
    $autor = Autor::listar();

    $opcoesA = '';
    $opcoesL = '';
    $opcaoSelecA = 0;
    $opcaoSelecL = 0;

    if ($id > 0) {
        $autorlivro = AutorLivro::listar(1, $id)[0];
        $opcaoSelecA = $autorlivro->getAutor()->getId();
        $opcaoSelecL = $autorlivro->getLivro()->getId();
        $formulario = str_replace('{id}', $autorlivro->getId(), $formulario);
    }

    foreach ($livro as $li) {
        $selected = ($opcaoSelecL == $li->getId()) ? 'selected' : '';
        $opcoesL .= '<option value="' . $li->getId() . '" ' . $selected . '>'
            . $li->getTitulo() . '</option>';
    }

    foreach ($autor as $au) {
        $selected = ($opcaoSelecA == $au->getId()) ? 'selected' : '';
        $opcoesA .= '<option value="' . $au->getId() . '" ' . $selected . '>'
            . $au->getNome().' '.$au->getLast() . '</option>';
    }

    $formulario = str_replace('{id}', 0, $formulario);
    $formulario = str_replace('{autor}', $opcoesA, $formulario);
    $formulario = str_replace('{livro}', $opcoesL, $formulario);

    print($formulario);
    include "listarautorli.php";
} else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = isset($_POST['id']) ? $_POST['id'] : 0;
    $autor = isset($_POST['autor']) ? $_POST['autor'] : "";
    $livro = isset($_POST['livro']) ? $_POST['livro'] : "";

    $acao = isset($_POST['acao']) ? $_POST['acao'] : 0;

    try {
        $autor = Autor::listar(1,$autor)[0];
        $livro = Livro::listar(1,$livro)[0];
        $autor = new AutorLivro($id, $autor, $livro);
        $resultado = "";
        if ($acao == 'salvar') {
            if ($id > 0) {
                $resultado = $autor->alterar();
            } else {
                $resultado = $autor->incluir();
            }
        } elseif ($acao == 'excluir') {
            $resultado = $autor->excluir();
        }
        var_dump($autor);
        if ($resultado)
            header('Location: index.php');
        else
            echo "erro ao inserir dados!";
    } catch (Exception $e) {

        echo $e;
    }
}
