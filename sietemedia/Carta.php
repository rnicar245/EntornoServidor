<?php
class Carta{
    public $_numero;
    public $_palo;
    public $_puntos;
    //private $_imagen;

    public function __construct($numero, $palo, $puntos){
        $this->_numero = $numero;
        $this->_palo = $palo;
        $this->_puntos = $puntos;
        //$this->_imagen = $puntos;
        
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
}