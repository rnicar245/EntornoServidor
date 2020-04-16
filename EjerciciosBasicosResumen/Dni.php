<?php
class Dni{
    private $_numero;
    private $_letra;
    private $_mensaje;

    public function __construct($dni){
        preg_match_all("/([0-9]{8})([A-Z])/i", $dni, $captura);

        if(!$captura[1] == array() or !$captura[2] == array()){
            $this->_numero = $captura[1][0];
            $this->_letra = $captura[2][0];
        }
        
        $this->_mensaje = $this->validaDni($this->_numero, $this->_letra);
        
        
    }

    private function validaDni($numero, $letra){
        $arrayLetras = str_split("TRWAGMYFPDXBNJZSQVHLCKE");
        if($arrayLetras[$numero%23] == $letra){
            return "El dni es correcto.";
        }else{
            return "El dni es incorrecto.";
        }
    }

    public function getMensaje(){
        return $this->_mensaje;
    }
}