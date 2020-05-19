<?php
class Cola{
    private $_cola;
    private $_pointer;


    public function __construct(){
        $this->_cola = array();
    }

    public function anadirElemento($elemento){
        array_push($this->_cola, $elemento);
    }

    public function getCola(){
        return $this->_cola;   
    }

    public function avanzarCola(){
        if($this->_cola != array()){
            array_shift($this->_cola);
        }
    }

}