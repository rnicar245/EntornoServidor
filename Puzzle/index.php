<?php
    include "Juego.php";
    session_start();
    
    $juego = new Juego();
    $arrayImagenes = array("arana", "avispa", "caracol", "hormiga", "oruga");

    foreach($arrayImagenes as $nombreImagen){
        $arrayRutas = array();
        for($i = 1; $i <= 3; $i++){
            array_push($arrayRutas, "./img/puz_".$nombreImagen."_".$i.".PNG");
        }
        
        $juego->anadirPuzzle($arrayRutas);
    }

    if (!isset($_SESSION['juego'])){
        $_SESSION['juego'] = $juego;
    }

    if(isset($_POST['0']) or isset($_POST['1']) or isset($_POST['2'])){
        foreach($_POST as $clave => $valor){
            if($valor == "▲"){
                $_SESSION['juego']->subir($clave);
            }else{
                $_SESSION['juego']->bajar($clave);
            }
        }
    }
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <link href="css.css" rel="stylesheet" type="text/css">
    <title>Puzzles</title>
</head>
<body>
    <?php
    if(!isset($_SESSION['comenzado'])){
        $_SESSION['comenzado'] = true;
        $_SESSION['prueba'] =0;
        $_SESSION['juego']->iniciarJuego();
    }
        echo "<br><a href=\"cerrar.php\">Reiniciar</a>";
        $_SESSION['juego']->pintarJuego();
    
    ?>
</body>
</html>