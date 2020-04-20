<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Tablas de multiplicar</title>
    <link href="index.css" rel="stylesheet" type="text/css">
</head>
<body>
    <?php
        session_start();

        function limpiarDatos($dato){
            $dato = trim($dato);
            $dato = stripslashes($dato);
            $dato = htmlspecialchars($dato);
            return $dato;
        }

        if (!isset($_SESSION['arrayTablas'])){
            $_SESSION['arrayTablas'] = array();
            $_SESSION['lcomenzar'] = false;
        }
        $contador = 0;
        $contadorAciertos = 0;
        $contadorFallos = 0;
        $operacion;
        $lformulario = false;
        $arrayTablas = array();

        if (isset($_POST['enviar'])){
            $arrayRes = array();
            foreach($_POST as $array => $valor){
                if(strlen($array)>2){
                    array_push($arrayRes, $valor);
                } 
            }
            $_SESSION['arrayRes'] = $arrayRes;
            $lformulario = true;
        }
    
        if (isset($_POST['comenzar'])){
            foreach($_POST as $array => $valor){
                if($array != "comenzar" and (strlen($array) == 1 or $valor == 10)){
                    array_push($arrayTablas, limpiarDatos($valor));
                    $_SESSION['lcomenzar'] = true;
                }
            }
            $_SESSION['arrayTablas'] = $arrayTablas;
            
            $arrayPreguntas = array();
            $cantidad = 10;
            if(isset($_POST['cantidad'])){
                if($_POST['cantidad'] >=1 and $_POST['cantidad'] <=10){
                    echo "saiohfsdahfsdauifsdjafsda";
                    $cantidad = limpiarDatos($_POST['cantidad']);
                }
            }
            
            $cantidad--;
            array_push($arrayPreguntas, rand(1, 10));
            
            for($i = 1; $i <= $cantidad; $i++){
                $rand = 0;
                do{
                    $noEncontrado = false;
                    $rand = rand(1,10);
                    foreach($arrayPreguntas as $pregunta){
                        if($rand == $pregunta){
                            $noEncontrado = true;
                        }
                    }
                }while($noEncontrado); 
                array_push($arrayPreguntas, $rand);
            }

            $_SESSION['preguntas'] = $arrayPreguntas;
            
        }
        echo "<br><a href=\"cerrar.php\">Reiniciar</a><br>";
        echo "<caption>Elige las tablas:</caption>";
        echo "</br><form action= ".htmlspecialchars($_SERVER["PHP_SELF"])." method= \"POST\">";
            for ($i=1; $i <=10 ; $i++) {
                echo "<input type=\"checkbox\" name=\"".$i."\" value=\"".$i."\">".$i."</input>";
            }
        echo "<p>¿Cuántas preguntas quieres?</p>";
        echo "<input type=\"number\" name=\"cantidad\" value=\"\">";
        echo "<br><input type=\"submit\" value=\"Comenzar\" name=\"comenzar\"/>";
        echo "</form>";
       
        if($_SESSION['lcomenzar']){
            echo "</br><form action= ".htmlspecialchars($_SERVER["PHP_SELF"])." method= \"POST\">";
            echo "<table border=\"1\">";
            echo "<caption>Tablas de multiplicar:</caption>";
            echo "<tr><td></td>";
            for($i = 1; $i <=10; $i++){
                echo "<td>".$i."</td>";
            }
            echo "</tr>";
            for ($i=1; $i <=10 ; $i++) {
                foreach($_SESSION['arrayTablas'] as $tablas){
                    if($i == $tablas){
                        echo "<tr style=\"background-color:rgb(232, 232, 232)\">";
                        echo "<td>Tabla del ".$i."</td>";
                        for ($j=1; $j <=10 ; $j++) {
                            $encontrado = false;
                            foreach($_SESSION['preguntas'] as $preguntas){
                                if($j == $preguntas){
                                    $encontrado = true;   
                                }
                            }

                            if($encontrado){
                                if (isset($_POST[$i.",".$j])){
                                    echo "<td><input type=\"text\" name=\"".$i.",".$j."\" value=\"".$_POST[$i.",".$j]."\"></td>";
                                }else{
                                    echo "<td><input type=\"text\" name=\"".$i.",".$j."\" value=\"\"></td>";
                                }
                            }else{
                                echo "<td style=\"background-color:gray;color:gray\">....</td>";
                            }
                        }
                        echo "</tr>";
                    }
                }
            }  
            echo "</table>";
            echo "<input type=\"submit\" value=\"Enviar\" name=\"enviar\"/>";
            echo "</form>";
        }
        if($lformulario){
            $contador = 0;
            echo "<table border=\"1\">";
            echo "<caption>Resultados:</caption>";
            echo "<tr><td></td>";
            for($i = 1; $i <=10; $i++){
                echo "<td>".$i."</td>";
            }
            echo "</tr>";
            for ($i=1; $i <=10 ; $i++) {
                foreach($_SESSION['arrayTablas'] as $tablas){
                    if($i == $tablas){
                        echo "<tr style=\"background-color:rgb(232, 232, 232)\">";
                        echo "<td>Tabla del ".$i."</td>";
                        for ($j=1; $j <=10 ; $j++) {
                            $encontrado = false;
                            foreach($_SESSION['preguntas'] as $preguntas){
                                if($j == $preguntas){
                                    $encontrado = true;   
                                }
                            }
                            if($encontrado){
                                $operacion = $j*$i;
                                if($_SESSION['arrayRes'][$contador] == $operacion){
                                    echo "<td style=\"background-color:lightgreen\">".$operacion."</td>";
                                    $contadorAciertos++;
                                }else{
                                    echo "<td style=\"background-color:LIGHTCORAL\">".$operacion."</td>";
                                    $contadorFallos++;
                                }
                                $contador ++;
                            }else{
                                echo "<td style=\"background-color:gray;color:gray\">....</td>";
                            } 
                        }
                        echo "</tr>";
                    }
                }
            }  
            echo "</table>";
            echo "<p>Has acertado ".$contadorAciertos." y has fallado ".$contadorFallos."</p>";
            
        }
        ?>
        
        
</body>
</html>
