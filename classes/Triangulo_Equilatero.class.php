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
        $sql = 'INSERT INTO triangulo (lado1, lado2, lado3, cor, imagem, unidade, tipo)   
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
        SET lado1 = :lado1, lado2 = :lado2, lado3 = :lado3 , cor = :cor, unidade = :unidade, tipo = :tipo
        WHERE idtriangulo = :id';
        $parametros = array(
            ':lado1' => $this->getLado1(),
            ':lado2' => $this->getLado2(),
            ':lado3' => $this->getLado3(),
            ':cor' => $this->getCor(),
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

    public function desenharForma()
    {
        $lado = $this->getLado1(); // Lados iguais
        $base = $this->getLado3(); // Base
    
        return "
        <a href='index.php?idTriangulo=" . $this->getId() . "'>
            <div style='position: relative; display: inline-block;'>
                <div style='
                    width: 0;
                    height: 0;
                    border-left: " . $lado . $this->getUnidade()->getUnidade() . " solid transparent;
                    border-right: " . $lado . $this->getUnidade()->getUnidade(). " solid transparent;
                    border-bottom: " . $base . $this->getUnidade()->getUnidade() ." solid " . $this->getCor() . ";
                    position: relative;
                '>
                    <div style='
                        position: absolute;
                        top: 0;
                        left: 50%;
                        transform: translateX(-50%);
                        width: " . (2 * $lado) .  $this->getUnidade()->getUnidade() . ";

                        height: " . $base . $this->getUnidade()->getUnidade(). ";
                        background-image: url(" . '"' . $this->getImg() . '"' . ");
                        background-size: cover;
                        background-repeat: no-repeat;
                        background-position: center;
                        clip-path: polygon(50% 0%, 0% 100%, 100% 100%);
                        pointer-events: none;
                    '></div>
                </div>
            </div>
        </a>
        <br>";
    }
}
