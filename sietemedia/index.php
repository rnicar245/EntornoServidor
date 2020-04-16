<?php
    include "Carta.php";
    session_start();

    if (!isset($_SESSION['puntuacionJugador'])){
        $_SESSION['puntuacionJugador'] = 0;
        $_SESSION['indice'] = 0;
        $_SESSION['plantado'] = false;
        $_SESSION['mensaje'] = "";
    }

    $puntuacionIA = 0;
    $baraja = array();
    $lCogerCarta = false;
    $carta = 0;

    function generarPalo($palo){
        switch($palo){
            case 1:
                return "oros";
                break;
            case 2:
                return "bastos";
                break;
            case 3:
                return "espadas";
                break;
            case 4:
                return "copas";
                break;
        }
    }

    function generarNumero($numero){
        switch($numero){
            case 8:
                return "Sota";
                break;
            case 9:
                return "Caballo"; 
                break;
            case 10:
                return "Rey";
                break;   
        }
        return $numero;
    }

    function jugadaIA($puntuacionIA){
        do{
            $carta = cogerCarta();
            $puntuacionIA += $carta->getPuntuacion();
        }while($puntuacionIA <= 5);
        return $puntuacionIA;
    }

    function cogerCarta(){
        $carta = $_SESSION['baraja'][$_SESSION['indice']];
        $_SESSION['indice']++;
        return $carta;

    }

    function plantarse($puntuacionIA){
        $_SESSION['plantado'] = true;
        $puntuacionIA = jugadaIA($puntuacionIA);
        if($_SESSION['puntuacionJugador'] > 7.5){
            if($puntuacionIA > 7.5){
                $_SESSION['mensaje'] = "Ambos jugadores han perdido...";
            }else{
                $_SESSION['mensaje'] = "Ha ganado la IA. ¡Suerte para la próxima!";
            }
        }else if($puntuacionIA > 7.5){
            $_SESSION['mensaje'] = "¡Enhorabuena, has ganado!";
        }else if($puntuacionIA > $_SESSION['puntuacionJugador']){
            $_SESSION['mensaje'] = "Ha ganado la IA. ¡Suerte para la próxima!";
        }else if($puntuacionIA < $_SESSION['puntuacionJugador']){
            $_SESSION['mensaje'] = "¡Enhorabuena, has ganado!";
        }else{
            $_SESSION['mensaje'] = "¡Ha habido un empate!";
        }
        return $puntuacionIA;
        
    }

    if (!isset($_SESSION['baraja'])){
    for($i = 0; $i < 40; $i++){
        do{
            $repetido = false;
            $palo = generarPalo(rand(1,4));
            $numero = generarNumero(rand(1, 10));
            $puntuacion = 0;

            if(!is_numeric($numero)){
                $puntuacion = 0.5;
            }else{
                $puntuacion = $numero;
            }

            $carta = new Carta($numero, $palo, $puntuacion);

            foreach($baraja as $cartaBaraja){
                    if(compararCartas($carta, $cartaBaraja)){
                        $repetido = true;
                    }
            }
            
        }while($repetido);

        array_push($baraja, $carta);
    }

    $_SESSION['baraja'] = $baraja;
    }
    function compararCartas($carta1, $carta2){
        if($carta1->getNumero() == $carta2->getNumero() and $carta1->getPalo() == $carta2->getPalo()){
            return true;
        }
        return false;
    }

    if(isset($_POST['cogerCarta'])){
        if(!$_SESSION['plantado']){
            $carta = cogerCarta();
            $_SESSION['puntuacionJugador'] += $carta->getPuntuacion();
            $lCogerCarta = true;
            
            if($_SESSION['puntuacionJugador']>7.5){
                $puntuacionIA = plantarse($puntuacionIA);
            }
        }
        
    }

    if(isset($_POST['plantar'])){
        if(!$_SESSION['plantado']){
            $puntuacionIA = plantarse($puntuacionIA);
        }
    }

    
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Siete y media</title>
    <?php
        echo "<br><a href=\"cerrar.php\">Reiniciar</a>";
        echo "<form action= ".htmlspecialchars($_SERVER["PHP_SELF"])." method= \"POST\">";
        echo "Tu puntuación es: ".$_SESSION['puntuacionJugador']."<br>";
        if($lCogerCarta){
            echo "<br>Has cogido ".$carta->getNumero()." de ".$carta->getPalo().".<br>";
        }
        if($_SESSION['plantado']){
            echo"<table border=1>";
            echo "<caption>Resultados</caption>";
            echo "<tr><td>Jugador</td><td>IA</td></tr>";
            echo "<td>".$_SESSION["puntuacionJugador"]."</td><td>".$puntuacionIA."</td>";
            echo "</table>";
            echo $_SESSION['mensaje']."<br>";
        }
        echo "<input type=\"submit\" name=\"cogerCarta\" value=\"Coger Carta\">";
        echo "<input type=\"submit\" name=\"plantar\" value=\"Plantarse\">";
        echo "</form>";
    ?>
    
</head>
<body>
</body>
</html>