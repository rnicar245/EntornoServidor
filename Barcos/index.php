<?php
    include "Barco.php";
    include "Tablero.php";
    session_start();

    $lComprobar = true;
    $tablero = new Tablero(15, 15);

    do{
        $valido = true;
        do{
            $barco = new Barco(array(rand(0, $tablero->getAncho()), rand(0, $tablero->getAlto())), rand(0, 3), $tablero->getTipoLibre());
            $valido = $tablero->insertarBarco($barco);
        }while(!$valido);
    }while($tablero->getNumBarcos() > 0);

    if (!isset($_SESSION['tablero'])){
        $_SESSION['tablero'] = $tablero;
        $_SESSION['mensaje'] = "";
    }

    if(isset($_POST)){
        $lComprobar = true;
        foreach($_POST as $clave => $valor){
            $clave = explode(",", $clave);
            $_SESSION['mensaje'] = $_SESSION['tablero']->comprobarCoordenadas($clave[0],$clave[1]);
        }
        
    }
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <link href="index.css" rel="stylesheet" type="text/css">
    <title>Barcos</title>
</head>
<body>
    <?php
    echo "<br><a href=\"cerrar.php\">Reiniciar</a>";
        if($lComprobar){
            $_SESSION['tablero']->imprimirTablero();
            echo $_SESSION['mensaje'];
            
        }
    ?>
</body>
</html>
