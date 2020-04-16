<?php
class Carta{
    private $_numero;
    private $_palo;
    private $_puntos;
    private $_imagen;

    public function __construct($numero, $palo, $puntos, $ruta){
        $this->_numero = $numero;
        $this->_palo = $palo;
        $this->_puntos = $puntos;
        $this->_imagen = $ruta;
        
    }

    public function getPalo(){
        return $this->_palo;
    }

    public function getNumero(){
        return $this->_numero;
    }

    public function getPuntuacion(){
        return $this->_puntos;
    }

    public function getImagen(){
        return $this->_imagen;
    }
}