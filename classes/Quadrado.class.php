<?php
require_once("../classes/Database.class.php");

class Quadrado
{
    private $id;
    private $altura;
    private $cor;
    private $unidade;

    public function  __construct($id = 0, $altura = 1, $cor = "black", Unidade $unidade = null)
    {
        $this->setId($id);
        $this->setAltura($altura);
        $this->setCor($cor);
        $this->setUnidade($unidade);
    }

    public function setId($id)
    {
        if ($id < 0)
            throw new Exception("Erro: id inválido!");
        else
            $this->id = $id;
    }

    public function setAltura($altura)
    {
        if ($altura < 1)
            throw new Exception("Erro, número indefinido");
        else
            $this->altura = $altura;
    }

    public function setCor($cor)
    {
        if ($cor == "")
            throw new Exception("Erro, cor indefinido");
        else
            $this->cor = $cor;
    }

    public function setUnidade($unidade)
    {
        if (!$unidade)
            throw new Exception("Erro, unidade indefinida");
        else
            $this->unidade = $unidade;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAltura()
    {
        return $this->altura;
    }

    public function getCor()
    {
        return $this->cor;
    }

    public function getUnidade()
    {
        return $this->unidade;
    }

    public function incluir()
    {
        $sql = 'INSERT INTO quadrado (lado,cor, unidade)   
                VALUES (:lado, :cor, :unidade)';

        $parametros = array(':lado' => $this->altura, ':cor' => $this->cor, ':unidade' => $this->unidade->getId());
        return Database::executar($sql, $parametros);
    }

    public function excluir()
    {
        $conexao = Database::getInstance();
        $sql = 'DELETE FROM quadrado WHERE idquad = :id';
        $comando = $conexao->prepare($sql);
        $comando->bindValue(':id', $this->id);
        return $comando->execute();
    }

    public function alterar()
{
    $sql = 'UPDATE quadrado
            SET lado = :lado, cor = :cor, unidade = :unidade
            WHERE idquad = :id';
    $parametros = array(
        ':lado' => $this->altura,
        ':cor' => $this->cor,
        ':unidade' => $this->unidade->getId(), // Passar o ID da unidade em vez do objeto
        ':id' => $this->id
    );
    return Database::executar($sql, $parametros);
}

    public static function listar($tipo = 0, $busca = "")
    {
        $sql = "SELECT * FROM quadrado";
        if ($tipo > 0) {
            switch ($tipo) {
                case 1:
                    $sql .= " WHERE idquad = :busca";
                    break;
                case 2:
                    $sql .= " WHERE lado LIKE :busca";
                    $busca = "%{$busca}%";
                    break;
                case 3:
                    $sql .= " WHERE cor LIKE :busca";
                    $busca = "%{$busca}%";
                    break;
                case 4:
                    $sql .= " WHERE unidade LIKE :busca";
                    $busca = "%{$busca}%";
                    break;
            }
        }
        // $comando = $conexao->prepare($sql);
        $parametros = [];
        if ($tipo > 0)
            $parametros = array(':busca' => $busca);

        $comando = Database::executar($sql, $parametros);
        $quadrados = array();

        while ($forma = $comando->fetch(PDO::FETCH_ASSOC)) {
            $unidade = Unidade :: listar(1,$forma['unidade'])[0]; 
            $quadrado = new Quadrado($forma['idquad'], $forma['lado'], $forma['cor'], $unidade);
            array_push($quadrados, $quadrado);
        }
        return $quadrados;
    }

    public function desenharQuadrado($quadrado)
    {
        return "<div class = 'container' style='background-color:" . $quadrado->getCor() . "; width:" . $quadrado->getAltura() . $quadrado->getUnidade()->getUnidade(). "; height:" . $quadrado->getAltura() . $quadrado->getUnidade()->getUnidade(). "'></div><br> ";
    }
}
