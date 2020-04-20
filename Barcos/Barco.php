<?php
class Barco{
    private $_unidades;
    private $_direccion;
    private $_tipo;
    private $_hitbox;

    public function __construct($coordenadas, $direccion, $tipo){
        $this->_direccion = $direccion;
        $this->_tipo = $tipo;
        $this->_unidades = $this->calculaUnidades($coordenadas, $direccion, $tipo);
        $this->_hitbox = $this->calculaHitbox($this->_unidades);
    }

    private function calculaUnidades($coordenadas, $direccion, $tipo){
        $unidades = array();
        array_push($unidades, $coordenadas);
        while($tipo>1){
            switch($direccion){
                case 0:
                    //Norte
                    $coordenadas[1]--;
                    break;
                case 1:
                    //Este
                    $coordenadas[0]++;
                    break;
                case 2:
                    //Sur
                    $coordenadas[1]++;
                    break;
                case 3:
                    //Oeste
                    $coordenadas[0]--;
                    break;
            }
            array_push($unidades, $coordenadas);
            $tipo--;
        }
        return $unidades; 
    }

    private function calculaHitbox($unidades){
        $hitbox = array();
        $x = array();
        $y = array();
        foreach($unidades as $coordenadas){
            array_push($x, $coordenadas[0]);
            array_push($y, $coordenadas[1]);
        }

        for($i = min($x)-1; $i<=max($x)+1; $i++){
            for($j = min($y)-1; $j<=max($y)+1; $j++){
                array_push($hitbox, array($i, $j));
            }
        }
        return $hitbox;
    }

    public function getUnidades(){
        return $this->_unidades;
    }

    public function getTipo(){
        return $this->_tipo;
    }

    public function getPuntuacion(){
        return $this->_puntos;
    }

    public function getHitbox(){
        return $this->_hitbox;
    }

    public function setUnidades($x, $y, $valor){
        $contador = 0;
        foreach($this->_unidades as $coordenadas){
            if($coordenadas[0] == $x and $coordenadas[1] == $y){
                array_push($coordenadas, -1);
                $this->_unidades[$contador] = $coordenadas;
            }
            $contador++;
        }
    }
}