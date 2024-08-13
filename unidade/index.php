<!DOCTYPE html>
<html lang="en">

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
                </div>
            </div>
        </div>
    </nav>
    <div class="container">


        <form action="unidade.php" method="post">

            <div class="row justify-content-center mt-5">
                <div class="col-6">
                    <h4> <b>Cadastro de Unidade</b></h4>
                </div>
            </div>

            <div class="row justify-content-center mb-3">
                <div class="col-6">
                    <label for="id">ID</label>
                    <input class="form-control" type="text" name="id" id="id" value="0" readonly>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-6">
                    <label for="id">Unidade</label>
                    <input class="form-control" type="text" name="unidade" id="unidade">
                </div>
            </div>

            <div class="row justify-content-center mt-3 ms-5">
                <div class="col-1 d-grid gap-2 ">
                    <input type="submit" class="btn btn-dark" name="acao" id="acao" value="Salvar">
                </div>

                <div class="col-1 d-grid gap-2 ">
                    <input type="reset" class="btn btn-dark" name="resetar" id="resetar" value="Resetar">
                </div>
            </div>
        </form>

        <form action="unidade.php" method="post">

            <div class="row justify-content-center mt-5">
                <div class="col-6">
                    <h4> <b>Busca</b></h4>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-6">
                    <input class="form-control" type="text" name="busca" id="busca" placeholder="Busca">
                </div>
            </div>
            <div class="row justify-content-center mt-4">
                <div class="col-6">
                    <select class="form-select" name="tipo" id="tipo">
                        <option value="1">ID</option>
                        <option value="4">Unidade</option>
                    </select>
                </div>
            </div>
            <div class="row justify-content-center mt-4">
                <div class="col-1 d-grid gap-2 ">
                    <input type="submit" class="btn btn-dark" name="acao" id="acao" value="Buscar">
                </div>
            </div>


        </form>
    </div>
</body>

</html>