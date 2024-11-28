<?php
require_once('../classes/autoload.php');
require_once('../config/config.inc.php');
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $id = isset($_GET['id']) ? $_GET['id'] : 0;
    $msg = isset($_GET['MSG']) ? $_GET['MSG'] : "";
    $formulario = file_get_contents('templates/form_cadastro_livro.html');
    $cat = Categoria::listar();

    $categoriaOptions = '';
    $categoriaSelected = 0;

    if ($id > 0) {
        $autor = Livro::listar(1, $id)[0];
        $categoriaSelected = $autor->getCategoria()->getId();

        $formulario = str_replace('{id}', $autor->getId(), $formulario);
        $formulario = str_replace('{titulo}', $autor->getTitulo(), $formulario);
        $formulario = str_replace('{pub}', $autor->getPub(), $formulario);
        $formulario = str_replace('{capa}', $autor->getCape(), $formulario);
        $formulario = str_replace('{preco}', $autor->getPreco(), $formulario);
    }

    foreach ($cat as $categoria) {
        $selected = ($categoriaSelected == $categoria->getId()) ? 'selected' : '';
        $categoriaOptions .= '<option value="' . $categoria->getId() . '" ' . $selected . '>'
            . $categoria->getDescricao() . '</option>';
    }

    $formulario = str_replace('{id}', 0, $formulario);
    $formulario = str_replace('{titulo}', '', $formulario);
    $formulario = str_replace('{pub}', '', $formulario);
    $formulario = str_replace('{capa}', '', $formulario);
    $formulario = str_replace('{categoria}', $categoriaOptions, $formulario);
    $formulario = str_replace('{preco}', '', $formulario);


    print($formulario);
    include "listarlivro.php";
} else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = isset($_POST['id']) ? $_POST['id'] : 0;
    $titulo = isset($_POST['titulo']) ? $_POST['titulo'] : "";
    $pub = isset($_POST['pub']) ? $_POST['pub'] : "";
    $capa = isset($_POST['capa']) ? $_POST['capa'] : "";
    $categoria = isset($_POST['categoria']) ? $_POST['categoria'] : "";
    $preco = isset($_POST['preco']) ? $_POST['preco'] : "";
    $acao = isset($_POST['acao']) ? $_POST['acao'] : 0;

    try {
        $categoria = Categoria::listar(1, $categoria)[0];
        $livro = new Livro($id, $titulo, $pub, $capa, $categoria, $preco);
        $resultado = "";
        
        if ($acao == 'salvar') {
            if ($id > 0) {
                $resultado = $livro->alterar();
            } else {
                $resultado = $livro->incluir();
            }
        } elseif ($acao == 'excluir') {
            $resultado = $livro->excluir();
        }
        var_dump($livro);
        if ($resultado)
            header('Location: index.php');
        else
            echo "erro ao inserir dados!";
    } catch (Exception $e) {

        echo $e;
    }
}
