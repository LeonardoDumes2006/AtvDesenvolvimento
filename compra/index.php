<?php
require_once('../classes/autoload.php');
require_once('../config/config.inc.php');

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $check = isset($_GET['comprar']) ? $_GET['comprar'] : "";
    $acao = isset($_GET['acao']) ? $_GET['acao'] : "";

    $id = isset($_GET['id']) ? $_GET['id'] : 0;
    $msg = isset($_GET['MSG']) ? $_GET['MSG'] : "";
    $formulario = file_get_contents('templates/form_cadastro_compra.html');
    if ($check) {
        echo "<form method='post'>";
        echo "<table>";
        echo "<tr><th>Id</th><th>Titulo</th><th>Publicação</th><th>Capa</th><th>Categoria</th><th>Preço</th><th>Quantia</th></tr>";

        foreach ($check as $c) {
            $livro = Livro::listar(1, $c)[0];
            echo "<div>";
            echo "<tr>";
            echo "<td><input type='text' name='idLivro[]' readonly value='" . $livro->getId() . "'> </td>";
            echo "<td><input type='text' name='titulo[]' readonly value='" . $livro->getTitulo() . "'></td>";
            echo "<td><input type='text' name='ano[]' readonly value='" . $livro->getAno() . "'></td>";
            echo "<td><input type='text' name='foto[]' readonly value='" . $livro->getFoto() . "'></td>";
            echo "<td><input type='text' name='descricao[]' readonly value='" . $livro->getCategoria()->getDescricao() . "'></td>";
            echo "<td><input type='text' name='preco[]' readonly value='" . $livro->getPreco() . "'></td>";
            echo "<td><input type='number' name='quantidade[]' value ='1'></td>";
            echo "</tr>";
            echo "</div>";
        }

        echo "</table>";
        echo "<input type='submit' name='acao' id='acao' value='Comprar'>";
        echo "</form>";
        print($formulario); 
    }

    if ($acao == 'excluir') {
        if ($id) {
            $compras = Compra::listar(1, $id)[0];
            if (!empty($compras)) {
                $resultado = $compras->excluir();
            }
        }
    }

    include "listacompra.php";
} else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = isset($_POST['id']) ? $_POST['id'] : 0;

    $quantiadades = isset($_POST['quantia']) ? $_POST['quantia'] : 1;
    $livros = isset($_POST['idLivro']) ? $_POST['idLivro'] : 1;

    $acao = isset($_POST['acao']) ? $_POST['acao'] : 0;

    date_default_timezone_set('America/Sao_Paulo');
    $dataAtual = new DateTime();
    $data = $dataAtual->format('Y-m-d H:i:s');
    $compra = new Compra($id, $data, 0.0);

    $resultado = "";
    $resultado = $compra->incluir();
    if ($resultado) {
        $idCompra = Database::$lastId;
        $valorTot = 0;
        foreach ($livros as $chave => $livro) {

            $quantia = $quantiadades[$chave];

            $livro = Livro::listar(1, $livro)[0];

            $valorTot += $livro->getPreco() * $quantia;
            $valorTotItem = $livro->getPreco() * $quantia;
            $compras = Compra::listar(1, $idCompra)[0];
            $itens = new Itenscompra(0, $livro, $compras, $quantia, $valorTotItem);
            if ($acao == 'Comprar') {
                $resultado = $itens->incluir();
            }
        }

        $compra = new Compra($idCompra, $data, $valortotal);
        $resultado = $compra->alterar();
    } else
        echo "Deu ruim visse";

    try {
        if ($resultado)
            header('Location: index.php');
        else
            echo "erro ao inserir dados!";
    } catch (Exception $e) {

        echo $e;
    }
}
