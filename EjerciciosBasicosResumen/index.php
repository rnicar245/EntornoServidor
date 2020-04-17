<?php
    include "Dni.php";
    $dni = "";
    $num = "";
    $lDni = false;
    $lPrimo = false;

    function limpiarDatos($dato){
            $dato = trim($dato);
            $dato = stripslashes($dato);
            $dato = htmlspecialchars($dato);
            return $dato;
    }

    if(isset($_POST['enviarDni'])){
        $dni = new Dni(limpiarDatos($_POST['dni']));
        $lDni = true;
    }

    if(isset($_POST['esPrimo'])){
        $num = $_POST['primo'];
        $lPrimo = true;
    }

    function esPrimo($numero){
        $esPrimo = true;
        for($i = 2; $i<$numero; $i++){
            if($numero % $i == 0){
                $esPrimo = false;
            }
        }
        return $esPrimo;
    }

    
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Ejercicios Basicos</title>
    <?php
        echo "<form action= ".htmlspecialchars($_SERVER["PHP_SELF"])." method= \"POST\">";
        echo "Introduzca su DNI ";
        echo "<input type=\"text\" name=\"dni\" value=\"\">";
        echo "</br>";
        echo "Introduzca un número para ver si es primo ";
        echo "<input type=\"text\" name=\"primo\" value=\"\">";
        echo "</br>";
        echo "<input type=\"submit\" name=\"enviarDni\" value=\"Validar DNI\">";
        echo "<input type=\"submit\" name=\"esPrimo\" value=\"Es Primo\">";
        echo "</form>";

        if($lDni){
            echo $dni->getMensaje();
            $lDni = false;
        }

        if($lPrimo){
            echo esPrimo($num);
            $lPrimo = false;
        }
        echo "<p>Primeros 5 números primos:</p>";
        $i = 1;
        $contador = 1;
        do{
            if(esPrimo($i)){
                echo "<p>".$i."</p>";
                $contador++;
            }
            $i++;
        }while($contador<6);     
    ?>
    
</head>
<body>
</body>
</html>
