<?php
require_once('../classes/autoload.php');
class Livro extends Persistencia
{
    private $titulo;
    private $pub;
    private $capa;
    private $categoria;
    private $preco;

    public function  __construct($id = 0, $titulo = "", $pub = "null", $capa = "", Categoria $categoria = null, $preco = 0.0)

    {
        parent::__construct($id);
        $this->setTitulo($titulo);
        $this->setPub($pub);
        $this->setCape($capa);
        $this->setCategoria($categoria);
        $this->setPreco($preco);
    }

    // ====================== Seter's ======================== //


    public function setTitulo($titulo)
    {
        if ($titulo === "")
            throw new Exception("Erro: titulo inválido!");
        else
            $this->titulo = $titulo;
    }

    public function setPub($pub)
    {
        if ($pub === "")
            throw new Exception("Erro: Data de publicação inválida!");
        else
            $this->pub = $pub;
    }

    public function setCape($capa)
    {
        if ($capa === "")
            throw new Exception("Erro: Capa inválida!");
        else
            $this->capa = $capa;
    }
    public function setCategoria(Categoria $categoria)
    {
        if ($categoria === "")
            throw new Exception("Erro: Data de publicação inválida!");
        else
            $this->categoria = $categoria;
    }
    public function setPreco($preco)
    {
        if ($preco === 0)
            throw new Exception("Erro: Valor inválido!");
        else
            $this->preco = $preco;
    }

    // ====================== Geter's ======================== //


    public function getTitulo()
    {
        return $this->titulo;
    }
    public function getPub()
    {
        return $this->pub;
    }
    public function getCape()
    {
        return $this->capa;
    }
    public function getCategoria()
    {
        return $this->categoria;
    }
    public function getPreco()
    {
        return $this->preco;
    }

    // ====================== DBFunctions ======================== //


    public function incluir()
    {
        $sql = 'INSERT INTO livros (titulo, anoPublicacao, fotoCapa, idCategoria, preco)   
        VALUES (:titulo, :pub, :capa, :categoria, :preco)';

        $parametros = array(
            ':titulo' => $this->getTitulo(),
            ':pub' => $this->getPub(),
            ':capa' => $this->getCape(),
            ':categoria' => $this->getCategoria()->getId(),
            ':preco' => $this->getPreco()
        );

        return Database::executar($sql, $parametros);
    }

    public function alterar()
    {
        $sql = 'UPDATE livros 
        SET titulo = :titulo, anoPublicacao = :pub, fotoCapa = :capa, idCategoria = :categoria, preco = :preco
      WHERE id = :id';
        $parametros = array(
            ':id' => parent::getId(),
            ':titulo' => $this->getTitulo(),
            ':pub' => $this->getPub(),
            ':capa' => $this->getCape(),
            ':categoria' => $this->getCategoria()->getId(),
            ':preco' => $this->getPreco()
        );
        Database::executar($sql, $parametros);
        return true;
    }

    public function excluir()
    {
        $sql = 'DELETE 
                  FROM livros
                 WHERE id = :id';
        $parametros = array(':id' => parent::getId());
        return Database::executar($sql, $parametros);
    }

    public static function listar($tipo = 0, $busca = ""): array
    {
        $sql = "SELECT * FROM livros";
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
            $categoria = Categoria::listar(1,$registro['idCategoria'])[0];
            $quadrado = new Livro($registro['id'], $registro['titulo'], $registro['anoPublicacao'], $registro['fotoCapa'], $categoria, $registro['preco']);
            array_push($formas, $quadrado);
        }
        return $formas;
    }

    public function Login() {}
}
