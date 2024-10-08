<!DOCTYPE html>
<html lang="en">
<?php
include_once('triangulo.php');
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
                    <a class="nav-link" href="../quadrado/index.php">Cadastro de Quadrado</a>
                    <a class="nav-link" href="../unidade/index.php">Cadastro de Unidade</a>
                    <a class="nav-link active" aria-current="page" href="#">Cadastro de Triângulo</a>
                    <a class="nav-link" href="../circulo/index.php">Cadastro de Circulo</a>

                </div>
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row m-3">
            <!-- Coluna da esquerda: Formulário de Cadastro de Quadrado e Tabela -->
            <div class="col-md-6 p-3">
                <form action="triangulo.php" method="post" enctype="multipart/form-data">
                    <div class="row justify-content-center">
                        <div class="col-12">
                            <h4><b>Cadastro de Triângulo</b></h4>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-3">
                            <label class="form-label" for="lado1">Lado 1 </label>
                            <input type="number" class="form-control" name="lado1" id="lado1" value="<?= $id ? $triangulo->getLado1() : 0 ?>" placeholder="">
                        </div>
                        <div class="col-3">
                            <label class="form-label" for="lado2">Lado 2 </label>
                            <input type="number" class="form-control" name="lado2" id="lado2" value="<?= $id ? $triangulo->getLado2() : 0 ?>" placeholder="">
                        </div>
                        <div class="col-3">
                            <label class="form-label" for="lado3">Lado 3 </label>
                            <input type="number" class="form-control" name="lado3" id="lado3" value="<?= $id ? $triangulo->getLado3() : 0 ?>" placeholder="">
                        </div>
                        <div class="col-3">
                            <label class="form-label" for="cor">Cor</label>
                            <input type="color" class="form-control form-control-color" name="cor" id="cor" placeholder="Digite a cor de sua forma" value="<?= $id ? $triangulo->getCor() : 'black' ?>">
                        </div>
                    </div>
                    <div class="row justify-content-center mt-3">
                        <div class="col-3">
                            <label class="form-label" for="unidade">Unidade</label>
                            <select class="form-select" name="unidade" id="unidade">
                                <?php

                                $unidades = Unidade::listar();
                                foreach ($unidades as $unidade) {
                                    $str = "<option value='{$unidade->getId()} '";
                                    if (isset($triangulo) && $triangulo->getUnidade()->getId() == $unidade->getId())
                                        $str .= " selected";
                                    $str .= ">" . $unidade->getUnidade() . "</option>";
                                    echo $str;
                                } ?>
                            </select>

                        </div>
                        <div class="col-3">
                            <label class="form-label" for="tipo">Tipo</label>
                            <select class="form-select" name="tipo" id="tipo">  
                                <option value="equi">Equilatero</option>
                                <option value="iso">Isosceles</option>
                                <option value="esca">Escaleno</option>
                            </select>

                        </div>
                        <div class="col-6">
                            <label class="form-label" for="img">Imagem de fundo</label>
                            <input class="form-control" type="file" name="img" id="img">
                        </div>
                    </div>

                    <input type="text" name="id" id="id" value="<?= isset($triangulo) ? $triangulo->getId() : 0 ?>" hidden>

                    <div class="row justify-content-center mt-4">
                        <div class="col-4 d-grid gap-2">
                            <input class="btn btn-dark" type="submit" name="acao" id="acao" value="<?php if ($id > 0) echo 'Alterar';
                                                                                                    else echo 'Salvar'; ?>">
                        </div>
                        <div class="col-4 d-grid gap-2">
                            <input class="btn btn-dark" type="reset" name="resetar" id="resetar" value="Resetar">
                        </div>
                        <div class="col-4 d-grid gap-2">
                            <input class="btn btn-dark" type="submit" name="acao" id="acao" value="Excluir">
                        </div>
                    </div>
                </form>

                <!-- Tabela de triangulos -->
                <div class="row justify-content-center mt-5">
                    <div class="col-12">
                        <h4><b>Tabela triangulos</b></h4>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-12">
                        <table class="table table-striped table-responsive" border="1px">
                            <thead class="table-dark">
                                <tr>
                                    <th>Id</th>
                                    <th>Lado 1</th>
                                    <th>Lado 2</th>
                                    <th>Lado 3</th>
                                    <th>Cor</th>
                                    <th>Unidade</th>
                                    <th>Área</th>
                                    <th>Perímetro</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($lista as $triangulo) {
                                    echo "<tr>
                                         <td>" . $triangulo->getId() . "</td>
                                         <td>" . $triangulo->getLado1() . "</td>
                                         <td>" . $triangulo->getLado2() . "</td>
                                         <td>" . $triangulo->getLado3() . "</td>
                                         <td>" . $triangulo->getCor() . "</td>
                                         <td>" . $triangulo->getUnidade()->getUnidade() . "</td>
                                         <td>" . $triangulo->calcularArea() . " ". $triangulo->getUnidade()->getUnidade() . "²" . "</td>
                                         <td>" . $triangulo->calcularPerimetro() . " " . $triangulo->getUnidade()->getUnidade(). "</td>

                                      </tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Coluna da direita: Formulário de Busca e Apresentação dos trin$triangulos -->
            <div class="col-md-6 p-3">
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
                        <h4><b>Triangulo</b></h4>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-12">
                        <?php
                        foreach ($lista as $triangulo) {
                            echo "<a href='index.php?id=" . $triangulo->getId() . "'>" . $triangulo->desenharForma($triangulo) . "</a>";
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>