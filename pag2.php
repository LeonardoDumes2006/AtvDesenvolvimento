<?php
        $radio = isset($_POST['radio']) ? $_POST['radio'] : "";

        
       $min =isset($_POST['min']) ? $_POST['min'] : "";
       $max =isset($_POST['max']) ? $_POST['max'] : "";
       $q =isset($_POST['q']) ? $_POST['q'] : "";
       $cont = 0;
       $vet = [];
       
        echo "Vetor Gerado<br>";
        for ( $x = 0; $x < $q; $x++){
            $vet[] = rand($min,$max);
            echo $vet[$x]. "|";
        }
        if ( $radio == "ordem"){
            echo "<br><br>Mostrar os elementos do vetor na ordem original
            (primeiro, segundo, ... , último);<br>";
            
            for ( $x = 0; $x < $q; $x++){
                $vet[] = rand($min,$max);
                
                echo $vet[$x]. "|";
            }
    
        }
        else if ( $radio == "ordemin"){
            echo "<br><br>Mostrar os elementos do vetor na ordem inversa
            (último, penúltimo, ... , primeiro);<br>";
            for ( $x = $q-1; $x >= 0; $x--){
                $vet[] = rand($min,$max);
                
                echo $vet[$x]. "|";
            }
        }else if( $radio == "maior"){
            echo "<br><br>Maior elemento;<br>";
            echo max($vet); 

        }else if ( $radio == "menor"){
            echo "<br><br>Menor elemento;<br>";
                 
            echo min($vet);  
        }
?>