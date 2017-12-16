<?php

namespace serve\src\registro_1_0\model;

class Registro_listado_model {

    protected $Registro;
    protected $TipoUsuario;

    public function __construct() {
        $this->Registro = new Registro_model();
        $this->TipoUsuario = new Tipos_usuario_model();
    }

    public function getRegistro() {
        return $this->Registro;
    }

    public function getTipoUsuario() {
        return $this->TipoUsuario;
    }

    public function setRegistro(Registro_model $Item) {
        $this->Registro = $Item;
        return $this;
    }

    public function setTipoUsuario(Tipos_usuario_model $Item) {
        $this->TipoUsuario = $Item;
        return $this;
    }

}
