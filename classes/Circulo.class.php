<?php
require_once("../classes/Database.class.php");
require_once("../classes/Formas.class.php");
require_once("../classes/Unidade.class.php");

class Circulo extends Formas
{
    private $diametro;

    public function  __construct($id = 0, $diametro = 0, $cor = "black", Unidade $unidade = null, $img = "null" )
    {
        parent:: __construct($id, $cor, $unidade, $img);
        $this->setDiametro($diametro);
    }
    

    public function setDiametro($diametro)
    {
        if ($diametro < 1)
            throw new Exception("Erro, número indefinido");
        else
            $this->diametro = $diametro;
    }

   
    public function getDiametro()
    {
        return $this->diametro;
    }


    public function incluir()
    {
        $sql = 'INSERT INTO circulo (diametro,cor, unidade, imagem)   
                VALUES (:diametro, :cor, :unidade, :imagem)';

        $parametros = array(':diametro' => $this->diametro, 
                            ':cor' => $this->getCor(),
                            ':unidade' => $this->getUnidade()->getId(),
                            ':imagem' => $this->getImg());
        return Database::executar($sql, $parametros);
    }

    public function excluir()
    {
        $conexao = Database::getInstance();
        $sql = 'DELETE FROM circulo WHERE idcirculo = :id';
        $comando = $conexao->prepare($sql);
        $comando->bindValue(':id', $this->getId());
        return $comando->execute();
    }

    public function alterar()
{
    $sql = 'UPDATE circulo
            SET diametro = :diametro, cor = :cor, unidade = :unidade
            WHERE idcirculo = :id';
    $parametros = array(
        ':diametro' => $this->diametro,
        ':cor' => $this->getCor(),
        ':unidade' => $this->getUnidade()->getId(), // Passar o ID da unidade em vez do objeto
        ':id' => $this->getId()
    );
    return Database::executar($sql, $parametros);
}

    public static function listar($tipo = 0, $busca = ""):array
    {
        $sql = "SELECT * FROM circulo";
        if ($tipo > 0) {
            switch ($tipo) {
                case 1:
                    $sql .= " WHERE idcirculo = :busca";
                    break;
                case 2:
                    $sql .= " WHERE diametro LIKE :busca";
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
        $circulos = array();

        while ($forma = $comando->fetch(PDO::FETCH_ASSOC)) {
            $unidade = Unidade :: listar(1,$forma['unidade'])[0]; 
            $circulo = new Circulo($forma['idcirculo'], $forma['diametro'], $forma['cor'], $unidade,  $forma['imagem']);
            array_push($circulos, $circulo);
        }
        return $circulos;
    }


    // fazer desenhar - não feito ainda 
    public function desenharForma()
    {
    //     var_dump($this);
    // die;
        return "<div class = 'container' style= ' background-color:" . $this->getCor() . "; background-image:url(\"{$this->getImg()}\");width:" . $this->getDiametro() . $this->getUnidade()->getUnidade(). "; 
        background-size: contain; height:" . $this->getDiametro() . $this->getUnidade()->getUnidade(). ";  border-radius: 100%; '></div><br> ";
    }

    public function calcularArea(){
        $area = ( 3.1416 * ( $this->getDiametro() / 2 ** 2 )) ;
        return $area;
    }

    public function calcularPerimetro(){
        $perimetro = ( 2 * 3.1416 * ( $this->getDiametro() / 2 )) ;
        return $perimetro;
    }
}
