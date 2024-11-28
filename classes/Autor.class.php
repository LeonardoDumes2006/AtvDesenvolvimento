<?php
require_once("../classes/autoload.php");

class Autor extends Persistencia
{
    private $nome;
    private $sobrenome;

    public function  __construct($id = 0, $nome = "", $sobrenome = "")
    {
        parent::__construct($id);
        $this->setNome($nome);
        $this->setSobrenome($sobrenome);
    }

    public function setNome($nome)
    {
        if ($nome == "")
            throw new Exception("Erro, número indefinnomeo");
        else
            $this->nome = $nome;
    }

    public function setSobrenome($sobrenome)
    {
        if ($sobrenome == "")
            throw new Exception("Erro, número indefinsobrenomeo");
        else
            $this->sobrenome = $sobrenome;
    }


    public function getNome()
    {
        return $this->nome;
    }

    public function getSobrenome()
    {
        return $this->sobrenome;
    }


    public function incluir()
    {
        $sql = 'INSERT INTO autor (nome,sobrenome)   
                VALUES (:nome, :sobrenome)';

        $parametros = array(
            ':nome' => $this->getNome(),
            ':sobrenome' => $this->getSobrenome()
        );

        return Database::executar($sql, $parametros);
    }

    public function excluir()
    {
        try {
            $conexao = Database::getInstance();
            $sql = 'DELETE FROM autor WHERE idautor = :id';
            $comando = $conexao->prepare($sql);
            $comando->bindValue(':id', $this->getId());
            if ($comando->execute()) {
                return true; // Exclusão bem-sucedida
            } else {
                throw new Exception("Erro ao executar a exclusão.");
            }
        } catch (Exception $e) {
            echo "Erro: " . $e->getMessage(); // Exibir mensagem de erro
            return false; // Exclusão falhou
        }
    }

    public function alterar()
    {
        $sql = 'UPDATE autor
            SET nome = :nome, sobrenome = :sobrenome
            WHERE idautor = :id';
        $parametros = array(
            ':nome' => $this->getNome(),
            ':sobrenome' => $this->getSobrenome(),
            ':id' => $this->getId()
        );
        return Database::executar($sql, $parametros);
    }

    public static function listar($tipo = 0, $busca = ""): array
    {
        $sql = "SELECT * FROM autor";
        if ($tipo > 0) {
            switch ($tipo) {
                case 1:
                    $sql .= " WHERE idautor = :busca";
                    break;
                case 2:
                    $sql .= " WHERE nome LIKE :busca";
                    $busca = "%{$busca}%";
                    break;
                case 3:
                    $sql .= " WHERE sobrenome LIKE :busca";
                    $busca = "%{$busca}%";
                    break;
            }
        }
        // $comando = $conexao->prepare($sql);
        $parametros = [];
        if ($tipo > 0)
            $parametros = array(':busca' => $busca);

        $comando = Database::executar($sql, $parametros);
        $autores = array();

        while ($forma = $comando->fetch(PDO::FETCH_ASSOC)) {
            $autor = new Autor($forma['idautor'], $forma['nome'], $forma['sobrenome']);
            array_push($autores, $autor);
        }
        return $autores;
    }
}
