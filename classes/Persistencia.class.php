<?php 

abstract class Persistencia{
    private $id;

    public function  __construct($id = 0 )
    {
        $this->setId($id);
    }

    public function setId($id)
    {
        if ($id < 0)
            throw new Exception("Erro: id inválido!");
        else
            $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }

    abstract public function incluir();
    abstract public function excluir();
    abstract public function alterar();
    abstract public static function listar($tipo = 0, $busca = ""):array;
    
    
}