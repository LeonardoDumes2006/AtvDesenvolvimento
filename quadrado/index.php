<!DOCTYPE html>
<html lang="en">
<?php
include_once('quadrado.php');
?>

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <title>Formulário de criação de formas</title>
</head>

<body>
<nav class="navbar navbar-expand-lg bg-body-tertiary nav-dark" data-bs-theme="dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php">Formas Geométricas</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
      <div class="navbar-nav">
        <a class="nav-link active" aria-current="page" href="#">Cadastro de Quadrado</a>
        <a class="nav-link" href="../unidade/index.php">Cadastro de Unidade</a>
      </div>
    </div>
  </div>
</nav>
   
        <div class="row">
            <!-- Coluna da esquerda: Formulário de Cadastro de Quadrado e Tabela -->
            <div class="col-md-6 p-5">
                <form action="quadrado.php" method="post">
                    <div class="row justify-content-center">
                        <div class="col-12">
                            <h4><b>Cadastro de Quadrado</b></h4>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-8">
                            <label class="form-label" for="altura">Altura</label>
                            <input type="number" class="form-control" name="altura" id="altura" value="<?= $id ? $quadrado->getAltura() : 0 ?>" placeholder="Digite a altura de sua forma">
                        </div>
                        <div class="col-4">
                            <label class="form-label" for="cor">Cor</label>
                            <input type="color" class="form-control form-control-color" name="cor" id="cor" placeholder="Digite a cor de sua forma" value="<?= $id ? $quadrado->getCor() : 'black' ?>">
                        </div>
                    </div>
                    <div class="row justify-content-center mt-3">
                        <div class="col-12">
                            <label class="form-label" for="unidade">Unidade</label>
                            <select class="form-select" name="unidade" id="unidade">
                                <?php
                                $unidades = Unidade::listar();
                                foreach ($unidades as $unidade) {
                                    echo " <option value=" . $unidade->getId() . "> " . $unidade->getUnidade() . " </option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <input type="text" name="id" id="id" value="<?= isset($quadrado) ? $quadrado->getId() : 0 ?>" hidden>

                    <div class="row justify-content-center mt-4">
                        <div class="col-4 d-grid gap-2">
                            <input class="btn btn-dark" type="submit" name="acao" id="acao" value="<?php if($id > 0) echo 'Alterar'; else echo 'Salvar'; ?>">
                        </div>
                        <div class="col-4 d-grid gap-2">
                            <input class="btn btn-dark" type="reset" name="resetar" id="resetar" value="Resetar">
                        </div>
                        <div class="col-4 d-grid gap-2">
                            <input class="btn btn-dark" type="submit" name="acao" id="acao" value="Excluir">
                        </div>
                    </div>
                </form>

                <!-- Tabela de Quadrados -->
                <div class="row justify-content-center mt-5">
                        <div class="col-12">
                            <h4><b>Tabela Quadrados</b></h4>
                        </div>
                    </div>
                <div class="row justify-content-center ">
                    <div class="col-12">
                        <table class="table table-striped" border="1px">
                            <thead class="table-dark">
                                <tr>
                                    <th>Id</th>
                                    <th>Altura</th>
                                    <th>Cor</th>
                                    <th>Unidade</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                            foreach ($lista as $quadrado) {
                                echo "<tr>
                                         <td>" . $quadrado->getId() . "</td>
                                         <td>" . $quadrado->getAltura() . "</td>
                                         <td>" . $quadrado->getCor() . "</td>
                                         <td>" . $quadrado->getUnidade()->getUnidade() . "</td>
                                      </tr>";
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Coluna da direita: Formulário de Busca e Apresentação dos Quadrados -->
            <div class="col-md-6 p-5">
                <form action="" method="get">
                    <div class="row justify-content-center">
                        <div class="col-12">
                            <h4><b>Busca</b></h4>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-12">
                            <input type="text" class="form-control" name="busca" id="busca" placeholder="Busca">
                        </div>
                    </div>
                    <div class="row justify-content-center mt-3">
                        <div class="col-12">
                            <select class="form-select" name="tipo" id="tipo">
                                <option value="1">ID</option>
                                <option value="2">Lado</option>
                                <option value="3">Cor</option>
                                <option value="4">Unidade</option>
                            </select>
                        </div>
                    </div>
                    <div class="row justify-content-center mt-3">
                        <div class="col-4 d-grid gap-2">
                            <input class="btn btn-dark" type="submit" name="acao" id="acao" value="Buscar">
                        </div>
                    </div>
                </form>

                <!-- Apresentação dos Quadrados -->
                <div class="row justify-content-center mt-4">
                    <div class="col-12">
                        <h4><b>Quadrado</b></h4>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-12">
                        <?php
                        foreach ($lista as $quadrado) {
                            echo "<a href='index.php?id=" . $quadrado->getId() . "'>" . $quadrado->desenharQuadrado($quadrado) . "</a>";
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    
</body>
</html>
