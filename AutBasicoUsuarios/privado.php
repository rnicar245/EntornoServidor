

<?php
session_start();
if($_SESSION['rol'] != "usuario"){
    header('Location: index.php');
}
echo "<br><a href=\"cerrar.php\">Salir</a><br>";
?>
Lado oculto de la luna.