<?php
require_once("../classes/autoload.php");
require_once("../config/config.inc.php");

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $id = isset($_GET['id']) ? $_GET['id'] : 0;
    $msg = isset($_GET['MSG']) ? $_GET['MSG'] : "";

    $formulario = file_get_contents('templates/form_cadastro_livro.html');
    $categorias = Categoria::listar();
    $categoriaOptions = '';
    $categoriaSelected = '';

    if ($id > 0) {
        $livro = Livro::listar(1, $id)[0];
        $categoriaSelected = $livro->getCategoria()->getId();

        $formulario = str_replace('{id}', $livro->getId(), $formulario);
        $formulario = str_replace('{titulo}', $livro->getTitulo(), $formulario);
        $formulario = str_replace('{ano}', $livro->getAno(), $formulario);
        $formulario = str_replace('{foto}', $livro->getFoto(), $formulario);


        foreach ($categorias as $categoria) {
            $selected = ($categoriaSelected == $categoria->getId()) ? 'selected' : '';
            $categoriaOptions .= '<option value="' . $categoria->getId() . '" ' . $selected . '>'
                . $categoria->getCategoria() . '</option>';
        }
        $formulario = str_replace('{categoria}',  $categoriaOptions, $formulario);

        $formulario = str_replace('{preco}', $livro->getPreco(), $formulario);
    } else {
        $formulario  = str_replace('{id}', '0', $formulario);
        $formulario  = str_replace('{titulo}', '', $formulario);
        $formulario  = str_replace('{ano}', '', $formulario);
        $formulario  = str_replace('{foto}', '', $formulario);
        foreach ($categorias as $categoria) {
            $categoriaOptions .= '<option value="' . $categoria->getId() . '" ' . '>'
                . $categoria->getCategoria() . '</option>';
        }
        $formulario  = str_replace('{categoria}', $categoriaOptions, $formulario);
        $formulario  = str_replace('{preco}', '', $formulario);
    }

    print($formulario);
    include "listalivros.php";
} else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = isset($_POST['id']) ? $_POST['id'] : 0;
    $titulo = isset($_POST['titulo']) ? $_POST['titulo'] : "";
    $ano = isset($_POST['ano']) ? $_POST['ano'] : "";
    $foto = isset($_FILES['foto']) ? $_FILES['foto'] : "";
    $categoria = isset($_POST['categoria']) ? $_POST['categoria'] : 0;
    $preco = isset($_POST['preco']) ? $_POST['preco'] : "";
    $acao = isset($_POST['acao']) ? $_POST['acao'] : "";
    $destino = '../img/' . $foto['name'];

    try {
        $categoria = Categoria::listar(1, $categoria)[0];
        $livro = new Livro($id, $titulo, $ano, $destino, $categoria, $preco);


        $resultado = "";
        switch ($acao) {
            case ("Salvar"):
                $resultado = $livro->incluir();
                break;
            case ("Alterar"):
                $resultado = $livro->alterar();
                break;
            case ("Excluir"):
                $resultado = $livro->excluir();
                break;
        }
        move_uploaded_file($foto['tmp_name'],$destino);
        if ($resultado)
            header('Location: index.php');
        else
            echo "erro ao inserir dados!";
    } catch (Exception $e) {
        header('Location:index.php?MSG=ERROR:' . $e->getMessage());
    }
}
