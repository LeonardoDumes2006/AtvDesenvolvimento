<?php
abstract class Persistencia
{
    private $id;

    public function  __construct($id = 0)

    {
        $this->setId($id);
    }

    // ====================== Seter's ======================== //


    public function setId($id)
    {
        if ($id === "")
            throw new Exception("Erro: id inválido!");
        else
            $this->id = $id;
    }

    // ====================== Geter's ======================== //


    public function getId()
    {
        return $this->id;
    }

    // ====================== DBFunctions ======================== //


    abstract public function incluir();

     abstract public function alterar();

    abstract public function excluir();

    abstract public static function listar($tipo=0, $busca=""): array;
}