<?php
require_once("../classes/autoload.php");
require_once("../config/config.inc.php");

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $id = isset($_GET['id']) ? $_GET['id'] : 0;
    $msg = isset($_GET['MSG']) ? $_GET['MSG'] : "";

    $formulario = file_get_contents('templates/form_cadastro_autorlivro.html');
    $autores = Autor::listar();
    $livros = Livro::listar();

    $livroOptions = '';
    $livroSelected = '';

    $autorOptions = '';
    $autorSelected = '';

    if ($id > 0) {
        $autorlivro = AutorLivro::listar(1, $id)[0];
        $autorSelected = $autorlivro->getAutor()->getId();
        $livroSelected = $autorlivro->getLivro()->getId();
        

        $formulario = str_replace('{id}', $autorlivro->getId(), $formulario);
        
        foreach ($autores as $autor) {
            $selected = ($autorSelected == $autor->getId()) ? 'selected' : '';
            $autorOptions .= '<option value="' . $autor->getId() . '" ' . $selected . '>'
                . $autor->getNome() . '</option>';
        }
        $formulario = str_replace('{autor}',  $autorOptions, $formulario);

        foreach ($livros as $livro) {
            $selected = ($livroSelected == $livro->getId()) ? 'selected' : '';
            $livroOptions .= '<option value="' . $livro->getId() . '" ' . $selected . '>'
                . $livro->getTitulo() . '</option>';
        }
        $formulario = str_replace('{livro}',  $livroOptions, $formulario);
      
    } else {
        $formulario  = str_replace('{id}', '0', $formulario);
        foreach ($autores as $autor) {
            $autorOptions .= '<option value="' . $autor->getId() . '" ' . '>'
                . $autor->getNome() . '</option>';
        }
        $formulario  = str_replace('{autor}', $autorOptions, $formulario);

        foreach ($livros as $livro) {
            $livroOptions .= '<option value="' . $livro->getId() . '" ' . '>'
                . $livro->getTitulo() . '</option>';
        }
        $formulario  = str_replace('{livro}', $livroOptions, $formulario);

    }

    print($formulario);
    include "listaautorlivro.php";
} else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = isset($_POST['id']) ? $_POST['id'] : 0;
    $autor = isset($_POST['autor']) ? $_POST['autor'] : "";
    $livro = isset($_POST['livro']) ? $_POST['livro'] : "";
    $acao = isset($_POST['acao']) ? $_POST['acao'] : "";

    try {
        $autor = Autor::listar(1, $autor)[0];
        $livro = Livro::listar(1, $livro)[0];
        $autorlivro = new Autorlivro($id, $autor, $livro);

        $resultado = "";
        switch ($acao) {
            case ("Salvar"):
                $resultado = $autorlivro->incluir();
                break;
            case ("Alterar"):
                $resultado = $autorlivro->alterar();
                break;
            case ("Excluir"):
                $resultado = $autorlivro->excluir();
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
