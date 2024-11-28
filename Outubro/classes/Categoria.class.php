<?php
require_once('../classes/autoload.php');
class Categoria extends Persistencia
{
    private $descricao;

    public function  __construct($id = 0, $descricao = "")

    {
        parent::__construct($id);
        $this->setDescricao($descricao);
       
    }

    // ====================== Seter's ======================== //


    public function setDescricao($descricao)
    {
        if ($descricao === "")
            throw new Exception("Erro: descricao inválido!");
        else
            $this->descricao = $descricao;
    }

    // ====================== Geter's ======================== //


    public function getDescricao()
    {
        return $this->descricao;
    }

    // ====================== DBFunctions ======================== //


    public function incluir()
    {
        $sql = 'INSERT INTO categorias (descricao)   
        VALUES (:descricao)';

        $parametros = array(
            ':descricao' => $this->getDescricao(),
        );

        return Database::executar($sql, $parametros);
    }

    public function alterar()
    {
        $sql = 'UPDATE categorias 
        SET descricao = :descricao   
      WHERE id = :id';
        $parametros = array(
            ':id' => parent::getId(),
            ':descricao' => $this->getDescricao(),
        );
        Database::executar($sql, $parametros);
        return true;
    }

    public function excluir()
    {
        $sql = 'DELETE 
                  FROM categorias
                 WHERE id = :id';
        $parametros = array(':id' => parent::getId());
        return Database::executar($sql, $parametros);
    }

    public static function listar($tipo = 0, $busca = ""): array
    {
        $sql = "SELECT * FROM categorias";
        if ($tipo > 0)
            switch ($tipo) {
                case 1:
                    $sql .= " WHERE id = :busca";
                    break;
                case 2:
                    $sql .= " WHERE nome like :busca";
                    $busca = "%{$busca}%";
                    break;
                case 3:
                    $sql .= " WHERE email like :busca";
                    $busca = "%{$busca}%";
                    break;
            }
        $parametros = array();
        if ($tipo > 0)
            $parametros = array(':busca' => $busca);
        $comando = Database::executar($sql, $parametros);
        $formas = array();
        while ($registro = $comando->fetch(PDO::FETCH_ASSOC)) {
            $quadrado = new Categoria($registro['id'], $registro['descricao']);
            array_push($formas, $quadrado);
        }
        return $formas;
    }

    public function Login() {}
}
