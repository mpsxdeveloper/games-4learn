<?php

class Questao implements JsonSerializable {

    private $id;
    private $pergunta;
    private $resposta1;
    private $resposta2;
    private $resposta3;
    private $resposta4;
    private $resposta5;
    private $gabarito;     
    private $prova_id;

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

    public function getPergunta() {
        return $this->pergunta;
    }

    public function setPergunta($pergunta) {
        $this->pergunta = $pergunta;
    }

    public function getResposta1() {
        return $this->resposta1;
    }

    public function setResposta1($resposta1) {
        $this->resposta1 = $resposta1;
    }

    public function getResposta2() {
        return $this->resposta2;
    }

    public function setResposta2($resposta2) {
        $this->resposta2 = $resposta2;
    }

    public function getResposta3() {
        return $this->resposta3;
    }

    public function setResposta3($resposta3) {
        $this->resposta3 = $resposta3;
    }

    public function getResposta4() {
        return $this->resposta4;
    }

    public function setResposta4($resposta4) {
        $this->resposta4 = $resposta4;
    }

    public function getResposta5() {
        return $this->resposta5;
    }

    public function setResposta5($resposta5) {
        $this->resposta5 = $resposta5;
    }

    public function getGabarito() {
        return $this->gabarito;
    }

    public function setGabarito($gabarito) {
        $this->gabarito = $gabarito;
    }

    public function getProva_id() {
        return $this->prova_id;
    }

    public function setProva_id($prova_id) {
        $this->prova_id = $prova_id;
    }

}