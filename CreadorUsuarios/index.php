<?php
    

    if(isset($_FILES['file'])){
        move_uploaded_file($_FILES['file']['tmp_name'], 'fic/'.$_FILES['file']['name']);
        $file = fopen("fic/".$_FILES['file']['name'], "r+") or exit("No se ha podido abrir el archivo.");
        $contador = 0;
        $arrayUsuarios = array();
        $nuevoTexto = "";
        do{
            $array = explode(" ", str_replace(array("Á", "É", "Í", "Ó", "Ú", "á", "é", "í", "ó", "ú"), array("a", "e", "i", "o", "u" ,"a", "e", "i" ,"o", "u"), strtolower(fgets($file))));
            if($contador >= 9){
                
                $apellido1 = substr($array[0], 0, 2);
                $apellido2 = substr($array[1], 0, 2);
                $nombre = substr($array[2], 0, 1);
                $cadena = $apellido1."".$apellido2."".$nombre;

                foreach($arrayUsuarios as $array){
                    foreach($array as $elemento){    
                        if($elemento === $cadena){
                            $indice = array_search($array, $arrayUsuarios);
                            $arrayUsuarios[$indice][1]++;
                            $cadena = $cadena."".$arrayUsuarios[$indice][1];                     
                        }
                    }
                }

                if($_POST['formato'] == "linux"){
                    $nuevoTexto = $nuevoTexto."useradd ".$cadena."\n";
                }else{
                    $nuevoTexto = $nuevoTexto."CREATE USER \'".$cadena."\'@\'localhost\' IDENTIFIED BY \'1234\';\nGRANT ALL PRIVILEGES ON * . * TO \'".$cadena."\'@\'localhost\';\n";
                }

                array_push($arrayUsuarios, array($cadena, 0));
            }
            $contador++;
        }while(!feof($file));
        file_put_contents('fic/'.$_FILES['file']['name'], $nuevoTexto);
        fclose($file);
        echo "Archivo creado con éxito en fic/".$_FILES['file']['name'];
        
    }


?>
<html>
<head>
    <meta charset="utf-8">
    <title>Autentificacion con ficheros</title>
</head>
<body>

<?php
    echo "<form action= ".htmlspecialchars($_SERVER["PHP_SELF"])." method= \"POST\" enctype=\"multipart/form-data\">";
    echo "Suba su fichero:<br> ";
    echo "<input type=\"FILE\" name=\"file\"><br>";
    echo "</br>";
    echo "Elija su formato:<br> ";
    echo "<select id=\"formato\" name=\"formato\">";
    echo "<option value=\"linux\">Linux</option>";
    echo "<option value=\"sql\">SQL</option>";
    echo "</select>";
    echo "<br><br><input type=\"submit\" name=\"enviar\" value=\"Enviar\">";
    echo "</form>";
?>

</body>
</html>