<?php
require_once('../classes/autoload.php');
class AutorLivro extends Persistencia
{
    private $autor;
    private $livro;

    public function  __construct($id = 0, Autor $autor = null, Livro $livro = null)

    {
        parent::__construct($id);
        $this->setAutor($autor);
        $this->setLivro($livro);
    }

    // ====================== Seter's ======================== //


    public function setAutor(Autor $autor)
    {
        if ($autor === "")
            throw new Exception("Erro:Autor inválido!");
        else
            $this->autor = $autor;
    }

    public function setLivro(Livro $livro)
    {
        if ($livro === "")
            throw new Exception("Erro:Livro inválido!");
        else
            $this->livro = $livro;
    }


    // ====================== Geter's ======================== //


    public function getAutor()
    {
        return $this->autor;
    }
    public function getLivro()
    {
        return $this->livro;
    }

    // ====================== DBFunctions ======================== //


    public function incluir()
    {
        $sql = 'INSERT INTO autorlivros (idAutor, idLivro)   
        VALUES (:idAutor, :idLivro)';

        $parametros = array(
            ':idAutor' => $this->getAutor()->getId(),
            ':idLivro' => $this->getLivro()->getId(),
        );

        return Database::executar($sql, $parametros);
    }

    public function alterar()
    {
        $sql = 'UPDATE autorlivros
        SET idAutor = :idAutor, idLivro = :idLivro
      WHERE id = :id';
        $parametros = array(
            ':id' => parent::getId(),
            ':idAutor' => $this->getAutor()->getId(),
            ':idLivro' => $this->getLivro()->getId(),
        );

        Database::executar($sql, $parametros);
        return true;
    }

    public function excluir()
    {
        $sql = 'DELETE 
                  FROM autorlivros
                 WHERE id = :id';
        $parametros = array(':id' => parent::getId());
        return Database::executar($sql, $parametros);
    }

    public static function listar($tipo = 0, $busca = ""): array
    {
        $sql = "SELECT * FROM autorlivros";
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
            $autor = Autor::listar(1, $registro['idAutor'])[0];
            $livro = Livro::listar(1, $registro['idLivro'])[0];
            $quadrado = new AutorLivro($registro['id'], $autor, $livro);
            array_push($formas, $quadrado);
        }
        return $formas;
    }

    public function Login() {}
}
