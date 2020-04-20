<?php
class Tablero{
    private $_ancho;
    private $_alto;
    private $_numBarcos = 10;
    private $_barcos = array();
    private $_tiposLibres = array(1,2,3,4);
    private $_tablero = array();
    private $_hundidos;

    public function __construct($ancho, $alto){
        $this->_ancho = $ancho-1;
        $this->_alto = $alto-1;
        $this->crearTablero($this->_ancho, $this->_alto);
        $this->_hundidos = $this->_numBarcos;
    }

    public function getTipoLibre(){
        $tipo = 0;
        do{
            $tipo = rand(0,3);
        }while($this->_tiposLibres[$tipo] == 0);

        return $tipo+1;
    }

    public function insertarBarco($barco){
        if(!$this->compruebaLimites($barco) or !$this->compruebaHitbox($barco)){
            return false;
        }
        array_push($this->_barcos, $barco);
        $this->_numBarcos--;
        $this->_tiposLibres[$barco->getTipo()-1]--;
        return true;
        
    }

    private function compruebaLimites($barco){
        $valido = true;
        foreach($barco->getUnidades() as $coordenadas){
            if($coordenadas[0] <0 or $coordenadas[0]>$this->_ancho or $coordenadas[1] <0 or $coordenadas[1] > $this->_alto){
                $valido = false;
            }
        }

        return $valido;
    }

    private function compruebaHitbox($barco){
        $valido = true;
        foreach($barco->getUnidades() as $coordenadas){
            foreach($this->_barcos as $barco2){
                foreach($barco2->getHitbox() as $coordenadas2){
                    if($coordenadas == $coordenadas2){
                        $valido = false;
                    }
                }
            }
        }

        return $valido;
    }

    private function crearTablero($ancho, $alto){
        for($i = 0; $i<=$ancho; $i++){
            array_push($this->_tablero, array());
            for($j=0; $j<=$alto; $j++){
                array_push($this->_tablero[$i], 0);
            }
        }
    }

    public function imprimirTablero(){
        $this->insertarBarcosEnTablero();
        echo "</br><form action= ".htmlspecialchars($_SERVER["PHP_SELF"])." method= \"POST\">";
        echo"<table border=1>";
        echo "<caption>Tablero</caption>";
        echo "<tr><td>x\y</td>";
        for($i = 0; $i <=$this->_ancho; $i++){
            echo "<td>".$i."</td>";
        }
        echo "</tr>";
        
        for($i = 0; $i<=$this->_ancho; $i++){
            echo "<tr>";
            echo "<td>".$i."</td>";
            for($j=0; $j<=$this->_alto; $j++){
                if($this->_tablero[$i][$j] === "*"){
                    echo "<td><input style=\"color:red;border:none;background-color:red;cursor:pointer\"type=\"submit\" name=\"".$i.",".$j."\" value=\"".$this->_tablero[$i][$j]."\"></td>";
                }else if($this->_tablero[$i][$j] != 0){
                    echo "<td><input style=\"color:red;border:none;background-color:white;cursor:pointer\"type=\"submit\" name=\"".$i.",".$j."\" value=\"".$this->_tablero[$i][$j]."\"></td>";
                }else{
                    echo "<td><input style=\"border:none;background-color:white;cursor:pointer\"type=\"submit\" name=\"".$i.",".$j."\" value=\"".$this->_tablero[$i][$j]."\"></td>";
                }
            }
            echo "</tr>";
        }
        echo "</table>"; 
        echo "</form>";
    }

    public function comprobarCoordenadas($x, $y){
        $mensaje = "";
        if($this->_hundidos <=0){
            $mensaje = "¡Has ganado!";
        }else if($x <0 or $x>$this->_ancho or $y <0 or $y > $this->_alto){
            $mensaje = "Coordenadas inválidas.";
        }else if($this->_tablero[$x][$y] > 0){
            $contador = 0;
            $hundido = false;
            foreach($this->_barcos as $barco){
                foreach($barco->getUnidades() as $coordenadas){
                    if($coordenadas[0] == $x and $coordenadas[1] == $y){
                        $hundido = true;
                        $barco->setUnidades($x, $y, -1);
                        $this->insertarBarcosEnTablero();
                        foreach($this->_barcos[$contador]->getUnidades() as $coordenadas2){
                            if(count($coordenadas2) != 3){
                                $hundido = false;
                            }
                        }
                    }
                }
                $contador++;
            }
            if($hundido){
                $mensaje = "Hundido";
                $this->_hundidos--;
            }else{
                $mensaje = "Tocado";
            }
        }else {
            $mensaje = "Agua";
        }

        if($this->_hundidos <=0){
            $mensaje = "¡Has ganado!";
        }
        return $mensaje;
    }

    private function insertarBarcosEnTablero(){
        foreach($this->_barcos as $barco){
            foreach($barco->getUnidades() as $coordenadas){
                if(count($coordenadas) == 3){
                    $this->_tablero[$coordenadas[0]][$coordenadas[1]] = "*";
                }else{
                    $this->_tablero[$coordenadas[0]][$coordenadas[1]] = $barco->getTipo();
                }
            }
        }
    }

    public function getAncho(){
        return $this->_ancho;
    }

    public function getAlto(){
        return $this->_alto;
    }

    public function getNumBarcos(){
        return $this->_numBarcos;
    }

    public function getBarcos(){
        return $this->_barcos;
    }

}