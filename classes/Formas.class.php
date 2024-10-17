<?php 

abstract class Formas{
    private $id;
    private $cor;
    private $unidade;
    private $img;

    public function  __construct($id = 0, $cor = "black", Unidade $unidade = null, $img = "null" )
    {
        $this->setId($id);
        $this->setCor($cor);
        $this->setUnidade($unidade);
        $this->setImg($img);
    }

    public function setId($id)
    {
        if ($id < 0)
            throw new Exception("Erro: id inválido!");
        else
            $this->id = $id;
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

    public function setImg($img)
    {
        if ($img == 'null')
            throw new Exception("Erro, img indefinida");
        else 
            $this->img = $img;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getCor()
    {
        return $this->cor;
    }

    public function getUnidade()
    {
        return $this->unidade;
    }

    public function getImg()
    {
        return $this->img;
    }
    

    abstract public function incluir();
    abstract public function excluir();
    abstract public function alterar();
    abstract public static function listar($tipo = 0, $busca = ""):array;
    abstract public function desenharForma();
    abstract public function calcularArea();
    abstract public function calcularPerimetro();

    
    
}