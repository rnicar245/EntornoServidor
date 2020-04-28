<?php
    session_start();

    if (!isset($_SESSION['aut'])){
        $_SESSION['aut'] = false;
        $_SESSION['user'] = 'Invitado';
        $_SESSION['rol'] = "invitado";
        $_SESSION['usuarioCreado'] = false;
    }

    $lError = false;

    function limpiarDatos($dato){
        $dato = trim($dato);
        $dato = stripslashes($dato);
        $dato = htmlspecialchars($dato);
        return $dato;
    }

    if(isset($_POST['enviar'])){
        if(limpiarDatos($_POST['user']) == "admin" and limpiarDatos($_POST['pass']) == "admin"){
            $_SESSION['aut'] = true;
            $_SESSION['user'] = 'admin';
            $_SESSION['rol'] = "admin";
        }else{
            $file = fopen("usuarios.txt", "r") or exit("No se ha podido abrir el archivo.");
            do{
                $linea = explode(" ", fgets($file));
                if(limpiarDatos($_POST['user']) == trim($linea[0]) and limpiarDatos($_POST['pass']) == trim($linea[1])){
                    $_SESSION['aut'] = true;
                    $_SESSION['user'] = $linea[0];
                    $_SESSION['rol'] = "usuario";
                }else{
                    $lError = true;
                }
    
            }while(!feof($file));
            fclose($file);
        }
    }

    if(isset($_POST['anadir'])){
        $file = fopen("usuarios.txt", "r+") or exit("No se ha podido abrir el archivo.");
        $_SESSION['usuarioCreado'] = true;
        do{
            $linea = explode(" ", fgets($file));
            if(limpiarDatos($_POST['userAdd']) == $linea[0]){
                $_SESSION['usuarioCreado'] = false;  
            }
        }while(!feof($file));
        $linea = fgets($file);

        if($_SESSION['usuarioCreado']){
            fwrite($file, limpiarDatos($_POST['userAdd'])." ".limpiarDatos($_POST['passAdd'])."".PHP_EOL);
        }
        fclose($file);
    }
?>
<html>
<head>
    <meta charset="utf-8">
    <title>Autentificacion de usuarios</title>
</head>
<body>

<?php
    echo "<br><a href=\"https://github.com/rnicar245/EntornoServidor/tree/master/AutBasicoUsuarios\">Github</a>";
    if(!$_SESSION['aut']){
        echo "<h1>Login</h1>";
        echo "<form action= ".htmlspecialchars($_SERVER["PHP_SELF"])." method= \"POST\">";
        echo "Usuario: ";
        echo "<input type=\"text\" name=\"user\" value=\"\"><br>";
        echo "</br>";
        echo "Contraseña: ";
        echo "<input type=\"text\" name=\"pass\" value=\"\"><br>";
        echo "<br><input type=\"submit\" name=\"enviar\" value=\"Enviar\">";
        echo "</form>";
        if($lError){
            echo "Las credenciales son incorrectas.";
        }
    }else{
        echo "<br><a href=\"cerrar.php\">Salir</a>";
        if($_SESSION['rol'] == "admin"){
            echo "<h1>Añadir Usuarios</h1>";
            echo "<form action= ".htmlspecialchars($_SERVER["PHP_SELF"])." method= \"POST\">";
            echo "Usuario: ";
            echo "<input type=\"text\" name=\"userAdd\" value=\"\"><br>";
            echo "</br>";
            echo "Contraseña: ";
            echo "<input type=\"text\" name=\"passAdd\" value=\"\"><br>";
            echo "<br><input type=\"submit\" name=\"anadir\" value=\"Añadir Usuario\">";
            echo "</form>";
            if($_SESSION['usuarioCreado']){
                echo "Usuario creado con éxito.";
            }
        }else{
            header('Location: privado.php');
        }
    }
    
?>


</body>
</html>