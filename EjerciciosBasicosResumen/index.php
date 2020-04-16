<?php
    include "Dni.php";
    $dni = "";
    $lDni = false;

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
        echo "<input type=\"submit\" name=\"enviarDni\" value=\"Enviar\">";
        echo "</form>";

        if($lDni){
            echo $dni->getMensaje();
            $lDni = false;
        }
    ?>
    
</head>
<body>
</body>
</html>
