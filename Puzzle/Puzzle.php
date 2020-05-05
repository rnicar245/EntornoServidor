<?php
class Puzzle{
    private $_id;
    private $_piezas;

    public function __construct($piezas){
        $this->_id = $_SESSION['id']++;
        $this->_piezas = $piezas;
    }

    public function getPiezas(){
        return $this->_piezas;
    }

    public function getId(){
        return $this->_id;
    }
}
?>