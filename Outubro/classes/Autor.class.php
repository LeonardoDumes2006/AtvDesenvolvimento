<?php
require_once('../classes/autoload.php');
class Autor extends Persistencia
{
    private $nome;
    private $lsname;

    public function  __construct($id = 0, $nome = "", $lsname = "null")

    {
        parent::__construct($id);
        $this->setNome($nome);
        $this->setLast($lsname);
    }

    // ====================== Seter's ======================== //


    public function setNome($nome)
    {
        if ($nome === "")
            throw new Exception("Erro: nome inválido!");
        else
            $this->nome = $nome;
    }

    public function setLast($lsname)
    {
        if ($lsname === "")
            throw new Exception("Erro:Sobrenome inválido!");
        else
            $this->lsname = $lsname;
    }


    // ====================== Geter's ======================== //


    public function getNome()
    {
        return $this->nome;
    }
    public function getLast()
    {
        return $this->lsname;
    }

    // ====================== DBFunctions ======================== //


    public function incluir()
    {
        $sql = 'INSERT INTO autors (nome, sobrenome)   
        VALUES (:nome, :sobrenome)';

        $parametros = array(
            ':nome' => $this->getNome(),
            ':sobrenome' => $this->getLast(),
        );

        return Database::executar($sql, $parametros);
    }

    public function alterar()
    {
        $sql = 'UPDATE autors 
        SET nome = :nome, sobrenome = :sobrenome
      WHERE id = :id';
        $parametros = array(
            ':id' => parent::getId(),
            ':nome' => $this->getNome(),
            ':sobrenome' => $this->getLast(),
        );
        Database::executar($sql, $parametros);
        return true;
    }

    public function excluir()
    {
        $sql = 'DELETE 
                  FROM autors
                 WHERE id = :id';
        $parametros = array(':id' => parent::getId());
        return Database::executar($sql, $parametros);
    }

    public static function listar($tipo = 0, $busca = ""): array
    {
        $sql = "SELECT * FROM autors";
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
            $quadrado = new Autor($registro['id'], $registro['nome'], $registro['sobrenome']);
            array_push($formas, $quadrado);
        }
        return $formas;
    }

    public function Login() {}
}
