<?php
class Juego{
    private $_puzzles;
    private $_puzzleCorrecto;
    private $_puzzleMostrado;
    private $_idMostrado;
    private $_hasGanado = false;

    public function __construct(){
        $this->_puzzles = array();
    }

    public function anadirPuzzle($puzzle){
        array_push($this->_puzzles, $puzzle);
    }

    public function getPuzzles(){
        return $this->_puzzles;
    }

    public function getPuzzleMostrado(){
        return $this->_puzzleMostrado;
    }

    public function iniciarJuego(){
        $_SESSION['prueba']++;
        shuffle($this->_puzzles);

        $this->_puzzleCorrecto = $this->_puzzles[rand(0 , 4)];

        do{
            $this->_puzzleMostrado = array();
            $ids = array();
            for($i = 0; $i < 3; $i++){
                $id = rand(0,4);
                array_push($ids, $id);
                array_push($this->_puzzleMostrado, $this->_puzzles[$id][$i]);
            }
        }while($ids[0] == $ids[1] or $ids[0] == $ids[2] or $ids[1] == $ids[2]);
        $this->_idMostrado = $ids;
    }

    public function subir($seccion){
        $this->_idMostrado[$seccion]++;
        if($this->_idMostrado[$seccion] == 5){
            $this->_idMostrado[$seccion] = 0;
        }
        $this->_puzzleMostrado[$seccion] = $this->_puzzles[$this->_idMostrado[$seccion]][$seccion];
        $this->comprobarIntento();
    }

    public function bajar($seccion){
        $this->_idMostrado[$seccion]--;
        if($this->_idMostrado[$seccion] == -1){
            $this->_idMostrado[$seccion] = 4;
        }
        $this->_puzzleMostrado[$seccion] = $this->_puzzles[$this->_idMostrado[$seccion]][$seccion];
    }

    public function comprobarIntento(){
        if(array_diff($this->_puzzleMostrado, $this->_puzzleCorrecto) == array()){
            $this->_hasGanado = true;
        }
    }

    public function pintarJuego(){
        if($this->_hasGanado){
            echo "<h2>¡Enhorabuena, has ganado!</h2>";
        }else{
            echo "</br><form action= ".htmlspecialchars($_SERVER["PHP_SELF"])." method= \"POST\">";
        }
        echo "<table border=\"1\">";
        echo "<caption>Encuentra la combinación</caption>";
        echo "<tr><td align=\"center\" valign=\"center\"><input type=\"submit\" value=\"▲\" name=\"0\"/></td><td align=\"center\" valign=\"center\"><input type=\"submit\" value=\"▲\" name=\"1\"/></td><td align=\"center\" valign=\"center\"><input type=\"submit\" value=\"▲\" name=\"2\"/></td></tr>";
        echo "<tr>";
        for($i = 0; $i <3; $i++){

            echo "<td><img width=\"100px\" heigth=\"100px\" src=\"".$this->_puzzleMostrado[$i]."\"></img></td>";
        }
        echo "</tr>";
        echo "<tr><td align=\"center\" valign=\"center\"><input type=\"submit\" value=\"▼\" name=\"0\"/></td><td align=\"center\" valign=\"center\"><input type=\"submit\" value=\"▼\" name=\"1\"/></td><td align=\"center\" valign=\"center\"><input type=\"submit\" value=\"▼\" name=\"2\"/></td></tr>";
        echo "</table>";

        echo "<table border=\"1\">";
        echo "<caption>Combinación correcta</caption>";
        echo "<tr>";
        for($i = 0; $i <3; $i++){
            echo "<td><img width=\"100px\" heigth=\"100px\" src=\"".$this->_puzzleCorrecto[$i]."\"></img></td>";
        }
        echo "</tr>";
        echo "</table>";
        echo "</form>";
        
    }
}