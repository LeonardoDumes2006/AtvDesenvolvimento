<?php
require_once("../classes/autoload.php");

class Autorlivro extends Persistencia
{
    private $idautor;
    private $idlivro;

    public function  __construct($id = 0, Autor $idautor = null, Livro $idlivro = null)
    {
        parent::__construct($id);
        $this->setAutor($idautor);
        $this->setLivro($idlivro);
    }

    public function setAutor($idautor)
    {
        if ($idautor == null)
            throw new Exception("Erro, número indefinidautoro");
        else
            $this->idautor = $idautor;
    }

    public function setLivro($idlivro)
    {
        if ($idlivro == null)
            throw new Exception("Erro, número indefinidlivroo");
        else
            $this->idlivro = $idlivro;
    }

    public function getAutor()
    {
        return $this->idautor;
    }

    public function getLivro()
    {
        return $this->idlivro;
    }

    public function incluir()
    {
        $sql = 'INSERT INTO autorlivro (idAuto, idLivro)   
                VALUES (:idAuto, :idLivro)';

        $parametros = array(
            ':idAuto' => $this->getAutor()->getId(),
            ':idLivro' => $this->getLivro()->getId()
        );

        return Database::executar($sql, $parametros);
    }

    public function excluir()
    {
        $conexao = Database::getInstance();
        $sql = 'DELETE FROM autorlivro WHERE idautorlivro = :id';
        $comando = $conexao->prepare($sql);
        $comando->bindValue(':id', $this->getId());
        return $comando->execute();
    }

    public function alterar()
    {
        $sql = 'UPDATE autorlivro
            SET idAuto = :idAuto, idLivro = :idLivro
            WHERE idautorlivro = :id';
        $parametros = array(
            ':idAuto' => $this->getAutor(),
            ':idLivro' => $this->getLivro()
        );
        return Database::executar($sql, $parametros);
    }

    public static function listar($tipo = 0, $busca = ""): array
    {
        $sql = "SELECT * FROM autorlivro";
        if ($tipo > 0) {
            switch ($tipo) {
                case 1:
                    $sql .= " WHERE idautorlivro = :busca";
                    break;
                case 2:
                    $sql .= " WHERE idAuto LIKE :busca";
                    $busca = "%{$busca}%";
                    break;
                case 3:
                    $sql .= " WHERE idLivro LIKE :busca";
                    $busca = "%{$busca}%";
                    break;
            }
        }
        // $comando = $conexao->prepare($sql);
        $parametros = [];
        if ($tipo > 0)
            $parametros = array(':busca' => $busca);

        $comando = Database::executar($sql, $parametros);
        $autorlivros = array();

        while ($forma = $comando->fetch(PDO::FETCH_ASSOC)) {
            $autor = Autor::listar(1, $forma['idAuto'])[0]; // Obtenha o objeto Autor
            $livro = Livro::listar(1, $forma['idLivro'])[0]; // Obtenha o objeto Livro
    
            // Agora você pode passar os objetos para o construtor
            $autorlivro = new Autorlivro($forma['idautorlivro'], $autor, $livro);
            array_push($autorlivros, $autorlivro);
        }
        return $autorlivros;
    }
}
