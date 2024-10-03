<?php
require_once("../classes/Database.class.php");
require_once("../classes/Formas.class.php");
require_once("../classes/Triangulo.class.php");
require_once("../classes/Unidade.class.php");

class TrianguloEquilatero extends Triangulo
{

    public function  __construct($id = 0, $cor = "black", Unidade $unidade = null, $img = "null", $lado1 = 0, $lado2 = 0, $lado3 = 0)
    {
        parent::__construct($id,  $cor, $unidade, $img, $lado1, $lado2, $lado3);
    }


    public function incluir()
    {
        $sql = 'INSERT INTO triangulo (lado1, lado2, lado3,cor, imagem, unidade, tipo)   
                VALUES (:lado1, :lado2, :lado3, :cor, :imagem , :unidade, :tipo )';

        $parametros = array(
            ':lado1' => $this->getLado1(),
            ':lado2' => $this->getLado2(),
            ':lado3' => $this->getLado3(),
            ':cor' => $this->getCor(),
            ':imagem' => $this->getImg(),
            ':unidade' => $this->getUnidade()->getId(),
            ':tipo' => Equilatero
        );

        return Database::executar($sql, $parametros);
    }
    public function excluir()
    {
        $conexao = Database::getInstance();
        $sql = 'DELETE FROM triangulo WHERE idtriangulo = :id';
        $comando = $conexao->prepare($sql);
        $comando->bindValue(':id', $this->getId());
        return $comando->execute();
    }
    public function alterar()
    {
        $sql = 'UPDATE triangulo
        SET lado1 = :lado1, lado2 = :lado2, lado3 = :lado3 , cor = :cor, unidade = :unidade
        WHERE idtriangulo = :id';
        $parametros = array(
            ':lado1' => $this->getLado1(),
            ':lado2' => $this->getLado2(),
            ':lado3' => $this->getLado3(),
            ':cor' => $this->getCor(),
            ':imagem' => $this->getImg(),
            ':unidade' => $this->getUnidade()->getId(),
            ':tipo' => Equilatero,
            ':id' => $this->getId()
        );
        return Database::executar($sql, $parametros);
    }
    public function calcularArea()
    {
        $area = ($this->getLado1() ** 2 * sqrt(3)) / 4;
        return $area;
    }
    public function calcularPerimetro()
    {
        $perimetro = $this->getLado1() * 3;
        return $perimetro;
    }
    public function desenharForma() {

    }
}
