<!DOCTYPE html>
<html lang="en">
<?php
include_once('unidade.php');
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <title>Document</title>
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
                    <a class="nav-link active" aria-current="page" href="#">Cadastro de Unidade</a>
                    <a class="nav-link" href="../triangulo/index.php">Cadastro de Triângulo</a>
                    <a class="nav-link" href="../circulo/index.php">Cadastro de Circulo</a>
                </div>
            </div>
        </div>
    </nav>
    
    <div class="container-fluid">
        <div class="row justify-content-center m-3">
            <!-- Coluna da esquerda: Formulário de Cadastro de Unidade -->
            <div class="col-md-6 p-3">
                <h4><b>Cadastro de Unidade</b></h4>
                <form action="unidade.php" method="post">
                    <div class="row justify-content-center mb-3">
                        <div class="col-12">
                            <label for="id">ID</label>
                            <input class="form-control" type="text" name="id" id="id" value="<?= $id ? $unidade->getId() : 0 ?>" readonly>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-12">
                            <label for="unidade">Unidade</label>
                            <input class="form-control" type="text" name="unidade" id="unidade" value="<?= $id ? $unidade->getUnidade() : 0 ?>">
                        </div>
                    </div>
                    <div class="row justify-content-center mt-4">
                        <div class="col-4 d-grid gap-2">
                            <input class="btn btn-dark" type="submit" name="acao" id="acao" value="<?php if($id> 0)echo 'Alterar'; else echo 'Salvar'; ?>">
                        </div>
                        <div class="col-4 d-grid gap-2">
                            <input class="btn btn-dark" type="reset" name="resetar" id="resetar" value="Resetar">
                        </div>
                        <div class="col-4 d-grid gap-2">
                            <input class="btn btn-dark" type="submit" name="acao" id="acao" value="Excluir">
                        </div>
                    </div>
                </form>
            </div>

            <!-- Coluna da direita: Formulário de Busca e Tabela de Unidades -->
            <div class="col-md-6 p-3">
                <h4><b>Busca</b></h4>
                <form action="" method="get">
                    <div class="row justify-content-center mb-3">
                        <div class="col-12">
                            <input class="form-control" type="text" name="busca" id="busca" placeholder="Busca">
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-12">
                            <select class="form-select" name="tipo" id="tipo">
                                <option value="1">ID</option>
                                <option value="4">Unidade</option>
                            </select>
                        </div>
                    </div>
                    <div class="row justify-content-center mt-4">
                        <div class="col-4 d-grid gap-2">
                            <input type="submit" class="btn btn-dark" name="acao" id="acao" value="Buscar">
                        </div>
                    </div>
                </form>

                <!-- Tabela de Unidades -->
                <div class="row justify-content-center mt-5">
                    <div class="col-12">
                        <table class="table table-striped table-responsive" border="1px">
                            <thead class="table-dark">
                                <tr>
                                    <th>Id</th>
                                    <th>Unidade</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                            foreach ($lista as $unidade) {
                                echo "<tr>
                                        <td><a href='index.php?id=". $unidade->getId() . "'>" . $unidade->getId() . "</a></td>
                                        <td><a href='index.php?id=" . $unidade->getId() . "' style='text-decoration: none; color: black'>" . $unidade->getUnidade() . "</a></td>
                                    </tr>";
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
