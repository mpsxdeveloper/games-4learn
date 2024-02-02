<?php

class Conquista implements JsonSerializable {

    private $id;
    private $tipo;
    private $data_conquista;
    private $prova_id;
    private $usuario_id;

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

    public function getTipo() {
        return $this->tipo;
    }

    public function setTipo($tipo) {
        $this->tipo = $tipo;
    }

    public function getData_conquista() {
        return $this->data_conquista;
    }

    public function setData_conquista($data_conquista) {
        $this->data_conquista = $data_conquista;
    }

    public function getProva_id() {
        return $this->prova_id;
    }

    public function setProva_id($prova_id) {
        $this->prova_id = $prova_id;
    }

    public function getUsuario_id() {
        return $this->usuario_id;
    }

    public function setUsuario_id($usuario_id) {
        $this->usuario_id = $usuario_id;
    }

}