<?php
require_once("../classes/autoload.php");

class Quadrado extends Formas
{
   
    private $lado;
   

    public function  __construct($id = 0, $lado = 1, $cor = "black", Unidade $unidade = null, $img = "null" )
    {
        parent:: __construct($id, $cor, $unidade, $img);
        $this->setLado($lado);
    
    }

    public function setLado($lado)
    {
        if ($lado < 1)
            throw new Exception("Erro, número indefinido");
        else
            $this->lado = $lado;
    }

   
    public function getLado()
    {
        return $this->lado;
    }


    public function incluir()
    {
        $sql = 'INSERT INTO quadrado (lado,cor, unidade, imagem)   
                VALUES (:lado, :cor, :unidade, :imagem)';

        $parametros = array(':lado' => $this->lado, 
                            ':cor' => $this->getCor(),
                            ':unidade' => $this->getUnidade()->getId(),
                            ':imagem' => $this->getImg());
        return Database::executar($sql, $parametros);
    }

    public function excluir()
    {
        $conexao = Database::getInstance();
        $sql = 'DELETE FROM quadrado WHERE idquad = :id';
        $comando = $conexao->prepare($sql);
        $comando->bindValue(':id', $this->getId());
        return $comando->execute();
    }

    public function alterar()
{
    $sql = 'UPDATE quadrado
            SET lado = :lado, cor = :cor, unidade = :unidade
            WHERE idquad = :id';
    $parametros = array(
        ':lado' => $this->lado,
        ':cor' => $this->getCor(),
        ':unidade' => $this->getUnidade()->getId(), // Passar o ID da unidade em vez do objeto
        ':id' => $this->getId()
    );
    return Database::executar($sql, $parametros);
}

    public static function listar($tipo = 0, $busca = ""):array
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
            $quadrado = new Quadrado($forma['idquad'], $forma['lado'], $forma['cor'], $unidade,  $forma['imagem']);
            array_push($quadrados, $quadrado);
        }
        return $quadrados;
    }

    public function desenharForma()
    {
    //     var_dump($this);
    // die;
        return "<div class = 'container' style= ' background-color:" . $this->getCor() . "; 
        background-image:url(\"{$this->getImg()}\");width:" . $this->getLado() . $this->getUnidade()->getUnidade(). "; 
        background-size: contain; height:" . $this->getLado() . $this->getUnidade()->getUnidade(). "'></div><br>";
    }

    public function calcularArea(){
        $area = $this->getLado() ** 2;
        return $area;
    }

    public function calcularPerimetro(){
        $perimetro = $this->getLado() * 4;
        return $perimetro;
    }

}
