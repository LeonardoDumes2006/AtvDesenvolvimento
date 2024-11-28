<?php
require_once("../classes/autoload.php");

class Usuario extends Persistencia
{
    private $nome;
    private $email;
    private $senha;
    private $permissao;

    public function  __construct($id = 0, $nome = "", $email = "", $senha = "", $permissao = 0)
    {
        parent::__construct($id);

        $this->setNome($nome);
        $this->setEmail($email);
        $this->setSenha($senha);
        $this->setPermissao($permissao);
    }

    public function setNome($nome)
    {
        if ($nome == "")
            throw new Exception("Erro, número indefinnomeo");
        else
            $this->nome = $nome;
    }

    public function setEmail($email)
    {
        if ($email == "")
            throw new Exception("Erro, número indefinemailo");
        else
            $this->email = $email;
    }

    public function setSenha($senha)
    {
        if ($senha == "")
            throw new Exception("Erro, número indefinsenhao");
        else
            $this->senha = $senha;
    }

    public function setPermissao($permissao)
    {
        if ($permissao < 1)
            throw new Exception("Erro, número indefinpermissaoo");
        else
            $this->permissao = $permissao;
    }


    public function getNome()
    {
        return $this->nome;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getSenha()
    {
        return $this->senha;
    }

    public function getPermissao()
    {
        return $this->permissao;
    }


    public function incluir()
    {
        $sql = 'INSERT INTO usuario (nome,email, senha, permissao, cpf)   
                VALUES (:nome, :email, :senha, :permissao, :cpf)';

        $parametros = array(
            ':nome' => $this->getNome(),
            ':email' => $this->getEmail(),
            ':senha' => $this->getSenha(),
            ':permissao' => $this->getPermissao(),
            ':cpf' => null
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
            ':cpf' => null,
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
        $usuarios = array();

        while ($forma = $comando->fetch(PDO::FETCH_ASSOC)) {
            $usuario = new Usuario($forma['idusuario'], $forma['nome'], $forma['email'],  $forma['senha'], $forma['permissao']);
            array_push($usuarios, $usuario);
        }
        return $usuarios;
    }
}
