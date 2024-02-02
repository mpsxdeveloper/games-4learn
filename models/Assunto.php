<?php

class Assunto implements JsonSerializable {

    private $id;
    private $materia;    

    public function __construct() {
    }

    public function jsonSerialize() : mixed {
        $vars = get_object_vars($this);
        return $vars;
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getMateria() {
        return $this->materia;
    }

    public function setMateria($materia) {
        $this->materia = $materia;
    }

}
