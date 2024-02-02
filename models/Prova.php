<?php

class Prova implements JsonSerializable {

    private $id;
    private $descricao;
    private $ano;
    private $cargo_id;
    private $assunto_id;

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

    public function getDescricao() {
        return $this->descricao;
    }

    public function setDescricao($descricao) {
        $this->descricao = $descricao;
    }

    public function getAno() {
        return $this->ano;
    }

    public function setAno($ano) {
        $this->ano = $ano;
    }

    public function getCargo_id() {
        return $this->cargo_id;
    }

    public function setCargo_id($cargo_id) {
        $this->cargo_id = $cargo_id;
    }

    public function getAssunto_id() {
        return $this->assunto_id;
    }

    public function setAssunto_id($assunto_id) {
        $this->assunto_id = $assunto_id;
    }

}