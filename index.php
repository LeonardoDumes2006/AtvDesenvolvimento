<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="" method="post">
        Quantidade de Números Gerados <input type="text" name="q" id="q"><br><br>
        Mínimo <input type="text" name="min" id="min"><br><br>
        Máximo <input type="text" name="max" id="max"><br><br>
        <fieldset>
            <legend>Resultados</legend>
            <input type="radio" name="ordem" id="ordem" value="ordem">Mostrar os elementos do vetor na ordem original
            (primeiro, segundo, ... , último);<br>
            <input type="radio" name="ordemin" id="ordemin" value="ordemin">Mostrar os elementos do vetor na ordem inversa
            (último, penúltimo, ... , primeiro);<br>
            <input type="radio" name="maior" id="maior" value="maior">Maior elemento;<br>
            <input type="radio" name="menor" id="menor" value="menor">Menor elemento;<br>
            <input type="radio" name="par" id="par" value="par">Elementos Pares;<br>
            <input type="radio" name="impar" id="impar" value="impar">Elementos Ímpares;<br>
            <input type="radio" name="soma" id="soma" value="soma">Soma dos Elementos;<br>
            <input type="radio" name="media" id="media" value="media">Médio dos Elementos;<br>
            <input type="radio" name="acima" id="acima" value="acima">Elementos acima da média;<br>
            <input type="radio" name="abaixo" id="abaixo" value="abaixo">Elementos abaixo da média;<br>
            <input type="radio" name="primos" id="primos" value="primos">Elementos primos;<br>
            
        </fieldset>
        <input type="submit" value="Calcular">
        
    </form>
</body>
</html>