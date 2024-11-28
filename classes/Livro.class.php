<?php
require_once("../classes/autoload.php");

class Livro extends Persistencia
{
    private $titulo;
    private $ano;
    private $foto;
    private $categoria;
    private $preco;

    public function  __construct($id = 0, $titulo = "", $ano = "", $foto = "", Categoria $categoria = null, $preco = 0)
    {
        parent::__construct($id);
        $this->setTitulo($titulo);
        $this->setAno($ano);
        $this->setFoto($foto);
        $this->setCategoria($categoria);
        $this->setPreco($preco);
    }

    public function setTitulo($titulo)
    {
        if ($titulo == "")
            throw new Exception("Erro, número indefintituloo");
        else
            $this->titulo = $titulo;
    }

    public function setAno($ano)
    {
        if ($ano == "")
            throw new Exception("Erro, número indefinanoo");
        else
            $this->ano = $ano;
    }

    public function setFoto($foto)
    {

        if ($foto == "")
            throw new Exception("Erro, número indefinfotoo");
        else
            $this->foto = $foto;
    }

    public function setCategoria(Categoria $categoria)
    {
        if ($categoria == null)
            throw new Exception("Erro, número indefincategoriao");
        else
            $this->categoria = $categoria;
    }

    public function setPreco($preco)
    {
        if ($preco < 1)
            throw new Exception("Erro, número indefinprecoo");
        else
            $this->preco = $preco;
    }

    public function getTitulo()
    {
        return $this->titulo;
    }

    public function getAno()
    {
        return $this->ano;
    }

    public function getFoto()
    {
        return $this->foto;
    }

    public function getCategoria(): Categoria
    {
        return $this->categoria;
    }

    public function getPreco()
    {
        return $this->preco;
    }

    public function incluir()
    {
        $sql = 'INSERT INTO livro (titulo, anoPublicacao,fotoCapa, idCategoria, preco)   
                VALUES (:titulo, :ano, :foto, :categoria, :preco)';

        $parametros = array(
            ':titulo' => $this->getTitulo(),
            ':ano' => $this->getAno(),
            ':foto' => $this->getFoto(),
            ':categoria' => $this->getCategoria()->getId(),
            ':preco' => $this->getPreco()
        );

        return Database::executar($sql, $parametros);
    }

    public function excluir()
    {
        $conexao = Database::getInstance();
        $sql = 'DELETE FROM livro WHERE idlivro = :id';
        $comando = $conexao->prepare($sql);
        $comando->bindValue(':id', $this->getId());
        return $comando->execute();
    }

    public function alterar()
    {
        $sql = 'UPDATE livro
            SET titulo = :titulo, anoPublicacao = :ano, fotoCapa = :foto, idCategoria = :categoria, preco = :preco
            WHERE idlivro = :id';
        $parametros = array(
            ':titulo' => $this->getTitulo(),
            ':ano' => $this->getAno(),
            ':foto' => $this->getFoto(),
            ':categoria' => $this->getCategoria(), // Passar o ID da unidade em vez do objeto
            ':preco' => $this->getPreco(),
            ':id' => $this->getId()
        );
        return Database::executar($sql, $parametros);
    }

    public static function listar($tipo = 0, $busca = ""): array
    {
        $sql = "SELECT * FROM livro";
        if ($tipo > 0) {
            switch ($tipo) {
                case 1:
                    $sql .= " WHERE idlivro = :busca";
                    break;
                case 2:
                    $sql .= " WHERE titulo LIKE :busca";
                    $busca = "%{$busca}%";
                    break;
                case 3:
                    $sql .= " WHERE anoPublicacao LIKE :busca";
                    $busca = "%{$busca}%";
                    break;
                case 4:
                    $sql .= " WHERE fotoCapa LIKE :busca";
                    $busca = "%{$busca}%";
                    break;
                case 5:
                    $sql .= " WHERE idCategoria LIKE :busca";
                    $busca = "%{$busca}%";
                    break;
                case 6:
                    $sql .= " WHERE preco LIKE :busca";
                    $busca = "%{$busca}%";
                    break;
            }
        }
        // $comando = $conexao->prepare($sql);
        $parametros = [];
        if ($tipo > 0)
            $parametros = array(':busca' => $busca);

        $comando = Database::executar($sql, $parametros);
        $livros = array();

        while ($forma = $comando->fetch(PDO::FETCH_ASSOC)) {
            $categoria = Categoria::listar(1, $forma['idCategoria'])[0];
            $livro = new Livro($forma['idlivro'], $forma['titulo'], $forma['anoPublicacao'], $forma['fotoCapa'],  $categoria, $forma['preco']);
            array_push($livros, $livro);
        }
        return $livros;
    }
}
