<?php 
require_once("../classes/Formas.class.php");


abstract class Triangulo extends Formas{
    private $lado1;
    private $lado2;
    private $lado3;

    public function  __construct($id = 0, $cor = "black", Unidade $unidade = null, $img = "null", $lado1 = 0, $lado2 = 0, $lado3 = 0)
    {
        parent:: __construct($id, $cor, $unidade, $img);
        $this->setLado1($lado1);
        $this->setLado2($lado2);
        $this->setLado3($lado3);
    }

    public function setLado1($lado1)
    {
        if ($lado1 < 0)
            throw new Exception("Erro: lado1 invállado1o!");
        else
            $this->lado1 = $lado1;
    }

    public function setLado2($lado2)
    {
        if ($lado2 < 0)
            throw new Exception("Erro: lado2 invállado2o!");
        else
            $this->lado2 = $lado2;
    }

    public function setLado3($lado3)
    {
        if ($lado3 < 0)
            throw new Exception("Erro: lado3 invállado3o!");
        else
            $this->lado3 = $lado3;
    }

    public function getLado1()
    {
        return $this->lado1;
    }

    public function getLado2()
    {
        return $this->lado2;
    }

    public function getLado3()
    {
        return $this->lado3;
    }

    abstract public function incluir();
    abstract public function excluir();
    abstract public function alterar();
    abstract public function calcularArea();
    abstract public function calcularPerimetro();

    public static function listar($tipo = 0, $busca = ""):array{
        $sql = "SELECT * FROM triangulo";
        if ($tipo > 0) {
            switch ($tipo) {
                case 1:
                    $sql .= " WHERE idtriangulo = :busca";
                    break;
                case 2:
                    $sql .= " WHERE cor LIKE :busca";
                    $busca = "%{$busca}%";
                    break;
                case 3:
                    $sql .= " WHERE unidade LIKE :busca";
                    $busca = "%{$busca}%";
                    break;
                case 4:
                    $sql .= " WHERE tipo LIKE :busca";
                    $busca = "%{$busca}%";
                    break;
            }
        }
        // $comando = $conexao->prepare($sql);
        $parametros = [];
        if ($tipo > 0)
            $parametros = array(':busca' => $busca);

        $comando = Database::executar($sql, $parametros);
        $triangulos = array();

        while ($forma = $comando->fetch(PDO::FETCH_ASSOC)) {
            $unidade = Unidade :: listar(1,$forma['unidade'])[0]; 
            
            if($forma['lado1'] == $forma['lado2'] && $forma['lado2'] == $forma['lado3']){
                $triangulo = new TrianguloEquilatero($forma['idtriangulo'], $forma['lado1'], $forma['lado2'], $forma['lado3'], $forma['cor'], $unidade, $forma['imagem'], $forma['tipo']);
            }elseif(($forma['lado1'] == $forma['lado2'] && $forma['lado2'] != $forma['lado3']) || ($forma['lado2'] == $forma['lado3'] && $forma['lado3'] != $forma['lado1']) || ($forma['lado1'] == $forma['lado3'] && $forma['lado3'] != $forma['lado2'])){
                $triangulo = new TrianguloIsosceles($forma['idtriangulo'], $forma['lado1'], $forma['lado2'], $forma['lado3'], $forma['cor'], $unidade, $forma['imagem'], $forma['tipo']);
            } elseif($forma['lado1'] != $forma['lado2'] && $forma['lado1'] != $forma['lado3'] && $forma['lado2'] != $forma['lado3']){
                $triangulo = new TrianguloEscaleno($forma['idtriangulo'], $forma['lado1'], $forma['lado2'], $forma['lado3'], $forma['cor'], $unidade, $forma['imagem'], $forma['tipo']);
            } 

            array_push($triangulos, $triangulo);
        }
       return $triangulos;
    }

    public function desenharForma()
    {
    
        return "<a href='index.php?idTriangulo=" . $this->getId() . "'>
            <div style='
                width: 0;
                height: 0;
                border-left: " . $this->getLado1() . $this->getUnidade()->getTipo() . " solid transparent;
                border-right: " . $this->getLado2() . $this->getUnidade()->getTipo() . " solid transparent;
                border-bottom: " . $this->getLado3() . $this->getUnidade()->getTipo() . " solid " . $this->getCor() . ";
                background-image:url(" . '"' . $this->getImg() . '"' . ");
                background-size: cover;
                background-repeat: no-repeat;
                background-position: center;
            '> </div>
            </a>";
    }

}