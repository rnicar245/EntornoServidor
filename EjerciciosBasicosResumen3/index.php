<?php
    include "Cola.php";
    session_start();
    
    $expresionTemp = "";
    $lExpresion = false;
    $resExpresion = "";
    $lSumaRecursiva = false;
    $elementoTemp = "";

    if (!isset($_SESSION['cola'])){
        $_SESSION['cola'] = new Cola();
    }

    function limpiarDatos($dato){
            $dato = trim($dato);
            $dato = stripslashes($dato);
            $dato = htmlspecialchars($dato);
            return $dato;
    }
    
    function sumaRecursiva($indice, $matriz){
        if($indice < count($matriz[0])){
            $suma = 0;
            foreach($matriz as $elemento){
                $suma += $elemento[$indice];
            }
            echo "<p>Array ".$indice.": ".$suma."</p>";
            $indice += 1;
            return sumaRecursiva($indice, $matriz);
        }
        
    }

    function encuentraParentesis($expresion){
        $expresion = str_split($expresion);
        $parentesisAp = 0;
        $parentesisCi = 0;
        foreach($expresion as $caracter){
            if($caracter == "("){
                $parentesisAp++;
            }
            if($caracter == ")"){
                $parentesisCi++;
            }
        }
        if($parentesisCi == $parentesisAp){
            return "<p>La expresión está equilibrada.</p>";
        }else{
            return "<p>La expresión no está equilibrada.</p>";
        }
        
    }

    if(isset($_POST['enviar'])){
        $lSumaRecursiva = true;
    }

    if(isset($_POST['enviar21'])){
        $elementoTemp = limpiarDatos($_POST['elem']);
        $_SESSION['cola']->anadirElemento(limpiarDatos($_POST['elem']));
    }

    if(isset($_POST['enviar22'])){
        $_SESSION['cola']->avanzarCola();
    }

    if(isset($_POST['enviar3'])){
        $expresionTemp = limpiarDatos($_POST['expresion']);
        $resExpresion = encuentraParentesis(limpiarDatos($_POST['expresion']));
        $lExpresion = true;
    }

    
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Ejercicios Basicos</title>
    <?php
        echo "<br><a href=\"https://github.com/rnicar245/EntornoServidor/tree/master/EjerciciosBasicosResumen2\">Github</a>";
        echo "<form action= ".htmlspecialchars($_SERVER["PHP_SELF"])." method= \"POST\">";
        echo "<h2>Suma recursiva</h2>";
        echo "<table border=\"1\">";
        echo "<caption>Suma recursiva:</caption>";
        for($i = 0; $i < 3; $i++){
            echo "<tr>";
            for($j = 0; $j < 3; $j++){
                if(isset($_POST['enviar'])){
                    echo "<td><input type=\"number\" name=\"valores[$i][$j]\" value=\"".$_POST['valores'][$i][$j]."\" required></td>";
                }else{
                    echo "<td><input type=\"number\" name=\"valores[$i][$j]\" value=\"\" required></td>";
                }
                
            }
            echo"</tr>";
        }
        echo "</table>";
        echo "<input type=\"submit\" value=\"Enviar\" name=\"enviar\"/>";
        echo "</form>";
        if($lSumaRecursiva){
            sumaRecursiva(0, $_POST['valores']);
        }
        echo "<form action= ".htmlspecialchars($_SERVER["PHP_SELF"])." method= \"POST\">";
        echo "<h2>Cola</h2>";
        echo "<a href=\"cerrar.php\">Reiniciar</a>";
        echo "<p>Añadir elemento a la cola:</p>";
        echo "<input type=\"text\" name=\"elem\" value=\"".$elementoTemp."\"><br>";
        echo "<input type=\"submit\" name=\"enviar21\" value=\"Enviar\"><br><br>";
        echo "</form>";
        echo "<form action= ".htmlspecialchars($_SERVER["PHP_SELF"])." method= \"POST\">";
        echo "<input type=\"submit\" name=\"enviar22\" value=\"Avanzar la cola\"><br><br>";
        echo "</form>";
        if($_SESSION['cola']->getCola() == array()){
            echo "<p>La cola está vacía.</p>";
        }else{
            $cola = $_SESSION['cola']->getCola();
            foreach($cola as $elemento){
                echo "<p>".$elemento."</p>";
            }
        }

        echo "<form action= ".htmlspecialchars($_SERVER["PHP_SELF"])." method= \"POST\">";
        echo "<h2>Parentesis</h2>";
        echo "<p>Escribe una expresión matemática:</p>";
        echo "<input type=\"text\" name=\"expresion\" value=\"".$expresionTemp."\"><br>";
        echo "<input type=\"submit\" name=\"enviar3\" value=\"Enviar\"><br><br>";
        echo "</form>";
        if($lExpresion){
            echo $resExpresion;
        }
        
    ?>
    
</head>
<body>
</body>
</html>
