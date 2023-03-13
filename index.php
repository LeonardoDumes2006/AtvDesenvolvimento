<!DOCTYPE html>
<html lang="en">
    <?php
        $radio = isset($_POST['radio']) ? $_POST['radio'] : "";
    ?>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="pag2.php" method="post">
        Quantidade de Números Gerados <input type="number" name="q" id="q"><br><br>
        Mínimo <input type="number" name="min" id="min"><br><br>
        Máximo <input type="number" name="max" id="max"><br><br>
        <fieldset>
            <legend>Resultados</legend>
            <input type="radio" name="radio" id="radio" value="ordem">Mostrar os elementos do vetor na ordem original
            (primeiro, segundo, ... , último);<br>
            <input type="radio" name="radio" id="radio" value="ordemin">Mostrar os elementos do vetor na ordem inversa
            (último, penúltimo, ... , primeiro);<br>
            <input type="radio" name="radio" id="radio" value="maior">Maior elemento;<br>
            <input type="radio" name="radio" id="radio" value="menor">Menor elemento;<br>
            <input type="radio" name="radio" id="radio" value="par">Elementos Pares;<br>
            <input type="radio" name="radio" id="radio" value="impar">Elementos Ímpares;<br>
            <input type="radio" name="radio" id="radio" value="soma">Soma dos Elementos;<br>
            <input type="radio" name="radio" id="radio" value="media">Média dos Elementos;<br>
            <input type="radio" name="radio" id="radio" value="acima">Elementos acima da média;<br>
            <input type="radio" name="radio" id="radio" value="abaixo">Elementos abaixo da média;<br>
            <input type="radio" name="radio" id="radio" value="primos">Elementos primos;<br>
            
        </fieldset>
        <input type="submit" value="Calcular">
        
    </form>
    
</body>
</html>