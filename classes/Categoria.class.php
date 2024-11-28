<?php
require_once("../classes/autoload.php");

class Categoria extends Persistencia
{
    private $categoria;

    public function  __construct($id = 0, $categoria = "")
    {
        parent::__construct($id);
        $this->setCategoria($categoria);
    }

    public function setCategoria($categoria)
    {
        if ($categoria == "")
            throw new Exception("Erro, número indefincate");
        else
            $this->categoria = $categoria;
    }

    public function getCategoria()
    {
        return $this->categoria;
    }

    public function incluir()
    {
        $sql = 'INSERT INTO categoria (descricao)   
                VALUES (:descricao)';

        $parametros = array(
            ':descricao' => $this->getCategoria(),
        );

        return Database::executar($sql, $parametros);
    }

    public function excluir()
    {
        $conexao = Database::getInstance();
        $sql = 'DELETE FROM categoria WHERE idcategoria = :id';
        $comando = $conexao->prepare($sql);
        $comando->bindValue(':id', $this->getId());
        return $comando->execute();
    }

    public function alterar()
    {
        $sql = 'UPDATE categoria
            SET descricao = :descricao
            WHERE idcategoria = :id';
        $parametros = array(
            ':descricao' => $this->getCategoria(),
            ':id' => $this->getId()
        );
        return Database::executar($sql, $parametros);
    }

    public static function listar($tipo = 0, $busca = ""): array
    {
        $sql = "SELECT * FROM categoria";
        if ($tipo > 0) {
            switch ($tipo) {
                case 1:
                    $sql .= " WHERE idcategoria = :busca";
                    break;
                case 2:
                    $sql .= " WHERE descricao LIKE :busca";
                    $busca = "%{$busca}%";
                    break;
            }
        }
        // $comando = $conexao->prepare($sql);
        $parametros = [];
        if ($tipo > 0)
            $parametros = array(':busca' => $busca);

        $comando = Database::executar($sql, $parametros);
        $categorias = array();

        while ($forma = $comando->fetch(PDO::FETCH_ASSOC)) {
            $categoria = new Categoria($forma['idcategoria'], $forma['descricao']);
            array_push($categorias, $categoria);
        }
        return $categorias;
    }
}
