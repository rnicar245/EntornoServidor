<?php
    $lRomano = false;
    $lDni = false;
    $lMatriz = false;
    $lMatriz2 = false;
    $romano = "";
    $matriz = array();
    $romanoTemp = "";

    function limpiarDatos($dato){
            $dato = trim($dato);
            $dato = stripslashes($dato);
            $dato = htmlspecialchars($dato);
            return $dato;
    }

    if(isset($_POST['enviar'])){
        if($_POST['romano'] != ""){
            $romanoTemp = $_POST['romano'];
            $romano = calculoNumeroRomano(limpiarDatos($_POST['romano']));
            $lRomano = true;
        }
    }

    if(isset($_POST['enviar2'])){
        if(!$_POST['num'] == "" and $_POST['num'] >=1){
            $num = limpiarDatos($_POST['num']);
            $lMatriz = true;
        }
        
    }

    if(isset($_POST['enviar3'])){
        $lMatriz2 = true;
        foreach($_POST as $elemento => $valor){
            if(substr($elemento, 0, 5) == "valor"){
                array_push($matriz, $valor);
            }
        }
    }

    function calculoNumeroRomano($romano){
        $romano = str_split(strtoupper($romano));
        $numero = 0;
        $repetido = 0;
        $valorAnterior = "";
        $valor = 0;
        
        foreach($romano as $letra){
            $correcto = true;
            $repetible = true;
            switch($letra){
                case "I":
                    $valor = 1;
                break;
                case "V":
                    $valor = 5;
                    $repetible = false;
                break;
                case "X":
                    $valor = 10;
                break;
                case "L":
                    $valor = 50;
                    $repetible = false;
                    if($valorAnterior == 1){
                        $correcto = false;
                    }
                break;
                case "C":
                    $valor = 100;
                    if($valorAnterior == 1){
                        $correcto = false;
                    }
                break;
                case "D":
                    $valor = 500;
                    $repetible = false;
                    if($valorAnterior == 1 or $valorAnterior == 10){
                        $correcto = false;
                    }
                break;
                case "M":
                    $valor = 1000;
                    if($valorAnterior == 1 or $valorAnterior == 10){
                        $correcto = false;
                    }
                break;
            }
            if($valorAnterior != ""){
                if($valorAnterior != $valor){
                    $repetido = 0;
                }
                if($repetido == 3 or !$correcto){
                    return false;
                }

                if($valorAnterior >= $valor){
                    if($valorAnterior == $valor and !$repetible){
                        return false;
                    }
                    $numero += $valor;
                }else{

                    $numero += ($valor - $valorAnterior*2);
                }
            }else{
                $numero = $valor;
            }


            $repetido++;
            $valorAnterior = $valor;
        }
        return $numero;
    }

    function numerosPerfectos($cantidad){
        do{
            for($i = 1; $i < 1000; $i++){
                $suma = 0;
                for($j = 1; $j<$i; $j++){
                    if($i % $j == 0){
                        $suma += $j;
                    }
                }

                if($suma == $i){
                    echo $i."<br>";
                    $cantidad--;
                }
            }
        }while($cantidad >0);
    }

    
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Ejercicios Basicos</title>
    <?php
        echo "<form action= ".htmlspecialchars($_SERVER["PHP_SELF"])." method= \"POST\">";
        echo "<h2>Números romanos</h2>";
        echo "Introduzca un número romano:<br> ";
        echo "<input type=\"text\" name=\"romano\" value=\"".$romanoTemp."\"><br>";
        echo "<input type=\"submit\" name=\"enviar\" value=\"Enviar\"><br><br>";
        echo "</form>";
        if($lRomano){
            if($romano == false){
                echo "El número introducido no es válido.";
            }else{
                echo $romano;
            }
        }
        echo "<h2>Números perfectos</h2>";
        numerosPerfectos(3);
        echo "<form action= ".htmlspecialchars($_SERVER["PHP_SELF"])." method= \"POST\">";
        echo "<h2>Matriz simétrica</h2>";
        echo "Introduzca el tamaño de la matriz:<br> ";
        echo "<input type=\"number\" name=\"num\" value=\"\"><br>";
        echo "<input type=\"submit\" name=\"enviar2\" value=\"Enviar\">";
        echo "</form>";

        if($lMatriz){
            echo "<form action= ".htmlspecialchars($_SERVER["PHP_SELF"])." method= \"POST\">";
            for($i = 1; $i<=$num; $i++){
                echo "<p>Valor ".$i.":</p>";
                echo "<input type=\"text\" name=\"valor".$i."\" value=\"\">";
            }
            echo "<br><input type=\"submit\" name=\"enviar3\" value=\"Enviar\">";
            echo "</form>";
        }
        
                    
        if($lMatriz2){
            $simetrico = true;
            $contador1 = 0;
            $contador2 = sizeof($matriz)-1;

            do{
                if($matriz[$contador1] != $matriz[$contador2]){
                    $simetrico = false;
                }
                $contador1++;
                $contador2--;
            }while($contador1 == sizeof($matriz)-1);

            if($simetrico){
                echo "<p>La matriz es simétrica.</p>";
            }else{
                echo "<p>La matriz no es simétrica.</p>";
            }
        }
    ?>
    
</head>
<body>
</body>
</html>
