<?php
$radio = isset($_POST['radio']) ? $_POST['radio'] : "";


$min = isset($_POST['min']) ? $_POST['min'] : "";
$max = isset($_POST['max']) ? $_POST['max'] : "";
$q = isset($_POST['q']) ? $_POST['q'] : "";
$cont = 0;
$vet = [];

echo "Vetor Gerado<br>";
for ($x = 0; $x < $q; $x++) {
    $vet[] = rand($min, $max);
    echo $vet[$x] . "|";
}
if ($radio == "ordem") {
    echo "<br><br>Mostrar os elementos do vetor na ordem original
            (primeiro, segundo, ... , último);<br>";

    for ($x = 0; $x < $q; $x++) {
        $vet[] = rand($min, $max);

        echo $vet[$x] . "|";
    }
} else if ($radio == "ordemin") {
    echo "<br><br>Mostrar os elementos do vetor na ordem inversa
            (último, penúltimo, ... , primeiro);<br>";
    for ($x = $q - 1; $x >= 0; $x--) {
        $vet[] = rand($min, $max);

        echo $vet[$x] . "|";
    }
} else if ($radio == "maior") {
    echo "<br><br>Maior elemento;<br>";
    echo max($vet);
} else if ($radio == "menor") {
    echo "<br><br>Menor elemento;<br>";

    echo min($vet);
} else if ($radio == "par") {
    echo "<br><br>Elementos Pares;<br>";
    for ($x = 0; $x < $q; $x++) {
        $vet[] = rand($min, $max);
        if ($vet[$x] % 2 == 0) {
            echo $vet[$x] . "|";
        }
    }
} else if ($radio == "impar") {
    echo "<br><br>Elementos Ímpares;<br>";
    for ($x = 0; $x < $q; $x++) {
        $vet[] = rand($min, $max);
        if ($vet[$x] % 2 != 0) {
            echo $vet[$x] . "|";
        }
    }
} else if ($radio == "soma") {
    echo "<br><br>Soma dos Elementos;<br>";
    for ($x = 0; $x < $q; $x++) {
        $vet[] = rand($min, $max);
        $cont += $vet[$x];
    }
    echo $cont;
} else if ($radio == "media") {
    echo "<br><br>Média dos Elementos;<br>";
    for ($x = 0; $x < $q; $x++) {
        $vet[] = rand($min, $max);
        $cont += $vet[$x];
        $media = $cont / $q;
    }
    echo $media ;
}else if ($radio == "acima") {
    echo "<br><br>Elementos acima da média;<br><br>";
    for ($x = 0; $x < $q; $x++) {
        $vet[] = rand($min, $max);
        $cont += $vet[$x];   
    } $media = $cont / $q;
    echo "A média é $media<br>";
     for ($x = 0; $x < $q; $x++) {
        if ( $vet[$x] > $media){
            echo $vet[$x] . "|";
    }  
}
}else if ($radio == "abaixo") {
    echo "<br><br>Elementos abaixo da média;<br><br>";
    for ($x = 0; $x < $q; $x++) {
        $vet[] = rand($min, $max);
        $cont += $vet[$x];   
    } $media = $cont / $q;
    echo "A média é $media<br>";
     for ($x = 0; $x < $q; $x++) {
        if ( $vet[$x] < $media){
            echo $vet[$x] . "|";
    }  
}
}
