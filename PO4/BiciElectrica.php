<?php

class BiciElectrica {
    private $id;
    private $coordx;
    private $coordy;
    private $bateria;
    private $operativa;

    public function __construct($id, $coordx, $coordy, $bateria, $operativa) {
        $this->id = $id;
        $this->coordx = $coordx;
        $this->coordy = $coordy;
        $this->bateria = $bateria;
        $this->operativa = $operativa;
    }

    public function __get($name) {
        return $this->$name;
    }

    public function __set($name, $value) {
        $this->$name = $value;
    }

    public function __toString() {
        return "Bici ID: {$this->id}, Batería: {$this->bateria}%";
    }

    public function distancia($x, $y) {
        return sqrt(pow($this->coordx - $x, 2) + pow($this->coordy - $y, 2));
    }
}