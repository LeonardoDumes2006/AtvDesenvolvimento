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
    <div class="container">
        <form action="quadrado.php" method="post">

            <div class="row justify-content-center mt-5">
                <div class="col-6">
                    <h4> <b>Cadastro de Quadrado</b></h4>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-4">
                    <label class="form-label" for="altura">Altura</label>
                    <input type="number" class="form-control" name="altura" id="altura" value="<?= $id ? $quadrado->getAltura() : 0 ?>" placeholder=" Digite a altura de sua forma">
                </div>
                <div class="col-2">
                    <label class="form-label" for="cor">Cor</label>
                    <input type="color" class="form-control form-control-color" name="cor" id="cor" placeholder=" Digite a cor de sua forma" value="<?= $id ? $quadrado->getCor() : "black" ?>">
                </div>
            </div>
            <div class="row justify-content-center mt-3">
                <div class="col-6">

                    <label class="form-label" for="unidade">Unidade</label>
                    <select class="form-select" name="unidade" id="unidade">
                        <?php
                        $unidades = Unidade::listar();
                        foreach ($unidades as $unidade) {
                            echo " <option value=" . $unidade->getId()  . "> " . $unidade->getUnidade() . " </option>";
                        }
                        ?>
                    </select>

                </div>
            </div>






            <input type="text" name="id" id="id" value="<?= isset($quadrado) ? $quadrado->getId() : 0 ?>" placeholder=" Digite a unidade de sua forma" hidden>

            <div class="row justify-content-center mt-4">
                <div class="col-1 d-grid gap-2 ">
                    <input class="btn btn-dark" type="submit" name="acao" id="acao" value="Salvar">
                </div>
                <div class="col-1 d-grid gap-2 ">
                    <input class="btn btn-dark" type="reset" name="resetar" id="resetar" value="Resetar">
                </div>
            </div>


        </form>

        <form action="" method="get">

            <div class="row justify-content-center mt-4">
                <div class="col-6">
                    <h4><b>Busca</b></h4>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-6">
                    <input type="text" class="form-control" name="busca" id="busca" placeholder="Busca">
                </div>
            </div>
            <div class="row justify-content-center mt-3">
                <div class="col-6">
                    <select class="form-select" name="tipo" id="tipo">
                        <option value="1">ID</option>
                        <option value="2">Lado</option>
                        <option value="3">Cor</option>
                        <option value="4">Unidade</option>
                    </select>
                </div>
            </div>

            <div class="row justify-content-center mt-3">
                <div class="col-1 d-grid gap-2 ">
                    <input class="btn btn-dark" type="submit" name="acao" id="acao" value="Buscar">
                </div>
            </div>

        </form>
        <table class="table table-striped mt-5" border="1px">
            <thead class="table-dark">
                <th>Id</th>
                <th>Altura</th>
                <th>Cor</th>
                <th>Unidade</th>
                <th>Quadrados</th>
            </thead>

            <?php
            foreach ($lista as $quadrado) {
                echo "<tr>
                         <td>". $quadrado->getId() . "</td>
                         <td>" . $quadrado->getAltura() . "</td>
                         <td>" . $quadrado->getCor() . "</td>
                         <td>" . $quadrado->getUnidade()->getUnidade()  . "</a></td>";
                echo "<td><a href='index.php?id=" . $quadrado->getId() . "'>" . $quadrado->desenharQuadrado($quadrado) . "</a>
                        </td>";
            }

            ?>
        </table>
    </div>
</body>

</html>