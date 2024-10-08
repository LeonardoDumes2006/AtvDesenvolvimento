<?php
require_once("../classes/Triangulo.class.php");
require_once("../classes/Triangulo_Equilatero.class.php");   
require_once("../classes/Triangulo_Escaleno.class.php");
require_once("../classes/Triangulo_Isosceles.class.php");
require_once("../classes/Unidade.class.php");
require_once("../classes/Database.class.php");

$id = isset($_GET['idTriangulo']) ? $_GET['idTriangulo'] : 0;
$msg = isset($_GET['MSG']) ? $_GET['MSG'] : "";
if ($id > 0) {
    $triangulo = Triangulo::listar(1, $id)[0];
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = isset($_POST['id']) ? $_POST['id'] : 0;
    $lado1 = isset($_POST['lado1']) ? $_POST['lado1'] : 0;
    $lado2 = isset($_POST['lado2']) ? $_POST['lado2'] : 0;
    $lado3 = isset($_POST['lado3']) ? $_POST['lado3'] : 0;
    $cor = isset($_POST['cor']) ? $_POST['cor'] : "";
    $unidade = isset($_POST['unidade']) ? $_POST['unidade'] : "";
    $arquivo = isset($_FILES['img']) ? $_FILES['img'] : "";
    $acao = isset($_POST['acao']) ? $_POST['acao'] : 0;
    $destino = "../".IMG."/".$arquivo['name'];
    $tipo = isset($_POST['tipo']) ? $_POST['tipo'] : '';

    try {
        $uni = Unidade::listar(1, $unidade)[0];
        $validacao = VerificaTriangulo($lado1, $lado2, $lado3, $tipo);
        
        if($validacao == "equi"){
            $triangulo = new TrianguloEquilatero($id,  $cor, $uni,$destino, $lado1, $lado2, $lado3);
        }
        else  if($validacao == "iso"){
            $triangulo = new TrianguloIsosceles($id,  $cor, $uni,$destino, $lado1, $lado2, $lado3);
        }
        else  if($validacao == "esca"){
            $triangulo = new TrianguloEscaleno($id,  $cor, $uni,$destino, $lado1, $lado2, $lado3);
        }
        if($validacao != $tipo){
            throw new Exception("Formato informado inválido");
        }

        if (!podeFormarTriangulo($lado1, $lado2, $lado3)) {
            throw new Exception("Não Pode formar um triângulo!");
        } 

        if (!$triangulo->verificaAngulo()) {
            throw new Exception("A soma dos ângulos não é igual a 180º. Verifique os valores.");
        }
       
            $resultado = "";
            switch ($acao) {
                case ("Salvar"):
                    $resultado = $triangulo->incluir();
                    break;
                case ("Alterar"):
                    $resultado = $triangulo->alterar();
                    break;
                case ("Excluir"):
                    $resultado = $triangulo->excluir();
                    break;
            }

            if ($resultado)
                 header('Location: index.php');
            else
            echo "erro ao inserir dados!";
        
        
        
        $_SESSION['IMG'] = "Dados Inseridos com sucesso!!";
        move_uploaded_file($arquivo['tmp_name'],$destino);
        
    } catch (Exception $e) {
        
        header('Location:index.php' . $e->getMessage());
    }   
} else if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $busca = isset($_GET['busca']) ? $_GET['busca'] : "";
    $tipo = isset($_GET['tipo']) ? $_GET['tipo'] : 0;
    
    $lista = Triangulo::listar($tipo, $busca);  
}

function VerificaTriangulo($lado1, $lado2, $lado3, $tipo){  

    if($lado1 == $lado2 && $lado2 == $lado3){
        $tipoTri =  "equi";
    }
    else if ($lado1 == $lado2 || $lado1 == $lado3 || $lado2 == $lado3 ){
        $tipoTri =  "iso";
    }
    else 
    $tipoTri =  "esca";
    
    if($tipoTri == $tipo){
        return $tipoTri;
    }
    else 
    return "Formato informado Invalidado";
}

function podeFormarTriangulo($lado1, $lado2, $lado3){
    if (($lado1 + $lado2 > $lado3) && ($lado1 + $lado3 > $lado2) && ($lado2 + $lado3 > $lado1)) {
        return true;  // Pode formar o triângulo
    } else {
        return false;  // Não pode formar o triângulo
    }
}

