<?php
require_once("../classes/autoload.php");

class Cliente extends Usuario
{
    private $cpf;

    public function  __construct($id = 0, $nome = "", $email = "", $senha = "", $permissao = "", $cpf = "")
    {
        parent::__construct($id, $nome, $email, $senha, $permissao);

        $this->setCpf($cpf);
    }

    public function setCpf($cpf)
    {
        $this->cpf = $cpf;
    }


    public function getCpf()
    {
        return $this->cpf;
    }


    public function incluir()
    {
        $sql = 'INSERT INTO usuario (nome,email, senha, permissao, cpf) 
        VALUES (:nome, :email, :senha, :permissao, :cpf) ';

        $parametros = array(
            ':nome' => $this->getNome(),
            ':email' => $this->getEmail(),
            ':senha' => $this->getSenha(),
            ':permissao' => $this->getPermissao(),
            'cpf' => $this->getCpf()
        );

        return Database::executar($sql, $parametros);
    }

    public function excluir()
    {
        $conexao = Database::getInstance();
        $sql = 'DELETE FROM usuario WHERE idusuario = :id';
        $comando = $conexao->prepare($sql);
        $comando->bindValue(':id', $this->getId());
        return $comando->execute();
    }

    public function alterar()
    {
        $sql = 'UPDATE usuario
            SET nome = :nome, email = :email, senha = :senha, permissao = :permissao, cpf = :cpf
            WHERE idquad = :id';
        $parametros = array(
            ':nome' => $this->getNome(),
            ':email' => $this->getEmail(),
            ':senha' => $this->getSenha(), // Passar o ID da unidade em vez do objeto
            ':permissao' => $this->getPermissao(),
            ':cpf' => $this->getCpf(),
            ':id' => $this->getId()
        );
        return Database::executar($sql, $parametros);
    }

    public static function listar($tipo = 0, $busca = ""): array
    {
        $sql = "SELECT * FROM usuario";
        if ($tipo > 0) {
            switch ($tipo) {
                case 1:
                    $sql .= " WHERE idusuario = :busca";
                    break;
                case 2:
                    $sql .= " WHERE nome LIKE :busca";
                    $busca = "%{$busca}%";
                    break;
                case 3:
                    $sql .= " WHERE email LIKE :busca";
                    $busca = "%{$busca}%";
                    break;
                case 4:
                    $sql .= " WHERE senha LIKE :busca";
                    $busca = "%{$busca}%";
                    break;
                case 5:
                    $sql .= " WHERE permissao LIKE :busca";
                    $busca = "%{$busca}%";
                    break;
                case 6:
                    $sql .= " WHERE cpf LIKE :busca";
                    $busca = "%{$busca}%";
                    break;
            }
        }
        // $comando = $conexao->prepare($sql);
        $parametros = [];
        if ($tipo > 0)
            $parametros = array(':busca' => $busca);

        $comando = Database::executar($sql, $parametros);
        $clientes = array();

        while ($forma = $comando->fetch(PDO::FETCH_ASSOC)) {
            $cliente = new Cliente($forma['idusuario'], $forma['nome'], $forma['email'],  $forma['senha'], $forma['permissao'], $forma['cpf']);
            array_push($clientes, $cliente);
        }
        return $clientes;
    }
}
